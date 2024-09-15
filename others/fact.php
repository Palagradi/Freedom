<?php
session_start();
$nomHotel=""; $date_emission=""; $logo="logo/Sesy.png";
$initial_fiche="ss"; $avanceA=20; $Mtotal=20;
$modulo=0; $remise=0; $nom="ALI"; $prenom="ze";
$debut="";  $fin=""; $footer1=""; $footer2="";
$QRCODE_MCF=""; $NIM_MCF=""; $COMPTEUR_MCF="";
$DT_HEURE_MCF=""; $ISF="";	$SIGNATURE_MCF="";
$groupe1="";$client=""; $client="";$NumIFU= ""; $AdresseClt="";
$EmailClt=""; $TelClt=""; $defalquer_impaye="";
$TotalHT=isset($_SESSION['TotalHT'])?$_SESSION['TotalHT']:0;
$TotalTva=isset($_SESSION['TotalTva'])?$_SESSION['TotalTva']:0;
$TotalTaxe=isset($_SESSION['TotalTaxe'])?$_SESSION['TotalTaxe']:0;
$remise=!empty($_SESSION['remise'])?$_SESSION['remise']:0;
$TotalTTC=isset($_SESSION['TotalTTC'])?$_SESSION['TotalTTC']:0;
$TotalTTC+=$remise;
$devise=isset($_SESSION['devise'])?$_SESSION['devise']:NULL;
$NetPayer=(int)$TotalTTC-(int)$remise;
