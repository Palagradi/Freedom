﻿<?php
	include_once'menu.php';

	//$reqsel=mysqli_query($con,"DELECTE FROM produits ");
	//echo $_SESSION['menuParenT'];
	$req="SELECT * FROM produits WHERE Type='".$_SESSION['menuParenT1']."'";
	$reqsel=mysqli_query($con,$req);
	$nbrePalimentaire=mysqli_num_rows($reqsel);$nbre=$nbrePalimentaire+1;
	if(($nbre>=0)&&($nbre<=9)) $nbre="00000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="0000".$nbre ;else $nbre="00".$nbre ;

	$sql=mysqli_query($con,"SELECT * FROM typeproduits LIMIT 1"); $NbrePrdts=10;
	$result=mysqli_fetch_object($sql); $Numero=$result->Numero;$Famille=$result->Famille;$UnitStockage=$result->UnitStockage;$PoidsNet1=$result->PoidsNet;
	$TypePrdts=$result->TypePrdts;$DateService=$result->DateService;$DatePeremption=$result->DatePeremption;$Fournisseur1=$result->Fournisseur;$PrixFournisseur1=$result->PrixFournisseur;$StockAlerte=$result->StockAlerte;$PrixVente=$result->PrixVente;

if(isset($_POST['ENREGISTRER'])&& ($_POST['ENREGISTRER']=="Enrégistrer")){$code=(int)$_POST['code'];
	$famille=ucfirst(addslashes($_POST['famille']));$designation=ucfirst(addslashes($_POST['designation']));$UniteStockage=$_POST['UniteStockage'];$PoidsNet=!empty($_POST['Poids'])?$_POST['Poids']:0;$Fournisseur=!empty($_POST['Fournisseur'])?$_POST['Fournisseur']:0;$Seuil=!empty($_POST['Seuil'])?$_POST['Seuil']:0; $PrixFrs=!empty($_POST['Prix'])?$_POST['Prix']:0;
	$req="SELECT * FROM produits WHERE Designation='".$designation."' AND Famille ='".$famille."' AND PoidsNet='".$PoidsNet."' AND UniteStockage='".$UniteStockage."' AND Type='".$_POST['menuParenT']."'";
	$Qte_Stock=isset($_POST['Qte_Stock'])?$_POST['Qte_Stock']:0;	$reqsel=mysqli_query($con,$req);
		if(mysqli_num_rows($reqsel)>0){
			echo "<script language='javascript'>";
			echo 'alertify.error(" Attention : Ce produit alimentaire existe déjà ");';
			echo "</script>";
		}else{ $PrixV=!empty($_POST['PrixV'])?$_POST['PrixV']:0; $DateService=isset($_POST['dateS'])?$_POST['dateS']:NULL; //DateService='$DateService', datePeremption='".$_POST['dateP']."'
		echo $req="INSERT INTO produits SET Num=NULL,Num2='".$code."',Famille='".$famille."',TypePrdts='".$TypePrdts."',Designation='".$designation."',UniteStockage='".$UniteStockage."',PoidsNet ='".$PoidsNet."',Fournisseur='".$Fournisseur."',Seuil='".$Seuil."',PrixFrs='".$PrixFrs."',Qte_Stock='".$Qte_Stock."',StockReel='".$Qte_Stock."',PrixV='".$PrixV."', Type='".$_POST['menuParenT']."',StockCuisine=0";
		$query = mysqli_query($con,$req) or die (mysqli_error($con));
		if($query){
		$sql=mysqli_query($con,"SELECT * FROM categorieproduit WHERE Type LIKE '".$_POST['menuParenT']."' AND catPrd LIKE '".$famille."'");
		if(mysqli_num_rows($sql)<=0)
		{	$req="INSERT INTO categorieproduit SET Num=NULL,Type='".$_POST['menuParenT']."',catPrd='".$famille."'";
			$query = mysqli_query($con,$req) or die (mysqli_error($con));
		}
			echo "<script language='javascript'>";
			echo 'alertify.success(" Enrégistrement effectué avec succès");';
			echo "</script>";
			echo '<meta http-equiv="refresh" content="1; url=produits.php?menuParent=Enrégistrement" />';
			}
		}

}
$update=isset($_GET['update'])?$_GET['update']:NULL; $delete=isset($_GET['delete'])?$_GET['delete']:NULL; $ap=isset($_GET['ap'])?$_GET['ap']:NULL;$app=isset($_GET['app'])?$_GET['app']:NULL;
	if(isset($update)){
		//echo $sql="SELECT * FROM produits,fournisseurs WHERE produits.Fournisseur=fournisseurs.NumFrs AND Num='".$update."' AND Type='".$_SESSION['menuParenT']."'";
	    $sql="SELECT * FROM produits WHERE Num='".$update."' AND Type='".$_SESSION['menuParenT1']."'";
		$reqk=mysqli_query($con,$sql);
		while($dataP = mysqli_fetch_object($reqk)){
			$nbre = $dataP->Num2;$designation=$dataP->Designation;$famille=$dataP->Famille;$UniteStockage=$dataP->UniteStockage;$PoidsNet=!empty($dataP->PoidsNet)?$dataP->PoidsNet:NULL;$Qte_Stock=isset($dataP->Qte_Stock)?$dataP->Qte_Stock:0; $Seuil=$dataP->Seuil; $Fournisseur=$dataP->Fournisseur; $PrixFrs=!empty($dataP->PrixFrs)?$dataP->PrixFrs:NULL; $PrixV=$dataP->PrixV;  $dateP=$dataP->datePeremption;
			if(($nbre>=0)&&($nbre<=9)) $nbre="00000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="0000".$nbre ;else $nbre="00".$nbre ;
		}
	}
	if(isset($ap)){
		$req="SELECT * FROM produits WHERE Num='".$ap."' AND Type='".$_SESSION['menuParenT1']."'";
		$reqk=mysqli_query($con,$req);
		while($dataP = mysqli_fetch_object($reqk)){
			$nbre = $dataP->Num2;$designation=$dataP->Designation;$famille=$dataP->Famille;$UniteStockage=$dataP->UniteStockage;$Conditionne=isset($dataP->Conditionne)?$dataP->Conditionne:NULL;$Prix=isset($dataP->Prix)?$dataP->Prix:NULL;$Qte_Stock=isset($dataP->Qte_Stock)?$dataP->Qte_Stock:0; $Seuil=isset($dataP->Seuil)?$dataP->Seuil:NULL;
			$TypeP = $dataP->TypePrdts; if($TypeP==1) $TypeP="Vendable"; else $TypeP="Non Vendable";  $StockCuisine = isset($dataP->StockCuisine)?$dataP->StockCuisine:0;
			$DateS=substr($dataP->DateService,8,2).'/'.substr($dataP->DateService,5,2).'/'.substr($dataP->DateService,0,4);$dateP=substr($dataP->datePeremption,8,2).'/'.substr($dataP->datePeremption,5,2).'/'.substr($dataP->datePeremption,0,4);

		}
			if(($nbre>=0)&&($nbre<=9)) $nbre="00000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="0000".$nbre ;else $nbre="00".$nbre ;
	}

	if(isset($_POST['ENREGISTRER'])&& ($_POST['ENREGISTRER']=="Approvisionner")){
			$update=(int)$_POST['code'];
			$StockCuisine=$_POST['qte']+$_POST['QteAf'];

		    //$rz="SELECT * FROM produits WHERE Num='".$update."' AND Type='".$_POST['menuParenT']."'"; $reqA=mysqli_query($con,$rz);
			//$data2=mysqli_fetch_assoc($reqA);$Qte_initial= $data2['StockCuisine'];

			$rek="UPDATE produits SET StockCuisine='".$StockCuisine."' WHERE Num='".$_GET['ap']."' AND Type='".$_POST['menuParenT']."'";
			$query = mysqli_query($con,$rek) or die (mysqli_error($con));

			if($query){
			echo "<script language='javascript'>";
			echo 'alertify.success(" Approvisionnement de la cuisine effectué avec succès !");';
			echo "</script>";
			//echo '<meta http-equiv="refresh" content="1; url=produits.php?menuParent='.$_SESSION['menuParenT'].'" />';
			}
	}

