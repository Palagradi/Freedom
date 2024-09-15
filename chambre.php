<?php
include_once'menu.php';
$CodeProfil='';$TypeProfil=''; $NomUti="";
// https://kwhotel.com/fr/logiciel-hotel-gratuit/
//http://ghmgesthotel.com/
//https://www.reservit.com/hebergement/pour-simplifier-votre-gestion-hoteliere/logiciel-de-gestion-hoteliere-pms
//https://www.familyhotel.fr/

//UPDATE `chambre` SET `DesignationType`='VENTILLEE' WHERE `DesignationType`='Ventillée'
//UPDATE `chambre` SET `DesignationType`='CLIMATISEE' WHERE `DesignationType`='Climatisée'

 $req=mysqli_query($con,"SELECT MAX(numch) AS numch FROM chambre ")or die ("Erreur de requête".mysqli_error($con));$initial_fiche="CH";
 $data=mysqli_fetch_object($req); $numch=$data->numch;
	if(($numch>=0)&&($numch<=9))$numch = $initial_fiche.'0000'.$numch ;	else if(($numch>=10)&&($numch <=99))$numch = $initial_fiche.'000'.$numch ;else if(($numch>=100)&&($numch<=999))	$numch = $initial_fiche.'00'.$numch ;else if(($numch>=1000)&&($numch<=1999)) $numch = $initial_fiche.'0'.$numch ;else $numch = $initial_fiche.$numch ;

