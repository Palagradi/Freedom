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
    $rsociale = isset($_POST['rsociale']) ? trim($_POST['rsociale']) : '';
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $prenoms = isset($_POST['prenoms']) ? trim($_POST['prenoms']) : '';
    $adresse = isset($_POST['adresse']) ? trim($_POST['adresse']) : '';
    $telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : '';
    $ifu = isset($_POST['ifu']) ? trim($_POST['ifu']) : '';

    // Ajoutez ce message pour vérifier que les données sont bien envoyées
    if ($rsociale === "" && $nom === "") {
        echo json_encode(["status" => "error", "message" => "L'un des champs Entreprise ou Nom doit être renseigné."]);
        exit;
    }

    if ($rsociale !== "" && $ifu === "") {
        echo json_encode(["status" => "error", "message" => "Pour une entreprise, le champ IFU est requis."]);
        exit;
    }

    // Préparer et exécuter la requête d'insertion
    try {
		 	if(!empty($nom)){
				//$req="SELECT * FROM clientresto WHERE (nomclt='".$nom."' AND prenomclt='".$prenoms."')";
				$req="SELECT * FROM clientresto WHERE (nomclt= ? AND prenomclt= ?)";
				$stmt = $pdo->prepare($req);
				$stmt->execute([$nom, $prenoms]);				
			}
		   else {
			    //$req="SELECT * FROM clientresto WHERE entrepriseName='".$rsociale."' OR numIFU='".$ifu."'";
				$req="SELECT * FROM clientresto WHERE entrepriseName= ? OR numIFU= ?";
				$stmt = $pdo->prepare($req);
				$stmt->execute([$rsociale, $ifu]);
			}				
		  // Vérifier si le client existe déjà
			if ($stmt->rowCount() > 0) {
				echo json_encode(["status" => "error", "message" => "Ce client existe déjà."]);
				exit;  // Arrêter l'exécution ici si le client existe déjà
			} 			
				
        $sql = "INSERT INTO clientresto (entrepriseName,nomclt, prenomclt, numIFU, adresseclt, Telclt) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$rsociale,$nom, $prenoms, $ifu, $adresse, $telephone]);

        // Répondre avec un message de succès
        echo json_encode(["status" => "success", "message" => "Client ajouté avec succès."]);
    } catch (\PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erreur lors de l'ajout du client: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Méthode de requête non autorisée."]);
}
?>
