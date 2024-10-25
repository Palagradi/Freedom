<?php
		ob_start();
		session_start();
		include_once 'connexion.php';

		$date = new DateTime("now"); // 'now' n'est pas n�c�ssaire, c'est la valeur par d�faut
		$tz = new DateTimeZone('Africa/Porto-Novo');
		$date->setTimezone($tz);
		$Heure_actuelle= $date->format("H") .":". $date->format("i").":". $date->format("s");
		$Jour_actuel= $date->format("Y") ."-". $date->format("m")."-". $date->format("d");
		$previousDay= date('Y-m-d', strtotime('-1 day', strtotime($Jour_actuel)));
		$Jour_actuelp= $date->format("Y") ."-". $date->format("m")."-". $date->format("d");
		$Date_actuel= $date->format("d") ."/". $date->format("m")."/". $date->format("Y");
		$Date_actueli= $date->format("Y") ."/". $date->format("m")."/". $date->format("d");
		$Date_actuel2= $date->format("d") ."-". $date->format("m")."-". $date->format("Y");   // echo gmdate('d-m-Y');
		$Heureactuelle= $date->format("H") .":". $date->format("i");
		$Heure_actuelle2= $date->format("H") ."-". $date->format("i")."-". $date->format("s");
		$Heureh= $date->format("H") ;
		$datej=$date->format("d") ;$month=$date->format("m") ; $year=$date->format("Y") ;

		/* Fonction renvoyant l'adresse de la page actuelle  https://openclassrooms.com/forum/sujet/recuperer-l-url-en-php-24302 */
		function getURI(){
			$adresse = $_SERVER['PHP_SELF'];
			$i = 0;
			foreach($_GET as $cle => $valeur){
				$adresse .= ($i == 0 ? '?' : '&').$cle.($valeur ? '='.$valeur : '');
				$i++;
			}
			return utf8_decode($adresse);
		}
		function getURI_(){
			$adresse = $_SERVER['PHP_SELF'];
			$i = 0;
			foreach($_GET as $cle => $valeur){
				$adresse .= ($i == 0 ? '?' : '&').$cle.($valeur ? '='.$valeur : '');
				$i++;
			}
			return $adresse;
		}
		function nbJours($debut, $fin) {
        //60 secondes X 60 minutes X 24 heures dans une journée
        $nbSecondes= 60*60*24;
        $debut_ts = strtotime($debut);
        $fin_ts = strtotime($fin);
        $diff = $fin_ts - $debut_ts;
        return round($diff / $nbSecondes);
		}
		function NumeroFacture($num_fact){
			if(($num_fact>=0)&&($num_fact<=9))$num_recu="0000".$num_fact."/".substr(date('Y'),2,2);if(($num_fact>=10)&&($num_fact <=99))	$num_recu= "000".$num_fact."/".substr(date('Y'),2,2);
			if(($num_fact>=100)&&($num_fact<=999))$num_recu= "00".$num_fact."/".substr(date('Y'),2,2);if(($num_fact>=1000)&&($num_fact<=1999))$num_recu= "0".$num_fact."/".substr(date('Y'),2,2);if($num_fact>1999)$num_recu=$num_fact."/".substr(date('Y'),2,2);
			return isset($num_recu)?$num_recu:NULL;
		}
		function TexteSansAccent($texte){
		$accent='ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËéèêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ';
		$noaccent='AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn';
		$texte = strtr($texte,$accent,$noaccent);
		return $texte;
		}
		function random($car,$initial) {
		$year=(substr(date('Y'),3,1)+substr(date('Y'),2,1))-5;
		$string = $initial;
		$chaine = "0123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
		}
		return $string;
		}
		function redirect_to($url){
		 header("Location:".$url);
		}
		{unset($_SESSION['lien']);
		$ri='UPDATE utilisateur SET etatconnect=0 WHERE login="'.$_SESSION['login'].'"';
		$rit=mysqli_query($con,$ri);
		}
		if(empty($_SESSION['login'])) {
			header('Location: index.php');
		}
		else{ // si le membre est connect�
			 if(isset($_SESSION['timestamp'])){ // si $_SESSION['timestamp'] existe
					 if($_SESSION['timestamp'] + 900 > time()){ //unset($_SESSION['login']);
							$_SESSION['timestamp'] = time();
					 }else{
						$_SESSION['lien']= getURI();
						 $cx=getURI();
						 //if($cx="/SYGHOG/planning.php")
							{$re="UPDATE utilisateur SET etatconnect='".utf8_decode(getURI())."' WHERE login='".$_SESSION['login']."'";
							 $ret=mysqli_query($con,$re);
							 }
						//header("Location: index.php");
						echo '<meta http-equiv="refresh" content="900; url=index.php"/>';
					 }
			 }else{  $_SESSION['timestamp'] = time(); }
		}
		$categorie="<i>Client ordinaire</i>";
		//include 'connexion.php';  //include 'Connexion_2.php';
		mysqli_query($con,"SET NAMES 'utf8'");
		$sql="SELECT * FROM configuration_facture";
		$reqsel=mysqli_query($con,$sql);
			while($data=mysqli_fetch_array($reqsel))
				{  $num_fiche=$data['num_fiche'];   $num_fact=$data['num_fact'];  $etat_facture=$data['etat_facture'];  $initial_grpe=$data['initial_grpe'];  $initial_reserv=$data['initial_reserv'];
				   $initial_fiche=$data['initial_fiche'];    $Nbre_char=$data['Nbre_char']; $limite_jrs=$data['limite_jrs'];$num_reserv=$data['num_reserv'];  $reimprimer=$data['reimprimer'];
				   $initial_proforma=$data['initial_proforma']; $num_proForma =$data['num_proForma'];$num_client=$data['num_client']+1; $num_grpe=$data['num_grpe']+1;$numclientS=$data['numclientS']+1;
				}
		
		if(($num_fiche>=0)&&($num_fiche<=9))$Num_fiche = $initial_fiche.'0000'.$num_fiche ;	else if(($num_fiche>=10)&&($num_fiche <=99))$Num_fiche = $initial_fiche.'000'.$num_fiche ;else if(($num_fiche>=100)&&($num_fiche<=999))	$Num_fiche = $initial_fiche.'00'.$num_fiche ;else if(($num_fiche>=1000)&&($num_fiche<=1999)) $Num_fiche = $initial_fiche.'0'.$num_fiche ;else $Num_fiche = $initial_fiche.$num_fiche ;

		//$Num_fiche=$num_fiche;

		$reqsel=mysqli_query($con,"SELECT * FROM autre_configuration");
			while($data=mysqli_fetch_array($reqsel))
				{  $Mtaxe=$data['taxe'];   $etat_taxe=$data['etat_taxe'];  $limitation=$data['limitation'];  $limite_jrs=$data['limite_jrs'];  $fond=$data['fond'];
				   $logo=$data['logo'];   $sitename=$data['sitename']; $favicon=$data['favicon'];$montantAuto=$data['montantAuto'];$AppliquerTaxe=$data['AppliquerTaxe'];
				   $devise=$data['devise']; $debutNuitee=$data['debutNuitee']; $FinNuitee=$data['FinNuitee']; $signataireFordinaire=$data['signataireFordinaire'];
				   $signatairepforma=$data['signatairepforma']; $signataireLrelance=$data['signataireLrelance']; $signataireAreservation=$data['signataireAreservation'];$TypeFacture=$data['TypeFacture'];
				   $DefaultPassword=$data['DefaultPassword'];$taxe=$data['taxe'];

				}
		$reqsel=mysqli_query($con,"SELECT * FROM configuration_client");
			while($data=mysqli_fetch_array($reqsel))
				{  $Nbre_chare=$data['Nbre_chare'];
				}
		$res=mysqli_query($con,"SELECT valeurTaxe FROM taxes WHERE NomTaxe LIKE 'TVA'");
		$ret=mysqli_fetch_assoc($res); $TvaD=$ret['valeurTaxe'];
				$res=mysqli_query($con,"SELECT valeurTaxe FROM taxes WHERE NomTaxe LIKE 'AIB'");
		$ret=mysqli_fetch_assoc($res); $AIBD=$ret['valeurTaxe'];

		$title="FREEDOM";$bodyColor="peachpuff";$DefaultPassword="change"; $categorie='ordinaire';

		$resT=mysqli_query($con,"SELECT * FROM  hotel");
		$reXt=mysqli_fetch_assoc($resT); $nomHotel=$reXt['nomHotel'];$NumUFI=$reXt['NumUFI'];$Apostale=$reXt['Apostale'];$NomLogo=$reXt['logo']; $NbreEToile=$reXt['NbreEToile'];
		$telephone1=$reXt['telephone1'];$telephone2=$reXt['telephone2'];$Email=$reXt['Email'];$NumBancaire=$reXt['NumBancaire']; $Siteweb=$reXt['Siteweb']; $RegimeTVA=$reXt['RegimeTVA'];
		$TPS_2=$reXt['TPS_2'];

		$reqsel=mysqli_query($con,"SELECT * FROM categorieClient");
		$dataX=mysqli_fetch_assoc($reqsel); $NbreX=$dataX['NbreVisite'];$frequenceX=$dataX['frequence'];

		// Ces lignes de codes pour le fichier LocationMensuelle.php
		$mois=(int)(date('m'));$annee=(int)(date('Y'));$date=date('Y-m-d');
		$reqselL=mysqli_query($con,"SELECT Numero,Designation,Montant FROM Loyer");
		while($rowL=mysqli_fetch_array($reqselL))
		{ $Numero=$rowL['Numero'];$Designation=$rowL['Designation'];$Montant=$rowL['Montant'];
		 if($TvaD==0){
			 $MontantHT=$Montant;
		 }else{$Tva=$TvaD+1;
			 $MontantHT=$Montant*$Tva;
		 }
			$reqsel=mysqli_query($con,"SELECT etat FROM payement_loyer  WHERE mois_payement='$mois' AND annee_payement='$annee' AND Numero='$Numero'");
			$Trouver=mysqli_num_rows($reqsel);
			if($Trouver<=0)
				{  $ret="INSERT INTO payement_loyer VALUES('$date','$mois','$annee','$Montant','$MontantHT','$Numero','Npaye')";
				   $req=mysqli_query($con,$ret);
				}
		}
	mysqli_query($con,"SET NAMES 'utf8'");
	$reqsel=mysqli_query($con,"SELECT * FROM ConfigResto");
		while($data=mysqli_fetch_array($reqsel))
		{    $NomImpot=$data['NomImpot'];$TauxImpot=$data['TauxImpot']; $numFact=$data['num_fact']; $pvc=$data['pvc'];
		}
	$jour=date('d');$mois=date('m');
	// if(($jour=='01')&&($mois=='01')&&($num_fact>1000))           Le numero du premier recu edité en janvier doit être reinitialise à 1
	if(($mois=='01')&&($num_fact>500))
	 $res=mysqli_query($con,'update configuration_facture set num_fact=0 WHERE num_fact!=0');

 	if(($mois=='01')&&($numFact>1000))
	 $res=mysqli_query($con,'update ConfigResto set num_fact=0 WHERE num_fact!=0');

	$reqsel=mysqli_query($con,"SELECT * FROM affectationrole"); $nbre=mysqli_num_rows($reqsel);
	if($nbre<=0){
		$ret="INSERT INTO affectationrole VALUES('Administration','Administrateur')";
		$req=mysqli_query($con,$ret);
	}
	//Pour le N� du re�u
	if(($num_fact>=0)&&($num_fact<=9))  $num_recu="0000".$num_fact."/".substr(date('Y'),2,2);	else if(($num_fact>=10)&&($num_fact <=99))	 $num_recu="000".$num_fact."/".substr(date('Y'),2,2);	else if(($num_fact>=100)&&($num_fact<=999))	 $num_recu="00".$num_fact."/".substr(date('Y'),2,2);	else if(($num_fact>=1000)&&($num_fact<=1999)) $num_recu="0".$num_fact."/".substr(date('Y'),2,2);else $num_recu=$num_fact."/".substr(date('Y'),2,2);

	//Pour le N� de la r�servation
		if(($num_reserv>=0)&&($num_reserv<=9)) $numReserv=$initial_reserv.'0000'.$num_reserv ;	else if(($num_reserv>=10)&&($num_reserv<=99)) $numReserv=$initial_reserv.'000'.$num_reserv ;else if(($num_reserv>=100)&&($num_reserv<=999)) $numReserv=$initial_reserv.'00'.$num_reserv ;	else if(($num_reserv>=1000)&&($num_reserv<=1999)) $numReserv=$initial_reserv.'0'.$num_reserv ;	else $numReserv=$initial_reserv.$num_reserv;

	function convertNumero($type,$numero){ //$type=1 for Resto ; $type=2 for 
		if(($numero>=0)&&($numero<=9))  $numRecu="0000".$numero."/".substr(date('Y'),2,2);	else if(($numero>=10)&&($numero <=99))	 $numRecu="000".$numero."/".substr(date('Y'),2,2);	else if(($numero>=100)&&($numero<=999))	 $numRecu="00".$numero."/".substr(date('Y'),2,2);	else if(($numero>=1000)&&($numero<=1999)) $numRecu="0".$numero."/".substr(date('Y'),2,2);else $numRecu=$numero."/".substr(date('Y'),2,2);
		return $numRecu;	
	}
	function modePayement($modeReglement){
		if($modeReglement==1) $mode="Espèce"; 
		else if($modeReglement==2) $mode="Chèque";
		else if($modeReglement==3) $mode="Virement"; 
		else if($modeReglement==4) $mode="Carte Bancaire";
		else if($modeReglement==5) $mode="Mobile Money";	
		else if($modeReglement==6) $mode="Autre";
		return $mode;
	}
	//Pour le numero des factures du Resto
	if(($numFact>=0)&&($numFact<=9))  $numRecu="0000".$numFact."/".substr(date('Y'),2,2);	else if(($numFact>=10)&&($numFact <=99))	 $numRecu="000".$numFact."/".substr(date('Y'),2,2);	else if(($numFact>=100)&&($numFact<=999))	 $numRecu="00".$numFact."/".substr(date('Y'),2,2);	else if(($numFact>=1000)&&($numFact<=1999)) $numRecu="0".$numFact."/".substr(date('Y'),2,2);else $numRecu=$numFact."/".substr(date('Y'),2,2);

	mysqli_query($con,"SET NAMES 'utf8'");
	$ref=mysqli_query($con,"SELECT typeoccuprc AS typeoccup FROM Typeoccupation ORDER BY Nbpers ");
	$i=0; $typeoccup=array("");$Ntypeoccup=mysqli_num_rows($ref);
	while ($rerf=mysqli_fetch_array($ref))
	{  $typeoccup[$i]=$rerf['typeoccup'];$i++;
	}

	mysqli_query($con,"SET NAMES 'utf8'");
	$ref=mysqli_query($con,"SELECT DISTINCT typech FROM chambre ");
	$i=0; $typech=array("");$Ntypech=mysqli_num_rows($ref);
	while ($rerf=mysqli_fetch_array($ref))
	{   $typech[$i]=$rerf['typech'];$i++;
	}

