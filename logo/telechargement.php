<?php
	$dir ='';
	
		header('Content-Type: application/pdf');
		header('Content-Length: '.filesize($_GET['file']));
		header('Content-Disposition: attachment; filename='.$_GET['file']);
		readfile($_GET['file']);
	
?>