<?php
//namespace \;


use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ConnectException;





class MCF
{

 protected $base_uri;
 protected $apikey;

// protected $base_uri = env('MCF_URI');

 public function __construct(
  String $base_uri = null,
  String $apikey = null
) {
  /*$apikey ?: 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IjMyMDIwMTExODM5MzJ8VFMwMTAwMDM3MSIsInJvbGUiOiJUYXhwYXllciIsIm5iZiI6MTYyMzk0MDc1MywiZXhwIjoxNjQwOTA1MjAwLCJpYXQiOjE2MjM5NDA3NTMsImlzcyI6ImltcG90cy5iaiIsImF1ZCI6ImltcG90cy5iaiJ9.4WZx7EyZIds8iV3fQb8DoQMQk3x_-pODUecuB8BjAeQ';*/

   $this->base_uri = $base_uri ?: 'http://developper.impots.bj/sygmef-emcf/';
   $this->apikey = $this->apikey = $apikey ?: 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IjEyMDE0MDgzMzMxMDB8VFMwMTAwMDM3OCIsInJvbGUiOiJUYXhwYXllciIsIm5iZiI6MTYyNDAxNTg4MywiZXhwIjoxNjM5NzgyMDAwLCJpYXQiOjE2MjQwMTU4ODMsImlzcyI6ImltcG90cy5iaiIsImF1ZCI6ImltcG90cy5iaiJ9.6wjvve9y0CRmwVJvfLPhrtfJfap28762m5SXI2gqvAU';



 }

 public function getApiKey()
 {
  return $this->apikey;
}

public function setApiKey($key)
{
 $this->apikey = $key;
}

public function getBase_uri()
{
  return $this->base_uri;
}

public function setBase_uri($uri)
{
 $this->apikey = $uri;
}


public function getInfoStatus() {
    // Set various headers on a request
 $client = new Client();
 $resp = $client->request('GET',  $this->getBase_uri().'api/info/status', [
  'headers' => ['Authorization' => $this->getApiKey()]
]);
 return $resp->getStatusCode();
}


public function getMCFInvoice($request=null,$customer=null,$FType =null) {
  $client = new Client();
  $requestData = $this->prepareRqData($request,$customer,$FType);

  //return $requestData;
  try{

    $resp = $client->request(

      'POST', $this->getBase_uri().'api/invoice',
      [
        'headers' => [
          'Authorization' => $this->getApiKey(),
          'Content-Type' => 'application/json'
        ],
        'body'=> $requestData
      ]
    );
    return json_decode($resp->getBody()->getContents());

  } catch (RequestException $e) {
    return "bad resquest !";
  } catch (ConnectException $e) {
    return "Connexion error !";
  }

}

public  function confirmMCFInvoice($uid) {
 $client = new Client();

 try{

  $resp =  $client->request('PUT',  $this->getBase_uri().'api/invoice/'.$uid.'/confirm', [
    'headers' => ['Authorization' =>  $this->getApiKey()]
  ]);

return $resp->getBody()->getContents();

} catch (RequestException $e) {
  return "bad resquest !";
} catch (ConnectException $e) {
  return "Connexion error !";
}

}

public function prepareRqData($request,$customer,$FType){

  $data = array();

  $data['ifu'] = Auth::user()->group->identification;
  $data['type'] = $FType;
  //$data['aib'] = 'A' ;
  //$data['aib'] = 'B' ;

//Preparation des articles
  $items =[];
  $item =[];
  $totalAmount = 0;
  for ( $i = 0 ; $i<count($request->productCode);$i++){
        // récupérartion des infos du produit
    $wproduct = Wproduct::whereCode($request->productCode[$i])->first();
    $item['code'] = $wproduct->code;
    $item['name'] = $wproduct->name;
    $item['price'] = $request->outPrice[$i];
    $item['quantity'] = $request->quantity[$i];
    $item['taxgroup'] = $wproduct->taxGroup;//$wproduct->taxgroup;
    if($wproduct->taxSpecific != 0){
    $item['taxspecific'] = $wproduct->taxSpecific; //taxe spécifique//
    }
    $totalAmount += ($item['price'] * $item['quantity']);
    array_push($items,$item);
  }


  $data['items'] = $items ;

//Préparation du client
  if($customer->lastName || $customer->firstName)
  {
   $customerName = $customer->lastName.' '.$customer->firstName ;
 }elseif( $customer->enterprise )
 {
   $customerName =  $customer->enterprise ;
 }else{
  $customerName =  $customer->pseudo;
}
$data['client'] = array( 'name' => $customerName , 'contact'=>$customer->phone, 'ifu' => $customer->ifu);

//preparer l'utilisateur...
$data['operator']  = array('id' =>Auth::user()->id, 'name' =>Auth::user()->name);

$data['payment'] =  array(array('name'=>"ESPECES", 'amount'=>$totalAmount));
//$paymentMethod
//
//dd($data);
return json_encode($data);
}



public function prepareRqDataFA($request,$customer,$FType){

  $data = array();

  $data['ifu'] = Auth::user()->group->identification;
  $data['type'] = "FA";
  $data['reference'] = "TEST-N6DO-NIXD-2VYL-PUBO-EHWI";

//Preparation des articles
  $items =[];
  $item =[];
  $totalAmount = 0;
  for ( $i = 0 ; $i<count($request->productCode);$i++){
        // récupérartion des infos du produit
    $wproduct = Wproduct::whereCode($request->productCode[$i])->first();
    $item['code'] = $wproduct->code;
    $item['name'] = $wproduct->name;
    $item['price'] = $request->outPrice[$i];
    $item['quantity'] = $request->quantity[$i];
    $item['taxGroup'] = $wproduct->taxGroup;//$wproduct->taxgroup;
    $totalAmount += ($item['price'] * $item['quantity']);
    array_push($items,$item);
  }


  $data['items'] = $items ;

//Préparation du client
  if($customer->lastName || $customer->firstName)
  {
   $customerName = $customer->lastName.' '.$customer->firstName ;
 }elseif( $customer->enterprise )
 {
   $customerName =  $customer->enterprise ;
 }else{
  $customerName =  $customer->pseudo;
}
$data['client'] = array( 'name' => $customerName , 'contact'=>$customer->phone, 'ifu' => $customer->ifu);

//preparer l'utilisateur...
$data['operator']  = array('id' =>Auth::user()->id, 'name' =>Auth::user()->name);

$data['payment'] =  array(array('name'=>"ESPECES", 'amount'=>$totalAmount));
//$paymentMethod
//
//dd($data);
return json_encode($data);
}


public static function getMcfLocalInvoice($billNumber){
  $bill =  DB::table("t_mecef")->where('bill_num','=',$billNumber)->first();
  if($bill){
    return json_decode($bill->responsjson);
  }else{
    return null;
  }

}

}
