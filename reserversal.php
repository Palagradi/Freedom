<?php
	include 'menu.php';
	if (isset($_POST['aj'])&& $_POST['aj']=='AJOUTER')
		{	//if((isset($_POST['exhonerer2'])) && ($_POST['exhonerer2']==1))
			//$_SESSION['exhonerer2']=isset($_POST['exhonerer2'])?$_POST['exhonerer2']:NULL; if((isset($_POST['exhonerer_aib']))&&($_POST['exhonerer_aib']==1)) $_SESSION['exhonerer_aib']=$_POST['exhonerer_aib'];
			$ret=mysqli_query($con,'SELECT nbre_salle FROM nombre_reservation');
			$ret1=mysqli_fetch_assoc($ret);
			$nbre_salle=$ret1['nbre_salle'];
			$edit10=!empty($_POST['edit10'])?$_POST['edit10']:0;
			if ($nbre_salle!=0)
			  { $first_letter=substr($_SESSION['mois'],0,1);
				if($first_letter==0)
				$_SESSION['mois']=substr($_SESSION['mois'],1,1);
				if($_SESSION['difference_mois']==0)
				  { $position=1;
					$query_Recordset_2 = "SELECT position FROM reservationsal WHERE annee like '".$_SESSION['ans']."' AND mois like '".$_SESSION['mois']."' AND  numsalle like '".$_POST['edit8']."' AND  fin like '".$_SESSION['jr_debut']."'";
					$Recordset_2 = mysqli_query($con,$query_Recordset_2) or die(mysql_error($con));
					$row_Recordset_2=mysqli_fetch_assoc($Recordset_2);
					$totalRows_Recordset1 = mysqli_num_rows($Recordset_2);
					$positionCourant=$row_Recordset_2['position'];
					if(($totalRows_Recordset1>=0)&&($positionCourant==1))
					 {$position=5;}
					else
					 {$position=1;}

				$ret="SELECT * FROM location, compte1 WHERE location.numfiche=compte1.numfiche and numsalle='".$_POST['edit8']."' and etatsortie='NON' ";
				$ret1=mysqli_query($con,$ret);
				$nbre2=mysqli_num_rows($ret1);
				
					$query_Recordset_3 = "SELECT numsalle,position FROM reservationsal WHERE annee like '".$_SESSION['ans']."' AND mois like '".$_SESSION['mois']."' AND '".$_SESSION['jr_debut']."' between debut AND (fin-1) AND numsalle like '".$_POST['edit8']."' ";

					$Recordset_3 = mysqli_query($con,$query_Recordset_3) or die(mysqli_error($con));
					$row_Recordset_3=mysqli_fetch_assoc($Recordset_3);
					$totalRows_Recordset3 = mysqli_num_rows($Recordset_3);
					//if($Recordset_3)
					 //Si tel est le cas, enregistrer tout en modifier la position
					if($totalRows_Recordset3>0) $etat_1=0; else $etat_1=1;
					if(($etat_1==1)&&($nbre2<=0))
					{  // Insertion normale sur le même mois
                         $re="INSERT INTO reservationsal VALUES(NULL,'".$_POST['edit1']."','".$_POST['edit8']."',
						'".$_SESSION['date_du_jour']."','".$_SESSION['jr_debut']."','".$_SESSION['jr_fin']."','".$_SESSION['mois']."','".$_SESSION['ans']."','$position','".addslashes($_SESSION['nom'])."','".addslashes($_SESSION['prenomT'])."','".$_SESSION['contact']."',
						'".$_SESSION['groupe']."','".$_SESSION['debutS']."','".$_SESSION['finS']."','".$_SESSION['nuiteA']."','".$_SESSION['nbsal']."','".$edit10."','0','".$_SESSION['login']."','".$_SESSION['login']."')";

					$req=mysqli_query($con,$re);
					$numsalle=$_POST['edit8'];
					$ret=mysqli_query($con,"SELECT codesalle,tariffete,tarifreunion FROM salle WHERE numsalle='$numsalle'");
					while ($ret1=mysqli_fetch_array($ret))
						{	$codesalle=$ret1['codesalle'];
							$tariffete=$ret1['tariffete'];
							$tarifreunion=$ret1['tarifreunion'];
							if($_POST['combo2']=='reunion')
								{$tarif=$tarifreunion;
								 $tarifrc=(int)(($tarifreunion*$TvaD+$tarifreunion)+0.1);
								}
							 else
								{$tarif=$tariffete;
								 $tarifrc=(int)(($tariffete*$TvaD+$tariffete)+0.1);
								}
						}
					    //if($_SESSION['exhonerer1']==1) $sql=mysqli_query($con,"INSERT INTO exonerer_tva VALUES('".date('Y-m-d')."','".$_POST['edit1']."')");
						//if($_SESSION['exhonerer_aib']==1) $sql=mysqli_query($con,"INSERT INTO exonerer_aib VALUES('".date('Y-m-d')."','".$_POST['edit1']."')");
						   $sql="INSERT INTO reserversal VALUES('".$_POST['edit1']."','".$_POST['edit8']."','$codesalle','".$_POST['combo2']."','$tarifrc','$tarif','0','0')";
						$ret1=mysqli_query($con,$sql);
						if ($req)
						{   $de=mysqli_query($con,"UPDATE nombre_reservation SET nbre_salle=nbre_salle-1 WHERE nbre_salle='$nbre_salle'");
								echo "<script language='javascript'>";
								echo 'alertify.success("La réservation de la salle effectuée avec succès");';
								echo "</script>";

						$ret1=mysqli_query($con,'SELECT nbre_salle FROM nombre_reservation');
						$ret_1=mysqli_fetch_assoc($ret1);
						 $nbre_salle1=$ret_1['nbre_salle'];

							if ($nbre_salle1==0)
								{redirect_to("cresch.php?menuParent=Gestion des Réservations");
								}

						}
				   }
					else{
							echo "<script language='javascript'>";
							echo 'alertify.error("Une r&eacute;servation est d&eacute;j&agrave; pr&eacute;vue pour cette p&eacute;riode");';
							echo "</script>";
					}
				 }
				 else
				 {  $nbj=date("t",mktime(0,0,0,$_SESSION['mois'],1,$_SESSION['ans']));//nbre de jours du mois
				    $position=1;
					$query_Recordset_2 = "SELECT position FROM reservationsal WHERE annee like '".$_SESSION['ans']."' AND mois like '".$_SESSION['mois']."' AND  numsalle like '".$_POST['edit8']."' AND  fin like '".$_SESSION['jr_debut']."'";
					$Recordset_2 = mysqli_query($con,$query_Recordset_2) or die(mysql_error($con));
					$row_Recordset_2=mysqli_fetch_assoc($Recordset_2);
					$totalRows_Recordset1 = mysqli_num_rows($Recordset_2);
					$positionCourant=$row_Recordset_2['position'];
					if(($totalRows_Recordset1>=0)&&($positionCourant==1))
					 {$position=5;}
					else
					 {$position=1;}

					$query_Recordset_3 = "SELECT numsalle,position FROM reservationsal WHERE annee like '".$_SESSION['ans']."' AND mois like '".$_SESSION['mois']."' AND '".$_SESSION['jr_debut']."' between debut AND (fin-1) AND numsalle like '".$_POST['edit8']."' ";
					$Recordset_3 = mysqli_query($con,$query_Recordset_3) or die(mysql_error($con));
					$row_Recordset_3=mysqli_fetch_assoc($Recordset_3);
					$totalRows_Recordset3 = mysqli_num_rows($Recordset_3);
					if($Recordset_3)
					 //Si tel est le cas, enregistrer tout en modifier la position
					if($totalRows_Recordset3>0)
					{ $etat_1=0;
					}else
					{$etat_1=1;
					}
					$ret="SELECT * FROM location, compte1 WHERE location.numfiche=compte1.numfiche and numsalle='".$_POST['edit8']."' and etatsortie='NON' ";
					$ret1=mysqli_query($con,$ret);
					$nbre2=mysqli_num_rows($ret1);
					if(($etat_1==1)&&($nbre2<=0))
					{  	//Insertion multiple

						 $re="INSERT INTO reservationsal VALUES('','".$_POST['edit1']."','".$_POST['edit8']."',
						'".$_SESSION['date_du_jour']."','".$_SESSION['jr_debut']."','$nbj','".$_SESSION['mois']."','".$_SESSION['ans']."','$position','".addslashes($_SESSION['nomT'])."','".addslashes($_SESSION['prenom'])."','".$_SESSION['contact']."',
						'".$_SESSION['groupe']."','".$_SESSION['debutS']."','".$_SESSION['finS']."','','".$_SESSION['nbsal']."','".$edit10."','0','".$_SESSION['login']."','".$_SESSION['login']."'),
						('','".$_POST['edit1']."','".$_POST['edit8']."','".$_SESSION['date_du_jour']."','01','".$_SESSION['jr_fin']."','".$_SESSION['mois2']."','".$_SESSION['ans']."','$position','".$_SESSION['nom']."','".$_SESSION['prenom']."','".$_SESSION['contact']."',
						'".$_SESSION['groupe']."','".$_SESSION['debutS']."','".$_SESSION['finS']."','','".$_SESSION['nbsal']."','".$_POST['edit10']."','0','".$_SESSION['login']."','".$_SESSION['login']."')";
					    $req=mysqli_query($con,$re);

					$numsalle=$_POST['edit8'];
					$ret=mysqli_query($con,"SELECT codesalle,tariffete,tarifreunion FROM salle WHERE numsalle='$numsalle'");
					while ($ret1=mysqli_fetch_array($ret))
						{	$codesalle=$ret1['codesalle'];
							$tariffete=$ret1['tariffete'];
							$tarifreunion=$ret1['tarifreunion'];
							if($_POST['combo2']=='reunion')
							 $tarif=$tarifreunion;
							 else $tarif=$tariffete;
						}

						//if($_SESSION['exhonerer1']==1) $sql=mysqli_query($con,"INSERT INTO exonerer_tva VALUES('".date('Y-m-d')."','".$_POST['edit1']."')");
						//if($_SESSION['exhonerer_aib']==1) $sql=mysqli_query($con,"INSERT INTO exonerer_aib VALUES('".date('Y-m-d')."','".$_POST['edit1']."')");

						 $sql="INSERT INTO reserversal VALUES('".$_POST['edit1']."','".$_POST['edit8']."','$codesalle','".$_POST['combo2']."','$tarif','$tarif','0','0')";
						$ret1=mysqli_query($con,$sql);
						if ($req)
						{   $de=mysqli_query($con,"UPDATE nombre_reservation SET nbre_salle=nbre_salle-1 WHERE nbre_salle='$nbre_salle'");
								echo "<script language='javascript'>";
								echo 'alertify.success("La réservation de la salle effectuée avec succès");';
								echo "</script>";
						$ret1=mysqli_query($con,'SELECT nbre_chambre,nbre_salle FROM nombre_reservation');
						while ($ret_1=mysqli_fetch_array($ret1))
							{ $nbre_chambre1=$ret_1[0]; $nbre_salle1=$ret_1[1];
							}
						 if ($nbre_salle1==0)
						     {redirect_to("cresch.php?menuParent=Gestion des Réservations");
							 }

						}
				   }
					else{
						echo "<script language='javascript'>";
						echo 'alertify.error("Une r&eacute;servation est d&eacute;j&agrave; pr&eacute;vue pour cette p&eacute;riode pour cette salle");';
						echo "</script>";
					}
				 }
			 }
				   else if($nbre_salle==0)   { redirect_to("cresch.php?menuParent=Gestion des Réservations");
				   }
	 }
