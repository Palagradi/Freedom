<?php
  //require_once('vendor/emecef/vendor/autoload.php');
  require_once('emecef/vendor/autoload.php');
  
// Configure API key authorization: Bearer
	//Test
   $config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IjEyMDE0MDgzMzMxMDB8VFMwMTAwMDM3OCIsInJvbGUiOiJUYXhwYXllciIsIm5iZiI6MTcxNzA3NjUyNSwiZXhwIjoxNzQzMjg5MjAwLCJpYXQiOjE3MTcwNzY1MjUsImlzcyI6ImltcG90cy5iaiIsImF1ZCI6ImltcG90cy5iaiJ9.G-xxSGlwH3JMNARUkU3weJ4jPEa6r024-pT6Xz92Q8c');
  
   //Production  = SESY
   //$config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization','Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IjEyMDEyMDEzMzIzMDF8RU0wMTI0NzA3NCIsInJvbGUiOiJUYXhwYXllciIsIm5iZiI6MTY2OTI4MTY4NSwiZXhwIjoxNzMyNDAyODAwLCJpYXQiOjE2NjkyODE2ODUsImlzcyI6ImltcG90cy5iaiIsImF1ZCI6ImltcG90cy5iaiJ9.UaqSd0Id12ScyQwhvQUMoFf7ifWIBAljT7L7Aysn3cg');


//print_r($config);
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$apiInvoiceInstance = new Swagger\Client\Api\SfeInvoiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(array('verify'=> false)),
    $config
	);

$apiInfoInstance = new Swagger\Client\Api\SfeInfoApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(array('verify'=> false)),
    $config
	);

//INFO
try {
    $infoResponseDto = $apiInfoInstance->apiInfoStatusGet();
    print_r($infoResponseDto);
} catch (Exception $e) {
    echo 'Exception when calling SfeInvoiceApi->apiInvoiceGet: ', $e->getMessage(), PHP_EOL;
    echo 'Demande non authorisée. Réessayez plus tard ...', PHP_EOL;
    //echo 1255;
}

try {
    $invoiceTypesDto = $apiInfoInstance->apiInfoInvoiceTypesGet();
    //print_r($invoiceTypesDto);
} catch (Exception $e) {
    //echo 'Exception when calling SfeInvoiceApi->apiInvoiceGet: ', $e->getMessage(), PHP_EOL;
    //echo 'Demande non authorisée. Réessayez plus tard ...';
}

try {
    $taxGroupsDto = $apiInfoInstance->apiInfoTaxGroupsGet();
    //print_r($taxGroupsDto);
} catch (Exception $e) {
    //echo 'Exception when calling SfeInvoiceApi->apiInvoiceGet: ', $e->getMessage(), PHP_EOL;
	}

try {
    $paymentTypesDto = $apiInfoInstance->apiInfoPaymentTypesGet();
    //print_r($paymentTypesDto);
} catch (Exception $e) {
    //echo 'Exception when calling SfeInvoiceApi->apiInvoiceGet: ', $e->getMessage(), PHP_EOL;
}

//INVOICE
try {
    $statusReponseDto = $apiInvoiceInstance->apiInvoiceGet();
    //print_r($statusReponseDto);
} catch (Exception $e) {
    //echo 'Exception when calling SfeInvoiceApi->apiInvoiceGet: ', $e->getMessage(), PHP_EOL;
	}


$body = new \Swagger\Client\Model\InvoiceRequestDataDto(); // \Swagger\Client\Model\InvoiceRequestDataDto |
$body->setIfu($_SESSION['NumIFUEn']);//YOUR IFU HERE

$ClientDto = new \Swagger\Client\Model\ClientDto();
if(isset($_SESSION['NumIFU'])&&($_SESSION['NumIFU']!=0))
$ClientDto->setIfu($_SESSION['NumIFU']);
$ClientDto->setName($_SESSION['client']);

/* if(isset($_SESSION['TelClt'])&&(!empty($_SESSION['TelClt'])))
$ClientDto->setcontact($_SESSION['TelClt']);
if(isset($_SESSION['AdresseClt'])&&(!empty($_SESSION['AdresseClt'])))
$ClientDto->setaddress($_SESSION['AdresseClt']); */

$body->setclient($ClientDto);

$operatorDto = new \Swagger\Client\Model\OperatorDto();
$operatorDto->setid($_SESSION['userId']);
$operatorDto->setName($_SESSION['vendeur']);
$body->setOperator($operatorDto);

