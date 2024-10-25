<?php
include_once 'menu.php';  
require ('vendor/autoload.php');

use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorPNG;

//if(isset($_SESSION['quantify'])) echo $_SESSION['quantify'];
// https://www.youtube.com/watch?v=xYc4AO_wQgM
//https://sweetalert.js.org/docs/#content
	$reqsel=mysqli_query($con,"SELECT * FROM RTables WHERE status=0");
	$Nbre=mysqli_num_rows($reqsel);   

		$fd=!empty($_GET['fd'])?$_GET['fd']:NULL; $fk=!empty($_GET['fk'])?$_GET['fk']:NULL;$Qte=!empty($_GET['Qte'])?$_GET['Qte']:0;$desactiveT=0;
		 $fd; $tk=!empty($_GET['tk'])?$_GET['tk']:NULL;   $serv = !empty($_GET['serv'])?$_GET['serv']:NULL; $tab = !empty($_GET['tab'])?$_GET['tab']:NULL;

/* 		$nomclt=!empty($_GET['nomclt'])?$_GET['nomclt']:NULL;
		if(empty($nomclt))
		$nomclt=!empty($_GET['rsociale'])?$_GET['rsociale']:NULL;
		if(isset($nomclt)&&(!empty($nomclt)))
		{  
			if(!empty($_GET['nomclt']))
				$req="SELECT * FROM clientresto WHERE (nomclt='".$nomclt."' AND prenomclt='".$_GET['prenoms']."')";
		   else 
			    $req="SELECT * FROM clientresto WHERE entrepriseName='".$_GET['rsociale']."' OR numIFU='".$_GET['ifu']."'";
		   $mQuery=mysqli_query($con,$req);
		   $data=mysqli_fetch_object($mQuery); 
		   if(mysqli_num_rows($mQuery)>0)
		   {	echo "<script language='javascript'>";
				echo 'alertify.error("Ce client existe déjà");';
				echo "</script>";
		   }else {

	       $Query="INSERT INTO clientresto SET nomclt='".$nomclt."',prenomclt ='".$_GET['prenoms']."',numIFU ='".$_GET['ifu']."',entrepriseName='".$_GET['rsociale']."',adresseclt ='".$_GET['adresse']."', Telclt ='".$_GET['telephone']."'";
		   $exec=mysqli_query($con,$Query);
			 if(isset($exec)){
				 echo "<script language='javascript'>";
				 echo 'alertify.success(" Le client a été enregistré avec succès");';
				 echo "</script>";					 
				}
		}
		} */
				
		$table = !empty($_GET['table'])?$_GET['table']:0;
		$cv = !empty($_GET['cv'])?$_GET['cv']:0;
		$reqselRTables=mysqli_query($con,"SELECT * FROM tableEnCours WHERE numTable='".$table."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'");
			if($reqselRTables){ unset($del); unset($val); unset($vt);
/* 				echo "<script language='javascript'>";
				echo 'alertify.success(" La commande a été validée !");';
				echo "</script>";	 */
				}
		
		$client=!empty($_GET['client'])?$_GET['client']:NULL;
		if(isset($client)&&(!empty($client)))
		{	$client = explode("(",$client); $client = explode(")",$client[1]); $table=(int)($table);
	 		$Query="UPDATE tableEnCours SET client ='".$client[0]."' WHERE numTable='".$table."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'";
			 $exec=mysqli_query($con,$Query);
		}
		$mode=!empty($_GET['mode'])?$_GET['mode']:NULL; 
		if(isset($mode)&&(!empty($mode))&&(!is_null($mode))&&($mode!='null'))
		{	$table=(int)($table);
	 		$Query="UPDATE tableEnCours SET modeReglement ='".$mode."' WHERE numTable='".$table."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'";
			$exec=mysqli_query($con,$Query);
		}

	$vt = !empty($_GET['vt'])?$_GET['vt']:NULL;  $val = !empty($_GET['val'])?$_GET['val']:NULL; if(empty($val)) { if(!isset($_GET['del'])) unset($_SESSION['Ntable']); unset($_SESSION['cv']);}
	$del = !empty($_GET['del'])?$_GET['del']:NULL;

	if (!empty($del))
		{  $mQuery=mysqli_query($con,"SELECT max(Num) AS Num FROM tableEnCours WHERE numTable='".$table."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'");
		   $data=mysqli_fetch_object($mQuery); $max=$data->Num;
		   if(empty($max))
		   {	echo "<script language='javascript'>";
				echo 'alertify.error(" Aucune Ligne à supprimer");';
				echo "</script>";
		   }else {  //$pre_sql1="DELETE FROM tableEnCours WHERE num='$max' AND Etat<> 'Desactive'";
		   //$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
		   $reqsel=mysqli_query($con,"SELECT * FROM RTables WHERE status=0 AND nomTable='".$table."'");
		   $data=mysqli_fetch_assoc($reqsel);$cv=$data['NbreCV'];
		   $reqselRTables=mysqli_query($con,"SELECT * FROM tableEnCours WHERE status=0 numTable='".$table."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'");
		   		//if($req1){
				//echo "<script language='javascript'>";
				//echo 'alertify.success(" Ligne supprimée avec succès !");';
				//echo "</script>";	}
		   }
		   //echo '<meta http-equiv="refresh" content="2; url=servir.php" />';
		}


