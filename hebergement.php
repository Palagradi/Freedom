<?php
include_once'menu.php';
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
      $button_checkbox_1 = isset($_POST['button_checkbox_1'])?$_POST['button_checkbox_1']:0;$button_checkbox_2 = isset($_POST['button_checkbox_2'])?$_POST['button_checkbox_2']:0;
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
  if(!empty($button_checkbox_1)&&($button_checkbox_1>0)) $var=$var." ".",RegimeTVA='".$button_checkbox_1."'";
  else $var=$var." ".",RegimeTVA='".$button_checkbox_2."'";
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
//$button_checkbox_1=1;
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

		<div align="" style="">
			<form action='' method='post' name='' enctype='multipart/form-data'>
					<table align="center" width="800" height='500' border="1" BORDERCOLOR="white"  cellspacing="0" style="border:2px solid white;margin-top:25px;border-collapse: collapse;font-family:Cambria;background-color:#D0DCE0;">
					<caption style="text-align:center;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;"> <span style="font-style:italic;font-size:0.8em;color:red;"> </span></caption>
					<tr style="background-color:#444739;color:white;font-size:1.2em; padding-bottom:5px;">
						<td colspan="2" align="center"><b>Informations générales sur l'Entreprise <b/></td>
					</tr>
					<tr>
						<!--<td  style="padding-left:80px;"> Caractéristique de l'Entreprise  : &nbsp;&nbsp;&nbsp;</td>
						<td >&nbsp;&nbsp;<i>Entreprise</i> &nbsp;&nbsp;&nbsp; !-->
						<input type='hidden'  min='0' max='100' id='' name='NbreEToile' style=''  onkeypress='testChiffres(event);' placeholder='<?php echo $NbreEToile; ?>'/>
						<!--<i>Etoile<?php if($NbreEToile>=1) echo "s";?></i> !-->
						</td>
					</tr>
					<tr>
						<td  style="padding-left:80px;"> Nom de l'Entreprise  : &nbsp;&nbsp;&nbsp;<span class="rouge"></span> </td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="nomHotel" style="width:250px;" placeholder='<?php echo $nomHotel; ?>' onkeyup='this.value=this.value.toUpperCase()' required="required"/> </td>
					</tr>
				<tr>
						<td  style="padding-left:80px;" >Logo de l'Entreprise :</td>
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
						<td >&nbsp;&nbsp;<input type="tel" id="" name="telephone1" style="width:250px;" placeholder='<?php echo $telephone1; ?>' value="" onkeypress='testChiffres(event);'/>

						</td>
				</tr>

					<tr>
						<td  style="padding-left:80px;" >Numéro de téléphone N°2 :</td>
						<td >&nbsp;&nbsp;<input type="tel" id="" name="telephone2" style="width:250px;" placeholder='<?php echo $telephone2; ?>' value="" onkeypress='testChiffres(event);'/>

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
            <td  style="padding-left:80px;" >Régime TVA  :</td>
              <td style=''>&nbsp;
                <input type="checkbox" id="button_checkbox_1"  name="button_checkbox_1" onClick="verifyCheckBoxes1();" value='1' <?php   if(!empty($RegimeTVA)&&($RegimeTVA==1)) echo "checked"; ?> >
                <label for="button_checkbox_1" >Exempté </label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type='checkbox'  id="button_checkbox_2"  name="button_checkbox_2" onClick="verifyCheckBoxes2();"  value='2' <?php   if(!empty($RegimeTVA)&&($RegimeTVA==2)) echo "checked"; ?>>
                <label for="button_checkbox_2">Assujetti </label>
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







		<br/>
	<table align='center' >
		<tr>
			<td bgcolor='#FF8080' >
			</td>
		</tr>
	</table>

</body>
