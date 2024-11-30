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
    $quantite = isset($_POST['quantite']) ? trim($_POST['quantite']) : '';
    $dateDebut = isset($_POST['dateDebut']) ? trim($_POST['dateDebut']) : "";
    $dateFin = isset($_POST['dateFin']) ? trim($_POST['dateFin']) : '';	
    $numero = isset($_POST['numero']) ? trim($_POST['numero']) : "";
	$portion = isset($_POST['portion']) ? trim($_POST['portion']) : "";

    // Validation des champs requis
    if (empty($quantite) || empty($dateDebut) || empty($dateFin)) {
        echo json_encode(["status" => "error", "message" => "Tous les champs sont obligatoires."]);
        exit;
    }

    // Préparer et exécuter la requête de mise à jour
    try {
		if($portion==1)
			$sql = "UPDATE portion SET Beginp = ?, NbreJPp = ?, Endp = ? WHERE id = ?";
		else 	 
			$sql = "UPDATE plat SET Begin = ?, NbreJP = ?, End = ? WHERE numero = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$dateDebut, $quantite, $dateFin, $numero]);

        echo json_encode(["status" => "success", "message" => "La quantité définie a été ajoutée pour cette période."]);
    } catch (\PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erreur lors de l'ajout de la quantité: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Méthode de requête non autorisée."]);
}
?>
