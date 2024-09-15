<?php
include '../connexion.php';
if($_POST['numcli']){
    mysqli_query($con,"SET NAMES 'utf8'");
	$s=mysqli_query($con,"SELECT lieudeliv FROM client WHERE numcli='".$_POST['numcli']."'");
	$ez=mysqli_fetch_array($s);
	echo $ez['lieudeliv'];
	}
?>
