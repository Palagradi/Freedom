<?php
include_once'menu.php'; unset($_SESSION['Nprecedente']);
	mysqli_query($con,"SET NAMES 'utf8'");  //echo $_SESSION['periode'];

		$val="Jour";$se5="Mois";$se6="Année";$combo2="";$edit9="";$edit17=""; $numcli=!empty($_GET['numcli'])?$_GET['numcli']:NULL;
		$reqsel=mysqli_query($con,"SELECT * FROM client WHERE numcli ='".$numcli."' ");
		while($data=mysqli_fetch_array($reqsel))
			{  $rlt1=$data['numcli'];    $rlt2=$data['nomcli'];   $rlt3=$data['prenomcli'];   $rlt4=$data['sexe'];  $rlt5=$data['datnaiss'];  $rlt6=$data['lieunaiss'];   $rlt8=$data['typepiece'];
			   $rlt9=$data['numiden'];   $rlt10=$data['date_livrais'];  $rlt11=$data['lieudeliv'];   $rlt12=$data['institutiondeliv'];  $rlt13=$data['pays'];  $rlt14=$data['adresse'];
			}
		if (isset($_POST['CONTINUER'])&& $_POST['CONTINUER']=='CONTINUER')
		{header('location:selection_chambre.php?menuParent=Hébergement');
		}
	mysqli_query($con,"SET NAMES 'utf8'");
		$reqsel=mysqli_query($con,"SELECT * FROM configuration_facture");
		while($data=mysqli_fetch_array($reqsel))
			{  $num_fiche=$data['num_fiche'];   $num_fact=$data['num_fact'];  $etat_facture=$data['etat_facture'];  $initial_grpe=$data['initial_grpe'];  $initial_reserv=$data['initial_reserv'];
			   $initial_fiche=$data['initial_fiche'];    $Nbre_char=$data['Nbre_char']; $limite_jrs=$data['limite_jrs'];
			}
	//enregistrement de la fiche
	if (isset($_POST['ok'])&& $_POST['ok']=='VALIDER')
		{ $date1=$Jour_actuel ; //$date2=substr($_POST['ladate'],6,4).'-'.substr($_POST['ladate'],3,2).'-'.substr($_POST['ladate'],0,2);
			$date2=$_POST['ladate'];
			if($date1==$date2) $date2=date("Y-m-d", mktime(0, 0, 0,date($month),date($datej)+1,date($year)));
			$exec=mysqli_query($con,"SELECT DATEDIFF('$date2','$date1') AS DiffDate");
			$row_Recordset1 = mysqli_fetch_assoc($exec);
			$row_Recordset=$row_Recordset1['DiffDate'];
			 $heure=(date('H'));	//echo abs($row_Recordset);
			 if(($row_Recordset>0)||(abs($row_Recordset)==0))
			//if(($row_Recordset>0)|| ((($heure>=00)&&($heure<=05))&&(abs($row_Recordset)==0)))
			{
			if($row_Recordset==0)	$row_Recordset++;
			$_SESSION['Nuite']= $row_Recordset; $_SESSION['motif']=$_POST['edit17'];   $_SESSION['date_arrive2']=$_POST['edit_2'];	 $_SESSION['dateSortie']=$_POST['ladate'];
		  $_SESSION['venant']=$_POST['edit19'];  $_SESSION['allant']=$_POST['edit21']; if($_SESSION['Nuite']>$_SESSION['limite_jrs']) {
			$_SESSION['num']=$_POST['edit1'];
			$_SESSION['cli']=$_POST['edit3'].' '.$_POST['edit4'];
			if (isset($_SESSION['num']) && !empty($_SESSION['num']))
				{   //vérification d'unicité de numéro de fiche
					$Recordset1=mysqli_query($con,"SELECT * FORM fiche1 WHERE numfiche='".$_SESSION['num']."'");
					if (!$Recordset1)
					{   //$_SESSION['numerof']=addslashes($_POST['edit1']);
						mysqli_query($con,"SET NAMES 'utf8' ");
						//vérifivation de disponibilité de chambre
							$datdeliv=$_POST['se3'].'-'.$_POST['se2'].'-'.$_POST['se1'];
							$heure=(date('H')); $minuite=(date('i'));
							$jr=substr($_POST['edit18'],8,2);
							$mois=substr($_POST['edit18'],5,2);
							$ans=substr($_POST['edit18'],0,4);

							$heure=$Heureh;
							$jour=$datej;$mois=$month;$ans=$year; //$jour=date("d");$mois=date("m");$ans=date("Y");
							if(($heure>=00)&&($heure<06))
								$datarriv=date("Y-m-d", mktime(0, 0, 0,date($mois),date($jour)-1,date($ans)));
							else
								$datarriv=addslashes($_POST['edit18']);

							//$datarriv=isset($_POST['edit18'])?$_POST['edit18']:NULL;
							$datdep=addslashes($_POST['ladate']);
							$_SESSION['date_arrive']=$datarriv;
							$etat='RAS';
							$p1=addslashes($_POST['edit1']);$p2=addslashes($_POST['edit2']);$p3=addslashes($_POST['combo2']);$p4=addslashes($_POST['edit9']);$p5=addslashes($_POST['edit10']);
							$p6=!empty($_POST['edit11'])?$_POST['edit11']:0;$p7=addslashes($_POST['edit12']);$p8=addslashes($_POST['edit_9']);$p9=addslashes($_POST['edit_13']);$p10=addslashes($_POST['edit_14']);
							$p11=addslashes($_POST['edit_15']);$p12=addslashes($_POST['edit_16']);$p17=addslashes($_POST['edit17']);$p18=addslashes($_POST['edit19']);$p18=addslashes($_POST['edit21']);
							if(($p1!='')AND($p2!='')AND($p3!='')AND($p4!='')AND($p5!='')AND($p7!='')AND($p8!='')AND($p9!='')AND($p10!='')AND($p11!='')AND($p12!='')AND($p17!='')AND($p18!='')AND($_POST['ladate']!='')){
							
							//$Query1=mysqli_query($con,"SELECT MAX(Periode) AS Periode FROM fiche1 WHERE codegrpe='".$_SESSION['groupe']."' AND codegrpe <>''");
							//$data1=mysqli_fetch_object($Query1); $data1->Periode;
							//$periode=isset($data1->Periode)?(1+$data1->Periode):1;	  
							
							$ret="INSERT INTO fiche1 VALUES('$p1','".$_POST['edit_1']."','$p2','','".$_SESSION['periode']."','".$_SESSION['groupe']."','$p3','$p4','$p5','$p17','".$datarriv."','".$datarriv."','$p18','$date2','$date2','$Heure_actuelle','$p18','".$_POST['rad']."',
								'".$etat."','".$_SESSION['re']."','','".$_SESSION['login']."','".$_SESSION['login']."','".$_SESSION['Nuite']."','OUI')";
							$req=mysql_query($ret);
								if ($req)
								{  $ret="INSERT INTO view_fiche2 VALUES('$p1','".$_POST['edit_1']."','','".$_SESSION['groupe']."','$p3','$p4','$p5','$p17','".$datarriv."','".$datarriv."','$p18','$date2','$date2','$Heure_actuelle','$p18','".$_POST['rad']."',
								'".$etat."','".$_SESSION['re']."','','".$_SESSION['login']."','".$_SESSION['login']."','".$_SESSION['Nuite']."','OUI')";
								$req=mysql_query($ret);
								$reqA=mysqli_query($con,"INSERT INTO mensuel_fiche1 VALUES('$p1','".$_POST['edit_1']."','','".$_SESSION['periode']."','".$_SESSION['groupe']."','$p3','$p4','$p5','$p17','".$datarriv."','".$datarriv."','$p18','$date2','$date2','$Heure_actuelle','$p18','".$_POST['rad']."','".$etat."','".$_SESSION['re']."','','".$_SESSION['login']."','".$_SESSION['login']."','".$_SESSION['Nuite']."','OUI')");
								$ret="INSERT INTO mensuel_view_fiche2 VALUES('$p1','".$_POST['edit_1']."','','".$_SESSION['groupe']."','$p3','$p4','$p5','$p17','".$datarriv."','".$datarriv."','$p18','$date2','$date2','12:00','$p18','".$_POST['rad']."',
								'".$etat."','".$_SESSION['re']."','','".$_SESSION['login']."','".$_SESSION['login']."','".$_SESSION['Nuite']."','OUI')";
								$req=mysql_query($ret);
								$update=mysqli_query($con,"UPDATE configuration_facture SET num_fiche=num_fiche+1  WHERE num_fiche!=''");
								}
							}else {
							echo "<script language='javascript'>";
							echo " alert('Les champs en couleur sont vides');";
							echo "</script>";
							}
				    }

				}
				header('location:avertissement.php?menuParent=Hébergement');	}
		     else if ($_SESSION['Nuite']<$_SESSION['limite_jrs'])
			   {//$_SESSION['Nuite']=$_POST['nui'];
				$_SESSION['num']=$_POST['edit1'];
				$_SESSION['cli']=$_POST['edit3'].' '.$_POST['edit4'];
			if (isset($_SESSION['num']) && !empty($_SESSION['num']))
				{//$_SESSION['nombre3']=$_SESSION['nombre1'];
				if ($_SESSION['nombre1']>0)
				    {	//vérification d'unicité de numéro de fiche
					$Recordset1=mysqli_query($con,"SELECT * FORM fiche1 WHERE numfiche='".$_SESSION['num']."'");
					if (!$Recordset1)
					{
						mysqli_query($con,"SET NAMES 'utf8' ");
						//vérifivation de disponibilité de chambre
							//$datdeliv=$_POST['se3'].'-'.$_POST['se2'].'-'.$_POST['se1'];
							$heure=(date('H')); $minuite=(date('i'));
							$jr=substr($_POST['edit18'],8,2);
							$mois=substr($_POST['edit18'],5,2);
							$ans=substr($_POST['edit18'],0,4);
							//if(($heure<=04)&&($minuite<59))
							//$datarriv=date("Y/m/d", mktime(0,0,0,date($mois),date($jr)-1,date($ans)));
							//else
							//$datarriv=$_POST['edit18'];

							$heure=$Heureh;
							$jour=$datej;$mois=$month;$ans=$year; //$jour=date("d");$mois=date("m");$ans=date("Y");
							if(($heure>=00)&&($heure<07))
								{ $_SESSION['Nprecedente']=1;
									$datarriv=date("Y-m-d", mktime(0, 0, 0,date($mois),date($jour)-1,date($ans)));
								}
							else
								$datarriv=addslashes($_POST['edit18']);

							$datdep=addslashes($_POST['ladate']);
							 $_SESSION['date_arrive']=$datarriv;
		                    //$nombre=1;
							$etat='NON';  $numresch=!empty($_SESSION['re'])?$_SESSION['re']:NULL;
							$p1=addslashes($_POST['edit1']);$p2=addslashes($_POST['edit2']);$p2=trim($p2);$p3=addslashes($_POST['combo2']);$p4=addslashes($_POST['edit9']);$p5=addslashes($_POST['edit10']);
							$p6=!empty($_POST['edit11'])?$_POST['edit11']:0;$p7=addslashes($_POST['edit12']);$p8=addslashes($_POST['edit_9']);$p9=addslashes($_POST['edit_13']);$p10=addslashes($_POST['edit_14']);
							$p11=addslashes($_POST['edit_15']);$p12=addslashes($_POST['edit_16']);$p17=addslashes($_POST['edit17']);$p18=addslashes($_POST['edit19']);$p18=addslashes($_POST['edit21']);
						if(($p1!='')AND($p2!=''))
						{  $rad=isset($_POST['rad'])?$_POST['rad']:NULL;
							$ret="INSERT INTO fiche1 VALUES('$p1','".$_POST['edit_1']."','$p2','','".$_SESSION['periode']."','".$_SESSION['groupe']."','$p3','$p4','$p5','$p6','$p17','".$datarriv."','".$datarriv."','$p18','$date2','$date2','$Heure_actuelle','$p18','".$rad."',
								'".$etat."','".$numresch."','','".$_SESSION['login']."','".$_SESSION['login']."','".$_SESSION['Nuite']."','NON')";
							$req=mysqli_query($con,$ret);
							if ($req)
							{   $req = "UPDATE images SET numfiche='".$_POST['edit1']."',numcli='".$p2."' WHERE  numfiche=''";
								$ret = mysqli_query ($con,$req) or die (mysqli_error ($con));

								$update=mysqli_query($con,"UPDATE configuration_facture SET num_grpe=num_grpe+1");
								 $ret="INSERT INTO view_fiche2 VALUES('$p1','".$_POST['edit_1']."','','".$_SESSION['groupe']."','$p3','$p4','$p5','$p6','$p17','".$datarriv."','".$datarriv."','$p18','$date2','$date2','$Heure_actuelle','$p18','".$rad."',
								'".$etat."','".$numresch."','','".$_SESSION['login']."','".$_SESSION['login']."','".$_SESSION['Nuite']."','NON')";
								$req=mysqli_query($con,$ret);
								$ret="INSERT INTO mensuel_fiche1 VALUES('$p1','".$_POST['edit_1']."','$p2','','".$_SESSION['periode']."','".$_SESSION['groupe']."','$p3','$p4','$p5','$p6','$p17','".$datarriv."','".$datarriv."','$p18','$date2','$date2','$Heure_actuelle','$p18','".$rad."',
								'".$etat."','".$numresch."','','".$_SESSION['login']."','".$_SESSION['login']."','".$_SESSION['Nuite']."','NON')";
								$req=mysqli_query($con,$ret);
								 $update=mysqli_query($con,"UPDATE configuration_facture SET num_grpe=num_grpe+1");
								 $ret="INSERT INTO mensuel_view_fiche2 VALUES('$p1','".$_POST['edit_1']."','','".$_SESSION['groupe']."','$p3','$p4','$p5','$p6','$p17','".$datarriv."','".$datarriv."','$p18','$date2','$date2','$Heure_actuelle','$p18','".$rad."',
								'".$etat."','".$numresch."','','".$_SESSION['login']."','".$_SESSION['login']."','".$_SESSION['Nuite']."','NON')";
								$req=mysqli_query($con,$ret);
								$update=mysqli_query($con,"UPDATE configuration_facture SET num_fiche=num_fiche+1");

								$_SESSION['nombre_01']++;
								 $_SESSION['nombre1']=$_SESSION['nombre1']-1;
								// $nombre++;
							 	 if($_SESSION['nombre1']==0) {
								 $_SESSION['numero']=$_POST['edit1'];
								 header('location:selection_chambre.php?menuParent=Hébergement');
								 }else {
								echo "<script language='javascript'>";
								echo 'alertify.success(" Enrégistrement effectué !");';
								echo "</script>";
								//echo '<meta http-equiv="refresh" content="1; url=fiche_groupe2.php?menuParent=Hébergement" />';
								header('location:fiche_groupe2.php?menuParent=Hébergement');
								//unset($rlt1);  unset($rlt2);unset($rlt3);unset($rlt4);unset($rlt5);unset($rlt6);unset($rlt7);unset($rlt8);unset($rlt9);
								//unset($rlt10);unset($rlt11);unset($rlt12);unset($rlt13);unset($rlt14);
								 }

							}

							}else {
							echo "<script language='javascript'>";
							echo " alert('Les champs en couleur sont vides');";
							echo "</script>";

							}
				     }
				  }
				}
			    else
				header('location:warning_date.php?menuParent=Hébergement');
         }
		 }else {"<script language='javascript'>alert('La date de départ doit être supérieure à la date du jour'); </script>";
		 }
		}else {
				if(isset($_FILES['cpi'])) {$style="color:normal;";
				$img_blob = file_get_contents ($_FILES['cpi']['tmp_name']);
				if(!empty($img_blob)){
				$req = "INSERT INTO images SET img_id=NULL,numfiche='',numcli='',img_blob='".addslashes($img_blob)."' ";
				$ret = mysqli_query ($con,$req) or die (mysqli_error ($con));}

						if($_FILES['cpi']['size']>150000){
						echo "<script language='javascript'>";
						echo 'alertify.error("Le fichier dépasse la limite autorisée par le serveur: 150 Ko ");';
						echo "</script>";}
				}else {$style="color:white;";
				$req="DELETE FROM  images WHERE numfiche =''";
				$ret = mysqli_query ($con,$req) or die (mysqli_error ($con));
				}

		}
  $res=mysqli_query($con,"DELETE FROM NbreDouble");	//$res=mysqli_query($con,"DELETE FROM client_tempon");
  unset($_SESSION['np']);  unset($_SESSION['numch']);  unset($_SESSION['mt']);  unset($_SESSION['Mttc1']); unset($_SESSION['numero_c']);
  unset($_SESSION['type_occupation1']); unset($_SESSION['type_chambre']); unset($_SESSION['tarif1']);unset($_SESSION['Ttaxe']);
  unset($_SESSION['taxe1']);	unset($_SESSION['Ttva1']);	 unset($_SESSION['TVA1']);