if(isset($_SESSION['reference']))
	{$body->setType(Swagger\Client\Model\InvoiceTypeEnum::FA);
	 $body->setreference($_SESSION['reference']);
	}
else
	{
		$body->setType(Swagger\Client\Model\InvoiceTypeEnum::FV);
	}
		$PaymentDto = new \Swagger\Client\Model\PaymentDto();

		if($_SESSION['PaymentDto']=="ESPECE") $PaymentDtoi="ESPECES";  if($_SESSION['PaymentDto']=="CHEQUE") $PaymentDtoi="CHEQUES"; else $PaymentDtoi=$_SESSION['PaymentDto'];

		$PaymentDto->setName($PaymentDtoi);

		if(isset($_SESSION['TotalTTC']))
			$PaymentDto->setamount($_SESSION['TotalTTC']);

//echo var_dump($PaymentDto);

//$body->setAib(Swagger\Client\Model\AibGroupTypeEnum::A); //B pour aib=5% A pour aib=1%;
//$body->setType(Swagger\Client\Model\InvoiceTypeEnum::FA);
//$body->setreference("TESTGEQSDOGQMWP746FTMPFW");  //Pour la facture d'avoir

$items = array();

$sql = 'SELECT * FROM produitsencours WHERE  Etat = 4 ORDER BY GrpeTaxation ASC, Num ASC';
mysqli_query($con,"SET NAMES 'utf8' ");
$query = mysqli_query($con, $sql);
while($data=mysqli_fetch_array($query)){
	$item1 = new \Swagger\Client\Model\ItemDto();
	$item1->setName($data['LigneCde']);
	$item1->setPrice($data['prix']);
	$item1->setQuantity($data['qte']);

  if($data['taxSpecific']>0)
  $item1->setTaxSpecific($data['taxSpecific']);

	if($data['GrpeTaxation']=="A")
	$item1->setTaxGroup(Swagger\Client\Model\TaxGroupTypeEnum::A);
	else if($data['GrpeTaxation']=="B")
	$item1->setTaxGroup(Swagger\Client\Model\TaxGroupTypeEnum::B);
	else if($data['GrpeTaxation']=="F")
	$item1->setTaxGroup(Swagger\Client\Model\TaxGroupTypeEnum::F);
	else
	$item1->setTaxGroup(Swagger\Client\Model\TaxGroupTypeEnum::E);


  //$item1->setTaxGroup(Swagger\Client\Model\taxSpecific::A);
  //else if($data['GrpeTaxation']=="B")

	array_push($items, $item1);
}

$body->setItems($items);

//}

try {
    $invoiceResponseDto = $apiInvoiceInstance->apiInvoicePost($body);
    //print_r($invoiceResponseDto);
} catch (Exception $e) {
    //echo 'Exception when calling SfeInvoiceApi->apiInvoicePost: ', $e->getMessage(), PHP_EOL;
	}

$rallback=0;

$uid = $invoiceResponseDto['uid']; // string |
if (!is_null($uid)){
  try {
      $invoiceDetailsDto = $apiInvoiceInstance->apiInvoiceUidGet($uid);
      //print_r($invoiceDetailsDto);

        try {
            $securityElementsDto = $apiInvoiceInstance->apiInvoiceUidConfirmPut($uid);
            //print_r($securityElementsDto);
            //return var_dump($securityElementsDto);
        } catch (Exception $e) {
            //echo 'Exception when calling SfeInvoiceApi->apiInvoiceUidConfirmPut: ', $e->getMessage(), PHP_EOL;
        }

  } catch (Exception $e) {
      //echo 'Exception when calling SfeInvoiceApi->apiInvoiceUidConfirmPut: ', $e->getMessage(), PHP_EOL;
  }
}else {
	$rallback=1; 
}

		if(isset($SecurityElementsDto))
		var_dump($SecurityElementsDto); //echo $securityElementsDto['qr_code'];

		//echo "<br/>".
		$_SESSION['DT_HEURE_MCF']   = isset($securityElementsDto['date_time'])?$securityElementsDto['date_time']:NULL;
		//echo "<br/>".
		$_SESSION['QRCODE_MCF']     = isset($securityElementsDto['qr_code'])?$securityElementsDto['qr_code']:NULL;
		//echo "<br/>".
		$_SESSION['SIGNATURE_MCF']   = isset($securityElementsDto['code_me_ce_fdgi'])?$securityElementsDto['code_me_ce_fdgi']:NULL;
		//echo "<br/>".
		$_SESSION['COMPTEUR_MCF']   = isset($securityElementsDto['counters'])?$securityElementsDto['counters']:NULL;
		//echo "<br/>".
		$_SESSION['NIM_MCF']        = isset($securityElementsDto['nim'])?$securityElementsDto['nim']:NULL;

		//$compteur=2;$_SESSION['initial_fiche']=$_SESSION['NIM_MCF']."-".$compteur;
		$remise=0;
		$solde=isset($_SESSION['solde'])?$_SESSION['solde']:0;  // Valeur 0 : facture non soldée
		$montant=$_SESSION['TotalHT']."|".$_SESSION['Mtotal']."|".$remise."|".$solde;
		

