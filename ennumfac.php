<?php
include 'connexion.php'; 
if(($_POST['num']))
{
/* 	$s=mysql_query("SELECT mtfact FROM facture WHERE mtfact='".$_POST['num']."'");
	$ez=mysql_fetch_array($s);
	echo$ez['mtfact']; */
		$s=mysql_query("SELECT * FROM fiche1, compte WHERE fiche1.numfiche=compte.numfiche and fiche1.numfiche='".$_POST['num']."'");
		$ez=mysql_fetch_array($s);
		$n=(strtotime(date('Y-m-d'))-strtotime($ez['datarriv']))/86400;
		$dat=(date('H')+1); 
		settype($dat,"integer");
		if ($dat<12){$n=$n;}else {$n= $n+1;}
		if ($n==0){$n= $n+1;}
		$mt=(int)($n*$ret1['somme1']);
		//$mt=$ez['due'];
		$var1=$ez['somme'];
		$var = $mt-$var1; 
		echo $var;
}
?>