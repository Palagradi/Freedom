<?php
include_once('connexion.php');
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Erreur de connexion à la base de données: " . $e->getMessage()]);
    exit;
}

// Vérifier si les données ont été envoyées via la méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données
    $serveurNumber = isset($_POST['serveurNumber']) ? trim($_POST['serveurNumber']) : '';
    $tableName = isset($_POST['tableName']) ? trim($_POST['tableName']) : ''; 
	$permanent = isset($_POST['permanent']) ? trim($_POST['permanent']) : 0; 
	$current = isset($_POST['current']) ? trim($_POST['current']) : 0;
    
    // Vérification des données reçues
    if ($serveurNumber === '' || $tableName === '') {
        echo json_encode(["status" => "error", "message" => "Les champs ServeurNumber et TableName sont obligatoires."]);
        exit;
    }

    // Afficher les valeurs pour vérifier ce qui est reçu
    error_log("Valeurs reçues - Serveur: $serveurNumber, Table: $tableName");

    // Préparer et exécuter la requête d'insertion
// Préparer et exécuter la requête d'insertion
try {
    $date = new DateTime("now"); // Récupérer la date actuelle
    $tz = new DateTimeZone('Africa/Porto-Novo');
    $date->setTimezone($tz);
    $dateFormatted = $date->format("Y-m-d");  // Formater la date correctement

    // Afficher la date utilisée pour la requête
    error_log("Date actuelle utilisée pour la requête: $dateFormatted");

    // Construire la requête SQL
	if($current==1){
    $sql = "UPDATE tableencours SET serveur = ? WHERE numTable = ? AND created_at = ? AND Etat <> 'Desactive'";
	// Préparer et exécuter la requête
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$serveurNumber, $tableName, $dateFormatted]);
	}

    // Afficher la requête SQL avec les paramètres
    $formattedSql = "UPDATE tableencours SET serveur = '$serveurNumber' WHERE numTable = '$tableName' AND created_at = '$dateFormatted' AND Etat <> 'Desactive'";

    // Afficher la requête complète pour le débogage
    error_log("Requête SQL générée : $formattedSql");

    if($current==0)$rowsAffected=1; else 
    // Vérifier le nombre de lignes affectées
    $rowsAffected = $stmt->rowCount();
    error_log("Lignes affectées: $rowsAffected");

    if ($rowsAffected > 0) {
		if($permanent==1){
		$sql = "UPDATE rtables SET serveur = ? WHERE nomTable = ? AND status=0 ";	
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$serveurNumber, $tableName]);
		}
        echo json_encode(["status" => "success", "message" => "Serveur(se) affecté(e) avec succès."]);
    } else {
        echo json_encode([
            "status" => "error", 
            "message" => "Aucune ligne n'a été mise à jour. Requête exécutée : $formattedSql"
        ]);
    }
} catch (\PDOException $e) {
    echo json_encode([
        "status" => "error", 
        "message" => "Erreur lors de l'affectation: " . $e->getMessage() . ". Requête exécutée : $formattedSql"
    ]);
}

} else {
    echo json_encode(["status" => "error", "message" => "Méthode de requête non autorisée."]);
}

?>
