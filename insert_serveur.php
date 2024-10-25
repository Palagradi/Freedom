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
    $surname = isset($_POST['surname']) ? trim($_POST['surname']) : '';
    $nameServ = isset($_POST['nameServ']) ? trim($_POST['nameServ']) : '';
    $adresse = isset($_POST['adresse']) ? trim($_POST['adresse']) : '';
    $phoneNumber = isset($_POST['phoneNumber']) ? trim($_POST['phoneNumber']) : '';

    if (empty($surname) || empty($nameServ) || empty($phoneNumber)) {
        echo json_encode(["status" => "error", "message" => "Les champs Nom, prénoms et téléphone sont obligatoires."]);
        exit;
    }

    try {
        $req = "SELECT * FROM serveur WHERE (nomserv= ? AND prenoms= ?)";
        $stmt = $pdo->prepare($req);
        $stmt->execute([$surname, $nameServ]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(["status" => "error", "message" => "Ce(tte) serveur(se) existe déjà."]);
            exit;
        }

        $sql = "INSERT INTO serveur (nomserv, prenoms, adresse, Telephone, status) VALUES (?, ?, ?, ?, 0)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$surname, $nameServ, $adresse, $phoneNumber]);

        echo json_encode(["status" => "success", "message" => "Serveur(se) ajouté(e) avec succès."]);
    } catch (\PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erreur lors de l'ajout de serveur(se) : " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Méthode de requête non autorisée."]);
}
?>
