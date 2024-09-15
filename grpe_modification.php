<?php
	include_once 'menuprin1.php';
	include 'connexion.php'; 
	
	// automatisation du numéro
	function random($car) {
		$string = "G";
		$chaine = "0123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
		}
		return $string;
		}
	//enregistrement des pays  
	
	  mysql_query("SET NAMES 'utf8' ");
	$reqsel=mysql_query("SELECT * FROM groupe WHERE code_reel='".$_GET['reference']."' ");
	//echo ("SELECT * FROM groupe WHERE numcli ='".$_GET['numcli']."' ");
		while($data=mysql_fetch_array($reqsel))
			{  $rlt1=$data['codegrpe'];  
			   $rlt2=$data['adressegrpe'];
			   $rlt3=$data['contactgrpe'];
			}
			
	if (isset($_POST['ok']) && $_POST['ok']=='VALIDER')
	{
		mysql_query("SET NAMES 'utf8' ");
		$test = "UPDATE groupe SET codegrpe='".$_POST['edit1']."', adressegrpe='".$_POST['edit2']."', contactgrpe='".$_POST['edit3']."'
			WHERE code_reel='".$_POST['edit_1']."' ";
		$reqsup = mysql_query($test) or die(mysql_error());
		$msg="Les modifications apport&eacute;es sur le groupe ont &eacute;t&eacute; prise en compte";
		$msg1="Retour";
		//else $msg="Aucune modification apportée. Merci!";
	}
?>
<html>
	<head> 
		<title> SYGHOC </title> 
		<script type="text/javascript" src="date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
	</head>
	<body bgcolor='#aaaaaa'>
		<table border='1' align='center'width="800">
			<tr>
				<td align='center'> 
					<fieldset> 
						<legend align='center'style='font-size:1.3em;'><b> MODIFICATION DES INFORMATIONS DU GROUPE </b></legend>
						<form action='grpe_modification.php' method='post'>
							<table style='font-size:1.2em;'>
								<tr>
									<td> Référence du groupe: </td>
									<td> <input type='text' name='edit_1'  readonly value="<?php echo $_GET['reference'];?>" /> </td>
								</tr>
								<tr>
									<td> Désignation du groupe: </td>
									<td> <input type='text' name='edit1' value="<?php echo $rlt1;?>" onkeyup='this.value=this.value.toUpperCase()'/> </td>
								</tr>
								<tr>
									<td> Adresse: </td>
									<td> <input type='text' name='edit2' value="<?php echo $rlt2;?>"/> </td>
								</tr>
								<tr>
									<td> Contact: </td>
									<td> <input type='text' name='edit3'onkeypress="testChiffres(event);" value="<?php echo $rlt3;?>"/> </td>
								</tr>
								<tr> 
									<br/><td colspan='2' align='center'> <br/><input type='submit' name='ok' value='VALIDER'/> </td>
								</tr>
							</table>
						</form>
					</fieldset>
				</td>
			</tr>
		</table>
		<?php 	
		   echo "<table align='center' style='border:0px solid black;color:blue;font-style:italic;'> <tr> <td style='font-weight:bold;'></br>
		    $msg
		</td></tr></table>";
		?>
	</body> 
	
</html> 