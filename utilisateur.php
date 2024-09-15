<?php
include_once'menu.php';
	$trie=!empty($_GET['trie'])?$_GET['trie']:NULL;
	 $EtatG=!empty($_GET['EtatG'])?$_GET['EtatG']:NULL;
	 $reset=!empty($_GET['reset'])?$_GET['reset']:NULL;
	 $login=!empty($_GET['login'])?$_GET['login']:NULL;

	mysqli_query($con,"SET NAMES 'utf8'");
		 if($EtatG%2==0)  $ordre="ASC"; else $ordre="DESC";
		 if($trie=='')
			$reqsel = mysqli_query($con,"SELECT * FROM utilisateur WHERE poste <> 'Super administrateur' ");
		  else
		     $reqsel = mysqli_query($con,"SELECT * FROM utilisateur WHERE poste <> 'Super administrateur' ORDER BY $trie $ordre");
		//$re=mysqli_query($con,$query_Recordset1);

		 if(!empty($reset))
		 {$password=md5("change");  //$password=md5("change" . $CFG['salt']);
		  $sql="UPDATE utilisateur SET pass='$password' WHERE login='$login'";
		  $exec=mysqli_query($con,$sql);
			echo "<script language='javascript'>";
			echo 'alertify.success("Mot de passe réinitialisé avec succès!");';
			echo "</script>";
		 }

		$login="";
		if(isset($_POST['Enregistrer']) && $_POST['Enregistrer'] == "Enregistrer")
		{	$nom = addslashes(strtoupper($_POST['nom']));
			$prenom = addslashes(ucfirst($_POST['prenom']));
			$Type = $_POST['type'];
			//$commune = $_POST['commune'];
			$nom_utilisateur = addslashes($_POST['nom_utilisateur']);
			$motpasse1 = $_POST['motpasse1'];
			$motpasse2 = $_POST['motpasse2'];
			$etat=1;$date=date("Y-m-d");
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
									$req = mysqli_query($con,"SELECT * FROM utilisateur WHERE login='".$nom_utilisateur."' ");
									if(mysqli_num_rows($req) >= 1)
									{
										$message = "Ce nom d'utilisateur existe déjà, veuillez en choisir un autre.";
										$ok = false;
									}
									else
									{   $password=md5("change"); //$password=md5("change" . $CFG['salt']);
										//$password=$_POST['motpasse1'] ;
										// Si tous les contrôles sont OK on enregistre le nouveau utilisateur
										$maj=$nom." ".$prenom;
										$pre_sql1="INSERT INTO utilisateur VALUES(NULL,'".$nom."','".ucfirst($prenom)."','".$Type."','".$nom_utilisateur."','$password','$date','$etat',NULL,0)";
										$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con)  );
										//$message = "L'utilisateur a bien été enregistré";
										$ok = true;
										$reqsel = mysqli_query($con,"SELECT * FROM utilisateur WHERE poste <> 'Super administrateur' ");
										echo "<script language='javascript'>";
										//echo " alert('Cet rôle a bien été attribué à l'utilisateur.');";
										echo 'alertify.success("L\'utilisateur a été bien enregistré  !");';
										echo "</script>";

									}
								}
							}
						}
					}
				}
			}

		}


	 if(isset($_GET['supp'])||isset($_GET['modif']))
		{/* 	$req = mysqli_query("SELECT * FROM utilisateur,profil  WHERE  profil.CodeProfil=utilisateur.CodeProfil AND utilisateur.login = '".$_GET['login']."' ");
				while($data=mysql_fetch_array($req))
					{   $Nom=$data['Nom'];
						$NomT = explode(" ", $Nom);
						$nom=$NomT[0];
						$prenoms=$NomT[1];$CodeProfil=$data['profil.CodeProfil'];
						$TypeProfil=$data['TypeProfil'];
						$commune=$data['commune'];
						$login=$data['login'];
					}
			if(isset($_GET['supp']))
				$supp=1;
			if(isset($_GET['modif']))
				$modif=1;

				if(isset($_POST['SUPPRIMER']) && $_POST['SUPPRIMER'] == "SUPPRIMER")
					{//Contrôle pour qu'il y ait au moins un utilisateur admin
						$req = mysqli_query("SELECT CodeProfil AS CodeProfilA FROM utilisateur  WHERE  utilisateur.login = '".$_GET['login']."' ");
						while($data=mysql_fetch_array($req))
							{   $CodeProfilA=$data['CodeProfilA'];
							}
						if($CodeProfilA!="ADM")
							{$delete=1;
							}
						else
						{	$req = mysqli_query("SELECT * FROM utilisateur  WHERE  utilisateur.CodeProfil= 'ADM' ");
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
							{$reqsup = mysqli_query("DELETE FROM utilisateur WHERE login = '".$_GET['login']."'");
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
												$req = mysqli_query("SELECT * FROM utilisateur WHERE login='".$nom_utilisateur."' ");

												if(mysql_num_rows($req) >= 1)
												{
													$message = "Ce nom d'utilisateur existe déjà, veuillez en choisir un autre.";
													$ok = false;
												}
												else
												{  	$maj=$nom." ".$prenom;
													$reqsel=mysqli_query("UPDATE utilisateur SET Nom='".$maj."',CodeProfil='".$_POST['type']."',commune='".$_POST['commune']."' WHERE login = '".$_GET['login']."'");
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
				} */
		}




