<?php
	require("config.php");
		// automatisation du numéro
		$numfiche = !empty($_GET['numfiche'])?$_GET['numfiche']:NULL;  $_SESSION['Visualiser']=0;  $_SESSION['pop']=1; //echo $_SESSION['periode'];

		$Numclt = !empty($_GET['Numclt'])?$_GET['Numclt']:NULL;  $sal = !empty($_GET['sal'])?$_GET['sal']:NULL;

		$pre_sql1="DELETE FROM fraisconnexe WHERE code =''";
		$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
			
		if(isset($_GET['modif'])|| isset($_GET['list'])|| isset($_GET['supp'])){


		}
		else {
		if(isset($_GET['codegrpe'])){
			$sql0="SELECT code_reel FROM groupe WHERE codegrpe='".trim($_GET['codegrpe'])."'";
			$req0 = mysqli_query($con,$sql0) or die (mysqli_error($con));
			$datap=mysqli_fetch_object($req0);
			$numfiche = isset($datap->code_reel)?$datap->code_reel:NULL;

			$Query1=mysqli_query($con,"SELECT MAX(Periode) AS Periode FROM fiche1 WHERE codegrpe LIKE '".$_GET['codegrpe']."'");
			$data1=mysqli_fetch_object($Query1); $data1->Periode;
			$_SESSION['periode']=isset($data1->Periode)?$data1->Periode:NULL;	//$numficheD=$data1->numfiche;

		}else {
			$Query1=mysqli_query($con,"SELECT Periode AS Periode FROM fiche1 WHERE numfiche='".$numfiche."'");
			$data1=mysqli_fetch_object($Query1); //$data1->Periode;
			$_SESSION['periode']=isset($data1->Periode)?$data1->Periode:NULL;
		}

		if(!empty($Numclt)){
			$sql="SELECT client.nomcli AS nom, client.prenomcli AS prenom FROM client WHERE (numcli='".$Numclt."' OR numcliS='".$Numclt."')";
			$req = mysqli_query($con,$sql) or die (mysqli_error($con));
			$dataT=mysqli_fetch_object($req); $Client=$dataT->nom." ".$dataT->prenom;
		}


		$delete = !empty($_GET['delete'])?$_GET['delete']:NULL;
		if(!empty($delete)){
		if(isset($_GET['codegrpe'])) {
		$sql3="SELECT numfiche FROM mensuel_fiche1 WHERE mensuel_fiche1.codegrpe='".$_GET['codegrpe']."' AND etatsortie='NON'";
		$req3 = mysqli_query($con,$sql3) or die (mysqli_error($con));
		//$u=1; $k=0;$ListeDesClients = array();
		while ($dataS= mysqli_fetch_array($req3))
			{
				$pre_sql1="DELETE FROM fraisconnexe WHERE numfiche LIKE '".$dataS['numfiche']."' AND Ferme ='NON'";
				$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
			}
		}

			$pre_sql1="DELETE FROM fraisconnexe WHERE numfiche LIKE '".$numfiche."' AND Ferme ='NON'";
			$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));

			echo "<script language='javascript'>";
			echo 'alert(" Suppression effectué avec succès");';
			//echo 'onclick="if(!confirm(\'Voulez-vous vraiment continuer?\')) return true;"';
			echo "</script>";
		}
	}
	if(isset($_POST['Valider']) && $_POST['Valider'] == "MODIFIER"){
		if(isset($_GET['modif'])|| isset($_GET['id']))
			{   $Prix=(int)($_POST['Prix']);
				$pre_sql1="UPDATE connexe SET NomFraisConnexe='".$_POST['designation']."',idcategorie='".$_POST['Categorie']."',PrixUnitaire='".$Prix."' WHERE id='".$_GET['id']."'";
				if(isset($_POST['Prix']))
					$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
				echo "<script language='javascript'>";
				echo 'alert("Modification du produit effectuée avec succès");';
				echo "</script>";
				echo "</script>"; $kxy=isset($_GET['vente'])?"vente=".$vente:NULL;
				$kxy.=isset($_GET['codegrpe'])?"codegrpe=".$_GET['codegrpe']:$kxy;
				$kxy.=isset($_GET['numfiche'])?"numfiche=".$_GET['numfiche']:$kxy;
				//echo '<meta http-equiv="refresh" content="0; url=popup.php?'.$kxy.'" />';
				echo "<script language='javascript'>";
					echo "window.opener.location.reload();";
					echo "window.close();";
				echo "</script>";
				
			}
		}
	if(isset($_POST['Valider']) && $_POST['Valider'] == "SUPPRIMER"){
		if(isset($_GET['supp'])|| isset($_GET['id']))
			{
				$pre_sql1="DELETE FROM connexe  WHERE id='".$_GET['id']."'";
				$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
				echo "<script language='javascript'>";
				echo 'alert("Suppresion effectuée avec succès");';
				echo "</script>"; $kxy=isset($_GET['vente'])?"vente=".$vente:NULL;
				$kxy.=isset($_GET['codegrpe'])?"codegrpe=".$_GET['codegrpe']:$kxy;
				$kxy.=isset($_GET['numfiche'])?"numfiche=".$_GET['numfiche']:$kxy;
				//echo '<meta http-equiv="refresh" content="0; url=popup.php?'.$kxy.'" />';
				echo "<script language='javascript'>";
					echo "window.opener.location.reload();";
					echo "window.close();";
				echo "</script>";
			}
			}
		if(isset($_POST['Valider']) && $_POST['Valider'] == "Valider")
		{ 	
					$Qte = !empty($_POST['Qte'])?$_POST['Qte']:1;
	
					$designation = explode("-",$_POST['designation']);	
					$designation0=isset($designation['0'])?$designation['0']:NULL;	
					//$designation1=isset($designation['1'])?$designation['1']:NULL;
					if(!isset($designation['1'])){
						$designation0=$designation0."%";
						$sql="SELECT * FROM connexe WHERE NomFraisConnexe LIKE '".$designation0."' AND idcategorie LIKE '".$_POST['Categorie']."'";
						$req0 = mysqli_query($con,$sql) or die (mysqli_error($con));
						$dataR=mysqli_fetch_object($req0);
						$designation0= isset($dataR->NomFraisConnexe)?$dataR->NomFraisConnexe:NULL;
						$designation00 = explode("-",$designation0);
						$designation0=isset($designation00['1'])?$designation00['1']:NULL;						
					}
					else 
						$designation0=$designation['1']; 
					
				if(empty($_POST['vente'])&& !isset($_POST['new']))
					{  	
					if(isset($_POST['ListeClients'])) $numfiche=$_POST['ListeClients'];
					$ListeClients=isset($_POST['ListeClients'])?$_POST['ListeClients']:"Client Divers";
				
					if(isset($_POST['sal']))
						{ if(isset($_POST['ListeClients']))
							  $sql3="SELECT numfiche,Periode FROM location WHERE (location.numfichegrpe='".$_POST['ListeClients']."' OR location.numfiche='".$_POST['ListeClients']."') AND etatsortie='NON'";
						}					
					else {if(isset($_POST['ListeClients'])) 
							$sql3="SELECT numfiche,Periode FROM mensuel_fiche1 WHERE (mensuel_fiche1.numfichegrpe='".$_POST['ListeClients']."' OR mensuel_fiche1.numfiche='".$_POST['ListeClients']."') AND etatsortie='NON'";
						}
						$req3 = mysqli_query($con,$sql3) or die (mysqli_error($con));
					$k=0;$ListeDesClients = array();
					while ($dataS= mysqli_fetch_array($req3))
						{  $ListeDesClients[$k]=$dataS['numfiche'];$k++;
						   $periode=$dataS['Periode'];;
						} 
						
					$periode=!empty($_SESSION['periode'])?$_SESSION['periode']:$periode;

					for($k=0;$k<count($ListeDesClients);$k++){
						$sql="SELECT * FROM fraisconnexe WHERE code LIKE '".$designation0."' AND numfiche LIKE '".$ListeDesClients[$k]."' AND Ferme ='NON'";
						$req = mysqli_query($con,$sql) or die (mysqli_error($con));
						if(mysqli_num_rows($req)>0){
							$dataT=mysqli_fetch_object($req);
							$Qte += $dataT->NbreUnites;
							$pre_sql1="UPDATE fraisconnexe SET NbreUnites = '".$Qte."',PrixUnitaire = '".$_POST['Prix']."' WHERE code LIKE '".$designation0."' AND numfiche LIKE '".$numfiche."' AND Ferme ='NON'";
							if(!isset($_GET['new'])) $req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));

						}else { $GrpeTaxation="E";  //Ici on suppose qu'on est en régime TPS par défaut
							$pre_sql1="INSERT INTO fraisconnexe VALUES(NULL,'".$ListeDesClients[$k]."','".$periode."','".ucfirst($designation0)."','".$Qte."','".$_POST['Prix']."','".$GrpeTaxation."','NON')";
							if(!isset($_GET['new'])) { if(isset($periode)) $req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));}
						}							
					}
					echo "<script language='javascript'>";
					echo 'alert(" Enrégistrement effectué avec succès");';
					echo "</script>";
			/* 		if(isset($_GET['new'])){
					$designation="%".$_POST['designation'];
				    $sql="SELECT * FROM connexe WHERE NomFraisConnexe LIKE '".$designation."' AND idcategorie LIKE '".$_POST['Categorie']."'";
					$req = mysqli_query($con,$sql) or die (mysqli_error($con));
					if(mysqli_num_rows($req)>0){
						echo "<script language='javascript'>";
						echo 'alert(" Ce produit a déjà été enrégistré");';
						echo "</script>";
					}
					else { $designation=$_POST['ident']."-".str_replace("-"," ",$_POST['designation']);
						$Prix=$_POST['Prix'];
						$pre_sql1="INSERT INTO connexe VALUES(NULL,'".$designation."','".$_POST['Categorie']."','".$Prix."')";
						if(isset($Prix)&&($Prix>0)) 
							$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
					}
					} */
				} 
				if(!empty($_POST['vente'])&& !isset($_GET['new'])) 
				{ $periode=1;  $groupe=NULL; $client = explode("-",$_POST['client']); $client=isset($client['0'])?$client['0']:$_POST['client'];				
						$sql="SELECT * FROM fraisconnexe WHERE numfiche LIKE '".$client."' AND Ferme ='NON'";
						$req = mysqli_query($con,$sql) or die (mysqli_error($con));	//$Mht=0; $Tva=0;
						if(mysqli_num_rows($req)==0){
							 $pre_sql1="INSERT INTO compte2 VALUES(NULL,'".$_POST['NumEnreg']."','".$client."','".$groupe."','0','0','".$Jour_actuel."')";
							$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));								
						}
						$sql="SELECT * FROM fraisconnexe WHERE code LIKE '".$designation0."' AND numfiche LIKE '".$client."' AND Ferme ='NON'";
							$req = mysqli_query($con,$sql) or die (mysqli_error($con));
							if(mysqli_num_rows($req)>0){
								$dataT=mysqli_fetch_object($req);
								$Qte += $dataT->NbreUnites;
								 $pre_sql1="UPDATE fraisconnexe SET NbreUnites = '".$Qte."',PrixUnitaire = '".$_POST['Prix']."' WHERE code LIKE '".$designation0."' AND numfiche LIKE '".$client."' AND Ferme ='NON'";
								if(!isset($_GET['new'])) $req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));

							}else { $GrpeTaxation="E";  //Ici on suppose qu'on est en régime TPS par défaut
																		
								$pre_sql1="INSERT INTO fraisconnexe VALUES(NULL,'".$client."','".$periode."','".ucfirst($designation0)."','".$Qte."','".$_POST['Prix']."','".$GrpeTaxation."','NON')";
								$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));									

							}						
							
						echo "<script language='javascript'>";
						echo 'alert(" Enrégistrement effectué avec succès");';
						echo "</script>";
				}
				
				if(isset($_GET['new'])){
					$designation="%".$_POST['designation'];
				    $sql="SELECT * FROM connexe WHERE NomFraisConnexe LIKE '".$designation."' AND idcategorie LIKE '".$_POST['Categorie']."'";
					$req = mysqli_query($con,$sql) or die (mysqli_error($con));
					if(mysqli_num_rows($req)>0){
						echo "<script language='javascript'>";
						echo 'alert(" Ce produit a déjà été enrégistré");';
						echo "</script>";
					}
					else { $designation=$_POST['ident']."-".str_replace("-"," ",$_POST['designation']);
						$Prix=$_POST['Prix'];
						$pre_sql1="INSERT INTO connexe VALUES(NULL,'".$designation."','".$_POST['Categorie']."','".$Prix."')";
						if(isset($Prix)&&($Prix>0)) 
							$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
						
						echo "<script language='javascript'>";
						echo 'alert(" Enrégistrement du produit effectué avec succès");';
						echo "</script>";
					}
					}

		}
		$s=mysqli_query($con,"SELECT id FROM categoriefconnexe ");
		$i=0;$totalRows_Recordset=mysqli_num_rows($s);
		while($ret1=mysqli_fetch_array($s))
		 {	$id[$i]=$ret1['id'];$i++;

		 }

