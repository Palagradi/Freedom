<html>
	<head>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script type="text/javascript" src="js/ajax.js"></script>
		<script src="js/sweetalert.min.js"></script>
	</head>
	<body bgcolor='azure' style="">
<?php
	 @include('config.php');//include 'others/footerpdf.inc';

	//echo 12;
	$numrecu=!empty($_GET['numrecu'])?$_GET['numrecu']:NULL;$num_facture=!empty($_GET['num_facture'])?$_GET['num_facture']:NULL;
	$fact=!empty($_GET['fact'])?$_GET['fact']:NULL;

	$_SESSION['initial_fiche'] = $numrecu;

		if(isset($fact)&&($fact==1)) $sql=" AND TypeF ='1'  "; //Ticket
		else if(isset($fact)&&($fact==2)) $sql=" AND TypeF ='2'  "; //Facture ordinaire
		else  $sql=" AND TypeF ='3'  ";  //Facture normalisée


		//echo "SELECT numfiche as numfiche_1 FROM  `exonerer_tva` WHERE numfiche='$numfiche'";
		//echo "<br/>SELECT numfiche as numfiche_1 FROM  `exonerer_tva` WHERE numfiche='$numfiche'";
//echo "SELECT client.numcli AS num1, view_client.numcli AS num2, client.nomcli AS nom1, view_client.nomcli AS nom2, client.prenomcli AS prenom1, view_client.prenomcli AS prenom2 FROM client, fiche1, view_client FROM client,fiche1 WHERE fiche1.numfiche='$numfiche' AND fiche1.numcli_1=client.numcli AND fiche1.numcli_2=view_client.numcli";

       if($_SESSION['serveurused']=="mecef")
			{	if(isset($fact)&&($fact==3))
					 $query="SELECT du,au,reeditionfacture2.numfiche AS numfiche,reedition_facture.date_emission AS date_emission,reedition_facture.nom_client AS nom_client,reedition_facture.num_facture AS num_facture,reedition_facture.du AS du,reedition_facture.au AS au,reedition_facture.montant_ttc AS montant_ttc,reedition_facture.somme_paye AS somme_paye,chambre.nomch,reeditionfacture2.tarif,reeditionfacture2.nuite,reeditionfacture2.montant,reeditionfacture2.occupation,reedition_facture.Remise FROM reedition_facture, reeditionfacture2,chambre WHERE chambre.numch=reeditionfacture2.designation AND reedition_facture.numFactNorm=reeditionfacture2.numrecu AND reedition_facture.numFactNorm='".$numrecu."' AND state <> '2' ".$sql;
				else
					 $query="SELECT du,au,reeditionfacture2.numfiche AS numfiche,reedition_facture.date_emission AS date_emission,reedition_facture.nom_client AS nom_client,reedition_facture.num_facture AS num_facture,reedition_facture.du AS du,reedition_facture.au AS au,reedition_facture.montant_ttc AS montant_ttc,reedition_facture.somme_paye AS somme_paye,chambre.nomch,reeditionfacture2.tarif,reeditionfacture2.nuite,reeditionfacture2.montant,reeditionfacture2.occupation,reedition_facture.Remise FROM reedition_facture, reeditionfacture2,chambre WHERE chambre.numch=reeditionfacture2.designation AND reedition_facture.num_facture=reeditionfacture2.numrecu AND reedition_facture.num_facture='".$numrecu."' AND state <> '2'".$sql;
		$sql2=mysqli_query($con,$query);
		$data="";$TotalHT=0;$tvaP=0;
 		while($row=mysqli_fetch_array($sql2))
			{ //echo $row['num_facture'];
			  //$_SESSION['initial_fiche']=$row['num_facture'];
			  $_SESSION['groupe1']=$row['nom_client'];  $_SESSION['debut']=$row['du']; $_SESSION['fin']=$row['au'];
			  $_SESSION['montant']=$row['montant_ttc']; $_SESSION['date_emission']=$row['date_emission'];
			  $_SESSION['avanceA']=$row['somme_paye']; $numfiche=$row['numfiche']; $_SESSION['remise']=$row['Remise'];
			  $_SESSION['Mtotal']=$row['montant_ttc']; $TotalHT+=($row['tarif']*$row['nuite']);

	    $sql_2=mysqli_query($con,"SELECT numfiche as numfiche_1 FROM  exonerer_tva WHERE numfiche='$numfiche'");
 		while($row_2=mysqli_fetch_array($sql_2))
			{ $numfiche_1=$row_2['numfiche_1'];  $_SESSION['exonorer_tva']==1;
			}
		//if(empty($numfiche_1))
		//{
		$sql_2=mysqli_query($con,"SELECT numfiche as numfiche_1 FROM  exonerer_aib WHERE numfiche='$numfiche'");
 		while($row_2=mysqli_fetch_array($sql_2))
			{ $numfiche_2=$row_2['numfiche_1'];  $_SESSION['exonerer_AIB']=1;
			}
		}
				$query="SELECT client.numcli AS num1, view_client.numcli AS num2, client.nomcli AS nom1, view_client.nomcli AS nom2, client.prenomcli AS prenom1, view_client.prenomcli AS prenom2,datarriv FROM client, fiche1, view_client WHERE fiche1.numfiche='".$numfiche."' AND fiche1.numcli_1=client.numcli AND fiche1.numcli_2=view_client.numcli";
			}
			
			
			
			
			
		else 
		{	
				//$dataS="";
				
 				$sql="SELECT DISTINCT SIGNATURE_MCF,objet,montant_ttc,du,au FROM e_mecef,reedition_facture WHERE e_mecef.NIM_MCF=reedition_facture.numFactNorm AND numFactNorm = '".$_GET['numrecu']."' ";
				$query=mysqli_query($con,$sql);$dataR=mysqli_fetch_object($query);
				$SIGNATURE_MCF=$dataR->SIGNATURE_MCF;	$montant_ttc=$dataR->montant_ttc;   $_SESSION['debut']=$dataR->du; $_SESSION['fin']=$dataR->au;

				$sql = "SELECT  (prix*qte) AS TotalTaxe FROM e_mecef,produitsencours WHERE e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF  AND e_mecef.SIGNATURE_MCF='".$SIGNATURE_MCF."' AND LigneCde LIKE 'TAXE DE SEJOUR'";
				$query = mysqli_query($con, $sql);	
				if(mysqli_num_rows($query)>0){
					$dataT=mysqli_fetch_object($query);	
					$_SESSION['TotalTaxe'] = $dataT->TotalTaxe;
				}
				
			
				$sqlA = "SELECT  * FROM e_mecef,produitsencours WHERE e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF  AND e_mecef.SIGNATURE_MCF='".$SIGNATURE_MCF."' AND LigneCde <>'TAXE DE SEJOUR'";
				mysqli_query($con,"SET NAMES 'utf8' ");
				$query = mysqli_query($con, $sqlA);$num=0;$data0="";$Mtotal=0; $TotalHT=0; $TotalTva=0;$TotalTva0=0;
				while($data=mysqli_fetch_array($query)){ $num++;

				$operat = explode("|",$data['operateur']);
				$_SESSION['userId']=$operat['0'];
				$_SESSION['vendeur']=$operat['1']; 
				$_SESSION['objet']=utf8_decode($operat['3']);
				$_SESSION['modeReglement']=$operat['2'];
				$_SESSION['PaymentDto']=$operat['2'];
				//$_SESSION['objet']=$operat['3'];
				$montant = explode("|",$data['Montant']);
				$Mtotal=isset($montant['0'])?$montant['0']:0;$avanceA=isset($montant['1'])?$montant['1']:0;
				if($montant['2']>0)
					$Mtotal=$Mtotal-$montant['2'];
				$remise=$montant['2']; $Date=substr($data['DT_HEURE_MCF'],0,10);
				$solde=(int)$montant['3']; 

				$client1 = explode("|",$data['clients']);
				
				$clientX = $data['Client']; 	$prix=$data['prix'];
				
				//$tarif=abs($data->montant);
				
				$taxe=0;
				
				if(substr(trim($data['LigneCde']),0,7)=="CHAMBRE"){
					if($prix<=20000) $taxe = 500;else if(($prix>20000) && ($prix<=100000))	$taxe = 1500;	else $taxe = 2500;
					$prix+=$taxe;
				}
				$customerIFU=$client1['0']; if($customerIFU==0) $customerIFU=null;
				
				//$_SESSION['AdresseClt']=$data['quartier']." ".$data['ville'];$_SESSION['TelClt']=$data['Telephone'];

			  //$_SESSION['groupe1']=$row['nom_client'];  $_SESSION['debut']=$row['du']; $_SESSION['fin']=$row['au'];
			  //$_SESSION['montant']=$row['montant_ttc']; 
			   //$_SESSION['date_emission']=$row['date_emission'];
			   $_SESSION['avanceA']=$avanceA; 			  
				$numcli=" ";  	  

			 
				$userName=$client1['1'];	
				
				$_SESSION['TelClt']=isset($client1['2'])?$client1['2']:NULL;
				$_SESSION['AdresseClt']=isset($client1['3'])?$client1['3']:NULL;
				
				
				$_SESSION['initial_fiche'] = $data['NIM_MCF'] ;

				$_SESSION['DT_HEURE_MCF']   = isset($data['DT_HEURE_MCF'])?$data['DT_HEURE_MCF']:NULL;
				$_SESSION['QRCODE_MCF']     = isset($data['QRCODE_MCF'])?$data['QRCODE_MCF']:NULL;
				$_SESSION['SIGNATURE_MCF']   = isset($data['SIGNATURE_MCF'])?$data['SIGNATURE_MCF']:NULL;
				$_SESSION['COMPTEUR_MCF']   = isset($data['COMPTEUR_MCF'])?$data['COMPTEUR_MCF']:NULL;
				$NIM_MCF = explode("|",$data['NIM_MCF']);$_SESSION['NIM_MCF']        = $NIM_MCF['0'];

				if($data['GrpeTaxation']=='A') $GrpeTaxation="A-EX";
				else if($data['GrpeTaxation']=='B') $GrpeTaxation="B";
				else if($data['GrpeTaxation']=='F') $GrpeTaxation="F";
				else if($data['GrpeTaxation']=='E') $GrpeTaxation="E";
				else $GrpeTaxation=$data['GrpeTaxation'];
				$LigneCde=$data['LigneCde']." (".$GrpeTaxation.")";
				$_SESSION['EtatF']=$data['EtatF'];
				
				//Taxe de Séjour
				
				$qte=$data['qte'];$mt=$prix*$qte;
				$ecrire=fopen('txt/facture.txt',"w");
				$data0.=$numcli.';'.$clientX.';'.$LigneCde.';'.$prix.';'.$qte.';'.$mt."\n";
				$ecrire2=fopen('txt/facture.txt',"a+");
				fputs($ecrire2,$data0);
			}

			 $_SESSION['TotalTTC']=$Mtotal; 
			 $_SESSION['Mtotal']=$Mtotal+$_SESSION['TotalTaxe'];  
			 //$_SESSION['TotalTaxe']=1000;
			 $_SESSION['TotalHT']= $Mtotal  ;
			 $_SESSION['TotalTva']= $TotalTva;
			 $_SESSION['NumIFU']=$customerIFU;
			 $_SESSION['client']=$userName;
			 $_SESSION['remise']=$remise;
			 $_SESSION['Date_actuel']=$Date;
			 $_SESSION['FV']=1;
		}
			  if($_SESSION['serveurused']=="mecef"){
			  $result=mysqli_query($con,$query);$i=0; $NbreClts=mysqli_num_rows($result);
				while($row1=mysqli_fetch_array($result))
				{if($row1['num1']!=$row1['num2'])
				   { $numcli=$row1['num1']." | ".$row1['num2'];
					 $client=substr(strtoupper($row1['nom1'])." ".strtoupper($row1['prenom1'])." |"." ".strtoupper($row1['nom2'])." ".strtoupper($$row1['prenom2']),0,35);    //if(!empty($row1['codegrpe']))  $_SESSION['client']=$row1['codegrpe'];
				   }
				  else
					{  $numcli=$row1['num1'];
					   $client=strtoupper($row1['nom1'])." ".strtoupper($row1['prenom1']); if(!isset($_SESSION['client'])) $_SESSION['client']=$client;
					 }
					 $datarriv=$row1['datarriv'];
					 	$i++;
					  $N_reel=2; // $N_reel=$dataR->nuite;

					 $debutT=substr($_SESSION['debut'],6,4).'-'.substr($_SESSION['debut'],3,2).'-'.substr($_SESSION['debut'],0,2);
					 $finT=substr($_SESSION['fin'],6,4).'-'.substr($_SESSION['fin'],3,2).'-'.substr($_SESSION['fin'],0,2);

					 //$client.="  (Du ".$jour." au ".$finT.")";
					 //echo $datarriv."<br/>".$debutT;

					 $ans=substr($datarriv,0,4);	$mois=substr($datarriv,5,2); $jour=substr($datarriv,8,2);
					 $fin=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$N_reel,date($ans)));

					 //if($row1['num1']=='CL0028') echo  $client.="  (Du ".$jour." au ".$fin.")"; //exit();

					 if($datarriv==$debutT){
						 if($fin==$finT) {

						 }else{
							//$client.="  (Du ".$jour." au ".$fin.")";
						}
				}
			 else {
					 if($fin==$finT) {

					 }else{
						 //if($NbreClts>1)
						 //$client.="  (Du ".$jour." au ".$fin.")";
					}
			 }

			  $nomch=$row['nomch'];
			  $nuite=$row['nuite'];
			  //$np=$row['np'];
			  $occupation=$row['occupation'];

			  $montant_ht=abs($nuite*round($row['tarif']));
			  $tarif=abs($row['tarif']);
			  if(!empty($numfiche_2))
			  $tarif=$tarif-$tarif*0.01;

			$sql="SELECT taxe,tva,TypeFacture,GrpeTaxation,montant,nuite FROM reedition_facture,reeditionfacture2 WHERE reedition_facture.numFactNorm=reeditionfacture2.numrecu AND numFactNorm = '".$_GET['numrecu']."' AND state='1' AND reeditionfacture2.numfiche='".$numfiche."'";
			$query=mysqli_query($con,$sql);$dataR=mysqli_fetch_object($query);

			$tarif=abs($dataR->montant);$taxe=0;
			if(abs($dataR->taxe)>0){
				if($tarif<=20000) $taxe = 500;else if(($tarif>20000) && ($tarif<=100000))	$taxe = 1500;	else $taxe = 2500;
			}
			$tva=$TvaD*((abs($row['montant'])-$taxe)/(1+$TvaD)); $tva=round($tva);   //fonction abs à cause du montant négatif lié à la facture d'avoir

			$nomch="   Chambre  ".strtoupper($row['nomch']);

			if($dataR->GrpeTaxation=='A') $GrpeTaxation='A-EX';else $GrpeTaxation=$dataR->GrpeTaxation;

			//if($dataR->taxe==0) $taxe=0;  if($dataR->tva==0) $tva=0;  //Exoneré - TVA - TAXE
			if($dataR->TypeFacture==1) {
			//$nomch.="  (A-EX)";
			}
			else if($dataR->TypeFacture==2) {
				$tva=0;
				//$nomch.="  (E)";
			}
			else if($dataR->TypeFacture==3) {
				//$nomch.="  (E)";
			}
			else if($dataR->TypeFacture==4)     //AIB applicable
        {
				//$nomch.="  (B)";
			}
			else if($dataR->TypeFacture==5)     //AIB applicable TVA Exoneré
			{ $_SESSION['Apply_AIB'] = isset($ratT['apply'])?$ratT['apply']:NULL;
				$_SESSION['PourcentAIB'] = isset($ratT['Pourcentage'])?$ratT['Pourcentage']:NULL;
				$_SESSION['ValAIB'] = isset($ratT['ValeurAIB'])?$ratT['ValeurAIB']:NULL;
				$tva=0;
				//$nomch.="  (A-EX)";
			}
			else {
				//$nomch.="  (E)";
			}

			$nomch.="  (".$GrpeTaxation.")";

			$PrixUnitaireTTC=$tarif;
			$tva*=$nuite; $tva=abs($tva);
			$taxe*=$nuite;

			//$aib=(100/$_SESSION['PourcentAIB'])*$montant_ht;

			$tvaP+=$tva;
			$_SESSION['TotalTaxe'] = $taxe;  // A revoir pour une facture de groupe

			//$nomch=$row['nomch'];


			$montant=$montant_ht+$taxe;
			  //$montant=$row['montant'];

			//if((empty($numfiche_1)))
				$montant+=$tva;
			  //$type=$row['type'];
			//if((!empty($numfiche_2)))
			//	$montant-=$aib;
			  //$nomch=$row['nomch'];

			$ecrire=fopen('txt/facture.txt',"w");  //$clientN="        ".$client;

			if($dataR->montant<0) $montant=-$montant;  //Condition valable pour une facture d'avoir

			//$PrixUnitaireTTC = $montant/$nuite;

			$montant = $PrixUnitaireTTC*$nuite;

			//}



			//if((empty($numfiche_1))&&(empty($numfiche_2)))
				//$data.=$numcli.';'.$client.';'.$nomch.';'.$nuite.';'.$montant_ht.';'.$tva.';'.$taxe.';'.$montant."\n";
				$data.=$numcli.';'.$client.';'.$nomch.';'.$PrixUnitaireTTC.';'.$nuite.';'.$montant."\n";
			// else if((!empty($numfiche_1))&&(empty($numfiche_2)))
			// 	$data.=$numcli.';'.$client.';'.$nomch.';'.$nuite.';'.$montant_ht.';'.$taxe.';'.$montant."\n";
			// else if((!empty($numfiche_1))&&(!empty($numfiche_2)))
			// 	$data.=$numcli.';'.$client.';'.$nomch.';'.$nuite.';'.$montant_ht.';'.$aib.';'.$taxe.';'.$montant."\n";
			// else
			// 	$data.=$numcli.';'.$client.';'.$nomch.';'.$nuite.';'.$montant_ht.';'.$tva.';'.$aib.';'.$taxe.';'.$montant."\n";
			$ecrire2=fopen('txt/facture.txt',"a+");
			fputs($ecrire2,$data);
		}  
		
		}
		
		//$_SESSION['TotalHT'] = $TotalHT; 	
		if(isset($tvaP))$_SESSION['TotalTva']=$tvaP;
		//echo $_SESSION['client']=12;