/* 			$reqsel2=mysqli_query($con,"SELECT DISTINCT numTable FROM tableEnCours");
			$Ttable=array();$i=0;
			while($data1=mysqli_fetch_array($reqsel2)){
				 echo $Ttable[$i]=$data1['numTable']; $i++;
			} */
		$reqTable=mysqli_query($con,"SELECT * FROM RTables WHERE NbreCV<>0"); $j=0;
		while($dataT=mysqli_fetch_object($reqTable)){	$j++;	
		$i=$dataT->nomTable ;  
		//for($i=1;$i<=$Nbre;$i++){
			if (isset($_POST['table']) and $_POST['table']==$i)
				{ if($i<10) $table="0".$i; else $table=$i;
					$reqsel=mysqli_query($con,"SELECT * FROM RTables WHERE status=0 AND nomTable='".$i."'");
					if(mysqli_num_rows($reqsel)>0){
					$_SESSION['Ntable']=$i;
					$data=mysqli_fetch_assoc($reqsel);$cv=$data['NbreCV'];$_SESSION['cv']=$cv;
					$req="SELECT * FROM tableEnCours WHERE numTable='".$i."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'";
					$reqselRTables=mysqli_query($con,$req);	$desactiveT=0;
					}else { $desactiveT=1;
						echo "<script language='javascript'>";
						echo 'alertify.error("Désolé ! Cette table est désactivée.");';
						echo "</script>";		
					}
				}
}
			if (isset($_POST['Valider']))
			{  //if(isset($_POST['MontantP'])) echo $_POST['MontantP'] ; echo 12;
			}
			$_SESSION['table'] = $table;

