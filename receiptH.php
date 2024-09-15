<?php
  if(!isset($con))
 	include 'config.php'; //echo $_SESSION['reservation'];
	include 'chiffre_to_lettre.php';
	$reqsel=mysqli_query($con,"SELECT numrecu FROM configuration_facture");
	$data=mysqli_fetch_object($reqsel);
	$num_recu=isset($_GET['num_recu'])?$_GET['num_recu']:NumeroFacture($data->numrecu);
	 $client=isset($_SESSION['cli'])?$_SESSION['cli']:NULL; $nature=isset($_SESSION['nature'])?$_SESSION['nature']:NULL;
	 $SommePayee=isset($_SESSION['SommePayee'])?$_SESSION['SommePayee']:0;
	 $Numch=isset($_SESSION['tch'])?$_SESSION['tch']:NULL;

	//@include('emecef.php');
		if(!isset($_GET['receipt'])){ 
			echo $id_request=isset($_GET['id_request'])?$_GET['id_request']:NULL;
			$query="SELECT * FROM e_mecef,produitsencours WHERE id_request='".$id_request."' AND e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF ";
			$res1=mysqli_query($con,$query);
			$data=mysqli_fetch_object($res1);
			$_SESSION['DT_HEURE_MCF']    = isset($data->DT_HEURE_MCF)?$data->DT_HEURE_MCF:NULL;
			$_SESSION['QRCODE_MCF']      = isset($data->QRCODE_MCF)?$data->QRCODE_MCF:NULL;
			$_SESSION['SIGNATURE_MCF']   = isset($data->SIGNATURE_MCF)?$data->SIGNATURE_MCF:NULL;
			$_SESSION['COMPTEUR_MCF']    = isset($data->COMPTEUR_MCF)?$data->COMPTEUR_MCF:NULL;
			$_SESSION['NIM_MCF']         = isset($data->NIM_MCF)?$data->NIM_MCF:NULL;
		

	require ('vendor/autoload.php');

	 // Instantiate the library class
	 $barcode = new \Com\Tecnick\Barcode\Barcode();
	 $dir = "qr-code/";

	 // Directory to store barcode
	 if (! is_dir($dir)) {
			 mkdir($dir, 0777, true);
	 }
	 // data string to encode
	 //$source = "F;TS01000378;TESTN23MVU2WGTJWZEQ6H3QD;1201408333100;20211116140029";

	 if(isset($_SESSION['QRCODE_MCF'])&& (!empty($_SESSION['QRCODE_MCF']))){
		 $source =$_SESSION['QRCODE_MCF'];

		 // ser properties
		 $qrcodeObj = $barcode->getBarcodeObj('QRCODE,H', $source, - 16, - 16, 'black', array(
				 - 2,
				 - 2,
				 - 2,
				 - 2
		 ))->setBackgroundColor('#f5f5f5');

		 // generate qrcode
		 $imageData = $qrcodeObj->getPngData();
		 $timestamp = time();

		 //store in the directory
		 file_put_contents($dir . $timestamp . '.png', $imageData);

	 }

}

		// $table=(isset($_SESSION['Ntable'])&&(!empty($_SESSION['Ntable']))) ? $_SESSION['Ntable']:NULL; $num_facture=isset($_GET['num_facture'])?$_GET['num_facture']:NULL;
		// if(isset($num_facture))
		// 	{ $req="SELECT * FROM factureResto,tableEnCours WHERE tableEnCours.num_facture=factureResto.num_facture AND factureResto.num_facture='".trim($num_facture)."' ";
		// 	  $reqselRTables=mysqli_query($con,$req);
		// 	}
		// else
		// 	{  $req="SELECT * FROM factureResto,tableEnCours WHERE tableEnCours.numTable=factureResto.numTable AND factureResto.numTable='".$table."' AND date_emission ='".$Jour_actuel."'  ";
		// 	  //$reqselRTables=mysqli_query($con,$req);
		// 		$reqselRTables=mysqli_query($con,"SELECT * FROM tableEnCours WHERE numTable='".$table."' AND Etat='active' ");
		// 	}
		//
		// 	$factureResto=mysqli_query($con,$req);
		// 	while($data1=mysqli_fetch_array($factureResto)){ $Net=$data1['montant_ttc']-$data1['Remise'];
		// 	$SommePayee=$data1['somme_paye']; $monnaie=$SommePayee-$Net;$remise=$data1['Remise'];
		// 	 $NomClient=!empty($data1['NomClient'])?$data1['NomClient']:"<i>Non renseigné</i>";
		// 	 $heure=$data1['heure_emission'];
		// 	}


	if(!empty($id_request)){ 
		$sqlA = "SELECT DISTINCT (produits.Num),clients.NomClt AS Client,clients.NumIFU,clients.AdresseClt,clients.TelClt,RaisonSociale,produitsencours.GrpeTaxation,taxSpecific,RegimeTVA,produits.Designation AS LigneCde,produitsencours.prix,produitsencours.qte
		FROM e_mecef,produitsencours,Clients,produits WHERE produits.Num=produitsencours.LigneCde AND
	   (produitsencours.Client=Clients.Num OR produitsencours.Client=Clients.RaisonSociale) AND id_request='".$id_request."' AND e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF ";
	}
	else if(isset($_GET['receipt'])) //Le cas d'une réimpression de ticket de caisse
	{
	$sqlA = "SELECT produits.Designation, produitsencours.GrpeTaxation,taxSpecific,RegimeTVA,produits.Designation AS LigneCde,produitsencours.prix,produitsencours.qte
	From e_mecef,produitsencours,produits WHERE produits.Num = produitsencours.LigneCde AND produitsencours.SIGNATURE_MCF = e_mecef.SIGNATURE_MCF  AND id_request='".$_GET['id_request']."'";
	}
	else if(isset($_GET['clt'])){ 
		$sqlA = "SELECT DISTINCT (produits.Num),clients.NomClt AS Client,clients.NumIFU,clients.AdresseClt,clients.TelClt,RaisonSociale,produitsencours.GrpeTaxation,taxSpecific,RegimeTVA,produits.Designation AS LigneCde,produitsencours.prix,produitsencours.qte
		FROM produitsencours,Clients,produits WHERE produits.Num=produitsencours.LigneCde AND
		(produitsencours.Client=Clients.Num OR produitsencours.Client=Clients.RaisonSociale)
		AND  Etat = 2 AND produitsencours.Client ='".$_GET['clt']."'";
	}
	else {echo 15;
		//Cas de Réservation
/* 		echo $sqlA = "SELECT DISTINCT (produits.Num),clients.NomClt AS Client,clients.NumIFU,clients.AdresseClt,clients.TelClt,RaisonSociale,produitsencours.GrpeTaxation,taxSpecific,RegimeTVA,produits.Designation AS LigneCde,produitsencours.prix,produitsencours.qte
		FROM produitsencours,clients,produits WHERE produits.Num=produitsencours.LigneCde AND
		(produitsencours.Client=clients.Num OR produitsencours.Client=clients.RaisonSociale)
		AND  Etat = 2 "; */
	}
	mysqli_query($con,"SET NAMES 'utf8' ");
	$query = mysqli_query($con, $sqlA);$num=0;$data0="";$Mtotal=0; $TotalHT=0; $TotalTva=0;$TotalTva0=0;