?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title><?php echo $title; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>
		<link rel="Stylesheet" href='css/table.css' />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width">
		<style>

		</style>
	</head>
	<body bgcolor='azure' style="">
	<div align="" style="">
			<form action="" method="POST">
			<table align='center'width="800" height="280" border="0" cellpadding="0" cellspacing="0" id="tab">
					<tr>
						<td colspan="4">
							<h3 style='text-align:center; font-family:Cambria;color:Maroon;font-weight:bold;'>GESTION DES UTILISATEURS</h3>
						</td>
					</tr>
					<tr>
						<td  style="text-align:center; color:#d10808;font-size:1em;font-style:italic;"> Les champs marqués de <span class="rouge">*</span> sont obligatoires</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;" >Nom :&nbsp;&nbsp;&nbsp;<span class="rouge">*</span></td>
						<td colspan="2">&nbsp;&nbsp;<input required="required" type="text" id="nom" name="nom" style="width:250px;"  onkeyup='this.value=this.value.toUpperCase()'/> </td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;"> Prénoms : &nbsp;&nbsp;&nbsp;<span class="rouge"></span></td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="prenom" name="prenom" style="width:250px;"  onkeyup="myFunction2()"/> </td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;"> Profil d'utilisateur :&nbsp;&nbsp;&nbsp;<span class="rouge">*</span> </td>
						<td colspan="2">&nbsp;
						<select name="type" style="font-family:sans-serif;font-size:80%;border:1px solid black;width:250px;" required="required">
							<?php
									echo "<option value=''>";  echo" </option>";
									$req=mysqli_query($con,"SELECT  TypeProfil FROM profil WHERE TypeProfil <> 'Super administrateur' ")or die ("Erreur de requête".mysql_error());
									while($data=mysqli_fetch_array($req))
									{
										echo" <option value ='".$data['TypeProfil']."'> ".ucfirst($data['TypeProfil'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option> ";
									}
									mysqli_free_result($req);
									mysqli_close($con);
							?>
						</select>
						</td>
					</tr>

					<tr>
						<td colspan="2" style="padding-left:100px;">Nom d'utilisateur :&nbsp;&nbsp;&nbsp;<span class="rouge">*</span></td>
						<td colspan="2">&nbsp;&nbsp;<input required="required" type="text" id="" name="nom_utilisateur" style="width:250px;" <?php if(!empty($nom)) echo 'value="'.$login.'"'; ?> /></td>
					</tr>
					<input type="hidden" id="" name="motpasse1" style="width:250px;" value='1'/>
					<input type="hidden" id="" name="motpasse2" style="width:250px;" value='1'/>

					<tr><?php $modif=!empty($modif)?$modif:NULL; $supp=!empty($supp)?$supp:NULL;?>
						<td colspan="2" align="right" > <input type="submit" value="<?php if($supp==1) echo 'SUPPRIMER'; else if($modif==1) echo 'MODIFIER'; else echo 'Enregistrer';?>" id="" class="bouton2"  name="<?php if($supp==1) echo 'SUPPRIMER'; else if($modif==1) echo 'MODIFIER'; else echo 'Enregistrer';?>" style="<?php if($supp==1) echo 'color:red;font-weight:bold;'; else if($modif==1) echo'color:#9B810B;font-weight:bold;';  echo'#8F0059';?>;margin-bottom:5px;border:2px solid <?php if($supp==1) echo '#D10808'; else if($modif==1) echo'#103550';  echo'#8F0059';?>;"  <?php if($supp==1) echo 'onclick="if(!confirm(\'Voulez-vous vraiment continuer?\')) return false;"'; ?>/> </td>
						<td colspan="2">&nbsp;&nbsp;<input type="reset" value="Annuler" class="bouton2"  name="ANNULER" style="<?php if($supp==1) echo 'color:red;font-weight:bold;'; else if($modif==1) echo'color:#9B810B;font-weight:bold;';  echo'#8F0059';?>;margin-bottom:5px;border:2px solid <?php if($supp==1) echo '#D10808'; else if($modif==1) echo'#103550';  echo'#8F0059';?>;"/> </td>
					</tr>
				</table>
				<table align='center' width="800"  border="0" cellspacing="0" style="margin-top:40px;border-collapse: collapse;font-family:Cambria;">
					<tr><td colspan='5'>
					<h3 style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#444739;">  Liste des utilisateurs </h3>
					</td></tr>
					<tr style=" background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;">
						<td style="border-right: 2px solid #ffffff" align="center" >N° </td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info1' href='utilisateur.php?trie=utilisateur.nom&etatget=<?php   if(!empty($_GET['etatget'])&&($_GET['trie']=='utilisateur.nom')) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget;?>&EtatG=<?php echo $etatget; ?>' style='text-decoration:none;color:white;' title=''> <span style='font-size:0.6em;'>Trier par Nom</span>Nom et prénoms</a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info1' href='utilisateur.php?trie=utilisateur.login&etatget=<?php   if(!empty($_GET['etatget'])&&($_GET['trie']=='utilisateur.login')) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget;?>&EtatG=<?php echo $etatget; ?>' style='text-decoration:none;color:white;' title=''> <span style='font-size:0.6em;'>Trier par Nom Utilisateur</span>Nom d'utilisateur</a></td>
						<td style="border-right: 2px solid #ffffff" align="center"><a class='info1' href='utilisateur.php?trie=utilisateur.poste&etatget=<?php   if(!empty($_GET['etatget'])&&($_GET['trie']=='utilisateur.poste')) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget;?>&EtatG=<?php echo $etatget; ?>' style='text-decoration:none;color:white;' title=''> <span style='font-size:0.6em;'>Trier par Type Utilsateur</span>Type d'utilisateur</a></td>
						<td align="center" >Actions</td>
					</tr>
					<?php
							$cpteur=1;$i=0;
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
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>&nbsp;&nbsp;<a href='#' class='info' style='cursor:default;text-decoration:none;color:black;' title='' alt='' ><span style='font-size:0.8em;' >Date de création utilisateur&nbsp;&nbsp;&nbsp;<span style='color:red;'>"   .substr($data['DateCreation'],8,2).'-'.substr($data['DateCreation'],5,2).'-'.substr($data['DateCreation'],0,4)."</span></span>".strtoupper($data['nom'])." &nbsp;".$data['prenom']."</a></td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' ><a href='#' class='info' style='cursor:default;text-decoration:none;color:black;' title='' alt='' ><span style='font-size:0.8em;'>Date de création utilisateur&nbsp;&nbsp;&nbsp;<span style='color:red;'>"   .substr($data['DateCreation'],8,2).'-'.substr($data['DateCreation'],5,2).'-'.substr($data['DateCreation'],0,4)."</span></span>".$data['login']."</a></td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><a href='#' class='info' style='cursor:default;text-decoration:none;color:black;' title='' alt='' ><span style='font-size:0.8em;'>Date de création utilisateur&nbsp;&nbsp;&nbsp;<span style='color:red;'>"   .substr($data['DateCreation'],8,2).'-'.substr($data['DateCreation'],5,2).'-'.substr($data['DateCreation'],0,4)."</span></span>".$data['poste']."</a></td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
										echo " 	<a class='info2' href='utilisateur.php?login=".$data['login']."&modif=ok'><img src='logo/b_edit.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.8em;'>Modifier</span></a>";
										echo " 	&nbsp;&nbsp;";
										echo " 	<a class='info2' href='utilisateur.php?login=".$data['login']."&reset=ok'><img src='logo/Change.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.8em;'>Réinitialiser mot de passe</span></a>";
										echo " 	&nbsp;&nbsp;";
										echo " 	<a class='info2' href='utilisateur.php?login=".$data['login']."&supp=ok'><img src='logo/b_drop.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.8em;'>Supprimer</span></a>";
										echo " 	</td>";
								echo " 	</tr></a> ";
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
