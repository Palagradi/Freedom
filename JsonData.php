<html>
	<head>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script type="text/javascript" src="js/ajax.js"></script>
		<script src="js/sweetalert.min.js"></script>
	</head>
	<body bgcolor='azure' style="">

<?php
//session_start();@include('connexion.php');
//if(isset($_SESSION['EtatS'])&& ($_SESSION['remise']>0))
	//require('fpdf17/fpdf.php');
//else

 @include('config.php');

 		//if(isset($_SESSION['EtatS'])){

		//Comment lancer une application exe en php

		//Lancement automayique de MyEtrade au démarrage

		if(isset($_SESSION['numrecu'])){  //Condition applicable pour une facture d'avoir

		}

		$sql="SELECT MAX(id_request) AS  id_request FROM t_mecef";
		$query=mysqli_query($con,$sql);$data=mysqli_fetch_object($query);
		$id_request=$data->id_request;//$id_request=61;

		if(isset($id_request)){
			$query="UPDATE reedition_facture SET id_request='".$id_request."'   WHERE  numFactNorm='".$_SESSION['initial_fiche']."'";
			$update=mysqli_query($con,$query);
		}

		$query="SELECT responsjson FROM t_mecef WHERE id_request='".$id_request."'";
		$res1=mysqli_query($con,$query); $data=mysqli_fetch_object($res1);
		$result = array ();
		if(isset($data->responsjson)) $result = json_decode($data->responsjson);

		$_SESSION['CODE_REPONSE']    = isset($result->CODE_REPONSE)?$result->CODE_REPONSE:NULL;
		$_SESSION['QRCODE_MCF']      = isset($result->QRCODE_MCF)?$result->QRCODE_MCF:NULL;
		$_SESSION['COMPTEUR_MCF']    = isset($result->COMPTEUR_MCF)?$result->COMPTEUR_MCF:NULL;
		$_SESSION['DT_HEURE_MCF']    = isset($result->DT_HEURE_MCF)?$result->DT_HEURE_MCF:NULL;
		$_SESSION['NIM_MCF']         = isset($result->NIM_MCF)?$result->NIM_MCF:NULL;
		$_SESSION['SIGNATURE_MCF']   = isset($result->SIGNATURE_MCF)?$result->SIGNATURE_MCF:NULL;
		$_SESSION['IFU_MCF']         = isset($result->IFU_MCF)?$result->IFU_MCF:NULL;
		$MSG_REPONSE                 = isset($result->MSG_REPONSE)?$result->MSG_REPONSE:NULL;

		//if(!empty($_GET['test'])&& ($_GET['test']=='null')){
			//echo "<script language='javascript'>";
			//echo 'alertify.error(" L\'opération a été annulée !");';
			//echo "</script>";
		//}

		if(isset($_SESSION['CODE_REPONSE'])&& ($_SESSION['CODE_REPONSE']=="TOTALTTC-OK")&&($_SESSION['ANNULER']==0)){
			if(!isset($_SESSION['numrecu'])){
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
		 if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) {
			 $delete="DELETE FROM mensuel_compte  WHERE mensuel_compte.numfiche='".$_SESSION['Listcompte'][$k]."'";
			 $query=mysqli_query($con,$delete);
			 $req_=mysqli_query($con,$_SESSION['req1']);$req_=mysqli_query($con,$_SESSION['req2']);
		 }

		 if($RegimeTVA==0) header('location:FactureNormaliseeTPS.php'); else header('location:FactureNormalisee.php');
	 }else {   //Condition applicable pour une facture d'avoir
		   $query="SELECT * FROM reedition_facture WHERE reedition_facture.numFactNorm='".$_SESSION['numrecu']."' AND state <> '2' ";
 //else
		 //$query="SELECT * FROM reedition_facture WHERE  reedition_facture.num_facture='".$_SESSION['numrecu']."' AND state <> '2'";

		 $query2="SELECT * FROM reeditionfacture2 WHERE reeditionfacture2.numrecu='".$_SESSION['numrecu']."' ";

	   $sql2=mysqli_query($con,$query); $sql3=mysqli_query($con,$query2);

		 $update=mysqli_query($con,"UPDATE configuration_facture SET numFactDavoir=numFactDavoir+1 ");
		 $reqsel=mysqli_query($con,"SELECT num_fact,numFactDavoir FROM configuration_facture");
		 $data=mysqli_fetch_object($reqsel);		$NumFact=NumeroFacture($data->num_fact);  $numFactNorm=NumeroFacture($data->numFactDavoir);

	while($row=mysqli_fetch_array($sql2))
		{ //$_SESSION['Ref_Fact_orig'] = $row['numFactNorm'];
			$query="INSERT INTO  reedition_facture SET state='".$row['state']."',
			date_emission='".$Jour_actuelp."', heure_emission='".$Heure_actuelle."', receptionniste='".$_SESSION['login']."',
			numFactNorm='".$numFactNorm."', id_request=$id_request, nom_client='".$row['nom_client']."', objet='".$row['objet']."',
			du='".$row['du']."', au='".$row['au']."', taxe=-'".$row['taxe']."', tva=-'".$row['tva']."', montant_ttc=-'".$row['montant_ttc']."',
			Remise=-'".$row['Remise']."', Arrhes='".$row['Arrhes']."', somme_paye=-'".$row['somme_paye']."' ";
			$res1=mysqli_query($con,$query);
		}
		while($row=mysqli_fetch_array($sql3))
			{ $query="INSERT INTO  reeditionfacture2 SET TypeF='".$row['TypeF']."', numrecu='".$numFactNorm."', numfiche='".$row['numfiche']."',
				designation='".$row['designation']."', type='".$row['type']."',TypeFacture='".$row['TypeFacture']."', occupation='".$row['occupation']."',
				tarif=-'".$row['tarif']."', nuite='".$row['nuite']."',	 montant=-'".$row['montant']."' ";
				$res1=mysqli_query($con,$query);
			}

			$query="SELECT numFactNorm FROM reedition_facture WHERE id IN (SELECT MAX(id) FROM reedition_facture)";
			$res1=mysqli_query($con,$query); $data=mysqli_fetch_object($res1);//$numrecu=$data->numFactNorm;

			$res=mysqli_query($con,'CREATE TABLE IF NOT EXISTS FacturedAvoir (date DATE NOT NULL,
			reference VARCHAR(25) NOT NULL, Foriginal1 VARCHAR(25) NOT NULL, Foriginal2 VARCHAR(25) NOT NULL,PRIMARY KEY (reference)
			) ENGINE = InnoDB ');
			$req="INSERT INTO FacturedAvoir VALUES('".$Jour_actuel."','".$numFactNorm."','".$_SESSION['NIM_MCF']."','".$_SESSION['numrecu']."')";
			$sql=mysqli_query($con,$req);

			$fact=isset($_SESSION['fact'])?$_SESSION['fact']:NULL; $numrecu=$data->numFactNorm;

			echo "<iframe src='reimpression.php?numrecu=".$data->numFactNorm."&fact=".$fact;  echo "' width='100%' height='100%' scrolling='no' frameborder='0' marginwidth='0'></iframe>";
			//header('location:reimpression.php');	//include ('reimpression.php');
	 		}
		}
		else {
			 if($RegimeTVA==0) header('location:FactureNormaliseeTPS.php'); else header('location:FactureNormalisee.php');      // Attention : Commenter cette ligne

			if($_SESSION['verrou']==1) $MSG_REPONSE="VOUS NE POUVEZ PAS ETABLIR DE FACTURE NORMALISEE. VEUILLEZ CONTACTER VOTRE EDITEUR. ";
			else {
				echo "<center><h3 style='margin-top:200px;color:red;'>LA FACTURE NORMALISEE A ETE ANNULEE. REESSAYEZ SVP !</h3></center>";
				if($_SESSION['ANNULER']==1) $MSG_REPONSE="LE MONTANT A ENCAISSE NE CORRESPOND PAS AU TOTAL ENCAISSE";
			}
			echo "<br/><center><h3 style='color:maroon;'> ";
			if(isset($MSG_REPONSE)&&($MSG_REPONSE!=NULL))
					echo " CAUSE DU PROBLEME : <span style='color:red;'>".$MSG_REPONSE."</span>";
			else
					echo "1-	VERIFIER SI LA MACHINE DE LA FACTURATION <span style='color:red;'>MECEF</span> EST BIEN CONNECTEE.
					<br/><br/><br/>
								2-	VERIFIER ENSUITE SI LE MODULE <span style='color:red;'>MYELTRADE</span> EST LANCE. LE REDEMARRER CI POSSIBLE.";
			echo "</h3></center>";

			if(!isset($_SESSION['numrecu'])){

				if(isset($id_request)){
					$query="UPDATE reedition_facture SET id_request='".$id_request."' WHERE  numFactNorm='".$_SESSION['initial_fiche']."'";
					$update=mysqli_query($con,$query);
				}
					//Faire des rollbacks ici
				for($k=0;$k<count($_SESSION['Listcompte']);$k++)
				//if(isset($_SESSION['num']))
				{
					 $sql="SELECT compte.somme AS somme,compte.due AS due,compte.np AS np,compte.date AS date FROM compte,mensuel_fiche1 WHERE mensuel_fiche1.numfiche=compte.numfiche AND compte.numfiche='".$_SESSION['Listcompte'][$k]."'";
					$result=mysqli_query($con,$sql);
					if (!$result) {
						printf("Error: %s\n", mysqli_error($con));
						exit();
					}
					while($data=mysqli_fetch_array($result)){
						$somme=isset($data['somme'])?$data['somme']:0;	$np=isset($data['np'])?$data['np']:0; $due=isset($data['due'])?$data['due']:0; $date=isset($data['date'])?$data['date']:NULL;
						//echo
						$update="UPDATE mensuel_compte SET  somme='".$somme."',due='".$due."',np='".$np."',date='".$date."' WHERE mensuel_compte.numfiche='".$_SESSION['Listcompte'][$k]."'";
						$query=mysqli_query($con,$update);
						if(!isset($_SESSION['impaye'])&&!empty($_SESSION['impaye'])){ //Sauf dans le cas de la régularisation d'une facture impayée, faire rallback
							$delete="DELETE FROM mensuel_compte  WHERE mensuel_compte.numfiche='".$_SESSION['Listcompte'][$k]."'";
							$query=mysqli_query($con,$delete);
							$delete="DELETE FROM compte  WHERE compte.numfiche='".$_SESSION['Listcompte'][$k]."'";
							$query=mysqli_query($con,$delete);
						}
					}//unset($_SESSION['Listcompte']);

					//echo  $sql="SELECT * FROM encaissement WHERE ref='".$_SESSION['num']."' AND datencaiss ='".$Jour_actuel."' AND heure_emission Like ='".$Heureactuelle.":%'";

					$select=mysqli_query($con,"SELECT numFactNorm FROM configuration_facture");
					$data=mysqli_fetch_object($select);  $numFactNorm=NumeroFacture($data->numFactNorm);

					$delete="DELETE FROM reeditionfacture2 WHERE numrecu='".$numFactNorm."'";
					//$query=mysqli_query($con,$delete);     //A décommenter

					$delete="DELETE FROM reedition_facture WHERE numFactNorm='".$numFactNorm."'";
					//$query=mysqli_query($con,$delete);      //A décommenter

					if($numFactNorm>0) $update=mysqli_query($con,"UPDATE configuration_facture SET numFactNorm=numFactNorm-1 ");

					$queryN="DELETE FROM  cloturecaisse WHERE utilisateur='".$_SESSION['login']."' AND state='0' AND DateCloture='".$Jour_actuel."'";
					$reqN = mysqli_query($con,$queryN) or die (mysqli_error($con));

					}
					//echo var_dump($_SESSION['ListEncaissement']);
				// echo $_SESSION['Tableau'][DATE];

					for($i=0;$i<count($_SESSION['ListEncaissement']);$i++)
					 {		$delete="DELETE FROM encaissement WHERE num_encaisse='".$_SESSION['ListEncaissement'][$i]."'";
					 			$query=mysqli_query($con,$delete);
								$delete="DELETE FROM mensuel_encaissement WHERE num_encaisse='".$_SESSION['ListEncaissement'][$i]."'";
		 					 	$query=mysqli_query($con,$delete);
					 }
					}
					$select=mysqli_query($con,"SELECT  max(id_request) AS id_request FROM t_mecef");
					$datap=mysqli_fetch_object($select);
					$delete="DELETE FROM t_mecef WHERE id_request='".$datap->id_request."'";
					//$query=mysqli_query($con,$delete);  //A décommenter
					$idRequest=$datap->id_request-1;
				  $update=mysqli_query($con,"ALTER TABLE t_mecef AUTO_INCREMENT='".$idRequest."'");

				 unset($_SESSION['impaye']);

				 // if(isset($_SESSION['CODE_REPONSE'])&& ($_SESSION['CODE_REPONSE']=="TOTALTTC-NOK")&& ($MSG_REPONSE=="LE MONTANT TOTAL TTC DE LA FACTURE NON VALIDE"))
				 // {
					//  $sql="SELECT MAX(id_request) AS  id_request FROM t_mecef";
					//  $query=mysqli_query($con,$sql);$data=mysqli_fetch_object($query);
					//  $id_request=$data->id_request;
				 //
					//  $query="SELECT requestjson,responsjson FROM t_mecef WHERE id_request='".$id_request."'";
					//  $res1=mysqli_query($con,$query);
					//  if(mysqli_num_rows($res1)>0){
					// 		 $data=mysqli_fetch_object($res1);
					// 		 $result = array (); $result0 = array ();
					// 		 $result = json_decode($data->responsjson); $result0 = json_decode($data->requestjson);
				 //
					// 		 $TC_MCF   = isset($result->TC_MCF)?$result->TC_MCF:NULL;
					// 		 $NIM_MCF ="ED04001173-".$TC_MCF;
				 //
					// 		 $jsonDataT = array(
					// 			"CLE_SERVICEKEY" => isset($result0->CLE_SERVICEKEY)?$result0->CLE_SERVICEKEY:NULL,
					// 			"ID_DUVENDEUR" => isset($result0->ID_DUVENDEUR)?$result0->ID_DUVENDEUR:NULL,
					// 			"NOM_DUVENDEUR" => isset($result0->NOM_DUVENDEUR)?$result0->NOM_DUVENDEUR:NULL ,
					// 			"IFU_DUCLIENT"=> isset($result0->IFU_DUCLIENT)?$result0->IFU_DUCLIENT:NULL,
					// 			"NOM_DUCLIENT"=> isset($result0->NOM_DUCLIENT)?$result0->NOM_DUCLIENT:NULL,
					// 			"AIB_DUCLIENT"=> isset($result0->AIB_DUCLIENT)?$result0->AIB_DUCLIENT:NULL,
					// 			"REF_FACTAREMB"=>$NIM_MCF,
					// 			"EXPORTATION"=>false,
					// 			"MENTION_COPIE"=>false,
					// 			"TOTAL_TTCFACT"=>NULL,
					// 			"PA_LPAIEMENT"=>isset($result0->PA_LPAIEMENT)?$result0->PA_LPAIEMENT:NULL,
					// 			"MP_MONTANTPAYE"=>NULL,
					// 			"TAXE_A"=>"",
					// 			"TAXE_B"=>"",
					// 			"TAXE_C"=>"",
					// 			"TAXE_D"=>"",
					// 			"PRODUITMCF" => isset($result0->PRODUITMCF)?$result0->PRODUITMCF:NULL
					// 		 );
					// 		 $jsonData = json_encode($jsonDataT) ;
					// 		 $query="INSERT INTO  t_mecef VALUES (NULL,'".$jsonData."','0','',NULL,NULL,NULL)";
					// 		 $res1=mysqli_query($con,$query); }
					// 	 }
		}
		unset($_SESSION['CODE_REPONSE']);
?>