?>
<html>
	<head>
		<link href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		
		<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> !-->
		<link rel="stylesheet" href="js/bootstrap2.min.css">
		<script src="js/bootstrap2.bundle.min.js"></script>

			
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script src="js/sweetalert.min.js"></script>	
		<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> !-->
		<script src="js/sweetalert2.min.js"></script>

		<style>
		.alertify-log-custom {
				background: blue;
			}
		#lien1:hover {
			text-decoration:underline;background-color: #046380;font-size:1.1em;
		}
		#lien1:hover {
			text-decoration:underline;background-color: #046380;font-size:1.1em;
		}
		.bouton5 {
		border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;background: #00734F; 

		border:none;
		color:#fff;
		font:bold 12px Verdana;
		padding:6px ;font-family:cambria;font-size:0.9em;
		}
		.bouton5:hover{
		cursor:pointer;color: black;
		}
		.bouton2 {
			border-radius:12px 0 12px 0;
			background: #d34836;
			border:none;
			color:#fff;
			font:bold 12px Verdana;
			padding:6px ;font-family:cambria;font-size:0.9em;
		}
		.bouton2:hover{
			cursor:pointer;background-color: #000000;
		}
		#test:hover{
			color:black;
		}


		 .button {
		  background-color: blue;
		  border: none;
		  color: white;font-weight:bold;
		  padding-left: 10px; padding-right: 10px;  padding-top: 2px; padding-bottom: 0px;
		  text-align: center;
		  text-decoration: none;
		  display: inline-block;
		  font-size: 25px;
		  margin: 4px 2px;cursor: pointer;
		}

		.button5 {border-radius: 50%;}

		 .buttonT {
		  background-color: red;
		  border: none;
		  color: white;font-weight:bold;
		  padding: 0px;
		  text-align: center;
		  text-decoration: none;
		  display: inline-block;
		  font-size: 25px;
		  margin: 4px 2px;cursor: pointer;
		}

		 .button7 {
		  background-color: orange;
		  border: none;
		  color: white;font-weight:bold;
		  text-align: center;
		  text-decoration: none;display: inline-block;
		  font-size: 22px;
		  padding-left:2px;padding-right:2px;
		  margin: 0px 0px;cursor: pointer;
		}
		.button6 {border-radius: 40%;}

		#full  {-webkit-transition: all 1s ease; /* Safari and Chrome */
			-moz-transition: all 1s ease; /* Firefox */
			-ms-transition: all 1s ease; /* IE 9 */
			-o-transition: all 1s ease; /* Opera */
			transition: all 1s ease;}
		#full:hover{   -webkit-transform:scale(1.25); /* Safari and Chrome */
			-moz-transform:scale(1.25); /* Firefox */
			-ms-transform:scale(1.25); /* IE 9 */
			-o-transform:scale(1.25); /* Opera */
			 transform:scale(1.25);}
			 
	/* Styles du ticket */
        .ticket {
            width: 400px;
            padding: 25px;
            background: linear-gradient(135deg, #ffffff, #f7f7f7);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: calibri;
            color: #333;
            margin: 20px auto;
			
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .header h5 {
            margin: 0;
            color: #2c3e50;
        }

        .header p {
            margin: 0px 0;
            color: #7f8c8d;
			font-size:0.9em;
        }

        .content table {
            width: 100%;
        }

        .content td {
            padding: 1px 5px;
            border-bottom: 1px solid #ddd;
        }

        .total {
            text-align: right;
            font-weight: bold;
            font-size: 16px;
        }

        .footerT {
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        .footerT img {
            margin-top: 15px;
            width: 80px;
        }
		
		
	.watermark {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-45deg);
    font-size: 5em;
    color: rgba(0, 0, 0, 0.1); /* Couleur semi-transparente */
    z-index: 0; /* Assurez-vous qu'il ne recouvre pas le contenu */
    white-space: nowrap;
    pointer-events: none; /* Évite que le texte interfère avec la sélection de contenu */
	}
	.ticket {
		position: relative; /* Pour que le filigrane se base sur le ticket */
		z-index: 1; /* Met le contenu du ticket au-dessus du filigrane */
	}
		
	 /* Impression */
	@media print {
		body * {
			visibility: hidden;
		}

		#printable-ticket, #printable-ticket * {
			visibility: visible;
		}

		#printable-ticket {
			position: absolute;
			left: 0;
			top: 0;
		}
	  .info {
		margin-bottom: 10px;
	}
		</style>
			<script type="text/javascript" >
				function edition1() { options = "Width=800,Height=450" ; window.open( "tableP.php", "edition", options ) ; }
				function edition2() { options = "Width=800,Height=400" ; window.open( "ServP.php", "edition", options ) ; }
				//function edition3() { options = "Width=800,Height=450" ; window.open( "receipt2.php", "edition", options ) ; }
				function edition4() { options = "Width=800,Height=450" ; window.open( "frameFood.php", "edition", options ) ; }
				function edition9() { options = "Width=800,Height=450" ; window.open( "framePFood.php", "edition", options ) ; }
				function edition5() { options = "Width=800,Height=450" ; window.open( "frameDrink.php", "edition", options ) ; }
				function edition8() { options = "Width=800,Height=450" ; window.open( "framePDrink.php", "edition", options ) ; }
				function edition6(param0=0) { options = "Width=auto,Height=auto" ; window.open( "receipt2.php?param0=" + encodeURIComponent(param0), "edition", options ) ; }
				//function edition7() { options = "Width=600,Height=300" ; window.open( "tableS.php", "edition", options ) ; }
				function Alert() {
					alertify.error(" Choississez d'abord la formule de vente à appliquer!");
				}
				function Alert1() {
					alertify.error(" Valider d'abord la Commande!");
				}
				function Alert2() {
					alertify.error(" Aucune donnée à imprimer!");
				}
				function remiseR() {//alert("hjjjd");
					if(document.getElementById('remise').value!=""){
						rem.innerHTML = parseInt(document.getElementById("total").value)-parseInt(document.getElementById('remise').value);
						document.getElementById('m').value=parseInt(document.getElementById("total").value)-parseInt(document.getElementById('remise').value);
						document.getElementById('remise').style.backgroundColor='#F3F39F';
						document.getElementById('remise').style.fontWeight='bold'; }
				}
				function monnaie() {
					if(document.getElementById('remise').value=="") {document.getElementById('remise').value=0;
					rem.innerHTML =parseInt(document.getElementById("total").value)-parseInt(document.getElementById('remise').value);}

						var it= parseInt(document.getElementById("total").value)-parseInt(document.getElementById('remise').value);

					  if(document.getElementById("Mtpercu").value>= it)
						  var Rx=parseInt(document.getElementById("Mtpercu").value) - it;
					  else
						  var Rx=0;
						mon.innerHTML = Rx;
						document.getElementById('Mtpercu').style.backgroundColor='#F3F39F';
						document.getElementById('Mtpercu').style.fontWeight='bold';

					document.getElementById('m').value=parseInt(document.getElementById("total").value)-parseInt(document.getElementById('remise').value);

				}

		/* 		function JSalert(){
					swal("Entrez ici le Nom du Client :", {
					  content: "input",
					})
					.then((value) => {

					  document.getElementById('Nomclt').value=value;   var table = document.getElementById('NameTable').value;  var cv = document.getElementById('cv').value;
					  document.location.href='servir.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&clt='+value+'&table='+table+'&cv='+cv;
					});
				} */
				

	</script>
	</head>
	<body bgcolor='azure' style="" > 
		<div class="container">
		<div style='margin-left:0%;float:left;'>
		<form action='' method='post'>
		<?php
		$printf=0;
		echo "<span style='display:block;font-weight:bold;font-size:135%;color:maroon;font-family:cambria;'>Liste des tables du Restaurant&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		
		echo "<span style='font-size:0.8em;color:#006D80;float:right;'>";
		
		if(!empty($_GET['p'])){ $_SESSION['p']=$_GET['p'];
			echo "<script language='javascript'>";
			echo 'swal("Vous êtes sur le point de retirer votre serveur(se) de la table. Voulez-vous continuer ?", {
			  dangerMode: true, buttons: true,
			}).then((value) => { var Es = value;  document.location.href="servir.php?menuParent='.$_SESSION['menuParenT'].'&test="+Es;
			}); ';
			echo "</script>";
		}  //https://sweetalert.js.org/docs/#configuration
		if(!empty($_GET['test'])&& ($_GET['test']=='true')){
			//echo $_SESSION['p'];
/* 			$rz="SELECT * FROM produits WHERE Num='".$_SESSION['aj']."' AND Type='".$_SESSION['menuParenT1']."'"; $req=mysqli_query($con,$rz);
			$data=mysqli_fetch_object($req);  $Qte_initial= $data->Qte_Stock; $Qte_Stock=$Qte_initial+$_SESSION['qte'];$update=$data->Num2 ;
		 	$rek="UPDATE produits SET Qte_Stock='".$Qte_Stock."',StockReel='".$Qte_Stock."' WHERE Num='".$_SESSION['aj']."' AND Type='".$_SESSION['menuParenT1']."'";
			$query = mysqli_query($con,$rek) or die (mysqli_error($con)); $ref="PRIN".$update ;  $service=" "; $designationOperation ='Mise à jour Produits';
			if($query){
			$re="INSERT INTO operation VALUES(NULL,'".$ref."','".$designationOperation."','".$update."','".$Qte_initial."','".$_SESSION['qte']."','".$Qte_Stock."','".$Jour_actuel."','".$Heure_actuelle."','','".$_SESSION['qte']."')";
			$req=mysqli_query($con,$re);
			echo "<script language='javascript'>";
			echo 'alertify.success(" Opération effectuée avec succès !");';
			echo "</script>"; */
		} 
		echo "<a href='servir.php?menuParent=".$_SESSION['menuParenT']."&tab=1&trie=1' style='text-decoration:none;font-size:1.1em;' class='info2'>
		<img src='logo/Resto/circle.png' alt='' width='30' height='25' border='1'><span style='color:#ff103c;font-weight:bold;font-size:75%;'>Trier les tables</span></a>";
		echo "</span>";	
		echo "<a class='info' href='#' style='' onclick='JSalert();return false;'><i class='fas fa-user-plus' style='color:red'></i>
		<span style='color:#ff103c;font-weight:bold;font-size:75%;'>Nouveau client</span></a>";	
							
		echo '<br/>';
			include('listingTable.php');
		echo "</form>";
		
		 if($printf==1)  {
 				echo "<br/><br/>";
			/*	echo "&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<a href='servir.php?menuParent=".$_SESSION['menuParenT']."&serv=1' style='text-decoration:none;font-size:1.1em;'>
			<span style='color:#ff103c;font-weight:bold;font-size:75%;'>Serveurs -> Tables</span></a> &nbsp;|<a href='servir.php?menuParent=".$_SESSION['menuParenT']."&tab=1&trie=1' style='text-decoration:none;font-size:1.1em;'>
			<span style='color:#ff103c;font-weight:bold;font-size:75%;'>Trier les tables</span></a>"; */
			}
		?>	
		</div>
		<div style='margin-top:0%;width:auto;float:right;'><span style='font-weight:bold;font-size:135%;color:maroon;font-family:cambria;float:left;display:inline;'>
		<?php if((empty($table))&&(empty($vt))) echo "<a href='servir.php?menuParent=".$_SESSION['menuParenT']."&vt=1&tk=1'   id='lien1' style='text-decoration:none;'></a>";
		else if((empty($table))&&(!empty($vt))) echo "<span style='color:#444739;font-weight:bold;'>Formule de vente : Takeaway</span>";
		else if(!empty($table)) {echo "<span style='color:#444739;font-weight:bold;'>Formule de vente : Occupation d'une table</span>"; }  else {}

	 		echo "</span>"; if((empty($table))&&(empty($vt))) echo "<span style='float:left;font-weight:bold;'></span>
			<span style='float:right;font-weight:bold;'><a href='servir.php?menuParent=".$_SESSION['menuParenT']."&vt=1&tk=1' id='lien1' class='info2' style='color:red;text-decoration:none;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'>
			<span style='font-size:0.8em;'>Takeaway</span> <img src='logo/Resto/take-away.png' alt='' width='40' height='45' border='1' style='position:relative;margin-top:-14px;background: white;z-index:1;'></a> </span>";
		?>
		<h2 style='font-size:1.1em;color:maroon;font-family:cambria;'>&nbsp;&nbsp;  </h2>

				<?php if(((!empty($table))||(!empty($vt))||(!empty($tk)))&& ($desactiveT==0))
					{include('serv.php');
					}
					else if(isset($_GET['print'])){
						include('receiptH.php');
					}
					else
						{ //echo "<br/>";
							echo "<img title='' src='logo/1/".rand(1,3).".jpg' width='500' height='340' style='max-width:500px;border:3px solid white;'/>	";
						}

		$req="SELECT DISTINCT tableEnCours.num_facture as num_facture,heure_emission,montant_ttc,NomClient,factureResto.numTable,factureResto.id AS id FROM tableEnCours,factureResto WHERE factureResto.num_facture=tableEnCours.num_facture AND created_at='".$Jour_actuel."' AND Etat LIKE 'Desactive' AND factureResto.num_facture<>'' ORDER BY factureResto.id DESC LIMIT 5";
		$reqsel2=mysqli_query($con,$req);
		if(mysqli_num_rows($reqsel2)>0) {
				?>
				<hr/>
				<h5>LISTE DES DERNIERES FACTURES EMISES</h5><span style='float:right;margin-top:-20px;'><?=$Date_actuel2 ?></span>
				<hr/>
				<table class='rouge1' style='width:500px;border:2px solid gray;background-color:#F4FEFE;font-family:Calibri;font-size:1em;'>
		 
    <thead>
      <tr style='background-color:#DCDCDC;border:1px solid gray;'>
        <th align="left">NUMERO</th>
		<th align="left">&nbsp;HEURE</th>
		<th style="text-align: left;">CLIENT</th>
		<th style="text-align: left;">Table</th>
        <th style="text-align: center;">TOTAL </th>
		<th style="text-align: right;">IMPRIMER</th>
		
      </tr>
    </thead>

    <tbody id="tablbody">
<?php   $cpteur=1;
		while($data=mysqli_fetch_array($reqsel2)){
			if($cpteur == 1)
			{
				$cpteur = 0;
				$bgcouleur = "white";$color = "#FC7F3C";
			}
			else
			{
				$cpteur = 1;
				$bgcouleur = "#dfeef3";$color = "red"; 
			}
		  $i=$data['numTable']; if($i<10) $table="0".$i; else $table=$i;
		  echo "<tr class='rouge1' bgcolor='".$bgcouleur."' style='border:1px solid gray;'>
			<td align='left' style='color:maroon;'>&nbsp;&nbsp;&nbsp;".$data['num_facture']."</td>
			<td align='left'>".$data['heure_emission']."</td>
			<td style='text-align: left;'> "; echo $client=!empty($data['NomClient'])?substr($data['NomClient'],0,75):"#Non renseigné#"; echo"</td>
			<td style='text-align: center;'>"; echo $table=($table!="00")?substr($table,0,35):"-"; echo"</td>
			<td style='text-align: right;color:maroon;'>".$data['montant_ttc']."</td>
			 <td style='text-align:right;'>";
			 //echo "<a class='info2' href='servir.php?print=1' onclick='edition6(".$data['id'].");return false;'> <span style='font-size:0.9em;font-style:normal;color:black;'>Impression</span>	 <i class='fas fa-print' style='color:".$color."' aria-hidden='true' style='font-size:100%;'></i></a>";
			//echo "<a href='#' class='info2' id='ticketLink-".$data['id']."' data-bs-toggle='modal' data-bs-target='#ticketModal' data-ticket-id='".$data['id']."'><span style='font-size:0.9em;font-style:normal;color:black;'>Impression</span>	 <i class='fas fa-print' style='color:".$color."' aria-hidden='true' style='font-size:100%;'></i></a>";
		?>  
		<a href='' class='info' class='quickview' data-link-action='quickview'  data-bs-toggle='modal' data-bs-target='#ec_quickview_modal<?=$data['id'];?>'> <span style='font-size:0.9em;font-style:normal;color:black;'>Impression</span><i class='fas fa-print' style='color:<?=$color;?>' aria-hidden='true' style='font-size:100%;'></i></a>

		<!-- Modal -->
    <div class="modal fade" id="ec_quickview_modal<?=$data['id'];?>" tabindex="-1" role="dialog" aria-labelledby="ticketModalLabel" aria-hidden="true">			
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ticketModalLabel"><center>Copyright © eFREEDOM - Version 1.0 </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Contenu du ticket de restaurant -->
                <div class="ticket" id="printable-ticket">
                    <div class="header">
						<div style="float:left;">
								<img class="img-responsive" alt="" src="<?php if(!empty($_SESSION['logo'])) echo $_SESSION['logo']; ?>" style="width:105px;height:105px;">
						</div>
						<div>
            			<h5><?php 	
						if(!empty($nomHotel)) echo $nomHotel;  echo "</h5>";
						if(!empty($Apostale))
							echo  "<p>".$Apostale."</p> ";
						if(!empty($NumUFI))
							echo  "<p>N° IFU: ".$NumUFI."</p> ";
	/* 					if(!empty($NumBancaire))
							echo  "<p>Compte Bancaire: ".$NumBancaire."</p>  ";
						else {
						} */
					?>
					<p> <i class="fa fa-phone"></i>&nbsp;<?php echo $telephone1." - ".$telephone2; ?></p>
					<p><?php echo "E-mail : ".$Email; ?></p>
				
					<?php
							
					$table=(isset($_SESSION['Ntable'])&&(!empty($_SESSION['Ntable']))) ? $_SESSION['Ntable']:NULL; $num_facture=isset($_SESSION['numFact'])?$_SESSION['numFact']:NULL;
					if (isset($data['id'])) {
						$param0 = $data['id'];
						$req="SELECT * FROM factureResto,tableEnCours WHERE tableEnCours.num_facture=factureResto.num_facture AND factureResto.id='".htmlspecialchars($param0)."' ";
						$reqselRTables=mysqli_query($con,$req);
					} else if(isset($num_facture)) {
						$req="SELECT * FROM factureResto,tableEnCours WHERE tableEnCours.num_facture=factureResto.num_facture AND factureResto.num_facture='".trim($num_facture)."' ";
						$reqselRTables=mysqli_query($con,$req);
					}	
					else
					{ 
					}
					$factureResto=mysqli_query($con,$req);
					while($data1=mysqli_fetch_array($factureResto)){ 
						$Net=$data1['montant_ttc']-$data1['Remise'];
						$SommePayee=$data1['somme_paye']; $monnaie=$SommePayee-$Net;$remise=$data1['Remise'];
						$NomClient=!empty($data1['NomClient'])?$data1['NomClient']:"<g>Non renseigné</g>";
						$heure=$data1['heure_emission'];$numRecu=$data1['num_facture'];$client=$data1['client'];$serveur=$data1['serveur'];
					}

				if($client>0){
						$reqx="SELECT * FROM clientresto WHERE id='".$client."' ";
						$reqselRTablesx=mysqli_query($con,$reqx);
						$datax=mysqli_fetch_object($reqselRTablesx);
						$numIFU="<u>IFU</u> : ".$datax->numIFU;
					if(!empty($datax->entrepriseName))
						$NomClient=$datax->entrepriseName;
					else 
						$NomClient=$datax->nomclt." ".$datax->prenomclt;
					}
					else {
					$NomClient="<g>Non renseigné</g>";
					$numIFU=" ";				
					}

				if($serveur>0){
						$reqx="SELECT * FROM serveur WHERE id='".$serveur."' ";
						$reqselRTablesx=mysqli_query($con,$reqx);
						$datax=mysqli_fetch_object($reqselRTablesx);
						$NomServeur=$datax->nomserv." ".$datax->prenoms;
					}
					else {
					$NomServeur="<g> </g>";	
					}					
					?>
				</div>
			</div>

			  <div class="info">
					<small><?php if(!empty($Date_actuel)) echo $Date_actuel2;  ?> à <?php echo $heure; ?></small>
					<center>
							<h6 style='font-weight:bold;background-color:#e5e5e5;'> Ticket N°: <?php echo $numRecu; ?> </h6>
					</center>
					<div><div>
						<p style='float:left;margin-bottom:0px;font-size:0.9em;'><u>Client</u> :  <?php echo $NomClient; ?></p>
						<p style='float:right;margin-bottom:0px;font-size:0.9em;'> <?php echo $numIFU; ?></p></div><br/>
						<div>
						<p style='font-size:0.9em;float: <?php echo "left;"; //else echo "right;"; ?> '><u>Serveur(se)</u> : <?php echo $NomServeur; ?> </p>
						<p style='font-size:0.9em;float: <?php  echo "right;"; ?> '><u>Caissier(e)</u> : <?php echo $_SESSION["nom"]." ".$_SESSION["prenom"]; ?> </p>
						</div>
					</div>	

				</div>
  <div class="content">
						
	<table style='font-size:0.9em;'>
    <tr style='background-color:#e5e5e5;font-weight:bold;'>
	   <td style=''>Désignation</td>
		<td align='right'>Prix</td>
		<td style='text-align:center;'>Qté</td>
		<td style='text-align:right;'>Montant</td>
    </tr>			
		<?php
		if(isset($reqselRTables)){$total=0;$num=0;//$mt=0;
			while($data1=mysqli_fetch_array($reqselRTables)){ $num++;
			$mt=$data1['qte']*$data1['prix'];$total+=$mt;
				echo "<tr>
					<td class='' >".ucfirst($data1['LigneCde'])." ".$data1['QteInd']."</td>
					<td align='right' class=''> ".$data1['prix']."</td>
					<td align='center' class=''> ".$data1['qte']."</td>
					<td  align='right' class=''> ".$mt."</td>
				</tr>";
			} $mht=round($total/1.18); $tva=round(0.18*$mht);
		   }
		   
			  echo 	"
			  <tr>
					<td colspan='1' rowspan='4' align='right'><strong> Montant HT : ".$mht." </strong>
					<br/><strong>  TVA [18%] : ".$tva." </strong>
					</td>
					
					
			  </tr>
			  <tr>
				<td  colspan='2' align='right'> <strong> Montant Total : </strong>  ";
				if($remise>0)
					echo "<br/><strong> Remise accordée : </strong>";

				echo "<br/><strong> Net à payer :</strong>
				<br/><strong> Somme payée :</strong> ";
				if($monnaie>0)
					echo "<br/><strong> Monnaie : </strong> </td>";
					?>
					<td align='right' style=''><strong><i class=""></i> <?php echo $total;?>
					<br/><?php echo $Net;?><br/>	<?php echo $SommePayee;?></strong>									

				<?php
				if($remise>0)
					echo " <br/><strong><i class=''></i> ". $remise."</strong> ";

				if($monnaie>0)
					echo "<br/><strong><i class=''></i> ". $monnaie."</strong> </td>
			</tr>";

				//QRcode::png('code data text', 'filename.png'); // creates file
				//QRcode::png('some othertext 1234'); // creates code image and outputs it directly into browser
	 ?>
	
	</table>

				</div>
				
				<div class="total" style='background-color:#e5e5e5;'>
				<span style='font-weight:normal;font-size:0.9em;float:left;padding-left:5px;'>Mode de règlement : <?php echo $mode="Espèce";?></span>
				<span style='padding-right:5px;'>Total encaissé : <strong><?php echo $total;?></strong></span>
				</div>

				<div class="footerT">
					<center>
					<?php $generator = new BarcodeGeneratorHTML();
						echo $generator->getBarcode($numRecu, $generator::TYPE_CODE_128);?><br/>
						Merci de votre visite !</center>
				</div>				
				<!-- <div class="watermark">DUPLICATA</div>	-->
                </div>
            </div>
        </div>
    </div>
	</div>
	<!-- Modal end -->
						
		<?php 
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		  </tr>";		
		}							
		echo "</tbody></table>";
	} 
