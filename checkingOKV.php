<?php
			@include('config.php'); // decommenter
			@session_start(); //commenter  
			
			//echo $_SESSION['Mtotal'];

			$date = new DateTime("now"); // 'now' n'est pas n�c�ssaire, c'est la valeur par d�faut
			$tz = new DateTimeZone('Africa/Porto-Novo');
			$date->setTimezone($tz);
			$Heure_actuelle= $date->format("H") .":". $date->format("i").":". $date->format("s");
			$Jour_actuel= $date->format("Y") ."-". $date->format("m")."-". $date->format("d");

			$_SESSION['Date_actuel']=isset($_SESSION['date_emission'])?$_SESSION['date_emission']:$Date_actuel;

			$_SESSION['objet'] = utf8_decode("Vente de produits"); $data0=""; $productlist=array();

		if(empty($_GET['numrecu'])){

			if(isset($_SESSION['pourcent'])&&($_SESSION['pourcent']>0)){


			}
			
			$NumFact1=0;$NumFactN=0;
			
			$reqsel=mysqli_query($con,"SELECT num_fact,numFactNorm FROM configuration_facture");
			$data=mysqli_fetch_object($reqsel);	$NumFact=NumeroFacture($data->num_fact); 
			if(isset($_SESSION['Normalise'])) { $numFactNorm=NumeroFacture($data->numFactNorm);$TypeF=3;} else $TypeF=2;  

			if(isset($_SESSION['Normalise'])) { $NumFactN=$numFactNorm;$_SESSION['initial_fiche']=$numFactNorm; } 
			else { $NumFact1=""; $_SESSION['initial_fiche']="00000/".substr(date('Y'),2,2);}			
			
			$query_Recordset1="SELECT date,numcli,numcliS,nomcli,prenomcli,GrpeTaxation,groupe,NbreUnites,PrixUnitaire,code FROM fraisconnexe,compte2,client WHERE fraisconnexe.numfiche=compte2.client AND (compte2.client=client.numcli OR compte2.client=client.numcliS) AND compte2.numfiche='".$_SESSION['num']."'";
			$result=mysqli_query($con,$query_Recordset1);
			if (!$result) {
				printf("Error: %s\n", mysqli_error($con));
				exit();
			}
			if($nbreresult=mysqli_num_rows($result)>0){ $Mtotal=0;
				while($retC=mysqli_fetch_assoc($result)){			
					
					$Designation=$retC['code']; $GrpeTaxation=$retC['GrpeTaxation']; $PrixUnitTTC=$retC['PrixUnitaire']; $Qte=$retC['NbreUnites'];

					 $List=array(
						"DESIGNPROD" => strtoupper($Designation),
						"LTAXE" => $GrpeTaxation,
						"PRIXUNITTTC" => $PrixUnitTTC ,
						"MTTAXESPE" => "" ,
						"QUANTITE" => $Qte,
						"DESCTAXESPE" => "",
					  );
					array_push($productlist,$List);   $dateS=$retC['date'] ;
						
						$numcli=!isset($retC['numcli'])?$retC['numcli']:$retC['numcliS'] ; $client=$retC['nomcli']." ".$retC['prenomcli']; if(!empty($retC['groupe'])) $client=$retC['groupe'];

						if($_SESSION['serveurused']=="emecef")
							{	
								$taxSpecific=0;//$RegimeTVA=0;
								//echo "<br/>".
								$insert="INSERT INTO produitsencours SET Num=NULL,SIGNATURE_MCF='',Client='".$client."', LigneCde ='".$Designation."',prix ='".$PrixUnitTTC."',qte ='".$Qte."',Etat='4',GrpeTaxation='".$GrpeTaxation."',taxSpecific='".$taxSpecific."',RegimeTVA='".$RegimeTVA."',Type=1";
								if(isset($_SESSION['view'])&&($_SESSION['view']==0))
									$insertOK=mysqli_query($con,$insert); 
							}
							
					$Mtotali=$retC['PrixUnitaire']*$retC['NbreUnites'];	$Mtotal+=$Mtotali; $Designation0=$Designation."  (".$GrpeTaxation.")";

					$ecrire=fopen('txt/facture.txt',"w");
					$data0.=$numcli.';'.$client.';'.$Designation0.';'.$PrixUnitTTC.';'.$Qte.';'.$Mtotali."\n";
					$ecrire2=fopen('txt/facture.txt',"a+");
					fputs($ecrire2,$data0);
						
					 //$tarif2=$ttc_fixe2/$np;
			 		$numfiche=$_SESSION['num'];$type=1; $RegimeTVAi=0;
					$query="INSERT INTO reeditionfacture2 VALUES (NULL,'".$TypeF."','".$NumFactN."','".$numfiche."','".$Designation."','','".$TypeFacture."','".$GrpeTaxation."','".$type."','".round($PrixUnitTTC)."','".$Qte."','".$RegimeTVAi."','".$Mtotali."')";
					if(isset($_SESSION['view'])&&($_SESSION['view']==0)) $tu=mysqli_query($con,$query);
			
			}
			}
												
			if(!empty($retC['groupe']))
				$sql = "SELECT NumIFU,adressegrpe AS adresse,contactgrpe AS TelClt,email AS Email FROM groupe WHERE  codegrpe = '".trim($retC['groupe'])."'";
			else
				$sql = "SELECT nomcli,prenomcli,NumIFU,adresse,Telephone AS TelClt,Email AS Email  FROM client WHERE (numcli LIKE '".trim($numcli)."' OR numcliS LIKE '".trim($numcli)."')";

			$res = mysqli_query($con, $sql) or die (mysqli_error($con));
			$data =  mysqli_fetch_assoc($res);	$_SESSION['NumIFU']=$data['NumIFU']; $_SESSION['AdresseClt']=$data['adresse'];
			$_SESSION['TelClt']=$data['TelClt'];
			$_SESSION['EmailClt']=isset($data['EmailClt'])?$data['EmailClt']:NULL;									


			$type=0;

	
		}

		$_SESSION['client']=$client;



			$_SESSION['TotalHT'] = $Mtotal; //$TotalHT = $n*$TotalHT;
			$_SESSION['TotalTva'] = 0;  //$TotalTva = $n*$TotalTva;
			$_SESSION['TotalTaxe'] = 0; //$TotalTaxe= $n*$TotalTaxe;

		if(empty($_SESSION['avanceA'])) $_SESSION['avanceA']=0;
		//$_SESSION['Mtotal']=isset($_SESSION['groupe'])?$_SESSION['Mtotal']:$_SESSION['edit26'];
		//if(!isset($_SESSION['Fconnexe']))
		$Mtotal= $_SESSION['Mtotal']-$_SESSION['arrhes'];$avanceA = $_SESSION['avanceA'];

		if($_SESSION['modulo'] >= 0)
		{ //$Mtotal= $_SESSION['avanceA'] - $_SESSION['modulo']; $avanceA = $_SESSION['avanceA']+ $_SESSION['modulo'];

		}
		//else if($_SESSION['modulo'] == 0 ) { //$Mtotal= $_SESSION['avanceA'] ; $avanceA = $_SESSION['avanceA'];
		//}
		else {  $avanceA = $_SESSION['avanceA'] + $_SESSION['modulo']; //$Mtotal= $_SESSION['Mtotal'] ;
		}

		if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) {
			$_SESSION['modulo']=0;
			//$_SESSION['Mtotal']=$_SESSION['avanceA'];
		}

		if(isset($_SESSION['groupe']))
		 $query="SELECT MAX(numrecu) AS  numrecu FROM reedition_facture WHERE nom_client= '".$_SESSION['groupe']."'";
		else
		 $query="SELECT MAX(numrecu) AS  numrecu FROM reedition_facture WHERE nom_client= '".$_SESSION['client']."'";
		$Result=mysqli_query($con,$query);$data=mysqli_fetch_object($Result); $numrecu=$data->numrecu;

		if(isset($numrecu)&&!empty($numrecu))
			{$query="UPDATE reedition_facture SET num_facture='".$NumFact."' WHERE numrecu= '".$numrecu."'";
			$update=mysqli_query($con,$query);
			}


		$Tps=$RegimeTVA;

		//if(isset($_SESSION['cham'])&&($_SESSION['cham']==1)){
			
		if(!isset($_SESSION['solde'])||($_SESSION['solde']!=1)) ;$avanceA=0;
							  
		if(isset($_SESSION['retro'])&& ($_SESSION['retro']==1))
			{ $state=1;
				 $objet="Vente de produits";   $dateS=substr($dateS,8,2).'-'.substr($dateS,5,2).'-'.substr($dateS,0,4); $TotalTva=0; $remise=0; $TotalTaxe=0;
			if(isset($_SESSION['view'])&&($_SESSION['view']==0)){		  
				//echo "<br/>".
				$query="INSERT INTO reedition_facture VALUES (NULL,'".$state."','".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['login']."','0','".$NumFact1."','".$NumFactN."','0','".$client."','".$objet."','".$dateS."','".$dateS."','".$TotalTaxe."','".$TotalTva."','".$_SESSION['Mtotal']."','".$remise."','".$_SESSION['modulo']."','".$avanceA."','".$Tps."')";
				 $tu=mysqli_query($con,$query); $avanceA=$_SESSION['sommePayee']; $state=2; // ici $avanceA a changé de valeur pour la suite
				if($_SESSION['sommePayee']>0) {
				//echo "<br/>".
				$query="INSERT INTO reedition_facture VALUES (NULL,'".$state."','".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['login']."','0','".$NumFact1."','".$NumFactN."','0','".$client."','".$objet."','".$dateS."','".$dateS."','".$TotalTaxe."','".$TotalTva."','".$_SESSION['Mtotal']."','".$remise."','".$_SESSION['modulo']."','".$avanceA."','".$Tps."')";
				$tu=mysqli_query($con,$query);}
				}
			}
		else
		{	$state=0; 		if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) $state=2;
			$TotalTva=0; $remise=0; $TotalTaxe=0; $objet="Vente de produits";
		 if(isset($_SESSION['Vente'])) {
			//echo "<br/>".
			$query="INSERT INTO reedition_facture VALUES (NULL,'".$state."','".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['login']."','0','".$NumFact1."','".$NumFactN."','0','".$client."','".$objet."','','','".$TotalTaxe."','".$TotalTva."','".$_SESSION['Tttc_fixe']."','".$remise."','".$_SESSION['modulo']."','".$avanceA."','".$Tps."')";
			if(isset($_SESSION['view'])&&($_SESSION['view']==0))
				$tu=mysqli_query($con,$query);}
		}
		//}

		if($_SESSION['Tttc_fixe']!=$_SESSION['avanceA']) $_SESSION['ANNULER']=1;else $_SESSION['ANNULER']=0;

			$_SESSION['numFactN']=$NumFactN;

	if(isset($_SESSION['Vente'])&&($_SESSION['Vente']==1)){// echo "<br/>8588".$_SESSION['impaye'];
		if((isset($_POST['exonorer_tva']))||(isset($_POST['exonerer_AIB'])))
			{ //header('location:facture_de_groupe1.php');
			}
		else
			{  if(($_SESSION['Vente']==1)|| (isset($_SESSION['impaye'])))  //Vérifier
						{	if($_SESSION['serveurused']=="mecef")
									include 'others/GenerateMecefBill.php';
								else{
									if(!isset($_SESSION['button_checkbox_2'])){
										if(empty($_SESSION['sal'])|| ($_SESSION['Vente']==1)){ echo $_SESSION['view'];
											//if(!isset($_SESSION['view'])|| (($_SESSION['NormSencaisser']==1)&&(isset($_SESSION['impaye']))))
											if(isset($_SESSION['view'])&&($_SESSION['view']==0))	
											{ //echo $_SESSION['reference'];
												include('emecef.php');
											}
											else {
											 	  if($Tps==1)   //1 pour Regime normal
												  {
										 			 if(isset($_SESSION['pourcent'])&&($_SESSION['pourcent']>0))
														header('location:FactureNormaliseeR.php');
													else
														header('location:InvoiceTPS.php');  
												  }
												 else header('location:FactureNormalisee.php');  
											}
										}
									}
									else {
										//if($RegimeTVA==0) header('location:InvoiceTPS.php');
										//else header('location:FactureNormalisee.php');
										}
									}
							}

		$userId=$_SESSION['userId'];
		$userName=$_SESSION['nom']." ".$_SESSION['prenom'];
		//$_SESSION['userId']=
		$_SESSION['vendeur']=$userName;
		$customerIFU=$_SESSION['NumIFU'];//$customerIFU=$NumUFI;
		if($customerIFU==0) $customerIFU=null;
		$customerName=isset($_SESSION['groupe1'])?$_SESSION['groupe1']:$_SESSION['client'];

		$totalAmount=$_SESSION['Tttc_fixe']; //$totalAmount=$Mtotal;
		//$totalpayee = $avanceA; //22.02.22
		$totalpayee = $_SESSION['avanceA'];

		//$TFacture="v"; //
		$Aib_duclient="";
		//$TFacture="a";
		//if($TFacture=="v")
		if($_SESSION['serveurused']=="mecef"){
			if((isset($_SESSION['ANNULER']))&&($_SESSION['ANNULER']==0)&&($_SESSION['verrou']==0))
			$jsonData = formatData($userId,$userName,$customerIFU,$customerName,$Aib_duclient,$productlist,$totalAmount,$totalpayee);
		}
		//else
		//	$jsonData = formatData_Avoir($userId,$userName,$customerIFU,$customerName,$Aib_duclient,$productlist,$totalAmount,$totalpayee,$NIM_MCF);
		//echo "<br/>".print_r($jsonData);
		if($_SESSION['serveurused']=="mecef"){
		if((isset($_SESSION['ANNULER']))&&($_SESSION['ANNULER']==0)&&($_SESSION['verrou']==0))
		push($jsonData);
		}

	}
}

if($_SESSION['serveurused']=="mecef"){
		echo "<script language='javascript'>";
		echo "var timeout = setTimeout(
		function() {
			 document.location.href='JsonData.php'
			}
		,5000);";
	echo "</script>";
}
else{
		 //include('emecef.php');
		 //if($_SESSION['serveurused']=="emecef")
}


//echo $_SESSION['Mtotal'];
?>
