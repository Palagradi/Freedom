<?php
include_once 'menu.php';
		$_SESSION['avance']='';
		$_SESSION['Nuite_sal']='';
		$_SESSION['somme']='';   $numresch= isset($_SESSION['re'])?$_SESSION['re']:NULL;
		$_SESSION['num']='';$_SESSION['num_ch']='';$_SESSION['exhonerer']='';$_SESSION['total_salle']=0;
		$test = "DELETE FROM chambre_tempon";
	$reqsup = mysqli_query($con,$test) or die(mysqli_error($con));
		include 'connexion.php';
	mysqli_query($con,"SET NAMES 'utf8'");
		$reqsel=mysqli_query($con,"SELECT * FROM configuration_facture");
			while($data=mysqli_fetch_array($reqsel))
				{  $num_fact=$data['num_fact'];
				   $etat_facture=$data['etat_facture'];
				   $initial_grpe=$data['initial_grpe'];
				   $initial_reserv=$data['initial_reserv'];
				   $initial_fiche=$data['initial_fiche'];
				   $Nbre_char=$data['Nbre_char'];
				   $num_fiche=$data['fiche_salle']+1;
				}
			if(empty($initial_fiche))
			{/* $reqsel=mysqli_query($con,"SELECT max(fiche_salle) AS numfiche FROM Location");
			while($data=mysqli_fetch_array($reqsel))
				{   $num_fiche=$data['numfiche']+1;
				} */
			}
			$reqsel=mysqli_query($con,"SELECT numfiche FROM fiche1 WHERE numfiche='1000'");
			while($data=mysqli_fetch_array($reqsel))
				{  $num_fiche1=$data['numfiche'];
				}
			$nbre1=mysqli_num_rows($reqsel);
	// automatisation du numéro