?>

	</div>
	</div>
	<input type='hidden' value='﻿<?php if(isset($del)) echo $del;?>'>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/jsalertClient.js"></script>
<script>
 // Attacher un événement sur le document pour détecter les clics sur les éléments qui ouvrent la modale
 document.addEventListener('DOMContentLoaded', () => {
    // Sélectionner tous les éléments de lien qui déclenchent l'impression (basé sur une classe ou attributs data)
    const printLinks = document.querySelectorAll('[data-bs-toggle="modal"][data-link-action="quickview"]');

    printLinks.forEach(link => {
        link.addEventListener('click', () => {
            // Obtenir l'ID de la modale depuis l'attribut data-bs-target
            const modalId = link.getAttribute('data-bs-target');
            const ticketModal = document.querySelector(modalId); // Récupérer la modale correspondante

            // Ajouter un écouteur à l'événement 'shown.bs.modal' pour déclencher l'impression
            ticketModal.addEventListener('shown.bs.modal', () => {
                setTimeout(() => {
                    window.print();
                }, 500); // Lancer l'impression après un court délai
            });
        });
    });
}); 

	function JSalert2(){
	swal("1 : Espèce | 2 : Chèque | 3 : Virement | 4 : Carte Bancaire | 5 : Mobile Money | 6 : Autre", {
		content: {
			element: "input",
			attributes: {
			placeholder: "1 | 2 | 3 | 4 | 5 | 6",
			type: "number",
			},
			},
	})
	.then((value) => {
		var table = document.getElementById('NameTable').value;  var cv = document.getElementById('cv').value;
		document.location.href='servir.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&mode='+value+'&table='+table+'&cv='+cv;

	});
	}

	function redirect() {
		document.location.href='servir.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>';
	}
				

