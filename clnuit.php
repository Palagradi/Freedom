<?php
session_start(); 
include 'connexion.php'; 
if($_POST['taxe']){
	$s=mysql_query('SELECT count(numch) as nb FROM reserverch WHERE numresch="'. $_SESSION['numresch'].'"');
	$ez=mysql_fetch_array($s);
	echo ($ez['nb']*$_POST['taxe']);
	}
?>