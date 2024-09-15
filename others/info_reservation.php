<?php
  //  ob_start();
require_once "../menu.php";
	//echo $_SESSION['numresch'];
	mysqli_query($con,"SET NAMES 'utf8'");
		$reqsel=mysqli_query($con,"SELECT * FROM configuration_facture");
			while($data=mysqli_fetch_array($reqsel))
				{ // $num_fiche=$data['num_fiche']+1;
				   $num_fact=$data['num_fact'];
				   $etat_facture=$data['etat_facture'];
				   $initial_grpe=$data['initial_grpe'];
				   $initial_reserv=$data['initial_reserv'];
				   $initial_fiche=$data['initial_fiche'];
				   $Nbre_char=$data['Nbre_char'];
				}

			$reqsel=mysqli_query($con,"SELECT max(numfiche) AS numfiche FROM fiche1");
			while($data=mysqli_fetch_array($reqsel))
				{  $num_fiche=$data['numfiche']+1;
				}

	// automatisation du numéro
	function random($car) {
		$string = $initial_fiche;
		$chaine = "0123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
		}
		return $string;
		}
		$numresch=$_GET['numresch'];

		$val="Jour";
		$se5="Mois";
		$se6="Année";
		$combo2="- Choix de l'Etat civil-";
		$edit9="-- Choix --";
		$edit17="-- Choix --";
			$reqsel=mysqli_query($con,"SELECT * FROM client WHERE numcli ='".$_GET['numcli']."' ");
	//echo ("SELECT * FROM client WHERE numcli ='".$_GET['numcli']."' ");
		while($data=mysqli_fetch_array($reqsel))
			{  $rlt1=$data['numcli'];
			   $rlt2=$data['nomcli'];
			   $rlt3=$data['prenomcli'];
			   $rlt4=$data['sexe'];
			   $rlt5=$data['datnaiss'];
			   $rlt6=$data['lieunaiss'];
			   $rlt8=$data['typepiece'];
			   $rlt9=$data['numiden'];
			   $rlt10=$data['date_livrais'];
			   $rlt11=$data['lieudeliv'];
			   $rlt12=$data['institutiondeliv'];
			   $rlt13=$data['pays'];
			   $rlt14=$data['adresse'];
			}


	//enregistrement de la fiche

	if (isset($_POST['ok'])&& $_POST['ok']=='VALIDER')
		{ 	$date1=date("Y-m-d");$date2=substr($_POST['ladate'],6,4).'-'.substr($_POST['ladate'],3,2).'-'.substr($_POST['ladate'],0,2);
			$exec=mysqli_query($con,"SELECT DATEDIFF('$date2','$date1') AS DiffDate");
			$row_Recordset1 = mysqli_fetch_assoc($exec);
			$row_Recordset=$row_Recordset1['DiffDate'];
		    if($row_Recordset>0)
			{$_SESSION['Nuite']= $row_Recordset;
			$_SESSION['avance']=$_POST['edit30'];
			$_SESSION['num_ch']=$_POST['numch'];
		    $_SESSION['numreservation']=$_POST['numreserv'];
			$_SESSION['numreserv']=$_POST['numreserv'];
			$_SESSION['np_avance']=$_POST['edit32'];
		   if($_POST['nui']>15) {
      		$_SESSION['num']=$_POST['edit1'];
						$_SESSION['cli']=$_POST['edit3'].' '.$_POST['edit4'];
			if (isset($_SESSION['num']) && !empty($_SESSION['num']))
				{
			//vérification d'unicité de numéro de fiche
					$Recordset1=mysqli_query($con,"SELECT * FORM fiche1 WHERE numfiche='".$_SESSION['num']."'");
					if (!$Recordset1)
					{ 	mysqli_query($con,"SET NAMES 'utf8' ");
						//vérifivation de disponibilité de chambre
							$datdeliv=$_POST['se3'].'-'.$_POST['se2'].'-'.$_POST['se1'];
							$datarriv=addslashes($_POST['edit18']);
							//$datdep=addslashes($_POST['ladate']);
							$datdep=substr($_POST['ladate'],6,4).'-'.substr($_POST['ladate'],3,2).'-'.substr($_POST['ladate'],0,2)	;

							$etat='RAS';
							$p1=addslashes($_POST['edit1']);$p2=addslashes($_POST['edit2']);$p3=addslashes($_POST['combo2']);$p4=addslashes($_POST['edit9']);$p5=addslashes($_POST['edit10']);
							$p6=addslashes($_POST['edit11']);$p7=addslashes($_POST['edit12']);$p8=addslashes($_POST['edit_9']);$p9=addslashes($_POST['edit_13']);$p10=addslashes($_POST['edit_14']);
							$p11=addslashes($_POST['edit_15']);$p12=addslashes($_POST['edit_16']);$p17=addslashes($_POST['edit17']);$p18=addslashes($_POST['edit19']);$p18=addslashes($_POST['edit21']);
							if(($p1!='')AND($p2!='')AND($p3!='')AND($p4!='')AND($p5!='')AND($p6!='')AND($p7!='')AND($p8!='')AND($p9!='')AND($p10!='')AND($p11!='')AND($p12!='')AND($p17!='')AND($p18!='')AND($_POST['ladate']!='')){
$ret="INSERT INTO fiche1 VALUES('$p1','0','$p2','','$p3','$p4','$p5','$p17','".$datarriv."','$p18','".$datdep."','".$datdep."','12:00','$p18','".$_POST['rad']."',
								'".$etat."','".$_SESSION['re']."','','".$_SESSION['login']."','".$_SESSION['login']."','".$_SESSION['Nuite']."','OUI')";
							$req=mysqli_query($con,$ret);
							if ($req)
							{// header('location:occup.php');
							}
							}else {
							echo "<script language='javascript'>";
							echo " alert('Les champs en couleur sont vides');";
							echo "</script>";
							if($_POST['edit1']=='') $etat_1=1; else $edit1=$_POST['edit1'];
							if($_POST['edit2']=='') $etat_2=1; else $edit2=$_POST['edit2'];
							if($_POST['edit3']=='') $etat1=1; else $edit3=$_POST['edit3'];
							if($_POST['edit4']=='') $etat2=1; else $edit4=$_POST['edit4'];
							if($_POST['edit6']=='') $etat6=1; else $edit6=$_POST['edit6'];
							if($_POST['edit7']=='') $etat7=1; else $edit7=$_POST['edit7'];
							if($_POST['edit8']=='') $etat8=1; else $edit8=$_POST['edit8'];
							if($_POST['edit5']=='') $etat5=1; else $edit5=$_POST['edit5'];
							if($_POST['edit10']=='') $etat10=1; else $edit10=$_POST['edit10'];
							if($_POST['combo2']=='') $etat11=1; else $combo2=$_POST['combo2'];
							if($_POST['edit9']=='') $etat12=1; else $edit9=$_POST['edit9'];
							if($_POST['edit11']=='') $etat13=1; else $edit11=$_POST['edit11'];
							if($_POST['edit12']=='') $etat14=1; else $edit12=$_POST['edit12'];
							if($_POST['edit_9']=='') $etat15=1; else $edit_9=$_POST['edit_9'];
							if($_POST['edit_13']=='') $etat16=1; else $edit_13=$_POST['edit_13'];
							if($_POST['edit_14']=='') $etat17=1; else $edit_14=$_POST['edit_14'];
							if($_POST['edit_15']=='') $etat18=1; else $edit_15=$_POST['edit_15'];
							if($_POST['edit_16']=='') $etat19=1; else $edit_16=$_POST['edit_16'];
							if($_POST['edit17']=='') $etat20=1; else $edit17=$_POST['edit17'];
							if($_POST['se4']=='') $etat21=1; else $val=$_POST['se4'];
							if($_POST['se5']=='') $etat22=1; else $se5=$_POST['se5'];
							if($_POST['se6']=='') $etat23=1; else $se6=$_POST['se6'];
							if($_POST['ladate']=='') $etat1_4=1; else $ladate=$_POST['ladate'];
							if($_POST['edit21']=='') $etat1_40=1; else $edit21=$_POST['edit21'];
							if($_POST['edit19']=='') $etat1_41=1; else $edit19=$_POST['edit19'];}
				    }

				}
				header('location:../avertissement.php');	}
		     else if ($_POST['nui']<15)
			   {     //if (empty($_POST['edit_03'])){
          			    //$_SESSION['Nuite']=$_POST['nui'];
                		$_SESSION['num']=$_POST['edit1'];
						$_SESSION['cli']=$_POST['edit3'].' '.$_POST['edit4'];
			if (isset($_SESSION['num']) && !empty($_SESSION['num']))
				{
			//vérification d'unicité de numéro de fiche
					$Recordset1=mysqli_query($con,"SELECT * FORM fiche1 WHERE numfiche='".$_SESSION['num']."'");
					if (!$Recordset1)
					{   //$_SESSION['numerof']=addslashes($_POST['edit1']);
						mysqli_query($con,"SET NAMES 'utf8' ");
						//vérification de disponibilité de chambre
							$datdeliv=$_POST['se3'].'-'.$_POST['se2'].'-'.$_POST['se1'];
							$datarriv=addslashes($_POST['edit18']);
							//$datdep=addslashes($_POST['ladate']);
							$datdep=substr($_POST['ladate'],6,4).'-'.substr($_POST['ladate'],3,2).'-'.substr($_POST['ladate'],0,2)	;

							$etat='NON';
							$p1=addslashes($_POST['edit1']);$p2=addslashes($_POST['edit2']);$p2=trim($p2);$p3=addslashes($_POST['combo2']);$p4=addslashes($_POST['edit9']);$p5=addslashes($_POST['edit10']);
							$p6=addslashes($_POST['edit11']);$p7=addslashes($_POST['edit12']);$p8=addslashes($_POST['edit_9']);$p9=addslashes($_POST['edit_13']);$p10=addslashes($_POST['edit_14']);
							$p11=addslashes($_POST['edit_15']);$p12=addslashes($_POST['edit_16']);$p17=addslashes($_POST['edit17']);$p18=addslashes($_POST['edit19']);$p18=addslashes($_POST['edit21']);
						if(($p1!='')AND($p2!='')AND($p3!='')AND($p4!='')AND($p5!='')AND($p6!='')AND($p7!='')AND($p8!='')AND($p9!='')AND($p10!='')AND($p11!='')AND($p12!='')AND($p17!='')AND($p18!='')AND($_POST['ladate']!='')){
$ret="INSERT INTO fiche1 VALUES('$p1','0','$p2','','$p3','$p4','$p5','$p6','$p17','".$datarriv."','$p18','".$datdep."','".$datdep."','12:00','$p18','".$_POST['rad']."',
								'".$etat."','".$_SESSION['re']."','','".$_SESSION['login']."','".$_SESSION['login']."','".$_SESSION['Nuite']."','NON')";
							$req=mysqli_query($con,$ret);
							echo $ret;
							if ($req)
							{  $_SESSION['numreserv']=$_POST['numreserv'];
							   header('location:../occup.php');
							}
						}else {
							echo "<script language='javascript'>";
							echo " alert('Les champs en couleur sont vides');";
							echo "</script>";
							if($_POST['edit1']=='') $etat_1=1; else $edit1=$_POST['edit1'];
							if($_POST['edit2']=='') $etat_2=1; else $edit2=$_POST['edit2'];
							if($_POST['edit3']=='') $etat1=1; else $edit3=$_POST['edit3'];
							if($_POST['edit4']=='') $etat2=1; else $edit4=$_POST['edit4'];
							if($_POST['edit6']=='') $etat6=1; else $edit6=$_POST['edit6'];
							if($_POST['edit7']=='') $etat7=1; else $edit7=$_POST['edit7'];
							if($_POST['edit8']=='') $etat8=1; else $edit8=$_POST['edit8'];
							if($_POST['edit5']=='') $etat5=1; else $edit5=$_POST['edit5'];
							if($_POST['edit10']=='') $etat10=1; else $edit10=$_POST['edit10'];
							if($_POST['combo2']=='') $etat11=1; else $combo2=$_POST['combo2'];
							if($_POST['edit9']=='') $etat12=1; else $edit9=$_POST['edit9'];
							if($_POST['edit11']=='') $etat13=1; else $edit11=$_POST['edit11'];
							if($_POST['edit12']=='') $etat14=1; else $edit12=$_POST['edit12'];
							if($_POST['edit_9']=='') $etat15=1; else $edit_9=$_POST['edit_9'];
							if($_POST['edit_13']=='') $etat16=1; else $edit_13=$_POST['edit_13'];
							if($_POST['edit_14']=='') $etat17=1; else $edit_14=$_POST['edit_14'];
							if($_POST['edit_15']=='') $etat18=1; else $edit_15=$_POST['edit_15'];
							if($_POST['edit_16']=='') $etat19=1; else $edit_16=$_POST['edit_16'];
							if($_POST['edit17']=='') $etat20=1; else $edit17=$_POST['edit17'];
							if($_POST['se4']=='') $etat21=1; else $val=$_POST['se4'];
							if($_POST['se5']=='') $etat22=1; else $se5=$_POST['se5'];
							if($_POST['se6']=='') $etat23=1; else $se6=$_POST['se6'];
							if($_POST['ladate']=='') $etat1_4=1; else $ladate=$_POST['ladate'];
							if($_POST['edit21']=='') $etat1_40=1; else $edit21=$_POST['edit21'];
							if($_POST['edit19']=='') $etat1_41=1; else $edit19=$_POST['edit19'];}
				    }

				}

			 }

			    else
				header('location:warning_date.php');
}else	echo "<script language='javascript'>alert('La date de départ doit être supérieure à la date du jour'); </script>";
}

