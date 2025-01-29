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
    $db = isset($_POST['db']) ? trim($_POST['db']) : '';
    $stock_to_add = isset($_POST['stock_to_add']) ? trim($_POST['stock_to_add']) : 0;
    $current_stock = isset($_POST['current_stock']) ? trim($_POST['current_stock']) : 0; 
	$currentStock = isset($_POST['currentStock']) ? trim($_POST['currentStock']) : 0; 
	$drinkId = isset($_POST['drinkId']) ? trim($_POST['drinkId']) : 0;
	$nbre = isset($_POST['nbre']) ? trim($_POST['nbre']) : 0;
	$checkpvc = isset($_POST['checkpvc']) ? trim($_POST['checkpvc']) : 0;
	$QteStock=$stock_to_add+$current_stock;		


    if (($stock_to_add>$currentStock)&&($db==2)) {
        echo json_encode(["status" => "error", "message" => "La quantité à affecter est supérieure au stock disponible dans le Dépôt."]);
        exit;
    } 
//if($edit==1){

    try {
/*         // Vérification si la table existe déjà
        $req = "SELECT * FROM RTables WHERE RealNameTable <> '' OR RealNameTable = ? AND status = 0";
        $stmt = $pdo->prepare($req);
        $stmt->execute([$RealNameTable]);

        // Vérifier si la table existe déjà
        if ($stmt->rowCount() > 0) {
            echo json_encode(["status" => "error", "message" => "Une table du même nom existe déjà."]);
            exit;  
        } */
		
		if($checkpvc==2) 
			$sql = "UPDATE boisson SET QteStock=? WHERE numero=? AND pc<> '0' AND Depot = ?";
		else 
			$sql = "UPDATE boisson SET QteStock=? WHERE numero=? AND pc=0 AND Depot = ?";
		
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$QteStock, $drinkId, $db]);	
		
		if($db==2) {
			if($checkpvc==2) 
				$sql = "UPDATE boisson SET QteStock=(QteStock-?) WHERE numero=? AND pc<>'0' AND Depot =1";
			else 
				$sql = "UPDATE boisson SET QteStock=(QteStock-?) WHERE numero=? AND pc='0' AND Depot =1";
		
		$stmt = $pdo->prepare($sql);
        $stmt->execute([$stock_to_add, $nbre]);
		}

        // Répondre avec un message de succès sans inclure la requête SQL
        echo json_encode(["status" => "success", "message" => "Nouvelle quantité ajoutée avec succès."]);
    } catch (\PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erreur lors de l'ajout de la table: " . $e->getMessage()]);
    }

	//}
/* 	else{  
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
        }else {
		        // Vérification si la table existe déjà
			$req = "SELECT * FROM RTables WHERE RealNameTable <> '' AND RealNameTable = ? AND status = 0";
			$stmt = $pdo->prepare($req);
			$stmt->execute([$RealNameTable]);

			// Vérifier si la table existe déjà
			if ($stmt->rowCount() > 0) {
				echo json_encode(["status" => "error", "message" => "Une table du même nom existe déjà."]);
				exit;  
			}	
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
	} */
} else {
    echo json_encode(["status" => "error", "message" => "Méthode de requête non autorisée."]);
}
?>
