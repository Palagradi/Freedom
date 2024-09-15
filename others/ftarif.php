<?php
include '../connexion.php';

if(($_POST['objet'])&& ($_POST['numch'])){
	$s=mysqli_query($con,"SELECT * FROM chambre WHERE EtatChambre='active' AND numch='".$_POST['numch']."'");
	$ez=mysqli_fetch_array($s);

	switch ($_POST['objet'])
	{
		case 'individuelle':echo $ez['tarifsimple']; break;
		case 'double': echo $ez['tarifdouble']; break;
		default: echo 'llll'; break;
	}
	}

?>
