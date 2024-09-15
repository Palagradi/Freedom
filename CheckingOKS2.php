<?php 
		if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1))
			$post_S2="location.etatsortie='OUI' AND compte1.due>0 AND location.Periode='".$_SESSION['PeriodeS']."'";
		else 
			$post_S2="location.etatsortie='NON' AND location.Periode='".$_SESSION['PeriodeS']."'";
		
		if(isset($_SESSION['groupe']))
			 $sql="SELECT DISTINCT compte1.numfiche AS numfiche,GrpeTaxation,ttva,ttax,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, salle.codesalle, compte1.tarif,compte1.ttc_fixeR,compte1.ttc_fixe,compte1.np, compte1.typeoccup,  location.datarriv,compte1.nuite,compte1.somme AS somme
			FROM client, location, salle, compte1 WHERE (location.numcli = client.numcli OR location.numcli = client.numcliS) AND codegrpe='".$_SESSION['groupe']."' AND ".$post_S2;
		else
			 $sql="SELECT DISTINCT compte1.numfiche AS numfiche,GrpeTaxation,ttva,ttax,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1,salle.codesalle, compte1.tarif, compte1.ttc_fixeR,compte1.ttc_fixe,compte1.np,compte1.typeoccup, location.datarriv,compte1.nuite,compte1.somme AS somme
			FROM client, location, salle, compte1 WHERE (location.numcli = client.numcli OR location.numcli = client.numcliS) AND location.numfiche='".$_SESSION['num']."' AND ".$post_S2;
			$res=mysqli_query($con,$sql);
		while ($ret=mysqli_fetch_array($res))
			{$num_fiche=$ret['numfiche'];  $num1=$ret['num1']; $nom1=$ret['nom1']; $prenom1=$ret['prenom1']; 
			 $codesalle=$ret['codesalle']; $tarif=$ret['tarif'];
			 $tva=$ret['tarif']*$ret['ttva'];
			 $ttc_fixe=$ret['ttc_fixe']; $np=$ret['np']; $taxe=$ret['ttax']; $typeoccup=$ret['typeoccup']; $datarriv=$ret['datarriv']; $nuite=$ret['nuite'];$somme=$ret['somme'];//$ttc=$ret['ttc'];
			}
			if (!$res) {
				printf("Error: %s\n", mysqli_error($con));
				exit();
			}
 		$reqsel=mysqli_query($con,"SELECT num_fact,numFactNorm FROM configuration_facture");
		$data=mysqli_fetch_object($reqsel);		$NumFact=NumeroFacture($data->num_fact);  $numFactNorm=NumeroFacture($data->numFactNorm);
		
		$Jour_actuel=((isset($_SESSION['impaye']))&&($_SESSION['impaye']==1))?$_SESSION['ladate1']:$Jour_actuel;

		//$sql2=mysqli_query($con,"SELECT compte1.numfiche,num1,num2,nom1,nom2,prenom1,prenom2,codesalle,compte1.np AS np,compte1.nuite,compte1.N_reel,compte1.typeoccup,compte1.ttc_fixe,datarriv,compte1.tarif FROM view_temporaire,compte1 WHERE view_temporaire.numfiche=compte1.numfiche");
			if(isset($_SESSION['groupe']))
			   //echo "1-<br/>".
			$sql="SELECT DATEDIFF('".$Jour_actuel."',datarriv) AS DiffDate,GrpeTaxation,ttva,ttax,N_reel,compte1.numfiche AS numfiche,client.numcli AS num1,client.numcliS, client.nomcli AS nom1, client.prenomcli AS prenom1,salle.codesalle, compte1.tarif,compte1.ttc_fixeR,compte1.ttc_fixe,compte1.np,compte1.N_reel AS N_reel,compte1.typeoccup, location.datarriv,compte1.nuite,compte1.somme AS somme
			FROM client, location, salle, compte1
			WHERE (location.numcli = client.numcli OR location.numcli = client.numcliS)
			AND location.codegrpe LIKE '".$_SESSION['groupe']."'
			AND salle.numsalle = compte1.numsalle
			AND compte1.numfiche = location.numfiche
			AND location.datarriv
			BETWEEN '".$_SESSION['ladate1']."'
			AND '".$_SESSION['ladate2']."' AND ".$post_S2;
			else
			 //echo "2-<br/>".
			$sql="SELECT DATEDIFF('".$Jour_actuel."',datarriv) AS DiffDate,GrpeTaxation,ttva,ttax,N_reel,compte1.numfiche AS numfiche,client.numcli AS num1,client.numcliS client.nomcli AS nom1, client.prenomcli AS prenom1,salle.codesalle, compte1.tarif, compte1.ttc_fixeR,compte1.ttc_fixe,compte1.np,compte1.N_reel AS N_reel,compte1.typeoccup, location.datarriv,compte1.nuite,compte1.somme AS somme
			FROM client, location, salle, compte1
			WHERE (location.numcli = client.numcli OR location.numcli = client.numcliS)
			AND location.numfiche LIKE '".$_SESSION['num']."'
			AND salle.numsalle = compte1.numsalle
			AND compte1.numfiche = location.numfiche
			AND ".$post_S2;

			//echo "<br/>".$sql;
			$result=mysqli_query($con,$sql);
			$data=""; $TotalTva=0;$TotalTaxe=0;  $i=0;
			if (!$result) {
				printf("Error: %s\n", mysqli_error($con));
				exit();
			}
			$TotalHT=0;$productlist=array(); $ListEncaissement=array(); $p=0; $t=0; $MttaxesejourT=0; $montant_ht0=0;  $Tnuite=array();

			while($row=mysqli_fetch_array($result))
			{ 
				$codesalle=$row['codesalle'];  $np=$row['np']; $type=$row['typeoccup'];
				$tarif=$row['ttc_fixe'];  $tarif_1=$row['tarif'];
				
				$numcli=!empty($row['numcli'])?$row['numcli']:$row['numcliS'];

				if($row['ttc_fixeR']>0) {
					$tarif=$row['ttc_fixeR'];
				}
				else {
					$tarif=$row['ttc_fixe'];
					$tarif_1=$row['tarif'];
				}

				$N_reel=$row['N_reel'];
				
				$n=($row['DiffDate']>0)?$row['DiffDate']:1;
				
				$n_p= $n-$np; if($n_p<0) $n_p=-$n_p;
				
				if($n_p<=0) $n_p=1; 

			if(isset($numfichegrpe)&&(!empty($numfichegrpe))&&(isset($_SESSION['impaye']))&&($_SESSION['impaye']==1)) {   //Facture de groupe impayee
				$Np=$row['N_reel'];$t++;
			}else{ //if(is_int($_SESSION['Nd'])) echo $_SESSION['Nd'];
				$Np=$n;	 // la variabe de session $_SESSION['Nd'] est pour le cas des impayés
				 if(isset($_SESSION['Nd'])&&($_SESSION['Nd']>0)&& is_numeric($_SESSION['Nd'])) { 
				 $Np=$_SESSION['Nd']; //unset($_SESSION['Nd']); 
					//echo 51;
				 }
				 else {	//echo 52;
					 $Np=$n_p;
					}
				$Tnuite[$t]=$Np; $t++;
			}

			if($row['ttc_fixeR']>0) {    //Réduction spéciale sur le prix de la salle
				$tarif_1=round(($row['ttc_fixeR']-$taxe)/$TvaD);
			}

			$Mtotal=$tarif*$Np;   $TotalHT+=$row['tarif'];
			$tarif_2=$tarif_1*$Np;  //$tva=round($TvaD*$tarif_2); $tva*=$Nuite_Payee;
		  $MtSpecial=$taxe; //$TotalTaxe+=$taxe;  $TotalTva+=$tva;
			 $taxei=$taxe; $taxe*=$Np;
			  $MttaxesejourT+=$taxe;
			$montant_ht= ($row['ttc_fixe'] - $taxe)/(1+$TvaD);
			$tva=0;
			if($row['ttva']!=0)$tva=round($TvaD*$montant_ht); $tva*=$Np;
			$montant_ht*=$Np;  $montant_ht=round($montant_ht);  //Ici on arrondi le montant après avoir multiplier par le total de nuitée

			$Mttaxespe = $taxe; //$Mttaxespe = $taxe/$Nuite_Payee;
			$PrixUnitaireTTC=($Mtotal/$Np);
			//echo "<br/>".$Mttaxespe."<br/>";
			 $PrixUnitTTC=$PrixUnitaireTTC-$Mttaxespe;

			$codesalle=strtoupper($row['codesalle']); $nomch0=$codesalle;

			 $TypeTxe="B"; $codesalle.="  (B)"; //les factures normalisees seront taxables par defaut
			 $TypeFacture=0;  //Changement d'etat au cas ou c'est exoneree
			 if(isset($_SESSION['groupe1']))
			  	$sql_TVA = "SELECT * FROM ExonereTVA WHERE groupe='".$_SESSION['groupe1']."' AND numfiche='".$row['numfiche']."' AND date ='".$Jour_actuel."' AND Exonere='1'";
			 else
			 	$sql_TVA = "SELECT * FROM ExonereTVA WHERE numfiche='".$row['numfiche']."' AND date ='".$Jour_actuel."' AND Exonere='1'";
			 $ras_TVA=mysqli_query($con,$sql_TVA);	$ratT=mysqli_fetch_assoc($ras_TVA);

			 if($row['GrpeTaxation']=='A') $GrpeTaxation='A-EX';else $GrpeTaxation=$row['GrpeTaxation'];
			 $TypeTxe=$row['GrpeTaxation'];
			 if(($ratT['Exonere']==1)||($row['ttva']==0)) {
				 	$TypeFacture=2; $tva=0;
					if($row['ttva']!=0) {
					$Mtotal-=$ratT['ValeurTVA']; //Exonere TVA uniquement
					$PrixUnitTTC/=(1+$TvaD);  $PrixUnitTTC=round($PrixUnitTTC);
					}
					$codesalle=" ".strtoupper($row['codesalle']);

			}else {
					$codesalle=" ".strtoupper($row['codesalle']);
				 }

				 $codesalle.="  (".$GrpeTaxation.")";

				if(isset($_SESSION['groupe1']))
					{
						$sqlT = "SELECT * FROM Applyaib WHERE groupe='".$_SESSION['groupe1']."' AND date ='".$Jour_actuel."' AND apply='1'";
						if(isset($_SESSION['Fconnexe'])&&($_SESSION['Fconnexe']>0))
						$sql_Connexe="SELECT * FROM fraisconnexe WHERE numfiche='".$_SESSION['groupe1']."' AND Ferme='NON'";
					}
				else
					{
						$sqlT = "SELECT * FROM Applyaib WHERE numfiche='".$row['numfiche']."' AND date ='".$Jour_actuel."' AND apply='1'";
						if(isset($_SESSION['Fconnexe'])&&($_SESSION['Fconnexe']>0))
						$sql_Connexe="SELECT * FROM fraisconnexe WHERE numfiche='".$row['numfiche']."' AND Ferme='NON'";
					}

				$rasT=mysqli_query($con,$sqlT);	$ratT=mysqli_fetch_assoc($rasT);
				if($ratT['apply']==1) {
				 $Aib_duclient="AIB".$ratT['Pourcentage'];
				 if($TypeFacture==2) $TypeFacture=5;  //AIB applicable TVA Exoneré
				 else $TypeFacture=4; //AIB applicable
			 }else $Aib_duclient="";

			if(isset($_SESSION['pourcent'])&&($_SESSION['pourcent']>0)){
				echo $PrixUnitTTC=$tarif-$taxe; //Exple : 8500-500;
				$PrixUnitTTC/=(1+$TvaD);
				echo "<br/>".$PrixUnitTTC=round($PrixUnitTTC);
				//$montant_ht=$PrixUnitTTC;
				echo "<br/>".$remise = $PrixUnitTTC*($_SESSION['pourcent']/100);
				echo "<br/>".$netC = $PrixUnitTTC - $remise ;
				echo "<br/>".$tvAi = round($netC*$TvaD);
				echo "<br/>".$NeTaPayer = $netC + $tvAi+$taxe;
				$tva+=$tvAi;
				echo "<br/>".$PrixUnitTTC = round($NeTaPayer) ;
				$_SESSION['end'] = "(".$_SESSION['pourcent']." %)";

			} 
			 $List=array(
				"DESIGNPROD" => "LOCATION SALLE ".strtoupper($nomch0),
				"LTAXE" => $TypeTxe,
				"PRIXUNITTTC" => $PrixUnitTTC ,
				"MTTAXESPE" => "" ,
				"QUANTITE" => $Np,
				"DESCTAXESPE" => "",
			  );
				array_push($productlist,$List);

				if($_SESSION['serveurused']=="emecef")
					{	$client=isset($_SESSION['client'])?$_SESSION['client']:$_SESSION['groupe'];
						$taxSpecific=0;//$RegimeTVA=0;
						//echo "<br/>3-". 
						 $insert="INSERT INTO produitsencours SET Num=NULL,SIGNATURE_MCF='',Client='".$client."', LigneCde ='".$nomch0."',prix ='".$PrixUnitTTC."',qte ='".$Np."',Etat='4',GrpeTaxation='".$TypeTxe."',taxSpecific='".$taxSpecific."',RegimeTVA='".$RegimeTVA."',Type=1";
						if(isset($_SESSION['view'])&&($_SESSION['view']==0)) $insertOK=mysqli_query($con,$insert);
					}
			//echo $Np;
			 $taxeDeSejourT=$taxei*$Np;
			 $TotalTva+=$tva; $TotalTaxe+=$taxeDeSejourT;   //$Mtotal=$montantHT+$tva+$taxe; //

			 $Mtotal=$montant_ht+$tva+$taxei;   //$clientN="        ".$client;

			  if($GrpeTaxation=='E')
			 		{$PrixUnitaireTTC = (int) ($tarif);   //Mode TPS
					 $Mtotali=$PrixUnitaireTTC*$Np;
					 //$montant_ht0+=$PrixUnitaireTTC-$taxei;
					 $PUnitaire=($PrixUnitaireTTC-$taxei)*$Np;
					 $montant_ht0+=$PUnitaire;
					}
			 else
			 		{
						$PrixUnitaireTTC = (int) ($Mtotal/$Np);
						$montant_ht0+=$montant_ht;
					}
			//echo "<br/>1-". $Np;

 			//if(empty($_POST['PeriodeC']))
			//$ecrire=fopen('txt/facture.txt',"r");
			//else 
			$ecrire=fopen('txt/facture.txt',"w");
			$data.=$numcli.';'.$client.';'.$codesalle.';'.$PrixUnitaireTTC.';'.$Np.';'.$Mtotali."\n";
			$ecrire2=fopen('txt/facture.txt',"a+");
			fputs($ecrire2,$data); 

			$type=0;

			if($RegimeTVA==0) $codesalle.="  (E)"; else if($row['ttva']==0) {$type=1; $codesalle.="  (A-EX)";	} else { $type=2; $codesalle.="  (B)";}

			//if(isset($_SESSION['groupe'])) $_SESSION['client']=$client;	//$_SESSION['client']=$client;  $_SESSION['cli']

			$recu=substr($NumFact, 0, -3);$heure=$Heure_actuelle;	 	//$Mttc+=$ttc_fixe;

			$codesalle=$row['codesalle'];
			//$np=$row['np'];
			$np=$Np;  $type=$row['typeoccup'];
			if($row['ttc_fixeR']>0) {   //Réduction spéciale sur le prix de la salle
				$ttc_fixe=$row['ttc_fixeR'];
				//if($row['ttc_fixeR']<=20000) $taxe = 500; else if(($row['ttc_fixeR']>20000) && ($row['ttc_fixeR']<=100000))	$taxe = 1500; else $taxe = 2500;
				$tarif=($row['ttc_fixeR']-$taxe)/$TvaD;
			}
			else {
				$ttc_fixe=$row['ttc_fixe'];
				$tarif=$row['tarif'];
			}
			 $numfiche=$row['numfiche'];

			$req="SELECT numsalle,typesalle,GrpeTaxation,RegimeTVA  FROM salle WHERE codesalle='".$codesalle."'";
			$sqlB=mysqli_query($con,$req);
			while($rowB=mysqli_fetch_array($sqlB))
			{ $numsalle=$rowB['numsalle'];
			  $typesalle=$rowB['typesalle']; $GrpeTaxation=$rowB['GrpeTaxation'];
				$RegimeTVAi=$rowB['RegimeTVA'];//if($typesalle=="V") $typesalle="Ventillee";if($typesalle=="CL") $typesalle="Climatisee";
			}
			if($np!=0)
			{	$avc=$ttc_fixe*$np; $ttc_fixe2=$ttc_fixe;

				if(isset($_SESSION['groupe1']))
					 $sql_TVA2 = "SELECT * FROM ExonereTVA WHERE groupe='".$_SESSION['groupe1']."' AND numfiche='".$numfiche."' AND date ='".$Jour_actuel."' AND Exonere='1'";
				else
					 $sql_TVA2 = "SELECT * FROM ExonereTVA WHERE numfiche='".$numfiche."' AND date ='".$Jour_actuel."' AND Exonere='1'";
					 $ValeurTVA2=0;$ras_TVA2=mysqli_query($con,$sql_TVA2);
					 $ratT2=mysqli_fetch_assoc($ras_TVA2);
					 $ttc_fixe2=$ttc_fixe-$ratT2['ValeurTVA'];  //Ici on fait le cummul des TVA pour un groupe.

				if(isset($_SESSION['Normalise'])) { $NumFact=$numFactNorm;$TypeF=3;} else $TypeF=2;  //$tarif2=$ttc_fixe2/$np;
				$query="INSERT INTO reeditionfacture2 VALUES (NULL,'".$TypeF."','".$NumFact."','".$numfiche."','".$numsalle."','".$typesalle."','".$TypeFacture."','".$GrpeTaxation."','".$type."','".round($tarif)."','".$np."','".$RegimeTVAi."','".$ttc_fixe2."')";
				if(isset($_SESSION['view'])&&($_SESSION['view']==0)) $tu=mysqli_query($con,$query);

				if(!isset($_SESSION['fiche'])){
				if(isset($_SESSION['retro'])&& ($_SESSION['retro']==1)) $np=$_SESSION['Nuitep'];
				$pos="VALUES (NULL,'".$Jour_actuel."','".$Heure_actuelle."','".$numfiche."','".$avc."','".$_SESSION['login']."','".$typeEncaisse."','".$numsalle."','".$type."','".$tarif_1."','".$ttc_fixe2."','".$np."')";
				$sql1="INSERT INTO mensuel_encaissement ".$pos; $sql2="INSERT INTO encaissement ".$pos;
				if(isset($_SESSION['updateBD'])&&($_SESSION['updateBD']==1)&&($np>0))
					{	if(isset($_SESSION['view'])&&($_SESSION['view']==0)){
						$en=mysqli_query($con,$sql1);
						$en=mysqli_query($con,$sql2);
						}
					}

					$select=mysqli_query($con,"SELECT  max(num_encaisse) AS num_encaisse FROM encaissement");
					$datap=mysqli_fetch_object($select);
					$ListEncaissement[$p]=$datap->num_encaisse;  $p++;//Mettre en session les numeros des encaissement en vue de faire un eventuel roolback
				}
			}

		}
		
		

			if($_SESSION['serveurused']=="emecef")
				{	//$client=isset($_SESSION['client'])?$_SESSION['client']:$_SESSION['groupe'];
					//taxSpecific=0;$LigneCde="TAXE DE SEJOUR";$PrixUnitTTC=$MttaxesejourT;$Np=1;$TypeTxe="F";
					//$insert="INSERT INTO produitsencours SET Num=NULL,SIGNATURE_MCF='',Client='".$client."', LigneCde ='".$LigneCde."',prix ='".$PrixUnitTTC."',qte ='".$Np."',Etat='4',GrpeTaxation='".$TypeTxe."',taxSpecific='".$taxSpecific."',RegimeTVA='".$RegimeTVA."',Type=1";
					//$insertOK=mysqli_query($con,$insert);   
				}

				if(isset($_SESSION['Fconnexe'])&&($_SESSION['Fconnexe']>0))
				{	$taxSpecific=0; $Ttotal=0; $HT_connexe=0;	
					if(isset($_SESSION['code_reel'])){
						echo $sql3="SELECT DISTINCT location.numfiche AS numfiche FROM location,fraisconnexe WHERE fraisconnexe.numfiche=location.numfiche";
						$req3 = mysqli_query($con,$sql3) or die (mysqli_error($con));
						$k=0;$ListeDesFiches = array();
						if(mysqli_num_rows($req3)>0) {
							while ($dataS= mysqli_fetch_array($req3))
								{ $ListeDesFiches[$k]=$dataS['numfiche'];$k++;
								}
						}

				for($k=0;$k<count($ListeDesFiches);$k++){
					echo $sql_Connexe="SELECT * FROM fraisconnexe WHERE (numfiche='".$ListeDesFiches[$k]."' OR numfiche='".trim($_SESSION['code_reel'])."') AND Ferme='NON'";
					$s=mysqli_query($con,$sql_Connexe);
					if($nbreresult=mysqli_num_rows($s)>0)
					{	while($retA=mysqli_fetch_array($s))
							{ 	$designation=ucfirst($retA['code']);
									$Qte =$retA['NbreUnites'];
									$PrixUnitTTC =$retA['PrixUnitaire'];
									$NbreUnites =$retA['NbreUnites'];  //$Ttotali = $NbreUnites * $MontantUnites ;
									$Mtotalp=$PrixUnitTTC*$Qte;

									$Ttotal+=$Mtotalp; $montant_ht0+=$Mtotalp;

									$HT_connexe +=  $Mtotalp/1.18;  $clienti=""; $GrpeTaxation=$retA['GrpeTaxation'];

									echo "<br/>".
									$insert="INSERT INTO produitsencours SET Num=NULL,SIGNATURE_MCF='',Client='".$client."', LigneCde ='".$designation."',prix ='".$PrixUnitTTC."',qte ='".$Qte."',Etat='4',GrpeTaxation='".$GrpeTaxation."',taxSpecific='".$taxSpecific."',RegimeTVA='".$RegimeTVA."',Type=1";
									if(isset($_SESSION['view'])&&($_SESSION['view']==0)) $insertOK=mysqli_query($con,$insert);
									
									$update="UPDATE fraisconnexe SET Ferme='OUI' WHERE numfiche='".$ListeDesFiches[$k]."'";
									if(isset($_SESSION['view'])&&($_SESSION['view']==0)) $updateOK=mysqli_query($con,$update);

						 			//if(empty($_POST['PeriodeC']))
									//$ecrire=fopen('txt/facture.txt',"r");
									//else 
									$ecrire=fopen('txt/facture.txt',"w");
									$designation.=" (".$GrpeTaxation.")";
									$data.=$numcli.';'.$clienti.';'.$designation.';'.$PrixUnitTTC.';'.$Qte.';'.$Mtotalp."\n";
									$ecrire2=fopen('txt/facture.txt',"a+");
									fputs($ecrire2,$data); 

							}
						} $_SESSION['HT_connexe'] =	round($HT_connexe);
					}
					}else {
					$sql3="SELECT fiche1.numfiche AS numfiche,GrpeTaxation,id,code,NbreUnites,PrixUnitaire FROM fiche1,fraisconnexe WHERE fraisconnexe.numfiche = fiche1.numfiche  AND numfiche='".$_SESSION['num']."' AND fraisconnexe.Ferme='NON'";
					$req3 = mysqli_query($con,$sql3) or die (mysqli_error($con));
					//$taxSpecific=0; $Ttotal=0; $HT_connexe=0;	
						if(mysqli_num_rows($req3)>0){ 
						while ($retA= mysqli_fetch_array($req3))
							{  	
								$designation=ucfirst($retA['code']);
								$Qte =$retA['NbreUnites'];
								$PrixUnitTTC =$retA['PrixUnitaire'];
								$NbreUnites =$retA['NbreUnites']; 
								$Mtotalp=$PrixUnitTTC*$Qte;
								$Ttotal+=$Mtotalp; $montant_ht0+=$Mtotalp;
								$HT_connexe +=  $Mtotalp/1.18;  $clienti=""; $GrpeTaxation=$retA['GrpeTaxation'];
								//echo "<br/><br/>".
								$insert="INSERT INTO produitsencours SET Num=NULL,SIGNATURE_MCF='',Client='".$client."', LigneCde ='".$designation."',prix ='".$PrixUnitTTC."',qte ='".$Qte."',Etat='4',GrpeTaxation='".$GrpeTaxation."',taxSpecific='".$taxSpecific."',RegimeTVA='".$RegimeTVA."',Type=1";
								if(isset($_SESSION['view'])&&($_SESSION['view']==0)) $insertOK=mysqli_query($con,$insert);

								$update="UPDATE fraisconnexe SET Ferme='OUI' WHERE numfiche='".$retA['numfiche']."'";
								if(isset($_SESSION['view'])&&($_SESSION['view']==0))$updateOK=mysqli_query($con,$update);
									
		 			 			//if(empty($_POST['PeriodeC']))
								//$ecrire=fopen('txt/facture.txt',"r");
								//else 
								$ecrire=fopen('txt/facture.txt',"w");
								$designation.=" (".$GrpeTaxation.")";
								$numclip=isset($numcli)?$numcli:NULL;
								$data.=$numclip.';'.$clienti.';'.$designation.';'.$PrixUnitTTC.';'.$Qte.';'.$Mtotalp."\n";
								$ecrire2=fopen('txt/facture.txt',"a+");
								fputs($ecrire2,$data);  
							}
						}	
					}
				}
			$_SESSION['ListEncaissement']=$ListEncaissement;		$_SESSION['Listcompte']=$Listcompte;

