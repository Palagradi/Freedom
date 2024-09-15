<?php 
include 'connexion.php'; 
if(($_POST['objet'])&& ($_POST['numsalle'])){
	
	$s=mysqli_query($con,"SELECT * FROM salle WHERE numsalle='".$_POST['numsalle']."'");
	$ez=mysqli_fetch_array($s);
	switch ($_POST['objet']) 
	{
		case 'reunion': echo $ez[3]; break;
		case 'fete': echo$ez[2]; break;
		default: echo 'llll'; break; 
	}
	}
	
?>