/* 	function random($car,$initial_fiche) {
		$string = $initial_fiche;
		$chaine = "0123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
		}
		return $string;
		} */
		$val="Jour";
		$se5="Mois";
		$se6="Année";
		$combo2="- Choix de l'Etat civil-";
		$edit9="";
		$edit17="";
			if(!empty($_GET['numcli']))
				$reqsel=mysqli_query($con,"SELECT * FROM client WHERE numcli ='".$_GET['numcli']."' ");
	//echo ("SELECT * FROM client WHERE numcli ='".$_GET['numcli']."' ");
		while($data=mysqli_fetch_array($reqsel))
			{  $rlt1=$data['numcli'];  $rlt2=$data['nomcli'];  $rlt3=$data['prenomcli'];  $rlt4=$data['sexe'];
			   $rlt5=$data['datnaiss'];  $rlt6=$data['lieunaiss']; $rlt8=$data['typepiece'];  $rlt9=$data['numiden'];
			   $rlt10=$data['date_livrais']; $rlt11=$data['lieudeliv']; $rlt12=$data['institutiondeliv']; $rlt13=$data['pays']; $rlt14=$data['adresse'];
			}

	//enregistrement de la fiche
	if (isset($_POST['ok'])&& $_POST['ok']=='VALIDER')
		{ 			
			$etat='RAS';
			$p1=addslashes($_POST['edit1']);$p2=addslashes($_POST['edit2']);$motif=addslashes($_POST['edit17']);$Tedit2=$_POST['Tedit2'];
			if(isset($_POST['change'])&&(!empty($_POST['change'])))
				{   $pre="SET numcli='".$p2."',motifsejoiur='".$motif."' WHERE numfiche='".$p1."'";
						//echo "UPDATE location ".$pre;
						$update=mysqli_query($con,"UPDATE location ".$pre ); 

				if ($update)
							{
								header('location:loccup.php?menuParent=Consultation&sal=1');
							}
				}else{							
						
			$Recordset=mysqli_query($con,"SELECT * FROM groupe WHERE codegrpe='".trim($_POST['groupe'])."'");
			$nbreR=mysqli_num_rows($Recordset);
			$dataT=mysqli_fetch_object($Recordset);
			$code_reel= isset($dataT->code_reel)?$dataT->code_reel:NULL;	
			//$NumFact=NumeroFacture($data->num_fact); 
			if(($nbreR>0)|| empty($_POST['groupe']))
			{ 
			$p2=addslashes($_POST['edit2']);
			if(empty($_POST['groupe']))
				{
					$Query1=mysqli_query($con,"SELECT MAX(Periode) AS Periode FROM location WHERE numcli='".$p2."' AND codegrpe=''");
					$data1=mysqli_fetch_object($Query1); $data1->Periode;
					$periode=isset($data1->Periode)?(1+$data1->Periode):1;
				}
			else 
				{
					$Query1=mysqli_query($con,"SELECT Periode FROM location WHERE codegrpe='".trim($_POST['groupe'])."' AND etatsortie='NON'");
					$data1=mysqli_fetch_object($Query1); 
					if(isset($data1->Periode))
					$periode=$data1->Periode;		 //Là on n'incrémente pas. Les clients sont entrées ensemble.
					else {
					$Query1=mysqli_query($con,"SELECT MAX(Periode) AS Periode,etatsortie FROM location WHERE codegrpe='".trim($_POST['groupe'])."' AND codegrpe <>''");
					$data1=mysqli_fetch_object($Query1); $data1->Periode; 
					$periode=isset($data1->Periode)?(1+$data1->Periode):1;
					}
				}
							
							
			$date1=$Jour_actuel;//$date2=substr($_POST['ladate'],6,4).'-'.substr($_POST['ladate'],3,2).'-'.substr($_POST['ladate'],0,2);
			$date2=$_POST['ladate'];
			$sql="SELECT DATEDIFF('".$date2."','".$date1."') AS DiffDate";
			$exec=mysqli_query($con,$sql);
			$row_Recordset1 = mysqli_fetch_assoc($exec);
			$row_Recordset=$row_Recordset1['DiffDate'];
			if($row_Recordset>=0)
			{  $_SESSION['Nuite_sal']= $row_Recordset+1;
			//else
			// $_SESSION['Nuite_sal']=1;
		    if($_POST['nui']>15) {
                		$_SESSION['num']=$_POST['edit1']; $grpe=$_POST['groupe'];$_SESSION['nbre']=$_POST['edit2_2'];
						if($_SESSION['nbre']=='')$_SESSION['nbre']=1;$_SESSION['nbre2']=1;
						if($grpe!='') $_SESSION['cli']=$grpe; else $_SESSION['cli']=$_POST['edit3'].' '.$_POST['edit4'];
			if (isset($_SESSION['num']) && !empty($_SESSION['num']))
				{//vérification d'unicité de numéro de fiche
					$Recordset1=mysqli_query($con,"SELECT * FROM location WHERE numfiche='".$_SESSION['num']."'");
					if (!$Recordset1)
					{ 		mysqli_query($con,"SET NAMES 'utf8' ");
						//vérifivation de disponibilité de chambre
							$datdeliv=$_POST['se3'].'-'.$_POST['se2'].'-'.$_POST['se1'];

							$datdep=$_POST['ladate']; //$datarriv=$_POST['edit_2'];  
							$datarriv=$Jour_actuel;
							
							
							//$sql="SELECT code_reel FROM groupe WHERE codegrpe LIKE '".$grpe."'";
							//$req = mysqli_query($con,$sql) or die (mysqli_error($con));
							//$dataT=mysqli_fetch_object($req);
							//$code_reel= $dataT->code_reel;						

							$etat='RAS';
							$p1=addslashes($_POST['edit1']);$p2=addslashes($_POST['edit2']);$p3=addslashes($_POST['combo2']);$p4=addslashes($_POST['edit9']);$p5=addslashes($_POST['edit10']);
							$p6=addslashes($_POST['edit11']);$p7=addslashes($_POST['edit12']);$p8=addslashes($_POST['edit_9']);$p9=addslashes($_POST['edit_13']);$p10=addslashes($_POST['edit_14']);
							$p11=addslashes($_POST['edit_15']);$p12=addslashes($_POST['edit_16']);$p17=addslashes($_POST['edit17']);$p18=addslashes($_POST['edit19']);$p18=addslashes($_POST['edit21']);
							$ret="INSERT INTO location VALUES('$p1','".$code_reel."','$p2','".$periode."','','$p3','$p4','0','$p17','".$datarriv."','".$datarriv."','','$datdep','$datdep','".$Heure_actuelle."','','',
								'".$etat."','".$numresch."','','".$_SESSION['login']."','".$_SESSION['login']."','".$_SESSION['Nuite']."','OUI','')";
							$req=mysqli_query($con,$ret);
							if ($req)
							{// header('location:occup.php');
							}

				    }

				}
				header('location:avertissement.php?menuParent=Location');	}
		     else if ($_POST['nui']<15)
			   {     if (empty($_POST['edit_03'])){
						$grpe=$_POST['groupe'];$_SESSION['nbre']=$_POST['edit2_2'];	if($_SESSION['nbre']=='') $_SESSION['nbre']=1; $_SESSION['nbre2']=1;
                		$_SESSION['num']=$_POST['edit1'];
						if($grpe!='') $_SESSION['cli']=$grpe; else $_SESSION['cli']=$_POST['edit3'].' '.$_POST['edit4'];
			if (isset($_SESSION['num']) && !empty($_SESSION['num']))
				{	//vérification d'unicité de numéro de fiche
					$Recordset1=mysqli_query($con,"SELECT * FORM location WHERE numfiche='".$_SESSION['num']."'");
					if (!$Recordset1)
					{  	mysqli_query($con,"SET NAMES 'utf8' ");
						//vérification de disponibilité de chambre
							if(isset($_POST['se1'])&&isset($_POST['se2'])&&isset($_POST['se3']))
							$datdeliv=$_POST['se3'].'-'.$_POST['se2'].'-'.$_POST['se1'];
							$datdep=$_POST['ladate']; //$datarriv=$_POST['edit_2'];
							$datarriv=$Jour_actuel;
							//$datarriv=substr($_POST['edit_2'],6,4).'-'.substr($_POST['edit_2'],3,2).'-'.substr($_POST['edit_2'],0,2)	;
							//$datdep=substr($_POST['ladate'],6,4).'-'.substr($_POST['ladate'],3,2).'-'.substr($_POST['ladate'],0,2)	;
							$etat='NON'; $combo2=!empty($_POST['combo2'])?$_POST['combo2']:NULL; $edit9=!empty($_POST['edit9'])?$_POST['edit9']:NULL; $edit21=!empty($_POST['edit21'])?$_POST['edit21']:NULL;
							$edit10=!empty($_POST['edit10'])?$_POST['edit10']:NULL;$edit11=!empty($_POST['edit11'])?$_POST['edit11']:NULL;$edit19=!empty($_POST['edit19'])?$_POST['edit19']:NULL;
							$p1=addslashes($_POST['edit1']);$p2=addslashes($_POST['edit2']);$p2=trim($p2);$p3=addslashes($combo2);$p4=addslashes($edit9);$p5=addslashes($edit10);
							$p6=addslashes($edit11);$p7=addslashes($_POST['edit12']);$p8=addslashes($_POST['edit_9']);$p9=addslashes($_POST['edit_13']);$p10=addslashes($_POST['edit_14']);
							$nomPrenoms=addslashes(trim($_POST['edit3'])).";".addslashes(trim($_POST['edit4']));
							$p11=addslashes($_POST['edit_15']);$p12=addslashes($_POST['edit_16']);$p17=addslashes($_POST['edit17']);$p18=addslashes($edit19);$p18=addslashes($edit21);
							
							if(empty($p2)){
								$numclientS=$Tedit2;
								$req1=mysqli_query($con,"SELECT numcliS,numcli FROM client WHERE nomcli LIKE '".addslashes(trim($_POST['edit3']))."' AND prenomcli LIKE '".addslashes(trim($_POST['edit4']))."'");
								if(mysqli_num_rows($req1)>0)
								{	$req2=mysqli_fetch_object($req1);
									$p2=!empty($req2->numcli)?$req2->numcli:$req2->numcliS;
								}else {
									$ret="INSERT INTO client VALUES('',0,'".addslashes(trim($_POST['edit3']))."','".addslashes(trim($_POST['edit4']))."','','','','','','','','','".date('Y-m-d')."','','','".$p7."','','','','".$numclientS."')";
									$req=mysqli_query($con,$ret);
									$ret="INSERT INTO view_client VALUES('',0,'".addslashes(trim($_POST['edit3']))."','".addslashes(trim($_POST['edit4']))."','','','','','','','','','".date('Y-m-d')."','','','".$p7."','','','','".$numclientS."')";
									$req=mysqli_query($con,$ret);	
									$update=mysqli_query($con,"UPDATE configuration_facture SET numclientS=numclientS+1");
									$p2=$numclientS;								
								}							
							}else $numclientS=NULL;						
							//echo "<br/>".
							$ret="INSERT INTO location VALUES('$p1','".$code_reel."','$p2','".$periode."','$grpe','$p3','$p4','$p5','0','$p17','".$datarriv."','".$datarriv."','','$datdep','$datdep','".$Heure_actuelle."','','',
							'".$etat."','".$numresch."','','".$_SESSION['login']."','".$_SESSION['login']."','1','NON')";
							$req=mysqli_query($con,$ret);
							if ($req)
							{ header('location:occupSal.php?menuParent=Location');
							}
					 $update=mysqli_query($con,"UPDATE configuration_facture SET fiche_salle=fiche_salle+1");
					}

				}
                 }     else	{  $_SESSION['avance_03']=$_POST['edit_03'];
				           header('location:occup_03.php?menuParent=Location');}
				}
			    else
				header('location:warning_date.php?menuParent=Location');
	}else	echo "<script language='javascript'>alert('La date de départ doit être supérieure à la date du jour'); </script>";
	}else {
		echo "<script language='javascript'>";
		echo 'alertify.error("Désolé. Le groupe que vous avez renseigné n\'existe pas. Veuillez procéder à l\'enregistrement. ");';
		echo "</script>";
		echo '<meta http-equiv="refresh" content="2; url=group.php?menuParent=Fichier" />';
	}
}
}

