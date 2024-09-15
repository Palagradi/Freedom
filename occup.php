<?php
	include 'menu.php';  	include 'others/footerpdf.inc'; //echo $_SESSION['Numclt'];

	$numero=isset($_SESSION['numero'])?$_SESSION['numero']:NULL; unset($_SESSION['groupe']); unset($_SESSION['code_reel']);
	unset($_SESSION['TotalHT']);unset($_SESSION['TotalTva']);unset($_SESSION['TotalTaxe']);unset($_SESSION['TotalTTC']);
	unset($_SESSION['N']);unset($_SESSION['retro']); unset($_SESSION['reimprime']); unset($_SESSION['Nd']); //unset($_SESSION['num']);
	$numfiche=!empty($_GET['numfiche'])?$_GET['numfiche']:NULL;   unset($_SESSION['Numreserv']); unset($_SESSION['Foriginal1']);unset($_SESSION['Foriginal2']);
	if(isset($_SESSION['numreservation'])){$res=mysqli_query($con,"SELECT numfiche  FROM exonerer_tva WHERE numfiche='".$_SESSION['numreservation']."'");
		$ret=mysqli_fetch_assoc($res);
		 $numfiche_1=$ret['numfiche'];
		}

	$res=mysqli_query($con,"SELECT Categorie FROM fiche1,client WHERE fiche1.numcli_1=client.numcli AND numfiche='".$numfiche."'");
	$reC=mysqli_fetch_assoc($res);  $Categorie=$reC['Categorie'];

	unset($_SESSION['QRCODE_MCF']);unset($_SESSION['COMPTEUR_MCF']);unset($_SESSION['DT_HEURE_MCF']);unset($_SESSION['NIM_MCF']);
	unset($_SESSION['SIGNATURE_MCF']);unset($_SESSION['IFU_MCF']);unset($_SESSION['CODE_REPONSE']);


	$DateCloture=$Jour_actuel;
	$query="SELECT * FROM  cloturecaisse WHERE state='0'";
	$req1 = mysqli_query($con,$query) or die (mysqli_error($con));
	while($close=mysqli_fetch_array($req1)){
		$Heure= $close['Heure']; $utilisateur= $close['utilisateur'];
		$DateCloture=$close['DateCloture'];
	}

	//echo $DateCloture; echo "-".$Jour_actuel;

$query2="SELECT * FROM  cloturecaisse WHERE state='1' AND DateCloture='".$Jour_actuel."'";
$req2 = mysqli_query($con,$query2) or die (mysqli_error($con));
$close2=mysqli_fetch_assoc($req2);	 $Heure= isset($close2['Heure'])?$close2['Heure']:NULL;

//$res=mysqli_query($con,"SELECT pourcentage,Application FROM categorieclient WHERE  NomCat='".$Categorie."'");
//$reC=mysqli_fetch_assoc($res);  $pourcentage=$reC['pourcentage'];  $Application=$reC['Application'];


//Code commenté ce 04/05/2016  --------- A revoir----------

