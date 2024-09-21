<?php
// Configuration
$dbHost = 'localhost'; // Hôte de la base de données
$dbName = 'efreedom'; // Nom de la base de données
$dbUser = 'root'; // Nom d'utilisateur de la base de données
$dbPass = ''; // Mot de passe de la base de données
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
?>
