<?php
	require("connexion.php");
	
 		if(isset($_GET['getCountriesByLetters']) && isset($_GET['letters']))
		{
			$letters = $_GET['letters'];
			$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
			 mysqli_query($con,"SET NAMES 'utf8'"); 
			$res = mysqli_query($con,"SELECT numcli,numcliS,nomcli,prenomcli FROM client WHERE ((nomcli like '".$letters."%' OR prenomcli like '".$letters."%' AND numcli <> '') OR (nomcli like '".$letters."%' OR prenomcli like '".$letters."%' AND numcliS <> '') )   ") or die(mysqli_error());
			while($inf = mysqli_fetch_array($res))
			{   $numclt=!empty($inf["numcli"])?$inf["numcli"]:$inf["numcliS"];
				$client=$numclt."-".$inf["nomcli"]." ".$inf["prenomcli"];
				echo $client."###".$client."|";
			}
			  // echo "Client Divers" . "|";
		} 
/*  $etudiant = array("Larah", "Sebastian", "Kevin", "Audile", "Rodrigue");
for($i = 0;$i <= count($etudiant); $i++)
{
  echo $etudiant[$i] . "|";
}  
	
?>
