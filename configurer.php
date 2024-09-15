<?php
include_once'menu.php';
/* 	$reqsel=mysqli_query($con,"SELECT * FROM autre_configuration");
			while($data=mysqli_fetch_array($reqsel))
				{  $taxe=$data['taxe'];
				   $etat_taxe=$data['etat_taxe'];
				   $limitation=$data['limitation'];
				   $limite_jrs=$data['limite_jrs'];
				   $fond=$data['fond'];
				}
	$reqsel=mysqli_query($con,"SELECT * FROM configuration_facture");
			while($data=mysqli_fetch_array($reqsel))
				{  $etat_facture=$data['etat_facture'];
				   $initial_grpe=$data['initial_grpe'];
				   $initial_reserv=$data['initial_reserv'];
				   $initial_fiche=$data['initial_fiche'];
				   $Nbre_char=$data['Nbre_char'];
				   $reimprimer=$data['reimprimer'];
				}
	$reqsel=mysqli_query($con,"SELECT * FROM configuration_client");
			while($data=mysqli_fetch_array($reqsel))
				{  $num_auto=$data['num_auto'];
				   $Nbre_chare=$data['Nbre_chare'];
				} */
    mysqli_query($con,"SET NAMES 'utf8'");
	        $numfiche=!empty($_GET['numfiche'])?$_GET['numfiche']:NULL;
			if($numfiche!='') {
		    $test = "UPDATE fiche1 SET Avertissement='OUI_D' WHERE numfiche='$numfiche' ";
			$requp = mysqli_query($con,$test) or die(mysqli_error($con));
			if(requp)
			$msg1="<span style='font-weight:bold;'>L'autorisation a été accordée au client pour un séjour de plus de 15 jours</span>";
			}
	if (isset($_POST['enregistrer1'])&& $_POST['enregistrer1']=='Enrégistrer')
		{
			$nomHotel = $_POST['nomHotel'];$logoHotel = isset($_POST['logoHotel'])?$_POST['logoHotel']:NULL;$NumUFI =!empty($_POST['NumUFI'])? $_POST['NumUFI']:NULL;$Apostale = $_POST['Apostale'];$NbreEToile = $_POST['NbreEToile']; 
			$telephone1 = $_POST['telephone1'];$telephone2 = $_POST['telephone2'];$Email = $_POST['Email'];$NumBancaire = $_POST['NumBancaire'];$Siteweb= $_POST['Siteweb'];

	if(isset($_FILES['logoHotel']))
	{ $fichier=mysqli_real_escape_string($con,htmlentities($_FILES['logoHotel']['name']));
	  $fichieR="logo/".$fichier;
	  //$taille=$_FILES['fichier']['size'];
	  $fichier2=explode('.',$fichier);
	  $ext_fichier=end($fichier2);
	  $query="UPDATE autre_configuration SET logo='".$fichieR."'";
	  $query1 = mysqli_query($con,$query) or die(mysql_error($con));
	  if($query1=true) {
		  move_uploaded_file($_FILES['logoHotel']['tmp_name'],'logo/'.$fichier);
	  }
	 
	$NbreEToile=!empty($NbreEToile)?$NbreEToile:1;
	$var="update hotel SET";
	if(!empty($nomHotel))   $var=$var." "."nomHotel='".$nomHotel."'";
	if(!empty($NumUFI))     $var=$var." ".",NumUFI='".$NumUFI."'";
	if(!empty($Apostale))   $var=$var." ".",Apostale='".$Apostale."'";
	if(!empty($telephone1)) $var=$var." ".",telephone1='".$telephone1."'";
	if(!empty($telephone2)) $var=$var." ".",telephone2='".$telephone2."'";
	if(!empty($Email)) 	    $var=$var." ".",Email='".$Email."'";
	if(!empty($Siteweb)) 	$var=$var." ".",Siteweb='".$Siteweb."'";
	if(!empty($NumBancaire))$var=$var." ".",NumBancaire='".$NumBancaire."'";
	if(!empty($fichier))    $var=$var." ".",logo='".$fichier."'";
	if(!empty($NbreEToile)) $var=$var." ".",NbreEToile='".$NbreEToile."'";
	 $query=$var;
	 $query1 = mysqli_query($con,$query) or die(mysqli_error($con));
	 
	 echo "<script language='javascript'>";
	 echo 'alertify.success("Enrégistrement effectué avec succès");';
	 echo "</script>";
	}else {
		 echo "<script language='javascript'>";
		 echo 'alertify.error("Vous devez mettre un logo");';
		 echo "</script>";
	}
}
if (isset($_POST['enregistrer2'])&& $_POST['enregistrer2']=='Enrégistrer')
	{	$NumeroLoyer = $_POST['NumeroLoyer']; $DLoyer = $_POST['DLoyer']; $NomLoc = $_POST['NomLoc'];
		$ContactLoc = $_POST['ContactLoc']; $MontantLoyer = $_POST['MLoyer']; $Dpayement = $_POST['Dpayement'];

		$query="INSERT INTO loyer SET Numero='$NumeroLoyer', Designation='$DLoyer',NomLoc='$NomLoc',ContactLoc='$ContactLoc',Montant='$MontantLoyer',DatePayement='$Dpayement'";
		 $query1 = mysqli_query($con,$query) or die(mysqli_error($con));
		 echo "<script language='javascript'>";
		 echo 'alertify.error("Enrégistrement effectué avec succès");';
		 echo "</script>";

	}

