<?php
// (c) Xavier Nicolay
// Exemple de génération de Facture/facture PDF

require('invoice.php');  include 'connexion.php';  include 'chiffre_to_lettre.php';  //$_GET['num_facture']='298/20';

	$devise=isset($_GET['devise'])?$_GET['devise']:"Francs CFA"; if($devise=="F CFA") $devise="Francs CFA";
	$resT=mysqli_query($con,"SELECT * FROM  hotel");
	$reXt=mysqli_fetch_assoc($resT); $nomHotel=$reXt['nomHotel'];$NumUFI=$reXt['NumUFI'];$Apostale=$reXt['Apostale'];$NomLogo=$reXt['logo']; $NbreEToile=$reXt['NbreEToile'];
	$telephone=$reXt['telephone1'];$telephone2=$reXt['telephone2'];$Email=$reXt['Email'];$NumBancaire=$reXt['NumBancaire']; $Siteweb=$reXt['Siteweb'];
	if(isset($telephone2)) $telephone=$telephone.'/ '.$telephone2; $numFact=isset($_GET['num_facture'])?$_GET['num_facture']:"0001/".date('Y');

if(isset($_GET['num_facture'])|| isset($num_facture))         // Condition pour rééditer une facture
	{ 	$numFacture=isset($_GET['num_facture'])?$_GET['num_facture']:$num_facture;
		$ref=mysqli_query($con,"SELECT DISTINCT Nums,Client,date_emission,Echeance,ModePayement,Signature FROM factureeconomat WHERE  num_facture ='".$numFacture."' ");
		$reXt=mysqli_fetch_object($ref);$Nums=$reXt->Nums ;$Client=$reXt->Client;$date=substr($reXt->date_emission,8,2).'/'.substr($reXt->date_emission,5,2).'/'.substr($reXt->date_emission,0,4); $dateE=$reXt->Echeance;$mode=$reXt->ModePayement;$signature=$reXt->Signature;
		mysqli_query($con,"SET NAMES 'utf8'");
		$sql = "SELECT DISTINCT produits.Designation AS LigneCde,Num2,produitsencours.qte AS qte,prix FROM produitsencours,factureeconomat,produits WHERE produitsencours.LigneCde=produits.Num AND factureeconomat.Client = produitsencours.Client  AND produitsencours.Client='".$Client."' AND produitsencours.Num in (".$Nums.") ";
		$sql .= " UNION SELECT LigneCde,produitsencours.Num AS Num2,produitsencours.qte AS qte,prix FROM produitsencours,factureeconomat WHERE factureeconomat.Client = produitsencours.Client  AND produitsencours.Client='".$Client."' AND produitsencours.Num in (".$Nums.") AND Type='0' "; // Pour les lignes de Prestation de Services
	}
else{
		$resT=mysqli_query($con,"SELECT Client FROM  produitsencours WHERE Num IN (SELECT MAX(Num) FROM  produitsencours)");
		$reXt=mysqli_fetch_assoc($resT); $clt=$reXt['Client'];
		$Client=isset($_GET['clt'])?$_GET['clt']:$clt; if(isset($_GET['date'])) $date=$_GET['date']; else $date=date('d-m-Y');
		if(isset($_GET['echeance'])) $dateE=$_GET['echeance']; else $dateE=date('d-m-Y'); 
		$mode=isset($_GET['mode'])?utf8_decode($_GET['mode']):utf8_decode(" Espèce");
		
		$sql= 'SELECT DISTINCT MAX(Nums) AS Nums FROM produitsencours,factureeconomat WHERE factureeconomat.Client = produitsencours.Client  AND produitsencours.Client="'.$Client.'" ';
		$res = mysqli_query($con,$sql)  or die ('Erreur SQL : ' .$sql .mysqli_connect_error() );
		$data=mysqli_fetch_object($res); $Nums=$data->Nums ; 
		mysqli_query($con,"SET NAMES 'utf8'");
		$sql = "SELECT produits.Designation AS LigneCde,Num2,produitsencours.qte AS qte,prix FROM produitsencours,factureeconomat,produits WHERE produitsencours.LigneCde=produits.Num AND factureeconomat.Client = produitsencours.Client  AND produitsencours.Client='".$Client."' AND produitsencours.Num in (".$Nums.") ";
		$sql .= " UNION SELECT LigneCde,produitsencours.Num AS Num2,produitsencours.qte AS qte,prix FROM produitsencours,factureeconomat WHERE factureeconomat.Client = produitsencours.Client  AND produitsencours.Client='".$Client."' AND produitsencours.Num in (".$Nums.") AND Type='0' ";  // Pour les lignes de Prestation de Services
	
		$sqlk= 'SELECT DISTINCT num_facture AS num_facture FROM produitsencours,factureeconomat WHERE factureeconomat.Client = produitsencours.Client  AND produitsencours.Client="'.$Client.'" ';
		$res = mysqli_query($con,$sqlk)  or die ('Erreur SQL : ' .$sqlk .mysqli_connect_error() );
		$datak=mysqli_fetch_object($res); $numFacture=$datak->num_facture ; 
	
	}
	$resT=mysqli_query($con,"SELECT * FROM  clients WHERE Num='".$Client."'");$reXt=mysqli_fetch_object($resT); 
	if(mysqli_num_rows($resT)>0){$Clt="CL0".$Client;
		$NomClt=$reXt->NomClt;$AdresseClt=$reXt->AdresseClt;$TelClt=$reXt->TelClt;$EmailClt=$reXt->EmailClt;
	}else {
		$NomClt="Client anonyme";$AdresseClt="Adresse : ";$TelClt="Tel : ";$EmailClt="Email : ";
		$Clt="#CL".substr($Client,8)."#";
	}
	$res=mysqli_query($con,"SELECT valeurTaxe FROM taxes WHERE NomTaxe LIKE 'TVA'");
	$ret=mysqli_fetch_assoc($res); $TvaD=$ret['valeurTaxe'];
	
