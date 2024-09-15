<?php
include_once'menu.php';  //$req = mysqli_query($con,"DELETE FROM QteBoisson WHERE qte='Hhhh'");
/* 	$req = mysqli_query($con,"SELECT * FROM config_boisson ORDER BY LibCateg") or die (mysqli_error($con));
	//$nbre=mysqli_num_rows($req);
	$reqsel=mysqli_query($con,"SELECT * FROM boisson ");
	$nbreBoisson=mysqli_num_rows($reqsel);$nbre=$nbreBoisson+1; */

	$req="SELECT * FROM produits WHERE Type='".$_SESSION['menuParenT1']."'";
	$reqsel=mysqli_query($con,$req);
	$nbrePalimentaire=mysqli_num_rows($reqsel);$nbre=$nbrePalimentaire+1;
	if(($nbre>=0)&&($nbre<=9)) $nbre="00000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="0000".$nbre ;else $nbre="00".$nbre ;

	$sql=mysqli_query($con,"SELECT * FROM typeproduits LIMIT 1"); $NbrePrdts=10;
	$result=mysqli_fetch_object($sql); $Numero=$result->Numero;$Famille=$result->Famille;$UnitStockage=$result->UnitStockage;$PoidsNet1=$result->PoidsNet;
	$TypePrdts=$result->TypePrdts;$DateService=$result->DateService;$DatePeremption=$result->DatePeremption;$Fournisseur1=$result->Fournisseur;$PrixFournisseur1=$result->PrixFournisseur;$StockAlerte=$result->StockAlerte;$PrixVente=$result->PrixVente;

 $update=isset($_GET['update'])?$_GET['update']:NULL; $delete=isset($_GET['delete'])?$_GET['delete']:NULL;
 $rowspan=6;
		if(isset($update)){ //$rowspan=8;
		$reqk=mysqli_query($con,"SELECT * FROM boissonb WHERE numero2='".$update."' ");
		while($dataP = mysqli_fetch_object($reqk)){
			$nbre = $dataP->numero2;$designation=$dataP->designation;$Categorie=$dataP->Categorie;$Qte=$dataP->Qte;$Conditionne=$dataP->Conditionne;$Prix=$dataP->Prix;$Qte_Stock=$dataP->Qte_Stock; $Seuil=$dataP->Seuil;
			if(($nbre>=0)&&($nbre<=9)) $nbre="00000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="0000".$nbre ;else $nbre="00".$nbre ;
		}

	}



?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title><?php echo $title; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>
		<link rel="Stylesheet" href='css/table.css' />
		<link href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
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
		</style>
		<script type="text/javascript" >

			$(document).ready( function() {
		  // détection de la saisie dans le champ de recherche
		  $('#q').keyup( function(){
			$field = $(this);
			$('#resultsB').html(''); // on vide les resultats

			//document.getElementById('q').style.backgroundColor="#84CECC";
			var fiche =  document.getElementById('fiche');
			$('#ajax-loader').remove(); // on retire le loader

			// on commence à traiter à partir du 2ème caractère saisie
			if( $field.val().length > 1 )
			{  $('#resultsB').html('');
			  // on envoie la valeur recherché en GET au fichier de traitement
			  $.ajax({
			type : 'GET', // envoi des données en GET ou POST
			url : 'ajax-search2C.php' , // url du fichier de traitement
			data : 'q='+$(this).val() , // données à envoyer en  GET ou POST
			beforeSend : function() { // traitements JS à faire AVANT l'envoi
				$field.after('<img src="logo/wp2d14cca2.gif" alt="loader" id="ajax-loader" />'); // ajout d'un loader pour signifier l'action
			},
			success : function(data){ // traitements JS à faire APRES le retour d'ajax-search.php
				$('#ajax-loader').remove(); // on enleve le loader
				$('#resultsB').html(data); // affichage des résultats dans le bloc
			}
			  });
			}
		  });
		});
		</script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
			<script type="text/javascript" >
				function edition1() { options = "Width=800,Height=450" ; window.open( "CatBois.php", "edition1", options ) ; }
				function edition2() { options = "Width=800,Height=450" ; window.open( "QuantBois.php", "edition2", options ) ; }
				function devis() {
					document.getElementById('Prixvente').value=document.getElementById('Prixvente').value+document.getElementById('devise').value;
				}
			</script>
	</head>
	<body bgcolor='azure' style="">

		<table align='center'>
			<tr>
			<td>
				<h2 style=' font-family:Cambria;color:Maroon;font-weight:bold;margin-bottom:50px;'>		<hr /> STOCK DE PRODUITS ALIMENTAIRES DISPONIBLES<hr style=''/></h2>
			</td>
		</tr>
	</table>
<form class="ajax" action="" method="get">
	<p align='center'>
		<label style='font-size:20px;font-weight:bold; padding:3px;color:#B83A1B;font-family: Cambria, Verdana, Geneva, Arial;' for="q">Rechercher un produit
		<span style='font-size:15px;color:#777;'></span></label>
		 <input style='background-color:#EFFBFF;width:400px;padding:3px;border:1px solid #aaa;-moz-border-radius:7px;-webkit-border-radius:7px;border-radius:7px;height:25px;line-height:22px;' type="text" name="q" id="q" placeholder="              "/>
	</p>
</form>
<!--fin du formulaire-->

<!--preparation de l'affichage des resultats-->
<div id="resultsC">

	<table align='center' width='80%' border='0' cellspacing='0' style='margin-top:0px;border-collapse: collapse;font-family:Cambria;'>

