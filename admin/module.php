<?php
include_once'../menu.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" style='overflow-x: hidden;'>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="Pragma" CONTENT="no-cache">
		<title> <?php echo $nomHotel; ?> </title>

		<title> <?php echo $nomHotel; ?> </title>
			<link href="../bootstrap/customiz_e.css" rel="stylesheet">
			<link rel="Stylesheet" type="text/css" media="screen, print" href='../css/style.css' />
			<link href="../fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
			<link href="../bootstrap/4.1.1/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
			<script src="../bootstrap/4.1.1/bootstrap.min.js"></script>
			<script src="../bootstrap/4.1.1/jquery.min.js"></script>
			<link href="../bootstrap/4.0.0/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
			<script src="../bootstrap/4.0.0/bootstrap.min.js"></script>
			<script src="../bootstrap/4.0.0/jquery.min.js"></script>
			
			<link rel="Stylesheet" type="text/css"  href='../css/input.css' />
			<link rel="stylesheet" href="../js/alertify.js/themes/alertify.core.css" />
			<link rel="stylesheet" href="../js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
<style>
	.alertify-log-custom {
		background: blue;
	}
	.bouton5 {
	border-radius:12px 0 12px 0;
	background: #d34836;
	border:none;
	color:#fff;
	font:bold 12px Verdana;
	padding:6px ;font-family:cambria;font-size:1em;
}
.bouton5:hover{
    cursor:pointer;background-color: #000000;
}
	.bouton6 {
	border-radius:12px 0 12px 0;
	background: #000000;
	border:none;
	color:#fff;
	font:bold 12px Verdana;
	padding:6px ;font-family:cambria;font-size:1em;
}
.bouton6:hover{
    cursor:pointer;background-color: #d34836;
}
</style>
<script src="../js/alertify.js/lib/alertify.min.js"></script>
<?php echo "</head>";

//echo '<meta http-equiv="refresh" content="10; url=admin.php" />';

if (isset($_POST['Envoyer']) and $_POST['Envoyer']=="ACTIVER/DESACTIVER"){
	if(isset($_POST['button_checkbox_1']) )
		$req1 = mysqli_query($con,"UPDATE module SET Etat='1' WHERE Name='HEBERGEMENT'") or die (mysqli_error($con));
	else
		$req1 = mysqli_query($con,"UPDATE module SET Etat='0' WHERE Name='HEBERGEMENT'") or die (mysqli_error($con));	
	
	if(isset($_POST['button_checkbox_2']) )
		$req1 = mysqli_query($con,"UPDATE module SET Etat='1' WHERE Name='RESTAURATION'") or die (mysqli_error($con));	
	else 
		$req1 = mysqli_query($con,"UPDATE module SET Etat='0' WHERE Name='RESTAURATION'") or die (mysqli_error($con));
	
	if(isset($_POST['button_checkbox_3']) )
		$req1 = mysqli_query($con,"UPDATE module SET Etat='1' WHERE Name='ECONOMAT'") or die (mysqli_error($con));
	else 
		$req1 = mysqli_query($con,"UPDATE module SET Etat='0' WHERE Name='ECONOMAT'") or die (mysqli_error($con));
	
	if(isset($_POST['button_checkbox_4']) )
		$req1 = mysqli_query($con,"UPDATE module SET Etat='1' WHERE Name='BIENS IMMOBILIERS'") or die (mysqli_error($con));
	else 
		$req1 = mysqli_query($con,"UPDATE module SET Etat='0' WHERE Name='BIENS IMMOBILIERS'") or die (mysqli_error($con));
	
	echo "<script language='javascript'>";
		echo 'alertify.success("Opération effectuée avec succès");';
	echo "</script>";

}
	$reqsel=mysqli_query($con,"SELECT * FROM module WHERE Etat='1' AND Name ='HEBERGEMENT'");
	if(mysqli_num_rows($reqsel)>0) $idr1=1; 
	$reqsel=mysqli_query($con,"SELECT * FROM module WHERE Etat='1' AND Name ='RESTAURATION'");
	if(mysqli_num_rows($reqsel)>0) $idr2=1; 
	$reqsel=mysqli_query($con,"SELECT * FROM module WHERE Etat='1' AND Name ='ECONOMAT'");
	if(mysqli_num_rows($reqsel)>0) $idr3=1;
	$reqsel=mysqli_query($con,"SELECT * FROM module WHERE Etat='1' AND Name ='BIENS IMMOBILIERS'");
	if(mysqli_num_rows($reqsel)>0) $idr4=1;
	 
?>	<body style='background-color:#84CECC; '>
	<form action='' method='post' id="chgdept" >
	<table align='center' width='55%' height='50%' border='0' cellpadding='0' cellspacing='0' style='margin-top:5%;border:2px solid teal;font-family:Cambria;background-color:#f5f5dc;'>
		<tr>
			<td align='center' colspan='2' ><h3>SELECTION DE MODULE(S) A INSTALLER</h3></td>
		</tr>
			<tr>   <td align='center'  style="" >&nbsp;	</td></tr>	
		<tr>   
			<td align='center'  style="" >
					<input type="checkbox" id="button_checkbox_1"  name="button_checkbox_1"  <?php if(isset($idr1)) echo "checked='checked'"; ?>><label for="button_checkbox_1" ><h2>HEBERGEMENT	</h2></label>				
			</td>
			<td align='center'  style="" >
					<input type='checkbox'  id="button_checkbox_2"  name="button_checkbox_2"   <?php if(isset($idr2)) echo "checked='checked'"; ?>><label for="button_checkbox_2"><h2>RESTAURATION</h2></label>				
			</td>
		</tr>
		<tr>   <td align='center'  style="" >&nbsp;	</td></tr>	
		<tr>	<td align='center'  style="" >
					<input type='checkbox'  id="button_checkbox_3"  name="button_checkbox_3"  <?php if(isset($idr3)) echo "checked='checked'"; ?> ><label for="button_checkbox_3"><h2>ECONOMAT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h2></label>				
				</td>
				<td align='center'  style="" >
					<input type='checkbox'  id="button_checkbox_4"  name="button_checkbox_4"  <?php if(isset($idr4)) echo "checked='checked'"; ?> ><label for="button_checkbox_4"><h2>BIENS IMMOBILIERS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h2></label>				
				</td>
		</tr>
		
		<tr>	<td align='center'  colspan='2' style="" > <br/><br/><input class='bouton5' type="submit" name="Envoyer" value="ACTIVER/DESACTIVER" style='margin-bottom:25px;'/> 
		 		</td>	</tr>
	</table>
	</form>
	</body>
