<?php
	include 'menu.php';
	//enregistrement de la fiche
if(($_SESSION['Nuite_sal']==0)||($_SESSION['Nuite_sal']=='')) $_SESSION['Nuite_sal']=1; unset($_SESSION['view']);

//echo $_SESSION['nbre'];

	if ((isset($_POST['va'])&& $_POST['va']=='VALIDER')&&($_POST['edit26'])>0)  
		{   $_SESSION['avance']=0;$_SESSION['motif']=$_POST['combo33']; $_SESSION['exhonerer']=isset($_POST['exhonerer'])?$_POST['exhonerer']:NULL;
			if($_SESSION['exhonerer']==1) $edit26=$_POST['edit26']-$_POST['edit29']; else $edit26=$_POST['edit26'];
			  $edit27=$_POST['edit27'];$etat_10=1;
			$ttc_fixe=$edit26/$_POST['edit23'];
			if($_SESSION['nbre']<=1) { if(!empty($_POST['edit33'])) $_SESSION['np']=$_POST['edit26']/$_POST['edit33'];}

			$ret=mysqli_query($con,'SELECT numsalle FROM salle WHERE  typesalle="'.$_POST['edit22'].'"');
			$ret1=mysqli_fetch_array($ret);$numsalle=$ret1['numsalle'];

			$ret="SELECT * FROM location, compte1 WHERE location.numfiche=compte1.numfiche and numsalle='$numsalle' and etatsortie='NON' ";
			$ret1=mysqli_query($con,$ret);
			$ret2=mysqli_fetch_array($ret1);
			if ($ret2)
			{
				if (($ret2['datarriv']==date('Y-m-d')) and ($ret2['typeoccup'])=='double')
				{
					//$reta=mysqli_query("INSERT INTO compte1 VALUES ('".$_SESSION['num']."', '$numsalle', '', '', '','' '','','','','','','','','')");
				}
				else
				{
					echo "<script language='javascript'>alert('Cette salle est occupée');</script>";
				}
			} else
			{
				$_SESSION['np']=isset($_POST['edit32'])?$_POST['edit32']:1;
				//$_SESSION['nuit']=$_POST['edit28']/$_SESSION['Nuite_sal'];
				$nomsalle=$_POST['combo3'];
				$_SESSION['tch']=$_POST['edit22'];
			//	combo33
				$_SESSION['occup']=$_POST['combo33'];
				$tarif=$_POST['edit24'];
				$_SESSION['mt']=$_POST['edit26']/$_POST['edit23'];
				//$_SESSION['taxe']=$_POST['edit28'];
				$_SESSION['tv']=$_POST['combo6'];
				$tva=$_POST['edit29']/$_SESSION['Nuite_sal'];
				if($_SESSION['exhonerer']!=1)
				$ttc=$_POST['edit26']; else $ttc=$_POST['edit24'];
				$_SESSION['due']=$_POST['edit26'];
				$_SESSION['edit_25']=$_POST['edit_25'];
	/* 			if($_SESSION['nbre']>1)
					{if((($_POST['edit30']>=$ttc)||($_POST['edit27']>=$ttc))&&($ttc!=''))
						{if($_POST['edit30']>=$ttc) $np=$_POST['edit30']/$ttc;
						if($_POST['edit27']>=$ttc) $np=$_POST['edit27']/$ttc;} else $np=0;
					}
				else */
					{	/* $_SESSION['total_salle']+=$edit26;
						if(($_POST['edit30']>=$_SESSION['total_salle'])&&($_POST['edit30']!='')&&($_SESSION['total_salle']!=''))
							{if(($_SESSION['exhonerer']==1)&&(empty($_SESSION['numreserv']))) {$np=(int)($_POST['edit30']/$_SESSION['total_salle']);}
							else {if(($_POST['edit30']>=$_SESSION['total_salle'])&&($_POST['edit30']>=0)&&($_SESSION['total_salle']>=0))
									$np=$_POST['edit30']/$_SESSION['total_salle'];if($_POST['edit27']>=$ttc) {$np=$_POST['edit27']/$ttc;}
								}
							} else $np=0;
						if(!empty($_SESSION['numreserv'])) $np=$_POST['edit27']/$ttc; */
					}
					
					$np=0;
					
					//echo $_SESSION['total_salle'];
				//echo $np."<br/>".$ttc."<br/>".$_POST['edit27'];
				if((is_int($np))||($np==0)||($np==1)||($np==2)||($np==3)||($np==4)||($np==5))
				{//enregistrement du compte1
					$tarif1=$ttc_fixe*$np;
					$taxe=isset($_POST['edit28'])?_POST['edit28']:0;
					$due=isset($_POST['edit31'])?_POST['edit31']:0;
					$sql="INSERT INTO compte1 VALUES ('".$_SESSION['num']."','$numsalle','".$_SESSION['motif']."','".$_POST['edit24']."','".$_POST['edit23']."','0','".$_POST['edit24']."','0','".$taxe."','".$_POST['combo6']."','".$_POST['edit29']."','".$_POST['edit26']."','0','0','$ttc_fixe','$tarif1','".$due."','$np','')";
					$reto=mysqli_query($con,$sql);
					if($_SESSION['nbre']>1)   {  $_SESSION['total_salle']+=$edit26;}
					 $en=mysqli_query($con,"INSERT INTO chambre_tempon VALUES ('".$_POST['combo3']."')");
					 //$ret=mysqli_query($con,"INSERT INTO reservation_tempon2 VALUES ('".date('Y-m-d')."','".$_SESSION['numreserv']."')");
					$res=mysqli_query($con,'SELECT * FROM compte1,salle WHERE numfiche="'.$_SESSION['num'].'" AND salle.numsalle=compte1.numsalle');
					while ($ret=mysqli_fetch_array($res))
						{  $tarif2=$ret['ttc_fixe']*$np;  if($np==0) {
/* 							if(is_int($_POST['edit30']/$ret['ttc_fixe']))  {
								$np=$_POST['edit30']/$ret['ttc_fixe'];$tarif2=$ret['ttc_fixe']*$np; $_SESSION['somme']=$_POST['edit30'];
								}else echo "<script language='javascript'>alert('La somme remise ne correspond à aucun montant d'une salle');</script>"; */ 
							}
						  if(empty($_SESSION['numreserv']))
							$update=mysqli_query($con,"UPDATE compte1 SET somme='$tarif2',np='$np'  WHERE numsalle='".$ret['numsalle']."'");
						  if(($np>0)&& (empty($_SESSION['numreserv'])))$tu=mysqli_query("INSERT INTO encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$_SESSION['num']."','".$_POST['edit30']."','".$_SESSION['login']."','Location salle','".$ret['typesalle']."','RAS','".$ret['tarif']."','$tarif2','$np')");
						}

				if ($reto)
				{    $update=mysqli_query($con,"UPDATE reservationsal SET somme=0  WHERE numresch='".$_SESSION['numreserv']."'");
				     if($update)
						{   $update=mysqli_query($con,"UPDATE reserversal SET avancerc=0 ,nuite_payee=0 WHERE numresch='".$_SESSION['numreserv']."'");
							//$ret=mysqli_query("INSERT INTO reservation_tempon2 VALUES ('".date('Y-m-d')."','".$_SESSION['numreserv']."')");
						}
						if ($reto)
						{   $e_n=mysqli_query($con,"INSERT INTO recu_salle VALUES ('".$_SESSION['num']."','".$nomsalle."','". $tarif."','".$tva."','".$ttc."')");
						    if($e_n) {$_SESSION['nbre']--; if($_SESSION['nbre']==0) $aff=1;}

							$res=mysqli_query($con,'SELECT sum(somme) AS somme FROM compte1 WHERE numfiche="'.$_SESSION['num'].'"');
							while ($ret=mysqli_fetch_array($res))
								{$var=$ret['somme'];
								}
							$_SESSION['somme']=$var;
							if(($_SESSION['nbre']==0)&&($var!=0)&&($np>0)) {
							//$tu=mysqli_query("INSERT INTO encaissement VALUES ('','".date('Y-m-d')."','".$_SESSION['num']."','".$_POST['edit30']."','".$_SESSION['login']."','Location salle','".$_POST['combo3']."','RAS','$tarif','$ttc','$np')");
							$update=mysqli_query($con,"UPDATE configuration_facture SET num_fact=num_fact+1 "); $update1="OUI";
							//if($_POST['exhonerer']==1)
							//	$sql=mysqli_query($con,"INSERT INTO exonerer_tva VALUES('".date('Y-m-d')."','".$_SESSION['num']."')");
							//header('location:recusalle.php');
							}
							//if(($update1!="OUI")&&($_SESSION['nbre']==0)&&($np>0)) 
							{
							$update=mysqli_query($con,"UPDATE configuration_facture SET num_fact=num_fact+1 ");
							//if($_SESSION['exhonerer']==1)
							//	$sql=mysqli_query($con,"INSERT INTO exonerer_tva VALUES('".date('Y-m-d')."','".$_SESSION['num']."')");
							//header('location:recusalle.php');
							}
							if((empty($_POST['edit30'])||($_POST['edit30']==0))&&($_SESSION['nbre']==0)) {
							//if($_SESSION['exhonerer']==1)
							//	$sql=mysqli_query($con,"INSERT INTO exonerer_tva VALUES('".date('Y-m-d')."','".$_SESSION['num']."')");
								header('location:loccup.php?menuParent=Consultation&sal=1');
								}
							echo "<script language='javascript'>alert('Enrégistrement bien effectué');</script>";
						} else
						{
							echo "<script language='javascript'>alert('Echec d'enregistrement');</script>";
						}
				} else {echo "<script language='javascript'>alert('Echec d'enregistrement'); </script>"; }
			}else {echo "<script language='javascript'>alert('Le client ne peut pas avancer ce montant'); </script>"; }
		}
			//requete pour compter le nombre d'occuper
			$ze=mysqli_query($con,"SELECT count(numsalle) FROM location, compte1 WHERE numsalle='".$_POST['combo3']."' and location.numfiche=compte1.numfiche and datarriv='".date('Y-m-d')."'");
			$zer=mysqli_fetch_array($ze);
			if ($zer[0]==0)
			{
				$ze1=mysqli_query($con,"SELECT location.numfiche FROM location, compte1 WHERE etatsortie='NON' and location.numfiche=compte1.numfiche and numsalle='".$_POST['combo3']."'");
				$zer1=mysqli_fetch_array($ze1);
				if ($zer1)
					{"<script language='javascript'>alert('La salle est occupée'); </script>"; }

			} else
				{
					if ($zer[0]==1)
					{
					/* 	$ze2=mysqli_query("SELECT typeoccup FROM compte1,location WHERE numsalle='".$_POST['combo3']."' and location.numfiche=compte1.numfiche and  datarriv='".date('Y-m-d')."'");
						$zer2=mysqli_fetch_array($ze2);
						if ($zer2)
						{
							switch ($zer2)
							{
								case 'double':
									{$ret=mysqli_query("INSERT INTO compte1 VALUES ('".$_SESSION['num']."', '$numsalle', '".$_POST['combo4']."', '0','0' '0', '0','0','0','0','0','0','0','0','0')");header('location:fiche_1.php');
									} break;
								default: echo''; break;
							}
						}  */
					} else
					{
						 echo "<script language='javascript'>alert('Cette salle est occupée');</script>";
					}
				}
$_SESSION['num_ch']='';
$_SESSION['avance']='';
//$_SESSION['numreserv']='';
	}
?>
<html>
	<head>
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
			<link rel="Stylesheet" href='css/table.css' />
		<style>
			.alertify-log-custom {
				background: blue;
			}
		</style>
		<script type="text/javascript">
		function Aff()
		{
			if (document.getElementById("edit23").value!='')
			{
				document.getElementById("edit25").value= (('\t'+document.getElementById("edit24").value)*document.getElementById("edit23").value).toFixed(4);
			}
		}
		function Aff5()
		{
			if (document.getElementById("edit25").value!='')
			{
				document.getElementById("edit_25").value=parseFloat(document.getElementById("edit_25").value)+parseFloat(document.getElementById("edit25").value);
			}
		}
		 function Aff1()
		{
			if (document.getElementById("combo3").value!='')
			{
				document.getElementById("edit22").value=document.getElementById("combo3").value;
				alertify.success("Non Assujetti(e) à la TVA");
			}
		}
		function Aff_1()
		{
			if (document.getElementById("edit222").value!='')
			{
				document.getElementById("edit24").value=(document.getElementById("edit222").value*document.getElementById("edit23").value).toFixed(4);
			}
		}
		function Aff2()
		{
			if (document.getElementById("edit24").value!='')
			{
				document.getElementById("edit29").value=(document.getElementById("edit24").value*document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value).toFixed(4);
				document.getElementById("edit26").value=Math.round(parseFloat(document.getElementById("edit29").value)+parseFloat(document.getElementById("edit24").value));
			}
		}
		function Aff3()
		{
			if (document.getElementById("edit33").value!='')
			{
				document.getElementById("edit31").value=parseInt(document.getElementById("edit26").value)-parseInt(document.getElementById("edit33").value);
				document.getElementById("edit32").value=Math.round(document.getElementById("edit33").value/
							(parseInt(document.getElementById('combo5').options[document.getElementById('combo5').selectedIndex].value)+
							 ((document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value)*('\t'+document.getElementById("edit24").value)+parseInt('\t'+document.getElementById("edit24").value))));
			}
		}
		function Aff4()
		{
			if (document.getElementById("edit27").value!='')
			{
				document.getElementById("edit33").value=parseInt(document.getElementById("edit30").value)+parseInt(document.getElementById("edit27").value);
			} else
			{
				document.getElementById("edit33").value=parseInt(document.getElementById("edit30").value);
			}
		}
			</script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
	</head>
	<?php
	?>
	<body bgcolor='azure' style="padding-top:0px;"><br/>
	<div align="" style="margin-top:-2%;">
		<table align='center' width="800"  id="tab" >
		<tr>
				<td align='center'>
				<fieldset style='border:0px solid white;background-color:#D0DCE0;font-family:Cambria;'>
						<form action='occupSal.php?menuParent=Location' method='post' >
							<table style=''>
							<tr>
								<td colspan='4'><br/>
								<legend align='center' style='color:#046380;font-size:150%;'><b> DETAILS  SUR LA LOCATION DE SALLE </b></legend><hr/>
								</td>
							</tr>
			<?php
			echo"<tr>";
			mysqli_query($con,"SET NAMES 'utf8'");
			$nbre=0;
			//echo "SELECT salle.codesalle,salle.typesalle,salle.numsalle,typeoccuprc FROM reserversal,salle WHERE salle.numsalle=reserversal.numsalle AND reserversal.numresch='".$_SESSION['numreserv']."' AND reserversal.numresch <> '' AND salle.numsalle NOT IN (SELECT numch AS numsalle FROM chambre_tempon)";
			if(isset($_SESSION['numreserv']))
			{
				$sql=mysqli_query($con,"SELECT salle.codesalle,salle.typesalle,salle.numsalle,typeoccuprc FROM reserversal,salle WHERE salle.numsalle=reserversal.numsalle AND reserversal.numresch='".$_SESSION['numreserv']."' AND reserversal.numresch <> '' AND salle.numsalle NOT IN (SELECT numch AS numsalle FROM chambre_tempon)");
				$nbre=mysqli_num_rows($sql);
			}
			if($nbre>0)
			{	if($nbre>1)echo"<td align='center'><span style='color:black; font-style:italic;'> Liste des salles reservées:</span> ";
				else echo"<td align='center'><span style='color:black; font-style:italic;'> Salles reservée:</span> ";
			$compteur=0;
			while ($data= mysqli_fetch_array($sql))
			{	$numsalle=$data['numsalle'];
				if($compteur%5==0)
				echo"<br/>";
				echo "<span style='color:#CD5C5C;font-size:0.8em; font-style:italic;'>".$codesalle=$data['codesalle'];
				echo "</span> <span style='color:white;font-size:0.8em; font-style:italic;'>(".$typeoccuprc=$data['typeoccuprc']; echo") </span>;&nbsp;";
				$compteur++;

			}
			echo"</td>";
			}
			echo"</tr>";

			//echo "SELECT numsalle,codesalle,typesalle FROM reserversal,salle WHERE salle.numsalle=reserversal.numsalle AND reserversal.numresch='".$_SESSION['numreserv']."' AND salle.numsalle NOT IN (SELECT numch AS numsalle FROM chambre_tempon) LIMIT 1";
			?>
								<tr>
									<td> Désignation de la Salle : <span style="color:red;"> *</span> &nbsp;</td>
									<td>
											<select name='combo3' id='combo3' onchange="Aff1();" required style='width:175px;font-size:1em;' >
											<?php
											if(isset($_SESSION['numreserv'])){
												mysqli_query($con,"SET NAMES 'utf8' ");
												$res=mysqli_query($con,"SELECT salle.numsalle,salle.codesalle,salle.typesalle,avancerc FROM reserversal,salle WHERE salle.numsalle=reserversal.numsalle AND reserversal.numresch='".$_SESSION['numreserv']."' AND reserversal.numresch <> '' AND salle.numsalle NOT IN (SELECT numch AS numsalle FROM chambre_tempon) ORDER BY salle.numsalle ASC LIMIT 1");
												while ($ret=mysqli_fetch_array($res))
													{$numsalle=$ret['numsalle'];
													 $nom_ch=$ret['codesalle'];
													 $typesalle=$ret['typesalle'];
													 $avancerc1=$ret['avancerc'];
													}
											}

											if(!empty($nom_ch))
												{echo "<option value='".$numsalle."'>".$nom_ch."</option value=''> ";
													echo "<option value=''></option value=''> ";
												}
											else
												echo "<option value=''></option value=''> ";
											?>
											<?php
											mysqli_query($con,"SET NAMES 'utf8' ");
												$res=mysqli_query($con,'SELECT numsalle,codesalle,typesalle FROM salle WHERE numsalle NOT IN (SELECT compte1.numsalle FROM location,compte1 WHERE location.numfiche=compte1.numfiche and location.etatsortie="NON")');
												while ($ret=mysqli_fetch_array($res))
													{
														echo '<option value="'.$ret['typesalle'].'">';
														echo($ret['codesalle']);
														echo '</option>' ;
															echo "<option value=''></option value=''> ";
													}
										echo "</select>";
										
										if(!empty($_SESSION['numreserv'])){
										$res=mysqli_query($con,"SELECT salle.numsalle,salle.codesalle,salle.typesalle,typeoccuprc,mtrc FROM reserversal,salle WHERE salle.numsalle=reserversal.numsalle AND reserversal.numresch='".$_SESSION['numreserv']."' AND reserversal.numresch <> '' AND salle.numsalle NOT IN (SELECT numch AS numsalle FROM chambre_tempon) ORDER BY salle.numsalle ASC LIMIT 1");
										while ($ret=mysqli_fetch_array($res))
											{$typeoccuprc =$ret['typeoccuprc'];
											 $mtrc =$ret['mtrc'];
											}
											
										}
								/* 			if($typeoccuprc=="reunion")
												{$typeoccuprc="Tarif réunion";
												 $typeoccuprc1="tarifreunion";
												}
											if($typeoccuprc=="fete")
											    {$typeoccuprc="Tarif fête";
												$typeoccuprc1="tariffete";
												} */
											?>
									</td>
									<td> &nbsp; Code de la Salle : </td>
									<td> <input type='text' name='edit22' id='edit22' value='<?php if(isset($typesalle)) echo $typesalle; ?>'/> </td>
								</tr>
								<tr>
									<td><br/> Tarif à appliquer : <span style="color:red;"> *</span> </td>
									<td> <br/>
											<select name='combo33' id='combo33' required style='width:175px;font-size:1em;'>
											<option value='<?php if(isset($typeoccuprc1)) echo $typeoccuprc1;?>'><?php if(isset($typeoccuprc1)) echo $typeoccuprc1; else echo ""; ?></option>
											<option value='tariffete'>  Tarif fête</option>
											<option value=''> </option>
											<option value='tarifreunion'>  Tarif réunion</option>

										</select>
									</td>
									<td><br/>&nbsp; Tarif appliqué : </td>
									<td><br/> <input type='text' name='edit222' id='edit222' value='<?php if(isset($mtrc)) echo $mtrc; ?>' onblur="Aff_1();" /> </td>
								</tr>
								<tr>
									<td><br/> Nombre de jours: </td>
									<td><br/> <input type='text' name='edit23' id='edit23' value='<?php  if(isset($_SESSION['Nuite_sal'])) echo $_SESSION['Nuite_sal']; ?>'readonly /> </td>
									<td><br/>&nbsp; Montant HT: </td>
									<td><br/> <input type='text' name='edit24' id='edit24' readonly value='<?php if(isset($mtrc)) echo $_SESSION['Nuite_sal']*$mtrc;?>'/> </td>

								</tr>
								<tr>
 										<input type='hidden' name='edit_25' id='edit_25'   readonly  value="0"/>
								</tr>

								<?php
								if($TvaD!=0) {
									echo "<tr>
									<td><br/> Taux TVA  :<span style='color:red;'> *</span>&nbsp; </td>
									<td>
										<br/><select name='combo6' id='combo6' onchange='Aff2();' required style='width:175px;font-size:1em;'>
											<option value=''>"; //if(($_SESSION['num_ch']!='')&&($_SESSION['exhonerer']!=1)) echo "18%";
											if($_SESSION['exhonerer']==1)  echo "0%"; else ""; echo "</option>";

											$pourcent=100*$TvaD;
											$TvaD=0;$pourcent=0;
											echo "<option value='".$TvaD."'>".$pourcent."%</option>";


										echo "</select>
									</td>
									<td><br/>&nbsp; TVA : &nbsp;</td>
									<td><br/> <input type='text' name='edit29' id='edit29' value='"; if(($_SESSION['num_ch']!='')&&($_SESSION['exhonerer']!=1)) echo $tva=0.18*$_SESSION['Nuite_sal']*$mtrc; if($_SESSION['exhonerer']==1) echo 0; echo "' readonly /> </td>
								</tr>";
								}else {
									echo "<input type='hidden' name='NTVA' id='NTVA' value='1'/>";
								}
								?>
								<tr>
									<td><br/> Montant TTC : </td>
									<td><br/> <input type='text' name='edit26' id='edit26' readonly value="<?php if(($_SESSION['num_ch']!='')&&($_SESSION['exhonerer']!=1)) echo $montant=(int)(0.1+$tva+$_SESSION['Nuite_sal']*$mtrc); if($_SESSION['exhonerer']==1) echo $montant=$_SESSION['Nuite_sal']*$mtrc;?>"/> </td>

								<?php
									if(isset($_SESSION['numreserv'])){
										$or="SELECT distinct reservationsal.numresch,reservationsal.datdepch,reservationsal.avancerc FROM reservationsal,reserversal WHERE reservationsal.numresch=reserversal.numresch and reservationsal.datarrivch='".date('Y-m-d')."' AND numresch='".$_SESSION['numreserv']."'";
										$or1=mysqli_query($con,$or);
										if ($or1)
										{
											while ($roi= mysqli_fetch_array($or1))
											{
												$numresch=$roi['numresch'];
												$date_depart=$roi['datdepch'];
												$avancerc=$roi['avancerc'];
											}
										}
									}
								?>
									<td><br/>&nbsp; Avance: </td>
									<td><br/> <input type='text' name='edit27' id='edit27' value='<?php if(isset($avancerc1)) echo $avancerc1; else echo 0;?>' readonly /> </td>
								</tr>
								<tr>
									<?php //echo "<br/><td colspan='4' align='center' style='font-style:italic;font-size:0.8em;'>Attention, pour chaque salle sélectionnée, mettez l'avance </td>"; ?>
								</tr>
								<?php
								if(($_SESSION['nbre']<=1)&&($_SESSION['exhonerer']!=1))
								echo"<tr>
									<td style='font-style:italic;font-weight:bold;'><br/> Somme Remise : </td>
									<td> <br/><input type='text' readonly name='edit30' id='edit30' onchange='Aff4();' onkeypress='testChiffres(event);'/> </td>
									<td style='font-style:italic;font-weight:bold;'><br/>&nbsp; Total Payé : </td>
									<td><br/> <input type='text' name='edit33' id='edit33' onblur='Aff3();'/> </td>
								</tr> ";
								?>
								<tr>
									<td colspan='4' <?php  if($TvaD!=0) echo "align='left'"; else echo " align='center'"; ?> > <br/>
									<?php  	if($TvaD!=0) {
										echo "<input  type='checkbox' name='exhonerer'"; if($_SESSION['exhonerer']==1) echo "checked='checked'"; echo "value='1'/><span style='font-size:0.8em;font-style:italic;'>Exhonérer de la TVA</span>
									&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
									}else {
									}
									?></td></tr>
									<tr>
									<td colspan='4'  align='center' > <br/><input type='submit' class='bouton2' name='va' id='va' value='VALIDER'  style='' /> </td>
								</tr>
							</table>
						</form>
					</fieldset>
				</td>
			</tr>

		</table>
	</body>
	<script type="text/javascript">

		// fonction pour selectionner le tarif
		function action7(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit222').value = leselect;
						document.getElementById('edit24').value = leselect*document.getElementById('edit23').value;
						if (document.getElementById('NTVA').value==1)
							document.getElementById('edit26').value =leselect*document.getElementById('edit23').value;
					}
				}
				xhr.open("POST","tarifsalle.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo3');
				sel1 = document.getElementById('combo33');
				sh1=sel1.options[sel1.selectedIndex].value;
				sh = sel.options[sel.selectedIndex].value;
				xhr.send("code="+sh+"&tarif="+sh1);
		}
		var momoElement1 = document.getElementById("combo33");
		if(momoElement1.addEventListener){
		  momoElement1.addEventListener("change", action7, false);
		}else if(momoElement1.attachEvent){
		  momoElement1.attachEvent("onchange", action7);
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
<?php
$_SESSION['numreserv']='';
?>
