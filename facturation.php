<?php
	include_once'menu.php'; //echo $_SESSION['serveurused'];

	include 'others/footerpdf.inc';

	$idr = isset($_POST['button_checkbox_2'])?$_POST['button_checkbox_2']:null;
	$idrV = isset($_POST['button_checkbox_1'])?$_POST['button_checkbox_1']:null;
  $idrx = isset($_POST['famille'])?$_POST['famille']:null;

	$connected=is_connected();$txi=0;
	if(isset($_GET['clt']) && isset($_GET['dato']) && ($connected=='true')){
		$txi=1;
	 //if($connected=='true'){
		 //if((isset($_SESSION['print'])&&($_SESSION['print']==1))){
			// unset($_SESSION['DT_HEURE_MCF']);unset($_SESSION['CODE_REPONSE']);
			 //unset($_SESSION['SIGNATURE_MCF']);unset($_SESSION['COMPTEUR_MCF']);
			 //unset($_SESSION['QRCODE_MCF']);  unset($_SESSION['NIM_MCF']);
		//}	else { //echo 125;
			$_SESSION['call_emecef']=1;$receipt=0;
			$sql="UPDATE produitsencours SET Etat='4' WHERE  Etat = 3 AND Client ='".$_GET['clt']."'";
			$req=mysqli_query($con,$sql) or die(mysqli_error($con));
			include('process.php');
			//@include('test.php');$txi
		//}
	 }else {
		 //if((isset($_SESSION['print'])&&($_SESSION['print']==1))){
		 if(isset($_GET['clt'])){
			 $sql="UPDATE produitsencours SET Etat='1' WHERE  Etat = 3 AND Client ='".$_GET['clt']."'";
			 $req=mysqli_query($con,$sql) or die(mysqli_error($con));
			// echo "<script language='javascript'>";
			// echo 'swal("Vous n\'êtes pas connectez à Internet.","","error")';
			// echo "</script>";$receipt=1;
			if(isset($_GET['dato']))
			echo '<meta http-equiv="refresh" content="1; url=Facturation.php?menuParent=Facturation&rallback=1" />';
		 }
	// }
	//include ('process.php');
	}

	if(isset($idr) || isset($idrV) || isset($_GET['clt']) || isset($idrx)) {  $nomclt=isset($_POST['nomclt'])?$_POST['nomclt']:NULL;
		if(isset($idr) || isset($idrV) || isset($idrx))
			{	if(isset($_GET['clt']) && (substr($_GET['clt'],0,8)=="Anonyme_")) $Numclt=$_GET['clt'];
				if(isset($_SESSION['nomclt'])){$req="SELECT Num FROM clients WHERE NomClt='".$_SESSION['nomclt']."' AND Clients.Type='".$_SESSION['menuParenT1']."'";
				$reqsel=mysqli_query($con,$req);$NClient=mysqli_fetch_object($reqsel);$Numclt=isset($NClient->Num)?$NClient->Num:NULL;}
			}
		if(isset($_GET['clt'])) $Numclt=$_GET['clt'];

		if(isset($Numclt)){
			$ret1=mysqli_query($con,'SELECT *  FROM produitsencours WHERE Etat="1" AND Client="'.$Numclt.'" AND Type ="1"');
			$ret2=mysqli_query($con,'SELECT *  FROM produitsencours WHERE Etat="1" AND Client="'.$Numclt.'" AND Type ="0"');
			$NVente=mysqli_num_rows($ret1);$NPrestation=mysqli_num_rows($ret2);
		}

	}else{
		unset($_SESSION['nomclt']);
	}

	if(!(isset($_GET['ano0']))) unset($_SESSION['CltAnonyme']);

	$req="SELECT DISTINCT(produitsencours.Client) AS Client FROM clients,produitsencours WHERE produitsencours.Client=clients.Num  AND Etat='1'  AND Clients.Type='".$_SESSION['menuParenT1']."'";
	$req.=" UNION SELECT DISTINCT(produitsencours.Client) AS Client FROM produitsencours WHERE Etat='1' AND Type <>'3'";
	$result0 = mysqli_query($con,$req);
	$data0 = mysqli_fetch_object($result0);
	if(isset($data0->Client)){
		$reqsel=mysqli_query($con,$req);$ListeClients=array();$i=0;
		while($NClient=mysqli_fetch_array($reqsel)){
			$ListeClients[$i]=$NClient['Client'];$i++;
		}
	}
	if(isset($_GET['clt'])){
		$req="SELECT NomClt FROM clients WHERE Num='".$_GET['clt']."' AND Clients.Type='".$_SESSION['menuParenT1']."'";
		$reqsel=mysqli_query($con,$req);$NClient=mysqli_fetch_assoc($reqsel);$_SESSION['nomclt']=isset($NClient['NomClt'])?$NClient['NomClt']:"Client anonyme";
	}
	// if(isset($_GET['valider'])&&($_GET['valider']=='true')){//echo 12;
	// 	if(isset($Numclt)){ //echo 5;
	// 		$sql="SELECT * FROM produitsencours  WHERE  Etat='3' AND Client ='".$Numclt."'";  //Le cas ou l'opération a été validée
	// 		$req=mysqli_query($con,$sql) or die(mysqli_error($con));
	// 		if(mysqli_num_rows($req)>0)  {
	// 			echo $emecef=1;
	// 			include ('process.php');
	// 		}//$emecef=1; //else $emecef=0;
	//
	// 	}
	// }else
	// 	$emecef=0;

	if (isset($_POST['Affecter'])&& $_POST['Affecter']=='Enrégistrer')
	   { $qteVendue=!empty($_POST['qteVendue'])?$_POST['qteVendue']:1;
	   if(isset($_POST['button_checkbox_2'])){
		  $produit=addslashes(ucfirst($_POST['produit']));
	   }else {
		  $rz="SELECT * FROM produits WHERE Num='".$_POST['produit']."' AND Type='".$_SESSION['menuParenT1']."'"; $req=mysqli_query($con,$rz);
		  $data=mysqli_fetch_object($req);  $Qte_initial= $data->Qte_Stock;$update=$data->Num2 ; $designation=$data->Designation ;
		  $produit=$_POST['produit'] ;
	   }
		if(isset($_POST['nomclt'])){
		    if(substr($_POST['nomclt'],0,8)=="Anonyme_"){
				$Numclt=$_POST['nomclt'];$ToInsert=0;
				$_SESSION['CltAnonyme']=$_POST['nomclt'];
			}
			if(isset($_GET['ano0'])&& ($_GET['ano0']==0) && isset($_GET['clt'])) {  $Numclt=$_GET['clt'];
			}
			else { $_SESSION['nomclt']=$_POST['nomclt'];  $nom_clt=$_POST['nomclt'];
					$rek="SELECT * FROM clients WHERE Type LIKE '".$_SESSION['menuParenT1']."' AND NomClt LIKE '".$_POST['nomclt']."'";
					$sql=mysqli_query($con,$rek);
					if(mysqli_num_rows($sql)<=0)
					   {	$req="SELECT * FROM clients WHERE Type='".$_SESSION['menuParenT1']."'";
							$reqsel=mysqli_query($con,$req);$nbre=1+mysqli_num_rows($reqsel);
							if(($nbre>=0)&&($nbre<=9)) $nbre="00000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="0000".$nbre ;else $nbre="00".$nbre ;
							if(!isset($ToInsert))
								{$req="INSERT INTO clients SET Num=NULL,Num2='".$nbre."',NomClt='".ucfirst($_POST['nomclt'])."',AdresseClt='',TelClt='',EmailClt='',Type='".$_SESSION['menuParenT1']."'";
								$query = mysqli_query($con,$req) or die (mysqli_error($con));}
						}
					if(!isset($ToInsert)){
						$req="SELECT Num FROM clients WHERE NomClt='".$_POST['nomclt']."' AND Clients.Type='".$_SESSION['menuParenT1']."'";
						$reqsel=mysqli_query($con,$req);$NClient=mysqli_fetch_assoc($reqsel);$Numclt=$NClient['Num'];}
				}
			}

				$GrpeTaxation="E" ; $taxSpecific=0;$RegimeTVA= 0;
				$check='SELECT Num FROM produitsencours WHERE LigneCde="'.$produit.'" AND Client="'.$Numclt.'"  AND Etat ="1" '; // Vérifier si la ligne de commande correspondant au même produit n'a pas encore été inséré. Si OUI -> UPDATE  Si NON->INSERT
				$insert="INSERT INTO produitsencours SET Num=NULL,SIGNATURE_MCF='',Client='".$Numclt."', LigneCde ='".$produit."', prix ='".$_POST['PrixVente']."',qte ='".$qteVendue."',Etat='1',GrpeTaxation='".$GrpeTaxation."',taxSpecific='".$taxSpecific."',RegimeTVA='".$RegimeTVA."'";
				$update="UPDATE produitsencours SET qte =qte+'".$qteVendue."' WHERE Num= ";
				$Numclt2=isset($_GET['clt'])?$_GET['clt']: $Numclt; $idrx=NULL;
				$NbreP='SELECT * FROM produitsencours WHERE Etat="1" AND Client="'.$Numclt2.'"';

				if(isset($_POST['button_checkbox_2'])){  //Prestation de services
				$check.=' AND Type="0"'; $ret=mysqli_query($con,$check);
				if(mysqli_num_rows($ret)>0){
				$aws=mysqli_fetch_object($ret); $update.="'".$aws->Num."'";
				 $req=$update;
				}else {
		   		 $insert.=" ,Type='0'"; $req=$insert;
				}
				$reqselR=mysqli_query($con,$req);

				$NbreP.=" AND Type='0'"; $ret2=mysqli_query($con,$NbreP);	$NPrestation=mysqli_num_rows($ret2);

				echo "<script language='javascript'>";
			    echo 'alertify.success(" Ligne de commande enrégistrée");';
			    echo "</script>";

				$sql1='SELECT *  FROM produitsencours WHERE Etat="1" AND Client="'.$Numclt.'" AND Type ="0"';
				$Reqk=mysqli_query($con,$sql1);
				$NPrestation=mysqli_num_rows($Reqk);	$designation=$produit;
		 }else {              //Vente de produits
			 if(($qteVendue <= $_POST['Qtestock'])&& ($qteVendue>0) ){
				$check.='AND Type="1" AND prix="'.$_POST['PrixVente'].'"'; $ret=mysqli_query($con,$check);
				if(mysqli_num_rows($ret)>0){
				$aws=mysqli_fetch_object($ret); $update.="'".$aws->Num."'";
				$req=$update;
				}else {
				 $insert.=" ,Type='1'"; $req=$insert;
				}
				$reqselR=mysqli_query($con,$req);  $Qte_Stock = $_POST['Qtestock'] - $qteVendue;

				if($reqselR)
				{$rek="UPDATE produits SET Qte_Stock='".$Qte_Stock."',StockReel='".$Qte_Stock."' WHERE Num='".$_POST['produit']."'";
				 $query = mysqli_query($con,$rek) or die (mysqli_error($con));

				$NbreP.=" AND Type='1'"; $ret2=mysqli_query($con,$NbreP);  $NVente=mysqli_num_rows($ret2);
				}
				$nomClt=isset($nom_clt)?$nom_clt:"Client anonyme";
				if($query)
				{echo "<script language='javascript'>";
			    //echo 'alertify.success(" Ligne de commande enrégistrée");';
				 echo "var quantite = '".$qteVendue."';";
				 echo "var designation = '".$designation."';";
				 echo "var client = '".$nomClt."';";
			     echo 'alertify.success("("+quantite+") "+designation+" ===> "+client);';
			     echo "</script>";

				$sql1='SELECT *  FROM produitsencours WHERE Etat="1" AND Client="'.$Numclt.'" AND Type ="1"';
				$Reqk=mysqli_query($con,$sql1);
				$NVente=mysqli_num_rows($Reqk);

				$Qte_Stock=$Qte_initial-$qteVendue; $ref="VENTE_".$produit."_".$Numclt ;  $service=" "; $designationOperation ='Vente de Produits';
				$re="INSERT INTO operation VALUES(NULL,'".$ref."','".$designationOperation."','".$produit."','".$Qte_initial."','".$qteVendue."','".$Qte_Stock."','".$Jour_actuel."','".$Heure_actuelle."','','".$qteVendue."')";
				$req=mysqli_query($con,$re);}

			 }else if($_POST['PrixVente']<=0){
				 echo "<script language='javascript'>";
				 echo 'alertify.error("Vérifier le Prix de vente du Produit");';
				 echo "</script>";
			 }
			 else {
				 echo "<script language='javascript'>";
				 echo 'alertify.error(" Qté vendue supérieure à la quantité en stock");';
				 echo "</script>";
			 }
		 }
	 }

	// $_SESSION['nomclt']