function JSalert() {
  swal({
    title: "Enrégistrer un nouveau Client ",
    content: {
      element: "div",
      attributes: {
        innerHTML: `
          <style>
            .swal-custom-form {
              display: flex;
              flex-direction: column;
              gap: 10px;
              font-family: Arial, sans-serif;
            }
            .swal-custom-form .row {
              display: flex;
              align-items: center;
            }
            .swal-custom-form label {
              width: 135px;
              font-weight: bold;
              color: maroon;
              margin-right: 10px;
              text-align: right;
            }
            .swal-custom-form input {
              flex: 1;
              padding: 5px;
              height: 25px;
              border: 1px solid #ccc;
              border-radius: 4px;
              margin-right: 15px;
            }
          </style>
          
          <div class='swal-custom-form'>
            <div class='row'>
              <label for='rsociale'>Entreprise :</label>
              <input id='rsociale' type='text' class='swal-content__input' placeholder='Si le client est une Entreprise'>
            </div>
            
            <div class='row'>
              <label for='NomClt'>Nom :</label>
              <input id='NomClt' type='text' class='swal-content__input' placeholder='Nom du client'>
            </div>
            
            <div class='row'>
              <label for='Prenomclt'>Prénoms :</label>
              <input id='Prenomclt' type='text' class='swal-content__input' placeholder='Prénoms du client'>
            </div>
            
            <div class='row'>
              <label for='Adresseclt'>Adresse :</label>
              <input id='Adresseclt' type='text' class='swal-content__input'>
            </div>
            
            <div class='row'>
              <label for='Telephoneclt'>Téléphone :</label>
              <input id='Telephoneclt' type='tel' class='swal-content__input'>
            </div>
            
            <div class='row'>
              <label for='IFUclt'>IFU :</label>
              <input id='IFUclt' type='number' class='swal-content__input' placeholder='Numérique'>
            </div>
          </div>
        `
      }
    },
    buttons: true
  }).then((willSubmit) => {
    if (willSubmit) {
      // Récupérer les valeurs des champs
      var rsociale = document.getElementById('rsociale').value.trim();
      var nom = document.getElementById('NomClt').value.trim();
      var prenoms = document.getElementById('Prenomclt').value.trim();
      var adresse = document.getElementById('Adresseclt').value.trim();
      var telephone = document.getElementById('Telephoneclt').value.trim();
      var ifu = document.getElementById('IFUclt').value.trim();

      // Validation côté client
      if ((nom === "") && (rsociale === "")) {
        swal("Erreur", "L'un des champs Entreprise ou Nom doit être renseigné.", "error");
        return;
      }

      if (isNaN(ifu)) {
        swal("Erreur", "Le champ IFU doit être numérique !", "error");
        return;
      }

      if ((rsociale !== "") && (ifu === "")) {
        swal("Erreur", "Pour une Entreprise, le champ IFU est requis !", "error");
        return;
      }

      // Envoi des données en AJAX
      var formData = new FormData();
      formData.append('rsociale', rsociale);
      formData.append('nom', nom);
      formData.append('prenoms', prenoms);
      formData.append('adresse', adresse);
      formData.append('telephone', telephone);
      formData.append('ifu', ifu);

      fetch('insert_client.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          swal("Succès", data.message, "success");
        } else {
          swal("Erreur", data.message, "error");
        }
      })
      .catch(error => swal("Erreur", "Une erreur s'est produite lors de l'ajout du client.", "error"));
    }
  });
}

