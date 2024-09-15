<?php

		if(isset($_SESSION['sal']))			
			{
				if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) $post_S2="location.etatsortie='OUI' AND compte1.due>0" ; else $post_S2="location.etatsortie='NON' AND compte1.due<=0";
			}
		if(isset($_SESSION['groupe']))
			 echo $sql="SELECT GrpeTaxation,ttva,ttax,compte1.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1,salle.nomch, compte1.tarif,compte1.ttc_fixeR,compte1.ttc_fixe,compte1.np, compte1.typeoccup,  location.datarriv,compte1.nuite,compte1.somme AS somme
			FROM client, location, salle, compte1 WHERE location.numcli_1 = client.numcli
			 AND codegrpe='".$_SESSION['code_reel']."' AND ".$post_S2;
		else
			 echo $sql="SELECT GrpeTaxation,ttva,ttax,compte1.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, salle.nomch, compte1.tarif, compte1.ttc_fixeR,compte1.ttc_fixe,compte1.np,compte1.typeoccup, location.datarriv,compte1.nuite,compte1.somme AS somme
			FROM client, location, salle, compte1 WHERE location.numcli_1 = client.numcli
			AND  location.numfiche='".$_SESSION['num']."' AND ".$post_S2;
			$res=mysqli_query($con,$sql);
		while ($ret=mysqli_fetch_array($res))
			{$num_fiche=$ret['numfiche'];  $num1=$ret['num1']; $nom1=$ret['nom1']; $prenom1=$ret['prenom1']; $num2=$ret['num2'];$nom2=$ret['nom2']; $nomch=$ret['nomch']; $tarif=$ret['tarif'];
			 $tva=$ret['tarif']*$ret['ttva'];
			 $ttc_fixe=$ret['ttc_fixe']; $np=$ret['np']; $taxe=$ret['ttax']; $typeoccup=$ret['typeoccup']; $datarriv=$ret['datarriv']; $nuite=$ret['nuite'];$somme=$ret['somme'];//$ttc=$ret['ttc'];
			}
 		$reqsel=mysqli_query($con,"SELECT num_fact,numFactNorm FROM configuration_facture");
		$data=mysqli_fetch_object($reqsel);		$NumFact=NumeroFacture($data->num_fact);  $numFactNorm=NumeroFacture($data->numFactNorm);
		
		$taxe=0;

		if(isset($_SESSION['cham'])){
			if(isset($_SESSION['groupe']))
			  $sql="SELECT GrpeTaxation,ttva,ttax,N_reel,compte1.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, salle.nomch, compte1.tarif,compte1.ttc_fixeR,compte1.ttc_fixe,compte1.np,compte1.N_reel AS N_reel,compte1.typeoccup, location.datarriv,compte1.nuite,compte1.somme AS somme
			FROM client, location, salle, compte1
			WHERE location.codegrpe LIKE '".$_SESSION['groupe']."'
			AND salle.numch = compte1.numch
			AND compte1.numfiche = location.numfiche
			AND location.datarriv
			BETWEEN '".$_SESSION['ladate1']."'
			AND '".$_SESSION['ladate2']."' AND ".$post0;
			else
			  $sql="SELECT GrpeTaxation,ttva,ttax,N_reel,compte1.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, salle.nomch, compte1.tarif, compte1.ttc_fixeR,compte1.ttc_fixe,compte1.np,compte1.N_reel AS N_reel,compte1.typeoccup, location.datarriv,compte1.nuite,compte1.somme AS somme
			FROM client, location, salle, compte1
			WHERE location.numcli_1 = client.numcli
			AND location.numfiche LIKE '".$_SESSION['num']."'
			AND salle.numch = compte1.numch
			AND compte1.numfiche = location.numfiche
			AND ".$post0;

			//echo "<br/>".$sql;
			$result=mysqli_query($con,$sql);
			$data=""; $TotalTva=0;$TotalTaxe=0;  $i=0;
			if (!$result) {
				printf("Error: %s\n", mysqli_error($con));
				exit();
			}
			$TotalHT=0;$productlist=array(); $ListEncaissement=array(); $p=0; $MttaxesejourT=0; $montant_ht0=0;

			while($row=mysqli_fetch_array($result))
			{ if($row['num1']!=$row['num2'])
			   {$numcli=substr($row['num1'],0,5)." | ".substr($row['num2'],0,5);
			   $client=substr(strtoupper($row['nom1'])." ".strtoupper($row['prenom1'])." |"." ".strtoupper($row['nom2'])." ".strtoupper($row['prenom2']),0,35);}
			  else
				{ $numcli=$row['num1'];
				  $client=strtoupper($row['nom1'])." ".strtoupper($row['prenom1']);
				 }

			  $nomch=$row['nomch'];  $np=$row['np']; $type=$row['typeoccup'];
				$tarif=$row['ttc_fixe'];  $tarif_1=$row['tarif'];

				if($row['ttc_fixeR']>0) {
					$tarif=$row['ttc_fixeR'];
				}
				else {
					$tarif=$row['ttc_fixe'];
					$tarif_1=$row['tarif'];
				}

				$N_reel=$row['N_reel'];
				$n=(strtotime(date('Y-m-d'))-strtotime($row['datarriv']))/86400;
				$dat=(date('H')+1);
				settype($dat,"integer");
				if ($dat<14){$n=$n;}else {$n= $n+1;}
				if ($n==0){$n= $n+1;}
			 //$nuite=$n;
			 $n_p= $n-$np; if($n_p<0) $n_p=-$n_p;


			if(isset($numfichegrpe)&&(!empty($numfichegrpe))&&(isset($_SESSION['impaye']))&&($_SESSION['impaye']==1)) {   //Facture de groupe impayee
				$Np=$row['N_reel'];
			}else{
				 $Np=$n;	 // la variabe de session $_SESSION['Nd'] est pour le cas des impayés
				 if(isset($_SESSION['Nd'])&&($_SESSION['Nd']>0))  $Np=$_SESSION['Nd']; unset($_SESSION['Nd']);
			}
			$Nuite_Payee=$Np;

			if($row['ttc_fixeR']>0) {    //Réduction spéciale sur le prix de la salle
				//$tarif=$row['ttc_fixeR'];
				$tarif_1=round(($row['ttc_fixeR']-$taxe)/$TvaD);
			}

			//$Nuite_Payee=$_SESSION['NuitePayee'];$Np=(int)$Nuite_Payee;
			$Mtotal=$tarif*$Nuite_Payee;   $TotalHT+=$row['tarif'];
			$tarif_2=$tarif_1*$Nuite_Payee;  //$tva=round($TvaD*$tarif_2); $tva*=$Nuite_Payee;
		  $MtSpecial=$taxe; //$TotalTaxe+=$taxe;  $TotalTva+=$tva;
			 $taxei=$taxe; $taxe*=$Nuite_Payee;
			  $MttaxesejourT+=$taxe;
			//$montant_ht=$row['tarif'];  //Ne pas considérer le montant HT car le montant est déjà arrondi depuis le formulaire loccup.php

			$montant_ht= ($row['ttc_fixe'] - $taxe)/(1+$TvaD);
			$tva=0;
			if($row['ttva']!=0)$tva=round($TvaD*$montant_ht); $tva*=$Nuite_Payee;
			$montant_ht*=$Nuite_Payee;  $montant_ht=round($montant_ht);  //Ici on arrondi le montant après avoir multiplier par le total de nuitée

			$Mttaxespe = $taxe; //$Mttaxespe = $taxe/$Nuite_Payee;
			$PrixUnitaireTTC=($Mtotal/$Nuite_Payee);
			//echo "<br/>".$Mttaxespe."<br/>";
			$PrixUnitTTC=$PrixUnitaireTTC-$Mttaxespe;

			$nomch="    salle  ".strtoupper($row['nomch']); $nomch0=$nomch;

			 $TypeTxe="B"; $nomch.="  (B)"; //les factures normalisees seront taxables par defaut
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
					$nomch="    salle  ".strtoupper($row['nomch']);

			}else {
					$nomch="    salle  ".strtoupper($row['nomch']);
				 }

				 $nomch.="  (".$GrpeTaxation.")";

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

			} //else {
			//echo "<br/>".
			//$montant_ht0+=$montant_ht;
			//}

			 $List=array(
				"DESIGNPROD" => "HEBERGEMENT salle ".strtoupper($nomch0),
				"LTAXE" => $TypeTxe,
				"PRIXUNITTTC" => $PrixUnitTTC ,
				"MTTAXESPE" => "" ,
				"QUANTITE" => $Np,
				"DESCTAXESPE" => "",
			  );
				array_push($productlist,$List);

				if($_SESSION['serveurused']=="emecef")
					{	//$client=isset($_SESSION['client'])?$_SESSION['client']:$_SESSION['groupe'];
						$taxSpecific=0;//$RegimeTVA=0;
						$insert="INSERT INTO produitsencours SET Num=NULL,SIGNATURE_MCF='',Client='".$client."', LigneCde ='".$nomch0."',prix ='".$PrixUnitTTC."',qte ='".$Np."',Etat='4',GrpeTaxation='".$TypeTxe."',taxSpecific='".$taxSpecific."',RegimeTVA='".$RegimeTVA."',Type=1";
						$insertOK=mysqli_query($con,$insert);
					}

			 $taxeDeSejourT=$taxei*$Nuite_Payee;
			 $TotalTva+=$tva; $TotalTaxe+=$taxeDeSejourT;   //$Mtotal=$montantHT+$tva+$taxe; //

			 $Mtotal=$montant_ht+$tva+$taxei;   //$clientN="        ".$client;

			  if($GrpeTaxation=='E')
			 		{$PrixUnitaireTTC = (int) ($tarif);   //Mode TPS
					 $Mtotali=$PrixUnitaireTTC*$Nuite_Payee;
					 //$montant_ht0+=$PrixUnitaireTTC-$taxei;
					 $PUnitaire=($PrixUnitaireTTC-$taxei)*$Nuite_Payee;
					 $montant_ht0+=$PUnitaire;
					}
			 else
			 		{
						$PrixUnitaireTTC = (int) ($Mtotal/$Nuite_Payee);
						$montant_ht0+=$montant_ht;
					}

			//if(isset($_POST['exonorer_tva']) && ($_POST['exonorer_tva']==1)) $tva=0;
			$ecrire=fopen('txt/facture.txt',"w");
			$data.=$numcli.';'.$client.';'.$nomch.';'.$PrixUnitaireTTC.';'.$Nuite_Payee.';'.$Mtotali."\n";
			$ecrire2=fopen('txt/facture.txt',"a+");
			fputs($ecrire2,$data);

			$type=0;

			if($RegimeTVA==0) $nomch.="  (E)"; else if($row['ttva']==0) {$type=1; $nomch.="  (A-EX)";	} else { $type=2; $nomch.="  (B)";}

			//if(isset($_SESSION['groupe'])) $_SESSION['client']=$client;	//$_SESSION['client']=$client;  $_SESSION['cli']

			$recu=substr($NumFact, 0, -3);$heure=$Heure_actuelle;	 	//$Mttc+=$ttc_fixe;

			$nomch=$row['nomch'];
			//$np=$row['np'];
			$np=$Nuite_Payee;  $type=$row['typeoccup'];
			if($row['ttc_fixeR']>0) {   //Réduction spéciale sur le prix de la salle
				$ttc_fixe=$row['ttc_fixeR'];
				if($row['ttc_fixeR']<=20000) $taxe = 500; else if(($row['ttc_fixeR']>20000) && ($row['ttc_fixeR']<=100000))	$taxe = 1500; else $taxe = 2500;
				$tarif=($row['ttc_fixeR']-$taxe)/$TvaD;
			}
			else {
				$ttc_fixe=$row['ttc_fixe'];
				$tarif=$row['tarif'];
			}
			 $numfiche=$row['numfiche'];

			$req="SELECT numch,typech,GrpeTaxation,RegimeTVA  FROM salle WHERE nomch='".$nomch."'";
			$sqlB=mysqli_query($con,$req);
			while($rowB=mysqli_fetch_array($sqlB))
			{ $numch=$rowB['numch'];
			  $typech=$rowB['typech']; $GrpeTaxation=$rowB['GrpeTaxation'];
				$RegimeTVAi=$rowB['RegimeTVA'];//if($typech=="V") $typech="Ventillee";if($typech=="CL") $typech="Climatisee";
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
				$query="INSERT INTO reeditionfacture2 VALUES (NULL,'".$TypeF."','".$NumFact."','".$numfiche."','".$numch."','".$typech."','".$TypeFacture."','".$GrpeTaxation."','".$type."','".round($tarif)."','".$np."','".$RegimeTVAi."','".$ttc_fixe2."')";
				$tu=mysqli_query($con,$query);

				if(!isset($_SESSION['fiche'])){
				if(isset($_SESSION['retro'])&& ($_SESSION['retro']==1)) $np=$_SESSION['Nuitep'];
				$pos="VALUES (NULL,'".$Jour_actuel."','".$Heure_actuelle."','".$numfiche."','".$avc."','".$_SESSION['login']."','".$typeEncaisse."','".$numch."','".$type."','".$tarif_1."','".$ttc_fixe2."','".$np."')";
				$sql1="INSERT INTO mensuel_encaissement ".$pos; $sql2="INSERT INTO encaissement ".$pos;
				if(isset($_SESSION['updateBD'])&&($_SESSION['updateBD']==1)&&($np>0))
					{$en=mysqli_query($con,$sql1);$en=mysqli_query($con,$sql2);
					}

					$select=mysqli_query($con,"SELECT  max(num_encaisse) AS num_encaisse FROM encaissement");
					$datap=mysqli_fetch_object($select);
					$ListEncaissement[$p]=$datap->num_encaisse;  $p++;//Mettre en session les numeros des encaissement en vue de faire un eventuel roolback
				}
			}

		}

				if(isset($_SESSION['Fconnexe'])&&($_SESSION['Fconnexe']>0))
				{
					$sql_Connexe="SELECT * FROM fraisconnexe WHERE numfiche='".$numfiche."' AND Ferme='NON'";
					$s=mysqli_query($con,$sql_Connexe);
					$taxSpecific=0; $Ttotal=0; $HT_connexe=0;
					if($nbreresult=mysqli_num_rows($s)>0)
					{	while($retA=mysqli_fetch_array($s))
							{ 	$designation=ucfirst($retA['code']);
									$Qte =$retA['NbreUnites'];
									$PrixUnitTTC =$retA['PrixUnitaire'];
								//$PrixConnexe[$i]=$Unites*$MontantUnites; $id[$i] =$retA['id']+$i; $i++;
								//$MontantPaye =$retA['GrpeTaxation'];
									$NbreUnites =$retA['NbreUnites'];  //$Ttotali = $NbreUnites * $MontantUnites ;
									$Mtotalp=$PrixUnitTTC*$Qte;

									$Ttotal+=$Mtotalp; $montant_ht0+=$Mtotalp;

									$HT_connexe +=  $Mtotalp/1.18;  $clienti=""; $GrpeTaxation=$retA['GrpeTaxation'];

									$insert="INSERT INTO produitsencours SET Num=NULL,SIGNATURE_MCF='',Client='".$client."', LigneCde ='".$designation."',prix ='".$PrixUnitTTC."',qte ='".$Qte."',Etat='4',GrpeTaxation='".$GrpeTaxation."',taxSpecific='".$taxSpecific."',RegimeTVA='".$RegimeTVA."',Type=1";
									$insertOK=mysqli_query($con,$insert);

									$ecrire=fopen('txt/facture.txt',"w"); $designation.=" (".$GrpeTaxation.")";
									$data.=$numcli.';'.$clienti.';'.$designation.';'.$PrixUnitTTC.';'.$Qte.';'.$Mtotalp."\n";
									$ecrire2=fopen('txt/facture.txt',"a+");
									fputs($ecrire2,$data);

							}
					} $_SESSION['HT_connexe'] =	round($HT_connexe);
				}

			$_SESSION['ListEncaissement']=$ListEncaissement;		$_SESSION['Listcompte']=$Listcompte;

			if(isset($_SESSION['groupe']))
				 $_SESSION['groupe'];
			else if(isset($_SESSION['cli']))
				 $_SESSION['client']=$_SESSION['cli'] ;
			else
				 $_SESSION['client']=$client ;

			if(isset($_SESSION['N'])&&($_SESSION['N']>0)) $n=$_SESSION['N']; else  $n=$_SESSION['NuitePayee'];

		  $_SESSION['TotalHT'] = $montant_ht0; //$TotalHT = $n*$TotalHT;
			$_SESSION['TotalTva'] = $TotalTva;  //$TotalTva = $n*$TotalTva;
			$_SESSION['TotalTaxe'] = $TotalTaxe; //$TotalTaxe= $n*$TotalTaxe;

			//echo $TotalHT; ;

			if((isset($_POST['defalquer_impaye'])) && ($_POST['defalquer_impaye']==1))
			{
			}else{ //$N_reel=0;
			if(isset($_SESSION['groupe']))
				 $sql="SELECT max(compte1.N_reel) AS N_reel FROM mensuel_view_fiche2,compte1 WHERE mensuel_view_fiche2.numfiche=compte1.numfiche AND mensuel_view_fiche2.codegrpe='".$_SESSION['groupe']."' AND ".$post_0;
			else
				  $sql="SELECT compte1.N_reel AS N_reel FROM location,compte1 WHERE location.numfiche=compte1.numfiche AND location.numfiche='".$_SESSION['num']."' AND ".$post0;
			$res1=mysqli_query($con,$sql);
				while ($ret=mysqli_fetch_array($res1))
				{	$N_reel=$ret['N_reel'];
						/* if ($np>$N_reel)
						{$N_reel=$np;
						} Commentaire du 29.10.2020 */
						if ($n>$N_reel)
						{$N_reel=$n;
						}
				} if(!isset($_SESSION['fiche'])){  if((!empty($np_1))&&($np_1>0)) $N_reel-=$np_1; }

			if(isset($N_reel)&& ($N_reel>0))
			 { if($_SESSION['debut']==$Date_actuel2) $N_reel-=1; //Ce cas survient lorsque le client est venu entre 00h et 12h.
				 //echo "<br/>".
				 $_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$N_reel,date($ans)));
			   //echo "<br/>".$_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$NuiteP,date($ans)));
				 $_SESSION['finp']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$N_reel,date($ans)));
				//if($_SESSION['debut']==$Date_actuel2)
				//{

				//}$_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)-1,date($ans)));
			}

			if(isset($_SESSION['debut'])&&(isset($_SESSION['fin']))){
				//if($_SESSION['debut']==$_SESSION['fin'])  echo $_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)-1,date($ans)));
			}
			if(isset($_SESSION['groupe1']))
				$query="SELECT location.heuresortie,location.etatsortie,compte1.date,compte1.numfiche AS numfiche,compte1.np as NuiteP, compte1.somme AS SommeP,compte1.ttc_fixe, compte1.N_reel,location.datarriv
			FROM client, location, salle, compte1
			WHERE location.numcli_1 = client.numcli
			AND location.codegrpe = '".$_SESSION['groupe1']."'
			AND salle.numch = compte1.numch
			AND compte1.numfiche = location.numfiche
			AND ".$post0;
			else
				$query="SELECT location.heuresortie,location.etatsortie,compte1.date,compte1.numfiche AS numfiche,compte1.np as NuiteP, compte1.somme AS SommeP,compte1.ttc_fixe, compte1.N_reel,location.datarriv
			FROM client, location, salle, compte1
			WHERE location.numcli_1 = client.numcli
			AND location.numfiche = '".$_SESSION['num']."'
			AND salle.numch = compte1.numch
			AND compte1.numfiche = location.numfiche
			AND ".$post0;
			$sql3=mysqli_query($con,$query);
			$i=0; $nombre=array("");
			while($row_1=mysqli_fetch_array($sql3))
			{ $nombre= $row_1['numfiche'];  $NuiteP= $row_1['NuiteP'];  $heuresortie=$row_1['heuresortie'];
			    //if(isset($numfichegrpe)&&(!empty($numfichegrpe)))  //Le cas d'un groupe
					if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)){
						if($row_1['etatsortie']=='OUI')
							{
									if(!empty($row_1['date'])){
										 	$ans=substr($row_1['date'],0,4);
										    	$mois=substr($row_1['date'],5,2);
													$jour=substr($row_1['date'],8,2);
													 $_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$NuiteP,date($ans)));
									}
									else { //echo $row_1['etatsortie'];
											 $ans=substr($row_1['datarriv'],0,4);
												 $mois=substr($row_1['datarriv'],5,2);
												 $jour=substr($row_1['datarriv'],8,2);
												 $_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$NuiteP,date($ans)));
									}
								}
						//if($_SESSION['debut']==$Date_actuel2) $NuiteP-=1; //Ce cas survient lorsque le client est venu entre 00h et 12h.
						//echo "<br/>".
							//echo $row_1['datarriv'];


						//echo "<br/>".$Date_actuel2;
						//if($_SESSION['debut']==$Date_actuel2)
						//$_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)-1,date($ans)));
					}
					if(!isset($_SESSION['fin']))
					//echo "<br/>".
					$_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$NuiteP,date($ans)));
					//echo "<br/>".$_SESSION['impaye'];
				 //echo "<br/>".$_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$NuiteP,date($ans)));
				 //$req="UPDATE compte1 SET date='".$NuiteP."' WHERE numfiche='".$nombre."'";
				 if($_SESSION['debut']==$_SESSION['fin']){
					 $ans=substr($_SESSION['fin'],6,4);
					 $mois=substr($_SESSION['fin'],3,2);
					 $jour=substr($_SESSION['fin'],0,2);
					 if((substr($heuresortie,0,2)>=00)&&(substr($heuresortie,0,2)<=07) )
					 {		 $_SESSION['debut']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)-1,date($ans)));
					 }else {
								 $_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+1,date($ans)));
					 }
				 }

				 if(isset($_SESSION['fin']))
				 {$req="UPDATE compte1 SET date='".$_SESSION['fin']."' WHERE numfiche='".$nombre."'";
			   $req=mysqli_query($con,$req);}
			   $i++;  	
			}
			}
		if(isset($_SESSION['groupe']))
		$query="SELECT compte1.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1,salle.nomch, compte1.tarif,compte1.ttc_fixe,compte1.np,compte1.typeoccup,location.datarriv,compte1.nuite,compte1.somme AS somme
		FROM client, location, salle, compte1 WHERE location.numcli_1 = client.numcli
		 AND codegrpe='".$_SESSION['groupe']."' AND ".$post_S2;
		else
		$query="SELECT compte1.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, salle.nomch, compte1.tarif,compte1.ttc_fixe,compte1.np, compte1.typeoccup,location.datarriv,compte1.nuite,compte1.somme AS somme
		FROM client, location, salle, compte1 WHERE location.numcli_1 = client.numcli
		AND location.numfiche='".$_SESSION['num']."' AND ".$post_S2;

 		$sql=mysqli_query($con,$query);
		while($row=mysqli_fetch_array($sql))
			{ if($row['num1']!=$row['num2'])
			   {  $numcli=$row['num1']." | ".$row['num2'];$clientN=strtoupper($row['nom1'])." ".strtoupper($row['prenom1']);
				  $client=substr(strtoupper($row['nom1'])." ".strtoupper($row['prenom1'])." |"." ".strtoupper($row['nom2'])." ".strtoupper($row['prenom2']),0,30);}
			  else
				{ $numcli=$row['num1'];
				  $client=strtoupper($row['nom1'])." ".strtoupper($row['prenom1']);$clientN=strtoupper($row['nom1'])." ".strtoupper($row['prenom1']);
				 }
			 }

		if(empty($_SESSION['avanceA'])) $_SESSION['avanceA']=0;

		$Mtotal= $_SESSION['Mtotal']-$_SESSION['arrhes'];$avanceA = $_SESSION['avanceA'];

		if($_SESSION['modulo'] >= 0)
		{ //$Mtotal= $_SESSION['avanceA'] - $_SESSION['modulo']; $avanceA = $_SESSION['avanceA']+ $_SESSION['modulo'];

		}
		else {  $avanceA = $_SESSION['avanceA'] + $_SESSION['modulo']; //$Mtotal= $_SESSION['Mtotal'] ;
		}

		if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) {
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

		if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1))
		{unset($_SESSION['retro']);$objet='Facture impayée';}else $objet='Hébergement';

		if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) $_SESSION['retro']=1;
			$client=isset($_SESSION['client'])?$_SESSION['client']:$_SESSION['groupe'];
		$Tps=$RegimeTVA;
		if(isset($_SESSION['retro'])&& ($_SESSION['retro']==1))
			{$state=1;
				 //echo "<br/>".
				  $query="INSERT INTO reedition_facture VALUES (NULL,'".$state."','".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['login']."','0','".$NumFact1."','".$NumFactN."','0','".$client."','".$objet."','".$_SESSION['debut']."','".$_SESSION['fin']."','".$TotalTaxe."','".$TotalTva."','".$_SESSION['Tttc_fixe']."','".$remise."','".$_SESSION['modulo']."','".$avanceA."','".$Tps."')";
			 $tu=mysqli_query($con,$query); $avanceA=$_SESSION['sommePayee']; $state=2; // ici $avanceA a changé de valeur pour la suite
			if($_SESSION['sommePayee']>0) {
				  $query="INSERT INTO reedition_facture VALUES (NULL,'".$state."','".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['login']."','0','".$NumFact1."','".$NumFactN."','0','".$client."','".$objet."','".$_SESSION['debut']."','".$_SESSION['fin']."','".$TotalTaxe."','".$TotalTva."','".$_SESSION['Tttc_fixe']."','".$remise."','".$_SESSION['modulo']."','".$avanceA."','".$Tps."')";
			$tu=mysqli_query($con,$query);}
			}
		else
		{	$state=0; 		if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) $state=2;
		 if(isset($_SESSION['fin'])) {
			//echo "<br/>".
			$query="INSERT INTO reedition_facture VALUES (NULL,'".$state."','".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['login']."','0','".$NumFact1."','".$NumFactN."','0','".$client."','".$objet."','".$_SESSION['debut']."','".$_SESSION['fin']."','".$TotalTaxe."','".$TotalTva."','".$_SESSION['Tttc_fixe']."','".$remise."','".$_SESSION['modulo']."','".$avanceA."','".$Tps."')";
			$tu=mysqli_query($con,$query);}
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
		}
			
			
			if(isset($_SESSION['sal'])) include('CheckingOKS2.php');  //Traitement spécial pour Location de Salle
	if(isset($_SESSION['cham'])){
		if((isset($_POST['exonorer_tva']))||(isset($_POST['exonerer_AIB'])))
			{ header('location:facture_de_groupe1.php');
			}
		else
			{     echo 45;
		
				if((isset($_SESSION['ANNULER']))&&($_SESSION['ANNULER']==0)&&($_SESSION['verrou']==0))  //Vérifier
						{		//echo $_SESSION['Tttc_fixe']; echo "<br/>".$_SESSION['avanceA'] ;
								if($_SESSION['serveurused']=="mecef")
									include 'others/GenerateMecefBill.php';
								else{
									if(!isset($_SESSION['button_checkbox_2'])){
									@include('emecef.php');
									}
									else {
										if($RegimeTVA==0) header('location:InvoiceTPS.php');
										else header('location:FactureNormalisee.php');
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
		$_SESSION['Date_actuel']=isset($_SESSION['date_emission'])?$_SESSION['date_emission']:$Date_actuel;
		//$productlist="salle climatisée";
		$totalAmount=$_SESSION['Tttc_fixe']; //$totalAmount=$Mtotal;
		$totalpayee = $avanceA;
		$Aib_duclient="";
		//$TFacture="a";
		//if($TFacture=="v")
		if($_SESSION['serveurused']=="mecef"){
			if((isset($_SESSION['ANNULER']))&&($_SESSION['ANNULER']==0)&&($_SESSION['verrou']==0))
			$jsonData = formatData($userId,$userName,$customerIFU,$customerName,$Aib_duclient,$productlist,$totalAmount,$totalpayee);
		}
		if($_SESSION['serveurused']=="mecef"){
		if((isset($_SESSION['ANNULER']))&&($_SESSION['ANNULER']==0)&&($_SESSION['verrou']==0))
		push($jsonData);
		}
		if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) {
			if(isset($_SESSION['num'])){
				$_SESSION['req1'] ="DELETE from location  WHERE numfiche='".$_SESSION['num']."'";
				$_SESSION['req2']="DELETE from compte1  WHERE numfiche='".$_SESSION['num']."' AND due =0 ";
			}
		  //$req_=mysqli_query($con,$req1);$req_=mysqli_query($con,$req2);
		}


		//include 'JsonData.php';

		if(isset($_SESSION['debuti'])) $_SESSION['debut']=$_SESSION['debuti'];  //Pour une facture ordinaire

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
