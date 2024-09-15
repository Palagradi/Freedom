<?php
include '../connexion.php';
if($_POST['numch']){
	mysqli_query($con,"SET NAMES 'utf8'");
	$s=mysqli_query($con,"SELECT DesignationType FROM chambre WHERE EtatChambre='active' AND numch='".$_POST['numch']."'");
	$ez=mysqli_fetch_array($s);
	echo trim($ez['DesignationType']);
/* 	switch ($ez['typech'])
	{
		case 'V': echo "Ventillée"; break;
		case 'CL': echo "Climatisée"; break;
		default: echo "hhhhh"; break;
	} */
	}
?>
