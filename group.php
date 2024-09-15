<?php
include_once'menu.php';
		$i=0;
		if(($num_grpe>=0)&&($num_grpe<=9)) $num_grpe="GR000".$num_grpe ;
		if(($num_grpe>=10)&&($num_grpe <=99)) $num_grpe="GR00".$num_grpe ;
		if($num_grpe>100) $num_grpe="GR".$num_grpe ;

		$res1=mysqli_query($con,"SELECT num_encaisse  FROM encaissement");
		while ($ret=mysqli_fetch_array($res1))
			{  $num_encaisse=$ret['num_encaisse'];
				 $i++;
			//$res2=UPDATE encaissement SET  num_encaisse='$i' WHERE num_encaisse='$num_encaisse'");
			}
	//enregistrement des pays
	if (isset($_POST['ok']) && $_POST['ok']=='VALIDER')
	{
		mysqli_query($con,"SET NAMES 'utf8' ");
		if ((isset($_POST['edit1'])&& !empty($_POST['edit1'])) and (isset($_POST['edit3'])&& !empty($_POST['edit3'])))
		{  $maj=addslashes(trim($_POST['edit1'])); $IFU=!empty($_POST['IFU'])?$_POST['IFU']:0;
			$req=mysqli_query($con,"SELECT * FROM groupe WHERE codegrpe='$maj'");
					$reqi=mysqli_fetch_array($req);
			if((mysqli_num_rows($req))>0)
				{
					echo "<script language='javascript'>";
					//echo " alert('Ce Groupe existe déja ');";
					echo 'alertify.error("Ce groupe existe déja !");';
					echo "</script>";
				} else
				{
					 $ret="INSERT INTO groupe VALUES('".$_POST['edit_1']."','".$IFU."','$maj','".$_POST['edit2']."','".$_POST['edit3']."','".$_POST['email']."')";
					//echo $ret;
							$req=mysqli_query($con,$ret);
							if ($req)
								{	$update=mysqli_query($con,"UPDATE configuration_facture SET num_grpe=num_grpe+1");
									//echo "<script language='javascript'>";
									//echo " alert('Ce groupe a été enrégistré avec succès');";
									//echo "</script>";
										echo "<script language='javascript'>";
										echo 'alertify.success("Ce groupe a été enrégistré avec succès !");';
										echo "</script>";
										echo '<meta http-equiv="refresh" content="1; url=group.php?menuParent=Fichier" />';
										//header('location:groupe.php?menuParent=Fichier');
								} else
								{
									echo "<script language='javascript'>";
									echo " alert('Echec d'enregistrement');";
									echo "</script>";
								}
				}
		} else
		{
			echo "<script language='javascript'>";
			//echo " alert('Un champ est vide');";
			echo 'alertify.error("Vous devez remplir tous les champs !");';
			echo "</script>";
		}
	}
?>
<html>
	<head>
		<title>  </title>
		<script type="text/javascript" src="date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width"><link rel="Stylesheet" href='css/table.css' />
		<!-- <style>
			.input {
				font-size: 1.1em;
			}
		</style> -->
	</head>
	<body bgcolor='azure' style="">
	<div align="" style="">
						<form action='group.php' method='post'>
								<table align='center' width="800" height="300" border="0" cellpadding="0" cellspacing="0" id="tab">
									<tr>
									<td colspan="2">
										<h3 style="text-align:center; font-family:Cambria;color:maroon;font-weight:bold;">ENREGISTREMENT DES GROUPES</h3><br/>
									</td>
								</tr>
								<tr>
									<td style=""> <label style='margin-left:35%;' for ='edit_1'>Référence du groupe :   </label>  </td>
									<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='edit_1'  id='edit_1' readonly
									<?php echo 'value="'.$num_grpe ; echo '"';?> style='width:300px;font-size: 1em;'/> </td>
								</tr>
								<tr>
									<td style=""><br/> <label style='margin-left:35%;' for ='IFU'>Numéro IFU : </label> </td>
									<td><br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input maxlength="13" type='text' name='IFU' id='IFU' style='width:300px;font-size: 1em;' onkeypress="testChiffres(event);" /> </td>
								</tr>
								<tr>
									<td style=""><br/> <label style='margin-left:35%;' for ='edit1'>Désignation du groupe : </label></td>
									<td><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='edit1'  id='edit1' required='required' onkeyup='this.value=this.value.toUpperCase()' style='width:300px;font-size: 1em;'/> </td>
								</tr>
								<tr>
									<td style=""><br/><label style='margin-left:35%;' for ='edit2'>Adresse : </label></td>
									<td><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='edit2' id='edit2' style='width:300px;' style='width:300px;font-size: 1em;'/> </td>
								</tr>
								<tr>
									<td style=""><br/><label style='margin-left:35%;' for ='edit3'>N° de téléphone : </label></td>
									<td><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' required='required' id='edit3' name='edit3' onkeypress="testChiffres(event);" style='width:300px;font-size: 1em;'/> </td>
								</tr>
										<tr>
									<td style=""><br/><label style='margin-left:35%;' for ='email'>Email : </label> </td>
									<td><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='email'  id='email' name='email' style='width:300px;font-size: 1em;' onkeyup='this.value=this.value.toLowerCase()'/> </td>
								</tr>
								<tr>
									<br/><td colspan='2' align='center'> <br/><input type='submit' name='ok' class='bouton2' value='VALIDER' style=""/>  <br/>&nbsp;</td>
								</tr>
							</table>
						</form>
		</div>
	</body>

</html>
