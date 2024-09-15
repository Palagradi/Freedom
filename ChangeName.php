<?php
include_once 'menu.php';
	if (isset($_POST['CONTINUER'])&& $_POST['CONTINUER']=='CONTINUER')
		{	echo $numfiche=trim($_POST['edit1']); //$datarriv=addslashes($_POST['edit18']);
			//$datdep=addslashes($_POST['ladate']);
			//$datdep=substr($_POST['ladate'],6,4).'-'.substr($_POST['ladate'],3,2).'-'.substr($_POST['ladate'],0,2)	;
			$etat='RAS'; //$p8=addslashes($_POST['edit_9']); $p11=addslashes($_POST['edit_15']);$p12=addslashes($_POST['edit_16']);$p17=addslashes($_POST['edit17']);
			$p1=addslashes($_POST['edit1']);$p2=addslashes($_POST['edit2']);$p3=addslashes($_POST['combo2']);$p4=addslashes($_POST['edit9']);$p5=addslashes($_POST['edit10']);
			$p6=addslashes($_POST['edit11']);$p7=addslashes($_POST['edit12']);//$p9=addslashes($_POST['edit_13']);$p10=addslashes($_POST['edit_14']);
			//$p18=addslashes($_POST['edit19']);$p18=addslashes($_POST['edit21']);
			if(isset($_POST['edit2'])){
			//echo "SELECT * FROM fiche1 WHERE fiche1.etatsortie ='NON' AND fiche1.numfiche='$numfiche'";
			$sql="SELECT * FROM fiche1 WHERE fiche1.etatsortie ='NON' AND fiche1.numfiche='$numfiche'";
			$reqsel=mysqli_query($con,$sql);
			 echo $nbre=mysqli_num_rows($reqsel);$p2=trim($p2);
			if($nbre<=0)
				{//$update=mysqli_query($con,"UPDATE fiche2 SET numcli_1='$p2',etatcivil='$p3',profession='$p4',domicile='$p5',nbenfant='$p6',motifsejoiur='$p17',provenance='$p18',destination='$p18',modetransport='".$_POST['rad']."' WHERE numfiche='$numfiche'");
				//echo "<br/>UPDATE fiche2 SET numcli_1='$p2',etatcivil='$p3',profession='$p4',domicile='$p5',nbenfant='$p6',motifsejoiur='$p17',provenance='$p18',destination='$p18',modetransport='".$_POST['rad']."' WHERE numfiche='$numfiche'";
				}
			else
				{ //echo 12;
					$update=mysqli_query($con,"UPDATE fiche1 SET numcli_1='$p2',etatcivil='$p3',profession='$p4',domicile='$p5',nbenfant='$p6',motifsejoiur='$p17',provenance='$p18',destination='$p18',modetransport='".$_POST['rad']."' WHERE numfiche='$numfiche' ");
				 	$update=mysqli_query($con,"UPDATE mensuel_fiche1 SET numcli_1='$p2',etatcivil='$p3',profession='$p4',domicile='$p5',nbenfant='$p6',motifsejoiur='$p17',provenance='$p18',destination='$p18',modetransport='".$_POST['rad']."' WHERE numfiche='$numfiche' ");
				}
				if ($update)
							{header('location:loccup.php?menuParent=Consultation');
							}
							}else {

						}

		}

		if(!empty($_GET['numcli'])) {
		$reqsel=mysqli_query($con,"SELECT * FROM client WHERE numcli ='".$_GET['numcli']."' ");
		while($data=mysqli_fetch_array($reqsel))
			{  $rlt1=$data['numcli'];   $rlt2=$data['nomcli'];   $rlt3=$data['prenomcli'];  $rlt4=$data['sexe'];  $rlt5=$data['datnaiss'];   $rlt6=$data['lieunaiss'];  $rlt8=$data['typepiece'];
			   $rlt9=$data['numiden'];   $rlt10=$data['date_livrais'];   $rlt11=$data['lieudeliv']; $rlt12=$data['institutiondeliv']; $rlt13=$data['pays']; $rlt14=$data['Telephone'];$Categorie=$data['Categorie'];
			   if(isset($data['NumIFU'])&& $data['NumIFU'] > 0 )$_SESSION['NumIFU']=$data['NumIFU'];
			}
		}
?>

