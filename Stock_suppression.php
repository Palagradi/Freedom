<?php
	// pages à inclure
	ob_start();
	session_start(); 
	require("Connexion_2.php");
		   if($_SESSION['poste']==cpersonnel)
		include 'menucp.php'; 
	   	   if($_SESSION['poste']==agent)
		include 'menuprin1.php'; 
			   if($_SESSION['poste']==directrice)
		include 'menudirec.php'; 
			   if($_SESSION['poste']==admin)
		include 'admin.php';
	//$reference= $_GET['reference'];
	$connecter = new Connexion_2;
	if($connecter->testConnexion())
	{mysql_query("SET NAMES 'utf8'");
			$reqsel=mysql_query("SELECT * FROM entree_sortie WHERE reference ='".$_GET['reference']."' ");
			//echo "SELECT * FROM entree_sortie WHERE reference ='".$_GET['reference']."'";
	//$result = mysql_fetch_array($reqsel);
		while($data=mysql_fetch_array($reqsel))
			{  $rlt1=$data['reference'];  
			   $rlt2=$data['designation'];
			   $rlt3=$data['seuil'];
			   $rlt4=$data['quantite'];
			   $rlt5=$data['date_entree'];
					
			}

		if(isset($_POST['Confirmer']) && $_POST['Confirmer'] == "Confirmer")
		{  	$test = "DELETE FROM `entree_sortie` WHERE reference = '".$_POST['reference']."'";
			$reqsup = mysql_query($test) or die(mysql_error());
			//echo $test;
			//header("location:Entree_Sortie.php");
			$msg="Le produit a &eacute;t&eacute; supprimer de la liste";
			$msg1="Retour";
		}
				
		if(isset($_POST['annuler']) && $_POST['annuler'] == "Annuler")
		{header('location:Entree_Sortie.php');
		}
	}
	
?>


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>SYGHOC</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>
	</head>
	<body bgcolor='#FFDAB9'>
		<div align="center">
			<form action="Stock_suppression.php" method="POST">
				<table width="586" height="200" border="0" cellpadding="2" cellspacing="0" style="margin-top:100px; border:2px solid; font-family:Cambria;">
					<tr>
						<td colspan="4">
							<h2 style="text-align:center; font-family:Cambria;color:#a4660d;">CONFIRMATION DE LA SUPPRESSION</h2>
						</td>
						
					</tr>
				  <tr>
						<td colspan="4">
							<h4 style="text-align:center; font-family:Cambria;color:blue;">Voulez vous vraiment supprimer ce produit?</h4>
							
						</td>

					<tr>
						<td colspan="2" align="right" style="padding-right: 20px;"> <input type="submit" class="les_boutons" value="Confirmer" id="" name="Confirmer" style="border:2px solid black;font-weight:bold;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;"/> </td>
						<td colspan="2"> <input type="submit" name="annuler" class="les_boutons" value="Annuler" style="border:2px solid black;font-weight:bold;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;"/> </td>
					</tr>
                    <tr>   <td colspan="2"> <input type="hidden" id="" name="reference" value="<?php echo $rlt1; ?>" onFocus="this.blur()" style="width:75px;" /> </td></tr>
				</table>
			</form>
			<table width="582" border="0" cellspacing="0" cellpadding="0">
			<tr>
			    <td>
				<h4 style="text-align:center; font-family:Cambria;color:#a4660d;"> <?php echo $msg; ?></h4>
				</td>
			</tr>
			<tr>
			    <td>
				<a href="Entree_Sortie.php" style="text-decoration:none;"><span style="text-align:center; font-family:Cambria;color:blue;margin-left:250px;"><?php echo $msg1 ?></span></a>
				</td>
			</tr>
			</table>
		</div>
	</body>
</html>