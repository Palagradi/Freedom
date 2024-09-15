<?php
include 'connexion.php'; 
if(($_POST['type'])&&($_POST['num']))
{
mysql_query("SET NAMES 'utf8' ");
	switch ($_POST['type'])
	{
		case 'fiche':  
		{
			$s=mysql_query("SELECT * FROM fiche1, compte WHERE fiche1.numfiche=compte.numfiche and fiche1.numfiche='".$_POST['num']."'");
			$ez=mysql_fetch_array($s);
			$n=(strtotime(date('Y-m-d'))-strtotime($ez['datarriv']))/86400;
			$dat=(date('H')+1); 
			settype($dat,"integer");
			if ($dat<12){$n=$n;}else {$n= $n+1;}
			if ($n==0){$n= $n+1;}
			$mt=(1+$ez['ttva'])*($n*($ez['tarif']+$ez['ttax']));
			$var1=$ez['somme'];
			echo $var1;
		}
		break; 
		case 'location':  
		{
			$s=mysql_query("SELECT * FROM location, compte1 WHERE location.numfiche=compte1.numfiche and location.numfiche='".$_POST['num']."'");
			$ez=mysql_fetch_array($s);
			$var1=$ez['somme'];
			echo $var1;
		}
		break;
		case 'reservation':  
		{
			$s=mysql_query("SELECT sum(avancerc) AS ttc FROM reserverch WHERE reserverch.numresch='".$_POST['num']."'");
			while($ez=mysql_fetch_array($s))
			{$montant=$ez['ttc'];
			}
			$s=mysql_query("SELECT sum(avancerc) AS ttc  FROM reserversal WHERE reserversal.numresch='".$_POST['num']."'");
			while($ez=mysql_fetch_array($s))
			{$montant2=$ez['ttc'];
			}
			echo $montant+$montant2;
		}
		break;
		default: echo ''; 
	}
}
?>