//$mysqli_num_rowsN=0; //$DateClotureN=$Jour_actuel;
//echo 	"<br/><br/><br/><br/>";
 $queryN="SELECT DateCloture FROM  cloturecaisse WHERE utilisateur='".$_SESSION['login']."' AND state='0'";
 $reqN = mysqli_query($con,$queryN) or die (mysqli_error($con));
 $mysqli_num_rowsN=mysqli_num_rows($reqN);
 if(isset($reqN)){
	$closeN=mysqli_fetch_assoc($reqN);$DateClotureN= isset($closeN['DateCloture'])?$closeN['DateCloture']:NULL;
 }
if($mysqli_num_rowsN>0) {

	$Jour_actuelp=$DateClotureN;
	//echo $Date_actuel=substr($DateClotureN,8,2).'-'.substr($DateClotureN,5,2).'-'.substr($DateClotureN,0,4);
	}

	$query="SELECT * FROM  cloturecaisse WHERE DateCloture='".$Jour_actuelp."' AND ChiffreAffaire <>0 AND utilisateur='".$_SESSION['login']."'";
 $req1 = mysqli_query($con,$query) or die (mysqli_error($con)); $Close=mysqli_fetch_object($req1);

 $query="SELECT DISTINCT date_emission,reeditionfacture2.numfiche AS numfiche,reedition_facture.nom_client AS nom_client,reedition_facture.num_facture AS num_facture,reedition_facture.du AS du,reedition_facture.au AS au,reedition_facture.montant_ttc AS montant_ttc,reedition_facture.somme_paye AS somme_paye,reedition_facture.Remise,Arrhes,tva,taxe FROM reedition_facture,reeditionfacture2 WHERE reedition_facture.numFactNorm=reeditionfacture2.numrecu  AND date_emission='".$Jour_actuelp."'  AND receptionniste='".$_SESSION['login']."' AND state <> '1' AND somme_paye <> '0'
		UNION
		SELECT DISTINCT date_emission,reeditionfacture2.numfiche AS numfiche,reedition_facture.nom_client AS nom_client,reedition_facture.num_facture AS num_facture,reedition_facture.du AS du,reedition_facture.au AS au,reedition_facture.montant_ttc AS montant_ttc,reedition_facture.somme_paye AS somme_paye,reedition_facture.Remise,Arrhes,tva,taxe FROM reedition_facture, reeditionfacture2 WHERE reedition_facture.num_facture=reeditionfacture2.numrecu AND date_emission='".$Jour_actuelp."'  AND receptionniste='".$_SESSION['login']."' AND state <> '1' AND somme_paye <> '0'
		UNION
		SELECT DISTINCT date_emission,reeditionfacture2.numfiche AS numfiche,reedition_facture.nom_client AS nom_client,reedition_facture.num_facture AS num_facture,reedition_facture.du AS du,reedition_facture.au AS au,reedition_facture.montant_ttc AS montant_ttc,reedition_facture.somme_paye AS somme_paye,reedition_facture.Remise,Arrhes,tva,taxe FROM reedition_facture, reeditionfacture2 WHERE reedition_facture.numrecu=reeditionfacture2.numrecu AND date_emission='".$Jour_actuelp."'  AND receptionniste='".$_SESSION['login']."' AND state <> '1' AND somme_paye <> '0'";

