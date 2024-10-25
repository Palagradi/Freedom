<?php
 // Connexion à la base de données MySQL
$host = 'localhost';
$db   = 'efreedom';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Création de la connexion PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
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

// Récupérer le paramètre de recherche depuis l'URL
$query = isset($_GET['query']) ? trim($_GET['query']) : '';

// Effectuer la recherche dans la table client
if ($query !== '') {
    $stmt = $pdo->prepare("SELECT id,nomclt,prenomclt,numIFU,adresseclt,Telclt,entrepriseName FROM clientresto WHERE nomclt LIKE ? OR prenomclt LIKE ? OR entrepriseName LIKE ? LIMIT 10");
    $stmt->execute(["%$query%", "%$query%", "%$query%"]);
    $clients = $stmt->fetchAll();

    // Retourner les résultats au format JSON
    echo json_encode($clients);
} 

/* include_once 'connexion.php';

// Récupérer le paramètre de recherche depuis l'URL
$query = isset($_GET['query']) ? trim($_GET['query']) : '';

// Effectuer la recherche dans la table client
if ($query !== '') {
	//$result=mysqli_query($con,"SELECT id,nomclt,prenomclt,numIFU,adresseclt,Telclt FROM clientresto WHERE nomclt LIKE ? OR prenomclt LIKE ? LIMIT 10");
    $stmt = $pdo->prepare($con,"SELECT nom, prenom, telephone, ifu FROM clients WHERE nom LIKE ? OR prenom LIKE ? LIMIT 10");
    $stmt->execute(["%$query%", "%$query%"]);
    $clients = $stmt->fetchAll();

    // Retourner les résultats au format JSON
    echo json_encode($clients);
} */
?>
