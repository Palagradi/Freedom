<?php
include_once'menu.php';

$sql=mysqli_query($con,"SELECT * FROM typeproduits LIMIT 1");
$result=mysqli_fetch_object($sql); $Numero=$result->Numero;$Famille=$result->Famille;$UnitStockage=$result->UnitStockage;$PoidsNet=$result->PoidsNet;$TypePrdts=$result->TypePrdts;
$DateService=$result->DateService;$DatePeremption=$result->DatePeremption;$Fournisseur=$result->Fournisseur;$PrixFournisseur=$result->PrixFournisseur;$StockAlerte=$result->StockAlerte;$PrixVente=$result->PrixVente;

if (isset($_POST['ENREGISTRER'])&& ($_POST['ENREGISTRER']=='Enrégistrer'))
{ 	$button_checkbox_1=isset($_POST['button_checkbox_1'])?1:0;$button_checkbox_2=isset($_POST['button_checkbox_2'])?2:0;$button_checkbox_3=isset($_POST['button_checkbox_3'])?3:0; $Numero=$button_checkbox_1+$button_checkbox_2+$button_checkbox_3;
	$button_checkbox_4=isset($_POST['button_checkbox_4'])?1:0;$button_checkbox_5=isset($_POST['button_checkbox_5'])?1:0;$button_checkbox_6=isset($_POST['button_checkbox_6'])?1:0;$button_checkbox_7=isset($_POST['button_checkbox_7'])?1:0;
	$button_checkbox_8=isset($_POST['button_checkbox_8'])?1:0;$button_checkbox_9=isset($_POST['button_checkbox_9'])?1:0;$button_checkbox_10=isset($_POST['button_checkbox_10'])?1:0;$button_checkbox_11=isset($_POST['button_checkbox_11'])?1:0;
	$button_checkbox_12=isset($_POST['button_checkbox_12'])?1:0;$button_checkbox_13=isset($_POST['button_checkbox_13'])?1:0;
    $rek="UPDATE typeproduits SET Numero='".$Numero."',Famille='".$button_checkbox_11."', UnitStockage='".$button_checkbox_4."',Fournisseur='".$button_checkbox_7."',PrixFournisseur='".$button_checkbox_8."',StockAlerte='".$button_checkbox_9."',PrixVente='".$button_checkbox_10."',TypePrdts='".$button_checkbox_5."',DateService='".$button_checkbox_12."',PoidsNet='".$button_checkbox_6."',DatePeremption='".$button_checkbox_13."'";
	$query = mysqli_query($con,$rek) or die (mysqli_error($con));
		if($query){
		echo "<script language='javascript'>";
		echo 'alertify.success(" Modification effectuée avec succès !");';
		echo "</script>";	
		}
		$sql=mysqli_query($con,"SELECT * FROM typeproduits LIMIT 1");
		$result=mysqli_fetch_object($sql); $Numero=$result->Numero;$Famille=$result->Famille;$UnitStockage=$result->UnitStockage;$PoidsNet=$result->PoidsNet;
		$DatePeremption=$result->DatePeremption;$Fournisseur=$result->Fournisseur;$PrixFournisseur=$result->PrixFournisseur;$StockAlerte=$result->StockAlerte;$PrixVente=$result->PrixVente;$TypePrdts=$result->TypePrdts;$DateService=$result->DateService;		
}
?><html>
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
					<br/><table align="center" width="800" height='500' border="1" BORDERCOLOR="white"  cellspacing="0" style="border:2px solid white;margin-top:0px;border-collapse: collapse;font-family:Cambria;background-color:#D0DCE0;">
					<caption style="text-align:center;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;"> <span style="font-style:italic;font-size:0.8em;color:red;"> </span></caption>

					<tr  style="background-color:#444739;color:white;font-size:1.2em; padding-bottom:5px;">
						<td colspan="3" align="center"><b>N° d'enrég. des produits <b/></td>
					</tr>
					<tr style="text-align:center;">
						<td style=''><input type='checkbox' id="button_checkbox_1" onClick="verifyCheckBoxes1();"  name="button_checkbox_1" <?php if($Numero==1) echo 'checked';   ?> ><label for="button_checkbox_1">Automatique	</label> </td>
						<td style=''><input type='checkbox' id="button_checkbox_2" onClick="verifyCheckBoxes2();"  name="button_checkbox_2" <?php if($Numero==2) echo 'checked="checked"';  ?>><label for="button_checkbox_2">Saisie manuelle</label></td>
						<td style=''><input type='checkbox' id="button_checkbox_3" onClick="verifyCheckBoxes3();"  name="button_checkbox_3" <?php if($Numero==3) echo 'checked="checked"';  ?>><label for="button_checkbox_3">Par un lecteur de barre de codes</label></td>
					</tr>
					<tr  style="background-color:#444739;color:white;font-size:1.2em; padding-bottom:5px;">
						<td colspan="3" align="center"><b>Caractéristiques des Produits <b/></td>
					</tr>
					<tr>
						<td colspan="2" style='padding-left:100px;'><input type='checkbox' id="button_checkbox_11" name="button_checkbox_11" <?php if($Famille==1) echo 'checked';  ?>><label for="button_checkbox_11">Famille </label></td>
						<td colspan="2" style='padding-left:100px;'><input type='checkbox' id="button_checkbox_5" name="button_checkbox_5"<?php if($TypePrdts==1) echo 'checked'; ?>><label for="button_checkbox_5"><a class='info' ><span style='font-size:0.9em;font-style:normal;color:black;'> Produits Vendables     <i>&nbsp;&nbsp;&nbsp;& </i> <br/><br/>Produits non Vendables</span>Type de Produits</a> </label></td>

					</tr>
					<tr>
						<td colspan="2" style='padding-left:100px;'><input type='checkbox' id="button_checkbox_4"  name="button_checkbox_4"<?php if($UnitStockage==1) echo 'checked ';  ?>><label for="button_checkbox_4">Unité de Stockage</label></td>
						<td colspan="2" style='padding-left:100px;'><input type='checkbox' id="button_checkbox_6" name="button_checkbox_6"<?php if($PoidsNet==1) echo 'checked ';   ?>><label for="button_checkbox_6">Poids Net</label></td>
					</tr>
					<tr>
						<td colspan="2" style='padding-left:100px;'><input type='checkbox' id="button_checkbox_13" name="button_checkbox_13"<?php if($DatePeremption==1) echo 'checked ';   ?>><label for="button_checkbox_13">Date de Péremption</label></td>
						<td colspan="2" style='padding-left:100px;'><input type='checkbox' id="button_checkbox_12" name="button_checkbox_12"<?php if($DateService==1) echo 'checked'; ?>><label for="button_checkbox_12">Date de Mise en Service </label></td>
					</tr>
					<tr>
						<td colspan="2" style='padding-left:100px;'><input type='checkbox' id="button_checkbox_7" name="button_checkbox_7"<?php if($Fournisseur==1) echo 'checked '; ?>><label for="button_checkbox_7">Fournisseur  </label></td>
						<td colspan="2" style='padding-left:100px;'><input type='checkbox' id="button_checkbox_8" name="button_checkbox_8"<?php if($PrixFournisseur==1) echo 'checked '; ?>><label for="button_checkbox_8">Prix Fournisseur</label></td>
					</tr>
					<tr>
						<td colspan="2" style='padding-left:100px;'><input type='checkbox' id="button_checkbox_9"  name="button_checkbox_9"<?php if($StockAlerte==1) echo 'checked ';  ?>><label for="button_checkbox_9">Stock d'alerte | Critique  </label></td>
						<td colspan="2" style='padding-left:100px;'><input type='checkbox' id="button_checkbox_10" name="button_checkbox_10"<?php if($PrixVente==1) echo 'checked '; ?>><label for="button_checkbox_10">Prix de Vente | Cession</label></td>
					</tr>

				<tr>
					<td  colspan="3" align="center" ><br/> <input type="submit" value="Enrégistrer" id="" class="bouton2"  name="ENREGISTRER" style=""/> 
					&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="Annuler" class="bouton2"  name="Annuler" style=""/> <br/>&nbsp;</td>
				</tr>
				</table>
	</form>
		</div>
	</body>