//if(!isset($idr)&&!isset($idrV)) unset($_SESSION['nomclt']);



?>
<html>
	<head>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<link rel="Stylesheet" href='css/table.css' />
		<script type="text/javascript" src="js/verifyCheckBoxes1.js"></script>
		<script type="text/javascript" src="js/ajax.js"></script>
		<script type="text/javascript" src="js/ajax-dynamic-list2.js"></script>
		<link rel="Stylesheet" type="text/css"  href='css/input.css' />
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
				border:1px solid;
			}

			.bouton:hover
			{
				cursor:pointer;
			}
		</style>
<script type="text/javascript">
function prix () {
	var value1 = document.getElementById('PrixVente2').value;  var value2 = document.getElementById('qteVendue').value
	document.getElementById('PrixVente').value = value1 * value2;
}

//function edition6() { options = "Width=800,Height=650" ; window.open( "receipt2.php", "edition", options ) ; }
</script>	<script src="js/sweetalert.min.js"></script>
	</head>
	<body bgcolor='azure' style="">
	<div align="" style="">
		<div align="center" style="">
			<?php  $mode=isset($_GET['mode'])?$_GET['mode']:"Espèce";   $echeance=isset($_GET['echeance'])?$_GET['echeance']:$Date_actuel; //unset($_SESSION['echeance']);echo var_dump($_SESSION['echeance']);