$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();
$pdf->addSociete( $nomHotel,
				            $Apostale."\n" .
                  "Tel : ".$telephone."\n" .
				  "Email : ".$Email."\n" .
				  "N° IFU: ".$NumUFI."\n" .
				 "N° de compte : ".$NumBancaire);
$pdf->fact_dev( "Facture ", $numFacture );
$pdf->temporaire( $nomHotel );
$pdf->addDate( $date);
$pdf->addClient($Clt);
$pdf->addPageNumber("1");
$pdf->addClientAdresse("Ste\n".$NomClt."\n".$AdresseClt."\n".$TelClt."\n".$EmailClt);
$pdf->addReglement($mode);
//$pdf->addReglement("Chèque à réception de facture");
$pdf->addEcheance($dateE);
$pdf->addNumTVA("Achat de Biens et Services ");
$pdf->addReference("Facture ... du ....");
$cols=array( " REFERENCE "    => 23,
             "DESIGNATION"  => 89,
             "QUANTITE"     => 22,
             "P.U. HT"      => 26,
             "MONTANT TTC" => 30);
$pdf->addCols( $cols);
//$pdf->lineVert( $cols);
//$pdf->addLineFormat($cols);

$y    = 109;

        $res = mysqli_query($con, $sql)  or die ('Erreur SQL : ' .$sql .mysqli_connect_error() );$val=0;
        while ($data =  mysqli_fetch_array($res))
        {  $montant=$data['qte']*$data['prix']; $val+=$montant; $Num2=$data['Num2']; $prixHT=(1-$TvaD)*$data['prix'];
			if(($Num2>=0)&&($Num2<=9))$Num2='REF000'.$Num2 ;else if(($Num2>=10)&&($Num2<=99))$Num2='REF00'.$Num2 ;else if(($Num2>=100)&&($Num2<=999)) $Num2='REF0'.$Num2 ;else $Num2='REF'.$Num2;
			   $line = array( " REFERENCE "    => "   ".$Num2,
               "DESIGNATION"  => utf8_decode($data['LigneCde']),
               "QUANTITE"     => "        ".$data['qte'],
               "P.U. HT"      => "        ".$prixHT,
               "MONTANT TTC" => "      ".$montant);
		$size = $pdf->addLine( $y, $line );
		$y   += $size + 5;

		}

$pdf->addCadreTVAs();
        
$tot_prods = array( array ( "px_unit" => 600, "qte" => 1, "tva" => 1 ),
                    array ( "px_unit" =>  10, "qte" => 1, "tva" => 1 ));
$tab_tva = array( "1"       => 19.6,
                  "2"       => 5.5);
$params1  = "Arrêté la présente facture à la somme de :";
$params2=chiffre_en_lettre($val, $devise1=$devise);
$pdf->addTVAs( $params1,$params2, $tab_tva, $tot_prods);  // les données des tableaux
$pdf->addCadreEurosFrancs('logo\signature.png','AKPOVO Jean de Dieu');  //Tableau 2
//$pdf->Image('logo\signature.png',145,275,60,20);

if(!isset($num_facture))

	$pdf->Output('Facture','I');

  
?>