mysqli_query($con,"SET NAMES 'utf8' ");
$res=mysqli_query($con,'SELECT * FROM chambre WHERE EtatChambre="active" ORDER BY nomch ASC');
$nbre=mysqli_num_rows($res);


	$date = new DateTime("now"); // 'now' n'est pas nécéssaire, c'est la valeur par défaut
	$tz = new DateTimeZone('Africa/Porto-Novo');
	$date->setTimezone($tz);
	$dateT= $date->format("Y") ."-".$date->format("m") ."-".$date->format("d") ." ".$date->format("H") .":". $date->format("i").":". $date->format("s");

	if(isset($_POST['CHANGE']) && $_POST['CHANGE'] == "Changer le prix des chambres")
		{if(empty($_POST['choix'])){
				echo "<script language='javascript'>";
					echo " alert('Vous devez sélectionner au moins une chambre dont vous voulez changer le prix.');";
					echo "</script>";
				}
			if(!empty($_POST['choix'])){//on déclare une variable
			$choix ='';
			//on boucle
			for ($i=0;$i<count($_POST['choix']);$i++)
			{
			//on concatène
			//$choix .= $_POST['choix'][$i];
			$choix .= $_POST['choix'][$i].'|';
			$explore = explode('|',$choix);
			}
			$query1="CREATE TABLE IF NOT EXISTS `dbmecef`.`ChambreTempon` (`id` INT NOT NULL AUTO_INCREMENT ,`nomCh` VARCHAR( 25 ) NOT NULL ,PRIMARY KEY ( `id` ))";
			$exec1=mysqli_query($con,$query1);
			 foreach($explore as $valeur){
				if(!empty($valeur)){
				//echo $valeur.'<br/>';
				$query2="INSERT INTO  ChambreTempon VALUES('', '".$valeur."')";
				$exec2=mysqli_query($con,$query2);
				}
			}
		}
	}
	if(isset($_POST['CHANGER']) && $_POST['CHANGER'] == "CHANGER")
		{   $reqR=mysqli_query($con,"SELECT DISTINCT nomCh FROM ChambreTempon");
			while($dataT=mysqli_fetch_array($reqR)){
			$nomCh=$dataT['nomCh'];
			$reqW=mysqli_query($con,"SELECT tarifsimple,tarifdouble,typech,DesignationType FROM chambre WHERE nomch='".$nomCh."' AND EtatChambre='active'");
			while($dataW=mysqli_fetch_array($reqW)){
				$typech=$dataW['typech'];
				$DesignationType=$dataW['DesignationType'];$NbLits = 1;//$NbLits = $_POST['NbLits'];
				$tarifsimple=$dataW['tarifsimple']; if(empty($_POST['Tsimple'])) $Tsimple=$tarifsimple; else $Tsimple=$_POST['Tsimple'];
				$tarifdouble=$dataW['tarifdouble']; if(empty($_POST['Tdouble'])) $Tdouble=$tarifdouble; else $Tdouble=$_POST['Tdouble'];
				$updateW="UPDATE chambre SET EtatChambre='desactive' WHERE nomch='".$nomCh."'";$execcUpdate=mysqli_query($con,$updateW);
				$EtatChambre="active";
				$pre_sql1="INSERT INTO chambre VALUES('','$dateT','".$nomCh."','".$NbLits."','".$typech."','".$DesignationType."','".$Tsimple."','".$Tdouble."','$EtatChambre')";
				$req1 = mysqli_query($con,$pre_sql1) or die (mysql_error($con));
				}
			}
			//$type="CL" ;$value="AB 001"; $DesignationType="Ventillée"; $EtatChambre="active";
			//$pre_sql1="INSERT INTO chambre VALUES('','$dateT','".$valeur."','".$type."','$DesignationType','".$_POST['Tsimple']."','".$_POST['Tdouble']."','$EtatChambre')";
			//$req1 = mysqli_query($pre_sql1) or die (mysql_error());
			$query2="DROP TABLE chambreTempon";
			$exec2=mysqli_query($con,$query2);
			$message = "Les modifications ont été prises en compte";
			echo "<script language='javascript'>";
			echo " alert('Les modifications ont été prises en compte.');";
			echo "</script>";
}
 $req=mysqli_query($con,"SELECT NomType FROM typechambre ")or die ("Erreur de requête".mysqli_error($con));

		if(isset($_POST['ENREGISTRER']) && $_POST['ENREGISTRER'] == "Enrégistrer")
		{	$code = $_POST['code'];
			$designation = trim($_POST['designation']);$NbLits = 1;//$NbLits = $_POST['NbLits'];
			$DesignationType = $_POST['type']; $EtatChambre ="active"; $typech="";
			$Tsimple = !empty($_POST['Tsimple'])?$_POST['Tsimple']:0; $Tdouble = !empty($_POST['Tdouble'])?$_POST['Tdouble']:0;
      $button_checkbox_1 = isset($_POST['button_checkbox_1'])?$_POST['button_checkbox_1']:0;$button_checkbox_2 = isset($_POST['button_checkbox_2'])?$_POST['button_checkbox_2']:0;
      if(!empty($button_checkbox_1)&&($button_checkbox_1>0)) $Regime_TVA=$button_checkbox_1; else $Regime_TVA=$button_checkbox_2;
		 $req=mysqli_query($con,"SELECT nomch FROM chambre WHERE nomch LIKE '".$designation."' ")or die ("Erreur de requête".mysqli_error($con));
		 if(mysqli_num_rows($req)>0){
			echo "<script language='javascript'>";
			echo 'alertify.error(" Cette chambre est déjà enregistrée. !");';
			echo "</script>";
		 }else {
			$pre_sql1="INSERT INTO chambre VALUES(NULL,'".$dateT."','".$designation."','".$typech."','".$DesignationType."','".$NbLits."','".$Tsimple."','".$Tdouble."','".$EtatChambre."','".$Regime_TVA."')";
			$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
			echo "<script language='javascript'>";
			echo 'alertify.success(" Chambre enregistrée avec succès !");';
			echo "</script>";

			mysqli_query($con,"SET NAMES 'utf8' ");
			$res=mysqli_query($con,'SELECT * FROM chambre WHERE EtatChambre="active" ORDER BY nomch ASC');
			$nbre=mysqli_num_rows($res);
		 }


		}


	 if(isset($_GET['supp'])||isset($_GET['modif']))
		{
		}
	$res=mysqli_query($con,"DELETE FROM chambreTempon");
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title><?php echo $title; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
		<link rel="Stylesheet" href='css/table.css' />
		<script type="text/javascript" src="js/jsconfirmstyle/jsConfirmStyle.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
    <script type="text/javascript" src="js/verifyCheckBoxes1.js"></script>
    <link rel="Stylesheet" type="text/css"  href='css/input.css' />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width">
		<style>
			.alertify-log-custom {
				background: blue;
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
		#bouton3:hover{
			cursor:pointer;background-color: #000000;color:white;font-weight:bold;
		}
		</style>
		<script type="text/javascript" >
			function edition() { options = "Width=auto,Height=500" ; window.open( "tarif.php", "edition", options ) ; }
		</script>
	</head>
	<body bgcolor='azure' style="">
	<div align="" style="">
	         <?php
		 		/* while($data=mysql_fetch_array($req))
					{
						echo $data['TypeProfil']."<br/>";
					}
					mysql_free_result($req);
					//mysql_close(); */
				?>
			<form action="" method="POST">
			<table align='center'width="800" height="auto" border="0" cellpadding="4" cellspacing="0" id='tab'>

	<?php
		if(!empty($_POST['choix'])){
		echo "	<tr>
					<td colspan='4'>
					<h3 style='text-align:center; font-family:Cambria;color:maroon;font-weight:bold;'>CHANGEMENT DU PRIX DES CHAMBRES</h3>
				</td>
				</tr>
				<tr>";
					//echo "<td  colspan='4' style='text-align:center; color:#FFFFFF;font-size:1em;font-style:italic;'> Vous pouvons changer les tarifs d'une chambre en particulier ou bien d'un ensemble de type de chambres</td>	";
			//on déclare une variable
			$choix ='';
			//on boucle
			for ($i=0;$i<count($_POST['choix']);$i++)
			{
			//on concatène
			//$choix .= $_POST['choix'][$i];
			$choix .= $_POST['choix'][$i].'|';
			$explore = explode('|',$choix);
			}
			echo "<tr>
				<td colspan='2' style='padding-left:100px;'>" ;
				if(count($_POST['choix'])>1) echo "Liste des chambres"; else echo "Chambre concernée";
				echo":&nbsp;&nbsp;&nbsp;<span class='rouge'></span> </td>
				<td colspan='2'>&nbsp;";
					 foreach($explore as $valeur){
				if(!empty($valeur)){
				echo "<span style='text-align:center; color:#8F0059;font-size:1em;'>".$valeur."&nbsp;<span style='color:black;'>|</span>&nbsp;</span>";

				$reqW=mysqli_query("SELECT tarifsimple,tarifdouble FROM chambre WHERE nomch='".$valeur."' AND EtatChambre='active'");
				while($dataW=mysql_fetch_array($reqW)){
					$simpleT=$dataW['tarifsimple'];
					$doubleT=$dataW['tarifdouble'];
					}
				}
			}
			echo
			"</tr>	";
	echo "<tr>
			<td colspan='2' style='padding-left:100px;'>Tarif simple :&nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
			<td colspan='2'>&nbsp;&nbsp;<input type='text' id='' name='Tsimple' style='width:250px;' placeholder='".$simpleT."'  onkeypress='' autofocus /></td>
		</tr>
		<tr>
			<td colspan='2' style='padding-left:100px;'> Tarif double : &nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
			<td colspan='2'>&nbsp;&nbsp;<input type='text' id='' name='Tdouble' style='width:250px;' placeholder='".$doubleT."' onkeypress=''/> </td>
		</tr>

		<tr>
			<td colspan='2' align='right' ><input type='submit' value='CHANGER' id='' class=''  name='CHANGER' style='margin-bottom:5px;border:2px solid #8F0059;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'/> </td>
			<td colspan='2'>&nbsp;&nbsp;<input type='reset' value='ANNULER' id='' class='les_boutons'  name='ANNULER' style='margin-bottom:5px;border:2px solid #8F0059;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'/> </td>
		</tr>";

		}else{ if(isset($_POST['change'])) echo "<script language='javascript'> alert('Vous devez cocher un champ d'abord'); </script>";
		 echo "	<tr>
						<td colspan='4'>
							<h3 style='text-align:center; font-family:Cambria;color:maroon;font-weight:bold;'>ENREGISTREMENT DES CHAMBRES</h3>
						</td>
					</tr>
					<tr>
						<td  style='text-align:center; color:#d10808;font-size:0.8em;font-style:italic;'> </td>
					</tr>
				<tr>
					<td colspan='2' style='padding-left:100px;' >Num Enrég. :&nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
					<td colspan='2'>&nbsp;&nbsp;<input type='text' id='code' name='code' style='width:250px;' readonly value='".$numch."' onkeyup='myFunction()'/> </td>
				</tr>
				<tr>
					<td colspan='2' style='padding-left:100px;'> Désignation : &nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
					<td colspan='2'>&nbsp;&nbsp;<input type='text' id='designation' name='designation' onkeyup='this.value=this.value.toUpperCase()' style='width:250px;'  onkeyup='myFunction2()' required='required' /> </td>
				</tr>";
			require('others/inter.php');
				// echo "
				// <tr>
				// 	<td  style='padding-left:100px;'> Nombre de lits : &nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
				// 	<td > </td>
				// </tr>
				// <tr>
				// 	<td  colspan='1' style='padding-left:100px;'>
				// 	Lit simple&nbsp;&nbsp;<input type='number' min='0' max='50' name='NbLits' style='width:50px;font-family:sans-serif;font-size:80%;'  onkeyup='myFunction2()' required='required' />
				// 	Lit double : &nbsp;&nbsp;&nbsp;<input type='number' min='0' max='50' name='NbLits' style='width:50px;font-family:sans-serif;font-size:80%;'  onkeyup='myFunction2()' required='required' />
				// 	Lit dappoint : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='number' min='0' max='50' name='NbLits' style='width:50px;font-family:sans-serif;font-size:80%;'  onkeyup='myFunction2()' required='required' />
				// 	</td>
				// </tr>";
			echo "<tr>
			<td colspan='2' style='padding-left:100px;'>Tarif simple ";  if($RegimeTVA==0) echo "HT";else echo "TTC"; echo " : &nbsp;&nbsp;&nbsp;<span style='color:#d10808;font-size:0.8em;'> ";    echo " * 1</span></td>
			<td colspan='2'>&nbsp;&nbsp;<input type='text' id='' name='Tsimple' style='width:250px;' required='required' onkeypress='testChiffres(event);'/>

			</td>
		</tr>
		<tr>
			<td colspan='2' style='padding-left:100px;'> Tarif double ";  if($RegimeTVA==0) echo "HT";else echo "TTC"; echo " : &nbsp;&nbsp;&nbsp;<span style='color:#d10808;font-size:0.8em;'>* 2</span></td>
			<td colspan='2'>&nbsp;&nbsp;<input type='text' id='' name='Tdouble' style='width:250px;' onkeypress='testChiffres(event);'/>

	<a class='info' onclick='edition();return false;' style='color:#B83A1B;' > <span style='font-size:0.8em;font-style:normal;'>Ajouter un Nouveau Type</span>	<i class='fa fa-plus-square' aria-hidden='true'></i></a>
			</td>
		</tr> ";?>
    <tr>
        <td colspan='2'  style="padding-left:100px;" >Régime TVA  :</td>
          <td style=''>&nbsp;
            <input type="checkbox" id="button_checkbox_1"  name="button_checkbox_1" onClick="verifyCheckBoxes1();" value='0' <?php   if($RegimeTVA==0) echo "checked"; ?>  ><label for="button_checkbox_1" >Exempté(e) </label>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type='checkbox'  id="button_checkbox_2"  name="button_checkbox_2" onClick="verifyCheckBoxes2();"  value='1' <?php   if(!empty($RegimeTVA)&&($RegimeTVA==1)) echo "checked"; ?>  ><label for="button_checkbox_2" >Assujetti(e) </label>
        </td>
    </tr>
	<?php	echo "<tr>
			<td colspan='2' align='right' ><br/><input type='submit' value='Enrégistrer' id='' class='bouton2'  name='ENREGISTRER' style=''/><br/>&nbsp; </td>
			<td colspan='2'><br/>&nbsp;&nbsp;<input type='reset' value='Annuler' id='' class='bouton2'  name='ANNULER' style=''/> <br/>&nbsp;</td>
		</tr>";
		}
	?>

	<script type="text/javascript">
