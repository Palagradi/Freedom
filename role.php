<?php
	require("menu.php");
	$remove=isset($_GET['remove']) ? $_GET['remove'] : NULL;
	$nomRole=isset($_GET['nomRole']) ? $_GET['nomRole'] : NULL;
	$Profil=isset($_GET['Profil']) ? $_GET['Profil'] : NULL;
	if($remove==1){
	$query="DELETE FROM affectationrole WHERE nomRole='".$nomRole."' AND Profil='".$Profil."'";
	$exec=mysqli_query($con,$query);
	echo "<script language='javascript'>";
	echo 'alertify.success("Révocation de rôle effectué avec succès  !");';
	echo "</script>";
	header('location:role.php');

	}
	$query=mysqli_query($con,"DELETE FROM  affectationrole WHERE Profil=''");

		 if (isset($_POST['AJOUTER'])&& $_POST['AJOUTER']=='AJOUTER')
	     {  $typeProfil=$_POST['type'];	$nomRole=$_POST['role'];
			if(($typeProfil=="")||($nomRole==""))
			{
				$message = "Vous devez sélectionner le type du profil et le nom du rôle.";
				echo "<script language='javascript'>";
					echo " alert('Vous devez sélectionner le type du profil et le nom du rôle.');";
					echo "</script>";
				$ok = false;
			}else
			{
	 		$req = mysqli_query($con,"SELECT  * FROM affectationrole WHERE nomRole='".$nomRole."' AND Profil='".$typeProfil."'");
			if(mysqli_num_rows($req)>0)
				{	echo "<script language='javascript'>";
			  	echo 'alertify.error("Ce rôle a déjà été attribué à cet utilisateur.");';
					echo "</script>";

				}else{
					$reqInsert = mysqli_query($con,"INSERT INTO affectationrole SET nomRole='".$nomRole."',Profil='".$typeProfil."' ");
					if($reqInsert)
						{	echo "<script language='javascript'>";
							echo 'alertify.success("Ce rôle a bien été attribué au profil  !");';
							echo "</script>";


						}
				}
			}
		 }
		 $j= 0;
		$req = mysqli_query($con,"SELECT DISTINCT Profil  FROM affectationrole");
		while($data = mysqli_fetch_array($req))
		{   $profil[$j] = $data['Profil'];
		  $j++;
		}
		 $totalRows_Recordset = mysqli_num_rows($req);
	$TypeProfil=''; $nomRole='';
