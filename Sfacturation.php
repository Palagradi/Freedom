<?php
include_once'menu.php';

$sql=mysqli_query($con,"SELECT TypeFacture FROM autre_configuration LIMIT 1");
$result=mysqli_fetch_object($sql); $TypeFacture=$result->TypeFacture;//$Famille=$result->Famille;
//$UnitStockage=$result->UnitStockage;$PoidsNet=$result->PoidsNet;$TypePrdts=$result->TypePrdts;
//$DateService=$result->DateService;$DatePeremption=$result->DatePeremption;$Fournisseur=$result->Fournisseur;$PrixFournisseur=$result->PrixFournisseur;$StockAlerte=$result->StockAlerte;$PrixVente=$result->PrixVente;


if (isset($_POST['ENREGISTRER'])&& $_POST['ENREGISTRER']=='Enrégistrer')
	{
	//$button_checkbox_1=isset($_POST['button_checkbox_1'])?1:0;
	$button_checkbox_2=isset($_POST['button_checkbox_2'])?0:0;$button_checkbox_3=isset($_POST['button_checkbox_3'])?1:0;
	$TypeFacture=$button_checkbox_2+$button_checkbox_3;

	$query="UPDATE autre_configuration SET TypeFacture='".$TypeFacture."'";
	$query1 = mysqli_query($con,$query) or die(mysql_error($con));

	$button_checkbox4=isset($_POST['button_checkbox4'])?1:0;
	$button_checkbox5=isset($_POST['button_checkbox5'])?1:0;

	$query="UPDATE serveurused SET state='".$button_checkbox4."' WHERE name='mecef'";
	$query1 = mysqli_query($con,$query) or die(mysql_error($con));

	$query="UPDATE serveurused SET state='".$button_checkbox5."' WHERE name='emecef'";
	$query1 = mysqli_query($con,$query) or die(mysql_error($con));


	echo "<script language='javascript'>";
	echo 'alertify.success("Enrégistrement effectué avec succès");';
	echo "</script>";

/* 	$nomHotel = $_POST['nomHotel'];$logoHotel = isset($_POST['logoHotel'])?$_POST['logoHotel']:NULL;$NumUFI =!empty($_POST['NumUFI'])? $_POST['NumUFI']:NULL;$Apostale = $_POST['Apostale'];$NbreEToile = $_POST['NbreEToile'];
			$telephone1 = $_POST['telephone1'];$telephone2 = $_POST['telephone2'];$Email = $_POST['Email'];$NumBancaire = $_POST['NumBancaire'];$Siteweb= $_POST['Siteweb']; */

/* 	if(isset($_FILES['logoHotel']))
	{ $fichier=mysqli_real_escape_string($con,htmlentities($_FILES['logoHotel']['name']));
	  $fichieR="logo/".$fichier;
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
	} */

	$sql=mysqli_query($con,"SELECT TypeFacture FROM autre_configuration LIMIT 1");
	$result=mysqli_fetch_object($sql); $TypeFacture=$result->TypeFacture;
}


$res=mysqli_query($con,"SELECT name FROM serveurused WHERE state =1");
	$ret=mysqli_fetch_assoc($res);
//if(mysqli_num_rows($res)>0)
	//if($ret['name']='emecef');

?><html>
	<head>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width">
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script type="text/javascript" src="js/verifyCheckBoxes2.js"></script>
		<script type="text/javascript" src="js/verifyCheckBoxes4.js"></script>
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
					<br/><table align="center" width="800" height='500' border="1" BORDERCOLOR="white"  cellspacing="0" style="border:2px solid white;margin-top:0px;border-collapse: collapse;font-family:Cambria;background-color:#D0DCE0;">
					<caption style="text-align:center;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;"> <span style="font-style:italic;font-size:0.8em;color:red;"> </span></caption>

					<tr  style="background-color:gray;color:white;font-size:1.2em; padding-bottom:5px;">
						<td colspan="3" align="center"><b>PROCESSUS DE NORMALISATION<b/></td>
					</tr>
					<tr style="text-align:center;">
								<td style=''><input type='checkbox' id="button_checkbox5" onClick="verifyCheckBoxes5();"  name="button_checkbox5" <?php if($ret['name']=='emecef') echo 'checked="checked"';  ?>><label for="button_checkbox5">eMECeF (en ligne)</label></td>
								<td style=''><input type='checkbox' id="button_checkbox4" onClick="verifyCheckBoxes4();"  name="button_checkbox4" <?php if($ret['name']=='mecef') echo 'checked="checked"';  ?>><label for="button_checkbox4">MECeF (Machine physique)</label></td>
					</tr>


					<tr  style="background-color:gray;color:white;font-size:1.2em; padding-bottom:5px;">
						<td colspan="3" align="center"><b>TYPE DE FACTURES <b/></td>
					</tr>
					<tr style="text-align:center;">
								<td style=''><input type='checkbox' id="button_checkbox_3" onClick="verifyCheckBoxes3();"  name="button_checkbox_3" <?php if($TypeFacture==1) echo 'checked="checked"';  ?>><label for="button_checkbox_3">Facture normalisée</label></td>
								<td style=''><input type='checkbox' id="button_checkbox_2" onClick="verifyCheckBoxes2();"  name="button_checkbox_2" <?php if($TypeFacture==0) echo 'checked="checked"';  ?>><label for="button_checkbox_2">Facture ordinaire</label></td>
					</tr>

					<tr style="background-color:gray;color:white;font-size:1.2em; padding-bottom:5px;">
						<td colspan="3" align="center"><b>EDITION DES FACTURES <b/></td>

					</tr>
					<tr>
						<td  colspan="3" style="padding-left:95px;"> Devise monétaire  :
						<input type="text" id="" name="TypeProfil" style="margin-left:100px;width:250px;" placeholder='<?php echo $devise; ?>' /> </td>
					</tr>
						<tr>
							<td  colspan="3" style="padding-left:95px;"> Type d'impôt  :
								<select name='Impot' style='margin-left:130px;width:250px;'>
								<?php //echo " ";
								echo "<option value=''> </option>";
								$req = mysqli_query($con,"SELECT * FROM taxes") or die (mysqli_error($con));	//$t=0;
								while($data=mysqli_fetch_array($req))
								{  	echo "<option value=''> </option>";
									echo" <option value ='".$data['NomTaxe']."'> ".ucfirst($data['NomTaxe'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option> ";
								}
								//echo ""; ?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="3" style="padding-left:95px;" >Signataire des Factures  :
							<input type="text" id="" name="code" style="margin-left:60px;width:250px;" placeholder='<?php  echo $signataireFordinaire; ?>' value="" />
							</td>
						</tr>

						<tr>
							<td colspan="3" style="padding-left:95px;">Insérer la signature du signataire :
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  type='file' accept='image/*' name='logoHotel' style=""  />  <!-- id='file' !-->
						<!-- <label for="file" <class="label-file"  >Choisir une image</label> !-->
						</td>
						</tr>



				<tr>
					<td  colspan="3" align="center" ><br/> <input type="submit" value="Enrégistrer" id="" class="bouton2"  name="ENREGISTRER" style=""/>
					&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="Annuler" class="bouton2"  name="Annuler" style=""/> <br/>&nbsp;</td>
				</tr>
				</table>
	</form>
		</div>
	</body>