<!--
function confirmation() {
	var answer = confirm("Wanna visit google?")
	if (answer){
		window.location = "http://www.google.com/";
	}
}
//-->
</script>
<style type="text/css">
body {

}
#jsconfirm {
	border-color: #c0c0c0;
	border-width: 2px 4px 4px 2px;
	left: 0;
	margin: 0;
	padding: 0;
	position: absolute;
	top: -1000px;
	z-index: 100;
}

#jsconfirm table {
	background-color: #fff;
	border: 2px groove #c0c0c0;
	height: 150px;
	width: 300px;
}

#jsconfirmtitle {
	background-color: #B0B0B0;
	font-weight: bold;
	height: 20px;
	text-align: center;
}

#jsconfirmbuttons {
	height: 50px;
	text-align: center;
}

#jsconfirmbuttons input {
	background-color: #E9E9CF;
	color: #000000;
	font-weight: bold;
	width: 125px;
	height: 33px;
	padding-left: 20px;
}

#jsconfirmleft{
	background-image: url(js/jsconfirmstyle/left.png);
}

#jsconfirmright{
	background-image: url(js/jsconfirmstyle/right.png);
}
</style>
				</table>
		</form>
		<form action='chambre.php' method='POST'><br/>
<h3 style='text-align:center;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;color:#444739;'> Liste des Chambres
					<?php

					$reqsel=mysqli_query($con,"SELECT * FROM chambre WHERE EtatChambre='active' ORDER BY nomch ASC ");
					$nbre_client=mysqli_num_rows($reqsel);
					$clientsParPage=25; //Nous allons afficher 5 contribuable par page.
					$nombreDePages=ceil($nbre_client/$clientsParPage); //Nous allons maintenant compter le nombre de pages.

					if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
					{
						  $pageActuelle=intval($_GET['page']);

						 if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
						 {
							   $pageActuelle=$nombreDePages;
						 }
					}
					else // Sinon
					{
						  $pageActuelle=1; // La page actuelle est la n°1
					}
					 $premiereEntree=($pageActuelle-1)*$clientsParPage;
					$res=mysqli_query($con,"SELECT * FROM chambre WHERE EtatChambre='active' ORDER BY nomch ASC LIMIT $premiereEntree, $clientsParPage");
					$nbre1=mysqli_num_rows($res);
					echo "&nbsp;&nbsp;&nbsp;<span style='font-style:italic;font-size:0.7em;color:#6694AE;'>".$nbre1."/".$nbre."</span>";

					echo "
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span style='color:black;font-size:0.7em;font-weight:normal;'>Page :</span> "; //Pour l'affichage, on centre la liste des pages
					$k=!empty($_GET['page'])?$_GET['page']-1:NULL; if(empty($_GET['page'])) $T=25; else $T=$_GET['i']-25;
						if($k>0)
								{
								 if(!empty($fiche))
									echo '<span style="color:black;font-size:0.7em;font-weight:normal;"> <a href="chambre.php?page='.$k.'&i='.$T.'" title="Suivant" style="text-decoration:none;"> &nbsp;<<&nbsp; </a> </span>';
								  else  if(!empty($fiche1))
									echo '<span style="color:black;font-size:0.7em;font-weight:normal;"> <a href="chambre.php?page='.$k.'&i='.$T.'" title="Suivant" style="text-decoration:none;"> &nbsp;<<&nbsp; </a> </span>';
								  else
									echo '<span style="color:black;font-size:0.7em;font-weight:normal;"> <a href="chambre.php?page='.$k.'&i='.$T.'" title="Suivant" style="text-decoration:none;"> &nbsp;<<&nbsp; </a></span> ';
								}
						for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
						{
							 //On va faire notre condition
							 if($i==$pageActuelle) //Si il s'agit de la page actuelle...
							 {
								 echo '<span style="color:black;font-size:0.7em;font-weight:normal;"> [ '.$i.' ] </span>';
							 }
							 if($i==1)
							 {
								  if(!empty($fiche))
									echo '<span style="color:black;font-size:0.7em;font-weight:normal;"> <a href="chambre.php?page='.$i.'&i=0">'.$i.'</a> </span>';
								  else  if(!empty($fiche1))
									echo '<span style="color:black;font-size:0.7em;font-weight:normal;"> <a href="chambre.php?page='.$i.'&i=0">'.$i.'</a></span> ';
								  else
									echo '<span style="color:black;font-size:0.7em;font-weight:normal;"> <a href="chambre.php?page='.$i.'&i=0">'.$i.'</a> </span>';
							 }
						} $j=!empty($j)?$j:NULL;
					if(empty($_GET['page']))$j+=2; else $j=$_GET['page'] +1;  if(empty($_GET['page'])) $T=25; else $T=25*$_GET['page'];
						if($i>=$j)
								{
								 if(!empty($fiche))
									echo ' <span style="color:black;font-size:0.7em;font-weight:normal;"><a href="chambre.php?page='.$j.'&i='.$T.'" title="Suivant" style="text-decoration:none;"> &nbsp;>>&nbsp; </a> </span>';
								  else  if(!empty($fiche1))
									echo '<span style="color:black;font-size:0.7em;font-weight:normal;"> <a href="chambre.php?page='.$j.'&i='.$T.'" title="Suivant" style="text-decoration:none;"> &nbsp;>>&nbsp; </a> </span>';
								  else
									echo '<span style="color:black;font-size:0.7em;font-weight:normal;"> <a href="chambre.php?page='.$j.'&i='.$T.'" title="Suivant" style="text-decoration:none;"> &nbsp;>>&nbsp; </a> </span>';
								}

						mysqli_query($con,"SET NAMES 'utf8'");
						$reqsel=mysqli_query($con,"SELECT  * FROM chambre  WHERE EtatChambre='active' ORDER BY nomch LIMIT $premiereEntree, $clientsParPage ");
  if(!empty($_GET['page'])){
	if($_GET['page']<=1)echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 	if($_GET['page']>$nombreDePages)echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 		if($_GET['page']==$nombreDePages)echo "&nbsp;";
	}?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' id=""  style='text-decoration:none;'>
	<input type='submit' name='CHANGE' id='bouton3' value='Changer Prix'  onclick="" <?php echo ''; ?> style='font-family:cambria;font-size:0.7em;margin-bottom:5px;border:2px solid #8F0059;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'>
	</a>

