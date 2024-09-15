<?php
include 'menu.php';
	//require("configuration.php");
	// automatisation du numéro
	function random($car) {
		$string = "A";
		$chaine = "0123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
		}
		return $string;
		}
		mysql_query("SET NAMES 'utf8'");
		$reqsel=mysql_query("SELECT * FROM profil");
		$code = $_POST['code'];
		$TypeProfil = ucfirst($_POST['TypeProfil']);

		if(isset($_POST['enregistrer']) && $_POST['enregistrer'] == "ENREGISTRER")
		{	if($TypeProfil=="")
			{
				$message = "Vous devez saisir le nom de la profil.";
				echo "<script language='javascript'>"; 
					echo " alert('Vous devez saisir le nom de la profil.');";
					echo "</script>";
				$ok = false;
			}else
			{		//Vérification de l'existance du nom d'utilisateur
				$req = mysql_query("SELECT * FROM profil WHERE TypeProfil='".$TypeProfil."' ");

				if(mysql_num_rows($req) >= 1)
				{
					$message = "Cette profil existe déjà, veuillez en choisir une autre.";
					echo "<script language='javascript'>"; 
					echo " alert('Cette profil existe déjà, veuillez en choisir une autre.');";
					echo "</script>";
					$ok = false;
				}
				else
				{ 	$pre_sql1="INSERT INTO profil VALUES('','$code','".$TypeProfil."')";
					$req1 = mysql_query($pre_sql1) or die (mysql_error());			
					$message = "Le contribuable a bien été enregistré";
					echo "<script language='javascript'>"; 
					echo " alert('La  profil a bien été enregistrée');";
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
	</head>
	<body bgcolor='azure' style="margin-top:-1%;">
	<div align="" style="margin-top:5%;">
			<form action="" method="POST"> 
			<table align='center' width="750" height="280" border="0" cellpadding="0" cellspacing="0" style="border:2px solid white;font-family:Cambria;background-color:#D0DCE0;">
					<tr>
						<td colspan="4">
							<h2 style="text-align:center; font-family:Cambria;color:#3EB27B;">TYPES &nbsp;DE&nbsp; SALLE</h2>
						</td>
					</tr>
					<tr>
						<td  style="text-align:center; color:#d10808;font-size:0.9em;font-style:italic;"> Les champs marqués de <span class="rouge">*</span> sont obligatoires</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:130px;" >Code profil :</td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="" name="code" style="width:250px;"
					value="<?php 
					echo $chaine1 = substr(random(50,''),0,5);
					 
					?>" onFocus="this.blur()"	/> </td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:130px;"> Nom profil  : &nbsp;&nbsp;&nbsp;<span class="rouge">*</span> </td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="" name="TypeProfil" style="width:250px;" /> </td>
					</tr>
					<tr>
						<td colspan="2" align="right" > <input type="submit" value="ENREGISTRER" id="" class="les_boutons"  name="enregistrer" style="margin-bottom:5px;border:2px solid #8F0059;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;"/> </td>
						<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="ANNULER" class="les_boutons"  name="Annuler" style="margin-bottom:5px;border:2px solid #8F0059;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;"/> </td>
					</tr>
				</table>
				<table align='center' width="750"  border="0" cellspacing="0" style="margin-top:40px;border-collapse: collapse;font-family:Cambria;">
					<caption style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#8F0059;">  Liste des profils </caption> 
					<tr style=" background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;">
						<td style="border-right: 2px solid #ffffff" align="center" >N° </td>
						<td style="border-right: 2px solid #ffffff" align="center" >Code </td>
						<td style="border-right: 2px solid #ffffff" align="" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nom profil </td>
					
						<td align="center" >Actions</td>
					</tr>
					<?php
							$cpteur=1; $i=0;
							while($data=mysql_fetch_array($reqsel))
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
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$data['CodeProfil']."</td>";
										echo " 	<td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$data['TypeProfil']."</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
											echo " 	<a href='profil.php?CodeProfil=".$data['CodeProfil']."'><img src='logo/b_edit.png' alt='Modifier' title='Modifier' width='16' height='16' border='0'></a>";
											echo " 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
											echo " 	<a href='profil.php?CodeProfil =".$data['CodeProfil']."&supp=ok'><img src='logo/b_drop.png' alt='Supprimer' title='Supprimer' width='16' height='16' border='0'></a>";
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