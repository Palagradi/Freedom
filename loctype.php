<?php

include 'connexion.php'; 
if($_POST['numsalle']){
    mysqli_query($con,"SET NAMES 'utf8'");
	$s=mysqli_query($con,"SELECT codesalle FROM salle WHERE numsalle='".$_POST['numsalle']."'");
	$ez=mysqli_fetch_array($s);
	
	echo $ez['codesalle'];
	
	}
?>