function CheckClient() {
  swal({
    title: "Rechercher un Client ",
    content: {
      element: "input",
      attributes: {
        placeholder: "Tapez pour rechercher le client...",
        id: "clientSearchInput",
        class: "swal-content__input",
        type: "text",
        autocomplete: "off",
      },
    },
    buttons: true,
  }).then((value) => {
    if (value) {
      var table = document.getElementById('NameTable').value;  
      var cv = document.getElementById('cv').value;

      // Utiliser la valeur sélectionnée pour rediriger
      document.location.href = 'servir.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&client=' + value + '&table=' + table + '&cv=' + cv;
    }
  });

  // Ajoutez un écouteur d'événements pour lancer la recherche AJAX à chaque frappe
  document.getElementById('clientSearchInput').addEventListener('input', function () {
    var query = this.value.trim();
    
    if (query.length > 2) {
      fetch('search_clients.php?query=' + encodeURIComponent(query))
        .then(response => response.json())  // Convertir la réponse en JSON
        .then(data => {
          console.log("Données reçues : ", data);  // Affichez les données pour voir ce que le serveur renvoie
          showSuggestions(data);
        })
        .catch(error => console.error('Erreur AJAX:', error));
    }
  });
}

// Fonction pour afficher les suggestions de recherche
function showSuggestions(data) {
  const searchInput = document.getElementById('clientSearchInput');
  const datalist = document.createElement('datalist');
  datalist.id = "clientsList";

  if (document.getElementById("clientsList")) {
    document.getElementById("clientsList").remove();
  }

  data.forEach(client => {
    let option = document.createElement('option');
	if (client.entrepriseName=="")
		option.value = client.nomclt + " " + client.prenomclt + " (" +client.id + ")"; // Utilisez les noms de colonnes corrects de la table
    else 
		option.value = client.entrepriseName + " [ " + client.nomclt + " " + client.prenomclt + " ]  (" +client.id + ")"; // Utilisez les noms de colonnes corrects de la table
	datalist.appendChild(option);
  });

  searchInput.setAttribute("list", "clientsList");
  document.body.appendChild(datalist);
}


