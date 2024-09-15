<?php
	include_once'menu.php';
	//require("configuration.php");
	$re="SELECT * FROM utilisateur WHERE login='".$_SESSION['login']."'";
		$ret=mysqli_query($con,$re);
		while ($ret1=mysqli_fetch_array($ret))
		{ $nom=$ret1['nom'];
		  $prenom=$ret1['prenom'];
		  $poste=$ret1['poste'];
		  $login=$ret1['login'];
		  $password=$ret1['pass'];
		}

		if(isset($_POST['enregistrer']) && $_POST['enregistrer'] == "Modifier")
		{  $password1=md5($_POST['motpasse1']);  $password2=md5($_POST['motpasse2']); $password3=md5($_POST['motpasse3']);
			//$password1=md5($_POST['motpasse1'] . $CFG['salt']);  $password2=md5($_POST['motpasse2'] . $CFG['salt']); $password3=md5($_POST['motpasse3'] . $CFG['salt']);
			$nomP=$_POST['nom'];
			$prenomP=$_POST['prenom'];
			$nom_utilisateurP=$_POST['nom_utilisateur'];

			$nom=$_POST['nom1'];
			$prenom=$_POST['prenom1'];
			$nom_utilisateur=$_POST['nom_utilisateur1'];
			//$password3=$_POST['motpasse3'];

		if($password1==$password2){
			if(($nom==$nomP)&&($prenom==$prenomP)&&($login==$nom_utilisateurP)&&($password2==$password))
			{	echo "<script language='javascript'>";
				//echo " alert('Cet rôle a bien été attribué à l'utilisateur.');";
				//echo 'alertify.success("Vous n\'avez rien modifié  !");';
				echo 'alertify.error("Vous n\'avez rien modifié  !");';
				echo "</script>";
			}else{
				if($nomP=="")$nomP=$nom;if($prenomP=="")$prenomP=$prenom;
				if($nom_utilisateurP=="")$nom_utilisateurP=$nom_utilisateur;
				//if($password2=="")$password2=$password2;
/* 						mysqli_query("SET NAMES 'utf8'");
						$req = mysqli_query("SELECT * FROM utilisateur WHERE login='".$nom_utilisateurP."' ");
						if(mysql_num_rows($req) >= 1)
							{	echo "<script language='javascript'>";
								echo 'alertify.success("Ce nom d\'utilisateur existe déjà, veuillez en choisir un autre  !");';
								echo "</script>";
							}else{ */
						$test = "UPDATE utilisateur SET nom='".$nomP."',prenom='".$prenomP."',pass='".$password2."'  WHERE login='".$nom_utilisateurP."' ";
						$reqsup = mysqli_query($con,$test) or die(mysql_error($con));
						echo "<script language='javascript'>";
						echo 'alertify.success("Vos modifications ont été effectuées avec succès  !");';
						echo "</script>";
						//}
			}
		}else{
			echo "<script language='javascript'>";
			//echo " alert('Cet rôle a bien été attribué à l'utilisateur.');";
			echo 'alertify.success("Les mots de passe ne sont pas identiques  !");';
			echo "</script>";
		}
		}


?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
		</style><link rel="Stylesheet" href='css/table.css' />
	</head>
	<body bgcolor='azure' style="">
		<div align="center" >
			<form action="personnaliser.php" method="POST">
			<input style="width:250px;" type="hidden" id=""  name="nom1" value="<?php echo $nom ?>" />
			<input style="width:250px;" type="hidden" id=""  name="prenom1" value="<?php echo $prenom ?>" />
			<input style="width:250px;" type="hidden" id=""  name="nom_utilisateur1" value="<?php echo $login ?>" />
			<input style="width:250px;" type="hidden" id=""  name="motpasse3" value="<?php echo $password ?>" />
				<table width="800" height="380" border="0" cellpadding="0" cellspacing="0" id='tab' style="margin-top:10px;">
					<tr>
						<td colspan="2">
							<h3 style='text-align:center; font-family:Cambria;color:maroon;font-weight:bold;'>GESTION DU COMPTE PERSONNEL</h3>
						</td>
					</tr>
					<tr>
						<td  style="text-align:center; color:#d10808;font-size:0.9em;font-style:italic;"> Les champs marqués de <span class="rouge">*</span> sont obligatoires</td>
					</tr>
					<tr>
						<td  style="padding-left:100px;">Nom : </td>
						<td > <input style="width:250px;" type="text" id=""  placeholder ='<?php echo $nom; ?>' name="nom" value="" /> </td>
					</tr>
					<tr>
						<td  style="padding-left:100px;"> Pr&eacute;noms : </td>
						<td > <input style="width:250px;" type="text" id="" name="prenom" placeholder ='<?php echo $prenom; ?>' value="" /> </td>
					</tr>
					<tr>
						<td  style="padding-left:100px;">Nom d'utilisateur : </td>
						<td > <input style="width:250px;" type="text" id="" name="nom_utilisateur"  placeholder ='<?php echo $login; ?>' value="" <?php if($_SESSION['poste']!='Administrateur') echo "onFocus='blur()'";?> /></td>
					</tr>
					<tr>
						<td  style="padding-left:100px;"> Mot de passe : </td>
						<td > <input style="width:250px;height:22px;" type="password" id="" name="motpasse1"  required='required'  value="<?php ?>"/> </td>
					</tr>
					<tr>
						<td  style="padding-left:100px;"> Confirmation : </td>
						<td > <input style="width:250px;height:22px;" type="password"  id="" required='required' name="motpasse2" value="<?php ?>"/> </td>
					</tr>
					<tr>
						<td colspan="2" align="center" style=""> <input type="submit" class="bouton2" value="Modifier" id="" name="enregistrer" style=""/> 
						&nbsp;&nbsp; <input type="submit" class="bouton2" name="annuler" value="Annuler" style=""/> </td>
					</tr>
				</table>
			</form>
			<div style ="">

			<br/>
			<p>&nbsp;</p>
			</div>
			<br/>
			<p>&nbsp;</p>
		</div>
	</body>
</html>
