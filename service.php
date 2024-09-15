<?php
include_once'menu.php';
		mysqli_query($con,"SET NAMES 'utf8'");	$query_Recordset1 = "SELECT * FROM service";
		
		if (isset($_POST['ENREGISTRER'])&& ($_POST['ENREGISTRER']=='Enrégistrer')&&(!empty($_POST['designation']))) 
	   {  $ans=substr(date('Y'),2,2);	
		  $reference1=$_POST['reference']; //echo $_SESSION['login'];
		  $designation=$_POST['designation'];
		  $sql="SELECT * FROM service WHERE code='".$_POST['reference']."'";
		  $reqsel=mysqli_query($con,$sql);
				$nbre=mysqli_num_rows($reqsel);
			if($nbre>0)
				{	echo "<script language='javascript'>";
					echo 'alertify.error(" Erreur d\'enrégistrement ");';
					echo "</script>";
				}
			else{
			mysqli_query($con,"SET NAMES 'utf8'");
			$re="INSERT INTO service VALUES('".$reference1."','".$designation."')";  
			$req=mysqli_query($con,$re);
			if ($req)
				{ 	echo "<script language='javascript'>";
					echo 'alertify.success(" Enrégistrement effectué avec succès");';
					echo "</script>";
					//mysqli_query($con,"SET NAMES 'utf8'");	$query_Recordset1 = "SELECT * FROM service";
				} 
			}	
	 }
?>
<html>
	<head> 
		<link rel="Stylesheet" type="text/css" media="screen, print" href='style.css' /> 
		<link rel="Stylesheet" href='css/table.css' />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width">
		<style>
		.alertify-log-custom {
				background: blue;
			}
					#lien1:hover {
			text-decoration:underline;background-color: gold;font-size:1.1em;
		}
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
		</style><script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script src="js/sweetalert.min.js"></script>		
	</head>
	<body bgcolor='azure'>

		<div align="center" style="">
			<form action="service.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>" method="POST"> 
				<table width="700" height="280" border="0" cellpadding="0" cellspacing="0" id="tab">
					<tr>
						<td colspan="4">
							<h3 style='text-align:center; font-family:Cambria;color:maroon;font-weight:bold;'>ENREGISTREMENT DES SERVICES</h3>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;" >Code du Service:</td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="" name="reference" readonly value="<?php echo $chaine = random(3,"SE");?>" style="width:200px;"/> </td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;"> Nom du Service : </td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="" name="designation" style="width:200px;" required /> </td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;"> Responsable du Service : </td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="" name="Responsable" style="width:200px;"  /> </td>
					</tr>
	
					<tr>
						<td colspan="2" align="right" > <input type="submit" value="Enrégistrer" id="" class="bouton2"  name="ENREGISTRER" style=""/> </td>
						<td colspan="2">&nbsp;&nbsp;<input type="reset" value="Annuler" class="bouton2"  name="Annuler" style=""/> </td>
					</tr>
				</table>
		</div>
			<?php
			echo "<table align='center' style='border:0px solid black;'> <tr> <td style='font-weight:bold;'>";
		    if(isset($msg)) echo $msg;
			 echo "</td></tr></table>";
			?>
				<table align="center" width="700" border="0" cellspacing="0" style="margin-top:20px;border-collapse: collapse;font-family:Cambria;">
					<tr style="">
						<td colspan='3' style="font-family:Cambria;font-weight:bold;font-size:1.4em;margin-bottom:5px;color:#4C767A;" align="left" > Liste de tous les services</td>
					</tr>
				<tr style=" background-color:#3EB27B;color:white;font-size:1.2em; ">
						<td style="border-right: 2px solid #ffffff" align="center" >R&eacute;f&eacute;rence</td>
						<td style="border-right: 2px solid #ffffff" align="center" >D&eacute;signation</td>
						<td align="center" >Actions</td>
					</tr>
					<?php
					   $Recordset_2 = mysqli_query($con,$query_Recordset1);
							$cpteur=1;
							while($data=mysqli_fetch_array($Recordset_2))
							{
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
										echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['code']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>&nbsp;&nbsp;&nbsp;&nbsp;".$data['nom']."</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
											echo " 	<a class='info2' href=''><img src='logo/b_edit.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.9em;'>Modifier</span></a>";
											echo " 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
											echo " 	<a class='info' href=''><img src='logo/b_drop.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.9em;color:red;'>Supprimer</span></a>";
										echo " 	</td>";
									echo " 	</tr> ";
							}
						//}
					?>
				</table>
			</form>
		</body>	
</html>