<?php
include 'connexion.php';
if($_POST['numcli']){

	$s=mysqli_query($con,"SELECT date_livrais FROM client WHERE numcli='".$_POST['numcli']."'");
	$ez=mysqli_fetch_array($s);
	echo $ez['date_livrais'];
	}
?>
