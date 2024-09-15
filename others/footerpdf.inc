<?php
	//ob_start();
	//session_start();
	include 'connexion.php';
	$resT=mysqli_query($con,"SELECT * FROM  hotel");
	$reXt=mysqli_fetch_assoc($resT); $nomHotel=$reXt['nomHotel'];$NumUFI=$reXt['NumUFI'];$Apostale=$reXt['Apostale'];$NomLogo=$reXt['logo']; $NbreEToile=$reXt['NbreEToile'];
	$telephone1=$reXt['telephone1'];$telephone2=$reXt['telephone2'];$Email=$reXt['Email'];$NumBancaire=$reXt['NumBancaire']; $Siteweb=$reXt['Siteweb']; $RegimeTVA=$reXt['RegimeTVA'];
	$TPS_2=$reXt['TPS_2'];
		
	//$_SESSION['logo']="logo/".$NomLogo;  
	$_SESSION['nomHotel']=utf8_decode("Ets ALLELUIAH "); //$_SESSION['nomHotel']=utf8_decode($nomHotel);
	$_SESSION['footer1']=" | ".utf8_decode($Apostale)." - TEL ".$telephone1." / ".$telephone2;
	$_SESSION['footer2']="Email: ".$Email." - Compte Bancaire : ".utf8_decode($NumBancaire)." - ".utf8_decode('N° IFU :')." ".$NumUFI;$_SESSION['Jour_actuel']=$Jour_actuel;$_SESSION['Heure_actuelle']=$Heure_actuelle;