?>
<html>
	<head>
		<title> <?php echo $title; ?> </title>
		<link rel="Stylesheet" type="text/css" media="screen, print" href='style.css' />
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
<script type="text/javascript">
		  $(function(){
					 $("#confirmT").click(  function(){
										 return confirm('Would you really make this test ?') ;
				 })
				 })



    </script>

	</head>
	<body bgcolor='azure' style="">
	<div align="" style="">
				<form action="" method="POST">
			<table align='center' width="800" height="280" border="0" cellpadding="0" cellspacing="0" id="tab">
					<tr>
						<td colspan="4">
							<h3 style='text-align:center; font-family:Cambria;color:maroon;font-weight:bold;'>GESTION DES ROLES</h3>
						</td>
					</tr>
					<tr>
						<td  style="text-align:center; color:#d10808;font-size:0.8em;font-style:italic;"> Les champs marqués de <span class="rouge">*</span> sont obligatoires</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:130px;" >Type de Profil : &nbsp;&nbsp;&nbsp;<span class="rouge">*</span></td>
						<td colspan="2">&nbsp;&nbsp;
							<select name="type" style="font-family:sans-serif;font-size:90%;border:0px solid black;width:255px;" required="required">
								<?php
										 if(!empty($TypeProfil)) { echo "<option value='".$CodeProfil."'>";  echo $TypeProfil;   echo" </option>";} else { echo "<option value=''>";  echo" </option>";}
										$req=mysqli_query($con,"SELECT  TypeProfil FROM profil WHERE TypeProfil <> 'Super administrateur' ")or die ("Erreur de requête".mysql_error());
										while($data=mysqli_fetch_array($req))
										{
											echo" <option value ='".$data['TypeProfil']."'> ".ucfirst($data['TypeProfil'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option> ";
											echo "<option value=''></option>";
										}
										mysqli_free_result($req);
										//mysql_close();
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:130px;"> Rôle  : &nbsp;&nbsp;&nbsp;<span class="rouge">*</span> </td>
						<td colspan="2">&nbsp;&nbsp;
							<select name="role" style="font-family:sans-serif;font-size:90%;border:0px solid black;width:255px;" required="required">
								<?php
										 if(!empty($role)) { echo "<option value='".$role."'>";    echo" </option>";} else { echo "<option value=''>";  echo" </option>";}
										$req=mysqli_query($con,"SELECT nomRole  FROM ".$_SESSION['role']." ORDER BY nomRole ASC")or die ("Erreur de requête".mysql_error()); $i=0;
										while($data=mysqli_fetch_array($req))
										{    $i++;
											echo" <option value ='".$data['nomRole']."'> ".$i.". -".ucfirst($data['nomRole'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option> ";
											echo "<option value=''></option>";
										}
										mysqli_free_result($req);
										//mysql_close();
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="right" > <input type="submit" value="AJOUTER" id="" class="bouton2"  name="AJOUTER" style=""/> </td>
						<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="ANNULER" class="bouton2"  name="Annuler" style=""/> </td>
					</tr>
				</table>
			</form>


	<?php
			if($totalRows_Recordset==0) echo "<center> Aucune affectation de Rôles</center>";
			for($n=0;$n<$totalRows_Recordset;$n++)
				{ mysqli_query($con,"SET NAMES 'utf8'");
				 $query_Recordset1 = "SELECT * FROM ".$_SESSION['role'].",affectationrole WHERE ".$_SESSION['role'].".nomrole=affectationrole.nomrole AND Profil='".$profil[$n]."' AND  Profil <> 'Super administrateur' ORDER BY ".$_SESSION['role'].".nomrole ASC";
			     $Recordset_2 = mysqli_query($con,$query_Recordset1);
				 $nbre = mysqli_num_rows($Recordset_2);
				   if($nbre>0)
				   {echo "<table align='center' width='800' border'0' cellspacing='0'style='margin-top:30px;border-collapse: collapse;font-family:Cambria;'>
				   <tr style='text-align:left;text-decoration:none; font-family:Cambria;font-size:1em;margin-bottom:5px;color:#444739;font-weight:bold;'> <td colspan='4'>Liste des Rôles affectés pour le profil [<span style='color:#8F0059;'>".ucfirst($profil[$n])." </span>]</td></tr>
					<tr style='background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;'>
						<td style='border-right: 2px solid #ffffff' align='center' >N° </td>
						<td style='border-right: 2px solid #ffffff' align='center' >Rôles affectés </td>
						<td style='border-right: 2px solid #ffffff' align='center' >Tâches à exécuter </td>
						<td align='center' >Actions</td>
					</tr>";
					$cpteur=1;$i=0;
					while($row=mysqli_fetch_array($Recordset_2))
					{ $i++;
					  $nomRole=$row['nomRole'];
					  $chemin=$row['chemin'];

						if($cpteur == 1)
						{
							$cpteur = 0;
							$bgcouleur = "#DDEEDD";
						}
						else
						{
							$cpteur = 1;
							$bgcouleur = "#dfeef3";
						} //if(poste)
						echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$i.".</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>&nbsp;&nbsp;&nbsp;&nbsp;".$row['nomRole']."</td>";
										echo " 	<td   style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>&nbsp;&nbsp;&nbsp;&nbsp;".$row['tacheExecutee']."</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
										echo " 	<a class='info2' id='confirmT' href='role.php?nomRole=".$row['nomRole']."&Profil=".$profil[$n]."&remove=1'><img src='logo/remove.png' alt='' title='' width='25' height='16' border='0'><span style='font-size:0.8em;'>Retirer le rôle</span></a>";
										echo " 	</td>";
								echo " 	</tr> ";
					}
					echo "</table>";
				}
			}
	?>
	</div>
<?php include 'confirm.php' ;?>

</body>
</html>