//$_SESSION['query'] = $query;

$res=mysqli_query($con,$query);

$mt=0; 	$i=1; $cpteur=1; $Tva=0 ; $taxe=0;
while ($ret=mysqli_fetch_array($res))
 {	 $mt+=$ret['somme_paye'];
		 $Tva+= round($ret['tva']); $taxe+=$ret['taxe'];
		 //$mt=$mt+$ret['somme_paye'];
 }

 $upd=isset($_GET['upd'])?$_GET['upd']:NULL;	 $Heure=NULL;$utilisateur=NULL;

  $query="SELECT * FROM  cloturecaisse WHERE DateCloture = '".$Jour_actuelp."' AND utilisateur='".$_SESSION['login']."' ";
 $req1 = mysqli_query($con,$query) or die (mysqli_error($con));
 while($close=mysqli_fetch_array($req1)){
 	$Heure= $close['Heure']; $utilisateur= $close['utilisateur']; $state= $close['state'];
 }
 if($mysqli_num_rowsN<=0) {
	 if(mysqli_num_rows($req1)==0) {
	 	if( $mt>0){
			if(!isset($upd))
		 				{	$update="INSERT INTO cloturecaisse VALUES('".$Jour_actuelp."','".$Heure_actuelle."','".$_SESSION['login']."','".$mt."','0','0','0','0','0')";
		 					$req2 = mysqli_query($con,$update) or die (mysqli_error($con));
						}
	 	}
 	}
}

