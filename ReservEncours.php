			<tr>
				<td>
					<fieldset style='border:2px solid white;'>
						<legend align='center' style='color:#046380;font-size:110%;'><b><?php //if(isset($dataT->nomdemch)) echo "RESERVATION DE CHAMBRE EN COURS"; else 
						echo "LISTE JOURNALIERE DES RESERVATIONS"; ?></b></legend>
					<form action='fiche.php?menuParent=Hébergement<?php if(isset($_GET['numcli'])) echo "&numcli=".$_GET['numcli'];else if(!empty($_SESSION['numcli'])) echo "&numcli=".$_SESSION['numcli']; else { }  if(isset($_GET['change'])) echo "&change=".$_GET['change']; if(isset($_GET['numfiche'])) echo "&numfiche=".$_GET['numfiche']; //echo getURI();	?>' method='post' name='fiche' id='form1' enctype='multipart/form-data'>
						<table border='0' align='center' style='font-family:cambria;'>
							<tr>
								<td > Identité du client :&nbsp;&nbsp;</td>
								<td>
									<select name='s1' id='s1' style='font-family:sans-serif;font-size:80%;width:200px;height:25px;' onchange="document.forms['form1'].submit();">
										<option value=''></option>
											<?php
												mysqli_query($con,"SET NAMES 'utf8'");
												$or="SELECT distinct reservationch.numresch,reservationch.nomdemch,reservationch.prenomdemch,reservationch.codegrpe FROM reservationch,reserverch WHERE reservationch.numresch=reserverch.numresch and reservationch.debut<='$jour_courant' AND reservationch.fin>='$jour_courant' AND mois BETWEEN '$mois_precedent' AND '$mois_suivant' AND annee='$ans_courant' AND reservationch.numresch NOT IN(SELECT num_reserv FROM reservation_tempon)";
												$or1=mysqli_query($con,$or);
												if ($or1)
												{
													while ($roi= mysqli_fetch_array($or1))
													{ if($roi['codegrpe']!='')
														{echo '<option value="'.$roi['numresch'].'">';echo($roi['codegrpe']);echo '</option>';}
													  else
													    {echo '<option value="'.$roi['numresch'].'">';echo($roi['nomdemch'].' '.$roi['prenomdemch']);echo '</option>'; }
														
														echo "<option value=''></option>";
													}
												}
											?>
									</select>
								 &nbsp;&nbsp;&nbsp;&nbsp; <!-- <input type='Submit' name='tt' value="OK" class='bouton3' style="border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;"/>  !-->
								 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='fiche.php?menuParent=Hébergement&zoom=1'><i class="fas fa-search-plus" style=''></i></a>
								</td>
							</tr>
								<tr>
									<td>&nbsp;&nbsp;</td>
								</tr>
							<?php

	/* 							if (isset($_POST['tt'])&& $_POST['tt']=='OK')
								{ $_SESSION['numreserv']= $_POST['s1'];
								  if(!empty($_POST['s1'])) $_SESSION['re']=$_POST['s1'];
								$res=mysqli_query($con,"SELECT numfiche  FROM exonerer_tva WHERE numfiche='".$_POST['s1']."'");
								while($ret=mysqli_fetch_array($res))
									{ $numfiche_1=$ret['numfiche'];
									}
								$ort="SELECT * FROM reservationch,reserverch WHERE reservationch.numresch=reserverch.numresch and reservationch.datarrivch='".date('Y-m-d')."' AND reservationch.numresch='".$_POST['s1']."'";
								//echo "SELECT * FROM reservationch,reserverch WHERE reservationch.numresch=reserverch.numresch and reservationch.datarrivch='".date('Y-m-d')."' AND reservationch.numresch='".$_POST['s1']."'";
								$ort1=mysqli_query($con,$ort);
								if ($ort1)
									{
										$roit= mysqli_fetch_array($ort1);
										echo "<tr border='1'>";
											echo "<td>   Nom du demandeur:"; echo ($roit['nomdemch'].'     '.$roit['prenomdemch']);echo "</td>";
											echo "<td> Avance: "; echo ($roit['avancerc']);echo "</td>";
										echo "</tr border='1'>";
										$_SESSION['avancef']=$roit['avancerc'];
										$_SESSION['codegrpe']=$roit['codegrpe'];
										$ort="SELECT * FROM reservationch,reserverch WHERE reservationch.numresch=reserverch.numresch and datarrivch='".date('Y-m-d')."'";
										$ort1=mysqli_query($con,$ort);
										while ($roit= mysqli_fetch_array($ort1))
											{
												echo "<tr border='1'>";
													echo "<td>Chambre N°"; echo ($roit['numch']);echo "</td>";
													echo "<td>Occupation: "; echo ($roit['typeoccuprc']);echo "</td>";
												echo "</tr>";
											}
							           //header('location:others/info_reservation.php');
									   header('location:fiche.php?menuParent=Hébergement&numreserv=1');
									}
								} */
							?>
						</table>
						</form>
					</fieldset>
				</td>
			</tr>
