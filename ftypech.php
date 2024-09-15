<?php
include 'connexion.php';
if($_POST['numch']){
	mysqli_query($con,"SET NAMES 'utf8'");
	$s=mysqli_query($con,"SELECT DesignationType,RegimeTVA FROM chambre WHERE EtatChambre='active' AND numch='".$_POST['numch']."'");
	$ez=mysqli_fetch_array($s);
	echo strtoupper($ez['DesignationType'])." | ".$ez['RegimeTVA'];
/* 	switch ($ez['typech'])
	{
		case 'V': echo "Ventillée"; break;
		case 'CL': echo "Climatisée"; break;
		default: echo "hhhhh"; break;
	} */
	}
?>