if(isset($_POST['ENREGISTRER'])&& ($_POST['ENREGISTRER']=="Modifier")){
		$update=$_POST['update']; //$update=(int)$_POST['code'];
		$famille=ucfirst($_POST['famille']);$designation=ucfirst($_POST['designation']);$UniteStockage=$_POST['UniteStockage'];$PoidsNet=!empty($_POST['Poids'])?$_POST['Poids']:0;$Fournisseur=!empty($_POST['Fournisseur'])?$_POST['Fournisseur']:NULL;$Seuil=!empty($_POST['Seuil'])?$_POST['Seuil']:0; $PrixFrs=!empty($_POST['Prix'])?$_POST['Prix']:0;
		//$Qte_Stock=isset($_POST['Qte_Stock'])?$_POST['Qte_Stock']:0;//$qte=$_POST['qte']+$_POST['QteAj'];

	    $rz="SELECT * FROM produits WHERE Num='".$update."' AND Type='".$_POST['menuParenT']."'"; $reqA=mysqli_query($con,$rz);
		$data2=mysqli_fetch_assoc($reqA);$Qte_initial= $data2['Qte_Stock'];

	    //$rz="SELECT NumFrs FROM fournisseurs WHERE RaisonSociale='".$Fournisseur."' "; $reqA=mysqli_query($con,$rz);
		//$data2=mysqli_fetch_assoc($reqA);$NumFrs= $data2['NumFrs'];

		$rek="UPDATE produits SET Famille='".$famille."', designation='".$designation."',UniteStockage='".$UniteStockage."',PoidsNet='".$PoidsNet."',Fournisseur='".$Fournisseur."',Seuil='".$Seuil."',PrixFrs='".$PrixFrs."', PrixV='".$_POST['PrixV']."',datePeremption='".$_POST['dateP']."',TypePrdts='".$_POST['TypePrdts']."',DateService='".$_POST['dateS']."' WHERE Num='".$update."' AND Type='".$_POST['menuParenT']."'";
		$query = mysqli_query($con,$rek) or die (mysqli_error($con));

/* 		$ref="PRIN".$update ; $quantiteF=$_POST['qte']+$_POST['QteAj']; $service="Depot";$designationOperation ='Mise à jour Produit alimentaire';
		if($_POST['QteAj']>0) { $re="INSERT INTO operation VALUES(NULL,'".$ref."','".$designationOperation."','".$update."','".$Qte_initial."','".$_POST['QteAj']."','".$quantiteF."','".$Jour_actuel."','".$Heure_actuelle."','','".$_POST['QteAj']."')";
		$req=mysqli_query($con,$re);}	 */

		if($query){
		echo "<script language='javascript'>";
		echo 'alertify.success(" Modification effectuée avec succès !");';
		echo "</script>";
		//$req = mysqli_query($con,"SELECT * FROM config_boisson ORDER BY LibCateg") or die (mysqli_error($con));
		echo '<meta http-equiv="refresh" content="1; url=produits.php?menuParent='.$_SESSION['menuParenT'].'" />';
		}
}