?>

<html>
	<head>
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<link rel="Stylesheet" type="text/css"  href='css/input.css' />
		<link rel="Stylesheet" href='css/table.css' />
	</head>
	<body bgcolor='azure' style=""><br/>
	<div align="" style="">
		<table align='center' style='' > <tr> <td>
			<fieldset style='margin-left:auto; margin-right:auto;border:2px solid white;background-color:#D0DCE0;font-family:Cambria;'>
			<form action='reserversal.php?menuParent=Gestion des Réservations' method='post'>
				<table align='center' style='min-width:750px;' height='250'>
					<tr>
						<td colspan='4' style=''><br/>
							<h3 style='text-align:center; font-family:Cambria;color:Maroon;font-weight:bold;'>SELECTION DES SALLES</h3>
						</td>
					</tr>
					<tr>
						<td colspan='4'>  <hr/>&nbsp; </td>
					</tr>
					<tr>
						<td> &nbsp; &nbsp; &nbsp; Réservation N°: </td>
						<td> <input type='text' name='edit1' id='edit1' value="<?php echo $_SESSION['numresch'];?>" /> </td>
						<td>  &nbsp; &nbsp;Nombre de Salles :</td>
						<td> <input type='text' name='edit2' value="<?php echo $_SESSION['nbsal']; ?>" readonly  style='width:250px;margin-right:8px;' /> </td>
					</tr>
					<tr>
						<td> <br/>&nbsp; &nbsp; &nbsp;&nbsp;Type de salle : </td>
						<td>
							 <br/><select name='edit8' id='edit8' style='' required>
								<option value='Default'> </option>
									<?php
										// mysqli_query($con,"SET NAMES 'utf8'");
										 $date=date('Y-m-d');
										//if(($date >=$_SESSION['debut'])&&($date <=$_SESSION['fin']))
										{mysqli_query($con,"SET NAMES 'utf8'");
										$ret=mysqli_query($con,"SELECT numsalle,typesalle FROM salle WHERE numsalle NOT IN (SELECT numsalle FROM reservationsal WHERE datarrivch  BETWEEN '".$_SESSION['debutS']."' AND '".$_SESSION['finS']."') AND numsalle NOT IN (SELECT numsalle FROM reservationsal WHERE datdepch  > '".$_SESSION['debutS']."' AND datdepch < '".$_SESSION['finS']."')
										") or die (mysql_error());
										}/* else{
										mysqli_query($con,"SET NAMES 'utf8'");
										$ret=mysqli_query($con,"SELECT numsalle,codesalle FROM salle WHERE numsalle NOT IN (SELECT numsalle FROM reservationsal WHERE datdepch BETWEEN '".$_SESSION['debut']."' AND '".$_SESSION['fin']."' )AND numsalle NOT IN (SELECT numsalle FROM reservationsal WHERE datdepch  BETWEEN '".$_SESSION['debut']."' AND '".$_SESSION['fin']."')
										AND numsalle NOT IN (SELECT compte1.numsalle FROM location,compte1 WHERE location.numfiche=compte1.numfiche and location.etatsortie='NON')") or die (mysql_error());
										//$ret=mysqli_query($con,'SELECT numsalle,codesalle FROM salle ');
										} */
										while ($ret1=mysqli_fetch_array($ret))
											{
												echo '<option value="'.$ret1['numsalle'].'">';
												echo($ret1['typesalle']);
												echo '</option>';
												echo "<option value=''></option>";
											}
									?>
							</select>
						</td>
						<td> <br/> &nbsp; &nbsp;Désignation Salle : </td>
						<td> <br/> <input type='text' name='edit9' id='edit9' readonly  style='width:250px;margin-right:8px;'/> </td>
					</tr>
					<tr>
						<td> <br/>&nbsp; &nbsp; &nbsp; Motif location : </td>
						<td>
							 <br/><select name='combo2' id='combo2' style='' required>
								<option value='Default'> </option>
								<option value='reunion'> REUNION </option>
								<option value=''>  </option>
								<option value='fete'> FETE </option>
							</select>
						</td>
					 <td>  <br/>&nbsp; &nbsp;Tarif: </td>
					 <td> <br/> <input type='text' name='Jedit' id='Jedit' readonly style='width:250px;margin-right:8px;' /> </td>
					</tr>

					<tr>
						<td colspan='4'>  <hr/>&nbsp; </td>
					</tr>

					<tr>
						<td> &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<input  type='checkbox' id="test3" name='salle'  <?php if(isset($_SESSION['chambre']) && ($_SESSION['chambre']==1)) echo "checked='checked'";?> value='1'/> <label for="test3" ><span style='font-style:italic;'>Ajouter des chambres</span></label></td>

					</tr>
					<?php
					//if (!isset($nbre_salle1) || ($nbre_salle1==1))
					{
					echo "	
					<tr>
						<td colspan='4' align='center'>  <br/> 						
						<input class='bouton2' type='submit' name='aj' value='AJOUTER' style=''/></td>
					</tr>";
					}
					?>
				</table>
			</form>
			</fieldset>
		</td> </tr> </table>
	</div>
	</body>
	<script type="text/javascript">

	// fonction pour selectionner le type de salle
		function action(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit9').value=leselect;
					}
				}
				xhr.open("POST","loctype.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit8');
				sh = sel.options[sel.selectedIndex].value;
				xhr.send("numsalle="+sh);
		}

	// fonction pour selectionner le tarif
		function action1(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('Jedit').value=leselect;
					}
				}
				xhr.open("POST","loctarif.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo2');
				sel1 = document.getElementById('edit8');
				sh1=sel1.options[sel1.selectedIndex].value;
				sh = sel.options[sel.selectedIndex].value;
				xhr.send("objet="+sh+"&numsalle="+sh1);


		}

		//
		var momoElement = document.getElementById("edit8");
		if(momoElement.addEventListener){
		  momoElement.addEventListener("change", action, false);
		}else if(momoElement.attachEvent){
		  momoElement.attachEvent("onchange", action);
		}
		var momoElement1 = document.getElementById("combo2");
		if(momoElement1.addEventListener){
		  momoElement1.addEventListener("change", action1, false);
		}else if(momoElement1.attachEvent){
		  momoElement1.attachEvent("onchange", action1);
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
