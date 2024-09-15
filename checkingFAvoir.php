<?php
 			@include('config.php'); // decommenter
			@session_start(); //commenter  

/* 			$date = new DateTime("now"); // 'now' n'est pas n�c�ssaire, c'est la valeur par d�faut
			$tz = new DateTimeZone('Africa/Porto-Novo');
			$date->setTimezone($tz);
			$Heure_actuelle= $date->format("H") .":". $date->format("i").":". $date->format("s");
			$Jour_actuel= $date->format("Y") ."-". $date->format("m")."-". $date->format("d");
			//$_SESSION['Date_actuel']=isset($_SESSION['date_emission'])?$_SESSION['date_emission']:$Date_actuel; */		
				
		$reqsel=mysqli_query($con,"SELECT num_fact,numFactNorm FROM configuration_facture");
		$data=mysqli_fetch_object($reqsel);	$NumFact=NumeroFacture($data->num_fact);  
		$numFactNorm=NumeroFacture($data->numFactNorm);
		
		//echo $_SESSION['reference']; $_SESSION['id_request'];  
		
		$_SESSION['initial_fiche']=$numFactNorm;
		
		include('emecef.php');