$etat_2=!empty($etat_2)?$etat_2:NULL; $etat1=!empty($etat1)?$etat1:NULL; $etat2=!empty($etat2)?$etat2:NULL; $rlt_2=!empty($rlt_2)?$rlt_2:NULL;  $rlt_3=!empty($rlt_3)?$rlt_3:NULL; $edit_9=!empty($edit_9)?$edit_9:NULL;
$edit2=!empty($edit2)?$edit2:NULL; $edit3=!empty($edit3)?$edit3:NULL; $edit4=!empty($edit4)?$edit4:NULL; $edit5=!empty($edit5)?$edit5:NULL; $edit6=!empty($edit6)?$edit6:NULL; $edit7=!empty($edit7)?$edit7:NULL;$edit_16=!empty($edit_16)?$edit_16:NULL;
$edit8=!empty($edit8)?$edit8:NULL; $edit10=!empty($edit10)?$edit10:NULL;  $edit12=!empty($edit12)?$edit12:NULL;$edit13=!empty($edit13)?$edit13:NULL; $edit14=!empty($edit14)?$edit14:NULL; $edit15=!empty($edit15)?$edit15:NULL;
$edit16=!empty($edit16)?$edit16:NULL; $edit17=!empty($edit17)?$edit17:NULL; $edit18=!empty($edit18)?$edit18:NULL;  $edit19=!empty($edit19)?$edit19:NULL;  $edit20=!empty($edit20)?$edit20:NULL; $edit_13=!empty($edit_13)?$edit_13:NULL;
$edit_14=!empty($edit_14)?$edit_14:NULL; $edit21=!empty($edit21)?$edit21:NULL;$edit_15=!empty($edit_15)?$edit_15:NULL;$etat14=!empty($etat14)?$etat14:NULL;$etat17=!empty($etat17)?$etat17:NULL;$etat15=!empty($etat15)?$etat15:NULL;
$etat16=!empty($etat16)?$etat16:NULL;$etat18=!empty($etat18)?$etat18:NULL;$etat19=!empty($etat19)?$etat19:NULL;$etat20=!empty($etat20)?$etat20:NULL;$etat1_4=!empty($etat1_4)?$etat1_4:NULL;$ladate=!empty($ladate)?$ladate:NULL;$msg_1=!empty($msg_1)?$msg_1:NULL;



$idr  = isset($_POST['s1'])?$_POST['s1']:NULL;
$idr  = isset($_GET['idr'])?$_GET['idr']:$idr;  
if(isset($idr))
{	$sql="SELECT * FROM reservationsal WHERE numresch LIKE '".$idr."'";
	$req = mysqli_query($con,$sql) or die (mysqli_error($con));
	$dataT=mysqli_fetch_object($req);  //echo $dataT->nomdemch;    //prenomdemch  contactdemch  codegrpe  avancerc
	
	echo "<script language='javascript'>";
	echo 'alertify.success("Veuillez Cliquer sur Informations Complémentaires ! pour complèter les informations liées au client");';
	echo "</script>";
}

?>