<tr><td colspan='13' > <span style="float:left;font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#4C767A;" >Liste des produits <?php  if($_SESSION['menuParenT1']=="Restauration") echo "alimentaires"; ?>  </span>
	<?php
	//mysqli_query($con,"SET NAMES 'utf8'");
	//$result =   mysqli_query($con, 'SELECT *  FROM boisson	LIMIT 0,10' );
		$reqsel=mysqli_query($con,"SELECT * FROM produits WHERE Type='".$_SESSION['menuParenT1']."'");
	$nbrePalimentaire=mysqli_num_rows($reqsel);
	$PalimentairesParPage=25; //Nous allons afficher 5 contribuable par page.
	$nombreDePages=ceil($nbrePalimentaire/$PalimentairesParPage); //Nous allons maintenant compter le nombre de pages.

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
	 $premiereEntree=($pageActuelle-1)*$PalimentairesParPage;
	$res=mysqli_query($con,"SELECT * FROM produits WHERE Type='".$_SESSION['menuParenT1']."' LIMIT $premiereEntree, $PalimentairesParPage");
	$nbre1=mysqli_num_rows($res);

 ?>
</span>
<span style="float:right;font-weight:normal;font-size:1em;color:#4C767A;font-style:italic;" >
		&nbsp;&nbsp;&nbsp;<a href="produits.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&p=1" style="text-decoration:none;color:teal;">Liste complète des produits<img src="logo/pdf_small.gif"style=""/> <a/></span>
		<tr  style='background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;'>
			<td  style="border-right: 2px solid #ffffff" align="center" ><a class='info' href='produits.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&trie=1' style='text-decoration:none;color:white;' title="">&nbsp;N° d'Enrég.<span style='font-size:0.8em;'></span></a></td>
			<?php if($Famille==1)  { ?> <td  style="border-right: 2px solid #ffffff" align="center" ><a class='info' href='produits.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&trie=1' style='text-decoration:none;color:white;' title="">&nbsp;Famille<span style='font-size:0.8em;'></span></a></td> <?php } ?>
			<td  style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='produits.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&trie=2' style='text-decoration:none;color:white;' title=''>&nbsp;Désignation<span style='font-size:0.8em;'></span></a></td>
			<?php if($PoidsNet1==1)  { ?> <td  style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='produits.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&trie=4' style='text-decoration:none;color:white;' title=''>&nbsp;Poids<br/> Net<span style='font-size:0.8em;'></span></a></td><?php } ?>
			<td  style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='produits.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&trie=5' style='text-decoration:none;color:white;' title=''>&nbsp;Qté en <br/>Stock<span style='font-size:0.8em;'></span></a></td>
			<?php if($UnitStockage==1)  { ?> <td  style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='produits.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&trie=3' style='text-decoration:none;color:white;' title=''>&nbsp;Unité de<br/> Stockage<span style='font-size:0.8em;'></span></a></td><?php } ?>
				<td  style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='produits.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&trie=5' style='text-decoration:none;color:white;' title=''>&nbsp;Qté + <br/>en Unités<span style='font-size:0.8em;'>Quantité supplémentaire</span></a></td>
			<?php if($StockAlerte==1)  { ?> <td  style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='produits.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&trie=5' style='text-decoration:none;color:white;' title=''>&nbsp;Seuil&nbsp;<span style='font-size:0.8em;'></span></a></td><?php } ?>
			<?php if($PrixVente==1)  { ?> <td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='produits.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&trie=5' style='text-decoration:none;color:white;' title=''>&nbsp;Prix de<br/> Vente<span style='font-size:0.8em;'></span></a></td><?php } ?>
			<td align="center" >Actions</td>


		</tr>

<?php
	mysqli_query($con,"SET NAMES 'utf8'");
	$result=mysqli_query($con,"SELECT  * FROM produits WHERE Type='".$_SESSION['menuParenT1']."' LIMIT $premiereEntree, $PalimentairesParPage ");
	$cpteur=1;
    // parcours et affichage des résultats
    while( $data = mysqli_fetch_object($result))
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
	$nbre=$data->Num2;
	if(($nbre>=0)&&($nbre<=9)) $nbre="0000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="000".$nbre ;else $nbre="00".$nbre ;
    ?>
		 	<tr class='rouge1' bgcolor=' <?php echo $bgcouleur; ?>'>
				 <td align="center" style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $nbre;  ?> </td>
				<?php if($Famille==1)  { ?>  <td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $data->Famille; ?> </td> <?php } ?>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->Designation; ?></td>
				<?php if($PoidsNet1==1)  { ?> <td align="center"  style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->PoidsNet; ?></td><?php } ?>
				 <td align="center"  style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->StockCuisine; ?></td>
				<?php if($UnitStockage==1)  { ?> <td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $data->UniteStockage; ?></td><?php } ?>
				<td align="center" style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->UniteRestante; ?></td>
				<?php if($StockAlerte==1)  { ?> <td align="center" style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->Seuil; ?></td><?php } ?>
				<?php if($PrixVente==1)  { ?> <td align="center" style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->PrixV; ?></td><?php } ?>
				<?php
				echo "<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <a class='info' href=''  style='color:#FC7F3C;'><img src='logo/b_edit.png' alt='' width='16' height='16' border='0'><span style='color:#FC7F3C;font-size:0.8em;'>Modifier</span></a></td>";

	}
	?>
			</tr>
	</table>


			</tr>
	</table>


</div>
	</body>
</html>
<?php
	// $Recordset1->Close();
?>