?>
<html>
	<head>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width">
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script type="text/javascript" src="js/verifyCheckBoxes1.js"></script>	
		<link rel="Stylesheet" type="text/css"  href='css/input.css' />
		<style>
		.label-file {
		cursor: pointer;
		color: #00b1ca;
		font-weight: bold;
		}
		.label-file:hover {
			color: #25a5c4;
		}
		#file {
			display: none;visibility: hidden;
		}
		</style>
	</head>
	<body bgcolor='azure' style="">
	<!--
		<div align="" style="">
			<form action='' method='post' name='' enctype='multipart/form-data'>
					<table align="center" width="800" border="1" BORDERCOLOR="white"  cellspacing="0" style="border:2px solid white;margin-top:0px;border-collapse: collapse;font-family:Cambria;background-color:#D0DCE0;">
					<caption style="text-align:center;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;"> <span style="font-style:italic;font-size:0.8em;color:red;"> </span></caption>
					<tr style="background-color:#444739;color:white;font-size:1.2em; padding-bottom:5px;">
						<td colspan="2" align="center"><b>Informations générales sur l'hôtel <b/></td>
					</tr>
					<tr>
						<td  style="padding-left:80px;"> Caractéristique de l'hôtel  : &nbsp;&nbsp;&nbsp;</td>
						<td >&nbsp;&nbsp;<i>Hôtel</i> &nbsp;&nbsp;&nbsp;
						<input type='number'  min='0' max='100' id='' name='NbreEToile' style=''  onkeypress='testChiffres(event);' placeholder='<?php echo $NbreEToile; ?>'/> <i>Etoile<?php if($NbreEToile>=1) echo "s";?></i>
						</td>
					</tr>
					<tr>
						<td  style="padding-left:80px;"> Nom de l'hôtel  : &nbsp;&nbsp;&nbsp;<span class="rouge"></span> </td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="nomHotel" style="width:250px;" placeholder='<?php echo $nomHotel; ?>' onkeyup='this.value=this.value.toUpperCase()' required="required"/> </td>
					</tr>
				<tr>
						<td  style="padding-left:80px;" >Logo de l'hôtel :</td>
						<td >&nbsp;&nbsp;<input id='file' type='file' accept='image/*' name='logoHotel' style="width:250px;"  required="required" />
						<label for="file" class="label-file">Choisir une image</label>
						</td>
				</tr>

					<tr>
						<td  style="padding-left:80px;"> N° IFU  : &nbsp;&nbsp;&nbsp;<span class="rouge"></span> </td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="NumUFI" maxlength='14'  style="width:250px;" placeholder='<?php echo $NumUFI; ?>' onkeypress="testChiffres(event);" /> </td>
					</tr>
				<tr>
						<td  style="padding-left:80px;" >Adresse postale  :</td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="Apostale" style="width:250px;" placeholder='<?php echo $Apostale; ?>' value="" />

						</td>
				</tr>
				<tr>
						<td  style="padding-left:80px;" >Numéro de téléphone N°1 :&nbsp;&nbsp;&nbsp;<span class="rouge"></span></td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="telephone1" style="width:250px;" placeholder='<?php echo $telephone1; ?>' value="" />

						</td>
				</tr>

					<tr>
						<td  style="padding-left:80px;" >Numéro de téléphone N°2 :</td>
						<td >&nbsp;&nbsp;<input type="tel" id="" name="telephone2" style="width:250px;" placeholder='<?php echo $telephone2; ?>' value="" />

						</td>
				</tr>
								<tr>
						<td  style="padding-left:80px;" >E-mail :</td>
						<td >&nbsp;&nbsp;<input type="email" id="" name="Email" style="width:250px;" placeholder='<?php echo $Email; ?>' value="" />

						</td>
				</tr>
												<tr>
						<td  style="padding-left:80px;" >Site web :</td>
						<td >&nbsp;&nbsp;<input type="url" id="" name="Siteweb" style="width:250px;" placeholder='<?php echo $Siteweb; ?>' value="" />

						</td>
				</tr>
									<tr>
						<td  style="padding-left:80px;" >N° de compte bancaire :</td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="NumBancaire" style="width:250px;" placeholder='<?php  echo $NumBancaire; ?>' value="" />

						</td>
				</tr>


					<tr>
						<td  colspan='2' align="center" ><br/> <input type="submit" value="Enrégistrer"  name="enregistrer1"  id="" class="bouton2"  style=""/>
						&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="Annuler" class="bouton2"  name="Annuler" style=""/> <br/>&nbsp;&nbsp;</td>
					</tr>
			
		</form>
	<table align='center' >
		<tr>
			<td bgcolor='#FF8080' >
			   <?php //echo $msg1;
				 ?>
			</td>
		</tr>
	</table>
		</div>