/*  		if((empty($numfiche_1))&&(empty($numfiche_2)))
			header('location:Facture.php?d=1');
		else if((!empty($numfiche_1))&&(!empty($numfiche_2)))
			header('location:facture_de_groupe3.php?d=1');
		else if((empty($numfiche_1))&&(!empty($numfiche_2)))
			header('location:facture_de_groupe2.php?d=1');
		else
			header('location:facture_de_groupe1.php?d=1');  */
		
		  if($_SESSION['serveurused']=="mecef"){

		if((isset($_POST['exonorer_tva']))||(isset($_POST['exonerer_AIB'])))
			{ header('location:facture_de_groupe1.php');
			}
		else
			{			if(isset($_GET['numrecu'])) {
						$sql = "SELECT DISTINCT(reeditionfacture2.numrecu) AS numrecu, numcli_1 AS numcli,nom_client,tva,taxe,Remise,montant_ttc,designation,date_emission,somme_paye FROM reedition_facture,reeditionfacture2,fiche1 WHERE fiche1.numfiche=reeditionfacture2.numfiche AND reedition_facture.numFactNorm=reeditionfacture2.numrecu AND reeditionfacture2.numrecu='".$_GET['numrecu']."' AND state='1' ";
						$res = mysqli_query($con, $sql) or die (mysqli_error($con));
						$data =  mysqli_fetch_assoc($res);	$client=$data['nom_client']; $numcli=$data['numcli']; $tva=$data['tva'];$taxe=$data['taxe']; $Remise=$data['Remise'];$montant_ttc=$data['montant_ttc'];	$_SESSION['date_emission']=$data['date_emission'];  $_SESSION['avanceA'] =$data['somme_paye'];
            //$_SESSION['date_emission']=	substr($data['date_emission'],8,2).'-'.substr($data['date_emission'],5,2).'-'.substr($data['date_emission'],0,4);
						$sqlT = "SELECT * FROM Applyaib WHERE numfiche='".$numfiche."'	AND date LIKE '".$data['date_emission']."'
						UNION
						SELECT * FROM Applyaib WHERE groupe='".$client."'	AND date LIKE '".$data['date_emission']."'";
						$rasT=mysqli_query($con,$sqlT);	$ratT=mysqli_fetch_assoc($rasT);

						{	$_SESSION['Apply_AIB'] = isset($ratT['apply'])?$ratT['apply']:NULL;
							$_SESSION['PourcentAIB'] = isset($ratT['Pourcentage'])?$ratT['Pourcentage']:NULL;
							$_SESSION['ValAIB'] = isset($ratT['ValeurAIB'])?$ratT['ValeurAIB']:NULL;

						}


						$sql = "SELECT NumIFU,adressegrpe AS adresse,contactgrpe AS TelClt,email AS Email FROM groupe WHERE  codegrpe = '".$client."'";
						$res = mysqli_query($con, $sql) or die (mysqli_error($con));
						$data =  mysqli_fetch_assoc($res);
						if(mysqli_num_rows($res)>0){
						}
						else
						{ $sql = "SELECT nomcli,prenomcli,NumIFU,adresse,Telephone AS TelClt,Email AS Email  FROM client WHERE numcli LIKE '".$numcli."'";
						$res = mysqli_query($con, $sql) or die (mysqli_error($con));
						$data =  mysqli_fetch_assoc($res);
						}
						$_SESSION['NumIFU']=$data['NumIFU'];  $_SESSION['AdresseClt']=$data['adresse'];
						$_SESSION['TelClt']=$data['TelClt'];
						$_SESSION['EmailClt']=isset($data['Email'])?$data['Email']:NULL;


						$_SESSION['client']=$client;  

						//$_SESSION['TotalHT'] =$tva;
						$_SESSION['TotalTaxe']=$taxe; $_SESSION['remise'] = $Remise; $_SESSION['TotalTTC']=$montant_ttc;

						$_SESSION['devise']=isset($devise)?$devise:NULL;
			}
			}
			}
					if(isset($_GET['fact'])&&($_GET['fact']==2))
						{		
					
								$sql="SELECT MAX(id_request) AS id_request FROM reedition_facture WHERE numFactNorm = '".$_GET['numrecu']."' AND state='1'";
								$query=mysqli_query($con,$sql);$data=mysqli_fetch_object($query);
								$id_request=$data->id_request;

								if(!empty($id_request))
								{
									if($_SESSION['serveurused']=="mecef")
										{	$query="SELECT responsjson FROM t_mecef WHERE id_request='".$id_request."'";
											$res1=mysqli_query($con,$query);
											$data=mysqli_fetch_object($res1);
											$result = array ();
											$result = json_decode($data->responsjson);
										}
									else
										{   $query="SELECT * FROM e_mecef WHERE id_request='".$id_request."'";
											$res1=mysqli_query($con,$query);
											$result=mysqli_fetch_object($res1);
										}
								}


								$_SESSION['CODE_REPONSE']    = isset($result->CODE_REPONSE)?$result->CODE_REPONSE:NULL;
								$_SESSION['QRCODE_MCF']      = isset($result->QRCODE_MCF)?$result->QRCODE_MCF:NULL;
								$_SESSION['COMPTEUR_MCF']    = isset($result->COMPTEUR_MCF)?$result->COMPTEUR_MCF:NULL;
								$_SESSION['DT_HEURE_MCF']    = isset($result->DT_HEURE_MCF)?$result->DT_HEURE_MCF:NULL;
								//$_SESSION['NIM_MCF']         = isset($result->NIM_MCF)?$result->NIM_MCF:NULL;
																

									
								$_SESSION['SIGNATURE_MCF']   = isset($result->SIGNATURE_MCF)?$result->SIGNATURE_MCF:NULL;
								$_SESSION['IFU_MCF']         = isset($result->IFU_MCF)?$result->IFU_MCF:NULL;
								$_SESSION['ISF']         		 = "Freedom-V01";

								$_SESSION['reimprime'] = 1;  $_SESSION['Date_actuel']=$Date_actuel;
								//$_SESSION['userId'] = 2;	$_SESSION['nom'] = "OKE";		$_SESSION['prenom'] ="Brice";

								$query="SELECT * FROM FacturedAvoir WHERE reference='".$_GET['numrecu']."'";
								$res1=mysqli_query($con,$query); $data=mysqli_fetch_object($res1);
								$_SESSION['Foriginal1'] = isset($data->Foriginal1)?$data->Foriginal1:NULL;
								$_SESSION['Foriginal2'] = isset($data->Foriginal2)?$data->Foriginal2:NULL;

								 //if($RegimeTVA!=0) header('location:InvoiceTPS.php');
								 //else
								 //header('location:FactureNormaliseeR.php');
							 

								
								if($solde<=0) $_SESSION['avanceA']=0;  //La facture emise n'avait pas été soldée
								//echo $solde;
								
	/* 							$_SESSION['debut']="27-03-2022"; $_SESSION['fin']="07-05-2022";  
								$_SESSION['PaymentDto']="CHEQUE";  
								$_SESSION['objet']=utf8_decode("Hébergement");
								$_SESSION['SIGNATURE_MCF1']="00016/22"; */
								
								//$_SESSION['Date_actuel']="21-02-2022";
/* 								$_SESSION['objet']=utf8_decode("Hébergement");
								$_SESSION['client']="GRANDS MOULINS DU BENIN";
								$_SESSION['AdresseClt']="01 BP 949";
								$_SESSION['TelClt'] =21330817; */
								//$_SESSION['Mtotal']=75000; 
								//$_SESSION['initial_fiche']="00021/22";
								
								//$_SESSION['eMCF']="EM01114947";
								//$_SESSION['NumIFUEn']="6201701236502"; //Mettre ici l'IFU de l'Entreprise
								
								$_SESSION['NIM_MCF'] = $_SESSION['eMCF']; 
							 
								header('location:InvoiceTPS.php');
								
								if($_SESSION['objet']=="RESTAURATION"){									
									$_SESSION['Vente']=$operat['4'];
								}
						}
				else { //echo 125;
					//header('location:Facture.php');
				}
			//}

			//}
?>
