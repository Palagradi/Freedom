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
    $id = isset($_POST['tableNumber']) ? trim($_POST['tableNumber']) : '';
    $NbreCV = isset($_POST['covers']) ? trim($_POST['covers']) : 1;
    $RealNameTable = isset($_POST['tableName']) ? trim($_POST['tableName']) : ''; 
	$edit = isset($_POST['edit']) ? trim($_POST['edit']) : 0;
	$table = isset($_POST['table']) ? trim($_POST['table']) : 0;
	$status=0;

    // Validation des champs requis
    if ((empty($id) || empty($NbreCV))&& ($edit===0)) {
        echo json_encode(["status" => "error", "message" => "Les champs Nom de la table et Nbre de couverts sont obligatoires."]);
        exit;
    }
	if($edit==1){ 
	 //Modifications des informations sur la table
        $sql = "UPDATE RTables SET RealNameTable = ?, NbreCV = ? WHERE nomTable = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$RealNameTable, $NbreCV, $table]);	
        // Répondre avec un message de succès
        echo json_encode(["status" => "success", "message" => "Modification effectuée avec succès."]);	
	}
	else{  
// Préparer et exécuter la requête d'insertion
    try {
        // Vérification si la table existe déjà
        $req = "SELECT * FROM RTables WHERE nomTable = ? AND status = 0 AND NbreCV=0";
        $stmt = $pdo->prepare($req);
        $stmt->execute([$id]);

        // Vérifier si la table existe déjà
        if ($stmt->rowCount() > 0) {
            echo json_encode(["status" => "error", "message" => "Cette table existe déjà."]);
            exit;  
        }

        // Préparer la requête d'insertion
        $sql = "UPDATE RTables SET RealNameTable = ?, NbreCV = ?, status = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$RealNameTable,$NbreCV,$status,$id]);

        // Répondre avec un message de succès sans inclure la requête SQL
        echo json_encode(["status" => "success", "message" => "Table ajoutée avec succès."]);
    } catch (\PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erreur lors de l'ajout de la table: " . $e->getMessage()]);
    }
	}
} else {
    echo json_encode(["status" => "error", "message" => "Méthode de requête non autorisée."]);
}
?>