!-->


				<div align="" style="margin-top:-3%;">
				<form action='' method='post' name=''>
					<br/><table align="center" width="800" border="1" BORDERCOLOR="white"  cellspacing="0" style="border:2px solid white;margin-top:0px;border-collapse: collapse;font-family:Cambria;background-color:#D0DCE0;">
					<caption style="text-align:center;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;"> <span style="font-style:italic;font-size:0.8em;color:red;"> </span></caption>

					<tr  style="background-color:#444739;color:white;font-size:1.2em; padding-bottom:5px;">
						<td colspan="2" align="center"><b>Taxe sur Nuitée - Durée de la Nuitée <b/></td>

					</tr>
				<tr >
						<td  style="padding-left:130px;" >Montant de la Taxe sur Nuitée :</td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="code" style="width:250px;" placeholder='<?php echo $Mtaxe; ?>' value="" />

						</td>
				</tr>
				<tr>
						<td   style="padding-left:130px;" >Critère d'application de la Taxe  :</td>
							<td style=''>
								<input type="checkbox" id="button_checkbox_1"  onClick="verifyCheckBoxes1();" ><label for="button_checkbox_1" >Par personne logée	</label>
								<input type='checkbox'  id="button_checkbox_2"  onClick="verifyCheckBoxes2();" ><label for="button_checkbox_2">Par chambre louée</label>			
						</td>
				</tr>
				<tr>
						<td  style="padding-left:130px;"> Durée de la Nuitée  : &nbsp;&nbsp;&nbsp;<span class="rouge">*</span> </td>
						<td style="">&nbsp;&nbsp;- de -
						<select name='edit17'style="font-family:sans-serif;font-size:80%;">
							<option value='<?php echo '';?>'> <?php echo ' ';?></option>
							<?php
								for($i=1;$i<=12;$i++)
								echo "<option value='$i'> $i</option>";
							?>
						</select>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- à -
						<select name='edit17'style="font-family:sans-serif;font-size:80%;">
							<option value='<?php echo '';?>'> <?php echo '';?></option>
							<?php
								for($i=1;$i<=12;$i++)
								echo "<option value='$i'> $i</option>";
							?>
						</select> &nbsp;heures
					</td>
					</tr>
					<tr>
						<td  style="padding-left:130px;" >Limitation de la durée de séjour :</td>
						<td style=''>&nbsp;&nbsp;<input type="text" id="" name="code" style="width:250px;" placeholder='<?php echo $limite_jrs; ?>' value="" /> jours

						</td>
				</tr>

		<tr>
						<td  colspan="2" align="center" ><br/> <input type="submit" value="Enrégistrer" id="" class="bouton2"  name="enregistrer4" style=""/> 
						&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="Annuler" class="bouton2"  name="Annuler" style=""/> <br/>&nbsp;</td>
					</tr>
	</form>
		</div>
		<div align="" style="">
				<form action='' method='post' name=''>
					<br/><table align="center" width="800" border="1" BORDERCOLOR="white"  cellspacing="0" style="border:2px solid white;margin-top:0px;border-collapse: collapse;font-family:Cambria;background-color:#D0DCE0;">
					<caption style="text-align:center;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;"> <span style="font-style:italic;font-size:0.8em;color:red;"> </span></caption>



					<tr style="background-color:#444739;color:white;font-size:1.2em; padding-bottom:5px;">
						<td colspan="2" align="center"><b>Autres Paramètres <b/></td>

					</tr>
								<tr>
						<td  style="padding-left:50px;"> Devise monétaire  : &nbsp;&nbsp;&nbsp;<span class="rouge">*</span> </td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="TypeProfil" style="width:250px;" placeholder='<?php echo $devise; ?>' required="required"/> </td>
					</tr>
									<tr>
						<td  style="padding-left:50px;" >Initial fiche individuel  :</td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="code" style="width:250px;" placeholder='<?php echo $initial_fiche; ?>' value="" />

						</td>
				</tr>
				<tr>
						<td  style="padding-left:50px;" >Initial de fiche de groupe :</td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="code" style="width:250px;" placeholder='<?php echo $initial_grpe; ?>' value="" />

						</td>
				</tr>

					<tr>
						<td  style="padding-left:50px;" >Initial fiche de réservation :</td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="code" style="width:250px;" placeholder='<?php echo $initial_reserv; ?>' value="" />

						</td>
				</tr>
								<tr>
						<td  style="padding-left:50px;" >Initial de facture pro forma :</td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="code" style="width:250px;" placeholder='<?php echo $initial_proforma; ?>' value="" />

						</td>
				</tr>
									<tr>
						<td  style="padding-left:50px;" >Signataire des factures ordinaires :</td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="code" style="width:250px;" placeholder='<?php  echo $signataireFordinaire; ?>' value="" />

						</td>
				</tr>
													<tr>
						<td  style="padding-left:50px;" >Signataire des factures pro forma :</td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="code" style="width:250px;" placeholder='<?php echo $signatairepforma; ?>' value="" />

						</td>
				</tr>
																	<tr>
						<td  style="padding-left:50px;" >Signataire des lettres de relance :</td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="code" style="width:250px;" placeholder='<?php  echo $signataireLrelance; ?>' value="" />

						</td>
				</tr>
																					<tr>
						<td  style="padding-left:50px;" >Signataire des attestations de réservations :</td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="code" style="width:250px;" placeholder='<?php  echo $signataireAreservation; ?>' value="" />

						</td>
				</tr>
													<tr>
						<td  style="padding-left:50px;" >Mot de passe par défaut d'un utilisateur créé :</td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="code" style="width:250px;" placeholder='<?php  echo $DefaultPassword; ?>' value="" />

						</td>
				</tr>

					<tr>
						<td  colspan="2" align="center"><br/> <input type="submit" value="Enrégistrer" id="" class="bouton2"  name="enregistrer6" style=""/>
						&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="Annuler" class="bouton2"  name="Annuler" style=""/> <br/>&nbsp;</td>
					</tr>
		</div>
				<div align="" style="">
				<form action='' method='post' name=''>
					<br/><table align="center" width="800" border="1" BORDERCOLOR="white"  cellspacing="0" style="border:2px solid white;margin-top:0px;border-collapse: collapse;font-family:Cambria;background-color:#D0DCE0;">
					<caption style="text-align:center;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;"> <span style="font-style:italic;font-size:0.8em;color:red;"> </span></caption>



					<tr style="background-color:#444739;color:white;font-size:1.2em; padding-bottom:5px;">
						<td colspan="2" align="center"><b>Gestion des Impôts<b/></td>

					</tr>

									<tr>
						<td  style="padding-left:200px;"> Impôt  : &nbsp;&nbsp;&nbsp;<span class="rouge"></span> </td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="" name="TypeProfil" style="width:250px;"  required="required"/> </td>
					</tr>
									<tr>
						<td style="padding-left:200px;"> Pourcentage  : &nbsp;&nbsp;&nbsp;<span class="rouge"></span> %</td>
						<td >&nbsp;&nbsp;<input type="number" min='1' max='100' name="TypeProfil" style="width:250px;height:21px;font-style:sans-serif;font-size:90%;" required="required"/> </td>
					</tr>
					<tr>
						<td  align="center" colspan='2'><br/> <input type="submit" value="Enrégistrer" id="" class="bouton2"  name="enregistrer3" /> 
						&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="Annuler" class="bouton2"  name="Annuler" /><br/>&nbsp;&nbsp; </td>
					</tr>


			<tr> <td colspan="2">
			<table align='center' width="80%"  border="1" BORDERCOLOR="white" cellspacing="0" style="margin-top:20px;border-collapse: collapse;font-family:Cambria;">
					<tr> <td colspan='4'>
						<h5 style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;color:#008080;"> Liste des Impôts </h5>
						</td>
					</tr>
					<tr style="background-color:#EFECCA;color:maroon;font-size:1em; padding-bottom:5px;font-weight:bold;">
						<td style="border-right: 2px solid #ffffff" align="center" >N° </td>
						<td style="border-right: 2px solid #ffffff" align="center" >Impôt &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Pourcentage </td>
						<td align="center" >Actions</td>
					</tr>
					<?php

							mysqli_query($con,"SET NAMES 'utf8'");
							$reqsel=mysqli_query($con,"SELECT * FROM taxes");
							$cpteur=1; $i=0;
							while($data=mysqli_fetch_array($reqsel))
							{ $i++;
								if($cpteur == 1)
								{
									$cpteur = 0;
									$bgcouleur = "#DDEEDD";  //#3EB27B 
								}
								else
								{
									$cpteur = 1;
									$bgcouleur = "#dfeef3";
								}$valeurTaxe=$data['valeurTaxe']*100;
								echo " 	<tr class='rouge2' bgcolor='".$bgcouleur."'>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$i.".</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$data['NomTaxe']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$valeurTaxe."%</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
											echo " 	<a class='info2' href='configurer.php?ggg'><img src='logo/b_edit.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.8em;'>Modifier</span></a>";
											//echo " 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
											//echo " 	<a class='info2' href='configurer.php?CodeProfil =".$data['CodeProfil']."&supp=ok'><img src='logo/b_drop.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.8em;'>Supprimer</span></a>";
										echo " 	</td>";
									echo " 	</tr> ";
							}
					?>
				</table>
				</tr> </td> </table>
	</form></div>


				<div align="" style="margin-top:0%;">
				<form action='' method='post' name=''>
					<br/><table align="center" width="800" border="1" BORDERCOLOR="white"  cellspacing="0" style="border:2px solid white;margin-top:0px;border-collapse: collapse;font-family:Cambria;background-color:#D0DCE0;">
					<caption style="text-align:center;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;"> <span style="font-style:italic;font-size:0.8em;color:red;"> </span></caption>



					<tr style="background-color:#444739;color:white;font-size:1.2em; padding-bottom:5px;">
						<td colspan="2" align="center"><b>Gestion des Services Extra <b/></td>

					</tr>
				<tr>
						<td  style="padding-left:50px;" >Code :</td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="code" style="width:250px;" value="" /> </td>
				</tr>
								<tr>
						<td  style="padding-left:50px;"> Désignation du Service Extra  : &nbsp;&nbsp;&nbsp;<span class="rouge">*</span> </td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="TypeProfil" style="width:250px;" required="required"/> </td>
					</tr>
									<tr>
						<td  style="padding-left:50px;"> Unité de mesure - Facturation  : &nbsp;&nbsp;&nbsp;<span class="rouge">*</span> </td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="" name="TypeProfil" style="width:250px;" required="required"/> </td>
					</tr>
									<tr>
						<td style="padding-left:50px;"> Montant unitaire  : &nbsp;&nbsp;&nbsp;<span class="rouge">*</span> </td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="TypeProfil" style="width:250px;" required="required"/> </td>
					</tr>
		<tr>
						<td  colspan="2" align="center" ><br/> <input type="submit" value="Enrégistrer" id="" class="bouton2"  name="enregistrer5" style=""/> 
						&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="Annuler" class="bouton2"  name="Annuler" style=""/> <br/>&nbsp;</td>
					</tr>


			<tr> <td colspan="2">
			<table align='center' width="90%"  border="1" BORDERCOLOR="white" cellspacing="0" style="margin-top:20px;border-collapse: collapse;font-family:Cambria;">
					<tr> <td colspan='5'>
						<h5 style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;color:#008080;"> Liste des Frais Connexes</h5>
						</td>
					</tr>
					<caption style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#008080;">  </caption>
					<tr style="background-color:#EFECCA;color:maroon;font-size:1em; padding-bottom:5px;font-weight:bold;">
						<td style="border-right: 2px solid #ffffff" align="center" >N° </td>
						<td style="border-right: 2px solid #ffffff" align="center" >Désignation </td>
						<td style="border-right: 2px solid #ffffff" align="center" >Unité de facturation </td>
					<td style="border-right: 2px solid #ffffff" align="center" >Montant unitaire </td>
						<td align="center" >Actions</td>
					</tr>
					<?php

									mysqli_query($con,"SET NAMES 'utf8'");
		$reqsel=mysqli_query($con,"SELECT * FROM connexe");
		$cpteur=1; $i=0;
							while($data=mysqli_fetch_array($reqsel))
							{ $i++;
								if($cpteur == 1)
								{
									$cpteur = 0;
									$bgcouleur = "#DDEEDD";
								}
								else
								{
									$cpteur = 1;
									$bgcouleur = "#dfeef3";
								}
								echo " 	<tr class='rouge2' bgcolor='".$bgcouleur."'>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$i.".</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$data['NomFraisConnexe']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$data['Unites']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$data['Unites']."</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
											echo " 	<a class='info2' href='configurer.php?edit'><img src='logo/b_edit.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.8em;'>Modifier</span></a>";
											echo " 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
											echo " 	<a class='info2' href='configurer.php?supp=ok'><img src='logo/b_drop.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.8em;'>Supprimer</span></a>";
										echo " 	</td>";
									echo " 	</tr> ";
							}
					?>
				</table>
				</tr> </td> </table>
			
	</form>
</div>


				
		</div>

		</form>

		<br/>
	<table align='center' >
		<tr>
			<td bgcolor='#FF8080' >
			</td>
		</tr>
	</table>

</body>