/* $sql=mysqli_query($con,"SELECT chambre.numch,chambre.nomch,reserverch.typeoccuprc,reserverch.tarifrc,reserverch.ttc,reserverch.nuite_payee FROM reserverch,chambre WHERE chambre.numch=reserverch.numch AND numresch='".$_SESSION['numreservation']."' AND chambre.numch NOT IN (SELECT numch  FROM compte WHERE numfiche='".$_SESSION['num']."') ORDER BY typeoccuprc LIMIT 1");
while ($data= mysqli_fetch_array($sql))
	{	$numch=$data['numch'];
		//$nomch=$data['nomch'];
		$typeoccuprc=$data['typeoccuprc'];
		$tarifrc=$data['tarifrc'];
		if(empty($numfiche_1))
		$ttc1=$data['ttc'];
		else
		{if($data['typeoccuprc']=='individuelle')
			$ttc1=$data['tarifrc']+1000;else $ttc1=$data['tarifrc']+2000;}
		$nuite_payee=$data['nuite_payee'];
	} */


	if (isset($_POST['VALIDER'])&& $_POST['VALIDER']=='VALIDER')
		{ 	if(empty($_POST['edit28']))
				echo "<script>alert(\"Etes vous sûr de vouloir enregistrer la fiche sans l'imposition de la taxe sur nuitée au client?\")</script>";
			//echo 'onclick="if(!confirm(\'Voulez-vous vraiment continuer?\')) return false;"';
				//else if(empty($_POST['edit29']))
				//echo "<script>alert(\"Etes vous sûr de vouloir enregistrer la fiche sans l'imposition de la TVA au client?\")</script>";
			else{
				//if(mysqli_num_rows($req1)==0){
				if(((mysqli_num_rows($req1)>0)&&($DateCloture==$Jour_actuel)&&(mysqli_num_rows($req2)<=0)) ||
				((mysqli_num_rows($req1)<=0)&&($DateCloture==$Jour_actuel)&&(mysqli_num_rows($req2)<=0)) || ($_POST['edit30']<=0) || ($_POST['edit30']=="")){
			if($_POST['edit30']>0)
				{$avance=isset($_SESSION['advance'])?$_SESSION['advance']:0;
				  $difference=$_POST['edit33']-$_POST['arrhes'];
					//$npp=$difference/($_POST['edit26']/$_POST['edit23']);
					if($_POST['edit32']>0) $npp=$_POST['edit32']; else $npp=0;//$npp=$_POST['edit3_2'];
					$_SESSION['pre']=$npp;
					$_SESSION['npp']=$_POST['edit32'];
				}
	    $_SESSION['MontantApayer']=$_POST['edit26']/$_POST['edit23'];
			$_SESSION['avance']=0; $date=$Jour_actuel; // date('Y-m-d');
		  $arrhes=$_POST['arrhes'];$etat_10=1;$date1=$Date_actuel2; //date('d-m-Y');
			$_SESSION['arrhes']=$_POST['arrhes'];
			$_SESSION['edit33']=$_POST['edit33'];
			$ttc_fixe=$_POST['edit26']/$_POST['edit23']; //$_SESSION['receip']=1;
			//$ttc_fixe2=$_POST['edit33']/$_POST['edit23'];
			$_SESSION['ttc']=$_POST['edit26']; $_SESSION['edit23']=$_POST['edit23'];
			$_SESSION['numch']=$_POST['combo3'];$_SESSION['remise']=$_POST['reduction'];
			$_SESSION['NuitePayee']=$_POST['edit32'];
			$reduction=!empty($_POST['reduction'])?$_POST['reduction']:0;
			$_SESSION['reduction']=$reduction;

			$ret="SELECT * FROM mensuel_fiche1, mensuel_compte WHERE mensuel_fiche1.numfiche=mensuel_compte.numfiche and numch='".$_POST['combo3']."' and etatsortie='NON' ";
			$ret1=mysqli_query($con,$ret);
			$ret2=mysqli_fetch_array($ret1);
			if ($ret2)
			{
				if (($ret2['datarriv']==$Jour_actuel) and ($ret2['typeoccup'])=='double')
				//if (($ret2['datarriv']==date('Y-m-d')) and ($ret2['typeoccup'])=='double')
				{
					//$reta=mysqli_query($con,"INSERT INTO compte VALUES ('".$_SESSION['num']."', '".$_POST['combo3']."', '".$_POST['combo4']."', '0', '0','0','', '0','0','0','0','0','0','0','0','0','','')");
					if($nbre==1){$_SESSION['advance']='';
						{$update=mysqli_query($con,"UPDATE compte SET due=0  WHERE numfiche='".$numero."'");
						 $update=mysqli_query($con,"UPDATE mensuel_compte SET due=0  WHERE numfiche='".$numero."'");
						}
					if($_POST['combo4']=='individuelle') header('location:fiche.php?menuParent=Hébergement'); 	//else header('location:fiche2.php?menuParent=Hébergement');
					}
				}
				else
				{
					echo "<script language='javascript'>alert('Cette chambre est occupée');</script>";
				}
			} else
			{
				$heure=(date('H')); $minuite=(date('i'));
				if(($heure>=05)||($heure<=12))
					$_SESSION['np']=$_POST['edit32'];
				else
					$_SESSION['np']=$_POST['edit32']-1;
				if($_SESSION['np']==0) $_SESSION['np']=1;
				//$_SESSION['nuit']=$_POST['edit28']/$_SESSION['Nuite'] *$_SESSION['np'];   //Commentaire du 20.07.2020
				$_SESSION['nuit']=$_POST['edit28']/$_POST['edit23'];
				$_SESSION['tch']=$_POST['edit22']; $_SESSION['occup']=$_POST['combo4'];
				$_SESSION['tarif']=$_POST['edit24'];$_SESSION['mt']=$_POST['edit25'];
				$edit28=$_POST['edit28'];$edit23=$_POST['edit23'];$edit32=$_POST['edit32'];$edit29=$_POST['edit29'];
				$_SESSION['taxe']=$_POST['edit28']; $_SESSION['taxe1']=($edit28/$edit23)*$edit32;
				$_SESSION['tva']=$edit29/$_SESSION['Nuite'] *$_SESSION['np']; //$_SESSION['tva']=$combo6; //
				$_SESSION['tva1']=$edit29/$_SESSION['Nuite'] *$_POST['edit32']; $_SESSION['edit26']=$_POST['edit26'];
				//$_SESSION['ttc']=$_POST['edit26'];
				if($_POST['Mtotal']==0)
					$_SESSION['somme']=$_POST['edit26'];
				else
					$_SESSION['somme']=$_POST['edit30'];
					$_SESSION['due']=$_POST['edit31']; $_SESSION['edit_25']=$_POST['edit_25']; $avance=$_POST['arrhes'];
				 $date=$Jour_actuel; //date('Y-m-d');
				 if($_POST['edit23']!=0) $taxeU=$_POST['edit28']/$_POST['edit23'];
				 //if($_POST['edit33'] > $_POST['edit26']) {
					 if($ttc_fixe!=0) $modulo=$_POST['edit33'] % $ttc_fixe;  if($ttc_fixe>$_POST['edit33']) $modulo=$_POST['edit33'];
				 //}
				// else  {if($_POST['edit33']!=0) $modulo=  $_POST['edit26'] % $_POST['edit33']; }
				$_SESSION['modulo'] = $modulo;  $edit30=$_POST['edit30']-$modulo ;   //$_SESSION['Mtotal'] = $_POST['Mtotal'];

				if($_POST['edit42']==0) //Non assujetti à la TVA
					$combo6=0; else $combo6=$_POST['combo6'];

				//enregistrement du compte
				if($_POST['edit33']!=0)
				{ $somme=$_POST['edit33']; 		//if($modulo > 0)   //$somme=$ttc_fixe*$_POST['edit32'];
					$np_avance=!empty($_SESSION['np_avance'])?$_SESSION['np_avance']:0;
					if(empty($_POST['edit32']))
						{
							if(isset($_POST['button_checkbox_1'])) $NuitePayeeE = 0; else  $NuitePayeeE = $np_avance; //echo 1;

							$post="VALUES ('".$_SESSION['num']."','".$_POST['combo3']."','".$_POST['combo4']."','".$_POST['edit24']."','".$_POST['edit23']."',0,'".$taxeU."','".$combo6."','".$reduction."','0','".$ttc_fixe."','".$somme."',0,'".$NuitePayeeE."','".$NuitePayeeE."','".$date1."')";
							$sql="INSERT INTO compte ".$post ;$reto=mysqli_query($con,$sql);
							$retoA=mysqli_query($con,"INSERT INTO mensuel_compte ".$post );

						 //$retoA=mysqli_query($con,"INSERT INTO mensuel_compte VALUES ('".$_SESSION['num']."','".$_POST['combo3']."','".$_POST['combo4']."','".$_POST['edit24']."','".$_POST['edit23']."',NULL,'".$_POST['edit25']."','".$taxeU."','".$_POST['edit28']."','".$combo6."','".$_POST['edit29']."','".$_POST['edit26']."','$ttc_fixe','$somme',NULL,'".$np_avance."','".$np_avance."','".$date1."')");
						}
				  else
						{ if(isset($_POST['button_checkbox_1'])) $NuitePayeeE = 0; else  $NuitePayeeE = $_POST['edit32']; //echo 4;

						$post="VALUES ('".$_SESSION['num']."','".$_POST['combo3']."','".$_POST['combo4']."','".$_POST['edit24']."','".$_POST['edit23']."',0,'".$taxeU."','".$combo6."','".$reduction."','0','$ttc_fixe','".$_POST['edit33']."','0','".$NuitePayeeE."','".$NuitePayeeE."','".$date1."')";
						$sql="INSERT INTO compte ".$post;
						$reto=mysqli_query($con,$sql);
						$sql="INSERT INTO mensuel_compte ".$post ;
						$retoA=mysqli_query($con,$sql);

						 //$retoA=mysqli_query($con,"INSERT INTO mensuel_compte VALUES ('".$_SESSION['num']."','".$_POST['combo3']."','".$_POST['combo4']."','".$_POST['edit24']."','".$_POST['edit23']."',NULL,'".$_POST['edit25']."','".$taxeU."','".$_POST['edit28']."','".$combo6."','".$_POST['edit29']."','".$_POST['edit26']."','$ttc_fixe','".$_POST['edit33']."','0','".$_POST['edit32']."','".$np_avance."','".$date1."')");
						}
				  $etat=1;
				  if($_POST['arrhes']!=0)
						{$update=mysqli_query($con,"UPDATE compte SET due=0 WHERE numfiche='".$_SESSION['num']."'");
						 $updateA=mysqli_query($con,"UPDATE mensuel_compte SET due=0 WHERE numfiche='".$_SESSION['num']."'");
						}
				  if(!empty($_POST['exhonerer']) && ($_POST['exhonerer']==1))
						$sql=mysqli_query($con,"INSERT INTO exonerer_tva VALUES('".$date."','".$_SESSION['num']."')");

				  if($_POST['edit33']==($somme+$_POST['Fconnexe']))
						{/* $_SESSION['Fconnexe']=$_POST['Fconnexe'];
						$s=mysqli_query($con,"SELECT *  FROM connexe,fraisconnexe WHERE connexe.id = fraisconnexe.id and fraisconnexe.numfiche='".$_SESSION['num']."' AND Ferme='NON'");
						$ret1=mysqli_fetch_array($s);$NomFraisConnexe =$ret1['NomFraisConnexe'];$NbreUnites=$ret1['NbreUnites'];$NomFraisConnexeC ="Frais connexes à l'hébergement";
						$en=mysqli_query($con,"INSERT INTO encaissement VALUES (NULL,'".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['num']."','".$_POST['Fconnexe']."','".$_SESSION['login']."','$NomFraisConnexeC','','','".$_POST['Fconnexe']."','".$_POST['Fconnexe']."','$NbreUnites')");
						$en1=mysqli_query($con,"INSERT INTO mensuel_encaissement VALUES (NULL,'".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['num']."','".$_POST['Fconnexe']."','".$_SESSION['login']."','$NomFraisConnexeC','','','".$_POST['Fconnexe']."','".$_POST['Fconnexe']."','$NbreUnites')");
						$deB=mysqli_query($con,"UPDATE fraisconnexe SET MontantPaye='".$_POST['Fconnexe']."', Ferme='OUI' WHERE numfiche='".$_SESSION['num']."'"); */
						}

					$sql=mysqli_query($con,"INSERT INTO chambre_tempon VALUES('".$_SESSION['num']."')");

					$insert=1;
				 }
				else
				   { $edit32=!empty($_POST['edit32'])?$_POST['edit32']:0;  $edit33=!empty($_POST['edit33'])?$_POST['edit33']:0;  //if($modulo > 0)  $edit33-=$modulo ;
						if(!empty($_SESSION['np_avance']))
						    {
								if(isset($_POST['button_checkbox_1'])) $NuitePayeeE = 0; else  $NuitePayeeE = $_SESSION['np_avance'];  //echo 2;

								$post="VALUES ('".$_SESSION['num']."','".$_POST['combo3']."','".$_POST['combo4']."','".$_POST['edit24']."','".$_POST['edit23']."','','".$taxeU."','".$combo6."','".$reduction."','0','".$ttc_fixe."','".$somme."','','".$NuitePayeeE."','".$NuitePayeeE."','".$date1."')";
								$reto=mysqli_query($con,"INSERT INTO compte ".$post);
								$sql="INSERT INTO mensuel_compte ".$post;$retoA=mysqli_query($con,$sql);
								 //$retoA=mysqli_query($con,"INSERT INTO mensuel_compte VALUES ('".$_SESSION['num']."','".$_POST['combo3']."','".$_POST['combo4']."','".$_POST['edit24']."','".$_POST['edit23']."','','".$_POST['edit25']."','".$taxeU."','".$_POST['edit28']."','".$combo6."','".$_POST['edit29']."','".$_POST['edit26']."','$ttc_fixe','$somme','','".$_SESSION['np_avance']."','".$_SESSION['np_avance']."','".$date1."')");
							}

					else
							{	if(isset($_POST['button_checkbox_1'])) $NuitePayeeE = 0; else  $NuitePayeeE = $edit32;   //echo 3;

								$post="VALUES ('".$_SESSION['num']."','".$_POST['combo3']."','".$_POST['combo4']."','".$_POST['edit24']."','".$_POST['edit23']."',0,'".$taxeU."','".$combo6."','".$reduction."','0','$ttc_fixe','".$edit33."',NULL,'".$NuitePayeeE."','0','')";
								$reto=mysqli_query($con,"INSERT INTO compte ".$post);
								$sql="INSERT INTO mensuel_compte ".$post;
								$retoA=mysqli_query($con,$sql);
							 //$retoA=mysqli_query($con,"INSERT INTO mensuel_compte VALUES ('".$_SESSION['num']."','".$_POST['combo3']."','".$_POST['combo4']."','".$_POST['edit24']."','".$_POST['edit23']."',NULL,'".$_POST['edit25']."','".$taxeU."','".$_POST['edit28']."','".$combo6."','".$_POST['edit29']."','".$_POST['edit26']."','$ttc_fixe','".$edit33."',NULL,'".$edit32."','0','')");
							}
				  $etat=1;

					$insert=1;

				  if(!empty($_POST['exhonerer']) && ($_POST['exhonerer']==1))
					$sql=mysqli_query($con,"INSERT INTO exonerer_tva VALUES('".$date."','".$_SESSION['num']."')");


				//Ligne de code inséré ce 03/05/2016
					//header('location:fiche.php?menuParent=Hébergement');
				}
				if(isset($_SESSION['numreservation'])){
					$res=mysqli_query($con,"SELECT numfiche  FROM exonerer_tva WHERE numfiche='".$_SESSION['numreservation']."'");
				    while($ret=mysqli_fetch_array($res))
					{ $numfiche_1=$ret['numfiche'];
					}
				$sql=mysqli_query($con,"SELECT chambre.numch,chambre.nomch,chambre.typech,reserverch.typeoccuprc,reserverch.tarifrc,reserverch.ttc,reserverch.nuite_payee FROM reserverch,chambre WHERE EtatChambre='active' AND  chambre.numch=reserverch.numch AND numresch='".$_SESSION['numreservation']."' AND chambre.numch NOT IN (SELECT numch  FROM compte WHERE numfiche='".$_SESSION['num']."') ORDER BY typeoccuprc LIMIT 1");
					while ($data= mysqli_fetch_array($sql))
					{	$numch=$data['numch'];
						$nomch=$data['nomch'];
						$typech=$data['typech'];
						$typeoccuprc=$data['typeoccuprc'];
						$tarifrc=$data['tarifrc'];
						if(empty($numfiche_1))
						$ttc1=$data['ttc'];
						else
						{if($data['typeoccuprc']=='individuelle')
						$ttc1=$data['tarifrc']+1000;else $ttc1=$data['tarifrc']+2000;}
						$nuite_payee=$data['nuite_payee'];
						$numresch=$data['numresch'];
					}
					$nbre=mysqli_num_rows($sql);
				 }

					if($_POST['arrhes']!=0)
					{$update=mysqli_query($con,"UPDATE compte SET due=0 WHERE numfiche='".$_SESSION['numero']."'");
					 $updateA=mysqli_query($con,"UPDATE mensuel_compte SET due=0 WHERE numfiche='".$_SESSION['numero']."'");
					}
					if(($_POST['arrhes']==0)||(empty($_POST['arrhes']))){ $_SESSION['recufiche']=1;
						if($_POST['combo4']=='double'){
							//Commentaire 1
						  header('location:fiche.php?menuParent=Hébergement&db=1');
						 }
					}

				if ($insert==1)
				{    $sql=mysqli_query($con,"INSERT INTO client_tempon  VALUES ('".$_POST['combo3']."')");
					 if(isset($_SESSION['numreserv']))
						{$update=mysqli_query($con,"UPDATE reservationch SET avancerc=0  WHERE numresch='".$_SESSION['numreserv']."'");
						 $update2=mysqli_query($con,"UPDATE reserverch SET avancerc=0  WHERE numresch='".$_SESSION['numreserv']."'");
						 if(!empty($_SESSION['numreservation']))
					$ret=mysqli_query($con,"INSERT INTO reservation_tempon VALUES ('$date1','".$_SESSION['numreservation']."')");
						}
				//echo $modulo."<br/>".$_SESSION['somme'];

					if ($_SESSION['somme']!=0)
					{	 if(isset($modulo) && ($modulo>0))	// Le client a payé un montant qui ne correspond pas à une nuité
							{ $pos=" VALUES (NULL,'".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['num']."','".$modulo."','".$_SESSION['login']."','Entree chambre','".$_POST['combo3']."','".$_POST['combo4']."','".$_POST['edit24']."','$ttc_fixe','0')";
							$en=mysqli_query($con,"INSERT INTO encaissement ".$pos); $enA=mysqli_query($con,"INSERT INTO mensuel_encaissement ".$pos);
							 //$enA=mysqli_query($con,"INSERT INTO mensuel_encaissement VALUES (NULL,'".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['num']."','".$modulo."','".$_SESSION['login']."','Entree chambre','".$_POST['combo3']."','".$_POST['combo4']."','".$_POST['edit24']."','$ttc_fixe','0')");
							 //$req="INSERT INTO nombre_nuitees VALUES ('".$Jour_actuel."','".$_POST['combo3']."','".$_POST['combo4']."','".$_POST['edit32']."')";
							//$en1=mysqli_query($con,$req);
							}

						if(isset($npp))
							{if($npp>0)
								{$pos="VALUES (NULL,'".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['num']."','".$edit30."','".$_SESSION['login']."','Entree chambre','".$_POST['combo3']."','".$_POST['combo4']."','".$_POST['edit24']."','".$ttc_fixe."','".$npp."')";
								$en=mysqli_query($con,"INSERT INTO encaissement ".$pos); $enA=mysqli_query($con,"INSERT INTO mensuel_encaissement ".$pos);

								 $req= "INSERT INTO nombre_nuitees VALUES ('".date('Y-m-d')."','".$_POST['combo3']."','".$_POST['combo4']."','".$npp."')"; $en1=mysqli_query($con,$req);

								 $update=mysqli_query($con,"UPDATE compte SET due=0  WHERE numfiche='".$numero."'");
								 $update=mysqli_query($con,"UPDATE `mensuel_compte SET due=0  WHERE numfiche='".$numero."'");
								}
							 $_SESSION['recufiche']=1;unset($_SESSION['advance']);

							if(isset($_POST['button_checkbox_2'])) $invoice=1; else if(isset($_POST['button_checkbox_3'])) $invoice=2; else $invoice=0;

							 $_SESSION['avanceA']=$_POST['edit33'];

							 $_SESSION['fiche']=1; $_SESSION['Mtotal'] = $ttc_fixe * $_POST['edit32'];	 $_SESSION['n']=$_POST['edit23'];

								if($_POST['combo4']=='individuelle')
									{  if(isset($_POST['button_checkbox_2']))
											{   $update=mysqli_query($con,"UPDATE configuration_facture SET num_fact=num_fact+1 ");
												echo "<iframe src='checkingOK.php";  echo "' width='1000' height='800' style='margin-left:15%;'></iframe>";
												//echo $_SESSION['modulo'];	//echo $_SESSION['Mtotal'];
												//echo 12;
											}
										else if(isset($_POST['button_checkbox_3'])) { $_SESSION['Normalise']=1; $_SESSION['retro']=1;
												$update=mysqli_query($con,"UPDATE configuration_facture SET numFactNorm=numFactNorm+1");
												$_SESSION['sommePayee'] = $_POST['edit33'];
												echo "<iframe src='checkingOK.php";  echo "' width='1000' height='800' style='margin-left:15%;'></iframe>";

											}
										else
										 {
											$modulo=$_POST['edit33']; $_SESSION['modulo']=$modulo; //$_SESSION['sommeArrhes']=$modulo;

/* 											$query = "VALUES (NULL,'".$Jour_actuel."','".$Heure_actuelle."','".$numfiche."','".$modulo."','".$_SESSION['login']."','Facture de groupe','".$_POST['numch']."','".$_POST['typeoccup']."','".$_POST['tarif']."','".$ttc_fixe."','0')";
											$InsertA=mysqli_query($con,"INSERT INTO encaissement ".$query); $InsertB=mysqli_query($con,"INSERT INTO mensuel_encaissement ".$query); */

											$query="SET somme=somme+'".$modulo."'  WHERE numfiche='".$numfiche."'";
											$reqA=mysqli_query($con,"UPDATE mensuel_compte ".$query);$reqB=mysqli_query($con,"UPDATE compte ".$query);
											echo "<script language='javascript'>";
											echo 'alertify.success(" Encaissement effectué avec succès.");';
											echo "</script>";

											$update=mysqli_query($con,"UPDATE configuration_facture SET numrecu=numrecu+1 ");
											//header('location:recufiche.php?menuParent=Hébergement');
											$_SESSION['nature'] = 'Hébergement';
											echo "<iframe src='receiptH.php";  echo "' width='600' height='675' scrolling='no' allowtransparency='true' FRAMEBORDER='yes' style='margin-left:30%;margin-top:-25px;'></iframe>";
										 }
									}
								if($_POST['combo4']=='double')
									 { $update=mysqli_query($con,"UPDATE configuration_facture SET num_fact=num_fact+1 ");
										header('location:fiche.php?menuParent=Hébergement&db=1&invoice='.$invoice);
									 }
							}
					    //else

					}  else {
							$_SESSION['recufiche']=1;
							if($_POST['combo4']=='individuelle') {
	/* 						echo "<script language='javascript'>";
							echo 'swal("Cette action est irréversible. Voulez-vous continuer ?", {
							  dangerMode: true, buttons: true,
							}).then((value) => { var Es = value;  document.location.href="occup.php?menuParent='.$_SESSION['menuParenT'].'&test="+Es;
							}); ';
							echo "</script>"; */
							 header('location:fiche.php?menuParent=Hébergement');
							}
						else {
							 header('location:fiche.php?menuParent=Hébergement&db=1');
							}
					}
			}
		}

		}else if((mysqli_num_rows($req1)==0)&&($DateCloture==$Jour_actuel)){
			echo "<script language='javascript'>";
			echo "var Heure = '".$Heure."';";
			echo 'alertify.error("Encaissement impossible. La caisse a déjà été clôturée pour le compte de ce jour à "+Heure+".");';
			echo "</script>";

		}else {
					$DateCloture=substr($DateCloture,8,2).'-'.substr($DateCloture,5,2).'-'.substr($DateCloture,0,4);
					echo "<script language='javascript'>";
					echo "var date = '".$DateCloture."';"; echo "var utilisateur = '".ucfirst($utilisateur)."';";
					//echo 'alertify.error("Encaissement impossible. La caisse a déjà été clôturée.");';
					echo 'alertify.error("Encaissement impossible. L\'agent "+utilisateur+" n\'a pas encore été clôturé sa caisse en date du "+date+" .");';
					echo "</script>";
			}
	}
}

