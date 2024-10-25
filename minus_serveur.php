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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tableName = isset($_POST['tableName']) ? trim($_POST['tableName']) : '';
    //$permanent = isset($_POST['permanent']) ? (int)$_POST['permanent'] : 0;
	//$serveur = isset($_POST['serveur']) ? (int)$_POST['serveur'] : 0;

    try {
        $date = new DateTime("now", new DateTimeZone('Africa/Porto-Novo'));
        $dateFormatted = $date->format('Y-m-d');

        // Suppression du serveur associé à la table
        $sql = "UPDATE tableencours SET serveur = 0 WHERE numTable = ? AND created_at = ? AND Etat <> 'Desactive'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tableName, $dateFormatted]);
		
		$sql = "UPDATE rtables SET serveur = 0 WHERE nomTable = ? AND status =0";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tableName]);
		

        echo json_encode(["status" => "success", "message" => "Serveur(se) retiré(e) de la table avec succès."]);
    } catch (\PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erreur lors de la suppression: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Méthode de requête non autorisée."]);
}
