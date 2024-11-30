<?php
include 'connexion.php'; 
// Récupérer les ventes par jour
$sql = "SELECT jour, ventes FROM ventes"; // Assure-toi que 'ventes' est la table et qu'elle a les colonnes 'jour' et 'ventes'
$result=mysqli_query($con,$sql);
$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row['ventes'];
    }
}
echo json_encode($data); // Convertir en JSON pour l'envoyer à JavaScript
$con->close();
?>
