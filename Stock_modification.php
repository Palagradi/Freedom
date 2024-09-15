<?php
     ob_start();
	session_start(); 
    mysql_query("SET NAMES 'utf8'");	
	   if($_SESSION['poste']==cpersonnel)
		include 'menucp.php'; 
	   	   if($_SESSION['poste']==agent)
		include 'menuprin1.php'; 
			   if($_SESSION['poste']==directrice)
		include 'menudirec.php'; 
			   if($_SESSION['poste']==admin)
		include 'admin.php';
			if($_SESSION['poste']==secretaire)
		include 'menusecretaire.php';
		include 'connexion.php'; 
		include 'connexion_2.php';	
	$connecter = new Connexion_2;
	if($connecter->testConnexion())
	{mysql_query("SET NAMES 'utf8'");
	
		$reqsel=mysql_query("SELECT * FROM entree_sortie WHERE reference ='".$_GET['reference']."' ");
	//$result = mysql_fetch_array($reqsel);
		while($data=mysql_fetch_array($reqsel))
			{  $rlt1=$data['reference1'];  
			   $rlt2=$data['designation'];
			   $rlt3=$data['seuil'];
			   //$rlt4=$data['quantite'];
			   $rlt5=$data['date_entree'];
					
			}
		if(isset($_POST['enregistrer']) && $_POST['enregistrer'] == "Modifier")
		{   $test = "UPDATE entree_sortie SET designation='".$_POST['designation']."', seuil='".$_POST['seuil']."', quantite='".$_POST['quantite']."', date_entree='".$_POST['date_entre']."' WHERE reference='".$_POST['reference']."' ";
			$reqsup = mysql_query($test) or die(mysql_error());
			//header("location:Entree_Sortie.php");
			$msg="La modification a &eacute;t&eacute; prise en compte concernant ce produit";
			$msg1="Retour";
		}
				
		if(isset($_POST['annuler']) && $_POST['annuler'] == "Annuler")
		{header('location:Entree_Sortie.php');
		}
	}
	
	$chaine = strpos($result['reference'], " ");
	//$rlt1 = substr($result['designation'],0,$chaine);
	 //$rlt2 = substr($result['designation'],$chaine+1);
	
?>


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>SYGHOC</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>
	</head>
	<body bgcolor='#FFDAB9'>
		<div align="center">
			<form action="Stock_modification.php" method="POST">
				<table width="586" height="200" border="0" cellpadding="2" cellspacing="0" style="margin-top:100px; border:2px solid; font-family:Cambria;padding-bottom:2%;">
					<tr>
						<td colspan="4">
							<h2 style="text-align:center; font-family:Cambria;color:#a4660d;">MISE A JOUR DU PRODUIT</h2>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;">R&eacute;f&eacute;rence : </td>
						<td colspan="2"> <input type="text" id="" name="reference" value="<?php echo $rlt1 ?>" onFocus="this.blur()" style="width:200px;" /> </td>
					</tr>
					<tr> 
						<td colspan="2" style="padding-left:100px;"> D&eacute;signation : </td>
						<td colspan="2"> <input type="text" id="" name="designation" value="<?php echo $rlt2 ?>" style="width:200px;"/> </td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;"> Seuil : </td>
						<td colspan="2"> 
		               <input type="text" id="" name="seuil"  value="<?php echo $rlt3 ?> "  style="width:200px;" />
						</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;">Date d'entr&eacute;e : </td>
						<td colspan="2"> <input type="text" id="" name="date_entre"  value="<?php echo $rlt5 ?> " onFocus="this.blur()" style="width:200px;" /></td>
					</tr>
					<tr>
						<td colspan="2" align="right" style="padding-right: 20px;"><br/> <input type="submit" class="les_boutons" value="Modifier" id="" name="enregistrer" style="border:2px solid black;font-weight:bold;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;"/> </td>
						<td colspan="2"><br/>  <input type="submit" name="annuler" class="les_boutons" value="Annuler" style="border:2px solid black;font-weight:bold;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;"/> </td>
					</tr>

				</table>
			</form>
			<table width="582" border="0" cellspacing="0" cellpadding="0">
			<tr>
			    <td>
				<h4 style="text-align:center; font-family:Cambria;color:#a4660d;"> <?php echo $msg ?></h4>
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