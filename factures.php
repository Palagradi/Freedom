<?php
include_once'menu.php';
    mysqli_query($con,"SET NAMES 'utf8'");
	        $numfiche=!empty($_GET['numfiche'])?$_GET['numfiche']:NULL;
			if($numfiche!='') {
		    $test = "UPDATE fiche1 SET Avertissement='OUI_D' WHERE numfiche='$numfiche' ";
			$requp = mysqli_query($con,$test) or die(mysqli_error($con));
			if(requp)
			$msg1="<span style='font-weight:bold;'>L'autorisation a été accordée au client pour un séjour de plus de 15 jours</span>";
			}
	if (isset($_POST['enregistrer1'])&& $_POST['enregistrer1']=='Enrégistrer')
		{
			$nomHotel = $_POST['nomHotel'];$logoHotel = isset($_POST['logoHotel'])?$_POST['logoHotel']:NULL;$NumUFI =!empty($_POST['NumUFI'])? $_POST['NumUFI']:NULL;$Apostale = $_POST['Apostale'];$NbreEToile = $_POST['NbreEToile']; 
			$telephone1 = $_POST['telephone1'];$telephone2 = $_POST['telephone2'];$Email = $_POST['Email'];$NumBancaire = $_POST['NumBancaire'];$Siteweb= $_POST['Siteweb'];

	if(isset($_FILES['logoHotel']))
	{ $fichier=mysqli_real_escape_string($con,htmlentities($_FILES['logoHotel']['name']));
	  $fichieR="logo/".$fichier;
	  //$taille=$_FILES['fichier']['size'];
	  $fichier2=explode('.',$fichier);
	  $ext_fichier=end($fichier2);
	  $query="UPDATE autre_configuration SET logo='".$fichieR."'";
	  $query1 = mysqli_query($con,$query) or die(mysql_error($con));
	  if($query1=true) {
		  move_uploaded_file($_FILES['logoHotel']['tmp_name'],'logo/'.$fichier);
	  }
	 
	$NbreEToile=!empty($NbreEToile)?$NbreEToile:1;
	$var="update hotel SET";
	if(!empty($nomHotel))   $var=$var." "."nomHotel='".$nomHotel."'";
	if(!empty($NumUFI))     $var=$var." ".",NumUFI='".$NumUFI."'";
	if(!empty($Apostale))   $var=$var." ".",Apostale='".$Apostale."'";
	if(!empty($telephone1)) $var=$var." ".",telephone1='".$telephone1."'";
	if(!empty($telephone2)) $var=$var." ".",telephone2='".$telephone2."'";
	if(!empty($Email)) 	    $var=$var." ".",Email='".$Email."'";
	if(!empty($Siteweb)) 	$var=$var." ".",Siteweb='".$Siteweb."'";
	if(!empty($NumBancaire))$var=$var." ".",NumBancaire='".$NumBancaire."'";
	if(!empty($fichier))    $var=$var." ".",logo='".$fichier."'";
	if(!empty($NbreEToile)) $var=$var." ".",NbreEToile='".$NbreEToile."'";
	 $query=$var;
	 $query1 = mysqli_query($con,$query) or die(mysqli_error($con));
	 
	 echo "<script language='javascript'>";
	 echo 'alertify.success("Enrégistrement effectué avec succès");';
	 echo "</script>";
	}else {
		 echo "<script language='javascript'>";
		 echo 'alertify.error("Vous devez mettre un logo");';
		 echo "</script>";
	}
}
if (isset($_POST['enregistrer2'])&& $_POST['enregistrer2']=='Enrégistrer')
	{	$NumeroLoyer = $_POST['NumeroLoyer']; $DLoyer = $_POST['DLoyer']; $NomLoc = $_POST['NomLoc'];
		$ContactLoc = $_POST['ContactLoc']; $MontantLoyer = $_POST['MLoyer']; $Dpayement = $_POST['Dpayement'];

		$query="INSERT INTO loyer SET Numero='$NumeroLoyer', Designation='$DLoyer',NomLoc='$NomLoc',ContactLoc='$ContactLoc',Montant='$MontantLoyer',DatePayement='$Dpayement'";
		 $query1 = mysqli_query($con,$query) or die(mysqli_error($con));
		 echo "<script language='javascript'>";
		 echo 'alertify.error("Enrégistrement effectué avec succès");';
		 echo "</script>";

	}

?>
<html>
	<head>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width">
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script type="text/javascript" src="js/verifyCheckBoxes1.js"></script>	
		<link rel="Stylesheet" type="text/css"  href='css/input.css' />
		<style>
		.label-file {
		cursor: pointer;
		color: #00b1ca;
		font-weight: bold;
		}
		.label-file:hover {
			color: #25a5c4;
		}
		#file {
			display: none;visibility: hidden;
		}
		</style>
	</head>
	<body bgcolor='azure' style="">

	<iframe src='factures/example_011.php' width='800' height='900'>	  </iframe>

<?php
//11 et 27 50 48 63

?>
</div>
				
		</div>

		</form>

		<br/>
	<table align='center' >
		<tr>
			<td bgcolor='#FF8080' >
			</td>
		</tr>
	</table>

</body>
