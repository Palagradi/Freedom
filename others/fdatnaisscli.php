<?php
include '../connexion.php';
if($_POST['numcli']){

	$s=mysqli_query($con,"SELECT datnaiss FROM client WHERE numcli='".$_POST['numcli']."'");
	$ez=mysqli_fetch_array($s);
	echo $ez['datnaiss'];
	}
?>
