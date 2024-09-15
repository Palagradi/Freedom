<?php
include '../connexion.php';
if($_POST['numcli']){
    mysqli_query($con,"SET NAMES 'utf8'");
	$s=mysqli_query($con,"SELECT typepiece FROM client WHERE numcli='".$_POST['numcli']."'");
	$ez=mysqli_fetch_array($s);
	if($ez['typepiece']=='cin')
	$msg= "Carte d'idendité Nationale";
	else if($ez['typepiece']=='passeport')
	$msg= "Passeport";
	else if($ez['typepiece']=='Permis')
	$msg= "Permis de Conduire";
	else if($ez['typepiece']=='cartepro')
	$msg= "Carte Professionnele";
	else //($ez['typepiece']=='cartepro1')
	$msg= "Autres";
	echo $msg;
	}
?>