/* 			if(isset($_SESSION['groupe']))
				 $_SESSION['groupe'];
			else if(isset($_SESSION['cli']))
				 $_SESSION['client']=$_SESSION['cli'] ;
			else
				 $_SESSION['client']=$client ; */

			if(isset($_SESSION['N'])&&($_SESSION['N']>0)) $n=$_SESSION['N']; else  $n=$_SESSION['NuitePayee'];

			$_SESSION['TotalHT'] = $montant_ht0; //$TotalHT = $n*$TotalHT;
			$_SESSION['TotalTva'] = $TotalTva;  //$TotalTva = $n*$TotalTva;
			$_SESSION['TotalTaxe'] = $TotalTaxe; //$TotalTaxe= $n*$TotalTaxe;

			//echo $TotalHT; ;

			if((isset($_POST['defalquer_impaye'])) && ($_POST['defalquer_impaye']==1))
			{
			}else{ 
/* 			
			if(isset($_SESSION['groupe']))
				 $sql="SELECT np,datarriv,max(compte1.N_reel) AS N_reel FROM location,compte1 WHERE location.numfiche=compte1.numfiche AND location.codegrpe='".$_SESSION['groupe']."' AND ".$post_S2;
			else
				  $sql="SELECT np,datarriv,compte1.N_reel AS N_reel FROM location,compte1 WHERE location.numfiche=compte1.numfiche AND location.numfiche='".$_SESSION['num']."' AND ".$post_S2;
			$res1=mysqli_query($con,$sql);
				while ($ret=mysqli_fetch_array($res1))
				{	
					//$N_reel=$ret['N_reel'];
					$n=(strtotime(date('Y-m-d'))-strtotime($ret['datarriv']))/86400;
					$dat=(date('H')+1);
					settype($dat,"integer");
					if ($dat<14){$n=$n;}else {$n= $n+1;}
					if ($n==0){$n= $n+1;}
				 //$nuite=$n;
					 $n_p= $np; //$n_p= $n-$np;
					 if($n_p<=0) $n_p=1; //$n_p=-$np;
						if ($n>$N_reel)
						{$N_reel=$n;
						}
				 $N_reel=$n-$ret['np'];	$N_reel--;	echo $N_reel;
						
				} //if(!isset($_SESSION['fiche'])){  if((!empty($np_1))&&($np_1>0)) $N_reel-=$np_1; } */
				

			if(isset($_SESSION['debut'])&&(isset($_SESSION['fin']))){
				//if($_SESSION['debut']==$_SESSION['fin'])  echo $_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)-1,date($ans)));
			}
			if(isset($_SESSION['groupe1']))
				$query="SELECT location.heuresortie,location.etatsortie,compte1.date,compte1.numfiche AS numfiche,compte1.np as NuiteP, compte1.somme AS SommeP,compte1.ttc_fixe, compte1.N_reel,location.datarriv
			FROM client, location, salle, compte1
			WHERE (location.numcli = client.numcli OR location.numcli = client.numcliS)
			AND location.codegrpe = '".$_SESSION['groupe1']."'
			AND salle.numsalle = compte1.numsalle
			AND compte1.numfiche = location.numfiche
			AND ".$post_S2;
			else
				$query="SELECT location.heuresortie,location.etatsortie,compte1.date,compte1.numfiche AS numfiche,compte1.np as NuiteP, compte1.somme AS SommeP,compte1.ttc_fixe, compte1.N_reel,location.datarriv
			FROM client, location, salle, compte1
			WHERE (location.numcli = client.numcli OR location.numcli = client.numcliS)
			AND location.numfiche = '".$_SESSION['num']."'
			AND salle.numsalle = compte1.numsalle
			AND compte1.numfiche = location.numfiche
			AND ".$post_S2;
			$sql3=mysqli_query($con,$query);
			$i=0; $nombre=array("");
			while($row_1=mysqli_fetch_array($sql3))
			{ 		$nombre= $row_1['numfiche'];  
		
					$NuiteP= $row_1['NuiteP'];  

					$_SESSION['debut']=substr($row_1['datarriv'],8,2).'-'.substr($row_1['datarriv'],5,2).'-'.substr($row_1['datarriv'],0,4);

				if(isset($_SESSION['fin']))
				 {$req="UPDATE compte1 SET date='".$_SESSION['fin']."' WHERE numfiche='".$nombre."'";
				    if(isset($_SESSION['view'])&&($_SESSION['view']==0)) $req=mysqli_query($con,$req);
				  		
					$Dsortie= substr($_SESSION['fin'],6,4).'-'.substr($_SESSION['fin'],3,2).'-'.substr($_SESSION['fin'],0,2);
					$query="UPDATE location SET datsortie='".$Dsortie."' WHERE numfiche= '".$nombre."'";
					if(isset($_SESSION['view'])&&($_SESSION['view']==0)) $update=mysqli_query($con,$query);
				  
				  
				  }
			   $i++;  	
			}
			}
		if(isset($_SESSION['groupe']))
		$query="SELECT compte1.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, salle.codesalle, compte1.tarif,compte1.ttc_fixe,compte1.np,compte1.typeoccup,location.datarriv,compte1.nuite,compte1.somme AS somme
		FROM client, location, salle, compte1 WHERE (location.numcli = client.numcli OR location.numcli = client.numcliS) AND codegrpe='".$_SESSION['groupe']."' AND ".$post_S2;
		else
		$query="SELECT compte1.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, salle.codesalle, compte1.tarif,compte1.ttc_fixe,compte1.np, compte1.typeoccup,location.datarriv,compte1.nuite,compte1.somme AS somme
		FROM client, location, salle, compte1 WHERE (location.numcli = client.numcli OR location.numcli = client.numcliS) AND location.numfiche='".$_SESSION['num']."' AND ".$post_S2;

 		$sql=mysqli_query($con,$query);
		while($row=mysqli_fetch_array($sql))
			{
				  //$numcli=$row['num1'];
				  //$client=strtoupper($row['nom'])." ".strtoupper($row['prenom']);

			 }

		if(empty($_SESSION['avanceA'])) $_SESSION['avanceA']=0;
		$Mtotal= $_SESSION['Mtotal']-$_SESSION['arrhes'];$avanceA = $_SESSION['avanceA'];

		if($_SESSION['modulo'] >= 0)
		{ //$Mtotal= $_SESSION['avanceA'] - $_SESSION['modulo']; $avanceA = $_SESSION['avanceA']+ $_SESSION['modulo'];

		}
		else {  $avanceA = $_SESSION['avanceA'] + $_SESSION['modulo']; //$Mtotal= $_SESSION['Mtotal'] ;
		}

		if(($_SESSION['NormSencaisser']==0)&&(isset($_SESSION['impaye']))) {
			$_SESSION['modulo']=0;
			$_SESSION['Mtotal']=$_SESSION['avanceA'];
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
		$NumFact1=0;$NumFactN=0;

		if(isset($_SESSION['Normalise'])) { $NumFactN=$numFactNorm;$_SESSION['initial_fiche']=$numFactNorm; } else { $NumFact1=$NumFact; $_SESSION['initial_fiche']=$NumFact;}

		if(isset($_SESSION['groupe1']))
			 $sql_TVA = "SELECT * FROM ExonereTVA WHERE groupe='".$_SESSION['groupe1']."' AND numfiche='".$row['numfiche']."' AND date ='".$Jour_actuel."' AND Exonere='1'";
		else
			 $sql_TVA = "SELECT * FROM ExonereTVA WHERE numfiche='".$row['numfiche']."' AND date ='".$Jour_actuel."' AND Exonere='1'";
		$ras_TVA=mysqli_query($con,$sql_TVA);
		//if($ras_TVA['Exonere']==1) {
			$ValeurTVA=0;
			while($ratT=mysqli_fetch_array($ras_TVA)){
					$ValeurTVA+=$ratT['ValeurTVA'];  //Ici on fait le cummul des TVA pour un groupe.
			}
			 $avanceA-=$ratT['ValeurTVA'];
		//}

		$_SESSION['TotalTTC'] = $Mtotal; $remise=!empty($_SESSION['remise'])?$_SESSION['remise']:0;

		$ValAIB=isset($_SESSION['ValAIB'])?$_SESSION['ValAIB']:0;
			if(isset($_SESSION['impaye']))
			$_SESSION['Tttc_fixe'] =  $_SESSION['Mtotal'];
		else
			$_SESSION['Tttc_fixe']=$Tttc_fixe+$ValAIB;

		//if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1))
		//{unset($_SESSION['retro']);$objet='Facture impayée';}else $objet='Hébergement';
		
		if(isset($_SESSION['cham'])&&($_SESSION['cham']==1)) $objet='Hébergement'; else $objet='Location de salle';

		//if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) $_SESSION['retro']=1;
			//$client=isset($_SESSION['client'])?$_SESSION['client']:$_SESSION['groupe'];
			
		if(isset($_SESSION['solde'])&&($_SESSION['solde']== 1)) $avanceA=0;	
			
		$Tps=$RegimeTVA;
		if(isset($_SESSION['retro'])&& ($_SESSION['retro']==1))
			{$state=1;
				 //echo "<br/>".
				 			 
			$query="INSERT INTO reedition_facture VALUES (NULL,'".$state."','".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['login']."','0','".$NumFact1."','".$NumFactN."','0','".$client."','".$objet."','".$_SESSION['debut']."','".$_SESSION['fin']."','".$TotalTaxe."','".$TotalTva."','".$_SESSION['Tttc_fixe']."','".$remise."','".$_SESSION['modulo']."','".$avanceA."','".$Tps."')";
			 $tu=mysqli_query($con,$query); $avanceA=$_SESSION['sommePayee']; $state=2; // ici $avanceA a changé de valeur pour la suite
			if($_SESSION['sommePayee']>0) {
			$query="INSERT INTO reedition_facture VALUES (NULL,'".$state."','".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['login']."','0','".$NumFact1."','".$NumFactN."','0','".$client."','".$objet."','".$_SESSION['debut']."','".$_SESSION['fin']."','".$TotalTaxe."','".$TotalTva."','".$_SESSION['Tttc_fixe']."','".$remise."','".$_SESSION['modulo']."','".$avanceA."','".$Tps."')";
			if(isset($_SESSION['view'])&&($_SESSION['view']==0)) $tu=mysqli_query($con,$query);
			}
			}
		else
		{	$state=0; 		if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) $state=2;
		 if(isset($_SESSION['fin'])) {
			//echo "<br/>".
			$query="INSERT INTO reedition_facture VALUES (NULL,'".$state."','".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['login']."','0','".$NumFact1."','".$NumFactN."','0','".$client."','".$objet."','".$_SESSION['debut']."','".$_SESSION['fin']."','".$TotalTaxe."','".$TotalTva."','".$_SESSION['Tttc_fixe']."','".$remise."','".$_SESSION['modulo']."','".$avanceA."','".$Tps."')";
			if(isset($_SESSION['view'])&&($_SESSION['view']==0)) $tu=mysqli_query($con,$query);}
		}
		

		if($_SESSION['Tttc_fixe']!=$_SESSION['avanceA']) $_SESSION['ANNULER']=1;else $_SESSION['ANNULER']=0;

		if(isset($_SESSION['groupe1'])&&(!empty($_SESSION['groupe1'])))
			$sql = "SELECT NumIFU,adressegrpe AS adresse,contactgrpe AS TelClt,email AS Email FROM groupe WHERE  codegrpe = '".trim($_SESSION['groupe'])."'";
		else
			$sql = "SELECT nomcli,prenomcli,NumIFU,adresse,Telephone AS TelClt,Email AS Email  FROM client WHERE numcli LIKE '".trim($_SESSION['Numclt'])."'";

			$res = mysqli_query($con, $sql) or die (mysqli_error($con));
			$data =  mysqli_fetch_assoc($res);	$_SESSION['NumIFU']=$data['NumIFU']; $_SESSION['AdresseClt']=$data['adresse'];

			$_SESSION['TelClt']=$data['TelClt'];
			$_SESSION['EmailClt']=isset($data['EmailClt'])?$data['EmailClt']:NULL;

			$_SESSION['numFactN']=$NumFactN;  
			
			$_SESSION['client'] = isset($_SESSION['groupe'])?$_SESSION['groupe']:$client;
			
//-----------------------------	

/* 		if((isset($_POST['exonorer_tva']))||(isset($_POST['exonerer_AIB'])))
			{ header('location:facture_de_groupe1.php');
			}
		else
			{     
			if((isset($_SESSION['ANNULER']))&&($_SESSION['ANNULER']==0)&&($_SESSION['verrou']==0))  //Vérifier
				{	 */	
				
				//echo $_SESSION['Tttc_fixe']; echo "<br/>".$_SESSION['avanceA'] ;
						if($_SESSION['serveurused']=="mecef")
							include 'others/GenerateMecefBill.php';
						else{
							if(!isset($_SESSION['button_checkbox_2'])){
								//if(empty($_POST['PeriodeC'])) $_SESSION['objet']=utf8_decode("Hébergement & Location");
							 	if(isset($_SESSION['view'])&&($_SESSION['view']==0)){
									@include('emecef.php');
								}
								else {   $_SESSION['initial_fiche']="00000/".date('Y');
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
							else {
								if($RegimeTVA==0) header('location:InvoiceTPS.php');
								else header('location:FactureNormalisee.php');
							}
							}
					//}
			//}							
			
	?>	