?>

<html>
	<head>
		<script type="text/javascript" src="js/date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script type="text/javascript" src="js/verifyCheckBoxes1.js"></script>
		<link rel="Stylesheet" type="text/css"  href='css/input.css' />
		<link rel="Stylesheet" href='css/table.css' />
		<style>
		<?php
		if(!empty($_GET['zoom']))
			echo "
			select, input[type=text]{
			 font-family:cambria;
			}";
		?>
			td {
			  padding: 2px 0;
			}
		</style>
	</head>
	<body bgcolor='azure' style="margin-top:-20px;padding-top:0px;">
	<div align="" style="">
		<table align='center'style='' id="tab" >
			<tr>
				<td>
					<fieldset style='border:0px solid white;background-color:#D0DCE0;font-family:Cambria;'>
						<legend align='left' style='color:#046380;font-size:125%;'><b> FICHE DE RENSEIGNEMENT</b> </legend>
						<form action='fiche_groupe2.php?menuParent=Hébergement<?php if(isset($_GET['numcli'])) echo "&numcli=".$_GET['numcli'];else if(!empty($_SESSION['numcli'])) echo "&numcli=".$_SESSION['numcli']; else { }?>' method='post'  name='form1' id='form1' enctype='multipart/form-data'>
							<table align='center' style=''>
								<tr>
									<td width=''>  Numéro du groupe : &nbsp;</td>
									<td width=''>  <input type='text' name='edit_1' value="<?php
									echo $_SESSION['combo1'];?>" readonly /> </td>
									 <input type='hidden' name='edit1' value="<?php echo $Num_fiche ; ?>"/>
						            <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<b style='color:#046380;'>
									Check-in Group&eacute;:&nbsp; <?php echo"<span style='color:green;'>".substr($_SESSION['groupe'],0,20)."</span>"; ?></b> <td>
									<td width=''>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									Nbre d'occupants : </td>
									<td width=''> &nbsp;&nbsp;&nbsp;<input type='text' name='edit_p' style="width:75px;" value="<?php echo $_SESSION['nombre_1'];?>" readonly  /> </td>
								</tr>
								<tr>
									<td>&nbsp;
									</td>
								</tr>
							</table>
					</fieldset>
				</td>
			</tr>
			<?php
			$etat_2=!empty($etat_2)?$etat_2:NULL; $etat1=!empty($etat1)?$etat1:NULL; $etat2=!empty($etat2)?$etat2:NULL; $rlt_2=!empty($rlt_2)?$rlt_2:NULL;  $rlt_3=!empty($rlt_3)?$rlt_3:NULL;
			$edit2=!empty($edit2)?$edit2:NULL; $edit3=!empty($edit3)?$edit3:NULL; $edit4=!empty($edit4)?$edit4:NULL; $edit5=!empty($edit5)?$edit5:NULL; $edit6=!empty($edit6)?$edit6:NULL; $edit7=!empty($edit7)?$edit7:NULL;
			$edit8=!empty($edit8)?$edit8:NULL; $edit10=!empty($edit10)?$edit10:NULL;  $edit12=!empty($edit12)?$edit12:NULL;$edit13=!empty($edit13)?$edit13:NULL; $edit14=!empty($edit14)?$edit14:NULL; $edit15=!empty($edit15)?$edit15:NULL;
			$edit16=!empty($edit16)?$edit16:NULL; $edit17=!empty($edit17)?$edit17:NULL; $edit18=!empty($edit18)?$edit18:NULL;  $edit19=!empty($edit19)?$edit19:NULL;  $edit20=!empty($edit20)?$edit20:NULL; $edit_13=!empty($edit_13)?$edit_13:NULL;
			$edit_14=!empty($edit_14)?$edit_14:NULL; $edit21=!empty($edit21)?$edit21:NULL;$edit_15=!empty($edit_15)?$edit_15:NULL; $etat6=!empty($etat6)?$etat6:NULL;$etat5=!empty($etat5)?$etat5:NULL;
			$etat7=!empty($etat7)?$etat7:NULL;$etat8=!empty($etat8)?$etat8:NULL;$etat9=!empty($etat9)?$etat9:NULL;$etat10=!empty($etat10)?$etat10:NULL;$etat11=!empty($etat11)?$etat11:NULL;
			$etat12=!empty($etat12)?$etat12:NULL;$etat13=!empty($etat13)?$etat13:NULL;$etat14=!empty($etat14)?$etat14:NULL;$etat15=!empty($etat15)?$etat15:NULL;$etat16=!empty($etat16)?$etat16:NULL;
			$etat17=!empty($etat17)?$etat17:NULL;$etat18=!empty($etat18)?$etat18:NULL;$etat19=!empty($etat19)?$etat19:NULL;$edit11=!empty($edit11)?$edit11:NULL; $edit_9=!empty($edit_9)?$edit_9:NULL; $edit_16=!empty($edit_16)?$edit_16:NULL;
			?>
			<tr>
				<td>
					<fieldset style='border:0px solid white;background-color:#D0DCE0;font-family:Cambria;'>
                    <table>	<tr>
									<td>
											<fieldset style='margin-top:-15px;border:2px solid white;background-color:#D0DCE0;font-family:Cambria;'>
											<legend align='left' style='color:#046380;font-size:110%;'><b> INFORMATIONS SUR LE SEJOUR </b></legend>
											<table style=''>
												<tr>
													<td> Motif du Séjour : </td>
													<td colspan=''>

														<select required name='edit17'style="font-size:0.9em;">
															<option value='<?php if(!empty($_SESSION['motif'])) echo $_SESSION['motif']; ?>'> <?php  if(!empty($_SESSION['motif'])) echo $_SESSION['motif']; ?></option>
															<option value='Vacances/Loisirs'>Vacances/Loisirs</option>
															<option value=''></option>
															<option value='Affaires'>Affaires</option>
															<option value=''></option>
															<option value='Parents et Amis'>Parents et Amis </option>
															<option value=''></option>
															<option value='Professionnel'>Professionnel</option>
															<option value=''></option>
															<option value='Autre'>Autre but</option>
														</select>
													</td>
												    <td> &nbsp;&nbsp;Date d'arrivée : </td>
													<td> <input type='text' name='edit_2' id='edit_2' value="<?php if(!empty($_SESSION['date_arrive2'])) echo $_SESSION['date_arrive2']; else echo $Date_actuel2; ?>" readonly /> </td>
													<td> &nbsp;&nbsp;Venant de : </td>
													<td> <input required type='text' name='edit19' onkeyup='this.value=this.value.toUpperCase()' value="<?php if(!empty($_SESSION['venant'])) echo $_SESSION['venant']; ?>"/> </td>
												</tr>

												<tr>
													<td> Date de sortie : </td>
								 <td style=" border: 0px solid black;"><input required type="date" name="ladate" id="ladate" size="20"  value="<?php if(!empty($_SESSION['dateSortie'])) echo $_SESSION['dateSortie'];  ?>" />
									   <!-- <a class='info'  href="javascript:show_calendar('form1.ladate');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
										<img src="logo/cal.gif" style="border:1px solid yellow;" alt="Calendrier" title=""><span style='font-size:0.8em;color:maroon;'>Calendrier</span></a>  !-->
						          </td>
													<td> &nbsp;&nbsp;Allant à : </td>
													<td> <input required type='text' name='edit21' onkeyup='this.value=this.value.toUpperCase()' value="<?php if(!empty($_SESSION['allant'])) echo $_SESSION['allant']; ?>"/> </td>
													<td> &nbsp;&nbsp;Mode de transport : </td>
													<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="checkbox" id="button_checkbox_1"  onClick="verifyCheckBoxes1();" value='air' name='rad' ><label for="button_checkbox_1" >A&eacute;rien	</label></td>
													<td> <input type='checkbox'  id="button_checkbox_2"  onClick="verifyCheckBoxes2();" value='mer' name='rad'><label for="button_checkbox_2">Maritime</label></td>
													<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type='checkbox'  id="button_checkbox_3"  onClick="verifyCheckBoxes3();" value='terre' checked="checked" name='rad'>
													<label for="button_checkbox_3">Terrestre</label></td>
												</tr>
											</table>
										</fieldset>
									</td>
								</tr>
								<?php
				  echo "<tr> <td align='center'style='color:red;'><br/>
				   <span style=''><a class='info' href='selection_client.php?menuParent=Hébergement&groupe=1' style='text-decoration:none;color:maroon;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rechercher
					<img src='logo/b_search.png?menuParent=Hébergement&groupe=1' alt='' width='22' /><span style='font-size:0.9em;color:maroon;'>Rechercher Client</span> </span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span style='font-size:0.9em;color:black;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a class='info' href='client.php?menuParent=Hébergement&groupe=1'style='text-decoration:none;color:maroon;'>Nouveau
					<img src='logo/edit.png?menuParent=Hébergement&groupe=1' alt='' title='Nouveau Client'/>
					<span style='font-size:0.9em;color:maroon;'>Nouveau Client</span> </span></a>
				  </span><span style='float:right;'><b> Client N°".$_SESSION['nombre_01']." du Groupe &nbsp;&nbsp;&nbsp;</b></span></td>

								</tr>
								<tr>
									<td>
									<fieldset style='border:2px solid white;background-color:#D0DCE0;font-family:Cambria;'>
									<legend align='left' style='color:#046380;font-size:110%;'><b>  INFORMATIONS SUR L'IDENTITE DU CLIENT</b></legend>

								<table style=''>
								<tr>
									<td> Numéro du Client : </td>
									<td> <input type='text' name='edit2' id='edit2' style='' readonly value='"; if(!empty($_GET['numcli'])) echo $rlt1; if(!empty($etat_2)&&($etat_2!=1)) echo $edit2;  if(!empty($_SESSION['numcli'])) echo $_SESSION['numcli'];echo"'/> </td>";
									echo "<td> &nbsp;&nbsp;Nom : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									";echo"<span style='font-size:0.9em;color:black;'>";

									include 'others/cni.php';
									echo "<td>
                                    <input type='text' name='edit3' id='edit3' style='if($etat1==1) background-color:#FDF1B8;' readonly value='"; if(!empty($_GET['numcli'])) echo $rlt2; if($etat1!=1) echo $edit3;  if(!empty($_SESSION['numcli'])) echo $_SESSION['nomcli'];echo"'/> </td>";
									echo "<input type='hidden' name='edit_03' id='edit_03' readonly />
									<td> &nbsp;&nbsp;Pr&eacute;noms : </td>
									<td>
                                    <input type='text' name='edit4' id='edit4' style='if($etat2==1) background-color:#FDF1B8;' readonly value='"; if(!empty($_GET['numcli'])) echo $rlt3; if($etat1!=1) echo $edit3;  if(!empty($_SESSION['numcli'])) echo $_SESSION['prenomcli'];echo"'/> </td>";
								echo"	</td></tr>
								<tr>
									<td> Date de naissance : </td>
									<td> <input type='text' name='edit6' id='edit6' readonly value='";
									if(!empty($_GET['numcli'])) echo $rlt5; if($etat6!=1) echo $edit6;  if(!empty($_SESSION['numcli'])) echo $_SESSION['datenais']; echo"'/> </td>
									<td> &nbsp;&nbsp;Lieu de naissance : </td>
									<td> <input type='text' name='edit7' id='edit7' readonly value='"; if(!empty($_GET['numcli'])) echo $rlt6; if($etat7!=1) echo $edit7;  if(!empty($_SESSION['numcli'])) echo $_SESSION['lieu'];echo"'/> </td>

									<td> &nbsp;&nbsp;Pays d'origine : </td>
									<td> <input type='text' name='edit8' id='edit8' readonly value='"; if(!empty($_GET['numcli'])) echo $rlt13;if($etat8!=1) echo $edit8;  if(!empty($_SESSION['numcli'])) echo $_SESSION['pays']; echo"'/> </td>
								</tr>
								<tr>
									<td> Sexe: </td>
									<td> <input type='text' name='edit5' id='edit5' readonly value='"; if(!empty($_GET['numcli'])) echo $rlt4;  if($etat5!=1) echo $edit5; if(!empty($_SESSION['numcli'])) echo $_SESSION['sexe']; echo"'/> </td>
							<td> &nbsp;&nbsp;Etat-civil : </td>
									<td>
										<select required name='combo2' style='"; if($etat11==1) echo "background-color:#FDF1B8;"; echo "font-size:0.9em;"; echo "'>
											<option value='";
											 if($combo2!='') echo $combo2; else echo ""; echo"'> ";
											 echo $combo2; echo "</option>
											<option value='Célibataire'>Célibataire</option>
											<option value=''></option>
											<option value='Marié'>Marié</option>
										</select>
									</td>
									<td> &nbsp;&nbsp;Profession : </td>
									<td>
										<select required name='edit9'style='";
										 if($etat12==1) echo "background-color:#FDF1B8;";  echo "font-size:0.9em;"; echo"'>
											<option value='";
											if($edit9!='') echo $edit9;echo"'>";
											 echo $edit9; echo"</option>
											<option value='Libérale'>Libérale</option>
											<option value=''></option>
											<option value='Ouvrier'>Ouvrier</option>
											<option value=''></option>
											<option value='Employé'>Employé</option>
											<option value=''></option>
											<option value='Cadre'>Cadre</option>
											<option value=''></option>
											<option value='Inactif'>Inactif</option>
											<option value=''></option>
											<option value='Divers'>Divers</option>
										</select>
									</td>
								</tr>
								<tr>
									<td> Domicile habituel : </td>
									<td> <input required type='text' name='edit10'onkeyup='this.value=this.value.toUpperCase()' style='";
									 if($etat10==1)echo"background-color:#FDF1B8;"; echo"' value='";
									 if($etat10!=1) echo $edit10; echo"'/> </td>
									<td>&nbsp;&nbsp; Nombre d'enfant(s) de moins de 15 ans accompagnant(s): </td>
									<td> <input type='text' name='edit11' placeholder='0' style='";
									if($etat13==1)echo"background-color:#FDF1B8;"; echo"'value='";
									if($etat13!=1) echo $edit11; echo "' onkeypress='testChiffres(event);'/> </td>
											<td> &nbsp;&nbsp;Contact : </td>
									<td> <input required type='text' name='edit12'style='";
									 if($etat14==1)echo"background-color:#FDF1B8;"; echo "'value='";
									 if(!empty($_GET['numcli'])) echo $rlt14;if($etat14!=1) echo $edit12; if(!empty($_SESSION['numcli'])) echo $_SESSION['contact']; echo"' /> </td>
								</tr>
					</table>


										</fieldset>
									</td>
								</tr>
								<tr>
									<td><br/>
											<fieldset style='border:2px solid white;background-color:#D0DCE0;font-family:Cambria;'>
											<legend align='left' style='color:#046380;font-size:110%;'><b>  TYPE DE PIECE D'IDENTITE </b></legend>
											<table style=''>
												<tr>
													<td> Type de pièce : </td>
	<td> <input type='text' name='edit_9' id='edit_9' readonly size='30' value='"; if(!empty($_GET['numcli'])) echo $rlt8;if($etat15!=1) echo $edit_9;  if(!empty($_SESSION['numcli'])) echo $_SESSION['piece']; echo"'/> </td>
													<td>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Numéro de pièce : </td>
	<td> <input type='text' name='edit_13' id='edit_13' readonly size='30' value='"; if(!empty($_GET['numcli'])) echo $rlt9;if($etat16!=1) echo $edit_13;  if(!empty($_SESSION['numcli'])) echo $_SESSION['numpiece']; echo"'/> </td>
													<td>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Délivrée le :&nbsp; </td>
		<td> <input type='text' name='edit_14' id='edit_14' readonly size='30' value='"; if(!empty($_GET['numcli'])) 
													echo   substr($rlt10,8,2).'-'.substr($rlt10,5,2).'-'.substr($rlt10,0,4);if($etat17!=1) 	echo $edit_14;
														if(!empty($_SESSION['numcli'])) echo $_SESSION['le']; echo"'/> </td>
												</tr>

												<tr>
													<td> à : </td>
	<td> <input type='text' name='edit_15' id='edit_15' readonly size='30' value='"; if(!empty($_GET['numcli'])) echo $rlt11;if($etat18!=1) echo $edit_15;  if(!empty($_SESSION['numcli'])) echo $_SESSION['a']; echo"'/> </td>
													<td>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Par : </td>
	<td> <input type='text' name='edit_16' id='edit_16' readonly size='30' value='"; if(!empty($_GET['numcli'])) echo $rlt12;if($etat19!=1) echo $edit_16;  if(!empty($_SESSION['numcli'])) echo $_SESSION['par']; echo"'/> </td>";

	unset($_SESSION['numcli']);	unset($_SESSION['nomcli']);	unset($_SESSION['prenomcli']);	unset($_SESSION['ladate']);	unset($_SESSION['lieu']);	unset($_SESSION['pays']);	unset($_SESSION['sexe']);
	unset($_SESSION['piece']);	unset($_SESSION['numpiece']);	unset($_SESSION['le']);	unset($_SESSION['a']);	unset($_SESSION['par']);   unset($_SESSION['contact']);
?>
			<td> <input type='hidden' name='edit18' id='edit18' value="<?php echo $Jour_actuel; ?>" readonly /> </td>
					</tr>
						</table>
							</fieldset>
								</td>
								</tr>
								<tr>
									<td>

									</td>
								</tr>
								<tr>
									<td align='center'><br/>
									<?php //echo "<input type='submit' name='CONTINUER' value='CONTINUER'/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";?>
									<input class='bouton2' type='submit' name='ok' value='VALIDER' style=""/> </td>
								</tr>
								<tr>
									<td>&nbsp;
									</td>
								</tr>
							</table>


						</form>
					</fieldset>
				</td>
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
				xhr.open("POST","fnomcli.php",true);
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
