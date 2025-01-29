<?php
include ('connexion.php');
// Vérifier si un plat a été sélectionné
if (isset($_GET['plat_id']))
//if(1==1)	
{
    $plat_id=$_GET['plat_id']; //$plat_id = 120;
	
/* 	$sql="SELECT ListeProduits FROM plat WHERE numero='".$plat_id."' ";
	$reqselz=mysqli_query($con,$sql);	$dataz=mysqli_fetch_assoc($reqselz); 
	$ListeProduits = explode("|", ($dataz['ListeProduits']) ?? "");
	
	$sql="";		
	for($j=0;$j<count($ListeProduits);$j++)
	{ 	$numeroPrd = explode(";", ($ListeProduits[$j]) ?? "");
		if($j==0)
			$sql= "SELECT Num AS produit_id, Designation AS produit_nom, Designation AS produit_description
            FROM produits
            WHERE  num= '".$numeroPrd[0]."'";
		else
			$sql.= " UNION (SELECT Num AS produit_id, Designation AS produit_nom, Designation AS produit_description
            FROM produits
            WHERE  num= '".$numeroPrd[0]."')";
	} */ 
	//echo $sql;							
								
 
    // Requête SQL pour récupérer les produits associés au plat
    $sql = "SELECT DISTINCT id_prd AS produit_id, Designation AS produit_nom, unite AS produit_unite,plat_produit.qte AS produit_qte
            FROM produits,plat_produit
            WHERE plat_produit.id_prd=produits.Num AND id_plat= '".$plat_id."'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        // Récupérer les produits dans un tableau associatif
        $produits = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // Retourner les produits en format JSON
        echo json_encode($produits);
    } else {
        echo json_encode([]);
    } 

} else {
    echo json_encode([]);
}

// Fermer la connexion à la base de données
mysqli_close($con);
?>
