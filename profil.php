<?php
include 'menu.php';
	//require("configuration.php");
	mysqli_query($con,"SET NAMES 'utf8'");
			$reqsel=mysqli_query($con,"SELECT * FROM profil WHERE TypeProfil <> 'Super administrateur' ");

		if(isset($_POST['enregistrer']) && $_POST['enregistrer'] == "AJOUTER")
		{
			$code = $_POST['code'];
			$TypeProfil = ucfirst($_POST['TypeProfil']);

		if($TypeProfil=="")
			{
				$message = "Vous devez saisir le nom du profil.";
				echo "<script language='javascript'>";
					echo " alert('Vous devez saisir le nom du profil.');";
					echo "</script>";
				$ok = false;
			}else
			{		//Vérification de l'existance du nom du profil
				$req = mysqli_query($con,"SELECT * FROM profil WHERE TypeProfil='".$TypeProfil."' ");

				if(mysqli_num_rows($req) >= 1)
				{
					$message = "Ce profil existe déjà, veuillez en choisir un autre.";
					echo "<script language='javascript'>";
					echo " alert('Ce profil existe déjà, veuillez en choisir un autre.');";
					echo "</script>";
					$ok = false;
				}
				else
				{  $pre_sql1="INSERT INTO profil VALUES('$code','".$TypeProfil."')";
					$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error());
					$message = "Le profil a bien été enregistré";
					mysqli_query($con,"SET NAMES 'utf8'");
					$reqsel=mysqli_query($con,"SELECT * FROM profil");
					echo "<script language='javascript'>";
					//echo " alert('La  profil a bien été enregistrée');";
					mysqli_query($con,"SET NAMES 'utf8'");
					$reqsel=mysqli_query($con,"SELECT * FROM profil WHERE TypeProfil <> 'Super administrateur'");
					echo 'alertify.success("Le  profil a bien été enregistré !");';
					echo "</script>";
					$ok = true;
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
			<form action="" method="POST">
			<table align='center' width="750" height="280" border="0" cellpadding="0" cellspacing="0" id="tab">
					<tr>
						<td colspan="4">
						<h3 style='text-align:center; font-family:Cambria;color:maroon;font-weight:bold;'>GESTION DES PROFILS</h3>
						</td>
					</tr>
					<tr>
						<td  style="text-align:center; color:#d10808;font-size:0.8em;font-style:italic;"> Les champs marqués de <span class="rouge">*</span> sont obligatoires</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:130px;" >Code profil :</td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="" name="code" style="width:250px;"
					value="<?php
					echo $chaine1 = substr(random(50,'A'),0,5);

					?>" onFocus="this.blur()"	/> </td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:130px;"> Nom profil  : &nbsp;&nbsp;&nbsp;<span class="rouge">*</span> </td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="" name="TypeProfil" style="width:250px;" required="required"/> </td>
					</tr>
					<tr>
						<td colspan="2" align="right" > <input type="submit" value="AJOUTER" id="" class="bouton2"  name="enregistrer" style=""/> </td>
						<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="ANNULER" class="bouton2"  name="Annuler" style=""/> </td>
					</tr>
				</table><br/>
				
				<table align='center' width="750"  border="0" cellspacing="0" style="margin-top:10px;border-collapse: collapse;font-family:Cambria;">
					<tr><td colspan='4'>
					<h3 style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#444739;">  Liste des profils </h3>
					</td></tr>
					<tr style=" background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;">
						<td style="border-right: 2px solid #ffffff" align="center" >N° </td>
						<td style="border-right: 2px solid #ffffff" align="center" >Code </td>
						<td style="border-right: 2px solid #ffffff" align="" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nom profil </td>

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
								echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$i.".</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$data['CodeProfil']."</td>";
										echo " 	<td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$data['TypeProfil']."</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
											echo " 	<a class='info2' href='profil.php?CodeProfil=".$data['CodeProfil']."'><img src='logo/b_edit.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.8em;'>Modifier</span></a>";
											echo " 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
											echo " 	<a class='info2' href='profil.php?CodeProfil =".$data['CodeProfil']."&supp=ok'><img src='logo/b_drop.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.8em;'>Supprimer</span></a>";
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
<?php
			//include ("footer.inc.php");
?>
