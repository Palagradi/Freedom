<?php
	include 'menu.php';
	if (isset($_POST['aj'])&& $_POST['aj']=='AJOUTER')
		{  $_SESSION['salle']=!empty($_POST['salle'])?$_POST['salle']:NULL;

		//$ret1=mysqli_query($con,'UPDATE nombre_reservation SET nbre_salle= ');

		//if((isset($_POST['exhonerer1']))&&($_POST['exhonerer1']==1)) $_SESSION['exhonerer1']=$_POST['exhonerer1'];
		//if((isset($_POST['exhonerer_aib']))&& ($_POST['exhonerer_aib']==1))	$_SESSION['exhonerer_aib']=$_POST['exhonerer_aib'];
			$_SESSION['taxe']=$_POST['edit2_8'];
		  //Attention
		  $how=substr($_SESSION['mois'],0,1);if($how==0) $mois_0=substr($_SESSION['mois'],1,1);
		   $ret=mysqli_query($con,'SELECT * FROM nombre_reservation');
				while ($ret1=mysqli_fetch_assoc($ret))
					{ $nbre_chambre=$ret1['nbre_chambre'];}
			if ($nbre_chambre!=0)
			 { if(($_SESSION['difference_mois']==0)&&($_SESSION['nuite']<=15))
				{ $s=mysqli_query($con,"SELECT * FROM chambre WHERE EtatChambre='active' AND numch='".$_POST['edit8']."'");
					$ez=mysqli_fetch_assoc($s);
					switch ($_POST['combo2'])
					{
						case 'individuelle':	$tarif=$ez['tarifsimple']; break;
						case 'double': $tarif=$ez['tarifdouble']; break;
						default: echo ''; break;
					}
					$mt=$_SESSION['nuite']*$tarif;

					$position=1; $mois_0=!empty($mois_0)?$mois_0:0;
					 $query_Recordset_2 = "SELECT position FROM reservationch WHERE annee like '".$_SESSION['ans']."' AND mois IN ('".$_SESSION['mois']."','".$mois_0."') AND  numch like '".$_POST['edit8']."' AND  fin like '".$_SESSION['jr_debut']."'";
					//echo $query_Recordset_2;
					$Recordset_2 = mysqli_query($con,$query_Recordset_2) or die(mysqli_error($con));
					$row_Recordset_2=mysqli_fetch_assoc($Recordset_2);
					$totalRows_Recordset1 = mysqli_num_rows($Recordset_2);
					$positionCourant=$row_Recordset_2['position'];
					//echo  "</br>".$positionCourant;
					if(($totalRows_Recordset1>=0)&&($positionCourant==1)) //Si tel est le cas, enregistrer tout en modifier la position
						$position=5;
					else
						$position=1;

					$query_Recordset_6 = "SELECT numreserv,numch FROM reservationch WHERE '".$_SESSION['debut']."' > datarrivch AND '".$_SESSION['debut']."' < datdepch  AND numch like '".$_POST['edit8']."'";
					$Recordset_6 = mysqli_query($con,$query_Recordset_6) or die(mysqli_error($con));
					//echo $query_Recordset_6;
					$totalRows_Recordset6 = mysqli_num_rows($Recordset_6);
					if($totalRows_Recordset6>0)
					{ $etat_01=0;
					}else
					{	$etat_01=1;
						$query_Recordset_6 = "SELECT numreserv,numch FROM reservationch WHERE '".$_SESSION['fin']."' > datarrivch AND '".$_SESSION['fin']."' < datdepch  AND numch like '".$_POST['edit8']."'";
						$Recordset_6 = mysqli_query($con,$query_Recordset_6) or die(mysqli_error($con));
						//echo "</br>".$query_Recordset_6;
						$totalRows_Recordset6 = mysqli_num_rows($Recordset_6);
						if($totalRows_Recordset6>0)
						 $etat_01=0; else $etat_01=1;
					}

					$query_Recordset_3 = "SELECT numch,position FROM reservationch WHERE annee like '".$_SESSION['ans']."' AND mois IN ('".$_SESSION['mois']."','$mois_0') AND '".$_SESSION['jr_debut']."' between debut AND (fin-1) AND numch like '".$_POST['edit8']."' ";
					$Recordset_3 = mysqli_query($con,$query_Recordset_3) or die(mysqli_error($con));
					$row_Recordset_3=mysqli_fetch_assoc($Recordset_3);
					$totalRows_Recordset3 = mysqli_num_rows($Recordset_3);
					if($Recordset_3)
					 //Si tel est le cas, enregistrer tout en modifier la position
					if($totalRows_Recordset3>=0)
					{ $etat_1=0;
					}else
					{$etat_1=1;
					}

					if(($etat_1==0)&&($etat_01==1))
					{  // Insertion normale sur le même mois
               $re="INSERT INTO reservationch VALUES(NULL,'".$_POST['edit1']."','".$_POST['edit8']."',
							'".$_SESSION['date_du_jour']."','".$_SESSION['jr_debut']."','".$_SESSION['jr_fin']."','".$_SESSION['mois']."','".$_SESSION['ans']."','$position','".addslashes($_SESSION['nomT'])."','".addslashes($_SESSION['prenomT'])."','".$_SESSION['contact']."',
							'".$_SESSION['groupe']."','".$_SESSION['debut']."','".$_SESSION['fin']."','".$_SESSION['nuite']."','".$_SESSION['nbch']."','".$_POST['edit10']."','0','".$_SESSION['login']."','".$_SESSION['login']."')";
							$req=mysqli_query($con,$re);
						//echo $re;
						// $update=mysqli_query($con,"UPDATE configuration_facture SET num_reserv =num_reserv +1  WHERE num_reserv !=''");

						if($_POST['edit42']==1) //Non assujetti à la TVA
							$tva=0; else $tva=$_POST['TvaD'];

							// if($_POST['combo2']=='individuelle')
							// $ttc=(int)($tarif*0.18+$tarif+1000);
							// else
							// $ttc=(int)($tarif*0.18+$tarif+2000);

							$ttc=$tarif;

							 $ret="INSERT INTO reserverch VALUES('".$_POST['edit1']."','".$_POST['edit8']."','".$_POST['combo2']."','".$tarif."','$ttc','".$_POST['edit10']."',0,0)";

							 //if($_SESSION['exhonerer1']==1) $sql=mysqli_query($con,"INSERT INTO exonerer_tva VALUES('".date('Y-m-d')."','".$_POST['edit1']."')");
							 //if($_SESSION['exhonerer_aib']==1) $sql=mysqli_query($con,"INSERT INTO exonerer_aib VALUES('".date('Y-m-d')."','".$_POST['edit1']."')");

							$ret1=mysqli_query($con,$ret);
							if ($ret1)
							{ 	$de=mysqli_query($con,"UPDATE nombre_reservation SET nbre_chambre=nbre_chambre-1 WHERE nbre_chambre='$nbre_chambre'");
								echo "<script language='javascript'>";
								echo 'alertify.success("Réservation de la chambre effectuée avec succès");';
								echo "</script>";
								//$msg=" La r&eacute;servation de la chambre s'est effectu&eacute;e avec succ&egrave;s";
								$som=1;
							$ret1=mysqli_query($con,'SELECT nbre_chambre,nbre_salle FROM nombre_reservation');
							while ($ret_1=mysqli_fetch_array($ret1))
								{
								 $nbre_chambre1=$ret_1['nbre_chambre'];
								 $nbre_salle1=$ret_1['nbre_salle'];
								}
							if($nbre_chambre1==0)
								{//if ($nbre_salle1>=1)
								if(isset($_SESSION['salle'])){
								$_SESSION['taxe']=$_POST['edit2_8']+$_POST['edit28'];
								  redirect_to("reservationsal.php?menuParent=Gestion des Réservations&sal=1");}
								else if((empty($nbre_salle1))||($nbre_salle1==0)) {$_SESSION['taxe']=$_POST['edit2_8']+$_POST['edit28'];
								redirect_to("cresch.php?menuParent=Gestion des Réservations");
								//echo 12;
								}
							 else echo"Erreur technique";
								}


							} else {$som2=isset($_POST['edit2_8'])?$_POST['edit2_8']:NULL;
								echo "<script language='javascript'>";
								echo 'alertify.error("Cette chambre est déjà occupée pour cette période");';
								echo "</script>";
							//$msg="Cette chambre est déjà occupée pour cette période";
							}
				    } else   {	 echo "<script language='javascript'>";
								echo 'alertify.error("Cette chambre est déjà occupée pour cette période");';
								echo "</script>";
								//$msg="<i> Cette chambre est déjà occupée pour cette période</i>";
							}
				 }

			 //Insertion à cheval de date sur deux mois
			 else
			   {
			   $nbj=date("t",mktime(0,0,0,$_SESSION['mois'],1,$_SESSION['ans']));//nbre de jours du mois courant
				$s=mysqli_query($con,"SELECT * FROM chambre WHERE numch='".$_POST['edit8']."' AND EtatChambre='ACTIVE'");
					while($ez=mysqli_fetch_array($s)){
						$tarif=$ez['tarifsimple'];
						$tarif2=$ez['tarifdouble'];
					}
					switch ($_POST['combo2'])
					{
						case 'individuelle':	$tarif; break;
						case 'double': $tarif=$tarif2; break;
						default: echo 'llll'; break;
					}
					$mt=$_SESSION['nuite']*$tarif;

					$position=1;
					$query_Recordset_2 = "SELECT position FROM reservationch WHERE annee like '".$_SESSION['ans']."' AND mois like '".$_SESSION['mois']."' AND  numch like '".$_POST['edit8']."' AND  fin like '".$_SESSION['jr_debut']."'";
					$Recordset_2 = mysqli_query($con,$query_Recordset_2) or die(mysql_error());
					$row_Recordset_2=mysqli_fetch_assoc($Recordset_2);
					$totalRows_Recordset1 = mysqli_num_rows($Recordset_2);
					$positionCourant=$row_Recordset_2['position'];
					if(($totalRows_Recordset1>=0)&&($positionCourant==1))  //Si tel est le cas, enregistrer tout en modifier la position
					 {$position=5;}
					else
					 {$position=1;}

					$query_Recordset_6 = "SELECT numreserv,numch FROM reservationch WHERE '".$_SESSION['debut']."' > datarrivch AND '".$_SESSION['debut']."' < datdepch  AND numch like '".$_POST['edit8']."'";
					$Recordset_6 = mysqli_query($con,$query_Recordset_6) or die(mysqli_error($con));
					//echo $query_Recordset_6;
					$totalRows_Recordset6 = mysqli_num_rows($Recordset_6);
					if($totalRows_Recordset6>0)
					{ $etat_01=0;
					}else
					{	$etat_01=1;
						$query_Recordset_6 = "SELECT numreserv,numch FROM reservationch WHERE '".$_SESSION['fin']."' > datarrivch AND '".$_SESSION['fin']."' < datdepch  AND numch like '".$_POST['edit8']."'";
						$Recordset_6 = mysqli_query($con,$query_Recordset_6) or die(mysqli_error($con));
						//echo "</br>".$query_Recordset_6;
						$totalRows_Recordset6 = mysqli_num_rows($Recordset_6);
						if($totalRows_Recordset6>0)
						 $etat_01=0; else $etat_01=1;
					}

					// Code à revoir
					$query_Recordset_3 = "SELECT numch,position FROM reservationch WHERE annee like '".$_SESSION['ans']."' AND mois like '".$_SESSION['mois']."' AND '".$_SESSION['jr_debut']."' between debut AND (fin-1) AND numch like '".$_POST['edit8']."' ";
					$Recordset_3 = mysqli_query($con,$query_Recordset_3) or die(mysql_error($con));
					$row_Recordset_3=mysqli_fetch_assoc($Recordset_3);
					$totalRows_Recordset3 = mysqli_num_rows($Recordset_3);
					if($Recordset_3)
					if($totalRows_Recordset3>=0)
					{ $etat_1=0;
					}else
					{$etat_1=1;
					}

					if(($etat_1==0)&&($etat_01==1))
					//if(($etat_1==0)&&($etat_01==1))
					{  // Insertion normale sur le mois courant
                        $re="INSERT INTO reservationch VALUES(NULL,'".$_POST['edit1']."','".$_POST['edit8']."',
							'".$_SESSION['date_du_jour']."','".$_SESSION['jr_debut']."','$nbj','".$_SESSION['mois']."','".$_SESSION['ans']."','$position','".addslashes($_SESSION['nom'])."','".addslashes($_SESSION['prenom'])."','".$_SESSION['contact']."',
							'".$_SESSION['groupe']."','".$_SESSION['debut']."','".$_SESSION['fin']."','".$_SESSION['nuite']."','".$_SESSION['nbch']."','".$_POST['edit10']."','0','".$_SESSION['login']."','".$_SESSION['login']."')";
							$req=mysqli_query($con,$re);

							// if($_POST['combo2']=='individuelle')
							// $ttc=(int)($tarif*$TvaD+$tarif+1000);
							// else
							// $ttc=(int)($tarif*$TvaD+$tarif+2000);

								$ttc=$tarif;

							//if($_SESSION['exhonerer1']==1) $sql=mysqli_query($con,"INSERT INTO exonerer_tva VALUES('".date('Y-m-d')."','".$_POST['edit1']."')");
							//if($_SESSION['exhonerer_aib']==1) $sql=mysqli_query($con,"INSERT INTO exonerer_aib VALUES('".date('Y-m-d')."','".$_POST['edit1']."')");

							$ret="INSERT INTO reserverch VALUES('".$_POST['edit1']."','".$_POST['edit8']."','".$_POST['combo2']."','".$tarif."','$ttc','".$_POST['edit10']."','0','0')";
							$ret1=mysqli_query($con,$ret);
							if ($ret1)
							{ 	$de=mysqli_query($con,"UPDATE nombre_reservation SET nbre_chambre=nbre_chambre-1 WHERE nbre_chambre='$nbre_chambre'");
								echo "<script language='javascript'>";
								echo 'alertify.success("Réservation de la chambre effectuée avec succès");';
								echo "</script>";
								//$msg=" La r&eacute;servation de la chambre s'est effectu&eacute;e avec succ&egrave;s";
								$som=1;
							//Insertion sur le deuxième mois
                            $re="INSERT INTO reservationch VALUES(NULL,'".$_POST['edit1']."','".$_POST['edit8']."',
							'".$_SESSION['date_du_jour']."','01','".$_SESSION['jr_fin']."','".$_SESSION['mois2']."','".$_SESSION['ans']."','$position','".addslashes($_SESSION['nom'])."','".addslashes($_SESSION['prenom'])."','".$_SESSION['contact']."',
							'".$_SESSION['groupe']."','".$_SESSION['debut']."','".$_SESSION['fin']."','".$_SESSION['nuite']."','".$_SESSION['nbch']."','".$_POST['edit10']."','0','".$_SESSION['login']."','".$_SESSION['login']."')";
							$req=mysqli_query($con,$re);

							$ret1=mysqli_query($con,'SELECT nbre_chambre,nbre_salle FROM nombre_reservation');
							while ($ret_1=mysqli_fetch_array($ret1))
								{
								 $nbre_chambre1=$ret_1['nbre_chambre'];
								 $nbre_salle1=$ret_1['nbre_salle'];
								}
							if($nbre_chambre1==0)
								{$_SESSION['taxe']=$_POST['edit2_8']+$_POST['edit28'];
								if(isset($_SESSION['salle'])) redirect_to("reservationsal.php?menuParent=Gestion des Réservations&sal=1");
								else if((empty($nbre_salle1))||($nbre_salle1==0)) {
								redirect_to("cresch.php?menuParent=Gestion des Réservations");
									//echo 13;
								}
							 else echo"Erreur technique";
								}

							} else {$som2=$_POST['edit2_8'];
								echo "<script language='javascript'>";
								echo 'alertify.error("Cette chambre est déjà occupée pour cette période");';
								echo "</script>";
							//$msg=" Cette chambre est déjà occupée pour cette période";
							}
				       }
                    else   {	echo "<script language='javascript'>";
								echo 'alertify.error("Cette chambre est déjà occupée pour cette période");';
								echo "</script>";
							//$msg="<i>Cette chambre est déjà occupée pour cette période</i>";
							}
			   }
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
	<body bgcolor='azure' style=""><br/><br/>
	<div align="" class="container" style="">
		<table align='center' width='' height='' style='' id="tab"> <tr> <td>
			<fieldset style='margin-left:auto; margin-right:auto;border:0px solid white;background-color:#D0DCE0;font-family:Cambria;'>
			<form action='reserverch.php?menuParent=Gestion des Réservations' method='post'>
				<table  align='center' style='' width='750' height='250'>
					<tr>
						<td colspan='4' style=''><br/>
							<h3 style='text-align:center; font-family:Cambria;color:Maroon;font-weight:bold;'>SELECTION DES CHAMBRES</h3>
						</td>
					</tr>
					<tr>
						<td colspan='4'>  <hr/>&nbsp; </td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Réservation N°: </td>
						<td><input type='text' name='edit1' id='edit1' value="<?php echo $_SESSION['numresch'];?>" /> </td>
						<td>&nbsp; Nbre de Chambres : </td>
						<td style='padding-right:15px;'><input type='text' name='edit2' value="<?php echo $_SESSION['nbch']; ?>" readonly  /> </td>
					</tr>
					<tr>
						<input type='hidden' name='TvaD' id='TvaD' readonly value='<?php if(isset($TvaD)) echo $TvaD;  ?>'/>

						<input type='hidden' required='required' name='edit42' id='edit42'  value='<?php //if(!empty($RegimeTVA)&&($RegimeTVA==1)) echo 1; else echo $TvaD;?>'/>
					<?php
							$date=$Jour_actuel;
										//if(($date >=$_SESSION['debut'])&&($date <=$_SESSION['fin']))
											//echo $req = "SELECT numch,nomch FROM chambre WHERE EtatChambre='active' AND  numch NOT IN (SELECT numch FROM reservationch WHERE datarrivch  BETWEEN '".$_SESSION['debut']."' AND '".$_SESSION['fin']."') 	AND numch NOT IN (SELECT mensuel_compte.numch FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.numfiche=mensuel_compte.numfiche and mensuel_fiche1.etatsortie='NON') ";
										//else
											//echo $req = "SELECT numch,nomch FROM chambre WHERE EtatChambre='active' AND  numch NOT IN (SELECT numch FROM reservationch WHERE datarrivch  BETWEEN '".$_SESSION['debut']."' AND '".$_SESSION['fin']."')";
					?>
						<td> <br/>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;N°: </td>
						<td> <br/>
							<select name='edit8' id='edit8' style='font-family:sans-serif;font-size:80%;'>
								<option value=''>  </option>
									<?php
										//$date=date('Y-m-d');
										//if(($date >=$_SESSION['debut'])&&($date <=$_SESSION['fin']))
											$req = "SELECT numch,nomch FROM chambre WHERE EtatChambre='active' AND  numch NOT IN (SELECT numch FROM reservationch WHERE datarrivch  BETWEEN '".$_SESSION['debut']."' AND '".$_SESSION['fin']."')
										AND  numch NOT IN (SELECT numch FROM reservationch WHERE datdepch  BETWEEN '".$_SESSION['debut']."' AND '".$_SESSION['fin']."')

										AND numch NOT IN (SELECT mensuel_compte.numch FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.numfiche=mensuel_compte.numfiche and mensuel_fiche1.etatsortie='NON') ";
										//else
											//$req = "SELECT numch,nomch FROM chambre WHERE EtatChambre='active' AND  numch NOT IN (SELECT numch FROM reservationch WHERE datarrivch  BETWEEN '".$_SESSION['debut']."' AND '".$_SESSION['fin']."')";
										$ret=mysqli_query($con,$req) ;
