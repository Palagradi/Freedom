<?php
include_once'menu.php';
//require("configuration.php");
$CodeProfil='';
$TypeProfil='';
$NomUti="";
		if(isset($_POST['Enregistrer']) && $_POST['Enregistrer'] == "Enregistrer")
		{	$nom = strtoupper($_POST['nom']);
			$prenom = ucfirst($_POST['prenom']);
			$type = $_POST['type'];
			$commune = $_POST['commune'];
			$nom_utilisateur = $_POST['nom_utilisateur'];
			$motpasse1 = $_POST['motpasse1'];
			$motpasse2 = $_POST['motpasse2'];
			// Contrôles sur les champs
			$ok = true;

			if($nom=="")
				{
					$message = "Vous devez saisir le nom.";
					$ok = false;
					echo "<script language='javascript'>";
					echo " alert('Vous devez saisir le nom.');";
					echo "</script>";

				}
				else
				{
					if($prenom=="")
					{
						$message = "Vous devez saisir votre prénom.";
						$ok = false;
						echo "<script language='javascript'>";
						echo " alert('Vous devez saisir le prénom.');";
						echo "</script>";
					}
					else
					{
						if($nom_utilisateur=="")
						{
							$message = "Vous devez saisir votre nom utilisateur.";
							$ok = false;
							echo "<script language='javascript'>";
							echo " alert('Vous devez saisir le nom utilisateur.');";
							echo "</script>";
						}
						else
						{
							if($motpasse1=="")
							{
								$message = "Vous devez saisir votre mot de passe.";
								$ok = false;
								echo "<script language='javascript'>";
								echo " alert('Vous devez saisir le mot de passe.');";
								echo "</script>";

							}
							else
							{
								if($motpasse2=="")
								{
									$message = "Vous devez confirmer votre mot de passe.";
									$ok = false;
									echo "<script language='javascript'>";
									echo " alert('Vous devez confirmer le mot de passe.');";
									echo "</script>";
								}
								else
								{
									if($motpasse1!=$motpasse2)
									{
										$message = "Vous devez saisir le même mot de passe.";
										$ok = false;
										echo "<script language='javascript'>";
										echo " alert('Vous devez saisir le même mot de passe.');";
										echo "</script>";
									}
								else
								{
									//Vérification de l'existance du nom d'utilisateur
									$req = mysqli_query($con,"SELECT * FROM utilisateur WHERE NomUti='".$nom_utilisateur."' ");

									if(mysqli_num_rows($req) >= 1)
									{
										$message = "Ce nom d'utilisateur existe déjà, veuillez en choisir un autre.";
										$ok = false;
									}
									else
									{   $password=md5($_POST['motpasse1'] . $CFG['salt']);
										//$password=$_POST['motpasse1'] ;
										// Si tous les contrôles sont OK on enregistre le nouveau utilisateur
										$maj=$nom." ".$prenom;
										$pre_sql1="INSERT INTO utilisateur VALUES('$nom_utilisateur','".$maj."','$password','".$type."','$commune')";
										$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
										$message = "L'utilisateur a bien été enregistré";
										$ok = true;
									}
								}
							}
						}
					}
				}
			}

		}


	 if(isset($_GET['supp'])||isset($_GET['modif']))
		{	
			if(isset($_GET['supp']))
				$supp=1;
			if(isset($_GET['modif']))
				$modif=1;

				if(isset($_POST['SUPPRIMER']) && $_POST['SUPPRIMER'] == "SUPPRIMER")
					{//Contrôle pour qu'il y ait au moins un utilisateur admin
						$req = mysqli_query($con,"SELECT CodeProfil AS CodeProfilA FROM utilisateur  WHERE  utilisateur.NomUti = '".$_GET['NomUti']."' ");
						while($data=mysqli_fetch_array($req))
							{   $CodeProfilA=$data['CodeProfilA'];
							}
						if($CodeProfilA!="ADM")
							{$delete=1;
							}
						else
						{	$req = mysqli_query($con,"SELECT * FROM utilisateur  WHERE  utilisateur.CodeProfil= 'ADM' ");
							$nbre=mysql_num_rows($req);
							if($nbre>1)
								{$delete=1;
								}
							else
								{	echo "<script language='javascript'>";
									echo " alert('Suppression impossible. Il doit avoir au moins un administrateur');";
									echo "</script>";
								}
						}
						if($delete==1)
							{$reqsup = mysqli_query($con,"DELETE FROM utilisateur WHERE NomUti = '".$_GET['NomUti']."'");
							$supp=0;
							echo "<script language='javascript'>";
							echo " alert('Utilisateur supprimé');";
							echo "</script>";
							}
					}
				if(isset($_POST['MODIFIER']) && $_POST['MODIFIER'] == "MODIFIER")
					{	$nom = strtoupper($_POST['nom']);
						$prenom = ucfirst($_POST['prenom']);
						$type = $_POST['type'];
						$commune = $_POST['commune'];
						$nom_utilisateur = $_POST['nom_utilisateur'];
						$motpasse1 = $_POST['motpasse1'];
						$motpasse2 = $_POST['motpasse2'];
					if($nom=="")
						{
							$message = "Vous devez saisir le nom.";
							$ok = false;
							echo "<script language='javascript'>";
							//echo " alert('Vous devez saisir le nom.');";
							echo "</script>";

						}
						else
						{
							if($prenom=="")
							{
								$message = "Vous devez saisir votre prénom.";
								$ok = false;
								echo "<script language='javascript'>";
								echo " alert('Vous devez saisir le prénom.');";
								echo "</script>";
							}
							else
							{
								if($nom_utilisateur=="")
								{
									$message = "Vous devez saisir votre nom utilisateur.";
									$ok = false;
									echo "<script language='javascript'>";
									echo " alert('Vous devez saisir le nom utilisateur.');";
									echo "</script>";
								}
								else
								{
									if($motpasse1=="")
									{
										$message = "Vous devez saisir votre mot de passe.";
										$ok = false;
										echo "<script language='javascript'>";
										echo " alert('Vous devez saisir le mot de passe.');";
										echo "</script>";

									}
									else
									{
										if($motpasse2=="")
										{
											$message = "Vous devez confirmer votre mot de passe.";
											$ok = false;
											echo "<script language='javascript'>";
											echo " alert('Vous devez confirmer le mot de passe.');";
											echo "</script>";
										}
										else
										{
											if($motpasse1!=$motpasse2)
											{
												$message = "Vous devez saisir le même mot de passe.";
												$ok = false;
												echo "<script language='javascript'>";
												echo " alert('Vous devez saisir le même mot de passe.');";
												echo "</script>";
											}
											else
											{
												//Vérification de l'existance du nom d'utilisateur
												$req = mysqli_query($con,"SELECT * FROM utilisateur WHERE NomUti='".$nom_utilisateur."' ");

												if(mysql_num_rows($req) >= 1)
												{
													$message = "Ce nom d'utilisateur existe déjà, veuillez en choisir un autre.";
													$ok = false;
												}
												else
												{  	$maj=$nom." ".$prenom;
													$reqsel=mysqli_query($con,"UPDATE utilisateur SET Nom='".$maj."',CodeProfil='".$_POST['type']."',commune='".$_POST['commune']."' WHERE NomUti = '".$_GET['NomUti']."'");
													$modif=0;
													echo "<script language='javascript'>";
													echo " alert('Utilisateur modifié');";
													echo "</script>";
												}
											}
										}
									}
								}
							}
						}
					}
				if(isset($_POST['ANNULER']) && $_POST['ANNULER'] == "ANNULER")
				{//$_POST['nom']=array();
				}
		}
	mysqli_query($con,"SET NAMES 'utf8'");
	$reqsel=mysqli_query($con,"SELECT  * FROM salle  ");
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title><?php echo $title; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>
				<style>

			.alertify-log-custom {
				background: blue;
			}
		</style><link rel="Stylesheet" href='css/table.css' />
	</head>
	<body bgcolor='azure' style="">
	<div align="" style="">
			<form action="" method="POST">
			<table align='center'width="800" height="280" border="0" cellpadding="0" cellspacing="0" id="tab">
					<tr>
						<td colspan="4">
							<h3 style="text-align:center; font-family:Cambria;color:maroon;font-weight:bold;">ENREGISTREMENT DES SALLES</h3>
						</td>
					</tr>
					<tr>
						<td  style="text-align:center; color:#d10808;font-size:0.8em;font-style:italic;"> Les champs marqués de <span class="rouge">*</span> sont obligatoires</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;" >Code :&nbsp;&nbsp;&nbsp;<span class="rouge">*</span></td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="nom" name="nom" style="width:250px;" <?php if(!empty($nom)) echo 'value="'.$nom.'"'; ?> onkeyup="myFunction()"/> </td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;"> Désignation : &nbsp;&nbsp;&nbsp;<span class="rouge">*</span></td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="prenom" name="prenom" style="width:250px;" <?php if(!empty($nom)) echo 'value="'.$prenoms.'"'; ?> onkeyup="myFunction2()"/> </td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;"> Type de salle :&nbsp;&nbsp;&nbsp;<span class="rouge"></span> </td>
						<td colspan="2">&nbsp;
						<input type="text" id="type" name="type" style="width:250px;" <?php if(!empty($nom)) echo 'value="'.$prenoms.'"'; ?> onkeyup="myFunction2()"/>
						</td>
					</tr>

					<tr>
						<td colspan="2" style="padding-left:100px;">Tarif Fête :&nbsp;&nbsp;&nbsp;<span class="rouge"></span></td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="" name="nom_utilisateur" style="width:250px;" <?php if(!empty($nom)) echo 'value="'.$NomUti.'"'; ?> /></td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;"> Tarif Réunion : &nbsp;&nbsp;&nbsp;<span class="rouge"></span></td>
						<td colspan="2">&nbsp;&nbsp;<input type="password" id="" name="motpasse1" style="width:250px;"/> </td>
					</tr>
					<tr>
						<td colspan="2" align="right" > <input type="submit" value="<?php $supp=!empty($supp)?$supp:NULL; $modif=!empty($modif)?$modif:NULL;  if($supp==1) echo 'SUPPRIMER'; else if($modif==1) echo 'MODIFIER'; else echo 'Enregistrer';?>" id="" class="bouton2"  name="<?php if($supp==1) echo 'SUPPRIMER'; else if($modif==1) echo 'MODIFIER'; else echo 'Enregistrer';?>" style="<?php if($supp==1) echo 'color:red;font-weight:bold;'; else if($modif==1) echo'color:#9B810B;font-weight:bold;';  echo'#8F0059';?>;margin-bottom:5px;border:2px solid <?php if($supp==1) echo '#D10808'; else if($modif==1) echo'#103550';  echo'#8F0059';?>;"  <?php if($supp==1) echo 'onclick="if(!confirm(\'Voulez-vous vraiment continuer?\')) return false;"'; ?>/> </td>
						<td colspan="2">&nbsp;&nbsp;<input type="reset" value="Annuler" class="bouton2"  name="ANNULER" style="<?php if($supp==1) echo 'color:red;font-weight:bold;'; else if($modif==1) echo'color:#9B810B;font-weight:bold;';  echo'#8F0059';?>;margin-bottom:5px;border:2px solid <?php if($supp==1) echo '#D10808'; else if($modif==1) echo'#103550';  echo'#8F0059';?>;"/> </td>
					</tr>
				</table>
				<table align='center' width="800"  border="0" cellspacing="0" style="margin-top:40px;border-collapse: collapse;font-family:Cambria;">
					<tr><td colspan='6'>
					<h3 style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#444739;">  Liste des Salles </h3>
					</td></tr>
					<tr style=" background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;">
						<td style="border-right: 2px solid #ffffff" align="center" >N° </td>
						<td style="border-right: 2px solid #ffffff" align="center" >Désignation</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Type de Salle</td>
						<td style="border-right: 2px solid #ffffff" align="center">Tarif Fête</td>
						<td style="border-right: 2px solid #ffffff" align="center">Tarif Réunion</td>
						<td align="center" >Actions</td>
					</tr>
					<?php
							$cpteur=1;$i=0;
							while($data=mysqli_fetch_array($reqsel))
							{ $i++; //$query=mysqli_query($con,"UPADTE chambre SET DesignationType='Ventillée' WHERE typech='V'");
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
										echo " 	<td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>&nbsp;&nbsp;".$data['codesalle']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$data['typesalle']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['tariffete']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['tarifreunion']."</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
										echo " 	<a href='salle.php?sal=".$data['codesalle']."&modif=ok'><img src='logo/b_edit.png' alt='Modifier' title='Modifier' width='16' height='16' border='0'></a>";
										echo " 	&nbsp;&nbsp;";
										echo " 	&nbsp;&nbsp;";
										echo " 	<a href='salle.php?sal=".$data['codesalle']."&supp=ok'><img src='logo/b_drop.png' alt='Supprimer' title='Supprimer' width='16' height='16' border='0'></a>";
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
	// $Recordset1->Close();
?>
