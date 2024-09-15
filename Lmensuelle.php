<?php
include 'menu.php';
	if (isset($_POST['enregistrer1'])&& $_POST['enregistrer1']=='Enregistrer')
		{/* $sql="UPDATE configuration_facture SET etat_facture='".$_POST['radio1']."',initial_grpe='".$_POST['initial3']."',initial_reserv='".$_POST['initial2']."',initial_fiche='".$_POST['initial1']."',reimprimer='".$_POST['radio2']."' WHERE etat_facture!=''";
		 $exec=mysqli_query($sql);
		 $sql1="UPDATE autre_configuration SET taxe='".$_POST['taxe']."',etat_taxe='".$_POST['radio3']."',limitation='".$_POST['radio6']."',limite_jrs='".$_POST['limite']."',fond='".$_POST['radio5']."' WHERE taxe!=''";
		 $exec1=mysqli_query($sql1);
		 $sql2="UPDATE configuration_client SET num_auto='".$_POST['radio4']."'WHERE num_auto!=''";
		 $exec2=mysqli_query($sql2);
		 if(($exec)||($exec1)||($exec2))
			{	echo "<script language='javascript'>";
				//echo " alert('Les modifications ont été prises en compte');";
				echo 'alertify.success("La Catégorie a bien été enregistrée !");';
				echo "</script>";
			}
	$reqsel=mysqli_query("SELECT * FROM autre_configuration");
			while($data=mysqli_fetch_array($reqsel))
				{  $taxe=$data['taxe'];
				   $etat_taxe=$data['etat_taxe'];
				   $limitation=$data['limitation'];
				   $limite_jrs=$data['limite_jrs'];
				   $fond=$data['fond'];
				}
	$reqsel=mysqli_query("SELECT * FROM configuration_facture");
			while($data=mysqli_fetch_array($reqsel))
				{  $etat_facture=$data['etat_facture'];
				   $initial_grpe=$data['initial_grpe'];
				   $initial_reserv=$data['initial_reserv'];
				   $initial_fiche=$data['initial_fiche'];
				   $Nbre_char=$data['Nbre_char'];
				   $reimprimer=$data['reimprimer'];
				}
	$reqsel=mysqli_query("SELECT * FROM configuration_client");
			while($data=mysqli_fetch_array($reqsel))
				{  $num_auto=$data['num_auto'];
				   $Nbre_chare=$data['Nbre_chare'];
				} */
			$nomHotel = $_POST['nomHotel'];$logoHotel = $_POST['logoHotel'];$NumUFI = $_POST['NumUFI'];$Apostale = $_POST['Apostale'];$NbreEToile = $_POST['NbreEToile']; 
			$telephone1 = $_POST['telephone1'];$telephone2 = $_POST['telephone2'];$Email = $_POST['Email'];$NumBancaire = $_POST['NumBancaire'];$Siteweb= $_POST['Siteweb'];

	 $query="DELETE FROM hotel"; //unlink('logo/'.$NomLogo);
	 $query1 = mysqli_query($con,$query) or die(mysql_error());

	if(isset($_FILES['logoHotel']))
	{ $fichier=mysqli_real_escape_string(htmlentities($_FILES['logoHotel']['name']));
	  $fichieR="logo/".$fichier;
	  $taille=$_FILES['fichier']['size'];
	  $fichier2=explode('.',$fichier);
	  $ext_fichier=end($fichier2);
	  $query="UPDATE autre_configuration SET logo='$fichieR'";
	  $query1 = mysqli_query($con,$query) or die(mysql_error($con));
	  if($query1=true) {
		  move_uploaded_file($_FILES['logoHotel']['tmp_name'],'logo/'.$fichier);
	  }
	}
	 $query="INSERT INTO hotel SET nomHotel='$nomHotel', NumUFI='$NumUFI',Apostale='$Apostale',telephone1='$telephone1',telephone2='$telephone2',Email='$Email',Siteweb='$Siteweb',NumBancaire='$NumBancaire',logo='$fichier',NbreEToile='$NbreEToile'";
	 $query1 = mysqli_query($con,$query) or die(mysqli_error($con));
	 echo "<script language='javascript'>";
	 echo 'alertify.error("Enrégistrement effectué avec succès");';
	 echo "</script>";
}
if (isset($_POST['enregistrer2'])&& $_POST['enregistrer2']=='Enregistrer')
	{	$NumeroLoyer = $_POST['NumeroLoyer']; $DLoyer = $_POST['DLoyer']; $NomLoc = $_POST['NomLoc'];
		$ContactLoc = $_POST['ContactLoc']; $MontantLoyer = $_POST['MLoyer']; $Dpayement = $_POST['Dpayement'];

		$query="INSERT INTO loyer SET Numero='$NumeroLoyer', Designation='$DLoyer',NomLoc='$NomLoc',ContactLoc='$ContactLoc',Montant='$MontantLoyer',DatePayement='$Dpayement'";
		 $query1 = mysqli_query($con,$query) or die(mysqli_error($con));
		 echo "<script language='javascript'>";
		 echo 'alertify.error("Enrégistrement effectué avec succès");';
		 echo "</script>";

	}