function is_connected(){ // Pour vérifier si l'utilisateur est connecté à Internet
	$connected = @fsockopen("www.google.com",80);
	if($connected){
		$is_conn = true;
		}else {
			$is_conn = false;
		}
		return $is_conn;
	}

$_SESSION['ISF'] = "eFreedom-V01"; $_SESSION['logo'] = $logo; //$_SESSION['nomHotel'] =  $nomHotel;
$icon="logo/link.png"; //$_SESSION['nomHotel'] =  $nomHotel;
if($Jour_actuel=="2021-07-16") $_SESSION['verrou']=1; else $_SESSION['verrou']=0;


$sql="SELECT * FROM module WHERE Etat='1'";
$reqsel=mysqli_query($con,$sql);
if(mysqli_num_rows($reqsel)>0){
	if(mysqli_num_rows($reqsel)==1) {
		$ret1=mysqli_fetch_assoc($reqsel);
	 	$_SESSION['module']=$ret1['Name'];
		}
}

$res=mysqli_query($con,"SELECT name FROM serveurused WHERE state =1");
$ret=mysqli_fetch_assoc($res);
if(mysqli_num_rows($res)>0)
	 $_SESSION['serveurused']=$ret['name'];
else
	 $_SESSION['serveurused']="emecef";

if($_SESSION['serveurused']=="emecef") $_SESSION['serveurname']="eFREEDOM"; else $_SESSION['serveurname']="FREEDOM";

