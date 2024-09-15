<?php
require("config.php");
if($_POST['numPdt']){
	$s=mysqli_query($con,"SELECT Qte_Stock,PrixV,Seuil FROM produits WHERE Num='".$_POST['numPdt']."'");
	$ez=mysqli_fetch_array($s);
    //echo $ez['Qte_Stock'];
	
	echo "||".$ez["Qte_Stock"]."||".$ez["PrixV"]."||".$ez["Seuil"];
/* 	switch ($_POST['numPdt'])
	{
		case 'individuelle':echo $ez['tarifsimple']; break;
		case 'double': echo $ez['tarifdouble']; break;
		default: echo 'llll'; break;
	} */
	}

?>