$submit=!empty($submit)?$submit:NULL;

$idr  = isset($_POST['Categorie'])?$_POST['Categorie']:NULL;    
$idr  = isset($_GET['idr'])?$_GET['idr']:$idr;  
$_SESSION['idr'] = $idr;

$clientS  = isset($_POST['client'])?$_POST['client']:NULL;
$clientS  = isset($_GET['client'])?$_GET['client']:$clientS; 

if(isset($idr))
{	$sql="SELECT * FROM CategorieFconnexe WHERE id LIKE '".$idr."'";
	$req = mysqli_query($con,$sql) or die (mysqli_error($con));
	$dataT=mysqli_fetch_object($req);  //echo $dataT->Libcategorie;
}
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr"

	<head>
		<title><?php echo $title; ?></title>
<script type="text/javascript">

		window.addEventListener('beforeunload', function (e) {
			window.opener.location.reload();
			window.close();
		});
</script>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="css/bootstrap.min.js"></script>
		<script src="css/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script type="text/javascript" src="js/ajax.js"></script>
		<script type="text/javascript" src="js/ajax-dynamic-list3.js"></script>
		<script type="text/javascript" src="js/ajax-dynamic-list5.js"></script>
		<link href="css/customize.css" rel="stylesheet">
		<link rel="Stylesheet" href='css/table.css' />
		<style>

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
				/*border:1px solid; */
			}

			.bouton:hover
			{
				cursor:pointer;
			}

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
		.bouton13 {
			border:none;
			padding:6px 0 6px 0;
			border-radius:8px;
			background:#d34836;
			font:bold 13px Arial;
			color:#fff;
		}
		</style>
		<script type="text/javascript">
		function Aff55()
		{
			if ((document.getElementById("edit2").value!=''))
			{	document.getElementById("edit3").value=document.getElementById('edit2').value*document.getElementById('MontantUnites').value;
			}
		}
		function Aff54()
		{
			//if ((document.getElementById("edit3").value!='')&&(document.getElementById("MontantUnites").value!=0))
			{	//document.getElementById("edit3").value=52;
			}

				//function action6(event)  //A commenter pour avoir la réponse
				{
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit3').value = leselect;
						//document.getElementById("edit3").value=52;
					}
				}
				xhr.open("POST","others/prixP.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sh1 = document.getElementById('edit1').value;
				//sh1 = 1;
				//sh = sel.options[sel.selectedIndex].value;
				sh2= document.getElementById('edit2').value;
				//sh2=document.getElementById('edit2').options[document.getElementById('edit2').selectedIndex].value
				xhr.send("categorie="+sh1+"&designation="+sh2);
			}
		}

		var momoElement1 = document.getElementById("edit2");
		if(momoElement1.addEventListener){
		  momoElement1.addEventListener("onblur", action6, false);
		}else if(momoElement1.attachEvent){
		  momoElement1.attachEvent("onblur", action6);
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
	</head>
	 <?php
		//if($submit==TRUE) echo '<body onLoad="refreshParent()"  style="background-color:#84CECC;"> '; else echo '<body style="background-color:#84CECC;" >'
	 ?>
<div class="container" style='background-color:#84CECC;'>
	<div class="row"> <?php ?>
    <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3" style='margin-top:-1px;'>
			<?php
			 if(!isset($_GET['list'])) {										
													
 					echo "<h4 style='color:#FC7F3C;margin-top:-3px;text-align:left;'>";
 						echo "<a href='popup.php?list=1"; if(isset($_GET['numfiche'])) echo "&numfiche=".$_GET['numfiche'];  if(isset($_GET['Numclt'])) echo "&Numclt=".$_GET['Numclt']; if(isset($_GET['codegrpe'])) echo "&codegrpe=".$_GET['codegrpe']; if(isset($idr)) echo "&idr=".$idr; if(isset($_GET['sal'])) echo "&sal=".$_GET['sal']; if(isset($_GET['vente'])) echo "&vente=".$_GET['vente']; if(isset($_GET['client'])) echo "&client=".$_GET['client'];  echo "'><span style='color:maroon;font-size:1em;font-weight:bold;'><u>CONSULTER LA LISTE DES PRODUITS</u> </a>";
 						if(isset($idr)) //echo " du Client : <b>".$Client;
 								{echo " de la Catégorie : </span>";
									 if(isset($dataT->Libcategorie))
										echo $dataT->Libcategorie;
								}
 						echo "</h4>"; //$_GET['modif']

	//echo $sql3="SELECT numfiche,nomcli,prenomcli FROM client,mensuel_fiche1 WHERE mensuel_fiche1.codegrpe='".$_GET['codegrpe']."' AND mensuel_fiche1.numcli_1=client.numcli AND etatsortie='NON'";    $idr
 		?>
		<form method="post" action="popup.php<?php if(isset($_GET['supp'])) echo "?supp=".$_GET['supp']."&id=".$_GET['id']; if(isset($_GET['modif'])) echo "?modif=".$_GET['modif']."&id=".$_GET['id'];  if(isset($_GET['numfiche'])) echo "?numfiche=".$_GET['numfiche']; else if(isset($_GET['codegrpe'])) echo "?codegrpe=".$_GET['codegrpe']; if(isset($_GET['Numclt'])) echo "&Numclt=".$_GET['Numclt'];  if(isset($_GET['sal'])) echo "&sal=".$_GET['sal']; if(isset($_GET['new'])) echo "?new=".$_GET['new']; 
		if(isset($_GET['vente'])&& !isset($_GET['new']) && !isset($_GET['supp']) && !isset($_GET['modif'])) echo "?vente=".$_GET['vente']; 
		if(isset($_GET['vente'])&& (isset($_GET['new'])||isset($_GET['supp'])||isset($_GET['modif']))) echo "&vente=".$_GET['vente'];
		if(!empty($clientS)) echo "&client=".$clientS; echo '"';//onSubmit="refreshParent()" ?> id="chgdept">
		<?php
		if(isset($_GET['codegrpe'])){
		if(isset($_GET['sal']))
			$sql3="SELECT numfichegrpe,numfiche,nomcli,prenomcli FROM client,location WHERE location.codegrpe='".$_GET['codegrpe']."' AND (location.numcli=client.numcli OR location.numcli=client.numcliS) AND etatsortie='NON' ORDER BY nomcli ASC,prenomcli ASC";
		else 
			$sql3="SELECT numfichegrpe,numfiche,nomcli,prenomcli FROM client,mensuel_fiche1 WHERE mensuel_fiche1.codegrpe='".$_GET['codegrpe']."' AND mensuel_fiche1.numcli_1=client.numcli AND etatsortie='NON' ORDER BY nomcli ASC,prenomcli ASC";
		$req3 = mysqli_query($con,$sql3) or die (mysqli_error($con));
		$u=1; $k=0;$ListeDesClients = array();
		if(mysqli_num_rows($req3)>1) {
			echo "<select id='edit0' name='ListeClients' required='required'  style='width:250px;font-size:1.1em;' onchange='' >";
			while ($dataS= mysqli_fetch_array($req3))
				{  	$client=$u."-".$dataS['nomcli']." ".$dataS['prenomcli'];$u++;
					$ListeDesClients[$k]=$dataS['numfiche'];$k++;
					echo "<option value='".$dataS['numfiche']."'>".$client."</option>";
					echo "<option value=''></option>";
				}
					echo "<option value='".$numfiche."'><b>Tous les clients</b></option>";
			echo "</select>";
			}				
			else
				{   $sql3="SELECT code_reel FROM groupe WHERE codegrpe LIKE '".trim($_GET['codegrpe'])."' ";
					$req4 = mysqli_query($con,$sql3) or die (mysqli_error($con)); 
					$dataST= mysqli_fetch_object($req4);
					echo "<input type='hidden' name='ListeClients' id='ListeClients' value='";
					if(isset($dataST->code_reel)) echo $dataST->code_reel; 
					echo "' >";
				}
		}else {
			if(isset($_GET['numfiche']))
				echo "<input type='hidden' name='ListeClients' id='ListeClients' value='".$_GET['numfiche']."' >";
		}
		if(isset($_GET['id'])){
			//echo $Designation=12;
			$reqsel = mysqli_query($con,"SELECT * FROM categoriefconnexe,connexe WHERE categoriefconnexe.id=connexe.idcategorie AND connexe.id='".$_GET['id']."'");
			$dataT=mysqli_fetch_object($reqsel); $idr=isset($dataT->idcategorie)?$dataT->idcategorie:NULL;
		}
		if(isset($_GET['sal']))
			echo "<input type='hidden' name='sal' value='".$_GET['sal']."' >";
		?>
		<table align='center' style='margin-top:-4px;' border='1' width='550'>
		<input type='hidden' style='width:250px;font-size:1.3em;' name='vente'  placeholder='' <?php  if(isset($_GET['vente'])) echo "value='".$_GET['vente']."'";?> />
		 <?php
			if($totalRows_Recordset==0) echo "<center> Aucun frais connexe n'a été défini. Contacter l'administrateur</center>";
/* 			for($n=0;$n<$totalRows_Recordset;$n++)
				{ 	mysqli_query($con,"SET NAMES 'utf8'");
					 $query_Recordset1 = "SELECT * FROM connexe WHERE id='".$id[$n]."'";
					 $Recordset_2 = mysqli_query($con,$query_Recordset1);
					 $nbre = mysqli_num_rows($Recordset_2);
					   if($nbre>0)
					   { 	while($ret1=mysqli_fetch_array($Recordset_2))
								{$MontantUnites =$ret1['MontantUnites'];
								 $NomFraisConnexe =$ret1['NomFraisConnexe'];$petitNom =!empty($ret1['petitNom'])?$ret1['petitNom']:NULL; */

					   echo "	<tr>
									<td>
										<fieldset>
											<legend align='center' style='color:#2F574D;'>
											<a class='info1' id='FraisC'  style='text-decoration:none;' title='Ajouter des frais Connexes' href='popup.php?new=1"; if(isset($_GET['vente'])) echo "&vente=".$_GET['vente']; echo "'>
											<img src='logo/plus.png' alt='' title='Nouveau produit' width='25' height='25' style='margin-top:0px;float:left;' border='0'><span style='font-size:1em;' >
											</span></a> 
											<b>";
											if(isset($_GET['new'])){
												echo "CREATION D'UN NOUVEAU PRODUIT";
											}
											else if(isset($_GET['supp'])){
												echo "SUPPRESSION D'UN PRODUIT";
											}
											else{
												if(isset($_GET['vente'])){
													echo "VENTE DE PRODUITS";
												}
												else if(!isset($_GET['id'])) {echo "FRAIS CONNEXES LIES A";
												if(isset($sal)) echo " LA LOCATION"; else echo " L'HEBERGEMENT";
												} else {
													if(!isset($_GET['supp']))
														echo "MODIFICATION SUR LE PRODUIT";
													else
														echo "SUPPRESSION DU PRODUIT";
												}
											}
											echo "</b></legend>
											<table style='font-size:1.1em;'>";
													if(isset($_GET['new'])){  
													
														$sql0="SELECT MAX(id) AS maximum FROM connexe ";
														$req0 = mysqli_query($con,$sql0) or die (mysqli_error($con));
														$dataR=mysqli_fetch_object($req0);														
														$ident=1+$dataR->maximum;
														if(($ident>=0)&&($ident<=9))$ident = '00'.$ident ; if(($ident>=10)&&($ident <=99))$ident ='0'.$ident ;//else $ident = $ident ;
												echo "<tr>
														<td style='font-size:1.2em;'> Identifiant : </td>
														<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' readonly style='width:250px;' name='ident'";  
														 echo "value='".$ident."'"; echo "/> </td>
													</tr>";
													}
													if(!isset($_GET['new'])&& isset($_GET['vente'])){ 	 
													
														$sql0="SELECT MAX(id) AS maximum FROM compte2 ";
														$req0 = mysqli_query($con,$sql0) or die (mysqli_error($con));
														$dataR=mysqli_fetch_object($req0);	//$ident="FV";													
														$ident=1+$dataR->maximum;
														if(($ident>=0)&&($ident<=9))$ident = 'FV000'.$ident ; if(($ident>=10)&&($ident <=99))$ident ='FV00'.$ident ;
														
														echo "<input type='hidden' style='width:250px;font-size:1.3em;' name='NumEnreg'  placeholder='' value='".$ident."' />";
													
													if(!isset($_GET['modif'])&& !(isset($_GET['supp']))){ 	
													?>											

													<tr>
														<td style='font-size:1.2em;'> Nom du client : </td>  
															
																														
														<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' style='width:250px;font-size:1.3em;' required='required' name='client'  placeholder='Identification du client' <?php  if(isset($_GET['client'])) $clientS=$_GET['client'] ; echo "value='".$clientS."'";?>
														
														autocomplete='OFF' onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" onchange="ajax_showOptions(this,'getCountriesByLetters',event)"/> </td>
													</tr>
													<?php 
													}													
													}
												echo "<tr>
													<td style='font-size:1.2em;'> Catégorie : </td>
													<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
													if(isset($_GET['supp'])) {
													 echo "<input type='text' style='width:250px;font-size:1.3em;'  name='Categorie'  readonly value='"; if(isset($dataT->Libcategorie)) echo $dataT->Libcategorie; echo "' />";	
													}else {
													?>
													<select id='edit1' name='Categorie' required='required'  style='width:250px;font-size:1.3em;' <?php if(!isset($_GET['id'])&&(!isset($_GET['new'])))  { ?>onchange="document.forms['chgdept'].submit();" <?php } ?> >
													<?php
													if(isset($dataT->Libcategorie))
														echo "<option value='".$idr."'>".$dataT->Libcategorie."</option>";
													else
														echo "<option value='*'></option>";?>
													<?php
														$req = mysqli_query($con,"SELECT * FROM CategorieFconnexe") or die (mysqli_error($con));
													while($data=mysqli_fetch_array($req))
													{    //$t++; if($t==1)
														echo "<option value=''> </option>";
														if(isset($data['id'])) echo "<option value='".$data['id']."'>".$data['Libcategorie']."</option>";
													}
													echo "</select>";
													}
													echo "</td>
												</tr>
												<tr>
													<td style='font-size:1.2em;'> Désignation  : </td>
													<input type='hidden' name='numfiche'";	echo " />
													<input type='hidden' name='MontantUnites' id='MontantUnites' value='' />
													<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";?>
													<input type='hidden' id='' style='width:250px;font-size:1.3em;' <?php if(isset($dataT->id)) echo "value='".$dataT->id."'"; ?>name='idM'  />													
													
													<input type='text' <?php if(isset($_GET['new'])) echo "placeholder='Désignation du produit'"; else echo "placeholder='Identifiant du produit'";?> id='edit2' style='width:250px;font-size:1.3em;' name='designation'  <?php if(isset($dataT->NomFraisConnexe)) echo "value='".$dataT->NomFraisConnexe."'"; ?> autocomplete='OFF' onblur='Aff54();' value='' required='required' />
												<?php
												echo "</td>
												</tr>
												<tr>
													<td style='font-size:1.2em;'> Prix Unitaire : </td>
													<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' style='width:250px;text-align:left;' name='Prix' required id='edit3'"; if(isset($dataT->PrixUnitaire)) echo "value='".$dataT->PrixUnitaire."'";  echo "autocomplete='OFF' onkeypress='testChiffres(event);'  /> </td>
												</tr>";
												if(!isset($_GET['id'])&& (!isset($_GET['new']))){
												echo "<tr>
														<td style='font-size:1.2em;'> Quantité à Facturer: </td>
														<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='number' style='width:250px;' name='Qte' placeholder='1' value='' onkeypress='testChiffres(event);' min='1' /> </td>
													</tr>";
													}
											echo "
											</table>
										</fieldset>
									</td>
								</tr> <br/> ";
							//	}
					   //}
				 //}
				    ?>
				</table>
				<div align='center'><br/>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<input class='bouton5' type="submit" name="Valider" <?php if(isset($_GET['modif'])) echo 'value="MODIFIER"'; else if(isset($_GET['supp'])) { echo 'value="SUPPRIMER"';   echo 'onclick="if(!confirm(\'Voulez-vous vraiment continuer?\')) return false;"';}   else echo 'value="Valider"';   ?> style='font-size:1.2em;'/>
				</div><br/>
			<a class='' href='popup.php?delete=1  <?php if(isset($_GET['numfiche'])) echo "&numfiche=".$_GET['numfiche']; if(isset($_GET['codegrpe'])) echo "&codegrpe=".$_GET['codegrpe']; ?>' title='TOUT REINITIALISER' style='color:red;text-decoration:none;font-weight:bold;'>

			<?php
			if(!isset($_GET['id'])){
				$trouver=0;
				 $sql0="SELECT * FROM fraisconnexe WHERE Ferme ='NON' AND numfiche='".$numfiche."'";
				$req0 = mysqli_query($con,$sql0) or die (mysqli_error($con));
				if(mysqli_num_rows($req0)>0) $trouver=1;
				else if(isset($_GET['codegrpe'])){					
					if(isset($_GET['sal']))
						$sql3="SELECT numfiche FROM location WHERE trim(location.(codegrpe) ='".trim($_GET['codegrpe'])."'  AND etatsortie='NON'";
					else 
						$sql3="SELECT numfiche FROM mensuel_fiche1 WHERE trim(mensuel_fiche1.codegrpe)='".trim($_GET['codegrpe'])."' AND etatsortie='NON'";
					$req3 = mysqli_query($con,$sql3) or die (mysqli_error($con));
					$k=0;$ListeDesClients = array();
					while ($dataS= mysqli_fetch_array($req3))
						{ $ListeDesClients[$k]=$dataS['numfiche'];$k++;
						}			
						
					for($k=0;$k<count($ListeDesClients);$k++){
						$sql0="SELECT * FROM fraisconnexe WHERE Ferme ='NON' AND numfiche='".$ListeDesClients[$k]."'";
						$req0 = mysqli_query($con,$sql0) or die (mysqli_error($con));
						if(mysqli_num_rows($req0)>0) { $trouver=1; break; }
					}
				}else { }
				if(($trouver==1)&&(!isset($_GET['vente']))){
				echo "<span style='color:#FC7F3C;'>
				<img src='logo/Change.png' alt='' title='' width='20' height='20' style='' border='0'>";
					echo "<span style='color:red;font-size:1em;'>REINITIALISER </a>[Tous les Frais Connexes liés à l'hébergement ";
					if(isset($Client)) echo " du Client : <b>".$Client;
					if(isset($_GET['codegrpe'])) echo " du groupe : <b>".$_GET['codegrpe'];
					echo "</b>]</span>
				</span>";
				}
			}
			?>

			</form>
         </div>
				 <?php
			 } else {
				 if(isset($_GET['idr'])&& ($_GET['idr']!="*")){
					$reqsel = mysqli_query($con,"SELECT * FROM categoriefconnexe,connexe WHERE categoriefconnexe.id=connexe.idcategorie AND categoriefconnexe.id='".$_GET['idr']."' ORDER BY connexe.id ASC");
					$sql="SELECT * FROM CategorieFconnexe WHERE id LIKE '".$_GET['idr']."'";
				    $req = mysqli_query($con,$sql) or die (mysqli_error($con));
					$dataT=mysqli_fetch_object($req); 
					}
				 else
					$reqsel = mysqli_query($con,"SELECT * FROM categoriefconnexe,connexe WHERE categoriefconnexe.id=connexe.idcategorie ORDER BY connexe.id ASC");

				?>
				 <table align='center' width="100%" height="100%" border="0" cellspacing="0" style="margin-top:-50px;">
				 					<tr><td colspan='5'>
				 					<h4 style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:2px;color:#444739;"> <span style='font-weight:bold;font-size:1.5em;'><a href='popup.php
									<?php if(isset($_GET['numfiche'])) echo "?numfiche=".$_GET['numfiche']; else if(isset($_GET['codegrpe'])) echo "?codegrpe=".$_GET['codegrpe'];
									if(isset($_GET['Numclt'])) echo "&Numclt=".$_GET['Numclt']; if(isset($_GET['idr'])) {
									if(isset($_GET['vente'])) echo "?idr=".$_GET['idr']; 
									else echo "&idr=".$_GET['idr'];}if(isset($_GET['sal'])) echo "&sal=".$_GET['sal']; 
									if(isset($_GET['vente'])) { if(!isset($_GET['sal'])&& !isset($_GET['numfiche']) && !isset($_GET['idr'])) echo "?vente=".$_GET['vente'];
									else echo "&vente=".$_GET['vente']; } if(!empty($clientS)) echo "&client=".$clientS;
									//if(isset($_GET['client'])) echo $_GET['client'];
									?> ' style='color:red;' title='Revenir au Formulaire'><<<</a><span> Liste des produits <?=isset($dataT->Libcategorie)?" de la Catégorie : ".$dataT->Libcategorie:NULL;  ?> </h4>

									</td></tr>
				 					<tr style=" background-color:#3EB27B;color:white; padding-bottom:5px;">
				 						<td style="font-size:15px;border-right: 2px solid #ffffff" align="center" >N° </td>
				 						<td style="font-size:15px;border-right: 2px solid #ffffff" align="center" ><a class='info1' href='popup.php' style='text-decoration:none;color:white;' title=''>Catégorie</a></td>
				 						<td style="font-size:15px;border-right: 2px solid #ffffff" align="center" ><a class='info1' href='popup.php' style='text-decoration:none;color:white;' title=''>id - Désignation</a></td>
				 						<td style="font-size:15px;border-right: 2px solid #ffffff" align="center"><a class='info1' href='popup.php' style='text-decoration:none;color:white;' title=''>Prix Unitaire</a></td>
				 						<td align="center" >Actions</td>
				 					</tr>
				 					<?php
				 							$cpteur=1;$i=0;
				 							while($data=mysqli_fetch_array($reqsel))
				 							{ $i++;
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
												
												$NomFraisConnexe = explode("-",$data['NomFraisConnexe']);
												$ident=$NomFraisConnexe['0'];
												if(isset($NomFraisConnexe['1'])) $NomFraisConnexe=$NomFraisConnexe['1']; else $NomFraisConnexe="";
												//if(isset($NomFraisConnexe['2'])) $NomFraisConnexe.="-".$NomFraisConnexe['2'];
												//$NomFraisConnexe=isset($NomFraisConnexe['1'])?$NomFraisConnexe['1']:NULL;
												//$NomFraisConnexe=isset($NomFraisConnexe['2'])?$NomFraisConnexe['2']:$NomFraisConnexe;
												//$NomFraisConnexe=isset($NomFraisConnexe['3'])?$NomFraisConnexe['3']:$NomFraisConnexe;				
				
				 								echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>";
				 								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;font-size:15px;'>".$i.".</td>";
				 										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;font-size:15px;'>&nbsp;&nbsp;<a href='#' class='info' style='cursor:default;text-decoration:none;color:black;' title='' alt='' >".$data['Libcategorie']."</a></td>";
				 										echo " 	<td align='left' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;font-size:15px;' ><a href='#' class='info' style='cursor:default;text-decoration:none;color:black;' title='' alt='' >&nbsp;&nbsp;&nbsp;<span style='color:red;'>".$ident." </span><span style='color:black;'>-".$NomFraisConnexe."</span></a></td>";
				 										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;font-size:15px;'><a href='#' class='info' style='cursor:default;text-decoration:none;color:black;' title='' alt='' >".$data['PrixUnitaire']."</a></td>";
				 										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
				 										echo " 	<a class='info2' href='popup.php?modif=ok&"; echo "id=".$data['id']; if(isset($_GET['vente'])) echo "&vente=".$_GET['vente']; //if(isset($_GET['numfiche'])) echo "&numfiche=".$_GET['numfiche']; if(isset($_GET['codegrpe'])) echo "&codegrpe=".$_GET['codegrpe'];
														echo "'><img src='../logo/b_edit.png' alt='' title='Modifier' width='16' height='16' border='0'><span style='font-size:0.8em;'></span></a>";
				 										echo " 	&nbsp;&nbsp;&nbsp;";
				 										echo " 	<a class='info2' href='popup.php?supp=ok"; echo "&id=".$data['id']; if(isset($_GET['vente'])) echo "&vente=".$_GET['vente']; echo "'><img src='../logo/b_drop.png' alt='' title='Supprimer' width='16' height='16' border='0'><span style='font-size:0.8em;'></span></a>";
				 										echo " 	</td>";
				 								echo " 	</tr></a> ";
				 							}
				 					?>
				 				</table>
				 <?php
			 		}
				 ?>
      </div>
	</div>
	</body>
</html>
<?php
			//include ("footer.inc.php");
?>