/* 		 $add=isset($_GET['aj'])?$_GET['aj']:NULL;
		 if(isset($add)){ $QteAj=0;

		$rz="SELECT * FROM produits WHERE num='".$add."' "; $req=mysqli_query($con,$rz);
		$data=mysqli_fetch_object($req);  $Qte_initial= $data->Qte_Stock; $quantiteF=$Qte_initial+$QteAj;$update=$data->Num2 ;

		if($QteAj>0) {
		$rek="UPDATE produits SET Qte_Stock='".$quantiteF."',StockReel='".$quantiteF."' WHERE Num='".$add."' AND Type='".$_SESSION['menuParenT1']."'";
		$query = mysqli_query($con,$rek) or die (mysqli_error($con));  $ref="PRIN".$update ;  $service=" "; $designationOperation ='Mise à jour Produits';
	    $re="INSERT INTO operation VALUES(NULL,'".$ref."','".$designationOperation."','".$update."','".$Qte_initial."','".$QteAj."','".$quantiteF."','".$Jour_actuel."','".$Heure_actuelle."','','".$QteAj."')";
		$req=mysqli_query($con,$re);}

		} */
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title><?php echo $title; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="Stylesheet" href='css/table.css' />
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>
		<link href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		
		<link href="js/datatables/dataTables.bootstrap4.css" rel="stylesheet">
		
		<link href="js/editableSelect/jquery-editable-select.min.css" rel="stylesheet">
		
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
			height:auto;font-family:cambria;font-size:0.9em;width:130px;
		}
		.bouton2:hover{color:white;
			cursor:pointer;background-color: #B1221C;border:2px solid #B1221C;
		}

		</style>
		<script type="text/javascript" >
			function fournisseurs() { options = "Width=800,Height=400" ; window.open( "fournisseurs.php", "Fournisseurs", options ) ; }

