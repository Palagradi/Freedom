<?php
require_once('vendor/SwaggerClient-php/vendor/autoload.php');

//include ('MCF.php');

//$mcf = new MCF();


// $productlist=array();
// $product="Jus d'orange";$price=1800; $quantity=2;  $taxGroup="B";
// $List=array(
//  "name" => ucfirst($product),
//  "price" => $price,
//  "quantity" => $quantity ,
//  "taxGroup" => $taxGroup ,
//  );
//  array_push($productlist,$List);
//
//  $customer=array();
//  $customerName ="ALI Mohamed"; $contact="97524896"; $ifu=NULL;
//  $List=array(
//   "name" => ucfirst($customerName),
//   "contact" => $contact,
//   "ifu" => $ifu ,
//   );
//   array_push($customer,$List);

// try {
//
//          $respCode =  $mcf->getInfoStatus();
//          echo var_dump($respCode);
//
//          //$MCFInvoice =  $mcf->getMCFInvoice($productlist,$customer,"FV");
//          //echo var_dump($MCFInvoice->$uid);
//
//
//        } catch (RequestException $e) {
//
//          echo 'Normalisation de facture rejetée , mauvaise requete ! ';
//
//        } catch (ConnectException $e) {
//
//          echo 'Erreur de Connexion : Facture normalisée non disponible ! ';
//
//        }


// Configure API key authorization: Bearer
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IjEyMDE0MDgzMzMxMDB8VFMwMTAwMDM3OCIsInJvbGUiOiJUYXhwYXllciIsIm5iZiI6MTYyNDAxNTg4MywiZXhwIjoxNjM5NzgyMDAwLCJpYXQiOjE2MjQwMTU4ODMsImlzcyI6ImltcG90cy5iaiIsImF1ZCI6ImltcG90cy5iaiJ9.6wjvve9y0CRmwVJvfLPhrtfJfap28762m5SXI2gqvAU');
print_r($config);
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
}

try {
    $invoiceTypesDto = $apiInfoInstance->apiInfoInvoiceTypesGet();
    print_r($invoiceTypesDto);
} catch (Exception $e) {
    echo 'Exception when calling SfeInvoiceApi->apiInvoiceGet: ', $e->getMessage(), PHP_EOL;
}

try {
    $taxGroupsDto = $apiInfoInstance->apiInfoTaxGroupsGet();
    print_r($taxGroupsDto);
} catch (Exception $e) {
    echo 'Exception when calling SfeInvoiceApi->apiInvoiceGet: ', $e->getMessage(), PHP_EOL;
}

try {
    $paymentTypesDto = $apiInfoInstance->apiInfoPaymentTypesGet();
    print_r($paymentTypesDto);
} catch (Exception $e) {
    echo 'Exception when calling SfeInvoiceApi->apiInvoiceGet: ', $e->getMessage(), PHP_EOL;
}

//INVOICE
try {
    $statusReponseDto = $apiInvoiceInstance->apiInvoiceGet();
    print_r($statusReponseDto);
} catch (Exception $e) {
    echo 'Exception when calling SfeInvoiceApi->apiInvoiceGet: ', $e->getMessage(), PHP_EOL;
}


$body = new \Swagger\Client\Model\InvoiceRequestDataDto(); // \Swagger\Client\Model\InvoiceRequestDataDto |
$body->setIfu('1201408333100');//YOUR IFU HERE

$operatorDto = new \Swagger\Client\Model\OperatorDto();
$operatorDto->setid(1);
$operatorDto->setName('ALIHONOU Elvie');
$body->setOperator($operatorDto);

$body->setType(Swagger\Client\Model\InvoiceTypeEnum::FV);
//$body->setType('FV');

$items = array();


$sql = 'SELECT * FROM produitsencours WHERE  Etat = 1 ';
mysqli_query($con,"SET NAMES 'utf8' ");
$query = mysqli_query($con, $sql);
while($data=mysqli_fetch_array($query)){
	$item1 = new \Swagger\Client\Model\ItemDto();
	$item1->setName($data['LigneCde']);
	$item1->setPrice($data['prix']);
	$item1->setQuantity($data['qte']); 
	if($data['GrpeTaxation']=="A")
	$item1->setTaxGroup(Swagger\Client\Model\TaxGroupTypeEnum::A);
	else if($data['GrpeTaxation']=="B")
	$item1->setTaxGroup(Swagger\Client\Model\TaxGroupTypeEnum::B);
	else if($data['GrpeTaxation']=="F")
	$item1->setTaxGroup(Swagger\Client\Model\TaxGroupTypeEnum::F);
	else
	$item1->setTaxGroup(Swagger\Client\Model\TaxGroupTypeEnum::E);
	array_push($items, $item1); 
} 


$body->setItems($items);

try {
    $invoiceResponseDto = $apiInvoiceInstance->apiInvoicePost($body);
    print_r($invoiceResponseDto);
} catch (Exception $e) {
    echo 'Exception when calling SfeInvoiceApi->apiInvoicePost: ', $e->getMessage(), PHP_EOL;
}

$uid = $invoiceResponseDto['uid']; // string |
if (!is_null($uid)){
  try {
      $invoiceDetailsDto = $apiInvoiceInstance->apiInvoiceUidGet($uid);
      print_r($invoiceDetailsDto);

        try {
            $securityElementsDto = $apiInvoiceInstance->apiInvoiceUidConfirmPut($uid);
            //print_r($securityElementsDto);
            //return var_dump($securityElementsDto);
        } catch (Exception $e) {
            echo 'Exception when calling SfeInvoiceApi->apiInvoiceUidConfirmPut: ', $e->getMessage(), PHP_EOL;
        }

  } catch (Exception $e) {
      echo 'Exception when calling SfeInvoiceApi->apiInvoiceUidConfirmPut: ', $e->getMessage(), PHP_EOL;
  }
}

		var_dump($SecurityElementsDto); //echo $securityElementsDto['qr_code']; 

		echo "<br/>".$_SESSION['DT_HEURE_MCF']   = isset($securityElementsDto['date_time'])?$securityElementsDto['date_time']:NULL;
		echo "<br/>".$_SESSION['QRCODE_MCF']     = isset($securityElementsDto['qr_code'])?$securityElementsDto['qr_code']:NULL;
		echo "<br/>".$_SESSION['SIGNATURE_MCF']   = isset($securityElementsDto['code_me_ce_fdgi'])?$securityElementsDto['code_me_ce_fdgi']:NULL;
		echo "<br/>".$_SESSION['COMPTEUR_MCF']   = isset($securityElementsDto['counters'])?$securityElementsDto['counters']:NULL;
		echo "<br/>".$_SESSION['NIM_MCF']        = isset($securityElementsDto['nim'])?$securityElementsDto['nim']:NULL;
		
		//$compteur=2;$_SESSION['initial_fiche']=$_SESSION['NIM_MCF']."-".$compteur;
		
		echo $query="INSERT INTO  e_mecef VALUES (NULL,'".$_SESSION['DT_HEURE_MCF']."','".$_SESSION['QRCODE_MCF']."','".$_SESSION['SIGNATURE_MCF']."','".$_SESSION['COMPTEUR_MCF']."','".$_SESSION['NIM_MCF']."')";
		$res1=mysqli_query($con,$query);
?>