/* 				$_SESSION['clt']=isset($_GET['clt'])?"&clt=".$_GET['clt']:"&clt=";
				$_SESSION['mode']=isset($_GET['mode'])?"&mode=".$_GET['mode']:"&mode=Espèce";
				$_SESSION['mode']=isset($_GET['mode'])?"&mode=".$_GET['mode']:"&mode=Espèce"; */

				if(isset($_GET['pc'])){
						echo "<iframe src='facture.php";  echo "' width='1000' height='800' scrolling='no' allowtransparency='true' FRAMEBORDER='yes' style='margin-left:10%;margin-top:-25px;'></iframe>";
				}

				if(isset($_GET['rallback'])){
							echo "<script language='javascript'>";
							echo 'swal("Vous n\'êtes pas connectez à Internet.","","error")';
							echo "</script>";
					//echo '<meta http-equiv="refresh" content="1; url=Facturation.php?menuParent=Facturation" />';
				}else if(!isset($_GET['rallback']) && isset($_GET['dato']) && ($txi==1)){
							echo "<script language='javascript'>";
							echo 'swal("Opération effectuée avec succès. Veuillez imprimer le reçu ou bien la facture normalisé.e au client.","","success")';
							echo "</script>";
							//echo '<meta http-equiv="refresh" content="1; url=Facturation.php?menuParent=Facturation" />';
						}
						else{

						}

				if(!empty($_GET['aj']) && ($_GET['aj']==1)){ //echo $_SESSION['mode']=$mode;
				echo "<script language='javascript'>";
				echo 'swal("Mode de règlement", {
					  content: {
					  element: "input",
					  attributes: {
					  placeholder: "Ex : Espèce, Chèque à réception de facture...",
					  },
					  },
					  })
						.then((value) => {
						  document.location.href="facturation.php?menuParent='.$_SESSION['menuParenT'].'&mode="+value;
						}); ';
				echo "</script>";
			}
			if(!empty($_GET['aj']) && ($_GET['aj']==2)){ //$_SESSION['echeance']=$echeance;
				echo "<script language='javascript'>";
				echo 'swal("Date d\'échéance", {
					  content: {
					  element: "input",
					  attributes: {
					  type: "date",
					  },
					  },
					  })
						.then((value) => {
						  document.location.href="facturation.php?menuParent='.$_SESSION['menuParenT'].'&echeance="+value;
						}); ';
				echo "</script>";
			}
				if(!empty($_GET['aj']) && ($_GET['aj']==3)){ //$_SESSION['echeance']=$echeance;
				echo "<script language='javascript'>";
				echo 'swal("Saisissez un mot de passe pour confirmer", {
					  content: {
					  element: "input",
					  attributes: {
					  placeholder: "password",
					  type: "password",
					  },
					  },
					  })
						.then((value) => {
						  document.location.href="facturation.php?menuParent='.$_SESSION['menuParenT'].'&echeance="+value;
						}); ';
				echo "</script>";
			}

			if(isset($_GET['px'])&&($_GET['px']=="true")){

			}

			if(isset($_GET['state'])||(isset($_GET['vis']))||isset($_GET['visr']))
			//if(isset($_GET['state'])||(isset($_GET['vis']))||isset($_GET['visr'])||($emecef==1))
			{
				include ('process.php');

			}
			else{
				//$resT=mysqli_query($con,"SELECT Client,NomClt FROM  produitsencours,clients WHERE produitsencours.Client=Clients.Num AND Clients.Type='".$_SESSION['menuParenT1']."'  AND produitsencours.Num IN (SELECT MAX(Num) FROM  produitsencours WHERE Etat='1')");
				$resT=mysqli_query($con,"SELECT Client FROM  produitsencours WHERE Num IN (SELECT MAX(Num) FROM  produitsencours WHERE Etat='1')");
				//echo "SELECT Client FROM  produitsencours WHERE Num IN (SELECT MAX(Num) FROM  produitsencours WHERE AND Etat='1')";
				$reXt=mysqli_fetch_assoc($resT); $clt=$reXt['Client']; $client=isset($_GET['clt'])?$_GET['clt']:$clt;
				$resT=mysqli_query($con,"SELECT Etat FROM  produitsencours WHERE Client ='".$client."' AND Etat='1'");
			?>
		    	 <form action="facturation.php?menuParent=<?php echo $_SESSION['menuParenT']; if(isset($_GET['clt'])) echo "&clt=".$_GET['clt']; if(isset($_GET['ano0'])) echo "&ano0=0"; if(isset($_GET['ki'])) echo "&ki=".$_GET['ki'];?>" method="POST" id="chgdept">
				<table width="800" height="auto" border="0" cellpadding="1" cellspacing="1" id="tab">
					<tr>
						<td colspan="2">
							<h2 style="text-align:center; font-family:Cambria;color:maroon;">FACTURATION D'UN CLIENT</h2>
						</td>
					</tr>
					<tr style=''>
						<td colspan='2'>
							<span style="float:left;" >
							<?php
							if(isset($ListeClients) && count($ListeClients)>0)
							{	$j=1;$k=0;
								for($i=0;$i<count($ListeClients);$i++)
								{  if(substr($ListeClients[$i],0,8)=="Anonyme_")
										{$k++; $NomClient="Client anonyme N°".$k;
										}
									else{$req="SELECT NomClt FROM clients WHERE Num='".$ListeClients[$i]."'  AND Clients.Type='".$_SESSION['menuParenT1']."'";
										 $reqsel=mysqli_query($con,$req);$NClient=mysqli_fetch_assoc($reqsel);$NomClient=$NClient['NomClt'];}

										 echo "<span style='color:gray;'><a  class='info' href='facturation.php?menuParent=". $_SESSION['menuParenT']."&clt=".$ListeClients[$i];  if(substr($ListeClients[$i],0,8)=="Anonyme_") echo "&ano0=0&ki=".$k; echo "' style='color:E70739;font-size:1.1em;' >".$j ."<span style='font-size:0.9em;color:pick;'>".$NomClient."</span> </a>&nbsp;<span style='color:gray;font-weight:bold;'>|</span>&nbsp;</span>";
									$j++;
								}
								echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							}
							?></span>
							<hr />
						</td>
					</tr>
					<tr style='background-color:#EFECCA;'>  <!-- #E1E6FA ffebcd  --!>
						<td colspan='2' align='center'>
						<span style="float:left;" >
						<?php
						// if(isset($ListeClients) && count($ListeClients)>0)
						// {	$j=1;$k=0;
						// 	for($i=0;$i<count($ListeClients);$i++)
						// 	{  if(substr($ListeClients[$i],0,8)=="Anonyme_")
						// 			{$k++; $NomClient="Client anonyme N°".$k;
						// 			}
						// 		else{$req="SELECT NomClt FROM clients WHERE Num='".$ListeClients[$i]."'  AND Clients.Type='".$_SESSION['menuParenT1']."'";
						// 			 $reqsel=mysqli_query($con,$req);$NClient=mysqli_fetch_assoc($reqsel);$NomClient=$NClient['NomClt'];}
						//
						// 			 echo "<span style='color:gray;'><a  class='info' href='facturation.php?menuParent=". $_SESSION['menuParenT']."&clt=".$ListeClients[$i];  if(substr($ListeClients[$i],0,8)=="Anonyme_") echo "&ano0=0&ki=".$k; echo "' style='color:E70739;' >".$j ."<span style='font-size:0.9em;color:pick;'>".$NomClient."</span> </a>&nbsp;|&nbsp;</span>";
						// 	  $j++;
						// 	}
						// 	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						// }
						?></span>
						<span style="" >
							<h5 style='display:inline;color:gray;'>
								<?php
								//if(isset($_GET['print']))
								echo "Identité du Client";
								?>
							: </h5>
							<?php
							if(isset($_GET['ano0'])&& ($_GET['ano0']==1)) {unset($_SESSION['CltAnonyme']);
								$reqsel=mysqli_query($con,"SELECT CltAnonyme FROM ConfigEcono");
								$data=mysqli_fetch_object($reqsel);$CltAnonyme="Anonyme_".$data->CltAnonyme;
								$resT=mysqli_query($con,"SELECT Client FROM  produitsencours WHERE Client='".$CltAnonyme."'");
								if(mysqli_num_rows($resT)>0){
									$update=mysqli_query($con,"UPDATE ConfigEcono SET CltAnonyme=CltAnonyme+1 ");
									$reqsel=mysqli_query($con,"SELECT CltAnonyme FROM ConfigEcono");
									$data=mysqli_fetch_object($reqsel);$CltAnonyme="Anonyme_".$data->CltAnonyme;
								}
								echo "<span style='color:gray;font-size:1.2em;font-weight:bold;'>Client anonyme</span>";
								echo "<input name='nomclt' type='hidden' value='".$CltAnonyme."'>";
							}
							else if(isset($_SESSION['CltAnonyme'])){
								echo "<span style='color:gray;font-size:1.2em;font-weight:bold;'>Client anonyme </span>";
								echo "<input name='nomclt' type='hidden' value='".$_SESSION['CltAnonyme']."'>";
							}
							else {
							if(isset($_SESSION['nomclt'])) {
								echo "<span style='color:gray;font-size:1.2em;font-weight:bold;'>". $_SESSION['nomclt']; if(isset($_GET['ki'])) echo " N°".$_GET['ki']; echo "</span>";
								echo "<input name='nomclt' type='hidden' value='".$_SESSION['nomclt']."'>"; }
								else { ?>
								<input name='nomclt' id='nomclt' required='required' style='border:1px dashed maroon;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" onchange="ajax_showOptions(this,'getCountriesByLetters',event)" autocomplete='OFF' value='<?php if(isset($nomclt)) echo $nomclt; ?>' style='' placeholder='&nbsp;&nbsp;Entreprise ou Nom du Client'/>
								</span>&nbsp;&nbsp; <a class='info3' href='facturation.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&ano0=1'><img src='logo/Change.png' alt='' title='' width='20' height='20' border='0'><span style='font-size:0.9em;color:black;'>Client anonyme</span></a>
								<?php
								}
							}
							?>
						</td>
					</tr>

					<tr style=''>
						<td colspan='2'><hr />
						</td>
					</tr>
					<tr>
					<td align='center' colspan='2'>
					<input type="checkbox"  id="button_checkbox_1" onClick="verifyCheckBoxes1();"  name="button_checkbox_1"  <?php if(empty($idr)) echo "checked"; ?> onchange="document.forms['chgdept'].submit();">  <label for="button_checkbox_1" style='font-weight:bold;color:#444739;'>
					VENTE DE PRODUITS</label> <span style='color:#BD8D46;'> <?php if(isset($NVente)) echo "(".$NVente.")";  ?></span>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

					<?php

					if(!empty($_GET['test'])&& ($_GET['test']=='true')){
						$rek="DELETE FROM produitsencours WHERE Client='".$_SESSION['delete']."' AND Etat='1'";
						$query = mysqli_query($con,$rek) or die (mysqli_error($con));
						if($query){
						echo "<script language='javascript'>";
						echo 'alertify.success(" Opération effectuée avec succès !");';
						echo "</script>";
						}
					} if(!empty($_GET['test'])&& ($_GET['test']=='null')){
						echo "<script language='javascript'>";
						echo 'alertify.error(" L\'opération a été annulée !");';
						echo "</script>";
					}

					 $resT=mysqli_query($con,"SELECT Client FROM  produitsencours WHERE Num IN (SELECT MAX(Num) FROM  produitsencours WHERE Etat='1')");
					 $reXt=mysqli_fetch_assoc($resT);  $Numclt=isset($_GET['clt'])?$_GET['clt']:$reXt['Client'];

					 $req="SELECT NomClt FROM clients WHERE Num='".$Numclt."' AND Clients.Type='".$_SESSION['menuParenT1']."'";
					 $reqsel=mysqli_query($con,$req);$NClient=mysqli_fetch_assoc($reqsel);

				    if(isset($_GET['clt'])&& (substr($_GET['clt'],0,8)=="Anonyme_")){
						$rek="SELECT DISTINCT(produitsencours.Client) AS Client FROM produitsencours WHERE Etat='1'";
						$result0=mysqli_query($con,$rek);	$k=0;
						while($result=mysqli_fetch_array($result0)){
							if(substr($result['Client'],0,8)=="Anonyme_")
								$k++;
							if($result['Client']==$_GET['clt'])
								$NomClient="Anonyme N°".$k;
						}
					}

					 if(isset($NClient['NomClt'])) $NomClt=$NClient['NomClt']; else {if(isset($NomClient))$NomClt=$NomClient;}


   					 $sql="SELECT Num FROM produitsencours WHERE Client ='".$Numclt."' AND Etat='1'";
					 $reqsel=mysqli_query($con,$sql);
					 $dataT=array();$i=0; $NbreResult= mysqli_num_rows($reqsel);
					 while($data=mysqli_fetch_array($reqsel)){
						 $dataT[$i]=$data['Num'];$i++;
					 }
					$data='';
					for($i=0;$i<count($dataT);$i++){
						$data.=$dataT[$i];
						if($i<$NbreResult-1)
							$data.=",";
					}
					 //if(isset($_GET['print'])) {
					 if(isset($_GET['valider'])&&($_GET['valider']!="true")) {
								 echo "<script language='javascript'>";
								 echo 'alertify.error(" L\'opération a été annulée !");';
								 echo "</script>";
					 			echo '<meta http-equiv="refresh" content="0; url=Facturation.php?menuParent=Facturation" />';
					 }
					 if(isset($_GET['valider'])&&($_GET['valider']=="true")) {
					 $mode=isset($_GET['mode'])?$_GET['mode']:"Espèce";   $echeance=isset($_GET['echeance'])?$_GET['echeance']:$Date_actuel;
					 $resT=mysqli_query($con,"SELECT SUM(prix*qte) AS somme FROM  produitsencours WHERE Client ='".$Numclt."'");
					 $reXt=mysqli_fetch_assoc($resT);  $somme=$reXt['somme']; $sommeP=$somme; $tva=$TvaD*$somme; $remise=0;

					 $update=mysqli_query($con,"UPDATE ConfigEcono SET num_fact=num_fact+1 ");
					 $reqsel=mysqli_query($con,"SELECT num_fact FROM ConfigEcono");
					 $data2=mysqli_fetch_assoc($reqsel);$numFact=$data2['num_fact'];
					 if(($numFact>=0)&&($numFact<=9))$numFact='000'.$numFact ;else if(($numFact>=10)&&($numFact<=99))$numFact='00'.$numFact ;else if(($numFact>=100)&&($numFact<=999)) $numFact='0'.$numFact ;else $numFact=$numFact;
					 $numFact.="/".substr(date('Y'),2,2);

					 $req="INSERT INTO factureeconomat SET Num=NULL,Nums='".$data."',date_emission='".$Jour_actuel."',heure_emission='".$Heure_actuelle."',num_facture='".$numFact."',Client='".$Numclt."',tva='".$tva."', montant_ttc='".$somme."',Remise='".$remise."',somme_paye='".$sommeP."',ModePayement='".$mode."',Echeance='".$echeance."',Signature='1' ";
					 $query = mysqli_query($con,$req) or die (mysqli_error($con));
					 $sql="UPDATE produitsencours SET Etat='3' WHERE Etat='1' AND Client ='".$Numclt."'";
					 $req=mysqli_query($con,$sql) or die(mysqli_error($con));

					 $sql="SELECT Num FROM produitsencours WHERE Client ='".$Numclt."' AND Etat='3'";
					 $reqsel=mysqli_query($con,$sql);
					 $Tableau=array();$i=0; $NbreResult= mysqli_num_rows($reqsel);
					 $dato='';
					 while($data=mysqli_fetch_array($reqsel)){
					//	$Tableau[$i]=$data['Num'].",";
					//$i++;
						$dato.=$data['Num'].",";
					} //$_SESSION['Tableau']=$Tableau;
					$dato=trim($dato);
					$sql="UPDATE produitsencours SET SIGNATURE_MCF='".$dato."' WHERE Etat='3' AND Client ='".$Numclt."'";
					//$req=mysqli_query($con,$sql) or die(mysqli_error($con));

					 if(isset($_GET['valider'])&&($_GET['valider']=='true')){
					 	 if(isset($Numclt)){
							 $sql="SELECT * FROM produitsencours  WHERE  Etat='3' AND Client ='".$Numclt."'";  //Le cas ou l'opération a été validée
							 $req=mysqli_query($con,$sql) or die(mysqli_error($con));
							 if(mysqli_num_rows($req)>0)  { $nb=5;
								 echo '<meta http-equiv="refresh" content="0; url=Facturation.php?menuParent=Facturation&clt='.$Numclt.'&dato='.$dato.'" />';
								 //include ('process.php');
							 }
						 }
					 }

					?>
					<a class='info2' href="facturation.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&state=1<?php  if(isset($_GET['clt'])) echo '&clt='.$_GET['clt']; if(isset($_GET['mode'])) echo '&mode='.$_GET['mode']; if(isset($_GET['echeance'])) echo '&echeance='.$_GET['echeance'];  ?>" style='color:teal;'>
					<span style='font-size:0.9em;font-style:normal;color:teal;'>Visualiser la facture | Client : <?php  echo $NomClt; ?></span>	 <i class='fas fa-print' aria-hidden='true' style='font-size:140%;'></i></a>
					&nbsp;&nbsp;&nbsp;
					<a class='info' href="facturation.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&state=2<?php   if(isset($_GET['clt'])) echo '&clt='.$_GET['clt']; if(isset($_GET['mode'])) echo '&mode='.$_GET['mode']; if(isset($_GET['echeance'])) echo '&echeance='.$_GET['echeance'];  ?>" style='color:red;'>
					<span style='font-size:0.9em;font-style:normal;color:red;'>Facture normalisée | Client : <?php  echo $NomClt; ?></span>	 <i class='fas fa-print' aria-hidden='true' style='font-size:140%;'></i></a>
					<?php
					}
					else if(!empty($_GET['delete'])){ $_SESSION['delete']=$_GET['clt'];
							echo "<script language='javascript'>";
							echo 'swal("Cette action est irréversible. Voulez-vous continuer ?", {
							  dangerMode: true, buttons: true,
							}).then((value) => { var Es = value;  document.location.href="facturation.php?menuParent='.$_SESSION['menuParenT'].'&test="+Es;
							}); ';
							echo "</script>";
						}
					else
							if(!empty($_GET['valid'])){
									$clt=isset($_GET['clt'])?$_GET['clt']:NULL;
									$req="SELECT NomClt FROM clients WHERE Num='".$clt."'  AND Clients.Type='".$_SESSION['menuParenT1']."'";
									$reqsel=mysqli_query($con,$req);$NClient=mysqli_fetch_assoc($reqsel);
									//$clt=str_replace("_"," N°",$clt);
									$client=!empty($NClient['NomClt'])?$NClient['NomClt']:"Anonyme";
									echo "<script language='javascript'>";
									echo "var clt = '".$clt."';";echo "var client = '".$client."';";
									echo 'swal("Vous êtes sur le point de finaliser le processus de vente du client : "+client+". Ceci sous-entend un encaissement; par conséquent l\'établissement d\'une facture normalisée pour le client. Voulez-vous vraiment continuer ?", {
										dangerMode: true, buttons: true,
									}).then((value) => { var Es = value;  document.location.href="facturation.php?menuParent='.$_SESSION['menuParenT'].'&valider="+Es+"&clt="+clt;
									}); ';
									echo "</script>";
								}
					else {
						 if((mysqli_num_rows($resT)>0)&& isset($Numclt))
						 {
							 if(isset($_GET['dato'])){
							 $sqlA = "SELECT MAX(id_request) AS id_request FROM e_mecef";
							 $query = mysqli_query($con, $sqlA); $dataR=mysqli_fetch_object($query);
							 $id_request= $dataR->id_request;
						 	}

						 ?>
						 <a class='info2' href="facturation.php?menuParent=<?php echo $_SESSION['menuParenT']; if(isset($id_request)) echo "&id_request=".$id_request; ?>&visr=1<?php  if(isset($Numclt)) echo "&clt=".$Numclt; if(isset($_GET['clt'])) echo '&clt='.$_GET['clt']; if(isset($_GET['mode'])) echo '&mode='.$_GET['mode']; if(isset($_GET['echeance'])) echo '&echeance='.$_GET['echeance'];  ?>" style='color:purple;'>
						 <span style='font-size:0.9em;font-style:normal;color:purple;'>
						 <?php

						 if(!isset($_GET['dato'])) echo "Visualiser le ticket de caisse";
						 else echo "Ticket de caisse normalisé";
						  ?>
						  | Client :
						 <?php  echo $NomClt; ?></span>	 <i class='fas fa-print' aria-hidden='true' style='font-size:140%;'></i></a>
						 &nbsp;&nbsp;
						 <a class='info' href="facturation.php?menuParent=<?php echo $_SESSION['menuParenT']; if(isset($id_request)) echo "&id_request=".$id_request; ?>&vis=1<?php  if(isset($Numclt)) echo "&clt=".$Numclt; if(isset($_GET['clt'])) echo '&clt='.$_GET['clt']; if(isset($_GET['mode'])) echo '&mode='.$_GET['mode']; if(isset($_GET['echeance'])) echo '&echeance='.$_GET['echeance'];  ?>" style='color:maroon;'>
						 <span style='font-size:0.9em;font-style:normal;color:maroon;'>
						 <?php
						 if(!isset($_GET['dato'])) echo "Visualiser la Facture";
						 else echo "Facture normalisée";
						 ?>
						  | Client : <?php  echo $NomClt; ?></span>	 <i class='fas fa-file-pdf' aria-hidden='true' style='font-size:140%;'></i></a>
						 <?php
 					 		if(!isset($_GET['dato'])){
						 ?>
						 &nbsp;&nbsp;
						 <a class='info2' href='facturation.php?menuParent=<?php echo $_SESSION['menuParenT']; echo "&valid=1"; if(isset($Numclt)) echo "&clt=".$Numclt;  if(isset($_GET['mode'])) echo "&mode=".$_GET['mode']; if(isset($_GET['echeance'])) echo "&echeance=".$_GET['echeance'];?>'><span style='font-size:0.9em;font-style:normal;color:blue;'>Valider l'opération | Client : <?php  echo $NomClt; ?> </span> <i style='font-size:1.3em;color:blue;' class="far fa-calendar-check"></i></a>
						 &nbsp;&nbsp;
						 <a class='info' href='facturation.php?menuParent=<?php echo $_SESSION['menuParenT']; echo "&delete=1"; if(isset($Numclt)) echo "&clt=".$Numclt; ?>'><span style='font-size:0.9em;font-style:normal;color:red;'>Supprimer l'opération | Client : <?php  echo $NomClt; ?> </span> <i style='font-size:1.2em;color:red;' class='fa fa-trash-alt' aria-hidden='true'></i></a>
						<?php
							}
						}
					}
					?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="checkbox"  id="button_checkbox_2" onClick="verifyCheckBoxes2();"  name="button_checkbox_2"   <?php if(isset($idr)) echo "checked"; ?> onchange="document.forms['chgdept'].submit();"  value='1'>  <label for="button_checkbox_2" style='font-weight:bold;color:#444739;'>
					PRESTATION DE SERVICES</label> <span style='color:#BD8D46;'><?php if(isset($NPrestation)) echo "(".$NPrestation.")";  ?></span>
					</td>
					</tr>
					<tr>
						<td colspan='2'><hr />
						</td>
					</tr>
				<?php
					if(isset($idr)){

					}
					else {
			?>

				<tr>
							<td  style="padding-left:100px;" >
								Famille de Produits : </td>
								<td><select name='famille' style='font-family:sans-serif;font-size:0.9em;width:200px;' id='famille' onchange="document.forms['chgdept'].submit();">

								<?php
									mysqli_query($con,"SET NAMES 'utf8'");
									//$ret=mysqli_query($con,'SELECT Num,Designation FROM produits WHERE TypePrdts="1" AND Type LIKE "'.$_SESSION['menuParenT1'].'" ORDER BY Designation');
									if(!empty($idrx)){
										$sql=mysqli_query($con,"SELECT * FROM categorieproduit WHERE Num='".$idrx."' AND Type LIKE '".$_SESSION['module']."' ");
										$ret0=mysqli_fetch_assoc($sql);
										echo "<option value='".$ret0['Num']."'> ".$ret0['catPrd']." </option>";
									}
									else echo "<option value='Default'>  </option>";
											//	{
												$sql=mysqli_query($con,"SELECT * FROM categorieproduit WHERE Type LIKE '".$_SESSION['module']."' ");
												while ($ret0=mysqli_fetch_array($sql))
													{  	echo '<option value="'.$ret0['Num'].'">';
															echo($ret0['catPrd']);
															echo '</option>';
															echo '<option></option>';
													}
										//	}

									echo "</select>";

										mysqli_query($con,"SET NAMES 'utf8'");
										$sql='SELECT produits.Num,Designation FROM produits,categorieproduit WHERE categorieproduit.Num =produits.Famille AND categorieproduit.Num="'.$idrx.'" AND TypePrdts="1" AND produits.Type LIKE "'.$_SESSION['menuParenT1'].'" ORDER BY Designation';
										$ret=mysqli_query($con,$sql);
								?>

					</td>
				</tr>

				<tr>
					<td colspan='2'>&nbsp;&nbsp;
					</td>
				</tr>

					<tr>
						<td  style="padding-left:100px;" >
									D&eacute;signation du Produit : </td>
									<td><select name='produit' style='font-family:sans-serif;font-size:0.9em;width:200px;' id='produit'>
								    <option value='Default'>  </option>
									<?php
									if(!empty($idrx)){

									while ($ret1=mysqli_fetch_array($ret))
										{  	echo '<option value="'.$ret1['Num'].'">';
												echo($ret1['Designation']);
												echo '</option>';
												echo '<option></option>';
										}
									}

									?>
							      </select>
						</td>
					</tr>
					<?php
					}
					?>

					<?php if(isset($idr))
					{
					?>
					<tr>
						<td colspan='2'>&nbsp;&nbsp;
						</td>
					</tr>
					<tr>
						<td style="padding-left:100px;"> <?php echo "D&eacute;signation de la Prestation &nbsp;"; //else echo "&nbsp;du produit"; ?>: </td>
						<td ><input type="text" id="" name="produit" required='required' value="" style="width:200px;font-family:sans-serif;font-size:90%;"/> </td>
					</tr>
					<tr>
						<td colspan='2'>&nbsp;&nbsp;
						</td>
					</tr>
					<tr>
						<td style="padding-left:100px;"> <?php echo "Quantit&eacute à Facturer &nbsp;"; //else echo "&nbsp;du produit"; ?>: </td>
						<td ><input type="number" id="" name="qteVendue" id="qteVendue" min='1' style="width:200px;font-family:sans-serif;font-size:90%;border:1px solid black;" onkeypress='testChiffres(event);' placeholder='1'/> </td>
					</tr>
					<tr>
						<td colspan='2'>&nbsp;&nbsp;
						</td>
					</tr>
					 <tr>
						<td  style="padding-left:100px;"> Montant de la Prestation : <span style="font-style:italic;font-size:0.9em;color:#800000;"> </span> </td>
						<td ><input type="text" id="PrixVente" name="PrixVente" style="width:200px;font-size:0.9em;border:1px solid black;" required='required' placeholder ='<?php if(isset($devise)) echo $devise; ?>' onkeypress='testChiffres(event);'/> </td>
					</tr>
					<?php
					}else {
					?>
					<tr>
						<td colspan='2'>&nbsp;&nbsp;
						</td>
					</tr>

					<tr>
						<td  style="padding-left:100px;"> Quantit&eacute; en Stock : </td>
						<td ><input type="text" id="Qtestock" name="Qtestock" readonly value="<?php if(isset($quantite))  echo $quantite;?>" style="width:200px;font-size:0.9em;border:1px solid black;"/> </td>
					</tr>
					<tr>
						<td colspan='2'>&nbsp;&nbsp;
						</td>
					</tr>
					 <tr>
						<td  style="padding-left:100px;"> Prix de Vente : <span style="font-style:italic;font-size:0.8em;color:#800000;"> </span> </td>
						<td ><input type="text" id="PrixVente" name="PrixVente"  readonly style="width:200px;border:1px solid black;font-family:sans-serif;font-size:90%;" onkeypress='testChiffres(event);'/> </td>
					</tr><input type="hidden" id="PrixVente2" name="PrixVente2"  readonly style="width:200px;"'/>
					<tr>
						<td colspan='2'>&nbsp;&nbsp;
						</td>
					</tr>
					 <tr>
					 <td  style="padding-left:100px;"> Quantit&eacute;e à Vendre : </td>
						<td ><input type="number" id="" name="qteVendue" id="qteVendue" min='0.5' step='0.5' style="width:200px;font-family:sans-serif;font-size:90%;border:1px solid black;" placeholder='1' onkeypress='testChiffres(event);prix();' onchange='prix();'/> </td>
					</tr>
					<?php
					}
					?>
					<tr><td colspan='2'> <hr/> </td></tr>

						<tr><td colspan='2' align='center'>
						<span style="float:left;font-weight:normal;font-size:1em;color:#4C767A;font-style:italic;" >
						<?php echo "&nbsp;&nbsp;
						&nbsp;<a class='info4' href='facturation.php?menuParent=".$_SESSION['menuParenT']."&aj=1";   if(isset($_GET['clt'])) echo '&clt='.$_GET['clt']; if(isset($_GET['mode'])) echo '&mode='.$_GET['mode']; if(isset($_GET['echeance'])) echo '&echeance='.$_GET['echeance']; echo "' style='color:green;'><i class='fa fa-plus-square'></i><span style='color:teal;font-size:1em;'>Mode de règlement : ".$mode."</span></a>
						&nbsp;<a class='info4' href='facturation.php?menuParent=".$_SESSION['menuParenT']."&aj=2'";  if(isset($_GET['clt'])) echo '&clt='.$_GET['clt']; if(isset($_GET['mode'])) echo '&mode='.$_GET['mode']; if(isset($_GET['echeance'])) echo '&echeance='.$_GET['echeance']; echo "' style='color:orange;'><i class='fa fa-plus-square'></i><span style='color:teal;font-size:1em;'>Date d'échéance : ".$echeance."</span></a>
						&nbsp;<a class='info4' href='facturation.php?menuParent=".$_SESSION['menuParenT']."&aj=3' "; if(isset($_GET['clt'])) echo '&clt='.$_GET['clt']; if(isset($_GET['mode'])) echo '&mode='.$_GET['mode']; if(isset($_GET['echeance'])) echo '&echeance='.$_GET['echeance']; echo "' style='color:green;'><i class='fa fa-plus-square'></i><span style='color:teal;font-size:1em;'>Signature sur la facture</span></a>"; ?>
						</span>	<span style="font-weight:normal;font-size:1em;color:#4C767A;font-style:italic;" >
						<input type="submit" value="Enrégistrer" id="" class="bouton2"  name="Affecter" style=""/>&nbsp; &nbsp; &nbsp;
						<input type="reset" value="Annuler" class="bouton2"  name="Annuler" style=""/> </span></td>
					</tr>
					<tr><td> &nbsp; </td></tr>
				</table>
			 <?php
				}
			 ?>
		    </div>
			</form>
	</div>
