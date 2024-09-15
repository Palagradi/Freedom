<?php
include 'connexion.php'; 
if(($_POST['type'])&&($_POST['num']))
{
	switch ($_POST['type'])
	{
		case 'fiche':  
		{mysql_query("SET NAMES 'utf8' ");
			$s=mysql_query("SELECT * FROM fiche1, compte WHERE fiche1.numfiche=compte.numfiche and fiche1.numfiche='".trim($_POST['num'])."' AND fiche1.etatsortie='NON'");
			$ret1=mysql_fetch_array($s);
					$n=(strtotime(date('Y-m-d'))-strtotime($ret1['datarriv']))/86400;
					$dat=(date('H')+1); 
					settype($dat,"integer");
					if ($dat<13){$n=$n;}else {$n= $n+1;}
					if ($n==0){$n= $n+1;}
					//Attention plus d'incrémentation ici 
					//$mt=$ret1['ttc']/$ret1['nuite'];
					$n=(int)$n;
					$mt=$ret1['ttc_fixe']*$n; 
					$var1=$ret1['somme'];											
				    $var = $mt-$var1; 
				    echo $var;
		}
		break; 
		case 'location':  
		{
					$s=mysql_query("SELECT * FROM location, compte1 WHERE location.numfiche=compte1.numfiche and location.numfiche='".trim($_POST['num'])."'");
					$ret1=mysql_fetch_array($s);
					$n=(strtotime(date('Y-m-d'))-strtotime($ret1['datarriv']))/86400;
					$dat=(date('H')+1); 
					settype($dat,"integer");
					if ($dat<13){$n=$n;}else {$n= $n+1;}
					if ($n==0){$n= $n+1;}
					//Attention plus d'incrémentation ici 
					$mt=$ret1['ttc']/$ret1['nuite'];
					$var1=$ret1['somme'];											
				    $var = $mt-$var1; 
				    echo $var;
		}
		break; 
		case 'reservation':  
		{   $s=mysql_query("SELECT  nuiterc AS  nuiterc FROM reservationch WHERE reservationch.numresch='".$_POST['num']."'");
			while($ez=mysql_fetch_array($s))
			{$nuiterc=$ez['nuiterc'];
			}			
			$s2=mysql_query("SELECT sum(ttc) AS ttc FROM reserverch WHERE reserverch.numresch='".$_POST['num']."'");
			while($ez2=mysql_fetch_array($s2))
			{$montant=$ez2['ttc']*$nuiterc;
			}
			$s3=mysql_query("SELECT sum(avancerc) AS avancerc  FROM reserverch WHERE reserverch.numresch='".$_POST['num']."'");
			while($ez3=mysql_fetch_array($s3))
			{$avancerc=$ez3['avancerc'];
			}
			$s=mysql_query("SELECT  nuiterc AS  nuiterc FROM reservationsal WHERE numresch='".$_POST['num']."'");
			while($ez=mysql_fetch_array($s))
			{$nuiterc=$ez['nuiterc'];
			}
			$s=mysql_query("SELECT  numfiche  FROM exonerer_tva WHERE numfiche='".$_POST['num']."'");
			while($ez=mysql_fetch_array($s))
			{$numfiche=$ez['numfiche'];
			}
			$nuiterc=1;
			$s=mysql_query("SELECT sum(mtrc) AS mtrc  FROM reserversal WHERE numresch='".$_POST['num']."'");
			while($ez=mysql_fetch_array($s))
			{	if(empty($numfiche))
					$montant2=(int)(0.1+$ez['mtrc']*$nuiterc);
				else
					$montant2=$ez['mtrc']*$nuiterc;
			}
			$s=mysql_query("SELECT sum(avancerc) AS avancerc  FROM reserversal WHERE numresch='".$_POST['num']."'");
			while($ez=mysql_fetch_array($s))
			{$avancerc2=$ez['avancerc'];
			}
			echo $montant+$montant2-$avancerc-$avancerc2;
		}
		break;
		default: echo ''; 
	}
}
?>