</head>
<body>
	</form>

	<script>
	function FuncToCall(){
	//changementPrix.innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-size:0.8em; font-weight:normal;'><a href='chambre.php?change=1' ></span></span>";
	}
	</script>
	<span id="changementPrix"><noscript>F</noscript></span></h3>
				<table align='center' width="800"  border="0" cellspacing="0" style="margin-top:10px;border-collapse: collapse;font-family:Cambria;">
					<tr style=" background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;">
						<td style="border-right: 2px solid #ffffff" align="center" >N° </td>
						<td style="border-right: 2px solid #ffffff" align="center" > ✔ </td>
						<td style="border-right: 2px solid #ffffff" align="center" >Désignation</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Type Chambre</td>
						<td style="border-right: 2px solid #ffffff" align="center">Tarif Simple</td>
						<td style="border-right: 2px solid #ffffff" align="center">Tarif Double</td>
						<td align="center" >Actions</td>
					</tr>
					<?php
							$cpteur=1; if(!empty($_GET['i'])) $i=$_GET['i']; else  $i=0;
							while($data=mysqli_fetch_array($reqsel))
							{ $i++; //$query=mysqli_query("UPADTE chambre SET DesignationType='Ventillée' WHERE typech='V'");
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
									echo "<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>
									<input type='checkbox' name='choix[]' value='".$data['nomch']."' onclick='FuncToCall()' onchange='FuncToCall()' />&nbsp;&nbsp;</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>	&nbsp;&nbsp;".$data['nomch']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >	".$data['DesignationType']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['tarifsimple']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['tarifdouble']."</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";

										echo " 	<a href='#'><img src='logo/b_edit.png' alt='Modifier' title='Modifier' width='16' height='16' border='0'></a>";
										echo " 	&nbsp;&nbsp;";
										echo " 	<a href='#'><img src='logo/b_drop.png' alt='Désactiver' title='Désactiver' width='16' height='16' border='0'></a>";
										echo " 	</td>";
								echo " 	</tr> ";
							}
					?>
				</table>


		</div>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="js/alertify.js/lib/alertify.min.js"></script>
	<script>
	//alertify.success("Vous venez de confirmer !");
		function reset () {
			$("#toggleCSS").attr("href", "js/alertify.js/themes/alertify.default.css");
			alertify.set({
				labels : {
					ok     : "Confirmer",
					cancel : "Annuler"
				},
				delay : 5000,
				buttonReverse : false,
				buttonFocus   : "ok"
			});
		}

		// ==============================
		// Standard Dialogs
		$("#alert").on( 'click', function () {
			reset();
			alertify.alert("This is an alert dialog");
			return false;
		});

		$("#confirm").on( 'click', function () {
			reset();
			alertify.confirm("Etes vous sûr de vouloir modifier le prix des chambres?", function (e) {
			//return false;
				if (e) {
					//alertify.success("Vous venez de confirmer !");
					 //window.location ="chambre.php?change=1";

				} else {
					//alertify.error("Vous venez d\'annuler l\'opération !");
					return false;
				}
			});
			return false;
		});

		$("#prompt").on( 'click', function () {
			reset();
			alertify.prompt("This is a prompt dialog", function (e, str) {
				if (e) {
					alertify.success("You've clicked OK and typed: " + str);
				} else {
					alertify.error("You've clicked Cancel");
				}
			}, "Default Value");
			return false;
		});

		// ==============================
		// Ajax
		$("#ajax").on("click", function () {
			reset();
			alertify.confirm("Confirm?", function (e) {
				if (e) {
					alertify.alert("Successful AJAX after OK");
				} else {
					alertify.alert("Successful AJAX after Cancel");
				}
			});
		});

		// ==============================
		// Standard Dialogs
		$("#notification").on( 'click', function () {
			reset();
			alertify.log("Standard log message");
			return false;
		});

		$("#success").on( 'click', function () {
			reset();
			alertify.success("Success log message");
			return false;
		});

		$("#error").on( 'click', function () {
			reset();
			alertify.error("Error log message");
			return false;
		});

		// ==============================
		// Custom Properties
		$("#delay").on( 'click', function () {
			reset();
			alertify.set({ delay: 10000 });
			alertify.log("Hiding in 10 seconds");
			return false;
		});

		$("#forever").on( 'click', function () {
			reset();
			alertify.log("Will stay until clicked", "", 0);
			return false;
		});

		$("#labels").on( 'click', function () {
			reset();
			alertify.set({ labels: { ok: "Accept", cancel: "Deny" } });
			alertify.confirm("Confirm dialog with custom button labels", function (e) {
				if (e) {
					alertify.success("You've clicked OK");
				} else {
					alertify.error("You've clicked Cancel");
				}
			});
			return false;
		});

		$("#focus").on( 'click', function () {
			reset();
			alertify.set({ buttonFocus: "cancel" });
			alertify.confirm("Confirm dialog with cancel button focused", function (e) {
				if (e) {
					alertify.success("You've clicked OK");
				} else {
					alertify.error("You've clicked Cancel");
				}
			});
			return false;
		});

		$("#order").on( 'click', function () {
			reset();
			alertify.set({ buttonReverse: true });
			alertify.confirm("Confirm dialog with reversed button order", function (e) {
				if (e) {
					alertify.success("You've clicked OK");
				} else {
					alertify.error("You've clicked Cancel");
				}
			});
			return false;
		});

		// ==============================
		// Custom Log
		$("#custom").on( 'click', function () {
			reset();
			alertify.custom = alertify.extend("custom");
			alertify.custom("I'm a custom log message");
			return false;
		});

		// ==============================
		// Custom Themes
		$("#bootstrap").on( 'click', function () {
			reset();
			$("#toggleCSS").attr("href", "../themes/alertify.bootstrap.css");
			alertify.prompt("Prompt dialog with bootstrap theme", function (e) {
				if (e) {
					alertify.success("You've clicked OK");
				} else {
					alertify.error("You've clicked Cancel");
				}
			}, "Default Value");
			return false;
		});
	</script>

	</body>
</html>
<?php
	// $Recordset1->Close();
?>
