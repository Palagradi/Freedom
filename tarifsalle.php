<?php
include 'connexion.php'; 
if(isset($_POST['code'])&& isset($_POST['tarif']))
{
	switch ($_POST['tarif'])
	{
		case 'tariffete':  
		{mysqli_query($con,"SET NAMES 'utf8' ");
			$s=mysqli_query($con,"SELECT tariffete FROM salle WHERE typesalle='".$_POST['code']."'");
			$ret1=mysqli_fetch_array($s);
					$tarif=$ret1['tariffete'];
				    echo $tarif;
		}
		break; 
		case 'tarifreunion':  
		{
			$s=mysqli_query($con,"SELECT tarifreunion FROM salle WHERE typesalle='".$_POST['code']."'");
			$ret1=mysqli_fetch_array($s);
				$tarif=$ret1['tarifreunion'];
				echo $tarif;
		}
		break; 
		default: echo '0'; 
	}
}
?>