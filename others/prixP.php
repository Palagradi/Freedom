<?php
 include '../connexion.php';
if(($_POST['designation'])&&($_POST['designation']!="*")){
	mysqli_query($con,"SET NAMES 'utf8'");
	$designation=$_POST['designation']."%";
	$sql="SELECT PrixUnitaire FROM connexe WHERE idcategorie='".$_POST['categorie']."' AND NomFraisConnexe LIKE '".$designation."'";
	//$sql="SELECT PrixUnitaire FROM connexe WHERE  idcategorie='1' AND NomFraisConnexe='Thé%'";
	$s=mysqli_query($con,$sql);
	////SELECT PrixUnitaire FROM connexe WHERE  idcategorie='1' AND NomFraisConnexe='Riz au poulet'
	$ez=mysqli_fetch_assoc($s); 
	
	//echo 750;
	//echo "SELECT NomFraisConnexe AS designation,PrixUnitaire FROM connexe WHERE idcategorie='".$_POST['categorie']."' AND NomFraisConnexe LIKE '".$designation."'";
	echo trim($ez['PrixUnitaire']);
	//echo $sql;
	//echo strtoupper($ez['designation'])." | ".$ez['PrixUnitaire'];
	//echo $ez->PrixUnitaire;
	//echo "SELECT PrixUnitaire FROM connexe WHERE  idcategorie='".$_POST['categorie']."' AND NomFraisConnexe='".$_POST['designation']."'";
	//echo 750;
/* 	switch ($ez['typech'])
	{
		case 'V': echo "Ventillée"; break;
		case 'CL': echo "Climatisée"; break;
		default: echo "hhhhh"; break;
	} */
	}

?>
	