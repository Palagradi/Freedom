<?php
include 'connexion.php'; 
if($_POST['numcli']){

	$s=mysqli_query($con,"SELECT DATEDIFF(datdep,datarriv) as nuite FROM fiche1 WHERE numcli_1='".$_POST['numcli']."'");
	$ez=mysqli_fetch_array($s);
	echo $ez['nuite'];
	}
?>