?>

<html>
	<head>
		<title> SYGHOC </title>
		<script type="text/javascript" src="../js/date-picker.js"></script>
	<script type="text/javascript" src="../js/fonctions_utiles.js"></script>
	</head>
	<body>
		<table align='center'style='font-size:1.1em;'>
			<tr>
				<td>
					<fieldset>
						<legend align='center' style="font-weight:bold;"> DETAILS SUR LA RESERVATION </legend>
						<form action='info_reservation.php' method='post' name='info_reservation' >
							<table align='center'>
					            <?php
								$res=mysqli_query($con,"SELECT numfiche  FROM exonerer_tva WHERE numfiche='".$_SESSION['numreserv']."'");
								while($ret=mysql_fetch_array($res))
									{ $numfiche_1=$ret['numfiche'];
									}
								    if($_SESSION['numreserv']=='')
									{ $or="SELECT distinct reserverch.nuite_payee,reserverch.ttc,reservationch.numresch,reservationch.nomdemch,reservationch.prenomdemch,reservationch.contactdemch,reservationch.numch,reservationch.datdepch,reservationch.avancerc,reservationch.montantrc FROM reservationch,reserverch WHERE reservationch.numresch=reserverch.numresch and reservationch.datarrivch='".date('Y-m-d')."' AND reservationch.numresch='".$_SESSION['numreserv']."'";
									 $or1=mysqli_query($con,$or);
									 if(empty($numfiche_1))
										$sql=mysqli_query($con,"SELECT DISTINCT nuite_payee,ttc AS ttc FROM reserverch WHERE numresch='".$_SESSION['numreserv']."'");
									 else
									 	 $sql=mysqli_query($con,"SELECT DISTINCT nuite_payee,tarifrc AS ttc FROM reserverch WHERE numresch='".$_SESSION['numreserv']."'");
									 }
									else
									{	if(empty($numfiche_1))
										$or="SELECT distinct reserverch.nuite_payee,reserverch.ttc,reserverch.avancerc,reservationch.numresch,reservationch.nuiterc,reservationch.nomdemch,reservationch.prenomdemch,reservationch.contactdemch,reservationch.numch,reservationch.datdepch,reservationch.avancerc,reservationch.montantrc FROM reservationch,reserverch WHERE reservationch.numresch=reserverch.numresch and reservationch.datarrivch='".date('Y-m-d')."' AND reservationch.numresch='".$_SESSION['numreserv']."'";
										else
										$or="SELECT distinct reserverch.nuite_payee,reserverch.tarifrc AS ttc,reserverch.avancerc,reservationch.numresch,reservationch.nuiterc,reservationch.nomdemch,reservationch.prenomdemch,reservationch.contactdemch,reservationch.numch,reservationch.datdepch,reservationch.avancerc,reservationch.montantrc FROM reservationch,reserverch WHERE reservationch.numresch=reserverch.numresch and reservationch.datarrivch='".date('Y-m-d')."' AND reservationch.numresch='".$_SESSION['numreserv']."'";$or1=mysqli_query($con,$or);
										$sql=mysqli_query($con,"SELECT DISTINCT nuite_payee,ttc AS ttc,reserverch.avancerc FROM reserverch WHERE numresch='".$_SESSION['numreserv']."'");
									}

									if(($_GET['numresch']!='')|| ($_SESSION['numresch']!=''))
									{// echo "SELECT numfiche  FROM exonerer_tva WHERE numfiche='".$_GET['numresch']."'";
									$res=mysqli_query($con,"SELECT numfiche  FROM exonerer_tva WHERE numfiche='".$_GET['numresch']."'");
										while($ret=mysql_fetch_array($res))
											{ $numfiche_1=$ret['numfiche'];
											}
									 $or="SELECT distinct reserverch.nuite_payee,reserverch.avancerc,reserverch.ttc,reservationch.numresch,reservationch.nomdemch,reservationch.prenomdemch,reservationch.contactdemch,reservationch.numch,reservationch.datdepch,reservationch.avancerc,reservationch.montantrc FROM reservationch,reserverch WHERE reservationch.numresch=reserverch.numresch and reservationch.datarrivch='".date('Y-m-d')."' AND reservationch.numresch='".$_GET['numresch']."'";
									 $or1=mysqli_query($con,$or);
									 $sql=mysqli_query($con,"SELECT DISTINCT nuite_payee,reserverch.avancerc,ttc AS ttc FROM reserverch WHERE numresch='".$_GET['numresch']."'");
									 }

									if ($or1)
									{while ($roi= mysql_fetch_array($or1))
										{	$numresch=$roi['numresch'];
											$nom=$roi['nomdemch'];
											$prenoms=$roi['prenomdemch'];
											$contact=$roi['contactdemch'];
											$numch=$roi['numch'];
											$date_depart=substr($roi['datdepch'],8,2).'-'.substr($roi['datdepch'],5,2).'-'.substr($roi['datdepch'],0,4);
											$avancerc=$roi['avancerc'];
											$nuiterc=$roi['nuiterc'];
											$nuite_payee=(int)$roi['nuite_payee'];
											$i++;
										}

										$somme_avance=array("");$somme_montant=array("");$i=0;$somme_tva=array("");
										while($result= mysql_fetch_array($sql))
										{if(empty($numfiche_1))
											{$somme_avance[$i]=$result['ttc']*$result['nuite_payee'];
										     $somme_montant[$i]=$result['ttc'];}
										  else
											{$somme_avance[$i]=$result['avancerc']*$result['nuite_payee'];
										     $somme_montant[$i]=$result['ttc']*$result['nuite_payee'];
											 $somme_tva[$i]=$result['ttc']*$result['nuite_payee']*0.18;
											}
										 $i++;
										}
										$avance=array_sum($somme_avance);
										$montantrc=array_sum($somme_montant);
										$somme_tva=array_sum($somme_tva);
										if(empty($numfiche_1)) $somme_due=$montantrc-$avance; else if(!empty($avance)) $somme_due=0;
									}
                  if($numresch=='')
									$orA="SELECT DISTINCT SUM(reserverch.avancerc)/SUM(reserverch.mtrc) AS nuite FROM reserverch,reservationch where reservationch.numresch=reserverch.numresch AND reservationch.datarrivch='".date('Y-m-d')."' AND reservationch.numresch='".$_SESSION['numreserv']."'";
									else
									$orA="SELECT DISTINCT SUM(reserverch.avancerc)/SUM(reserverch.mtrc) AS nuite FROM reserverch,reservationch where reservationch.numresch=reserverch.numresch AND reservationch.datarrivch='".date('Y-m-d')."' AND reservationch.numresch='$numresch'";
									$orB=mysqli_query($con,$orA);
									if ($orB)
									{
										while ($roiB= mysql_fetch_array($orB))
										{
                          $nuite=(int)$roiB['nuite'];
										}
									}
								?>
								<tr>
									<td> &nbsp;&nbsp;&nbsp;&nbsp;N° de la r&eacute;servation: </td>
									<td>
										<input type='text' name='numreserv' id='' readonly value='<?php if($_GET['numresch']!='') echo $_GET['numresch']; else echo $_SESSION['numreserv']; ?> '>
												<?php
					                           echo "<input type='hidden' name='nom' id='' readonly value='$nom'>";
											   echo "<input type='hidden' name='prenoms' id='' readonly value='$prenoms'>";
											   echo "<input type='hidden' name='contact' id='' readonly value='$contact'>";
											    echo "<input type='hidden' name='numch' id='' readonly value='$numch'>";

												?>
									</td>
								    <td> Date de sortie: </td>
									<td>
										<input type='text' name='date_sortie' id='' readonly value='<?php echo $date_depart;?>'>
									</td>


									<td>  &nbsp;&nbsp;&nbsp;&nbsp;Montant TTC: </td>
									 <td> <input type='text' name='edit26' id='edit26' readonly value="<?php echo $montantrc;?>" /> </td>
								   <td> Avance Remise : </td>
									<td> <input type='text' name='edit30' id='edit30' readonly value="<?php if($avance=='') echo 0; else echo $avance;?>"/> </td>

								</tr>
								<tr>
								<td> &nbsp;&nbsp;&nbsp;&nbsp;Somme due : </td>
									 <td> <input type='text' name='edit31' id='edit31' readonly value="<?php echo $somme_due;?>"/> </td>
									<td> Nuite pay&eacute;e : </td>
									 <td> <input type='text' name='edit32' id='edit32' readonly value="<?php echo $nuite_payee;?>"/> </td>
									  <td> <?php if($_SESSION['codegrpe']!='') echo "<span style='color:red; font-style:italic;fint-size:0.7em;'> Arrivée en Groupe</span>" ; else  echo "<span style='color:red; font-style:italic;fint-size:0.7em;'> Arrivée Individuelle</span>" ;?> </td>
								</tr>
								<tr>


								</tr>
								</table>
								
								
								<table>
								<tr>
									<td colspan='4' align='center'> <?php ?> </td>
			<tr>
				<tr>
					<td>
						<fieldset style='border:2px solid white;background-color:#D0DCE0;font-family:Cambria;'>
							<legend align='' style='color:#3EB27B;'><b> FICHE DE RENSEIGNEMENT</b> </legend>
							<form action='fiche.php' method='post' id='form1' name='fiche' >
								<table style=''>
									<tr>
										<td width=''>&nbsp;&nbsp; Numéro de Fiche: </td>
										<td width=''> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='edit1' readonly value="<?php
	/* 									if($etat_facture=='AA')
										{   $chaine1 = substr(random($Nbre_char,''),0,3);
											$chaine2 = substr(random($Nbre_char,''),5,3);
											$year=(substr(date('Y'),3,1)+substr(date('Y'),2,1))-5;
											echo $chaine = $initial_fiche.$year.$chaine1.$chaine2;
										}
										if(($etat_facture=='AI'))
										{ */
										if(($num_fiche>=0)&&($num_fiche<=9))
													echo $initial_fiche.'0000'.$num_fiche ;
											else if(($num_fiche>=10)&&($num_fiche <=99))
													echo $initial_fiche.'000'.$num_fiche ;
											else if(($num_fiche>=100)&&($num_fiche<=999))
												echo $initial_fiche.'00'.$num_fiche ;
											else if(($num_fiche>=1000)&&($num_fiche<=1999))
													echo $initial_fiche.'0'.$num_fiche ;
											else
													echo $initial_fiche.$num_fiche ;

										//}
										?>"  /> </td>
							            <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										 Pour une arriv&eacute;e en groupe, <a href="fiche_groupe.php?etat_1=1" style="text-decoration:none;font-weight:bold;">Cliquez ici</a>
										<?php if((!empty($_GET['numcli']))||(!empty($_SESSION['numcli'])))
												{echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
												/* 	echo "Catégorie du client: <select name='NomCat' style='width:150px;'  /> ";
													echo "<option value='".$Categorie."'>Client ".$Categorie."</option> ";
													$ret=mysqli_query($con,"SELECT NomCat FROM categorieclient WHERE NomCat NOT IN ('$Categorie')");
													while ($ret1=mysqli_fetch_array($ret))
														{   //if($ret1[0]!=$Categorie){
															echo '<option value="'.$ret1['NomCat'].'">';
															echo "Client ".$ret1['NomCat'];
															echo '</option>';
															//}
														}

													echo "</select>"; */
													include ('others/categorie.php');
												}
											else
												echo "&nbsp;&nbsp;&nbsp;&nbsp;Pour consulter les notifications, <a href='notification.php' style='text-decoration:none;font-weight:bold;'>Cliquez ici</a>";

	$etat_2=!empty($etat_2)?$etat_2:NULL; $etat1=!empty($etat1)?$etat1:NULL; $etat2=!empty($etat2)?$etat2:NULL; $rlt_2=!empty($rlt_2)?$rlt_2:NULL;  $rlt_3=!empty($rlt_3)?$rlt_3:NULL;
	$edit2=!empty($edit2)?$edit2:NULL; $edit3=!empty($edit3)?$edit3:NULL; $edit4=!empty($edit4)?$edit4:NULL; $edit5=!empty($edit5)?$edit5:NULL; $edit6=!empty($edit6)?$edit6:NULL; $edit7=!empty($edit7)?$edit7:NULL;
	$edit8=!empty($edit8)?$edit8:NULL; $edit10=!empty($edit10)?$edit10:NULL;  $edit12=!empty($edit12)?$edit12:NULL;$edit13=!empty($edit13)?$edit13:NULL; $edit14=!empty($edit14)?$edit14:NULL; $edit15=!empty($edit15)?$edit15:NULL;
	$edit16=!empty($edit16)?$edit16:NULL; $edit17=!empty($edit17)?$edit17:NULL; $edit18=!empty($edit18)?$edit18:NULL;  $edit19=!empty($edit19)?$edit19:NULL;  $edit20=!empty($edit20)?$edit20:NULL; $edit_13=!empty($edit_13)?$edit_13:NULL;
	$edit_14=!empty($edit_14)?$edit_14:NULL; $edit21=!empty($edit21)?$edit21:NULL;$edit_15=!empty($edit_15)?$edit_15:NULL;
										?>
										<td>
									</tr>

								</table>
								<table>
									<tr>
										<td>
											<fieldset style='border:1px solid white;background-color:#D0DCE0;font-family:Cambria;'>
												<legend align='' style='color:#3EB27B;'><b> INFORMATIONS SUR L'IDENTITE DU CLIENT</b></legend>
												<table style=''>
													<tr>
														<td> Numero du Client: </td>
															<input type='hidden' name='advance' id='advance'   value=" <?php if(!empty($advance)) echo $advance; ?>"  >
															<input type='hidden' name='numero' id='numero' value=" <?php if(!empty($numero)) echo $numero; ?>" />
														<td> <input type='text' name='edit2' id='edit2' readonly style='<?php if($etat_2==1)echo"background-color:#FDF1B8;";?>' readonly value=" <?php if(!empty($rlt_1)) echo $rlt_1; if(!empty($_GET['numcli'])) echo $rlt1; if($etat_2!=1) echo $edit2; if(!empty($_SESSION['numcli'])) echo $_SESSION['numcli'];  ?>" required />  </td>
														<td> Nom: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<span style="font-style:italic;font-size:0.8em;color:black;"><a class='info' href='selection_client.php?fiche=1&<?php if(!empty($numero)) echo "numero=".$numero; ?>' style='text-decoration:none;color:#d10808;'>Rechercher
														<img src="logo/b_search.png" alt="" width='22' title=''/><span style='font-size:0.9em;color:maroon;'>Rechercher Client</span></span> </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<span style="font-style:italic;font-size:0.8em;color:black;"><a class='info' href='client.php?etat=1&fiche=1'style='text-decoration:none;color:#d10808;'>Nouveau
	                                                    <img src="logo/edit.png" alt="" title=''/><span style='font-size:0.9em;color:maroon;'>Nouveau Client</span></span></a></td>
														<td> <input type='text' name='edit3' id='edit3' style='<?php if($etat1==1)echo"background-color:#FDF1B8;";?>'readonly value=" <?php if($rlt_2!='') echo $rlt_2; if(!empty($_GET['numcli'])) echo $rlt2; if($etat1!=1) echo $edit3; if(!empty($_SESSION['numcli'])) echo $_SESSION['nomcli'];  ?>" /> </td>

														<input type='hidden' name='edit_03' id='edit_03' readonly />
														<td> Pr&eacute;noms: </td>
														<td> <input type='text' name='edit4'id='edit4' style='<?php if($etat2==1)echo"background-color:#FDF1B8;";?>' readonly value=" <?php if($rlt_3!='') echo $rlt_3; if(!empty($_GET['numcli'])) echo $rlt3;  if($etat2!=1) echo $edit4; if(!empty($_SESSION['numcli'])) echo $_SESSION['prenomcli']; ?>" /> </td>
													</tr>

													<tr>
														<td> Date de naissance: </td>
														<td> <input type='text' name='edit6' id='edit6' readonly value=" <?php if(!empty($rlt_5)) echo $rlt_5; if(!empty($_GET['numcli'])) echo $rlt5; if(!empty($etat6) && $etat6 !=1) echo $edit6;  if(!empty($_SESSION['numcli'])) echo $_SESSION['datenais'];  ?>"/> </td>
														<td> Lieu de naissance: </td>
														<td> <input type='text' name='edit7' id='edit7' readonly value=" <?php if(!empty($rlt_6)) echo $rlt_6; if(!empty($_GET['numcli'])) echo $rlt6; if(!empty($etat7) && $etat7!=1) echo $edit7;  if(!empty($_SESSION['numcli'])) echo $_SESSION['lieu'];   ?>"/> </td>

														<td> Pays d'origine: </td>
														<td> <input type='text' name='edit8' id='edit8' readonly value=" <?php if(!empty($rlt_13)) echo $rlt_13; if(!empty($_GET['numcli'])) echo $rlt13;if(!empty($etat8) && $etat8!=1) echo $edit8;  if(!empty($_SESSION['numcli'])) echo $_SESSION['pays'];  ?>"/> </td>
													</tr>
													<tr>
														<td> Sexe: </td>
														<td> <input type='text' name='edit5' id='edit5' readonly value=" <?php if(!empty($rlt_4)) echo $rlt_4; if(!empty($_GET['numcli'])) echo $rlt4;  if(!empty($etat5) && $etat5!=1) echo $edit5; if(!empty($_SESSION['numcli'])) echo $_SESSION['sexe'];  ?>"/> </td>
												<td> Etat-civil: </td>
														<td>
															<select name='combo2' style='width:145px; <?php if(!empty($etat11) && $etat11==1)echo"background-color:#FDF1B8;";?>'>
																<option value='<?php if(isset($combo2) && !empty($combo2)) echo $combo2;   else echo "";?>'>  <?php echo $combo2; ?></option>
																<option value='Célibataire'>Célibataire</option>
																<option value='Marié'>Marié</option>
															</select>
														</td>
														<td> Profession: </td>
														<td>
															<select name='edit9'style='width:145px;<?php if(!empty($etat12) && $etat12==1)echo"background-color:#FDF1B8;";?>'>
																<option value='<?php if(!empty($edit9)) echo $edit9;  ?>'> <?php echo $edit9;  ?></option>
																<option value='Libérale'>Libérale</option>
																<option value='Ouvrier'>Ouvrier</option>
																<option value='Employé'>Employé</option>
																<option value='Cadre'>Cadre</option>
																<option value='Inactif'>Inactif</option>
																<option value='Divers'>Divers</option>
															</select>
														</td>
													</tr>
													<tr>
														<td> Domicile habituel: </td>
														<td> <input type='text' name='edit10'onkeyup='this.value=this.value.toUpperCase()' style='<?php $etat10=(!empty($etat10)&&($etat10==1))?$etat10:NULL;  //echo"background-color:#FDF1B8;";?>' value="<?php if($etat10!=1) echo $edit10;  ?>" /> </td>
														<td> Nombre d'enfant de moins de 15 ans accompagnants: </td>
														<td> <input type='text' name='edit11' style='<?php   $etat13=(!empty($etat13)&&($etat13==1))?$etat13:NULL; //echo"background-color:#FDF1B8;";?>' value="<?php  echo 0;?>" onkeypress="testChiffres(event);"/> </td>
																<td> Contact: </td>
														<td> <input type='text' name='edit12'style='<?php $etat14=(!empty($etat14)&&($etat14==1))?$etat14:NULL; //echo"background-color:#FDF1B8;";?>' value="<?php if(!empty($rlt_14)) echo $rlt_14; if(!empty($_GET['numcli'])) echo $rlt14;if($etat14!=1) echo $edit12; if(!empty($_SESSION['numcli'])) echo $_SESSION['contact'];  ?>" onkeypress="testChiffres(event);"/> </td>
													</tr>

												</table>
											</fieldset>
										</td>
									</tr>
									<tr>
										<td>
											<fieldset style='border:1px solid white;background-color:#D0DCE0;font-family:Cambria;'>
												<legend style='color:#3EB27B;'><b> TYPE DE PIECE D'IDENTITE </b></legend>
												<table style=''>
													<tr>
														<td> Type de pièce: </td>
														<td> <input type='text' name='edit_9'  id='edit_9'size='30' readonly value=" <?php if(!empty($rlt_8)) echo $rlt_8; if(!empty($_GET['numcli'])) echo strtoupper($rlt8);if(!empty($etat15) && $etat15!=1) echo $edit_9; if(!empty($_SESSION['numcli'])) echo $_SESSION['piece']; ?>" />  </td>
														<td> Numéro de pièce: </td>
														<td> <input type='text' name='edit_13'   id='edit_13' size='30' readonly value=" <?php  if(!empty($rlt_9)) echo $rlt_9; if(!empty($_GET['numcli'])) echo $rlt9;if(!empty($etat16) && $etat16!=1) echo $edit_13; if(!empty($_SESSION['numcli'])) echo $_SESSION['numpiece'];  ?>" /> </td>
														<td> Délivrée le: </td>
														<td> <input type='text' name='edit_14'  id='edit_14' size='30' readonly value=" <?php if(!empty($rlt_10)) echo $rlt_10; if(!empty($_GET['numcli'])) echo $rlt10;if(!empty($etat17) && $etat17!=1) echo $edit_14; if(!empty($_SESSION['numcli'])) echo $_SESSION['le']; ?>" /> </td>
													</tr>

													<tr>
														<td> à: </td>
														<td> <input type='text' name='edit_15'    id='edit_15' size='30' readonly value=" <?php if(!empty($rlt_11))  echo $rlt_11; if(!empty($_GET['numcli'])) echo $rlt11;if(!empty($etat18) && $etat18!=1) echo $edit_15; if(!empty($_SESSION['numcli'])) echo $_SESSION['a']; ?>" onKeyup="ucfirst(this)"/> </td>
														<td> Par: </td>
														<td> <input type='text' name='edit_16'   id='edit_16' size='30' readonly value=" <?php  if(!empty($rlt_12)) echo $rlt_12; if(!empty($_GET['numcli'])) echo $rlt12;if(!empty($etat19) && $etat19!=1) echo $edit_16; if(!empty($_SESSION['numcli'])) echo $_SESSION['par'];  ?>" onKeyup="ucfirst(this)"/> </td>
														<td> <input type='hidden' name='edit18' id='edit18' value="<?php echo date('Y-m-d') ?>" readonly /> </td>
													</tr>
												</table>
											</fieldset>
										</td>
									</tr>
									<tr>
										<td>
											<fieldset style='border:1px solid white;background-color:#D0DCE0;font-family:Cambria;'>
												<legend style='color:#3EB27B;'><b>SEJOUR </b></legend>
												<table style=''>
													<tr>
														<td> Motif du Séjour: </td>
														<td colspan=''>

															<select name='edit17'style='width:145px;<?php $etat20=(!empty($etat20)&&($etat20==1))?$etat20:NULL; //echo"background-color:#FDF1B8;";?>'>
																<option value='<?php if(!empty($edit17)) echo $edit17;?>'> <?php echo $edit17;?></option>
																<option value='Vacances/Loisirs'>Vacances/Loisirs</option>
																<option value='Affaires'>Affaires</option>
																<option value='Parents et Amis'>Parents et Amis </option>
																<option value='Professionnel'>Professionnel</option>
																<option value='Autre'>Autre but</option>
															</select>
														</td>
													    <td> Date d'arrivée: </td>
														<td> <input type='text' name='edit_2' id='edit_2' value="<?php
														echo date("d-m-Y"); ?>" readonly onKeyup="ucfirst(this)"/> </td>
														<td> Venant de: </td>
														<td> <input type='text' name='edit19' onKeyup="ucfirst(this)"onKeyup="ucfirst(this)"  style='<?php $etat1_40=(!empty($etat1_40)&&($etat1_40==1))?$etat1_40:NULL; //echo"background-color:#FDF1B8;";?>' value="<?php if($etat1_40!=1) echo $edit21; ?>"/> </td>
													</tr>

													<tr>
														<td> Date de sortie: </td>
													  <td style=" border: 0px solid black;"><input type="text" name="ladate" id="ladate" size="20" readonly style='<?php $etat1_4=(!empty($etat1_4)&&($etat1_4==1))?$etat1_4:NULL; ?>' value="<?php if($etat1_4!=1) if(!empty($ladate)) echo $ladate; ?>" />
														   <a class='info'  href="javascript:show_calendar('fiche.ladate');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
															 <img src="logo/cal.gif" style="border:1px solid yellow;" alt="Calendrier" title=""><span style='font-size:0.8em;color:maroon;'>Calendrier</span></a>
													  </td>
														<input type='hidden' name='nui' id='nui'/>
														<td> Allant à : </td>
														<td> <input type='text' name='edit21' onKeyup="ucfirst(this)" style='<?php if($etat1_40==1)echo"background-color:#FDF1B8;";?>' value="<?php $etat1_40=(!empty($etat1_40)&&($etat1_40!=1))?$etat1_40:NULL; echo $edit21; ?>"/> </td>
														<td> Mode de transport: </td>
														<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														A&eacute;rien <input type='radio' name='rad' value='air'/> </td>
														<td> Maritime <input type='radio' name='rad' value='mer'/></td>
														<td> Terrestre <input type='radio' CHECKED  name='rad' value='terre' /> </td>
													</tr>
												</table>
											</fieldset>
										</td>
									</tr>
									<tr>
										<td align='center'> <br/><input type='submit' name='ok' class='mybutton' value='VALIDER' style='border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;padding:0px 4px 0px 4px;'/> </td>
									</tr>
								</table>
							</form>
						</fieldset>
					</td>
				</tr>
			</table>
			<?php if(!empty($msg_1)) echo $msg_1;
			$_SESSION['numcli']='';	$_SESSION['nomcli']='';	$_SESSION['prenomcli']='';$_SESSION['ladate']='';$_SESSION['lieu']='';$_SESSION['pays']='';$_SESSION['sexe']='';
			$_SESSION['piece']='';  $_SESSION['numpiece']='';$_SESSION['le']='';$_SESSION['a']='';$_SESSION['par']='';$_SESSION['contact']='';

			$test = "DELETE FROM chambre_tempon";
			$reqsup = mysqli_query($con,$test) or die(mysqli_error($con));

			$test = "DELETE FROM avance_tempon";
			$reqsup = mysqli_query($con,$test) or die(mysqli_error($con));

	/* 		$test = "DELETE FROM encaissement WHERE encaissement.ttc_fixe=0";
			$reqsup = mysql_query($test) or die(mysql_error()); */

	/* 		$test = "DELETE FROM fiche2 WHERE fiche2.numcli_2=''";
			$reqsup = mysql_query($test) or die(mysql_error()); */


	/* 		$sql3=mysqli_query($con,"SELECT num_encaisse,ttc_fixe,tarif FROM encaissement"); // A effacer après tout reajustement
			while($row_1=mysqli_fetch_array($sql3))
			{  $num_encaisse= $row_1['num_encaisse'];$ttc_fixe= $row_1['ttc_fixe'];
					if($ttc_fixe==12000)
						$req=mysqli_query($con,"UPDATE encaissement SET tarif='9322.0339'	 WHERE num_encaisse='".$num_encaisse."'");
					if($ttc_fixe==14000)
						$req=mysqli_query($con,"UPDATE encaissement SET tarif='10169.4916' WHERE num_encaisse='".$num_encaisse."'");
					if($ttc_fixe==7500)
						$req=mysqli_query($con,"UPDATE encaissement SET tarif='5508.4746'	 WHERE num_encaisse='".$num_encaisse."'");
					if($ttc_fixe==9500)
						$req=mysqli_query($con,"UPDATE encaissement SET tarif='6355.9323'	 WHERE num_encaisse='".$num_encaisse."'");
			} */
			?>
			<table align='center'style='margin-top:80px;'>
				<tr>
					<td style='color:#76A2AC;'><i><u>Attention</u>: Pour les reservations en cours, le système opère une défalcation automatique de l'avance quand le client ne se présente pas.</i> </td>
				</tr>
			</table>
			</div>
		</body>
		<script type="text/javascript">
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
					xhr.open("POST","others/fnomcli.php",true);
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
					xhr.open("POST","others/fprenomcli.php",true);
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
					xhr.open("POST","others/fsexecli.php",true);
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
					xhr.open("POST","others/fdatnaisscli.php",true);
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
					xhr.open("POST","others/typepiece.php",true);
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
					xhr.open("POST","others/numeropiece.php",true);
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
					xhr.open("POST","others/datepiece.php",true);
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
					xhr.open("POST","others/lieupiece.php",true);
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
					xhr.open("POST","others/livreurpiece.php",true);
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
					xhr.open("POST","others/flieucli.php",true);
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
					xhr.open("POST","others/fpayscli.php",true);
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
					xhr.open("POST","others/ftypech.php",true);
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
					xhr.open("POST","others/ftarif.php",true);
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
