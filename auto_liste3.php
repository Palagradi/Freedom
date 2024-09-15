<?php
	require("config.php");
	
 		if(isset($_GET['getCountriesByLetters']) && isset($_GET['letters']))
		{
			$letters = $_GET['letters'];
			$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
			 mysqli_query($con,"SET NAMES 'utf8'"); 
			$res = mysqli_query($con,"SELECT NomFraisConnexe FROM connexe WHERE NomFraisConnexe like '".$letters."%' AND idcategorie like '".$_SESSION['idr']."' ") or die(mysqli_error());
			while($inf = mysqli_fetch_array($res))
			{ 
				echo $inf["NomFraisConnexe"]."###".$inf["NomFraisConnexe"]."|";
			}
		} 
/*  $etudiant = array("Larah", "Sebastian", "Kevin", "Audile", "Rodrigue");
for($i = 0;$i <= count($etudiant); $i++)
{
  echo $etudiant[$i] . "|";
}  */
	
?>