<html>
	<head>
		<script type="text/javascript" src="js/date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script type="text/javascript" src="js/verifyCheckBoxes1.js"></script>
		<script type="text/javascript" src="js/ajax.js"></script>
		<script type="text/javascript" src="js/ajax-dynamic-list4.js"></script>
		<link rel="Stylesheet" type="text/css"  href='css/input.css' />
		<link rel="Stylesheet" href='css/table.css' />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
			<style>
			.alertify-log-custom {
				background: blue;
			}
				td {
				  padding: 8px 0;
				}
	
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
		<?php
		if(!empty($_GET['zoom']))
			echo "
			select, input[type=text]{
			 font-family:cambria;
			}";
		if(isset($_SESSION['db'])) {
		?>
			td {
			  padding: 3px 0;
			}
		<?php
		}else {
		?>
			td {
			  padding: 2px 0;
			}
		<?php
		}
		?>
		</style>
	</head>
	<body style='background-color:#84CECC;'>
	<div align="" style="margin-top:2%;">
		<table align='center' id="tab" >
		<tr>
		<td>
		<fieldset style='border:1px solid white;background-color:#D0DCE0;font-family:Cambria;'>
		<legend align='center' style='color:#046380;font-size:110%;'><b> <?php if(isset($dataT->nomdemch)) echo "RESERVATION DE SALLE(S) EN COURS"; else echo "LISTE JOURNALIERE DES RESERVATIONS"; ?></b></legend>
		<form action='FicheS.php?menuParent=Location' method='post' id='chgdept'<?php  if(isset($_GET['change'])) echo "&change=".$_GET['change']; if(isset($idr)) echo "&idr=".$idr."&name=".$dataT->nomdemch."&surname=".$dataT->prenomdemch; ?> >
			<table border='0' align='center'>
		<?php
		
				if(isset($dataT->nomdemch)){
				//if(isset($_SESSION['numreserv'])){  
				echo "<tr>
					<td>
					<table align='center'>";
					$res=mysqli_query($con,"SELECT numfiche  FROM exonerer_tva WHERE numfiche='".$idr."'");
					$ret=mysqli_fetch_assoc($res);
					$numfiche_1=$ret['numfiche'];
						if(empty($_SESSION['numreserv']))
						{ $or="SELECT distinct reserversal.nuite_payee,reservationsal.numresch,reservationsal.nomdemch,reservationsal.prenomdemch,reservationsal.contactdemch,reservationsal.numsalle,reservationsal.datdepch,reservationsal.avancerc,reservationsal.montantrc FROM reservationsal,reserversal WHERE reservationsal.numresch=reserversal.numresch and reservationsal.datarrivch='".date('Y-m-d')."' AND reservationsal.numresch='".$idr."'";
						 $or1=mysqli_query($con,$or);
						 if(empty($numfiche_1))
							$sql=mysqli_query($con,"SELECT DISTINCT nuite_payee,ttc AS ttc FROM reserversal WHERE numresch='".$idr."'");
						 else
							 $sql=mysqli_query($con,"SELECT DISTINCT nuite_payee,tarifrc AS ttc FROM reserversal WHERE numresch='".$idr."'");
						 }
						else
						{	if(empty($numfiche_1))
							$or="SELECT distinct reserversal.nuite_payee,reserversal.avancerc,reservationsal.numresch,reservationsal.nuiterc,reservationsal.nomdemch,reservationsal.prenomdemch,reservationsal.contactdemch,reservationsal.numsalle,reservationsal.datdepch,reservationsal.avancerc,reservationsal.montantrc FROM reservationsal,reserversal WHERE reservationsal.numresch=reserversal.numresch and reservationsal.datarrivch='".date('Y-m-d')."' AND reservationsal.numresch='".$idr."'";
							else
							$or="SELECT distinct reserversal.nuite_payee,reserversal.tarifrc AS ttc,reserversal.avancerc,reservationsal.numresch,reservationsal.nuiterc,reservationsal.nomdemch,reservationsal.prenomdemch,reservationsal.contactdemch,reservationsal.numsalle,reservationsal.datdepch,reservationsal.avancerc,reservationsal.montantrc FROM reservationsal,reserversal WHERE reservationsal.numresch=reserversal.numresch and reservationsal.datarrivch='".date('Y-m-d')."' AND reservationsal.numresch='".$idr."'";$or1=mysqli_query($con,$or);
							$sql=mysqli_query($con,"SELECT DISTINCT nuite_payee,reserversal.avancerc FROM reserversal WHERE numresch='".$idr."'");
						}

						if(!empty($idr))
						{	$res=mysqli_query($con,"SELECT numfiche  FROM exonerer_tva WHERE numfiche='".$idr."'");
							$ret=mysqli_fetch_assoc($res);
							 $numfiche_1=$ret['numfiche'];
							 $or="SELECT distinct reserversal.nuite_payee,reserversal.avancerc,reservationsal.numresch,reservationsal.nomdemch,reservationsal.prenomdemch,reservationsal.contactdemch,reservationsal.numsalle,reservationsal.datdepch,reservationsal.avancerc,reservationsal.montantrc FROM reservationsal,reserversal WHERE reservationsal.numresch=reserversal.numresch and reservationsal.datarrivch='".date('Y-m-d')."' AND reservationsal.numresch='".$idr."'";
							 $or1=mysqli_query($con,$or);
							 $sql="SELECT DISTINCT nuite_payee,reserversal.avancerc FROM reserversal WHERE numresch='".$idr."'";
							 $sql=mysqli_query($con,$sql);
						 }

						if (isset($or1))
						{while ($roi= mysqli_fetch_array($or1))
							{	$numresch=$roi['numresch'];	$nom=$roi['nomdemch'];$prenoms=$roi['prenomdemch'];$contact=$roi['contactdemch'];$numsalle=$roi['numsalle'];
								$date_depart=substr($roi['datdepch'],8,2).'-'.substr($roi['datdepch'],5,2).'-'.substr($roi['datdepch'],0,4);//$date_depart=!empty($date_depart)?$date_depart:NULL;
								$avancerc=!empty($roi['avancerc'])?$roi['avancerc']:0;//$nuiterc=$roi['nuiterc'];$nuite_payee=(int)$roi['nuite_payee']; //$nuite_payee=!empty($nuite_payee)?$nuite_payee:0;
							}

							$somme_avance=array("");$somme_montant=array("");$i=0;$somme_tva=array("");
							while($result= mysqli_fetch_array($sql))
							{if(empty($numfiche_1))
								{//$somme_avance[$i]=$result['ttc']*$result['nuite_payee']; //$somme_montant[$i]=$result['ttc'];
								}
							  else
								{$somme_avance[$i]=$result['avancerc']*$result['nuite_payee'];
								 //$somme_montant[$i]=$result['ttc']*$result['nuite_payee'];
								 $somme_tva[$i]=$result['ttc']*$result['nuite_payee']*$TvaD;
								}
							 $i++;
							}
							$avance=array_sum($somme_avance);
							//$montantrc=array_sum($somme_montant);	$somme_tva=array_sum($somme_tva);
							//if(empty($numfiche_1)) $somme_due=$montantrc-$avance; else if(!empty($avance)) $somme_due=0;
							
						$montantrc =0;
						
						}
					if(empty($numresch))
						$orA="SELECT DISTINCT SUM(reserversal.avancerc)/SUM(reserversal.mtrc) AS nuite FROM reserversal,reservationsal where reservationsal.numresch=reserversal.numresch AND reservationsal.datarrivch='".date('Y-m-d')."' AND reservationsal.numresch='".$idr."'";
						else
						$orA="SELECT DISTINCT SUM(reserversal.avancerc)/SUM(reserversal.mtrc) AS nuite FROM reserversal,reservationsal where reservationsal.numresch=reserversal.numresch AND reservationsal.datarrivch='".date('Y-m-d')."' AND reservationsal.numresch='".$idr."'";
						$orB=mysqli_query($con,$orA);
						if ($orB)
						{
							while ($roiB= mysqli_fetch_array($orB))
							{
			  $nuite=(int)$roiB['nuite'];
							}
						}
					echo "<tr>
						<td> &nbsp;&nbsp;&nbsp;&nbsp;N° de la r&eacute;servation: &nbsp;&nbsp;</td>
						<td>
							<input type='text' name='numreserv' id='' readonly value='"; if(isset($idr)) echo $idr; else echo $_SESSION['numreserv']; echo" '>";

						echo "</td>
				
						<td>  &nbsp;&nbsp;&nbsp;&nbsp;Montant TTC: &nbsp;&nbsp;</td>
						 <td> <input type='text' name='edit26' id='edit26' readonly value='".$montantrc."' /> </td>
						<td> &nbsp;&nbsp;&nbsp;Avance Remise : &nbsp;&nbsp;</td>
						<td> <input type='text' name='edit30' id='edit30' readonly value='"; if(empty($avance)) echo 0; else echo $avance; echo "'/> </td>
				</tr>
					<tr><td>&nbsp;</td></tr>
				</table></fieldset></td></tr>";	
			} else { 
		?>	
		
				
							<tr>
								<td > Nom du Locataire de la Salle : &nbsp;&nbsp;</td>
								<td>
									<select name='s1' id='s1' style='font-family:sans-serif;font-size:90%;min-width:200px;height:25px;' onchange="document.forms['chgdept'].submit();">
										<option value=''><?php if(isset($dataT->nomdemch)) { if(isset($dataT->codegrpe)) echo $dataT->codegrpe;  else echo $dataT->nomdemch." ".$dataT->prenomdemch;}else echo "Sélectionnez"; ?></option>
											<?php
												mysqli_query($con,"SET NAMES 'utf8'");
												$or="SELECT distinct reservationsal.numresch,reservationsal.nomdemch,reservationsal.prenomdemch,reservationsal.codegrpe FROM reservationsal,reserversal WHERE reservationsal.numresch=reserversal.numresch and reservationsal.datarrivch='".date('Y-m-d')."' AND reservationsal.numresch NOT IN(SELECT num_reserv FROM reservation_tempon2)";
												$or1=mysqli_query($con,$or);
												if ($or1)
												{
													while ($roi= mysqli_fetch_array($or1))
													{ if($roi['codegrpe']!='')
														{echo '<option value="'.$roi['numresch'].'">';echo($roi['codegrpe']);echo '</option>';}
													  else
													    {echo '<option value="'.$roi['numresch'].'">';echo($roi['nomdemch'].' '.$roi['prenomdemch']);echo '</option>'; }
													}
												}
											?>
									</select></td>
								<td>
								 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='FicheS.php?menuParent=Location&zoom=1'><i class="fas fa-search-plus" style=''></i></a>
								</td>
							</tr>
					<?php		
									
									
						}
									
					?>				
							<tr>
								<td>
								 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
							</tr>
							<?php