?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title><?php echo $title; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="Stylesheet" type="text/css" media="screen, print" href="style.css">
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>

		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width">
			<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<style>
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
			.alertify-log-custom {
				background: blue;
			}
		</style>


	</head>
	<body bgcolor='azure' style="">

		<div align="" style="">
				<form action='' method='post' name=''>
					<fieldset  style='margin-left:auto; margin-right:auto;border:2px solid white;background-color:#D0DCE0;font-family:Cambria;width:800px;height:auto;'>
						<legend align='center' style='font-size:1.3em;color:#3EB27B;'>	<h3 style="text-align:center; font-family:Cambria;color:maroon;font-weight:bold;"></h3></legend>
					<table align="center" width="" border="0" BORDERCOLOR="white"  style="border:0px solid white;margin-top:0px;border-collapse: collapse;font-family:Cambria;background-color:#D0DCE0;height:350px;">
					<tr>
						<td colspan="2">
							<h3 style='text-align:center; font-family:Cambria;color:maroon;font-weight:bold;'>GESTION DES LOCATIONS MENSUELLES</h3>
						</td>
					</tr>
					<tr>
						<td style="text-align:left; color:#d10808;font-size:0.8em;font-style:italic;"> Les champs marqués de <span class="rouge">*</span> sont obligatoires</td>
					</tr>

					<tr>
						<td  style="padding-left:80px;"> Numéro : &nbsp;&nbsp;&nbsp;<span class="rouge"></span> </td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="" name="NumeroLoyer" readonly='readonly' value="<?php echo $chaine1 = substr(random(50,'L'),0,6);?>" style="width:250px;"  placeholder='' required=""/> </td>
					</tr>

					<tr>
						<td  style="padding-left:80px;"> Désignation du Loyer : &nbsp;&nbsp;&nbsp;<span class="rouge">*</span> </td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="" name="DLoyer" style="width:250px;"  placeholder='' required="required"/> </td>
					</tr>
										<tr>
						<td  style="padding-left:80px;"> Nom du Locataire : &nbsp;&nbsp;&nbsp;<span class="rouge"></span> </td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="" name="NomLoc" style="width:250px;"  placeholder='' /> </td>
					</tr>
										<tr>
						<td  style="padding-left:80px;"> Contact du Locataire : &nbsp;&nbsp;&nbsp;<span class="rouge"></span> </td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="" name="ContactLoc" style="width:250px;"  placeholder='' /> </td>
					</tr>
					<tr>
						<td style="padding-left:80px;"> Montant du Loyer  : &nbsp;&nbsp;&nbsp;<span class="rouge">*</span> </td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="MLoyer" style="width:250px;" required="required"/> </td>
					</tr>
										<tr>
						<td style="padding-left:80px;"> Date de payement  : &nbsp;&nbsp;&nbsp;<span class="rouge">*</span> </td>
						<td >&nbsp;
						<select name='Dpayement'style="width:75px;" required="required">
							<option value='<?php echo '';?>'> <?php echo '';?></option>
							<?php
								for($i=1;$i<=30;$i++)
									{ if($i<10)
										{$m="0".$i;
											echo "<option value='$m'> $i</option>";}
									  else
										  echo "<option value='$i'> $i</option>";
									}
							?>
						</select>
						&nbsp;&nbsp;&nbsp;<span class="rouge">de chaque mois</span> </td>
					</tr>
					<tr>
						<td  align="right" ><br/> <input type="submit" value="Enregistrer" id="" class="bouton2"  name="enregistrer2" style=""/><br/>&nbsp;  </td>
						<td><br/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="Annuler" class="bouton2"  name="Annuler" style=""/><br/>&nbsp; </td>
					</tr>


			</legend> </fieldset>  </table>
			
</div>

	</form>
				<table align='center' width="auto"  border="0" cellspacing="0" style="margin-top:40px;border-collapse: collapse;font-family:Cambria;">
					<tr><td colspan='6'>
					<h3 style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#444739;">   Liste des Locations  </h3>
					</td></tr>
							<tr style=" background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;">
						<td style="border-right: 2px solid #ffffff" align="center" >N° </td>
						<td style="border-right: 2px solid #ffffff" align="center" >Désignation du Loyer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Nom du Locataire &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Montant du Loyer </td>
						<td style="border-right: 2px solid #ffffff" align="center" >Date de payement </td>
						<td align="center" >Actions</td>
					</tr>
					<?php

									mysqli_query($con,"SET NAMES 'utf8'");
							$reqsel=mysqli_query($con,"SELECT * FROM Loyer");
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
								} $DatePayement=$data['DatePayement']."-mm-yyyy";
								echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$data['Numero']."</td>";
										echo " 	<td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".ucfirst($data['Designation'])."</td>";
										echo " 	<td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".ucfirst($data['NomLoc'])."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$data['Montant']."</td>";
											echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$DatePayement."</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
											echo "&nbsp;&nbsp;<a class='info2' href='configurer.php?edit'><img src='logo/b_edit.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.8em;'>Modifier</span></a>";
											echo " 	&nbsp;&nbsp;&nbsp;";
											echo " 	<a class='info2' href='configurer.php?sup'><img src='logo/b_drop.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.8em;'>Supprimer</span></a>";
										echo " 	</td>";
									echo " 	</tr> ";
							}
					?>
				</table>
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
