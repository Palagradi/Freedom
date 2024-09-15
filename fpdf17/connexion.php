<?php 
	$connexion=mysql_connect('localhost','root',''); 
	$db=mysql_select_db('codiam',$connexion); 
	if (!$db)
	{ print(' pas Connexion'); }
?> 