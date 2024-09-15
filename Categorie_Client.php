<?php
include 'menu.php';
	//require("configuration.php");
		mysqli_query($con,"SET NAMES 'utf8'");
		$reqsel=mysqli_query($con,"SELECT * FROM categorieclient ORDER BY pourcentage DESC");
		$code = isset($_POST['code'])?$_POST['code']:NULL;
		$Designation = isset($_POST['Designation'])?$_POST['Designation']:NULL;$Designation = ucfirst($Designation);
		$NbreVisite = isset($_POST['NbreVisite'])?$_POST['NbreVisite']:NULL;
		$DesignatioN=explode(" ",$Designation);
		$DesignatioN_0=!empty($DesignatioN[0])?$DesignatioN[0]:NULL;
		$DesignatioN_1=!empty($DesignatioN[1])?$DesignatioN[1]:NULL;
		$DesignatioN_2=!empty($DesignatioN[2])?$DesignatioN[2]:NULL;
		$DesignatioN_3=!empty($DesignatioN[3])?$DesignatioN[3]:NULL;
		$DesignatioN_4=!empty($DesignatioN[4])?$DesignatioN[4]:NULL;
		if(($DesignatioN_0=="Client")||($DesignatioN_0=="Clients"))
			{ $DesignatioN=$DesignatioN_1." ".$DesignatioN_2." ".$DesignatioN_3." ".$DesignatioN_4;
				 $Designation = trim($DesignatioN);
			}
		else
			{ $DesignatioN=$DesignatioN_0." ".$DesignatioN_1." ".$DesignatioN_2." ".$DesignatioN_3;
				 $Designation =trim($DesignatioN);
			}
		$Frequence = isset($_POST['Frequence'])?$_POST['Frequence']:NULL;
		$Recette = (isset($_POST['Recette'])&&!empty($_POST['Recette']))?$_POST['Recette']:0;
		if(!empty($_POST['check1'])) $check = $_POST['check1']; else $check = isset($_POST['check2'])?$_POST['check2']:NULL;
		$Pourcentage = isset($_POST['Pourcentage'])?$_POST['Pourcentage']:NULL;
		$procede = isset($_POST['procede'])?$_POST['procede']:NULL;
		if(isset($_POST['enregistrer']) && $_POST['enregistrer'] == "Enregistrer")
		{	if($Designation=="")
			{
				$message = "Vous devez saisir le nom de la Catégorie.";
				echo "<script language='javascript'>";
					echo " alert('Vous devez saisir le nom de la Catégorie.');";
					echo "</script>";
				$ok = false;
			}else
			{	if((!empty($NbreVisite))||(!empty($Frequence))||(!empty($Recette))){
						//Vérification de l'existance du nom du Catégorie
					$req = mysqli_query($con,"SELECT * FROM categorieclient WHERE NomCat='".$Designation."' ");

					if(mysqli_num_rows($req) >= 1)
					{
						$message = "Cette Catégorie existe déjà, veuillez en choisir un autre.";
						echo "<script language='javascript'>";
						echo " alert('Cette Catégorie existe déjà, veuillez en choisir une autre.');";
						echo "</script>";
						$ok = false;
					}
					else
					{   $query = mysqli_query($con,"SELECT * FROM categorieclient WHERE frequence='".$Frequence."' AND MoisAns='".$check."' AND Recette='".$Recette."' AND NbreVisite='".$NbreVisite."'");
						if(mysqli_num_rows($query) >= 1){
						$ret= mysqli_fetch_assoc($query);
						$NomCat=$ret['NomCat'];
						echo "<script language='javascript'>";
						echo " alert('Ces caractéristiques correspondent à celles d\'un autre client.');";
						echo "</script>";
						}else{
					 	$pre_sql1="INSERT INTO categorieclient VALUES('$code','".$Designation."','".$Frequence."','".$check."','".$Recette."','".$NbreVisite."','".$Pourcentage."','".$procede."')";
						$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
						$message = "La Catégorie du client a bien été enregistrée";
						mysqli_query($con,"SET NAMES 'utf8'");
						$reqsel=mysqli_query($con,"SELECT * FROM categorieclient ORDER BY pourcentage DESC");
						echo "<script language='javascript'>";
						//echo " alert('La  profil a bien été enregistrée');";
						mysqli_query($con,"SET NAMES 'utf8'");
						$reqsel=mysqli_query($con,"SELECT * FROM categorieclient ORDER BY pourcentage DESC ");
						echo 'alertify.success("La Catégorie a bien été enregistrée !");';
						echo "</script>";
						$ok = true;}
					}
				}else{
						echo "<script language='javascript'>";
						echo " alert('Caractéristiques d\'un client ordinaire.');";
						echo "</script>";
				}

			}
		}
	//}

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title><?php echo $title; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="Stylesheet" type="text/css" media="screen, print" href="style.css">
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>
		<link rel="Stylesheet" href='css/table.css' />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width">
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>


	</head>
	<body bgcolor='azure' style="">
	<div align="" style="">
			<form action="" method="POST">
			<table align='center' width="800" height="350" border="0" cellpadding="0" cellspacing="0" id="tab">
					<tr>
						<td colspan="4">
							<h3 style='text-align:center; font-family:Cambria;color:maroon;font-weight:bold;'>CATEGORISATION DES CLIENTS</h3>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:left; color:#d10808;font-size:0.8em;font-style:italic;"> Les champs marqués de <span class="rouge">*</span> sont obligatoires</td>
					</tr>
					<tr>
						<td  style="padding-left:50px;" >Code catégorie :</td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="code" style="width:200px;"
					value="<?php
					echo $chaine1 = substr(random(50,'C'),0,5);

					?>" onFocus="this.blur()"	/> </td>
					</tr>
					<tr>
						<td style="padding-left:50px;"> Désignation de la Catégorie  : &nbsp;&nbsp;&nbsp;<span style="color:#d10808;font-weight:bold;">*</span> </td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="Designation" style="width:200px;" required="required"/> </td>
					</tr>
					<tr>
						<td  style="padding-left:50px;"> Nbre de visite  : &nbsp;&nbsp;&nbsp;<span style="font-size:0.8em;color:#d10808;font-style:italic;"></span>
						</td>
						<td  >&nbsp;&nbsp;<input type="number"  min="0" id="" name="NbreVisite" style="width:100px;" onkeypress="testChiffres(event);"/>

						</td>
					</tr>
					<tr>
						<td  style="padding-left:50px;"> Fréquence  : &nbsp;&nbsp;&nbsp;<span style="color:#d10808;font-weight:bold;">*</span> </td>
						<td >&nbsp;&nbsp;<input type="number" min="0" id="" name="Frequence" style="width:100px;" onkeypress="testChiffres(event);"/>
						<input type="checkbox" id="button_checkbox_1" name="check1" style="" value="Mois" onClick="verifyCheckBoxes1();" /> Mois
						<input type="checkbox" id="button_checkbox_2" name="check2" style="" value="Ans" onClick="verifyCheckBoxes2();" /> Ans</td>
					</tr>
						<tr>
						<td  style="padding-left:50px;"> Montant de la Recette   : &nbsp;&nbsp;&nbsp;<span style="color:#d10808;font-weight:bold;"></span> </td>
						<td colspan="2" >&nbsp;&nbsp;<input type="text" id="" name="Recette" style="width:200px;" onkeypress="testChiffres(event);"/> </td>
					</tr>
					<tr>
						<td style="padding-left:50px;"> Pourcentage de Réduction appliqué :</td>
							<td colspan="2" >&nbsp;&nbsp;<input type="number"  min="0" max="100" id="" name="Pourcentage" style="width:100px;" onkeypress="testChiffres(event);"/>
						&nbsp;&nbsp;&nbsp;<span style="color:#d10808;font-style:italic;font-size:0.8em;"> en %</span>
						</td>
					</tr>
									<tr>
						<td  style="padding-left:50px;"> Procédé d'application de la Réduction : &nbsp;&nbsp;&nbsp; </td>
						<td >&nbsp;
								<select name="procede" style="border:0px solid black;width:200px;">
									<option value='Manuelle'>Manuel </option>
									<option value='Automatique'>Automatique </option>
								</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center" ><br/> <input type="submit" value="Enregistrer" id="" class="bouton2"  name="enregistrer" style=""/>
						&nbsp;&nbsp;<input type="reset" value="Annuler" class="bouton2"  name="Annuler" style=""/> </td>
					</tr>
				</table>
				<table align='center' width="800"  border="0" cellspacing="0" style="margin-top:40px;border-collapse: collapse;font-family:Cambria;">
					<tr><td colspan='9'>
					<h3 style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#444739;">  Liste des Catégories de Clients </h3>
					</td></tr>
					<tr style=" background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;">
						<td style="border-right: 2px solid #ffffff" align="center" >N° </td>
						<td style="border-right: 2px solid #ffffff" align="center" >Code </td>
						<td style="border-right: 2px solid #ffffff" align="" >Catégorie </td>
						<td style="border-right: 2px solid #ffffff" align="" >Nbre de visite </td>
						<td style="border-right: 2px solid #ffffff" align="" >Fréquence </td>
						<td style="border-right: 2px solid #ffffff" align="" >Recette </td>
					<td style="border-right: 2px solid #ffffff" align="" >Pourcentage </td>
					<td style="border-right: 2px solid #ffffff" align="" >Application</td>
						<td align="center" >Actions</td>
					</tr>
					<?php
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
								echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>";  $Nbre=!empty($data['Nbre'])?$data['Nbre']:NULL; $pourcentage=!empty($data['pourcentage'])?$data['pourcentage']:NULL;	$frequence=!empty($data['frequence'])?$data['frequence']:NULL;
								if($Nbre==0) $Nbre='-'; else $Nbre=$data['Nbre'].'/'.$frequence; if($pourcentage==0) $pourcentage='-';else $pourcentage=$data['pourcentage'].'%';
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$i.".</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$data['Numcat']."</td>";
										echo " 	<td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >Client ".$data['NomCat']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$data['NbreVisite']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >
										<a class='info2' href=''>".$data['frequence']."<span style='font-size:0.8em;'>".$data['MoisAns']."</span></a></td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$data['Recette']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$pourcentage."</td>";
										echo " 	<td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$data['Application']."</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
											echo " 	<a class='info2' href='Categorie_Client.php?Numcat=".$data['Numcat']."'><img src='logo/b_edit.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.8em;'>Modifier</span></a>";
											echo " 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
											echo " 	<a class='info2' href='Categorie_Client.php?Numcat =".$data['Numcat']."&supp=ok'><img src='logo/b_drop.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.8em;'>Supprimer</span></a>";
										echo " 	</td>";
									echo " 	</tr> ";
							}
					?>
				</table>
			</form>
         <?php //include ("footer.inc.php");?>
		</div>
	</body>
</html>
<script>
function verifyCheckBoxes1()
	{
		if((document.getElementById("button_checkbox_1").checked) )
		{
			document.getElementById("button_checkbox_2").checked = false;
		}
	}
function verifyCheckBoxes2()
	{
		if((document.getElementById("button_checkbox_2").checked) )
		{
			document.getElementById("button_checkbox_1").checked = false;
		}
	}

</script>