<html>
	<head>
		<script type="text/javascript" src="js/date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script type="text/javascript" src="js/verifyCheckBoxes1.js"></script>
		<link rel="Stylesheet" type="text/css"  href='css/input.css' />
		<?php
		if(!empty($_GET['zoom']))
			echo "<style>
			select, input[type=text]{
			 font-family:cambria;
			}
		</style>";
		?>
	</head>
	<body style='background-color:#84CECC;'>
	<div align="" style="margin-top:25px;">
		<table align='center'  style='background:#D0DCE0;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' >

			<tr>
				<td>
					<fieldset  style='border:2px solid white;font-family:Cambria;padding:10px;'>
						<legend align='' style='color:#046380;font-size:125%;'><b> FICHE DE RENSEIGNEMENT</b> </legend>
						<form action='<?php echo getURI_(); ?>' method='post' id='form1' name='fiche' enctype='multipart/form-data'>
							<table style=''>
								<tr>
									<td width=''>&nbsp;&nbsp; Numéro de Fiche:
										 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='edit1' readonly value="<?php
/* 									if($etat_facture=='AA')
									{   $chaine1 = substr(random($Nbre_char,''),0,3);
										$chaine2 = substr(random($Nbre_char,''),5,3);
										$year=(substr(date('Y'),3,1)+substr(date('Y'),2,1))-5;
										echo $chaine = $initial_fiche.$year.$chaine1.$chaine2;
									}
									if(($etat_facture=='AI'))
									{ */
								if(!empty($_GET['numfiche'])) {
										echo $_GET['numfiche'];
								}else{
										//echo $Num_fiche ;
									}
									?>"  style='float:right;'/> </td>
						            <td style=''>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									 	<span style="font-size:0.9em;color:black;"><a class='info' href='selection_client.php?menuParent=Hébergement<?php if(!empty($_GET['numfiche'])) echo "&numfiche=".$_GET['numfiche'];  if(isset($_GET['change'])) echo "&change=".$_GET['change']; ?>' style='text-decoration:none;color:#d10808;'>Rechercher
										<img src="logo/b_search.png" alt="" width='22' title=''/><span style='font-size:0.9em;color:maroon;'>Rechercher Client</span></span> </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<span style="font-size:0.9em;color:black;"><a class='info' href='client.php?menuParent=Hébergement&etat=1&fiche=1'style='text-decoration:none;color:#d10808;'>Nouveau
										<img src="logo/edit.png" alt="" title=''/><span style='font-size:0.9em;color:maroon;'>Nouveau Client</span></span></a>
									<?php
										$etat_2=!empty($etat_2)?$etat_2:NULL; $etat1=!empty($etat1)?$etat1:NULL; $etat2=!empty($etat2)?$etat2:NULL; $rlt_2=!empty($rlt_2)?$rlt_2:NULL;  $rlt_3=!empty($rlt_3)?$rlt_3:NULL;
										$edit2=!empty($edit2)?$edit2:NULL; $edit3=!empty($edit3)?$edit3:NULL; $edit4=!empty($edit4)?$edit4:NULL; $edit5=!empty($edit5)?$edit5:NULL; $edit6=!empty($edit6)?$edit6:NULL; $edit7=!empty($edit7)?$edit7:NULL;
										$edit8=!empty($edit8)?$edit8:NULL; $edit10=!empty($edit10)?$edit10:NULL;  $edit12=!empty($edit12)?$edit12:NULL;$edit13=!empty($edit13)?$edit13:NULL; $edit14=!empty($edit14)?$edit14:NULL; $edit15=!empty($edit15)?$edit15:NULL;
										$edit16=!empty($edit16)?$edit16:NULL; $edit17=!empty($edit17)?$edit17:NULL; $edit18=!empty($edit18)?$edit18:NULL;  $edit19=!empty($edit19)?$edit19:NULL;  $edit20=!empty($edit20)?$edit20:NULL; $edit_13=!empty($edit_13)?$edit_13:NULL;
										$edit_14=!empty($edit_14)?$edit_14:NULL; $edit21=!empty($edit21)?$edit21:NULL;$edit_15=!empty($edit_15)?$edit_15:NULL;
									?></td>
									<td>


									<?php
									if(!empty($_GET['change'])&& $_GET['change']==2) {
									echo "<td >
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type='checkbox' id='button_checkbox_1'  onClick='verifyCheckBoxes1();' value='1' ><label for='button_checkbox_1' style='color:#444739;'> Occupant N°1	</label></td>
									<td>&nbsp;&nbsp;&nbsp; <input type='checkbox'  id='button_checkbox_2'  onClick='verifyCheckBoxes2();' value='2'><label for='button_checkbox_2' style='color:#444739;'>Occupant N°2</label></td>";
									}
									?>
								</tr>

							</table><br/>
							<table style=''>
								<tr>
									<td>
										<fieldset style='border:1px solid white;'>
											<?php

													echo "<legend align='' style='color:#046380;font-size:110%;'><b> CHANGEMENT DU NOM DE L'OCCUPANT DE LA CHAMBRE </b></legend>";
											?>
											<table style='height:180px;'>
												<tr>
													<td> Numero du Client: </td>
														<input type='hidden' name='advance' id='advance'   value=" <?php if(!empty($advance)) echo $advance; ?>"  >
														<input type='hidden' name='numero' id='numero' value=" <?php if(!empty($numero)) echo $numero; ?>" />
													<td> <input type='text' name='edit2' id='edit2' readonly style='<?php if($etat_2==1)echo"background-color:#FDF1B8;";?>' readonly value=" <?php if(!empty($rlt_1)) echo $rlt_1; if(!empty($_GET['numcli'])) echo $rlt1; if($etat_2!=1) echo $edit2; if(!empty($_SESSION['numcli'])) echo $_SESSION['numcli'];  ?>" required />  </td>
													<td> Nom: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<span style="font-size:0.9em;"><a class='info2' id='info' href='fiche.php?fiche=1&<?php if(!empty($numero)) echo "numero=".$numero; ?>' style='text-decoration:none;'>
													<input id='file' type='file' accept='image/*' name='cpi' />  <input type="hidden" name="MAX_FILE_SIZE" value="250000" />
													<a class='info2' id='info' href='fiche.php?menuParent=Hébergement&<?php if(!empty($numero)) echo "numero=".$numero; ?>' style='text-decoration:none;'>
													<span style='font-size:0.9em;color:maroon;'> JOINDRE UNE COPIE DE LA PIECE D'IDENTITE</span>
													<label for="file" id="label-file"><i class="fas fa-id-card" style='font-size:1.8em;'></i></label></a>
												</td>
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
														<select name='combo2' required style='font-family:sans-serif;font-size:80%;width:165px; <?php if(!empty($etat11) && $etat11==1)echo"background-color:#FDF1B8;";?>'>
															<option value='<?php if(isset($combo2) && !empty($combo2)) echo $combo2;   else echo "";?>'>  <?php if(isset($combo2) && !empty($combo2)) echo $combo2; ?></option>
															<option value='Célibataire'>Célibataire</option>
															<option value='Marié'>Marié</option>
														</select>
													</td>
													<td> Profession: </td>
													<td>
														<select name='edit9' required style='font-family:sans-serif;font-size:80%;width:165px;<?php if(!empty($etat12) && $etat12==1)echo"background-color:#FDF1B8;";?>'>
															<option value='<?php if(!empty($edit9)) echo $edit9;  ?>'> <?php if(!empty($edit9)) echo $edit9;  ?></option>
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
													<td> <input required type='text' name='edit10'onkeyup='this.value=this.value.toUpperCase()' style='<?php $etat10=(!empty($etat10)&&($etat10==1))?$etat10:NULL;  //echo"background-color:#FDF1B8;";?>' value="<?php if($etat10!=1) echo $edit10;  ?>" /> </td>
													<td> Nombre d'enfant de moins de 15 ans accompagnants: </td>
													<td> <input type='text' name='edit11' placeholder='0' style='<?php   $etat13=(!empty($etat13)&&($etat13==1))?$etat13:NULL; //echo"background-color:#FDF1B8;";?>'  onkeypress="testChiffres(event);"/> </td>
															<td> Contact: </td>
													<td> <input type='text' name='edit12'style='<?php $etat14=(!empty($etat14)&&($etat14==1))?$etat14:NULL; //echo"background-color:#FDF1B8;";?>' value="<?php if(!empty($rlt_14)) echo $rlt_14; if(!empty($_GET['numcli'])) echo $rlt14;if($etat14!=1) echo $edit12; if(!empty($_SESSION['numcli'])) echo $_SESSION['contact'];  ?>" onkeypress="testChiffres(event);"/> </td>
												</tr>

											</table>
										</fieldset>
									</td>
								</tr>

								<tr>
									<td align='center'> <br/><input type='submit' name='CONTINUER' class='bouton2' value='CONTINUER' style=''/></td>
								</tr>
							</table>
						</form>
					</fieldset>
				</td>
			</tr>
		</table>

</html>
