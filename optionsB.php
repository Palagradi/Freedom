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


		<div align="" style="">
				<form action='' method='post' name=''>
					<br/><table align="center" height='400' width="800" border="1" BORDERCOLOR="white"  cellspacing="0" style="border:2px solid white;margin-top:-10px;border-collapse: collapse;font-family:Cambria;background-color:#D0DCE0;">
					<caption style="text-align:center;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;"> <span style="font-style:italic;font-size:0.8em;color:red;"> </span></caption>



					<tr style="background-color:#444739;color:white;font-size:1.2em; padding-bottom:5px;">
						<td colspan="2" align="center"><b>EDITION DES FACTURES <b/></td>

					</tr>
								<tr>
						<td  style="padding-left:50px;"> Devise monétaire  : &nbsp;&nbsp;&nbsp;<span class="rouge">*</span> </td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="TypeProfil" style="width:250px;" placeholder='<?php echo $devise; ?>' required="required"/> </td>
					</tr>
						<tr>
							<td  style="padding-left:50px;" >Type d'impôt  :</td>
							<td >&nbsp;&nbsp;
								<?php echo "<select name='Impot' style='font-family:sans-serif;font-size:90%;border:0px solid black;width:250px;border:0px;' ";
								echo "<option value=''> </option>";
								$req = mysqli_query($con,"SELECT * FROM taxes") or die (mysqli_error($con));	//$t=0;
								while($data=mysqli_fetch_array($req))
								{  	echo "<option value=''> </option>";
									echo" <option value ='".$data['NomTaxe']."'> ".ucfirst($data['NomTaxe'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option> ";
								}
								echo "</select>"; ?>
							</td>
						</tr>
						<tr>
							<td  style="padding-left:50px;" >Signataire des Factures  :</td>
							<td >&nbsp;&nbsp;<input type="text" id="" name="code" style="width:250px;" placeholder='<?php  echo $signataireFordinaire; ?>' value="" />
							</td>
						</tr>

						<tr>
							<td  style="padding-left:50px;" >Insérer la Signature du signataire :</td>
						<td >&nbsp;&nbsp;<input id='file' type='file' accept='image/*' name='logoHotel' style="width:250px;"  required="required" />
						<label for="file" class="label-file">Choisir une image</label>
						</td>
						</tr>


				<!-- <tr>
						<td  style="padding-left:50px;" >Mot de passe par défaut d'un utilisateur créé :</td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="code" style="width:250px;" placeholder='<?php  echo $DefaultPassword; ?>' value="" />

						</td>
				</tr> !-->

					<tr>
						<td  colspan="2" align="center"><br/> <input type="submit" value="Enrégistrer" id="" class="bouton2"  name="enregistrer6" style=""/>
						&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="Annuler" class="bouton2"  name="Annuler" style=""/> <br/>&nbsp;</td>
					</tr>
		</div>
		<!--		<div style='margin-left:100px;'> !-->


<?php
//11 et 27 50 48 63
/* for($i=10;$i<=65;$i++){
	echo "
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='factures/example_0".$i.".php' target='BLANK'>ici la facture ".$i."</a><br/>";
} */
?>
<!-- </div> !-->
		 		
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
