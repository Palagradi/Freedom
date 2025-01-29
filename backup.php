<?php
require("connexion.php");
// Configuration
$dbHost = $host; // Hôte de la base de données
$dbName = $db; // Nom de la base de données
$dbUser = $user; // Nom d'utilisateur de la base de données
$dbPass = $pass; // Mot de passe de la base de données
$backupDir = 'backup'; // Dossier où sauvegarder les dumps

// Créer le répertoire de sauvegarde s'il n'existe pas
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
}

$command="SET innodb_lock_wait_timeout = 120";  //-- Défini le délai à 120 secondes
exec($command, $output, $returnVar);

// Nom du fichier de sauvegarde
//$date = date('Y-m-d_H-i-s'); //$date = $previousDay.'_'.$Heure_actuelle2;
$backupFile = $backupDir . '/backup_' . $previousDay . '.sql';

// Commande mysqldump
//$command = "mysqldump --user=$dbUser --password=$dbPass --host=$dbHost $dbName > $backupFile";
$command = "mysqldump --quick --user=$dbUser --password=$dbPass --host=$dbHost $dbName | gzip > $backupFile.gz";

// Mesurer le temps d'exécution
$startTime = microtime(true); // Timestamp avant l'exécution

// Exécution de la commande
exec($command, $output, $returnVar);

$endTime = microtime(true); // Timestamp après l'exécution
$executionTime = $endTime - $startTime; // Durée d'exécution en secondes

// Afficher le temps d'exécution
//echo "Temps d'exécution du dump : " . number_format($executionTime, 2) . " secondes\n";

/* if ($returnVar !== 0) {
    echo "Erreur lors de l'exécution de la commande mysqldump.";
} else {
    echo "Sauvegarde réussie : $backupFile";
} */
 $reqsl=mysqli_query($con,"INSERT INTO backup SET backup='".$previousDay."',backupDate='".$Jour_actuel."',backupHour='".$Heure_actuelle."'");
 $result=mysqli_query($con,"UPDATE plat SET NbreJ=0,NbreC=0,Nbre=0");
 $result=mysqli_query($con,"UPDATE portion SET NbreJJp=0,NbreCp=0,Nbrep=0"); 
 $update=mysqli_query($con,"UPDATE ConfigResto SET numCde=0 ");

// Vérifier si c'est lundi pour réinitialiser les ventes
if (jourFr() == "Lundi") {
    $rek = "UPDATE ventes SET ventes = 0"; // Réinitialiser les ventes
    $query = mysqli_query($con, $rek);
    if (!$query) {
        die("Erreur lors de la réinitialisation des ventes : " . mysqli_error($con));
    } else {
        //echo "Les ventes ont été réinitialisées avec succès.";
    }
}

// Récupérer l'année de la dernière réinitialisation du compteur dans la base de données
$sql = "SELECT last_reset_year, num_fact FROM ConfigResto LIMIT 1";
$result = mysqli_query($con, $sql);
$data = mysqli_fetch_assoc($result);
// Si l'année actuelle est différente de l'année de la dernière réinitialisation
if ($data['last_reset_year'] != $currentYear) {
    // Réinitialiser le compteur des factures à 1 pour l'année en cours
    $updateQuery = "UPDATE ConfigResto SET num_fact =0, numFactNorm=0, last_reset_year = '$currentYear'";
    // Exécuter la requête pour mettre à jour la table
    $updateResult = mysqli_query($con, $updateQuery);
}
?>
