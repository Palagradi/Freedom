<?php

 function formatData($userId,$userName,$customerIFU,$customerName,$Aib_duclient,$productlist,$totalAmount,$totalpayee)
  {

   $jsonData = array(
    "CLE_SERVICEKEY" => getSERVICEKEY(),
    "ID_DUVENDEUR" => $userId,
    "NOM_DUVENDEUR" => $userName ,
    "IFU_DUCLIENT"=> $customerIFU,
    "NOM_DUCLIENT"=> $customerName,
    "AIB_DUCLIENT"=> $Aib_duclient,
    "REF_FACTAREMB"=>"",
    "EXPORTATION"=>false,
    "MENTION_COPIE"=>false,
    "TOTAL_TTCFACT"=>$totalAmount,
    "PA_LPAIEMENT"=>"E",
    "MP_MONTANTPAYE"=>$totalpayee,
    "TAXE_A"=>"",
    "TAXE_B"=>"",
    "TAXE_C"=>"",
    "TAXE_D"=>"",
    "PRODUITMCF" => $productlist
  );
   return json_encode($jsonData) ;
 }
 
  function formatData_Avoir($userId,$userName,$customerIFU,$customerName,$Aib_duclient,$productlist,$totalAmount,$totalpayee,$NIM_MCF)
  {

   $jsonData = array(
    "CLE_SERVICEKEY" => getSERVICEKEY(),
    "ID_DUVENDEUR" => $userId,
    "NOM_DUVENDEUR" => $userName ,
    "IFU_DUCLIENT"=> $customerIFU,
    "NOM_DUCLIENT"=> $customerName,
    "AIB_DUCLIENT"=> $Aib_duclient,
    "REF_FACTAREMB"=>$NIM_MCF,
    "EXPORTATION"=>false,
    "MENTION_COPIE"=>false,
    "TOTAL_TTCFACT"=>$totalAmount,
    "PA_LPAIEMENT"=>"E",
    "MP_MONTANTPAYE"=>$totalpayee,
    "TAXE_A"=>"",
    "TAXE_B"=>"",
    "TAXE_C"=>"",
    "TAXE_D"=>"",
    "PRODUITMCF" => $productlist
  );
   return json_encode($jsonData) ;
 }

 function getSERVICEKEY()
 {
  return "BABE-OLZB-ZWXQ-WEVV-JJIG-YOWS";
}

 function push($jsonData)
	{
		include 'connexion.php'; $result=0;
		$query="INSERT INTO  t_mecef VALUES (NULL,'".$jsonData."','".$result."','',NULL,NULL,NULL)";
		$res1=mysqli_query($con,$query);
	}

 function pull($id_request)
	{	include 'connexion.php';
		$query="SELECT responsjson FROM t_mecef WHERE id_request='".$id_request."'";
		$res1=mysqli_query($con,$query); $data=mysqli_fetch_object($res1);
		return json_decode($data->responsjson);

	}
