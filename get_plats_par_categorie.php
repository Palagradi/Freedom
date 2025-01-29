<?php
include('connexion.php');

if (isset($_GET['categorie_id'])) {
    $categorie_id = $_GET['categorie_id'];

    // Sélectionner les plats en fonction de la catégorie
	$sql = "SELECT * FROM plat WHERE categPlat = '".$categorie_id."' ORDER BY numero DESC";
	$result = mysqli_query($con, $sql);	
	    if ($result) {
        // Récupérer les plats dans un tableau associatif
        $plats = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // Retourner les plats en format JSON
        echo json_encode($plats);
		} else {
			echo json_encode([]);
		} 
	} else {
		echo json_encode([]);
	}
?>
