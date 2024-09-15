<?php
include 'connexion.php'; 
if(($_POST['type'])&&($_POST['num']))
{
	switch ($_POST['type'])
	{
		case 'fiche':  
		{
		  
	$ladate1=substr($_POST['ladate'],6,4).'-'.substr($_POST['ladate'],3,2).'-'.substr($_POST['ladate'],0,2);
	$ladate2=substr($_POST['ladate2'],6,4).'-'.substr($_POST['ladate2'],3,2).'-'.substr($_POST['ladate2'],0,2);
	$s=mysql_query("SELECT * FROM fiche2, compte WHERE fiche2.numfiche=compte.numfiche and fiche2.datarriv between'$ladate1' AND '$ladate2' AND fiche2.datdep between '$ladate1'  AND '$ladate2' AND codegrpe LIKE ");

	$ret1=mysql_fetch_array($s);
			$n=(strtotime(date('Y-m-d'))-strtotime($ret1['datarriv']))/86400;
			$dat=(date('H')+1); 
			settype($dat,"integer");
			if ($dat<12){$n=$n;}else {$n= $n+1;}
			if ($n==0){$n= $n+1;}
			$mt=($n*$ret1['ttc'])/$ret1['nuite'];
			$var1=$ret1['somme'];							
			$var = $mt-$var1; 
			echo $var;
		}
		break; 
		case 'location':  
		{
			$s=mysql_query("SELECT montantlc FROM location WHERE numloc='".$_POST['num']."'");
			$ez=mysql_fetch_array($s);
			echo$ez['montant'];
		}
		break; 
		default: echo 'bala'; 
	}
}
?>