/*      if($_SESSION['module']=="HEBERGEMENT")
       {mysqli_query($con,"UPDATE config SET numFact='".$_SESSION['numFact']."' ");
			if(isset($_SESSION['cham'])&&($_SESSION['cham']==1))  $objet = "Hébergement";  else $objet="Location de salle";
         //$objet="HEBERGEMENT";
       }
    if($_SESSION['module']=="ECONOMAT"){
      mysqli_query($con,"UPDATE configEconomat SET numFact='".$_SESSION['numFact']."' ");
      $objet="Vente de produits";
    }
    else {
       mysqli_query($con,"UPDATE ConfigResto SET numFact='".$_SESSION['numFact']."' ");
       $objet="RESTAURATION";
    }  */

		if(isset($_SESSION['cham'])&&($_SESSION['cham']==1))  $objet = "Hébergement";  
		else if(isset($_SESSION['sal']))     $objet="Location de salle"; 
		if(isset($_SESSION['Vente'])&&($_SESSION['Vente'])>0)	{
			$objet="Restauration";
			$objet.="|".$_SESSION['Nbre'];
		}

		if(!empty($_SESSION['SIGNATURE_MCF'])){

			$TelClt=!empty($_SESSION['TelClt'])?$_SESSION['TelClt']:NULL;
			$AdresseClt=!empty($_SESSION['AdresseClt'])?$_SESSION['AdresseClt']:NULL;
			$client=$_SESSION['NumIFU']."|".addslashes($_SESSION['client'])."|".$TelClt."|".$AdresseClt;
		
			$operateur=$_SESSION['userId']."|".$_SESSION['vendeur']."|".$_SESSION['PaymentDto']."|".$objet;
			
			if(isset($_SESSION['reference'])) {
				$EtatF='A|'.$_SESSION['id_request']."|".$_SESSION['ref_initial']; 
				 $query="INSERT INTO  e_mecef VALUES (NULL,'".$_SESSION['DT_HEURE_MCF']."','".$_SESSION['QRCODE_MCF']."','".$_SESSION['SIGNATURE_MCF']."','".$_SESSION['COMPTEUR_MCF']."','".$EtatF."','".$_SESSION['initial_fiche']."','".$montant."','".$operateur."','".$client."','".$Jour_actuelp."')";
				$res1=mysqli_query($con,$query);
				$update="UPDATE  e_mecef SET EtatF='AN' WHERE SIGNATURE_MCF='".$_SESSION['id_request']."'";
				$res1=mysqli_query($con,$update);
			
			}else {
				 $EtatF='V';
				 $query="INSERT INTO  e_mecef VALUES (NULL,'".$_SESSION['DT_HEURE_MCF']."','".$_SESSION['QRCODE_MCF']."','".$_SESSION['SIGNATURE_MCF']."','".$_SESSION['COMPTEUR_MCF']."','".$EtatF."','".$_SESSION['initial_fiche']."','".$montant."','".$operateur."','".$client."','".$Jour_actuelp."')";
				$res1=mysqli_query($con,$query);
				//$update="UPDATE  e_mecef SET EtatF='-1' WHERE SIGNATURE_MCF='".$_SESSION['id_request']."'";
				//$res1=mysqli_query($con,$update);
			}

			//if(!isset($_SESSION['reference']))
				//{
					$query="UPDATE produitsencours SET `Etat` = '0',SIGNATURE_MCF='".$_SESSION['SIGNATURE_MCF']."' WHERE `Etat` = '4'";
					$res1=mysqli_query($con,$query);
				//}

      if($_SESSION['module0']=="HEBERGEMENT"){
        $sql="SELECT MAX(id_request) AS  id_request FROM e_mecef";
        $query=mysqli_query($con,$sql);$data=mysqli_fetch_object($query);
        $id_request=$data->id_request;//$id_request=61;
        if(isset($id_request)){
          $query="UPDATE reedition_facture SET id_request='".$id_request."'   WHERE  numFactNorm='".$_SESSION['initial_fiche']."'";
          $update=mysqli_query($con,$query);
        }
        $query="SELECT * FROM e_mecef,produitsencours WHERE id_request='".$id_request."' AND e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF ";
        $res1=mysqli_query($con,$query);
        $data=mysqli_fetch_object($res1);
        $_SESSION['DT_HEURE_MCF']    = isset($data->DT_HEURE_MCF)?$data->DT_HEURE_MCF:NULL;
        $_SESSION['QRCODE_MCF']      = isset($data->QRCODE_MCF)?$data->QRCODE_MCF:NULL;
        $_SESSION['SIGNATURE_MCF']   = isset($data->SIGNATURE_MCF)?$data->SIGNATURE_MCF:NULL;
        $_SESSION['COMPTEUR_MCF']    = isset($data->COMPTEUR_MCF)?$data->COMPTEUR_MCF:NULL;
        //$_SESSION['NIM_MCF']         = isset($data->NIM_MCF)?$data->NIM_MCF:NULL;
		$_SESSION['NIM_MCF']         = $_SESSION['eMCF'];

       
	  if(!isset($_SESSION['reference'])){ 
		   for($k=0;$k<count($_SESSION['Listcompte']);$k++){
			$sql="SELECT mensuel_compte.somme AS somme,mensuel_compte.due AS due,mensuel_compte.np AS np,mensuel_compte.date AS date FROM mensuel_compte,mensuel_fiche1 WHERE mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_compte.numfiche='".$_SESSION['Listcompte'][$k]."'";
		   $result=mysqli_query($con,$sql);
		   if (!$result) {
			 printf("Error: %s\n", mysqli_error($con));
			 exit();
		   }
		   while($data=mysqli_fetch_array($result)){
			 $somme=isset($data['somme'])?$data['somme']:0;	$np=isset($data['np'])?$data['np']:0; $due=isset($data['due'])?$data['due']:0; $date=isset($data['date'])?$data['date']:NULL;
			 $update="UPDATE compte SET  somme='".$somme."',due='".$due."',np='".$np."',date='".$date."' WHERE compte.numfiche='".$_SESSION['Listcompte'][$k]."'";
			 $query=mysqli_query($con,$update);
		   }
		 }
		 if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)&&($_SESSION['NormSencaisser']==0)) {
		   $delete="DELETE FROM mensuel_compte  WHERE mensuel_compte.numfiche='".$_SESSION['Listcompte'][$k]."'";
		   $query=mysqli_query($con,$delete);
		   $req_=mysqli_query($con,$_SESSION['req1']);$req_=mysqli_query($con,$_SESSION['req2']);
		 }
		 if(isset($_SESSION['Vente'])&&($_SESSION['Vente']==1)) {
			$sql="SELECT compte2.client AS numcli FROM compte2,fraisconnexe WHERE fraisconnexe.numfiche=compte2.client  AND compte2.numfiche ='".$_SESSION['num']."'";
			$Select=mysqli_query($con,$sql); $data=mysqli_fetch_object($Select);			
			$pre_sql1="DELETE FROM compte2 WHERE numfiche='".$_SESSION['num']."'";
			$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
			$pre_sql1="DELETE FROM fraisconnexe WHERE numfiche='".$data->numcli."'";
			$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
		 }
	  }
	 

     if($Tps==1)   //1 pour Regime normal
          { 
		  if(isset($_SESSION['pourcent'])&&($_SESSION['pourcent']>0))
            header('location:FactureNormaliseeR.php');
            else
            header('location:InvoiceTPS.php'); 
          }
     	else header('location:FactureNormalisee.php');
      }
        //include ('JsonData.php');

		}else{
			$query="DELETE FROM produitsencours  WHERE `Etat` = '4'";
			$res1=mysqli_query($con,$query);			
			
 			if($Tps==1)   //1 pour Regime normal
				{if(isset($_SESSION['pourcent'])&&($_SESSION['pourcent']>0))
				header('location:FactureNormaliseeR.php');
				else
				header('location:InvoiceTPS.php');
				}
			else header('location:FactureNormalisee.php'); 
			
			//echo "La tentative a échouée pour des raisons techniques. Veuillez Réessayer SVP";		

			}
	  
		//}

?>