/* 								if (isset($_POST['tt'])&& $_POST['tt']=='OK')
								{ $_SESSION['numreserv']= $_POST['s1'];
								  $_SESSION['re']=$_POST['s1'];
								$ort="SELECT * FROM reservationsal,reserversal WHERE reservationsal.numresch=reserversal.numresch and reservationsal.datarrivch='".date('Y-m-d')."' AND reservationsal.numresch='".$_POST['s1']."'";
								//echo "SELECT * FROM reservationsal,reserversal WHERE reservationsal.numresch=reserversal.numresch and reservationsal.datarrivch='".date('Y-m-d')."' AND reservationsal.numresch='".$_POST['s1']."'";
								$ort1=mysqli_query($con,$ort);
								if ($ort1)
									{
										$roit= mysqli_fetch_array($ort1);
										echo "<tr border='1'>";
											echo "<td>   Nom du demandeur:"; echo ($roit['nomdemch'].'     '.$roit['prenomdemch']);echo "</td>";
											echo "<td> Avance: "; echo ($roit['avancerc']);echo "</td>";
										echo "</tr border='1'>";
										$_SESSION['avancef']=$roit['avancerc'];
										$ort="SELECT * FROM reservationsal,reserversal WHERE reservationsal.numresch=reserversal.numresch and datarrivch='".date('Y-m-d')."'";
										$ort1=mysqli_query($con,$ort);
										while ($roit= mysqli_fetch_array($ort1))
											{
												echo "<tr border='1'>";
													echo "<td>Chambre N°"; echo ($roit['numch']);echo "</td>";
													echo "<td>Occupation: "; echo ($roit['typeoccuprc']);echo "</td>";
												echo "</tr>";
											}
							           header('location:info_reservation2.php?sal=1');
									}
								} */
							?>
						</table>
						</form>
					</fieldset>
				</td>
			<tr>
			<tr style=''>
				<td>
					<fieldset style='border:1px solid white;background-color:#D0DCE0;font-family:Cambria;'>
						<legend align='' style='color:#046380;font-size:120%;'><b> FICHE DE RENSEIGNEMENT</b> </legend>
						<form action='FicheS.php?menuParent=Location' method='post' id='form1' name='FicheS' >
							<table align='center'>
								<tr align='left'>
									<td width=''> Location de salle N°:&nbsp; </td>
									<td width=''> <input type='text' name='edit1' value="<?php
										$initial_fiche='FS';
										if(isset($_GET['numfiche'])) echo $_GET['numfiche'];
			/* 							else {
										if($etat_facture=='AA')
										{   $initial_fiche="S";
											$chaine1 = substr(random($Nbre_char,''),0,3);
											$chaine2 = substr(random($Nbre_char,''),5,2);
											echo $chaine = $initial_fiche.$chaine1.$chaine2;
										}
										if(($etat_facture=='AI')) */
										else
										{	if(($num_fiche>=0)&&($num_fiche<=9))
													echo $initial_fiche.'0000'.$num_fiche ;
											else if(($num_fiche>=10)&&($num_fiche <=99))
													echo $initial_fiche.'000'.$num_fiche ;
											else if(($num_fiche>=100)&&($num_fiche<=999))
												echo $initial_fiche.'00'.$num_fiche ;
											else if(($num_fiche>=1000)&&($num_fiche<=1999))
													echo $initial_fiche.'0'.$num_fiche ;
											else
										echo $num_fiche ;}
										//}
									?>" readonly /> </td>
									<td>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<span style="font-style:italic;font-size:0.9em;color:black;"><a href='client.php?menuParent=Location&sal=1<?php if(isset($_GET['change'])) echo "&change=".$_GET['change']; if(isset($_GET['numfiche'])) echo "&numfiche=".$_GET['numfiche']; if(isset($dataT->nomdemch)) echo "&reservation=".$dataT->numresch; if(isset($idr)) echo "&idr=".$idr."&name=".$dataT->nomdemch."&surname=".$dataT->prenomdemch."&address=".$dataT->contactdemch; ?>'style='text-decoration:none;color:#d10808;font-size:1.1em;'><?php if(isset($dataT->nomdemch)) echo "Informations Complémentaires !"; else echo "Nouveau";?></span> 
									 <img src="logo/edit.png" alt="" title='Nouveau Client'/>   <i class='fas-solid fa-file-circle-plus'></i>  </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
									<span style="font-style:italic;font-size:0.8em;color:black;"><a href='selection_client.php?menuParent=Location&sal=1<?php if(isset($_GET['change'])) echo "&change=".$_GET['change']; if(isset($_GET['numfiche'])) echo "&numfiche=".$_GET['numfiche']; ?>' style='text-decoration:none;color:#d10808;'>Rechercher</span><img src="logo/b_search.png" alt="" width='22' title='Rechercher Client'/> </a>
									</td>
								</tr>
							<tr>
								<td></td>
							</tr>
							</table>
							<table style=''>
								<tr>
									<td>
										<fieldset>
											<legend align='' style='padding=5px;color:#046380;font-size:120%;'><b>INFORMATIONS SUR L'IDENTITE DU CLIENT</b></legend>
											<table>
												<tr style=''>
													<td> &nbsp;Numéro du Client : &nbsp;</td>
													<td> <input type='text' name='edit2' id='edit2' style='<?php if($etat_2==1)echo"background-color:#FDF1B8;";?>' readonly value=" <?php if(!empty($_GET['numcli'])) echo $rlt1; if($etat_2!=1) echo $edit2; if(!empty($_SESSION['numcli'])) echo $_SESSION['numcli']; ?>" />  </td>
													<?php
														if(($numclientS>=0)&&($numclientS<=9)) $numclientS="CS000".$numclientS ;
														if(($numclientS>=10)&&($numclientS <=99)) $numclientS="CS00".$numclientS ;
														if(($numclientS>=100)&&($numclientS <1000)) $numclientS="CS0".$numclientS ;
														if($numclientS>=1000) $numclientS="CS".$numclientS ;
														echo " <input type='hidden' name='Tedit2'  readonly size='26' value='".$numclientS."'/>";
													?>
													<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Nom : <span style="color:red;"> *</span> </td><td><input type='text' name='edit3' id='edit3' required style='<?php if($etat1==1 )echo"background-color:#FDF1B8;";?>' value="<?php if(!empty($_GET['numcli'])) echo $rlt2; if($etat1!=1) echo $edit3; if(!empty($_SESSION['numcli'])) echo $_SESSION['nomcli'];  if(isset($dataT->nomdemch)) echo $dataT->nomdemch; ?>" onkeyup='this.value=this.value.toUpperCase()' /> </td>
													<input type='hidden' name='edit_03' id='edit_03' readonly />
													<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pr&eacute;noms : <span style="color:red;"> *</span> &nbsp;</td>
													<td> <input type='text' name='edit4' id='edit4' required style='<?php if($etat2==1)echo"background-color:#FDF1B8;";?>' value="<?php  if(!empty($_GET['numcli'])) echo $rlt3;  if($etat2!=1) echo $edit4; if(!empty($_SESSION['numcli'])) echo $_SESSION['prenomcli']; if(isset($dataT->prenomdemch)) echo $dataT->prenomdemch; ?>" onKeyup="ucfirst(this)" /> </td>
												</tr>
												<tr style=''>
													<td> &nbsp;Contact  : <span style="color:red;"> *</span> </td>
													<td> <input type='text' name='edit12' required style='<?php if($etat14==1)echo"background-color:#FDF1B8;";?>' value="<?php  if(!empty($_GET['numcli'])) echo $rlt14;if($etat14!=1) echo $edit12; if(!empty($_SESSION['numcli'])) echo $_SESSION['contact']; if(isset($dataT->contactdemch)) echo $dataT->contactdemch; ?>" onkeypress="testChiffres(event);" /> </td>
													<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Groupe représenté : &nbsp;</td>
													<td> <input type='text' name='groupe' style='' value="<?php  if(isset($dataT->codegrpe)) echo $dataT->codegrpe; ?>" <?php if(!empty($_GET['change'])) echo "readonly";?> placeholder='Sélectionnez le groupe' autocomplete='OFF' onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" onchange="ajax_showOptions(this,'getCountriesByLetters',event)" /></td>
													<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nbre de salles sollicitées :&nbsp; </td>
													<td> <input type='number' name='edit2_2' style='' min='1' placeholder="1" onkeypress="testChiffres(event);"/> </td>
												</tr>

											</table>
										</fieldset>
									</td>
								</tr>
								<tr>
									<td> 
										 <input type='hidden' name='change' value="<?php if(!empty($_GET['change'])) echo $_GET['change'];?>" />
										<fieldset style='border:1px solid white;background-color:#D0DCE0;font-family:Cambria;'>
											<legend align='' style='color:#046380;font-size:120%;'><b>TYPE DE PIECE D'IDENTITE </b></legend>
											<table>
												<tr>
													<td> &nbsp;Type de pièce : &nbsp;</td>
													<td> <input type='text' name='edit_9'  id='edit_9'size='30' value="<?php if(!empty($_GET['numcli'])) echo strtoupper($rlt8);if($etat15!=1) echo $edit_9; if(!empty($_SESSION['numcli'])) echo $_SESSION['piece'];?>" />  </td>
													<td> &nbsp;&nbsp;Numéro de pièce : &nbsp;</td>
													<td> <input type='text' name='edit_13'   id='edit_13' size='30' value="<?php  if(!empty($_GET['numcli'])) echo $rlt9;if($etat16!=1) echo $edit_13; if(!empty($_SESSION['numcli'])) echo $_SESSION['numpiece']; ?>" /> </td>
													<td> &nbsp;&nbsp;Délivrée le :&nbsp;</td>
													<td> <input type='text' name='edit_14'  id='edit_14' size='30' value="<?php if(!empty($_GET['numcli'])) echo $rlt10;if($etat17!=1) echo $edit_14; if(!empty($_SESSION['numcli'])) echo $_SESSION['le']; ?>" /> </td>
												</tr>

												<tr>
													<td> &nbsp; à : </td>
													<td> <input type='text' name='edit_15'    id='edit_15' size='30' value="<?php  if(!empty($_GET['numcli'])) echo $rlt11;if($etat18!=1) echo $edit_15; if(!empty($_SESSION['numcli'])) echo $_SESSION['a']; ?>" onKeyup="ucfirst(this)"/> </td>
													<td> &nbsp;&nbsp;Par : </td>
													<td> <input type='text' name='edit_16'   id='edit_16' size='30' value="<?php  if(!empty($_GET['numcli'])) echo $rlt12;if($etat19!=1) echo $edit_16; if(!empty($_SESSION['numcli'])) echo $_SESSION['par']; ?>" onKeyup="ucfirst(this)"/> </td>
													<td> <input type='hidden' name='edit18' id='edit18' value="<?php echo date('Y-m-d') ?>" readonly /> </td>
												</tr>
											</table>
										</fieldset>
									</td>
								</tr>
								<tr>
									<td>
									<fieldset style='border:1px solid white;background-color:#D0DCE0;font-family:Cambria;'>
											<legend align='' style='color:#046380;font-size:120%;'><b>Location </b></legend>
											<table>
												<tr>
													<td> &nbsp;Motif de la Location : <span style="color:red;"> *</span>&nbsp; </td>
													<td colspan=''>

														<select name='edit17' required style='width:170px;font-size:1em;<?php if($etat20==1)echo"background-color:#FDF1B8;";?>'>
															<option value='<?php if($edit17!="") echo $edit17;?>'> <?php echo $edit17;?></option>
															<option value='Réunion'>Réunion</option>
															<option value=''></option>
															<option value='Fête'>Fête</option>
															<option value=''></option>
															<option value='Manifestation'>Manifestation </option>
															<option value=''></option>
															<option value='Autre'>Autre but</option>
														</select>
													</td>
												    <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date d'occupation : &nbsp;&nbsp;</td>
													<td><input type='text' readonly name='edit_2' id='edit_2' value="<?=$Date_actuel; ?>" required onKeyup="ucfirst(this)"/> </td>
													<td> &nbsp;&nbsp;&nbsp;&nbsp;Date de Libération de la Salle : <span style="color:red;"> *</span> &nbsp;&nbsp;</td>
												  <td style=" border: 0px solid black;"><input type="date" name="ladate" required  id="ladate" size="20" value=""  />
													   <!-- <a href="javascript:show_calendar('fiche_1.ladate');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
														 <img src="logo/cal.gif" style="border:1px solid yellow;" alt="calendrier" title="calendrier"></a> !-->
												  </td>
													<input type='hidden' name='nui' id='nui'/>
												</tr>

											</table>
										</fieldset>
									</td>
								</tr>
								<tr>
									<td align='center'> <br/><input type='submit' name='ok' class='bouton2' value='VALIDER' style=''/></td>
								</tr>
							</table>
						</form>
					</fieldset>
				</td>
			</tr>
		</table>
		</div>
		<?php echo $msg_1;
		$_SESSION['numcli']='';
		$_SESSION['nomcli']='';
		$_SESSION['prenomcli']='';
		$_SESSION['ladate']='';
		$_SESSION['lieu']='';
		$_SESSION['pays']='';
		$_SESSION['sexe']='';
		$_SESSION['piece']='';
	    $_SESSION['numpiece']='';
		$_SESSION['le']='';
		$_SESSION['a']='';
		$_SESSION['par']='';
		$_SESSION['contact']='';
		?>
	</body>
	<script type="text/javascript">

		//uppercase first letter
		function ucfirst(field) {
			field.value = field.value.substr(0, 1).toUpperCase() + field.value.substr(1);
		}
		function VerifForm()
		{
			if ((document.form1.edit1.value=='')|| (document.form1.edit2.value=='')||(document.form1.edit3.value=='')||(document.form1.edit4.value=='')||(document.form5.edit1.value=='')||(document.form1.edit6.value=='')||(document.form1.edit7.value=='')||(document.form1.edit8.value=='')||(document.form1.combo1.value=='Default')||(document.form1.combo2.value=='Default')||(document.form1.edit9.value=='')||(document.form1.edit10.value=='')||(document.form1.edit11.value=='')||(document.form1.edit12.value=='')||(document.form1.edit13.value=='')||(document.form1.se1.value=='Default')||(document.form1.se2.value=='Default')||(document.form1.se3.value=='Default')||(document.form1.se4.value=='Default')||(document.form1.se5.value=='Default')||(document.form1.se6.value=='Default')||(document.form1.edit21.value=='')||(document.form1.combo3.value=='Default')||(document.form1.edit22.value=='')||(document.form1.combo4.value=='Default')||(document.form1.edit23.value=='')||(document.form1.edit24.value=='')||(document.form1.edit25.value=='')||(document.form1.edit26.value=='')||(document.form1.edit27.value=='')||(document.form1.edit28.value==''))
			{
				alert('Un champ est vide');
			}
		}

		function Nuite()
			{
				var d1=document.getElementById("edit18").value;
				var d2=document.getElementById('se6').options[document.getElementById('se6').selectedIndex].value+'-'+document.getElementById('se5').options[document.getElementById('se5').selectedIndex].value+'-'+document.getElementById('se4').options[document.getElementById('se4').selectedIndex].value;
				var date1= new Date(d1);
				var date2= new Date(d2);
				var nuite=(date2-date1)/86400000;
				//alert (nuite);
				if (nuite==0)
				{nuite=nuite+1}
				document.getElementById("nui").value=nuite;
			}

			function CalculMt()
			{
				var montant=(document.getElementById("edit23").value* document.getElementById("edit24").value);
				document.getElementById("edit25").value=montant;
			}

			function CalculSD()
			{
				var due=(document.getElementById("edit25").value- document.getElementById("edit26").value);
				document.getElementById("edit27").value=due;

				var nt=(document.getElementById("edit26").value/ document.getElementById("edit24").value);
				document.getElementById("edit28").value=nt;
			}


		// fonction pour selectionner le nom du client
	   function action(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
					//id du champ qui receptionne le résultat
						document.getElementById('edit3').value = leselect;

					}
				}
				//nom du fichier qui exécute la requete
				xhr.open("POST","fnomcli.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				//id du numcli
				sel = document.getElementById('edit2').value;
				//affectation de la valeur saisie a la requete php
				xhr.send("numcli="+sel);
		}

				// fonction pour savoir si le codiam le doit
	   function action_03(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
					//id du champ qui receptionne le résultat
						document.getElementById('edit_03').value = leselect;

					}
				}
				//nom du fichier qui exécute la requete
				xhr.open("POST","valoir.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				//id du numcli
				sel = document.getElementById('edit2').value;
				//affectation de la valeur saisie a la requete php
				xhr.send("numcli="+sel);
		}


		// fonction pour selectionner le prenom du client
		function action1(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit4').value=leselect;

					}
				}
				xhr.open("POST","fprenomcli.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}
		//fonction pour selectionner le sexe du client
		function action2(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit5').value = leselect;

					}
				}
				xhr.open("POST","fsexecli.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}
		// fonction pour selectionner la date de naissance du client
		function action3(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit6').value = leselect;

					}
				}
				xhr.open("POST","fdatnaisscli.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}

				// fonction pour selectionner le type de piece du client
		function action8(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit_9').value = leselect;

					}
				}
				xhr.open("POST","typepiece.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}

		 // fonction pour selectionner le numero de la piece du client
		function action9(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit_13').value = leselect;

					}
				}
				xhr.open("POST","numeropiece.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}

				 // fonction pour selectionner la date de delivrance de la piece du client
		function action10(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit_14').value = leselect;

					}
				}
				xhr.open("POST","datepiece.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}
		// fonction pour selectionner le lieu de delivrance de la piece du client
		function action11(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit_15').value = leselect;

					}
				}
				xhr.open("POST","lieupiece.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}
				// fonction pour selectionner le delivreur de la piece du client
		function action12(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit_16').value = leselect;

					}
				}
				xhr.open("POST","livreurpiece.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}


		// fonction pour selectionner le lieu de naissance du client
		function action4(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit7').value = leselect;

					}
				}
				xhr.open("POST","flieucli.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}
		// fonction pour selectionner le pays du client
		function action5(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit8').value = leselect;

					}
				}
				xhr.open("POST","fpayscli.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}
		// fonction pour selectionner le type de chambre
		function action6(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit_9').value = leselect;
					}
				}
				xhr.open("POST","ftypech.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo3');
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("numch="+sh);
		}
		// fonction pour selectionner le tarif
		function action7(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit24').value = leselect;
					}
				}
				xhr.open("POST","ftarif.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo4');
				sel1 = document.getElementById('combo3');
				sh1=sel1.options[sel.selectedIndex].value;
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("objet="+sh+"&numch="+sh1);
		}

		//affichage des informations concernant le client
		var momoElement = document.getElementById("edit2");
		if(momoElement.addEventListener){
		  momoElement.addEventListener("blur", action, false);
		  momoElement.addEventListener("keyup", action, false);
		   momoElement.addEventListener("blur", action1, false);
		  momoElement.addEventListener("keyup", action1, false);
		  momoElement.addEventListener("blur", action2, false);
		  momoElement.addEventListener("keyup", action2, false);
		  momoElement.addEventListener("blur", action3, false);
		  momoElement.addEventListener("keyup", action3, false);
		  momoElement.addEventListener("blur", action4, false);
		  momoElement.addEventListener("keyup", action4, false);
		  momoElement.addEventListener("blur", action5, false);
		  momoElement.addEventListener("keyup", action5, false);
		  momoElement.addEventListener("blur", action8, false);
		  momoElement.addEventListener("keyup", action8, false);
		  momoElement.addEventListener("blur", action9, false);
		  momoElement.addEventListener("keyup", action9, false);
		  momoElement.addEventListener("blur", action10, false);
		  momoElement.addEventListener("keyup", action10, false);
		  momoElement.addEventListener("blur", action11, false);
		  momoElement.addEventListener("keyup", action11, false);
		  momoElement.addEventListener("blur", action12, false);
		  momoElement.addEventListener("keyup", action12, false);
		  momoElement.addEventListener("blur", action_03, false);
		  momoElement.addEventListener("keyup", action_03, false);
		}else if(momoElement.attachEvent){
		  momoElement.attachEvent("onblur", action);
		  momoElement.attachEvent("onkeyup", action);
		  momoElement.attachEvent("onblur", action1);
		  momoElement.attachEvent("onkeyup", action1);
		   momoElement.attachEvent("onblur", action2);
		  momoElement.attachEvent("onkeyup", action2);
		   momoElement.attachEvent("onblur", action3);
		  momoElement.attachEvent("onkeyup", action3);
		   momoElement.attachEvent("onblur", action4);
		  momoElement.attachEvent("onkeyup", action4);
		   momoElement.attachEvent("onblur", action5);
		  momoElement.attachEvent("onkeyup", action5);
		  momoElement.attachEvent("onblur", action8);
		  momoElement.attachEvent("onkeyup", action8);
		  momoElement.attachEvent("onblur", action9);
		  momoElement.attachEvent("onkeyup", action9);
		  momoElement.attachEvent("onblur", action10);
		  momoElement.attachEvent("onkeyup", action10);
		   momoElement.attachEvent("onblur", action11);
		  momoElement.attachEvent("onkeyup", action11);
		   momoElement.attachEvent("onblur", action12);
		  momoElement.attachEvent("onkeyup", action12);
		  momoElement.attachEvent("onblur", action_03);
		  momoElement.attachEvent("onkeyup", action_03);
		 // momoElement.attachEvent("onchange", action8);
		}

		var momoElement1 = document.getElementById("combo3");
		if(momoElement1.addEventListener){
		  momoElement1.addEventListener("change", action6, false);
		 // momoElement1.addEventListener("change", action7, false);
		  //momoElement1.addEventListener("change", Verif, false);
		}else if(momoElement1.attachEvent){
		  momoElement1.attachEvent("onchange", action6);
		 // momoElement1.attachEvent("onchange", action7);
		  //momoElement1.attachEvent("onchange", verif);
		}

		var momoElement2 = document.getElementById("combo4");
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