/* 			$(document).ready( function() {
		  // détection de la saisie dans le champ de recherche
		  $('#p').keyup( function(){
			$field = $(this);
			$('#resultsC').html(''); // on vide les resultats

			//document.getElementById('q').style.backgroundColor="#84CECC";
			var fiche =  document.getElementById('fiche');
			$('#ajax-loader').remove(); // on retire le loader

			// on commence à traiter à partir du 2ème caractère saisie
			if( $field.val().length > 1 )
			{  $('#resultsC').html('');
			  // on envoie la valeur recherché en GET au fichier de traitement
			  $.ajax({
			type : 'GET', // envoi des données en GET ou POST
			url : 'ajax-searchP.php' , // url du fichier de traitement
			data : 'p='+$(this).val() , // données à envoyer en  GET ou POST
			beforeSend : function() { // traitements JS à faire AVANT l'envoi
				$field.after('<img src="logo/wp2d14cca2.gif" alt="loader" id="ajax-loader" />'); // ajout d'un loader pour signifier l'action
			},
			success : function(data){ // traitements JS à faire APRES le retour d'ajax-search.php
				$('#ajax-loader').remove(); // on enleve le loader
				$('#resultsC').html(data); // affichage des résultats dans le bloc
			}
			  });
			}
		  });
		}); */
		</script>
			<script type="text/javascript" src="js/fonctions_utiles.js"></script>
			<script type="text/javascript" src="js/ajax.js"></script>
			<script type="text/javascript" src="js/ajax-dynamic-list.js"></script>
			<script src="js/sweetalert.min.js"></script>
			<script type="text/javascript" >
				/* function edition1() { options = "Width=800,Height=450" ; window.open( "Libmenu.php", "edition1", options ) ; }
				function edition1() { options = "Width=800,Height=450" ; window.open( "Libmenu.php", "edition1", options ) ; }
				function edition2() { options = "Width=800,Height=450" ; window.open( "QuatPalimentaire.php", "edition2", options ) ; }  */
					function JSalert(){
					swal("Nouvelle Unité de stockage :", {
				  content: {
				  element: "input",
				  attributes: {
				  placeholder: "Sélectionnez ou saisissez un nombre dans le champ",
				  type: "number",
				  Default: "2" ,
				  },
			      },
				  })
					.then((value) => {
					  //swal(`Nom client : ${value}`);
					  //document.getElementById('Nomclt').value=value;   var table = document.getElementById('NameTable').value;  var cv = document.getElementById('cv').value;
					  document.location.href='products.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&qte='+value;
/* 					  //swal(`Nom client : ${value}`);
					  //document.getElementById('Nomclt').value=value;
					   var table = document.getElementById('NameTable').value;  var cv = document.getElementById('cv').value;
					  //document.location.href='serv.php%20%20?menuParent=<?php echo $_SESSION['menuParenT']; ?>&clt='+value+'&table='+table+'&cv='+cv;
					   //if(!empty(value)) <?php  $_SESSION['clt']=value; ?> */
					   //document.getElementById('Nomclt').value=value;
					});
				}
			</script>

			<style type="text/css">
			/* Big box with list of options */
			#ajax_listOfOptions
			{
				position:absolute;	/* Never change this one */
				width:250px;	/* Width of box */
				height:100px;	/* Height of box */
				overflow:auto;	/* Scrolling features */
				border:1px solid #317082;	/* Dark green border */
				background-color:#FFF;	/* White background color */
				text-align:left;
				font-size:1.1em;
				z-index:100;
			}
			#ajax_listOfOptions div
			{	/* General rule for both .optionDiv and .optionDivSelected */
				margin:1px;
				padding:1px;
				cursor:pointer;
				font-size:0.9em;
			}
			#ajax_listOfOptions .optionDiv
			{	/* Div for each item in list */

			}
			#ajax_listOfOptions .optionDivSelected
			{ /* Selected item in the list */
				background-color:#317082;
				color:#FFF;
			}
			/*#ajax_listOfOptions_iframe
			{
				background-color:#F00;
				position:absolute;
				z-index:5;
			}*/

			form
			{
				display:inline;
			}
			input, select
			{
				border:1px solid ;
			}

			.bouton:hover
			{
				cursor:pointer;
			}
		</style>
	</head>
	<body bgcolor='azure' style="" >
