<?php
				$mode=isset($_GET['mode'])?$_GET['mode']:"Espèce";
				$echeance=isset($_GET['echeance'])?$_GET['echeance']:$Date_actuel;
				$_SESSION['modeReglement']=isset($_GET['mode'])?$_GET['mode']:"Espèces";
				if(isset($_GET['vis'])||isset($_GET['visr']))
				{
					$resT=mysqli_query($con,"SELECT SUM(prix*qte) AS somme FROM  produitsencours WHERE Client ='".$Numclt."'");
					$reXt=mysqli_fetch_assoc($resT);  $somme=$reXt['somme']; $sommeP=$somme; $tva=$TvaD*$somme; $remise=0;

					$update=mysqli_query($con,"UPDATE ConfigEcono SET num_fact=num_fact+1 ");
					$reqsel=mysqli_query($con,"SELECT num_fact FROM ConfigEcono");
					$data2=mysqli_fetch_assoc($reqsel);$numFact=$data2['num_fact'];
					if(($numFact>=0)&&($numFact<=9))$numFact='000'.$numFact ;else if(($numFact>=10)&&($numFact<=99))$numFact='00'.$numFact ;else if(($numFact>=100)&&($numFact<=999)) $numFact='0'.$numFact ;else $numFact=$numFact;
					$numFact.="/".substr(date('Y'),2,2);

					$sqlA = "SELECT DISTINCT (produitsencours.Num) AS Num FROM produitsencours,Clients WHERE
					(produitsencours.Client=Clients.Num OR produitsencours.Client=Clients.RaisonSociale)
					AND  Etat = 1 AND produitsencours.Client ='".$_GET['clt']."'";
					mysqli_query($con,"SET NAMES 'utf8' ");
					$query = mysqli_query($con, $sqlA);$i=0;$tab=array();
					while($data=mysqli_fetch_array($query)){
						$tab[$i]=$data['Num']; $i++;
			  	}

					//$req="INSERT INTO factureeconomat SET Num=NULL,Nums='".$data."',date_emission='".$Jour_actuel."',heure_emission='".$Heure_actuelle."',num_facture='".$numFact."',Client='".$Numclt."',tva='".$tva."', montant_ttc='".$somme."',Remise='".$remise."',somme_paye='".$sommeP."',ModePayement='".$mode."',Echeance='".$echeance."',Signature='1' ";
					//$query = mysqli_query($con,$req) or die (mysqli_error($con));
					$sql="UPDATE produitsencours SET Etat='2' WHERE  Client ='".$Numclt."' AND  Etat = 1";
					$req=mysqli_query($con,$sql) or die(mysqli_error($con));
				}else {
					//echo $sql="UPDATE produitsencours SET Etat='3' WHERE  Etat = 1 AND Client ='".$_GET['clt']."'";
					//$req=mysqli_query($con,$sql) or die(mysqli_error($con));
				}

				$sqlA = "SELECT DISTINCT (produitsencours.Num),clients.NomClt AS Client,clients.NumIFU,clients.AdresseClt,clients.TelClt,RaisonSociale,produitsencours.GrpeTaxation,taxSpecific,RegimeTVA,produits.Designation AS LigneCde,produitsencours.prix,produitsencours.qte
				FROM produitsencours,Clients,produits WHERE produits.Num=produitsencours.LigneCde AND
				(produitsencours.Client=Clients.Num OR produitsencours.Client=Clients.RaisonSociale)
				AND  Etat = 2 AND produitsencours.Client ='".$_GET['clt']."'";
				mysqli_query($con,"SET NAMES 'utf8' ");
				$query = mysqli_query($con, $sqlA);
				if(mysqli_num_rows($query)==0){
					$sqlA = "SELECT DISTINCT (produitsencours.Num),clients.NomClt AS Client,clients.NumIFU,clients.AdresseClt,clients.TelClt,RaisonSociale,produitsencours.GrpeTaxation,taxSpecific,RegimeTVA,produits.Designation AS LigneCde,produitsencours.prix,produitsencours.qte
					FROM produitsencours,Clients,produits WHERE produits.Num=produitsencours.LigneCde AND
					(produitsencours.Client=Clients.Num OR produitsencours.Client=Clients.RaisonSociale)
					AND  Etat = 4 AND produitsencours.Client ='".$_GET['clt']."'";
					mysqli_query($con,"SET NAMES 'utf8' ");
					$query = mysqli_query($con, $sqlA);
				}
				$num=0;$data0="";$Mtotal=0; $TotalHT=0; $TotalTva=0;$TotalTva0=0;
				while($data=mysqli_fetch_array($query)){ $num++;
				$customerIFU=$data['NumIFU']; if($customerIFU==0) $customerIFU=0;
				$userName=!empty($data['RaisonSociale'])?$data['RaisonSociale']:$data['Client'];
				$_SESSION['AdresseClt']=!empty($data['AdresseEn'])?$data['AdresseEn']:$data['AdresseClt'];
				$_SESSION['TelClt']=!empty($data['TelEn'])?$data['TelEn']:$data['TelClt'];
				if($data['GrpeTaxation']=='A') $GrpeTaxation="A-EX";
				else if($data['GrpeTaxation']=='B') $GrpeTaxation="B";
				else if($data['GrpeTaxation']=='F') $GrpeTaxation="F";
				else $GrpeTaxation="E";

				$LigneCde=$data['LigneCde'];

				$LigneCde=$LigneCde." (".$GrpeTaxation.")";
				$prix=$data['prix'];
				$qte=$data['qte'];
				$mt=$prix*$qte; $Mtotal+=$mt ;
				$TotalHT0=round(($prix/1.18)*$qte) ;
				if($data['RegimeTVA']==1){
					//$TotalHT0=round($Mtotal/1.18) ;
					$TotalTva0=round(($Mtotal/1.18)*0.18) ;
				}
				//else
				if($GrpeTaxation=="E"){
					$TotalHT0=$Mtotal ;
				}else{
					//$TotalHT0=$Mtotal ;
					$TotalTva0=0 ;
					$prix=round($prix/1.18) ;
					$mt=$prix*$qte;
				}

				$TotalHT+=$TotalHT0 ;  $TotalTva+=$TotalTva0 ;

				$ecrire=fopen('txt/facture.txt',"w");
				$data0.=$LigneCde.';'.$prix.';'.$qte.';'.$mt."\n";
				$ecrire2=fopen('txt/facture.txt',"a+");
				fputs($ecrire2,$data0);
			}

			 $_SESSION['objet']=utf8_decode("VENTE DE PRODUITS") ;
			 //$_SESSION['avanceA']=0;$_SESSION['userId']="" ;
			 $_SESSION['TotalTTC']=$Mtotal; $_SESSION['Mtotal']=$Mtotal;  $_SESSION['TotalTaxe']=1000;
			 $_SESSION['TotalHT']= $Mtotal  ;  	 //$_SESSION['TotalHT']= $TotalHT  ;
			 $_SESSION['TotalTva']= $TotalTva;
			 $_SESSION['NumIFU']=isset($customerIFU)?$customerIFU:NULL;//$_SESSION['NumIFU']="3234567891235";
			 $_SESSION['client']=isset($userName)?$userName:NULL;
			 //$_SESSION['client']="BOUKARI Abdel Malick";
			 $_SESSION['vendeur']=$_SESSION['nom']." ".ucfirst(strtolower($_SESSION['prenom']));
			 //$_SESSION['vendeur']="ALIHONOU Elvie"; //$_SESSION['code']=1;
			 $_SESSION['Date_actuel']=$Date_actuel;
			 $_SESSION['FV']=1; // Pour facture de vente

				$pk=0;

				 $_SESSION['norm']=isset($_GET['norm'])?$_GET['norm']:0;
				 $_SESSION['print']=isset($_GET['print'])?$_GET['print']:0;
				 if((isset($_GET['state'])&&($_GET['state']==1))||(isset($_GET['vis']))||(isset($_GET['visr'])))
					 { if(!isset($_GET['visr'])){
						 		for($j=0;$j<count($tab);$j++){
									$sql="UPDATE produitsencours SET Etat='1' WHERE  Etat = 2 AND produitsencours.Num ='".$tab[$j]."'";
									//$sql="UPDATE produitsencours SET Etat='1' WHERE  Etat = 2 AND Client ='".$_GET['clt']."'";
	 	 							$req=mysqli_query($con,$sql) or die(mysqli_error($con));
								}
								}
								if(isset($_GET['visr'])){
										if(isset($_GET['dato'])){
											include('emecef.php');
										}
										 else //{
												include('receiptH.php');
												for($j=0;$j<count($tab);$j++){
													$sql="UPDATE produitsencours SET Etat='1' WHERE  Etat = 2 AND produitsencours.Num ='".$tab[$j]."'";
													$req=mysqli_query($con,$sql) or die(mysqli_error($con));
												}
											//}
								}
								else
										{  if(isset($_GET['id_request']))  {
														$sqlA = "SELECT Montant,operateur,clients From e_mecef WHERE id_request='".$_GET['id_request']."'";
														$query = mysqli_query($con, $sqlA);$data=mysqli_fetch_object($query);
														$Montant = explode("-",$data->Montant);
														$operateur = explode("-",$data->operateur);
														$clients = explode("-",$data->clients);
														$_SESSION['TotalHT']=isset($Montant['0'])?$Montant['0']:0;
														$_SESSION['TotalTTC']=isset($Montant['1'])?$Montant['1']:0;
														$_SESSION['NumIFU']=isset($clients['0'])?$clients['0']:NULL;
														$_SESSION['client']=isset($clients['1'])?$clients['1']:NULL;
												}
											echo "<center><iframe src='facture1.php"; echo "?date=".$Date_actuel."&echeance=".$echeance."&mode=".$mode; if(isset($_GET['clt'])) echo "&clt=".$_GET['clt'];   echo "' width='1000' height='800' style=''></iframe><center>";
										}
					 }
				 else if((isset($_GET['state'])&&($_GET['state']==2)) || (isset($_GET['dato'])))
				 {
					 if($_SESSION['serveurused']=="emecef"){

										@include('emecef.php');

									 if(isset($receipt)&&($receipt==0)){ //echo 12;
											//echo "<iframe src='.php";  echo "' width='1000' height='800' scrolling='no' allowtransparency='true' FRAMEBORDER='yes' style='margin-left:5%;margin-top:-25px;'></iframe>";
									 }
								}else {
									echo "<iframe src='checkingOK.php";  echo "' width='1000' height='800' scrolling='no' allowtransparency='true' FRAMEBORDER='yes' style='margin-left:10%;margin-top:-25px;'></iframe>";
								}

		 }