function findServ(tableName,permanent=0,current) {
  swal({
    title: "",
    content: {
      element: "div",
      attributes: {
        innerHTML: `
          <style>
            .swal-custom-form {
              display: flex;
              flex-direction: column;
              gap: 10px;
              font-family: Arial, sans-serif;
			  min-height:200px;
            }
            .swal-custom-form .row {
              display: flex;
              align-items: center;
            }
            .swal-custom-form label {
              width: 135px;
              font-weight: bold;
              color: maroon;
              margin-right: 10px;
              text-align: right;
            }
            .swal-custom-form select,
            .swal-custom-form input {
              flex: 1;
              padding: 5px;
              height: 25px;
              border: 1px solid #ccc;
              border-radius: 4px;
              margin-right: 15px;
            }
          </style>
          
          <div class='swal-custom-form'>
            <div class='row'>
              <fieldset>
                <legend align='center' style='color:#2F574D;'><b>Affectation d'un(e) serveur(se) à la Table ${tableName}</b></legend>
                <div class='row'>
                  <label for='serveurNumber'>Serveur(se) :</label>
                  <select id='serveurNumber' class='swal-content__input' style='height:35px;'>
                    <option value=''>Sélectionner le nom ..</option>
                  </select>
                </div>
              </fieldset>
            </div>
          </div>
        `
      }
    },
    buttons: true
  }).then((willSubmit) => {
	if (willSubmit) {
  // Récupérer les valeurs des champs
  var serveurNumber = document.getElementById('serveurNumber').value.trim();

  // Validation côté client
  if (serveurNumber === "") {
    swal("Erreur", "Veuillez sélectionner le nom", "error");
    return;
  }

  // Envoi des données en AJAX avec le paramètre `table`
  var formData = new FormData();
  formData.append('serveurNumber', serveurNumber);
  formData.append('tableName', tableName);  // Ajouter la table en tant que paramètre supplémentaire
  formData.append('permanent', permanent); 
  formData.append('current', current); 

  fetch('affecter_serveur.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 'success') {
      swal("Succès", data.message, "success").then(() => {
        // Recharger la page mère après validation réussie
        window.location.reload();
      });
    } else {
      swal("Erreur", data.message, "error");
    }
  })
  .catch(error => swal("Erreur", "Une erreur s'est produite lors de l'affectation du serveur.", "error"));
}
});

  // Charger les serveurs depuis la table `serveur` via AJAX
  fetch('get_serv_numbers.php')
    .then(response => response.json())
    .then(data => {
      if (data && Array.isArray(data)) {
        let serveurSelect = document.getElementById('serveurNumber');
        data.forEach(serveur => {
			
					    // Ajouter une option vide après chaque serveur
        let emptyOption = document.createElement('option');
        emptyOption.disabled = true; // Rendre l'option non sélectionnable
        emptyOption.style.height = "1.5em"; // Espacement
        emptyOption.textContent = ""; // Option vide
        serveurSelect.appendChild(emptyOption);
		
          let option = document.createElement('option');
          option.value = serveur.id; // Insérer le nom du serveur dans la valeur de l'option
          option.textContent = serveur.nomserv+" "+serveur.prenoms; // Afficher le nom du serveur
          serveurSelect.appendChild(option);
		 		
        });
      }
    })
    .catch(error => console.error("Erreur lors de la récupération des serveurs:", error));
}


function delServ(tableName) {
  // Afficher une boîte de dialogue SweetAlert pour confirmer la suppression
  swal({
    title: "Confirmer le retrait du serveur(se)",
    text: `Voulez-vous vraiment retirer le serveur(se) associé(e) à la table ${tableName} ?`,
    icon: "warning",
    buttons: {
      cancel: "Annuler",
      confirm: {
        text: "Oui, supprimer",
        value: true,
        visible: true,
        className: "",
        closeModal: true
      }
    },
    dangerMode: true // Style d'alerte en mode danger
  }).then((willDelete) => {
    if (willDelete) {
      // Envoi des données en AJAX avec le paramètre `table`
      var formData = new FormData();
      formData.append('tableName', tableName);  // Ajouter la table en tant que paramètre

      fetch('minus_serveur.php', { // Remplacer par l'URL du fichier PHP qui gère la suppression
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          swal("Succès", data.message, "success").then(() => {
            // Recharger la page mère après suppression réussie
            window.location.reload();
          });
        } else {
          swal("Erreur", data.message, "error");
        }
      })
      .catch(error => swal("Erreur", "Une erreur s'est produite lors de la suppression du serveur.", "error"));
    }
  });
}


</script>			
	</body>
</html>