?>


<?php
	$s=mysqli_query($con,"SELECT * FROM connexe,fraisconnexe WHERE connexe.id = fraisconnexe.id and fraisconnexe.numfiche='".$numfiche."' AND Ferme='NON'");
	if($nbreresult=mysqli_num_rows($s)>0)
	{while($ret1=mysqli_fetch_array($s))
		{ 	$NomFraisConnexe =$ret1['NomFraisConnexe'];
			$Unites =$ret1['Unites'];
			$MontantUnites =$ret1['MontantUnites'];
			$NbreUnites =$ret1['NbreUnites'];   $Ttotal = $NbreUnites * $MontantUnites ;
		}
	}

	//echo '<meta http-equiv="refresh" content="1; url=chambre.php?p=1" />';

		//$MTtotal=$_GET['due']+ $Ttotal;

	// $PourcentAIB=5;

?>

<html>
	<head>
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script type="text/javascript" src="js/verifyCheckBoxes1.js"></script>
		<style>
			.alertify-log-custom {
				background: blue;
			}
		.bouton2 {
			border-radius:12px 0 12px 0;
			background: white;
			border:2px solid #B1221C;
			color:#B1221C;
			font:bold 12px Verdana;
			height:auto;font-family:cambria;font-size:0.9em;
		}
		.bouton2:hover{color:white;
			cursor:pointer;background-color: #B1221C;border:2px solid #B1221C;
		}
		select,input[type=text],input[type=number],input[type=date],textarea{
			width : 100%;
			border :1px solid #ccc;
			border-radius: 4px;
			-webkit-box-sizing:border-box;
			-moz-box-sizing:border-box;
			-mos-box-sizing:border-box;
			box-sizing: border-box;
			font-family:normal;
		}
		td {
			  padding: 8px 0;
			}
		</style>
		<script type="text/javascript">
		function action2(){

		if(document.getElementById("edit22").value=='')
		{alertify.error("Impossible d\'exonérer la TVA à cette étape. Veuillez sélectionner d\'abord la chambre et le type d\'occupation. ");
		var timeout = setTimeout(
		function() {
			document.getElementById("button_checkbox1").checked = false;
			}
		,1500);
		}

		 if (document.getElementById("edit26").value!='') {
						//document.getElementById('edit26').value =document.getElementById("edit26").value-document.getElementById("edit29").value;
						if (document.getElementById("edit26").value==document.getElementById("edit_25").value)
							document.getElementById('edit26').value = parseFloat(document.getElementById("edit_25").value)+parseFloat(document.getElementById("edit29").value);
						else
							document.getElementById('edit26').value =document.getElementById("edit_25").value;
				}

		}
		function AffT()
		{
			//if (document.getElementById("edit23").value!='')
			//{
				document.getElementById("edit25").value= (('\t'+document.getElementById("edit24").value)*document.getElementById("edit23").value).toFixed(4);
			//}
		}
		function Aff()
		{
			if (document.getElementById("edit23").value!='')
			{
				document.getElementById("edit25").value= (('\t'+document.getElementById("edit24").value)*document.getElementById("edit23").value).toFixed(4);
			}
		}
		function Aff5()
		{
			if (document.getElementById("edit25").value!='')
			{
				document.getElementById("edit_25").value=parseFloat(document.getElementById("edit_25").value)+parseFloat(document.getElementById("edit25").value);
			}
		}
		function Aff1()
		{
			if (document.getElementById("edit23").value!='')
			{   if ((document.getElementById("combo4").value=='individuelle')||(document.getElementById("edit_28").value==1))
				{document.getElementById("edit28").value=document.getElementById("edit23").value*document.getElementById('combo5').options[document.getElementById('combo5').selectedIndex].value;
				//document.getElementById("edit26").value=(parseFloat(document.getElementById("edit28").value)+parseFloat(document.getElementById("edit25").value)).toFixed(4);
				document.getElementById("edit26").value=Math.ceil(parseFloat(document.getElementById("edit28").value)+parseFloat(document.getElementById("edit25").value));
				document.getElementById("Mtotal").value=Math.round(parseFloat(document.getElementById("edit28").value)+parseFloat(document.getElementById("edit25").value)+parseFloat(document.getElementById("Fconnexe").value));
				}
				else
				{document.getElementById("edit28").value=document.getElementById("edit_28").value*document.getElementById("edit23").value*document.getElementById('combo5').options[document.getElementById('combo5').selectedIndex].value;
				//document.getElementById("edit26").value=(parseFloat(document.getElementById("edit28").value)+parseFloat(document.getElementById("edit25").value)).toFixed(4);
				document.getElementById("edit26").value=Math.ceil(parseFloat(document.getElementById("edit28").value)+parseFloat(document.getElementById("edit25").value));
				document.getElementById("Mtotal").value=Math.round(parseFloat(document.getElementById("edit28").value)+parseFloat(document.getElementById("edit25").value)+parseFloat(document.getElementById("Fconnexe").value));
				}
			}
			//Commentaire du dimanche 18.02.2018
		 //document.getElementById("reduction").value=parseInt((document.getElementById("Pourcentage").value/100)*document.getElementById("Mtotal").value);
		 document.getElementById("TotalM").value=document.getElementById("Mtotal").value-document.getElementById("reduction").value;
		}
		function Aff2()
		{
			if (document.getElementById("edit25").value!='')
			{
				//document.getElementById("edit29").value=Math.ceil(document.getElementById("edit25").value*document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value + document.getElementById("edit28").value*document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value);
				document.getElementById("edit29").value=Math.ceil(document.getElementById("edit25").value*document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value);
				//).toFixed(4);
				document.getElementById("edit26").value=Math.round(parseFloat(document.getElementById("edit28").value)+parseFloat(document.getElementById("edit29").value)+parseFloat(document.getElementById("edit25").value)
				- (document.getElementById("edit28").value*document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value )
				);
				document.getElementById("Mtotal").value=Math.round(parseFloat(document.getElementById("edit28").value)+parseFloat(document.getElementById("edit29").value)+parseFloat(document.getElementById("edit25").value)+parseFloat(document.getElementById("Fconnexe").value));
			}
			if(document.getElementById("Pourcentage").value==1)
			{

			}else
			document.getElementById("reduction").value=parseInt((document.getElementById("Pourcentage").value/100)*document.getElementById("Mtotal").value);

			document.getElementById("TotalM").value=document.getElementById("Mtotal").value-document.getElementById("reduction").value;
		}
	  function reductioN()
		{
				var MontantHt = document.getElementById("edit24").value;
				var reduction= Math.round((document.getElementById("reduction").value/100)*MontantHt)  ;

			if (document.getElementById("Mtotal").value>0)
			{ //document.getElementById("TotalM").value=document.getElementById("Mtotal").value-document.getElementById("reduction").value;
			    var montantHT2 = document.getElementById("edit24").value - Math.round((document.getElementById("reduction").value/100)*(document.getElementById("edit24").value))  ;;
				//var tva2 = Math.round(TvaD*parseFloat(montantHT - reduction));
					var TvaD = document.getElementById('TvaD').value;

					if(document.getElementById("edit29").value==0)
						var tva2=0;
					else
					var tva2 = Math.round(TvaD*montantHT2) ;
					document.getElementById("TotalM").value=  montantHT2 +  tva2 ;
				//var valeur=parseInt((document.getElementById("reduction").value/document.getElementById("Mtotal").value) *100);
			  document.getElementById("change").innerHTML='[ '+reduction+' ]';
				//document.getElementById("change").innerHTML=reduction+' %';

			}
		}


		function pal()
		{  		var leselect =document.getElementById("TotalM").value;
				if(leselect<=20000) var TaxeSejour = 500;	else if((leselect>20000) && (leselect<=100000))	var TaxeSejour = 1500;	else	var TaxeSejour = 2500;

		if (document.getElementById("edit3T").value==0)
			document.getElementById('edit3T').value = document.getElementById('TotalM').value;

		var checkbox_aib = document.getElementById("button_checkbox2");
		var checkbox_tva = document.getElementById("button_checkbox1");

		var mHT=document.getElementById("edit3T").value

		var PourcentAIB = document.getElementById('PourcentAIB').value/100;
		var TvaD = document.getElementById('TvaD').value;    //0.18
		var TvaDHT = parseFloat(TvaD) + 1 ;  //1.18;
		var montantHT=Math.round((mHT-TaxeSejour)/TvaDHT);
		var TVA=Math.round(montantHT*TvaD);var AIB=Math.round(montantHT*PourcentAIB);

			if(document.getElementById("edit22").value=='')
			{alertify.error("Impossible d\'appliquer l\'AIB à cette étape. Veuillez sélectionner d\'abord la chambre et le type d\'occupation. ");
			var timeout = setTimeout(
			function() {
				document.getElementById("button_checkbox2").checked = false;
				}
			,1500);
		} else{
		if (checkbox_aib.checked) {
				if (checkbox_tva.checked)
					{	document.getElementById('Mtotal').value = Math.round(parseInt(document.getElementById("edit3T").value) - TVA+AIB);
						document.getElementById('ValTVA').value = TVA ; document.getElementById('ValAIB').value = AIB ;
					}
				else
					{
					document.getElementById('TotalM').value = Math.round(parseInt(document.getElementById("edit3T").value) + AIB);
					document.getElementById('ValTVA').value = TVA ;
					}
			}else {
				if (checkbox_tva.checked)
					{
				 }
				else
					{
					}
			}
		}
			var arrhes = 0 ; if (document.getElementById("arrhes").value!='') arrhes = document.getElementById("arrhes").value;

			var reduction=0; if (document.getElementById("reduction").value!='')  reduction = document.getElementById("reduction").value;

			if ((document.getElementById("edit33").value!='')&& (document.getElementById("edit33").value>0))
			{ /*  if(document.getElementById("exhonerer").value!=1)
					{document.getElementById("edit31").value=parseInt(document.getElementById("edit26").value)-parseInt(document.getElementById("edit33").value);
					}
				else
					{ */
						document.getElementById("edit31").value=parseFloat(document.getElementById("edit26").value)-parseFloat(document.getElementById("edit33").value);
					//}
					document.getElementById("edit32").value=parseInt(document.getElementById("edit33").value/Math.round((parseFloat(document.getElementById('combo5').options[document.getElementById('combo5').selectedIndex].value)+((document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value)*('\t'+document.getElementById("edit24").value)+parseInt('\t'+document.getElementById("edit24").value)))));

					if(document.getElementById("edit23").value>1)
						var variable =document.getElementById("edit26").value/document.getElementById("edit23").value;
					else
						var variable =document.getElementById("edit26").value;


					if(variable>0)
						{	document.getElementById("edit32").value=parseInt(document.getElementById("edit33").value/variable);

							var edit33 = parseInt(document.getElementById("edit33").value) + parseInt(reduction);
							document.getElementById("edit32").value=parseInt(edit33/variable);

							if(document.getElementById("edit32").value >=1){
								document.getElementById("button_checkbox_1").checked = false;
								if(document.getElementById('TypeFacture').value <=0 )
									document.getElementById("button_checkbox_2").checked = true;
								else
									document.getElementById("button_checkbox_3").checked = true;
							}else{
								document.getElementById("button_checkbox_2").checked = false;
								document.getElementById("button_checkbox_3").checked = false;
								document.getElementById("button_checkbox_1").checked = true;
							}
						}
					else
						{//document.getElementById("edit32").value=0;

						}

					document.getElementById("edit3_2").value=parseInt(document.getElementById("edit33").value/Math.round((parseFloat(document.getElementById('combo5').options[document.getElementById('combo5').selectedIndex].value)+	((document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value)*('\t'+document.getElementById("edit24").value)+parseInt('\t'+document.getElementById("edit24").value)))));

/* 			if(document.getElementById("edit30").value > document.getElementById("TotalM").value)
				{alertify.success(" La somme remise est supérieure au montant à payer. ");
				 	 var timeout = setTimeout(
					function() {
						document.getElementById("button_checkbox_3").checked = false;
						document.getElementById("button_checkbox_1").checked = true;
						}
					,1500);

				} */

			}else {
				var variable = parseInt(arrhes);
				document.getElementById("edit33").value =  variable ;
				document.getElementById("edit31").value = 0;
			}
		}
		function Aff3()
		{
		var arrhes = 0 ; if (document.getElementById("arrhes").value!='') arrhes = document.getElementById("arrhes").value;

			var reduction=0; if (document.getElementById("reduction").value!='')  reduction = document.getElementById("reduction").value;

			if ((document.getElementById("edit33").value!='')&& (document.getElementById("edit33").value>0))
			{ 	//document.getElementById("edit31").value=parseFloat(document.getElementById("edit26").value)-parseFloat(document.getElementById("edit33").value);
					document.getElementById("edit31").value=parseFloat(document.getElementById("TotalM").value)-parseFloat(document.getElementById("edit33").value);
					if(document.getElementById("edit23").value>1)
						var variable =document.getElementById("edit26").value/document.getElementById("edit23").value;
					else
						var variable =document.getElementById("edit26").value;

						if(document.getElementById("reduction").value>0)
			 		  variable = parseInt(document.getElementById("TotalM").value - arrhes)/document.getElementById("edit23").value;


					if(variable>0)
						{	var edit33 = parseInt(document.getElementById("edit33").value) + parseInt(reduction);
							//document.getElementById("edit32").value=parseInt(edit33/variable);
							var TotalM = parseInt(document.getElementById("TotalM").value);
							//if(TotalM >= variable)
							var diviseur = TotalM/variable;
							if(diviseur >0)
							document.getElementById("edit32").value=parseInt(divideur);

							if(document.getElementById("edit32").value >=1){
								document.getElementById("button_checkbox_1").checked = false;
								if(document.getElementById('TypeFacture').value <=0 )
									document.getElementById("button_checkbox_2").checked = true;
								else
									document.getElementById("button_checkbox_3").checked = true;
							}else{
								document.getElementById("button_checkbox_2").checked = false;
								document.getElementById("button_checkbox_3").checked = false;
								document.getElementById("button_checkbox_1").checked = true;
							}
						}
					else
						{//document.getElementById("edit32").value=0;

						}

					document.getElementById("edit3_2").value=parseInt(document.getElementById("edit33").value/Math.round((parseFloat(document.getElementById('combo5').options[document.getElementById('combo5').selectedIndex].value)+	((document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value)*('\t'+document.getElementById("edit24").value)+parseInt('\t'+document.getElementById("edit24").value)))));
			}else {
				var variable = parseInt(arrhes);
				document.getElementById("edit33").value =  variable ;
				document.getElementById("edit31").value = 0;
			}
		}

		function Aff4()
		{
			if ((document.getElementById("arrhes").value!=0)&&(document.getElementById("arrhes").value>0))
			{
				if (document.getElementById("edit29").value!=0)
					{document.getElementById("edit33").value=parseInt(document.getElementById("edit30").value)+parseInt(document.getElementById("arrhes").value);
					//document.getElementById("edit31").value=parseInt(document.getElementById("edit26").value)-parseInt(document.getElementById("edit33").value);
					}
				else
					{document.getElementById("edit33").value=parseFloat(document.getElementById("edit30").value)+parseFloat(document.getElementById("arrhes").value);
					//document.getElementById("edit31").value=parseInt(document.getElementById("edit26").value)-parseInt(document.getElementById("edit33").value);
					}
			} else
			{
				document.getElementById("edit33").value=parseInt(document.getElementById("edit30").value);
				//document.getElementById("edit31").value=parseInt(document.getElementById("edit26").value)-parseInt(document.getElementById("edit33").value);
				//document.getElementById("edit32").value=parseInt((document.getElementById("edit30").value-document.getElementById("Fconnexe").value+parseInt(document.getElementById("reduction").value))/(document.getElementById("edit26").value/document.getElementById("edit23").value));
			}
	/* 		if (document.getElementById("combox6").value==0)
					if (document.getElementById("edit30").value>0)
				document.getElementById("edit32").value=parseInt((document.getElementById("edit33").value-document.getElementById("Fconnexe").value)/(document.getElementById("edit26").value/document.getElementById("edit23").value));
				 */
			//var edit33=document.getElementById("edit33").value;
		// Formule Nuité payée: (Total payé- Frais connexe)/(Montant TTC/Nuite)
			if (document.getElementById("edit30").value>0){
				//if (1=1)
				//var variable = parseInt(document.getElementById("TotalM").value - arrhes)/document.getElementById("edit23");
				//document.getElementById("edit32").value=parseInt((document.getElementById("TotalM").value - arrhes)/document.getElementById("edit23")/document.getElementById("edit23").value));
				//else
				document.getElementById("edit32").value=parseInt((document.getElementById("edit33").value-document.getElementById("Fconnexe").value+parseInt(document.getElementById("reduction").value))/(document.getElementById("edit26").value/document.getElementById("edit23").value));
				//document.getElementById("edit3_2").value=parseInt((document.getElementById("edit33").value-document.getElementById("Fconnexe").value+parseInt(document.getElementById("reduction").value))/(document.getElementById("edit26").value/document.getElementById("edit23").value));
			}
				if (document.getElementById("Mtotal").value==0)
					{ document.getElementById("edit31").value=parseInt(document.getElementById("edit26").value)-(parseInt(document.getElementById("edit33").value)+parseInt(document.getElementById("reduction").value));
					}
				else {
					document.getElementById("edit31").value=parseInt(document.getElementById("Mtotal").value)-(parseInt(document.getElementById("edit33").value)+parseInt(document.getElementById("reduction").value));

				}
		}
		function Aff5()
		{
		}
	</script>
	<link rel="Stylesheet" type="text/css"  href='css/input.css' />
	<link rel="Stylesheet" href='css/table.css' />
	<link rel="Stylesheet" type="text/css"  href='css/input2.css' />
	</head>
	<body bgcolor='azure' style="">
	<?php //if(isset($_GET['state'])) echo $_GET['state']; if(isset($_GET['p'])) echo $_GET['p'];
	if(!isset($_GET['p'])) {
	?>

	<div align="" style="">
		<table align='center' width="750" id="tab">
		<tr>
		<td align='center'>
			<fieldset  style='margin-left:auto; margin-right:auto;border:0px solid white;background-color:#D0DCE0;font-family:Cambria;'>
			<legend align='center' style='font-size:1.3em;color:#3EB27B;'>	</legend>
				<form action='<?php echo "occup.php?menuParent=Hébergement"; if(isset($_GET['numfiche'])) echo "&numfiche=".$_GET['numfiche']; if(isset($_GET['state'])) echo "&state=".$_GET['state'];//echo getURI_(); //	//echo "&p=1";?>' method='post' id="">
		<?php
		if(!empty($_SESSION['numreservation']))
		{echo"<table align='center'>
		<tr>";
			$sql=mysqli_query($con,"SELECT chambre.numch,chambre.nomch,reserverch.typeoccuprc,reserverch.tarifrc,reserverch.ttc,reserverch.nuite_payee FROM reserverch,chambre WHERE chambre.EtatChambre='active' AND chambre.numch=reserverch.numch AND numresch='".$_SESSION['numreservation']."' AND chambre.numch NOT IN (SELECT numch AS numch FROM chambre_tempon) ORDER BY typeoccuprc");
			$nbre=mysql_num_rows($sql);
			if($nbre>0)
			{echo"<td><span style='color:black; font-style:italic;'> Liste des chambres reservées:</span> ";
			while ($data= mysqli_fetch_array($sql))
			{	$numch=$data['numch'];
				echo "<span style='color:#CD5C5C;font-size:0.8em; font-style:italic;'>".$nomch=$data['nomch'];
				echo "</span> <span style='color:white;font-size:0.8em; font-style:italic;'>(".$typeoccuprc=$data['typeoccuprc']; echo") </span>;&nbsp;";
			}
		echo"</td>
		</tr>

		</table>";
		}
		//echo $_SESSION['numreservation'];
		$res=mysqli_query($con,"SELECT numfiche  FROM exonerer_tva WHERE numfiche='".$_SESSION['numreservation']."'");
			while($ret=mysqli_fetch_array($res))
				{ $numfiche_1=$ret['numfiche'];
				}
		}
		?>
				<table width='700' style='margin-right:25px;margin-left:25px;'>
				<tr>
					<td colspan='4'>
					<h3 style='margin-bottom:-20px;text-align:center; font-family:Cambria;color:maroon;font-weight:bold;'>OCCUPATION DE LA CHAMBRE</h3>
					</td>
				</tr>

				<input type='hidden' name='ValTVA' id='ValTVA' value='0' />
				<input type='hidden' name='ValAIB' id='ValAIB' value='0' />
				<input type='hidden' name='PourcentAIB' id='PourcentAIB' value='<?php echo isset($PourcentAIB)?$PourcentAIB:1;	?>' />
				<input type='hidden' name='TvaD' id='TvaD' value='<?php echo $TvaD;	?> ' />

								<tr>
										<td colspan='4'><hr style='margin-bottom:-20px;'/>&nbsp;</td>
								</tr>
								<tr>
									<td colspan='4'><span>
									<a  title='' target="_blank" style="text-decoration:none;" href="popup.php?numfiche=<?php echo isset($_SESSION['num'])?$_SESSION['num']:NULL;?>" onclick="window.open(this.href, 'Titre','target=_parent, height=auto, width=450, top=180, left=250, color=black, toolbar=no, menubar=no, location=no, resizable=no, scrollbars=no, status=no'); return false">
									<img src='logo/plus.png' alt='' title='' width='28' height='25' style='margin-top:-3px;float:left;' border='0'><span style='font-size:1em;color:gray;font-weight:bold;'>Frais Connexes</span></a>
									 </span>

								<?php
								echo "<span style='align:center;'>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
									<input  type='checkbox' name='Apply_AIB' id='button_checkbox2' onclick='pal();'/>
									<label for='button_checkbox2' style='color:#444739;font-size:1em;color:gray;'>Appliquer l'AIB	("; echo isset($PourcentAIB)?$PourcentAIB:1; echo "%) </label></span>	&nbsp; &nbsp;";

								if($TvaD!=0) { echo "<span style='float:right'>";
									 include_once('others/occupExo.php');
									 echo "</span>";
								}	else {
								     //echo "&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;";
								}
								?>
									</td>
								</tr>
								<tr>
										<td colspan='4'><hr style='margin-top:-15px;margin-bottom:-15px;'/>&nbsp;</td>
								</tr>
								<tr>
									<td>   Chambre N° : </td>
									<td>
										  <select name='combo3' id='combo3' style='' required='required' >
											<option value='<?php if(!empty($numch)) echo $numch;
											?> '> <?php
											if(!empty($numch))  echo $nomch;else
											echo " "?></option>
												<?php
													//$res=mysqli_query($con,'SELECT numch,nomch FROM chambre');
													$res=mysqli_query($con,"SELECT numch,nomch FROM chambre WHERE EtatChambre='active' AND numch NOT IN (SELECT mensuel_compte.numch FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.numfiche=mensuel_compte.numfiche and mensuel_fiche1.etatsortie='NON') ORDER BY nomch") or die (mysql_error());
													while ($ret=mysqli_fetch_array($res))
														{
															echo '<option value="'.$ret['numch'].'">';
															echo($ret['nomch']);
															echo '</option>' ;
															echo '<option value=""> </option>' ;
														}

												?>
										</select>
									<input type='hidden' name='numfiche' id='numfiche' value='<?php echo $numfiche;?>'/>
									<input type='hidden' name='numero' value='<?php echo $numero;?>'/>
									<input type='hidden' name='NumIFU' id='NumIFU' value='<?php if(isset($_SESSION['NumIFU'])) echo $_SESSION['NumIFU'];?>'/>
									</td>
									<td>&nbsp; &nbsp;Type de chambre :&nbsp; </td>
							<?php
							if(!empty($numch))
							$res=mysqli_query($con,'SELECT typech FROM chambre WHERE EtatChambre="active" AND numch="'.$numch.'"');
							$ret=mysqli_fetch_assoc($res);  $type_ch=isset($ret['typech'])?trim($ret['typech']):NULL;
							if(!empty($type_ch)) {if($type_ch=='CL') $type_ch="Climatisée"; else $type_ch="Ventillée";} else {};
							?>
							<td>   <input type='text' name='edit22' id='edit22' required='required'  value='<?php
							echo $type_ch;?>'/> </td>
								</tr>
								<tr>
									<td>  Type d'occupation : &nbsp;</td>
									<td>
										 <select name='combo4' id='combo4' style='' >
							<?php
								echo " <option value='"; if(!empty($typeoccuprc)) echo $typeoccuprc; echo"'> ";if(!empty($typeoccuprc)) echo $typeoccuprc; else echo" "; echo"</option>";

								$ref=mysqli_query($con,"SELECT typeoccuprc AS typeoccup FROM Typeoccupation ORDER BY Nbpers ");
								while ($rerf=mysqli_fetch_array($ref))
									{  	echo "<option value='".$rerf['typeoccup']."'> ".strtoupper($rerf['typeoccup'])."</option>";
										echo "<option value=''></option>";
									}

							?>	 </select>
										<input type='hidden' required='required'  id='TvaD'  value='<?php echo $TvaD;?>'/>
										<input type='hidden' required='required' name='edit42' id='edit42'  value='<?php //if(!empty($RegimeTVA)&&($RegimeTVA==1)) echo 1; else echo $TvaD;?>'/>
									</td>
									<td>&nbsp; &nbsp;Tarif HT : </td>
									<td>  <input type='text' required='required' name='edit24' id='edit24' onblur="Aff();" readonly <?php if(!empty($tarifrc)) echo "value='".$tarifrc."'";?>/> </td>
								</tr>
								<tr>
									<td>  Nuitée : </td>
									<td>  <input type='text'  name='edit23' id='edit23' value='<?php echo isset($_SESSION['Nuite'])?$_SESSION['Nuite']:1; ?>' readonly /> </td>
									<td>  &nbsp; &nbsp;Montant Total : </td>
									<td> <input type='text' required='required' name='edit25' id='edit25' placeholder='Montant HT' onblur="Aff5();"  readonly  value='<?php if(!empty($tarifrc)) echo $tarifrc*$_SESSION['Nuite'];?>'/>
								<input type='hidden' name='edit_25' id='edit_25'   readonly  value="0"/> 									</td>
								</tr>
								<tr>
									<td> TVA : </td>
									<td><input type='text' name='edit29' id='edit29' readonly <?php if(!empty($tarifrc)&&(empty($numfiche_1))) {echo "value='";
									//$tva=round($tvaD*$tarifrc*$_SESSION['Nuite'],4);
									$tva=$tvaD*$tarifrc*$_SESSION['Nuite'];  echo round($tva);
									echo"'";} if(!empty($numfiche_1)) {echo "value='"; echo 0; echo"'";}?>/>
									</td>
									<td>&nbsp; &nbsp;Taxe de séjour : </td>
									<td>  <input type='text' required='required' name='edit28' id='edit28' readonly  value='' /> </td>
								</tr>
								<tr>
								<?php
										 /* if($TvaD!=0) {
											 include_once('others/tva.php');
										}else{
										   echo "<input type='hidden' name='combo6' id='combox6' value='0'/>";
										}
 */
									$ttc1=!empty($ttc1)?$ttc1:0;$tarifrc=!empty($tarifrc)?$tarifrc:NULL;$nuite_payee=!empty($nuite_payee)?$nuite_payee:NULL;$var=!empty($var)?$var:NULL;
									$Ttotal=!empty($Ttotal)?$Ttotal:NULL;$pourcentage=!empty($pourcentage)?$pourcentage:0;$Application=!empty($Application)?$Application:NULL;
								?>
								</tr>
								<tr>
									<td>  Montant TTC : </td>
									<td>  <input type='text' name='edit26' id='edit26' readonly <?php if((!empty($tarifrc))&&(empty($numfiche_1))) { echo "value='"; echo $mt=(int)($tarifrc*$_SESSION['Nuite']+($TvaD*$tarifrc*$_SESSION['Nuite'])+$taxe);echo"'";} if(!empty($numfiche_1)){  echo "value='"; echo $mt=$tarifrc*$_SESSION['Nuite']+($_SESSION['Nuite'])+$taxe;echo"'";}?> onchange='FconnexeT();'/> </td>

									<td>  &nbsp;  &nbsp;&nbsp;Arrhes : </td>
									<td>  <input type='text' name='arrhes' id='arrhes' value='<?php if(isset($_GET['avance'])&&($_GET['avance'])>0) echo $_GET['avance']; else if($ttc1>0) echo $nuite_payee*$ttc1; else echo 0;?>' readonly /> </td>
								</tr>
								<?php
								 if(($Ttotal>0)) echo "
								<tr>
									<td>  <span style='color:#DA4E39;'>Frais connexes:</span> </td>
									<td>  <input type='text' name='Fconnexe' id='Fconnexe' readonly value='".$Ttotal."'/> </td>

									<td>  <span style='color:#DA4E39;'>Montant Total :</span> </td>
									<td>  <input type='text' name='Mtotal' id='Mtotal' value='' readonly /> </td>
								</tr>";
								else {
									 echo "<input type='hidden' name='Fconnexe' id='Fconnexe' readonly value='0'/>";
									echo "<input type='hidden' name='Mtotal' id='Mtotal' value='0' readonly />";
								}


								 //if($pourcentage>0)
									//{
										echo "<tr>
										<td>  Réduction : &nbsp;&nbsp;<span style='color:#d10808;font-size:0.8em;' id='change'>  [ Valeur ] </span></td>";
											echo "<td> ";
											if($Application=="Automatique"){ //Le montant de la réduction est fonction du pourcentage défini par l'admin
												echo "<input type='hidden' name='Pourcentage' id='Pourcentage' value='".$pourcentage."' />";
												echo '<input type="text" name="reduction" placeholder="%" id="reduction" onkeypress="testChiffres(event);" readonly="readonly"/>';
											}else{  //L'agent de caisse saisit directement le montant de la réduction
												echo "<input type='hidden' name='Pourcentage' id='Pourcentage' value='1' />";
												echo '<input type="text" name="reduction" placeholder="%" id="reduction" onkeyup="reductioN();" onkeypress="testChiffres(event);" placeholder="0"/>';
											}
											//echo '<input type="text" name="reduction" id="reduction" onkeyup="reductioN();" onkeypress="testChiffres(event);"/>';
									/* 		else
												{	echo "<select name='Pourcentage' id='Pourcentage' style=''>
													<option value=''> </option>";
														for($i=1;$i<=100;$i++)
															echo "<option value='".$i."'>".$i."</option>";
													echo "</select>";
												} */
											echo "</td>
										<td> &nbsp; &nbsp; Montant à payer : </td>
										<td>  <input type='text' name='TotalM' id='TotalM' readonly /> </td>
									</tr>";
									//}
								 ?>

								<tr>
									<td>  Somme encaissée : </td>
									<td>  <input type='text' name='edit30' id='edit30' onkeyup='Aff4();Aff3();' readonly  onkeypress="testChiffres(event);Aff4();Aff3();" autocomplete='OFF' placeholder='Intégralité ou Arrhes' /> </td>
									<td> &nbsp; &nbsp; Total Payé : </td>
									<td>  <input type='text' name='edit33' id='edit33' readonly onkeypress="testChiffres(event);" onblur='Aff3();'/> </td>
								</tr>

							<input type='hidden' name='combo5' id='' readonly value='<?php  ?>'/>

							<input type='hidden' name='combo6' id='' readonly value='<?php if(isset($TvaD)) echo $TvaD;  ?>'/>

								<tr>
									<td>  Somme due : </td>
									<td>  <input type='text' name='edit31' id='edit31' readonly /> </td>
									<td> &nbsp; &nbsp; Nuitée(s) Payée(s) : </td>
									<td>  <input type='text' name='edit32' id='edit32' readonly />
									 <input type='hidden' name='edit3_2' id='edit3_2' readonly /></td>
								</tr>

								<tr>
										<td colspan='4'><hr style='margin-bottom:-20px;'/>&nbsp;</td>
								</tr>
								<tr>

									<td align=''>
									<input type="checkbox" name='button_checkbox_1' id="button_checkbox_1"  onClick="verifyCheckBoxes1();" value='1' checked >
									<label for="button_checkbox_1" style='font-weight:bold;color:gray;'>Recu Ticket</label>
									</td>
									<td colspan='2' align='center'>
									<input type="checkbox" name='button_checkbox_2' id="button_checkbox_2" onClick="verifyCheckBoxes2();" value='1' onchange="verifyNuite();" <?php if($TypeFacture==1) echo "disabled"; ?>>
									<label for="button_checkbox_2" style='font-weight:bold;color:gray;'>Facture ordinaire</label>
									</td>
									<td align=''>&nbsp;&nbsp; &nbsp;
									<input type="checkbox" name='button_checkbox_3' id="button_checkbox_3" onClick="verifyCheckBoxes3();"  onchange="verifyIFU();" value='1' <?php if($TypeFacture==0) echo "disabled"; ?>>
									<label for="button_checkbox_3" style='font-weight:bold;color:gray;'>Facture Normalisée</label>
									</td>
								</tr>
									<tr>
										<td colspan='4'><hr style='margin-top:-15px;margin-bottom:-15px;'/>&nbsp;</td>
								</tr>
									<tr><td colspan='4' align='center'>
									<span><input style='margin-bottom:-15px;' type='submit' class='bouton2' name='VALIDER' id='VALIDER' value='VALIDER'/> &nbsp; </span></td>
								</tr>
								<?php /* if(($Ttotal>0)) {echo"<tr><td colspan='4' align='center'>
										<span style='font-size:1.1em;color:red;'>
										<input  type='checkbox' name='Fconnexe' id='Fconnexe' checked='checked' onclick='action2();' value='1'/>
										<input type='hidden' name='Ttotal' id='Ttotal' value='".$Ttotal."'  />Montant Total à Encaisser :&nbsp;</span>
									 <input type='text' name='MTtotal' id='MTtotal' value='".$MTtotal."'  />&nbsp;&nbsp;Hébergement + Frais Connexes</td></tr>";}  */
									 //if(($Ttotal>0)) echo "<tr><td colspan='4' align='center'><span style='font-size:1em;color:white;font-weight:bold;'> Vous venez d'ajouter ".$Ttotal." à la facture du client.</span></td></tr>";
								?>
							</table> 	<input type='hidden' name='edit3T' id='edit3T' value='0' readonly />
						</form>
					</fieldset>
				</td>
			</tr>

		</table>
		<?php
	}
	?>
	</div>
	</body>

	<input type='hidden' name='' id='TypeFacture' value='<?php if(isset($TypeFacture)) echo $TypeFacture;?>'/>


	<script type="text/javascript">
		function verifyIFU(){
			if(document.getElementById('TypeFacture').value <=0 )
			{ /* if((document.getElementById("button_checkbox_3").checked) )
				{alertify.error(" Pour établir la facture normalisée, <br/> le Numéro IFU du client est requise. ");
				 	 var timeout = setTimeout(
					function() {
						document.getElementById("button_checkbox_3").checked = false;
						document.getElementById("button_checkbox_1").checked = true;
						}
					,1500);

				} */
			}else {
				if(document.getElementById('edit32').value <=0 )
				{if((document.getElementById("button_checkbox_3").checked) )
					{alertify.error("Le montant à encaisser ne permet pas d'établir une facture pour le client. ");
					var timeout = setTimeout(
					function() {
						document.getElementById("button_checkbox_3").checked = false;
						document.getElementById("button_checkbox_1").checked = true;
						}
					,1500);
					}
				}

			}
	}
	function verifyNuite(){
			if(document.getElementById('edit32').value <=0 )
				{if((document.getElementById("button_checkbox_2").checked) )
					{alertify.error("Le montant à encaisser ne permet pas d'établir une facture pour le client. ");
					var timeout = setTimeout(
					function() {
						document.getElementById("button_checkbox_2").checked = false;
						document.getElementById("button_checkbox_1").checked = true;
						}
					,1500);
					}
				}
			//else
				//document.getElementById('button_checkbox_2').checked="checked";
	}
	function FconnexeT(){
		//if ((document.getElementById("Fconnexe").value!='')){
			document.getElementById('Mtotal').value=document.getElementById('Fconnexe').value+document.getElementById('edit26').value;
			//}

	}


		// fonction pour selectionner le type de chambre
		function action6(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						var mavariable = leselect.split('|');
						document.getElementById('edit42').value = mavariable[1];
						document.getElementById('edit22').value = mavariable[0];
						//document.getElementById('edit22').value = '\t'+leselect;
						if(document.getElementById('edit42').value ==0)
						alertify.success("Non Assujetti(e) à la TVA");
					}
				}
				xhr.open("POST","ftypech.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo3');
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("numch="+sh);
			//document.getElementById('edit32')='';
		}



				// fonction pour selectionner le type de chambre
			function action66(event){
			var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						//if(!empty(leselect) && (leselect!=0) )
							document.getElementById('reduction').value =leselect;
						//else
						//	document.getElementById('reduction').value =0;
						document.getElementById('TotalM').value =document.getElementById('edit26').value - leselect;
						//document.getElementById('TotalM').value =sl=document.getElementById('edit26').value - leselect;
						var valeur=parseInt(0.1+(leselect/document.getElementById("Mtotal").value) *100);
						document.getElementById("change").innerHTML=valeur+' %';
					}
				}
				xhr.open("POST","reduction.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				//sel = document.getElementById('combo5');
				//sh = sel.options[sel.selectedIndex].value;
				sl=document.getElementById('edit26').value;
				sl2=document.getElementById('numfiche').value;
				xhr.send("MontantTTC="+sl+"&numfiche="+sl2);
			//document.getElementById('edit32')='';
		}

		// fonction pour selectionner le tarif
		function action7(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						if(leselect<=20000)
							var TaxeSejour = 500;
						else if((leselect>20000) && (leselect<=100000))
							var TaxeSejour = 1500;
						else
							var TaxeSejour = 2500;
						var NbreNuite = document.getElementById('edit23').value;

						//if ((document.getElementById("edit42").value==0)) var diviseur=1; else 	var diviseur =1+document.getElementById("TvaD").value;
						//var TvaD =document.getElementById("TvaD").value;

						var TvaD =document.getElementById("TvaD").value;
						var diviseur=1; if ((document.getElementById("edit42").value!=0))	var diviseur =parseFloat(diviseur)+parseFloat(TvaD);

						document.getElementById('edit24').value = Math.round((leselect-TaxeSejour)/diviseur);
						if(diviseur==1) document.getElementById('edit29').value = 0;
						else document.getElementById('edit29').value = Math.round (NbreNuite*(((leselect-TaxeSejour)/diviseur)*TvaD));
						document.getElementById('edit28').value = TaxeSejour * NbreNuite;
						document.getElementById('edit26').value = leselect * NbreNuite;
						document.getElementById('Mtotal').value = leselect * NbreNuite;
						document.getElementById("TotalM").value=document.getElementById("edit26").value-document.getElementById("arrhes").value;
						//document.getElementById('edit25').value = (document.getElementById('edit23').value*document.getElementById('edit24').value).toFixed(4);
						document.getElementById('edit25').value = Math.round(document.getElementById('edit23').value*(leselect-TaxeSejour)/diviseur);
						document.getElementById('edit_25').value = Math.round(document.getElementById('edit23').value*((leselect-TaxeSejour)/diviseur)) + (TaxeSejour * NbreNuite);
						document.getElementById('edit30').focus();
						document.getElementById("edit30").style.backgroundColor= "beige" ;
						//document.getElementById("edit30").style.border = "2px solid #00FF00"  ;
					}
				}
				xhr.open("POST","others/ftarif.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo4');
				sel1 = document.getElementById('combo3');
				sh1=sel1.options[sel1.selectedIndex].value;
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("objet="+sh+"&numch="+sh1);
		}




		//affichage des informations concernant le client


		var momoElement1 = document.getElementById("combo3");
		if(momoElement1.addEventListener){
		  momoElement1.addEventListener("change", action6, false);
		 // momoElement1.addEventListener("change", action7, false);
		  //momoElement1.addEventListener("change", Verif, false);
		}else if(momoElement1.attachEvent){
		  momoElement1.attachEvent("onchange", action6);
		 // momoElement1.attachEvent("onchange", action7);
		  //momoElement1.attachEvent("onchange", verif);
		}

		var momoElement2 = document.getElementById("combo4");
		if(momoElement2.addEventListener){
		  momoElement2.addEventListener("change", action7, false);

		}else if(momoElement2.attachEvent){
		  momoElement2.attachEvent("onchange", action7);

		}


				var momoElement3 = document.getElementById("combo6");
		if(momoElement3.addEventListener){
		  momoElement3.addEventListener("change", action66, false);

		}else if(momoElement3.attachEvent){
		  momoElement3.attachEvent("onchange", action66);

		}

		//fonction standard
		function getXhr(){
			xhr=null;
				if(window.XMLHttpRequest){
					xhr=new XMLHttpRequest();
				}
				else if(window.ActiveXObject){
					try {
			                xhr = new ActiveXObject("Msxml2.XMLHTTP");
			            } catch (e) {
			                xhr = new ActiveXObject("Microsoft.XMLHTTP");
			            }
				}
				else{
					alert("votre navigateur ne suporte pas les objets XMLHttpRequest");
				}
				return xhr;
			}
	</script>
</html>