</body>
	<script type="text/javascript">
	// fonction pour selectionner le tarif
		function action7(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						var mavariable = leselect.split('||');
/* 						if(!empty(mavariable[0])){
						document.getElementById('Qtestock').value = mavariable[0];
						document.getElementById('PrixVente').value = mavariable[1];
						}else { */
						document.getElementById('Qtestock').value = mavariable[1];
						document.getElementById('PrixVente').value = mavariable[2];
						document.getElementById('PrixVente2').value = mavariable[2];
						//}
					}
				}
				xhr.open("POST","InfoProduit.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('produit');
				//sel1 = document.getElementById('combo3');
				//sh1=sel1.options[sel1.selectedIndex].value;
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("numPdt="+sh);
		}

		var momoElement2 = document.getElementById("produit");
		if(momoElement2.addEventListener){
		  momoElement2.addEventListener("change", action7, false);

		}else if(momoElement2.attachEvent){
		  momoElement2.attachEvent("onchange", action7);

		}

		//fonction standard
		function getXhr(){
			xhr=null;
				if(window.XMLHttpRequest){
					xhr=new XMLHttpRequest();
				}
				else if(window.ActiveXObject){
					try {
			                xhr = new ActiveXObject("Msxml2.XMLHTTP");
			            } catch (e) {
			                xhr = new ActiveXObject("Microsoft.XMLHTTP");
			            }
				}
				else{
					alert("votre navigateur ne suporte pas les objets XMLHttpRequest");
				}
				return xhr;
			}
    </script>
</html>
