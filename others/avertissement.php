<?php
include_once'menu.php';  $_SESSION['ladate2']; 
//echo $_SESSION['Nuite']." ".$limite_jrs;
		if(isset($_POST['Confirmer']) && $_POST['Confirmer'] == "Confirmer")
		{
			$msg="Une autorisation a  &eacute;t&eacute; envoy&eacute;e";
			$msg1="Retour";
			$_SESSION['etat']=1;$etat='NON'; 
			$date=date('Y-m-d');$avertissement="OUI";
			$ret="INSERT INTO fiche1 VALUES('".$_SESSION['edit1']."','','".$_SESSION['edit2']."','".$_SESSION['edit2']."','','".$_SESSION['combo2']."','".$_SESSION['edit_9']."','".$_SESSION['edit10']."','".$_SESSION['edit11']."','".$_SESSION['edit17']."','".$_SESSION['edit18']."','".$_SESSION['edit19']."','".$_SESSION['ladate2']."','".$_SESSION['ladate2']."','12:00','".$_SESSION['edit21']."','".$_SESSION['rad']."','','".$_SESSION['re']."','','".$_SESSION['login']."','".$_SESSION['login']."','".$_SESSION['Nuite']."','$avertissement')"; 
			$req=mysql_query($ret);
			$reqA=mysql_query("INSERT INTO mensuel_fiche1 VALUES('".$_SESSION['edit1']."','','".$_SESSION['edit2']."','".$_SESSION['edit2']."','','".$_SESSION['combo2']."','".$_SESSION['edit_9']."','".$_SESSION['edit10']."','".$_SESSION['edit11']."','".$_SESSION['edit17']."','".$_SESSION['edit18']."','".$_SESSION['edit19']."','".$_SESSION['ladate2']."','".$_SESSION['ladate2']."','12:00','".$_SESSION['edit21']."','".$_SESSION['rad']."','','".$_SESSION['re']."','','".$_SESSION['login']."','".$_SESSION['login']."','".$_SESSION['Nuite']."','$avertissement')");
			$update=mysql_query("UPDATE configuration_facture SET num_fiche=num_fiche+1  WHERE num_fiche!=''");
			header("location:fiche.php?dir=1");
		}
				
		if(isset($_POST['Annuler']) && $_POST['Annuler'] == "Annuler")
		{header("location:fiche.php");
		}
?> 
<head>
<SCRIPT LANGUAGE="JavaScript">
//D'autres scripts sur http://www.toutjavascript.com
//Si vous utilisez ce script, merci de m'avertir !  < webmaster@toutjavascript.com >

function msg1() {
	// affiche un message au visiteur 
	alert("Une autorisation a  été envoyée à l'administrateur du système");
}

function msg2() {
	// pose une question au visiteur
	if (confirm("Voici un message obtenu par la fonction javascript confirm")) {
		alert("Vous avez cliqué sur OK");
	} else {	
		alert("Vous avez cliqué sur Annuler");
	}
}

function msg3() {
	// ouvre une boite de saisie
	var resultat=prompt("Saisissez un texte","texte par défaut");
	if (resultat==null) {
		alert("Vous avez cliqué sur Annuler");
	} else {	
		alert("Vous avez saisi ["+resultat+"]");
	}
}


</SCRIPT>
</HEAD>
<form action="avertissement.php" method="POST"> 
	<table border='1' align='center' align='center' width='80%'  cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;margin-top:20px;'>
    <tr bgcolor=''> 
	<td align='center' style="font-weight:bold;"> En fonction de votre profil, aucune r&eacute;servation ou demande d'hebergement ne doit excéder <span style="color:red;">15 jours</span>. Vous pouvez toutefois obtenir une permission sp&eacute;ciale aupr&eacute;s de la Directrice
	ou du Chef personnel.</td> 
	<td>
		<h4 style="text-align:center; font-family:Cambria;color:blue;">Voulez vous obtenir une permission?</h4>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Confirmer" class=""  name="Confirmer" style="border:2px solid black;font-weight:bold;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;" onClick='msg1()' /> 
		<input type="submit" value="Annuler" class=""  name="Annuler" style="border:2px solid black;font-weight:bold;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;"/> 
	</td>
    </tr>
 </table>
 </form>
 <?php //echo $msg ?>