<div class="">
			<form action="products.php?menuParent=<?php echo $_SESSION['menuParenT']; if(isset($_GET['ap'])) echo "&ap=".$_GET['ap'];?> " method="POST" name="formulaire">
			<table align='center'width="75%" <?php  if($NbrePrdts>=10) echo "height='550'"; else if($NbrePrdts>=8) echo "height='450'"; else echo "height='400'";; ?> border="0" cellpadding="0" cellspacing="0" id="tab">
	<?php
		if(!empty($_GET['delete'])){ $_SESSION['delete']=$_GET['delete'];
			echo "<script language='javascript'>";
			echo 'swal("Cette action est irréversible. Voulez-vous continuer ?", {
			  dangerMode: true, buttons: true,
			}).then((value) => { var Es = value;  document.location.href="products.php?menuParent='.$_SESSION['menuParenT'].'&test2="+Es;
			}); ';
			echo "</script>";
		} 
		if(!empty($_GET['test2'])&& ($_GET['test2']=='true')){
			
		} if(!empty($_GET['test2'])&& ($_GET['test2']=='null')){
			echo "<script language='javascript'>";
			echo 'alertify.error(" L\'opération a été annulée !");';
			echo "</script>";
		}
		
		if(!empty($_GET['aj'])){ $_SESSION['aj']=$_GET['aj'];
			echo "<script language='javascript'>";
			echo 'swal("Ajout d\'une nouvelle quantité de produit :", {
				  content: {
				  element: "input",
				  attributes: {
				  placeholder: "Sélectionnez ou saisissez un nombre dans le champ",
				  type: "number",
				  },
			      },
				  })
					.then((value) => {
					  document.location.href="products.php?menuParent='.$_SESSION['menuParenT'].'&qte="+value;
					}); ';
			echo "</script>";
		}

		if(!empty($_GET['qte'])){ $_SESSION['qte']=$_GET['qte'];
			echo "<script language='javascript'>";
			echo 'swal("Cette action est irréversible. Voulez-vous continuer ?", {
			  dangerMode: true, buttons: true,
			}).then((value) => { var Es = value;  document.location.href="products.php?menuParent='.$_SESSION['menuParenT'].'&test="+Es;
			}); ';
			echo "</script>";
		}  //https://sweetalert.js.org/docs/#configuration
		if(!empty($_GET['test'])&& ($_GET['test']=='true')){
			$rz="SELECT * FROM produits WHERE Num='".$_SESSION['aj']."' AND Type='".$_SESSION['menuParenT1']."'"; $req=mysqli_query($con,$rz);
			$data=mysqli_fetch_object($req);  $Qte_initial= $data->Qte_Stock; $Qte_Stock=$Qte_initial+$_SESSION['qte'];$update=$data->Num2 ;
		 	$rek="UPDATE produits SET Qte_Stock='".$Qte_Stock."',StockReel='".$Qte_Stock."' WHERE Num='".$_SESSION['aj']."' AND Type='".$_SESSION['menuParenT1']."'";
			$query = mysqli_query($con,$rek) or die (mysqli_error($con)); $ref="PRIN".$update ;  $service=" "; $designationOperation ='Mise à jour Produits';
			if($query){
			$re="INSERT INTO operation VALUES(NULL,'".$ref."','".$designationOperation."','".$update."','".$Qte_initial."','".$_SESSION['qte']."','".$Qte_Stock."','".$Jour_actuel."','".$Heure_actuelle."','','".$_SESSION['qte']."')";
			$req=mysqli_query($con,$re);
			echo "<script language='javascript'>";
			echo 'alertify.success(" Opération effectuée avec succès !");';
			echo "</script>";
			//echo '<meta http-equiv="refresh" content="1; url=produits.php?menuParent=Enrégistrement" />';
			}
			//unset($_SESSION['aj']);
		} if(!empty($_GET['test'])&& ($_GET['test']=='null')){
			echo "<script language='javascript'>";
			echo 'alertify.error(" L\'opération a été annulée !");';
			echo "</script>";
		}

		//}else{
			//if(isset($_POST['change'])) echo "<script language='javascript'> alert('Vous devez cocher un champ d'abord'); </script>";
			echo "	<tr>
						<td colspan='2'>
							<h2 style='text-align:center; font-family:Cambria;color:Maroon;font-weight:bold;'>";  if(isset($update)) echo "MISE A JOUR - DE PRODUIT"; else {  if(isset($ap)) echo "APPROVISIONNEMENT DE LA CUISINE"; else if($_SESSION['menuParenT1']=="Restauration") echo "PRODUITS ALIMENTAIRES"; else echo "ENREGISTREMENT - DES PRODUITS"; } echo "</h2>
						</td>
					</tr>

				<tr> <input type='hidden'  name='menuParenT' readonly value='".$_SESSION['menuParenT1']."'/>";
				if(isset($update)) echo "<input type='hidden'  name='update' readonly value='".$update."'/> ";

					echo "<td  style='padding-left:200px;' >N° d'enrég. : &nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
					<td ><input type='text' id='code' name='code' style='width:250px;' readonly value='".$nbre."' onkeyup='myFunction()'/> </td>

				</tr>";

				if($Famille==1)
				{	echo "<tr>
					<td  style='padding-left:200px;'>Catégorie :&nbsp;&nbsp;&nbsp;<span class='rouge' style='color:red;'>*</span></td>
					<td  style=''>";
				?>
				<input name='famille' type='hidden' id='famille'  <?php if(isset($_GET['nom'])) echo $_GET['nom']; ?> style='font-family:sans-serif;font-size:90%;width:250px;' required='required' onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)"
				onchange="ajax_showOptions(this,'getCountriesByLetters',event)" autocomplete='OFF' value='<?php if(isset($famille)) echo $famille; ?>'/>
				<select id='editable-select'  name='portion' style="background:#fff;font-family:sans-serif;font-size:100%;border:1px solid gray;width:250px;">
				<?php 
				$req="SELECT * FROM categorieproduit WHERE Type like '".$_SESSION['menuParenT1']."'";
				$reqki=mysqli_query($con,$req);
				while($dataPi = mysqli_fetch_object($reqki)){
					echo "<option value ='".$dataPi->Num."'>".$dataPi->catPrd."</option>";
				}
				?>
				</select>

				</td>
				<?php echo "</tr> ";	}
			echo "<tr>
				<td  style='padding-left:200px;'>Désignation  :&nbsp;&nbsp;&nbsp;<span class='rouge' style='color:red;'> *</span></td>
				<td ><input type='text' id='' name='designation' style='width:250px;font-family:sans-serif;font-size:90%;' required='required' onKeyup='ucfirst(this)' value='"; if(isset($designation)) echo $designation;  echo "'/></td>
			</tr>";
			echo "<tr>
				<td  style='padding-left:200px;'>Type de produit  :&nbsp;&nbsp;&nbsp;<span class='rouge' style='color:red;'> *</span></td>
				<td >
				<select name='TypePrdts' required='required' style='font-family:sans-serif;font-size:90%;width:250px;border:1px solid gray;'>";
				if(isset($TypeP))echo "<option value='".$TypeP."'>".$TypeP."</option>";
				echo "<option></option>
				<option value='1'> Vendable </option>
				<option></option>
				<option value='2'> Non Vendable </option>
				</select>
				</td>
			</tr>";

			if($UnitStockage==1)
				{	echo "<tr>
				<td style='padding-left:200px;'>Unité de Stockage :&nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
				<td  style=''><select name='UniteStockage' style='font-family:sans-serif;font-size:90%;width:250px;border:1px solid gray;'>";

		        if(isset($UniteStockage))  echo "<option value='".$UniteStockage."'>".$UniteStockage." </option>"; else echo "<option value=''> </option>";
				$req = mysqli_query($con,"SELECT * FROM UniteStockage") or die (mysqli_error($con));
				while($data=mysqli_fetch_array($req))
				{
					echo" <option value ='".$data['catPrd']."'> ".ucfirst($data['catPrd'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
					<option></option> ";
				}
			echo "</select><a class='info' href='' style='color:#B83A1B;' onclick='JSalert();return false;' ><span style='font-size:0.8em;font-style:normal;'>Ajouter une nouvelle Unité</span>	 <i class='fa fa-plus-square' aria-hidden='true'></i></a>
				</td></tr>";
				}
			if($PoidsNet1==1)
				{	echo "<tr>
					<td  style='padding-left:200px;'>Poids Net :&nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
					<td ><input type='text' id='' name='Poids' style='width:250px;font-family:sans-serif;font-size:90%;'  onkeypress='testChiffres(event);' value='"; if(isset($PoidsNet)) echo $PoidsNet;  echo "'/></td>
					</tr>";
				}
			if($DatePeremption==1)
				{	echo "<tr>
					<td  style='padding-left:200px;'>Date de péremption :&nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
					<td><input type='date' id='' name='dateP' style='width:250px;border:1px solid gray;font-family:sans-serif;font-size:90%;'  value='";
					if(isset($dateP)) echo $dateP;  echo "'/></td>
					</tr>";
				}
			if($StockAlerte==1)
				{echo "<tr>
					<td  style='padding-left:200px;'>Stock d'alerte | critique :&nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
					<td ><input type='text' id='' name='Seuil' style='width:250px;font-family:sans-serif;font-size:90%;'  onkeypress='testChiffres(event);' value='";
					if(isset($Seuil)) echo $Seuil;  echo "'/></td>
					</tr>";
				}
			if($DateService==1)
				{	echo "<tr>
					<td  style='padding-left:200px;'>Date de mise en Service :&nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
					<td><input type='date' id='' name='dateS' style='border:1px solid gray;width:250px;font-family:sans-serif;font-size:90%;'  value='";
					if(isset($dateS)) echo $dateS;  echo "'/></td>
					</tr>";
				}
			if($Fournisseur1==1)
				{	echo "<tr>
				<td  style='padding-left:200px;'>Fournisseur :&nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
				<td >";
		/* 		if(isset($Fournisseur)){
					echo "<input type='text' id='' name='frs' style='width:250px;' value='".$Fournisseur."' readonly/>";
				}
				else{ */
				echo "<select name='Fournisseur' style='font-family:sans-serif;font-size:90%;width:250px;border:1px solid gray;' ";
		        //if(isset($RaisonSociale))  echo "<option value='".$RaisonSociale."'>".$RaisonSociale." </option>"; else echo "<option value=''> </option>";
				echo "<option value=''> </option>";
				$req = mysqli_query($con,"SELECT * FROM fournisseurs") or die (mysqli_error($con));	//$t=0;
				while($data=mysqli_fetch_array($req))
				{    //$t++; if($t==1)
					if(isset($Fournisseur)) echo "<option value='".$Fournisseur."'>".$Fournisseur."</option>"; else echo "<option value=''> </option>";
					echo" <option value ='".$data['RaisonSociale']."'> ".ucfirst($data['RaisonSociale'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option> ";
				}
				echo "</select>
				<a class='info' href='' style='color:#4C433B;' onclick='fournisseurs();return false;'><span style='font-size:0.8em;font-style:normal;'>Ajouter un nouveau fournisseur</span>	 <i class='fa fa-plus-square' aria-hidden='true'></i></a>";
				//}

				echo "</td>	</tr>";
				}
			if($PrixFournisseur1==1) {echo "<tr>
				<td  style='padding-left:200px;'>Prix Fournisseur :&nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
				<td ><input type='text' id='' name='Prix' style='width:250px;' value='"; if(isset($PrixFrs)) echo $PrixFrs;  echo "' onkeypress='testChiffres(event);' placeholder='"; if(isset($devise)) echo $devise; echo " '/></td>
			</tr>";
			}
			if($PrixVente==1) {echo "<tr>
				<td  style='padding-left:200px;'>Prix de vente | Cession :&nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
				<td ><input type='text' id='' name='PrixV' style='width:250px;font-family:sans-serif;font-size:90%;' value='"; if(isset($PrixV)) echo $PrixV;  echo "' onkeypress='testChiffres(event);' placeholder='"; if(isset($devise)) echo $devise; echo " '/></td>
			</tr>";
			}
/* 			if(isset($update)){
			 echo "<tr>
					<td  style='padding-left:200px;'>Quantité en Stock :&nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
					<td ><input type='text' id='' value='"; if(isset($Qte_Stock)) echo $Qte_Stock;  echo "' name='qte' style='width:50px;' readonly='readonly' onkeypress='testChiffres(event);'/>
					&nbsp;&nbsp;Qté à Ajouter : &nbsp;
					<input type='number' id='' name='QteAj' style='width:75px;border:1px;font-family:sans-serif;font-size:90%;' min='0' max=''/>
					</td>
				</tr>";
			} */
			if(isset($ap)){ $StockCuisine=isset($StockCuisine)?$StockCuisine:0;
			 echo "<tr>
					<td  style='padding-left:200px;'>Stock actuel de la cuisine :&nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
					<td ><input type='text' id='' value='".$StockCuisine."' name='qte' style='width:50px;font-family:sans-serif;font-size:90%;' readonly='readonly' onkeypress='testChiffres(event);'/>
					&nbsp;&nbsp;&nbsp;&nbsp;Qté à affecter : &nbsp;
					<input type='number' id='' name='QteAf' style='width:75px;' min='0' max=''/>
					</td>
				</tr>";
			}
			echo "<tr>
			<td colspan='4' align='center' ><br/><input type='submit' value='"; if(isset($update)) echo "Modifier"; else if(isset($ap)) echo "Approvisionner"; else  echo "Enrégistrer";
			echo "' id='' class='bouton2'  name='"; //if(isset($ap)) echo "Enregistrer"; else
			echo "ENREGISTRER"; echo "' style=''/>
			&nbsp;&nbsp;<input type='reset' value='Annuler' id='' class='bouton2'  name='ANNULER' style=''/> <br/>&nbsp;</td>
		</tr>";
		//}
	?>
		</form>
		</table>
<br/>


<div class="table-responsive">
	<table id="dataTable"  align='center' width='100%' border='0' cellspacing='1' style='margin-top:0px;border-collapse: collapse;font-family:Cambria;'>
<thead>
<tr><td colspan='6' > <span style="float:left;font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#4C767A;" >Liste des produits <?php  if($_SESSION['menuParenT1']=="Restauration") echo "alimentaires"; ?>  </span>

</td></tr>
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
	$res=mysqli_query($con,"SELECT * FROM produits WHERE Type='".$_SESSION['menuParenT1']."' ");
	$nbre1=mysqli_num_rows($res);

 ?>
</span>

		<tr  style='background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;'>
			<td rowspan='2' style="border: 1px solid #ffffff" align="center" >&nbsp;N° d'Enrég.<span style='font-size:0.8em;'></span></td>
			<?php if($Famille==1)  { ?> <td rowspan='2' style="border: 1px solid #ffffff" align="center" >&nbsp;Famille<span style='font-size:0.8em;'></span></td> <?php } ?>
			<td rowspan='2' style="border: 1px solid #ffffff" align="center" >&nbsp;Désignation<span style='font-size:0.8em;'></span></td>
			<?php if($UnitStockage==1)  { ?> <td rowspan='2' style="border: 1px solid #ffffff" align="center" >&nbsp;Unité de<br/> Stockage<span style='font-size:0.8em;'></span></td><?php } ?>
			<?php if($PoidsNet1==1)  { ?> <td rowspan='2' style="border: 1px solid #ffffff" align="center" >&nbsp;Poids<br/> Net<span style='font-size:0.8em;'></span></td><?php } ?>
			<td rowspan='2' style="border: 1px solid #ffffff" align="center" >&nbsp;Qté en <br/>Stock<span style='font-size:0.8em;'></span></td>
			<td rowspan='2' style="border: 1px solid #ffffff" align="center" >✔</td>
			<?php if($StockAlerte==1)  { ?> <td rowspan='2' style="border: 1px solid #ffffff" align="center" >&nbsp;Seuil&nbsp;<span style='font-size:0.8em;'></span></td><?php } ?>
			<?php if($DatePeremption==1)  { ?>
			<td colspan='<?php  $sum=$DatePeremption+$DateService; if($sum==2)  echo 2; else echo 1; ?>' style="border: 1px solid #ffffff;" align="center" >
			&nbsp;Date de <span style='font-size:0.8em;'></span>
			</td>
			<?php } ?>
			<?php if($PrixFournisseur1==1)  { ?> <td rowspan='2' style="border: 1px solid #ffffff" align="center" >&nbsp;Prix de <br/>Livraison<span style='font-size:0.8em;'></span></td><?php } ?>
			<?php if($PrixVente==1)  { ?> <td rowspan='2' style="border: 1px solid #ffffff" align="center" >&nbsp;Prix de<br/> Vente<span style='font-size:0.8em;'></span></td><?php } ?>
			<td rowspan='2' style="border: 1px solid #ffffff" align="center" align="center" >Actions</td>
		</tr>
		<tr  style='background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;'>
			<?php if($DatePeremption==1)  { ?>
			<td style="border: 1px solid #ffffff" align="center" >
			&nbsp;Péremption<span style='font-size:0.8em;'></span>
			</td>
			<?php }
			if($DateService==1) {
			?>
			<td style="border: 1px solid #ffffff" align="center" >
			&nbsp;Mise en Service<span style='font-size:0.8em;'></span>
			</td>
			<?php
			}
			?>
		</tr>
</thead>
<tbody id="">
<?php
	mysqli_query($con,"SET NAMES 'utf8'");
	$query="SELECT * FROM produits,categorieproduit WHERE categorieproduit.catPrd = produits.Famille AND produits.Type='".$_SESSION['menuParenT1']."' ";
	$result=mysqli_query($con,$query);
	$cpteur=1;
    // parcours et affichage des résultats
    while( $data = mysqli_fetch_object($result))
    {
		if($cpteur == 1)
			{
				$cpteur = 0;
				$bgcouleur = "#DDEEDD"; $color = "#FC7F3C";
			}
			else
			{
				$cpteur = 1;
				$bgcouleur = "#dfeef3";$color = "#FC7F3C";
			}
	$nbre=$data->Num2;
	if(($nbre>=0)&&($nbre<=9)) $nbre="0000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="000".$nbre ;else $nbre="00".$nbre ;
    ?>
		 	<tr class='rouge1' bgcolor=' <?php echo $bgcouleur; ?>'>
				 <td align="center" style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $nbre;  ?> </td>
				<?php if($Famille==1)  { ?>  <td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $data->Famille; ?> </td> <?php } ?>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->Designation; ?></td>
				<?php if($UnitStockage==1)  { ?> <td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $data->UniteStockage; ?></td><?php } ?>
				<?php if($PoidsNet1==1)  { ?> <td align="center"  style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->PoidsNet; ?></td><?php } ?>
				 <td align="right"  style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->Qte_Stock; 				 
				 echo "&nbsp;&nbsp;<a class='info2' href='products.php?menuParent=".$_SESSION['menuParenT']."&aj=".$data->Num."' style='color:".$color."'><i class='fa fa-plus-square'></i><span style='color:green;font-size:1em;'>Augmenter la quantité <br/>de <g style='color:red;'>".$data->Designation."</g></span></a>";
				 ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<?php echo "<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>";
				if($_SESSION['module']=="RESTAURATION")
					echo "<a class='info' href='products.php?menuParent=".$_SESSION['menuParenT']."&ap=".$data->Num."'  style='color:red;'>
							<img title='' src='logo/resto/11.png' width='25' height='25' style=''/>
							<span style='color:green;'>Approvisionner<br/> la Cuisine en <g style='color:red;'>".$data->Designation."</g></span> </a>";
				echo "</td>";
				?>
				<?php if($StockAlerte==1)  { ?> <td align="center" style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->Seuil; ?></td><?php } ?>
				<?php if($DatePeremption==1)  { ?> <td align="center" style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo substr($data->datePeremption,8,2).'-'.substr($data->datePeremption,5,2).'-'.substr($data->datePeremption,0,4); ?></td><?php } ?>
				<?php if($DateService==1)  { ?> <td align="center" style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo substr($data->DateService,8,2).'-'.substr($data->DateService,5,2).'-'.substr($data->DateService,0,4); ?></td><?php } ?>
				<?php if($PrixFournisseur1==1)  { ?> <td align="center" style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->PrixFrs; ?></td><?php } ?>
				<?php if($PrixVente==1)  { ?> <td align="center" style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->PrixV; ?></td><?php } ?>

				<?php
				echo "<td align='center' style=''>
				 &nbsp;<a class='info2' href='products.php?menuParent=".$_SESSION['menuParenT']."&update=".$data->Num."'  style='color:#FC7F3C;'><img src='logo/b_edit.png' alt='' width='16' height='16' border='0'><span style='color:#FC7F3C;font-size:0.9em;'>Modifier</span></a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;<a class='info2' href='products.php?menuParent=".$_SESSION['menuParenT']."&delete=".$data->Num."'  style='color:#B83A1B;'><img src='logo/b_drop.png' alt='Supprimer' width='16' height='16' border='0'><span style='color:#B83A1B;font-size:0.9em;'>Supprimer</span></a>
				</td></tr>";
	}
	?>			
			</tbody>
		<tfoot></tfoot>
	</table>
</div>
</div>
				<script src="js/editableSelect/jquery-1.12.4.min.js"></script>
		<script src="js/editableSelect/jquery-editable-select.min.js"></script>
		<script src="js/editableSelect/script.js"></script>
		
		<script src="js/datatables/jquery.dataTables.js"></script>
        <script src="js/datatables/dataTables.bootstrap4.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.min.js"></script>
        <!-- Custom scripts for this page-->
        <script src="js/sb-admin-datatables.min.js"></script>
        <script src="js/sb-admin-charts.min.js"></script>
        <script src="js/custom.js"></script>
		
	</body>
</html>
<?php
	// $Recordset1->Close();
?>