$reduce0=0;$reduce1=0;$deloger=0; $Encaisser=0;$conversion0=0;$conversion1=0;
mysqli_query($con,"SET NAMES 'utf8'");
$reqsel=mysqli_query($con,"SELECT * FROM roleh,affectationrole WHERE roleh.nomrole=affectationrole.nomrole AND Profil='".$_SESSION['poste']."' ");
	while($data=mysqli_fetch_array($reqsel))
		{   //echo $nomRole=$data['nomRole'];
			if($data['nomRole']=='Réduction|majoration ponctuelle sur les chambres') $reduce0=1;
			if($data['nomRole']=='Réduction|majoration ponctuelle sur les salles') $reduce1=1; 	
			if($data['nomRole']=='Délogement | Changement salle') $deloger=1; 
			if($data['nomRole']=='Effectuer des encaissements') $Encaisser=1;	
			if($data['nomRole']=='Reconvertir en Hébergement groupé') $conversion0=1;
			if($data['nomRole']=='Reconvertir en Location groupée') $conversion1=1;				
		}
		
 	$_SESSION['logo']="logo/Sesy.png";
	$_SESSION['logo']="logo/gis.jpg";
	
 	$_SESSION['entreprise']="GLOBAL INGENIERIES ET SERVICES";
	$_SESSION['NumIFUEn']="1201408333100"; //Mettre ici l'IFU de l'Entreprise
	$_SESSION['RCCMEn']="RB / COT / 21 A 65961";
	$_SESSION['AdresseEn']="Cotonou";
	$_SESSION['TelEn']="97635612 / 94618989";
	$_SESSION['eMCF']="TS01000378";
	$_SESSION['devise']="F CFA";  

/* 	$_SESSION['entreprise']='HOTEL SESY';
	$_SESSION['eMCF']="EM01247074";
	$_SESSION['NumIFUEn']="1201201332301"; //Mettre ici l'IFU de l'Entreprise  
	$_SESSION['RCCMEn']="N°12-A-15698 | 07 BP 0836";
	$_SESSION['AdresseEn']=utf8_decode("Siège C/647 Qtier Saint Jean - Cotonou");
	$_SESSION['TelEn']="97027766/60100014";
	$_SESSION['devise']="F CFA";  */
	
 

?>
