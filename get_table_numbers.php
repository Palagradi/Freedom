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
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Récupérer les numéros de tables depuis la table `rtables`
$stmt = $pdo->query("SELECT id,nomTable FROM rtables WHERE status=1 AND NbreCV=0");
$tables = $stmt->fetchAll();

// Retourner les résultats au format JSON
echo json_encode($tables);

/* // Récupérer les numéros de tables depuis la table `tables`
$stmt = $pdo->query("SELECT id,nomserv FROM serveur WHERE status=0");
$tables = $stmt->fetchAll();

// Retourner les résultats au format JSON
echo json_encode($tables); */
?>