if(isset($_GET['receipt']))
{ //Réimpression de facture
?>
<center>
<div class="" style='margin-left:0%;width:500px;margin-top:-5%;'>
﻿<?php }
else if(isset($_GET['visr']) || (!empty($id_request))){  //Economat
?>
<div class="" style='margin-left:0%;margin-top:-3%;width:500px;'>
﻿<?php }
	else {  //Restauration
?>
<div class="" style='margin-left:0%;width:500px;float:right;'>
<?php
	}
?>
    <div class="" style=''>
        <div class="" style='background-color:#fff;border:1px solid gray;'>
            <div class="" >
                <div class="" >
					<p style='margin-top:5px;margin-right:5px;align:right;float:right;'>
							<em style=''> <?php
							 echo "Cotonou le, ".$Date_actuel; ?></em>
					</p>

            <address style='float:left;'>
						<br/><img src='<?php echo $_SESSION['logo']; ?>' alt='' width="30%" height="15%" style='float:left;'>
						<div style='font-size:0.8em;text-align:left;'>
							<strong><?php echo $_SESSION['entreprise']; ?></strong>
							<br>
						   <?php if(isset( $_SESSION['NumIFUEn'])) echo 'N° IFU : '. $_SESSION['NumIFUEn']; ?>
						   	<br>
						   <?php if(isset( $_SESSION['RCCMEn'])) echo  str_replace(' ','',$_SESSION['RCCMEn']); ?>
							<br>
						   <?php if(isset( $_SESSION['TelEn'])) echo  'Tél : '.str_replace(' ','',$_SESSION['TelEn']); ?>
							<?php //if(isset($Email)) echo "Email: ".$Email; ?>
						</div>
						</address>
										<div class="" style='float:right;'>

										</div>
										<address style='float:right;border:1px dashed gray;margin-right:5px;padding-left:3px;'>
											<div style='font-size:0.9em;margin-right:10px;text-align:left;'>
												<strong><?php echo "Adresse de facturation" ?></strong>
												<br>
													<?php  if(isset($_SESSION['client'])&&(!empty($_SESSION['client']))) echo  $_SESSION['client']; else echo 'Nom du client : ';?>
												<br>
													<?php  echo 'N° IFU : '; if(isset($_SESSION['NumIFU'])&&(!empty($_SESSION['NumIFU']))) echo  $_SESSION['NumIFU']; ?>
												<br>
													<?php  if(isset($_SESSION['AdresseClt'])&&(!empty($_SESSION['AdresseClt']))) echo $_SESSION['AdresseClt'];
														   echo 'Tél  : '; if(isset($_SESSION['TelClt'])&&(!empty($_SESSION['TelClt']))) echo  $_SESSION['TelClt']; ?>
											</div>
										</address>
											<div class="" style='border:0px solid red;clear:both;margin-top: 75px;text-align:left;font-size:0.9em;'>
												<p style='float:left;padding-left:5px;'>
														<em>Reçu N°  : <?php if(isset( $_SESSION['SIGNATURE_MCF'])) echo $_SESSION['numFact']; else echo "000/".date('Y'); ?></em>
												</p>
												<p style='padding-right:5;text-align:right;float:right;'>
														<em>Vendeur : <?php echo isset($_SESSION['userId'])?$_SESSION['userId']:NULL;
														echo " | ";
														echo isset($_SESSION['vendeur'])?$_SESSION['vendeur']:NULL; ?></em>
												</p>
										</div>
                </div>
            </div>

			<?php  echo " <table style='background-color:#fff;'>
						<tr>
							<td colspan='2' > &nbsp;</td>
						</tr>
						<tr>";
							//echo "<td align=''><u>Période </u> : ";
							  //echo $d;  echo "  au ";  echo $dp;
						//}
							echo "</td>
						</tr> </table";
			?>

				<div class="row" style=''>
                </span>
                <table class="" style='min-height:50%;text-align:right;width:100%;background-color:#fff;font-size:0.8em;'>
                        <tr style='background-color:#c0c0c0;border-top:1px solid gray;border-bottom:2px solid gray;'>
							  <th class="" style='text-align:left;'>&nbsp;&nbsp;N°</th>
							  <th class="" style='text-align:left;'>Désignation</th>
							   <th class="">Prix Unit.</th>
							  <th class="">Qté</th>
                              <th class="" >Prix TTC</th>
                        </tr>
                    <tbody>
                       <?php
					   ///if(isset($reqselRTables)){
							 $total=0;$num=0;//$mt=0;
							 while($data=mysqli_fetch_array($query)){ $num++;
							 // $customerIFU=$data['NumIFU']; if($customerIFU==0) $customerIFU=0;
							 // $userName=!empty($data['RaisonSociale'])?$data['RaisonSociale']:$data['Client'];
							 // $_SESSION['AdresseClt']=!empty($data['AdresseEn'])?$data['AdresseEn']:$data['AdresseClt'];
							 // $_SESSION['TelClt']=!empty($data['TelEn'])?$data['TelEn']:$data['TelClt'];
							 if($data['GrpeTaxation']=='A') $GrpeTaxation="A-EX";
							 else if($data['GrpeTaxation']=='B') $GrpeTaxation="B";
							 else if($data['GrpeTaxation']=='F') $GrpeTaxation="F";
							 else $GrpeTaxation="E";

							$LigneCde=$data['LigneCde']; // $LigneCde="ghgghvhgvhghvhd"; //

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

							 //$TotalHT+=$TotalHT0 ;  $TotalTva+=$TotalTva0 ;
							echo "<tr style='border-bottom:1px dashed gray;'>
								<td style='text-align:left;'>&nbsp;&nbsp;".$num.".</td>
								<td class='' style='text-align:left;' >";
								echo ucfirst($LigneCde);
								//echo " ".$data1['QteInd'];
								echo "</td>
								<td align='' class=''> ".$prix."</td>
								<td align='' class=''> ".$qte."</td>
								<td align='' class=''>".$mt."</td>
							</tr>";
						}
					  // }

						?>
						    <tr>
                            <!-- <td colspan='5' align='left'><hr/> </td> !-->
							</tr>
							<tr style='border:1px solid gray;'>
								<!-- <td rowspan='5' align='left'><br/> Devise :</td>
								<td colspan='3' align='left'><br/><? //=$devise ?> </td> !-->

										<td colspan='1'> 
											<?php
											if(isset($_SESSION['QRCODE_MCF'])&& (!empty($_SESSION['QRCODE_MCF'])))
												echo '<img style="float:left;" src="'.$dir . $timestamp.'".png" width="80px" height="80px">';
											?>
										</td>
										<td colspan='2'> 
											<table style='font-size:0.8em;width:100%;float:left;margin-top:-5px;margin-left:-5px;'>
												<tr style=''>
													<td style=''>  <?php if(isset($_SESSION['SIGNATURE_MCF'])&& (!empty($_SESSION['SIGNATURE_MCF']))) echo "CODE MECeF/DGI : &nbsp;".$_SESSION['SIGNATURE_MCF']; ?></td>

												</tr>
												<tr style=''>
													<td style=''>  <?php if(isset($_SESSION['NIM_MCF'])&& (!empty($_SESSION['NIM_MCF']))) echo "MECeF NIM : &nbsp;".$_SESSION['NIM_MCF']; ?></td>

												</tr>
												<tr style=''>
													<td style=''>  <?php if(isset($_SESSION['COMPTEUR_MCF'])&& (!empty($_SESSION['COMPTEUR_MCF']))) echo "MECeF Compteurs : &nbsp;".$_SESSION['COMPTEUR_MCF']; ?> </td>

												</tr>
												<tr style=''>
													<td style=''> <?php if(isset($_SESSION['DT_HEURE_MCF'])&& (!empty($_SESSION['DT_HEURE_MCF']))) echo "MECeF Heure : &nbsp;".$_SESSION['DT_HEURE_MCF']; ?> </td>
												</tr>

											</table>


										</td>

										<td colspan='2'>

										<table style='width:100%;margin-top:0px;font-size:0.9em;'>
											<tr style=''>
												<td style='border:1px solid gray;'>Total HT :</td>
												<td style='border-top:1px solid gray;text-align:right;'><?php echo $_SESSION['TotalHT']; ?></td>
											</tr>
											<tr style=''>
												<td style='border:1px solid gray;'> TVA : </td>
												<td style='border-top:1px solid gray;text-align:right;'><?php echo $_SESSION['TotalTva']; ?></td>
											</tr>
											<tr style=''>
												<td style='border:1px solid gray;'>Total TTC :</td>
												<td style='border-top:1px solid gray;border-bottom:1px solid gray;text-align:right;'><?php echo $_SESSION['TotalTTC']=125588; ?></td>
											</tr>
											<tr style=''>
												<td style='border:1px solid gray;'>Remise :</td>
												<td style='border-top:1px solid gray;border-bottom:1px solid gray;text-align:right;'><?php echo $_SESSION['TotalTTC']=125588; ?></td>
											</tr>
											<tr style=''>
												<td style='border:1px solid gray;'>Net à payer :</td>
												<td style='border-top:1px solid gray;border-bottom:1px solid gray;text-align:right;'><?php echo $_SESSION['TotalTTC']=125588; ?></td>
											</tr>
										</table>
										</td>
							</tr>
							    <tr>
									<td colspan='5' align='left' style=''><font size='3' >
										<span style='font-style:italic;font-size:0.8em;'>
											Arreté le présent reçu à la somme de :
										<?php echo $p=chiffre_en_lettre($_SESSION['TotalTTC'], $devise1='francs CFA', $devise2=''); ?>
										</span>
									</td>
									</font>
								</tr>
						<?php
						//if(isset($signature)) Merci pour votre visite !  
							echo "
							<tr>
								<td align='right' colspan='5'>";
								//echo "<img src='logo/signature.png' alt='' title='' width='150' height='100' border='0'>	";
								//echo "<br/>".$signataireFordinaire.
								echo "<br/>Merci pour votre visite !</td>
							</tr>";
						?>


						<div style='float:left;border:1px solid maroon;'>

                    </tbody>
					<tr>
						<td align='left' colspan='5'>
							<?php
							//echo '<img style="float:left;" src="'.$dir . $timestamp.'".png" width="75px" height="75px">';
							?>
								<!--<h5 style="color: rgb(140, 140, 140);">Merci pour la visite!</h5> !-->
								<div style=''>&nbsp;&nbsp;&nbsp;


								</div>
							</td>
					</tr>

                </table>

                <!-- <button type="button" class="btn btn-success btn-lg btn-block" id='button-imprimer' class='noprt' title='Imprimer' style='clear:both;'>
                    <span class="glyphicon glyphicon-chevron-left"></span>  La satisfaction du client est notre priorité !  <span class="glyphicon glyphicon-chevron-right"></span>
                </button>  !-->
            </div>
        </div>
    </div>
		<?php
		 if(isset($_GET['receipt']))  //Réimpression de facture
			echo "</center>";
			?>
 </div>