/* 										else
										$ret=mysqli_query($con,"SELECT numch,nomch FROM chambre WHERE numch NOT IN (SELECT numch FROM reservationch WHERE datdepch BETWEEN '".$_SESSION['debut']."' AND '".$_SESSION['fin']."' )AND numch NOT IN (SELECT numch FROM reservationch WHERE datdepch  BETWEEN '".$_SESSION['debut']."' AND '".$_SESSION['fin']."')
										AND numch NOT IN (SELECT compte.numch FROM fiche2,compte WHERE fiche2.numfiche=compte.numfiche and fiche2.etatsortie='NON')") or die (mysql_error()); */
										while ($ret1=mysqli_fetch_assoc($ret))
											{
												echo '<option value="'.$ret1['numch'].'">';
												echo($ret1['nomch']);
												echo '<option></option>';
												echo '</option>';
											}
									?>
							</select>
						</td>
						<td><br/>&nbsp; Type de chambre : </td>
						<td style='padding-right:15px;'><br/> <input type='text' name='edit9' id='edit9' readonly  /> </td>
					</tr>
					<tr>
						<td><br/>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Type d'occupation : </td>
						<td><br/>
							<select name='combo2' id='combo2' onchange="Aff1();" style='' >	
								<option value=''>  </option>							
								<option value='individuelle'> INDIVIDUELLE </option>
								<option value=''>  </option>
								<option value='double'> DOUBLE </option>
							</select>
						</td>
						<td> <br/>&nbsp;&nbsp;Tarif : </td> <input type='hidden' name='edit28' id='edit28' readonly />
						<input type='hidden' name='edit2_8' id='edit2_8' value='<?php $som=!empty($som)?$som:0;$som2=!empty($som2)?$som2:0;     if($som==1) echo (int)$_POST['edit28']+(int)$_POST['edit2_8']; else echo $som2;?> '; />
						<td style='padding-right:15px;'> <br/><input type='text' name='edit10' id='edit10' readonly /> </td>
					</tr>
					<tr>
						<td colspan='4'>  <hr/>&nbsp; </td>
					</tr>

						<tr>
						<td> &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<input  type='checkbox' id="test3" name='salle'  <?php if(isset($_SESSION['salle']) && ($_SESSION['salle']==1)) echo "checked='checked'";?> value='1'/> <label for="test3" ><span style='font-style:italic;'>Ajouter des Salles</span></label></td>

					</tr>
					<tr>
						<td colspan='4' align='center'></br>
						<input class='bouton2' type='submit' name='aj' value='AJOUTER' style=''/><br/>&nbsp;</td>
					</tr>

				</table>
			</form>
			</fieldset>
		</td> </tr> </table> <?php  if(!empty($msg))
		echo" <table align='center'>
			<tr>
			    <td>
				<a href='' style='text-decoration:none;'></a><span style='text-align:center; font-family:Cambria;color:blue;margin-left:50px;font-style:italic;'> $msg</span></a>
				</td>
			</tr>	</table>";
			else
			echo" <table align='center'>
			</table>";?>
		</div>
	</body>

	<script type="text/javascript">

			function Aff1()
		{
            /*  if (document.getElementById("combo2").value=='individuelle')
				document.getElementById("edit28").value=1000;
			else
				document.getElementById("edit28").value=2000; */
		}
	// fonction pour selectionner le type de salle
		function action(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						var mavariable = leselect.split('|');
						document.getElementById('edit42').value = mavariable[1];
						document.getElementById('edit9').value = mavariable[0];
						//document.getElementById('edit9').value = '\t'+leselect;
						if(document.getElementById('edit42').value ==1)
						alertify.success("Non Assujetti(e) à la TVA");
					}
				}
				xhr.open("POST","ftypech.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit8');
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("numch="+sh);
		}

	// fonction pour selectionner le tarif
		function action1(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit10').value = leselect;
					}
				}
				xhr.open("POST","others/ftarif.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo2');
				sel1 = document.getElementById('edit8');
				sh1=sel1.options[sel1.selectedIndex].value;
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("objet="+sh+"&numch="+sh1);
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
