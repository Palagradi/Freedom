<?php
include_once'menu.php';

		$agent=!empty($_GET['agent'])?$_GET['agent']:NULL;
		
		$req = "SELECT MIN(datarriv) AS dateA, MAX(datsortie) AS dateS from fiche1";
		$ret=mysqli_query($con,$req) ; $data=mysqli_fetch_assoc($ret);  $dateA=substr($data['dateA'],0,4);  $dateS=substr($data['dateS'],0,4);
						
						
?>
<html>
	<?php 
	if(isset($_GET['p'])) {
	?>
	<head> 
		<style type="text/css">
		@media print { .noprt {display:none} }
		@page {size: paysage; }

		option:first {
			color: #999;
		}		
		</style>
	</head>
	<?php 
	}
	?>
	<body bgcolor='azure' style="">
	<div align="" style="border:2px solid white;background-color:#D0DCE0;border-radius: 5px;-moz-border-radius: 5px;width:1000px;margin:20px auto;">
	<?php 
	if(!isset($_GET['p'])) {
	?>
		<form  action='<?=getURI(); ?>&p=1' method='post'>
		<br/>	<table align='center' style=''>
				<tr>
					<td style=''><center> <font color='green' size='5' >ETABLISSEMENT DES FICHES DE RENSEIGNEMENT POUR UNE PERIODE </font></center></td>
				</tr>
			</table> <br/>
			<table align='center' style=''>

				</tr>
				<tr>
				<td>Période du: </td>
				<td>
					<select name='se1' id='se1' style="font-family:sans-serif;font-size:80%;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;">
						<option value=''>JJ</option>
						<?php						
							for ($i=1; $i<32; $i++)
								{
									if ($i<10)
										{
											echo '<option value="0'.$i.'">';
											echo($i);
											echo '</option>';
										} else
										{
											echo '<option value="'.$i.'">';
											echo($i);
											echo '</option>';
										}
								}
						?>
					 </select>
					<select name='se2' id='se2' style="font-family:sans-serif;font-size:80%;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;">
							<option value=''>MM</option>
						<option value='01'> Janvier </option>
							<option value='02'> Février </option>
							<option value='03'> Mars </option>
							<option value='04'> Avril </option>
							<option value='05'> Mai  </option>
							<option value='06'> Juin </option>
							<option value='07'> Juillet </option>
							<option value='08'> Août</option>
							<option value='09'> Septembre </option>
							<option value='10'> Octobre </option>
							<option value='11'> Novembre</option>
							<option value='12'> Décembre </option>
						</select>
					<select name='se3'id='se3'style="font-family:sans-serif;font-size:80%;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;" >
						<option>AAAA  </option>
						<?php
							for ($i=$dateA; $i<= date('Y') ; $i++)
								{
									echo '<option value="'.$i.'">';echo($i);echo '</option>';
								}
						?>
					</select>
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AU: </td>
				<td>
				<select name='se4' id='se4' style="font-family:sans-serif;font-size:80%;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;">
						<option value=''>JJ</option>
							<?php
								for ($i=1; $i<32; $i++)
								{
									if ($i<10)
										{
											echo '<option value="0'.$i.'">';
											echo($i);
											echo '</option>';
										} else
										{
											echo '<option value="'.$i.'">';
											echo($i);
											echo '</option>';
										}
								}
							?>
					</select>
					<select name='se5' id='se5' style="font-family:sans-serif;font-size:80%;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;">
										<option value=''>MM </option>
										<option value='01'> Janvier </option>
										<option value='02'> Février </option>
										<option value='03'> Mars </option>
										<option value='04'> Avril </option>
										<option value='05'> Mai  </option>
										<option value='06'> Juin </option>
										<option value='07'> Juillet </option>
									<option value='08'> Août</option>
										<option value='09'> Septembre </option>
										<option value='10'> Octobre </option>
										<option value='11'> Novembre</option>
										<option value='12'> Décembre </option>
					</select>
					<select name='se6'id='se6' style="font-family:sans-serif;font-size:80%;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;">
								<option>AAAA  </option>
						<?php
								for ($i=$dateA; $i<= date('Y') ; $i++)
										{
											echo '<option value="'.$i.'">';
											echo($i);
											echo '</option>';
										}
						?>
					</select>
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type='Submit' name='ok' value="OK" class='bouton3' style="border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;"/></td>
				<tr> 
					<td> <br/>&nbsp;&nbsp;
					</td> 
				</tr> 
				<input type='hidden' name='agent' value='<?php echo $agent;?>'/>
			</tr>
		</table>
	</form>
	
	<?php 
	}else {
		$jr_debut=$_POST['se1'];
		$mois_debut=$_POST['se2'];
		$ans_debut=$_POST['se3'];
		$date=$ans_debut.'-'.$mois_debut.'-'.$jr_debut;
		
		$jr_fin=$_POST['se4'];
		$mois_fin=$_POST['se5'];
		$ans_fin=$_POST['se6'];
		$date2=$ans_fin.'-'.$mois_fin.'-'.$jr_fin;
		//$sql=mysqli_query($con,"CREATE OR REPLACE VIEW view_fiche3 AS SELECT numfiche,numfichegrpe,numcli_2 AS numcli,codegrpe,etatcivil,profession,domicile,nbenfant,motifsejoiur,datarriv,provenance,datdep,datsortie,heuresortie,destination,modetransport,etatsortie,numresch,numfact,agenten,agentmo,nuite,Avertissement FROM fiche2"); 
		$or="SELECT * FROM fiche1,client,compte,chambre WHERE datarriv between '".$date."' AND '".$date2."' AND fiche1.numcli_1=client.numcli AND compte.numfiche=fiche1.numfiche AND chambre.numch=compte.numch
		UNION
		SELECT * FROM fiche1,client,compte,chambre WHERE datarriv between '".$date."' AND '".$date2."' AND fiche1.numcli_2=client.numcli AND compte.numfiche=fiche1.numfiche AND chambre.numch=compte.numch";
		mysqli_query($con,"SET NAMES 'utf8'");
		$or1=mysqli_query($con,$or);
		
		
	$i=0;
	while ($ret=mysqli_fetch_array($or1)) 
	{$i++;
	 $numfiche=substr($ret['numfiche'],0,8);
	 $numcli=$ret['numcli']; $nomcli=$ret['nomcli']; $prenomcli=$ret['prenomcli']; $datnaiss=$ret['datnaiss'];	 $lieunaiss=$ret['lieunaiss'];	 $pays=$ret['pays'];	 $sexe=$ret['sexe'];
	 $profession=$ret['profession']; $domicile=$ret['domicile']; $nbenfant=$ret['nbenfant']; $adresse=$ret['adresse']; $motifsejoiur=$ret['motifsejoiur'];	 $datarriv= substr($ret['datarriv'],8,2).'-'.substr($ret['datarriv'],5,2).'-'.substr($ret['datarriv'],0,4);	 $typepiece=$ret['typepiece'];
	 $numiden=$ret['numiden'];  $institutiondeliv=$ret['institutiondeliv'];  $lieudeliv=$ret['lieudeliv'];	 $datsortie=substr($ret['datsortie'],8,2).'-'.substr($ret['datsortie'],5,2).'-'.substr($ret['datsortie'],0,4);
	 $provenance=$ret['provenance']; $destination=$ret['destination']; $date_livrais=$ret['date_livrais']; $etatcivil=$ret['etatcivil']; $modetransport=$ret['modetransport']; 	 $nomch=$ret['nomch'];	 $occupation=$ret['typeoccup'];
			echo "<table align='center' border='0' style='margin-top:-25px;'> "; 
					if($i==1)
					{ echo "<tr><td style='padding-bottom:5px;'> <a href='piece.php' target='_BLANK' style='text-decoration:none;'><span style='font-size:1em;font-family:cambria;color:green;font-weight:bold;'>Afficher les pièces d'identités</span></a>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</a>
					   </td>
						<td style=''>
							<a href=''><img src='logo/im10.jpg' width='80' id='button-imprimer' class='noprt' title='Imprimer'  style=''></a>
						</td>
					</tr>";}
					echo "<tr>
						<td>&nbsp;
						</td>
					</tr>
				</table>";
			echo "<table align='center' style='background-color:#D0DCE0;'> 
			<tr> 
				<td>
					<fieldset> 
						<legend align='' style='font-size:1em;'><b> FICHE DE RENSEIGNEMENT</b> </legend>
						<form action='impression_fiche.php' method='post' id='form1' name='fiche' >
							<table align='center'> 
								<tr> 
									<td width=''> Numéro de Fiche: </td> 
									<td width=''> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='edit1' readonly value='".$numfiche."'  /> </td>
									<td width=''>
									&nbsp;&nbsp;&nbsp;&nbsp;Chambre occupée: </td> 
									<td width='' > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='edit1' readonly value='".$nomch."'  /> </td>
									<td width=''>
									&nbsp;&nbsp;&nbsp;Occupation: </td> 
									<td width='' > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='edit1' readonly value='".$occupation."'  /> </td>
								</tr> 
								
							</table>
							<table>
								<tr>
									<td>
										<fieldset> 
											<legend align='' style='font-size:1em;'><b> INFORMATIONS SUR L'IDENTITE DU CLIENT</b></legend> 
											<table > 
												<tr> 
													<td> Numero: </td>
													<td> <input type='text' name='edit2' id='edit2' style='' readonly value='".$numcli."' />  </td>
													<td> Nom: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													</td>
													<td> <input type='text' name='edit4'id='edit4' style='' readonly value='".$nomcli."' /> </td>
													<td> Pr&eacute;noms: </td>
													<td> <input type='text' name='edit4'id='edit4' style='' readonly value='".$prenomcli."' /> </td>
												</tr> 

												<tr> 
													<td> Date de naissance: </td>
													<td> <input type='text' name='edit6' id='edit6' readonly value='".$datnaiss."'/> </td>
													<td> Lieu de naissance: </td>
													<td> <input type='text' name='edit7' id='edit7' readonly value='".$lieunaiss."'/> </td>
											
													<td> Pays d'origine: </td>
													<td> <input type='text' name='edit8' id='edit8' readonly value='".$pays."'/> </td>
												</tr>
												<tr> 
													<td> Sexe: </td>
													<td> <input type='text' name='edit5' id='edit5' readonly value='".$sexe."'/> </td>
											<td> Etat-civil: </td>
													<td>
													<input type='text' name='combo2' id='' readonly value='".$etatcivil."'/> 
													</td>
													<td> Profession: </td>
													<td> 
												<input type='text' name='edit9' id='edit9' readonly value='".$profession."'/> 
													</td>
												</tr>
												<tr> 
													<td> Domicile habituel: </td>
													<td> <input type='text' name='edit10'  style='' value='".$domicile."' /> </td>
													<td> Nombre d'enfant de moins de 15 ans accompagnants: </td>
													<td> <input type='text' name='edit11' style='' value='".$nbenfant."'/> </td>
													<td> Contact: </td>
													<td> <input type='text' name='edit12'style='' value='".$adresse."'/> </td>
												</tr>
										
											</table> 
										</fieldset> 
									</td>
								</tr> 
								<tr>
									<td>
										<fieldset> 
											<legend style='font-size:1em;'><b> TYPE DE PIECE D'IDENTITE </b></legend> 
											<table> 
												<tr>
													<td> Type de pièce: </td>
													<td> <input type='text' name='edit_9'  id='edit_9' readonly value='".$typepiece."' />  </td>
													<td> Numéro de pièce: </td>
													<td> <input type='text' name='edit_13'   id='edit_13' size='30' readonly value='".$numiden."'/> </td>
													<td> Délivrée le: </td>
													<td> <input type='text' name='edit_14'  id='edit_14' size='30' readonly value='".$date_livrais."'/> </td>
												</tr> 
												
												<tr>
													<td> à: </td>
													<td> <input type='text' name='edit_15'    id='edit_15' size='30' readonly value='".$lieudeliv."'/> </td>
													<td> Par: </td>
													<td> <input type='text' name='edit_16'   id='edit_16' size='30' readonly value='".$institutiondeliv."'/> </td>
													<td> <input type='hidden' name='edit18' id='edit18' value='' readonly /> </td>
												</tr>
											</table>
										</fieldset>
									</td> 
								</tr>
								<tr>
									<td>
										<fieldset> 
											<legend style='font-size:1em;'><b>SEJOUR </b></legend> 
											<table> 
												<tr>
													<td> Motif du Séjour: </td>
													<td colspan=''> 
													<input type='text' name='edit17' id='edit17' readonly value='".$motifsejoiur."'/> 
													</td>
												    <td> Date d'arrivée: </td>
													<td> <input type='text' name='edit_2' id='edit_2' value='".$datarriv."' readonly /> </td>
													<td> Venant de: </td>
													<td> <input type='text' name='edit19'  style='' value='".$destination."'/> </td>
												</tr>

												<tr>
													<td> Date de sortie: </td>
												  <td style=''><input type='text' name='ladate' id='ladate' size='20' readonly style='' value='".$datsortie."' />

												  </td>
													<input type='hidden' name='nui' id='nui'/>													
													<td> Allant à : </td>
													<td> <input type='text' name='edit21' style='' value='".$provenance."'/> </td>
													<td> Mode de transport: </td>
													<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													A&eacute;rien <input type='radio'"; if($modetransport=="air") echo "CHECKED=CHECKED"; echo "name='rad' value='air'/> </td>
													<td> Maritime <input type='radio' "; if($modetransport=="mer") echo "CHECKED=CHECKED"; echo "name='rad' value='mer'/></td>
													<td> Terrestre <input type='radio' "; if($modetransport=="terre") echo "CHECKED=CHECKED"; echo "  name='rad' value='terre' /> </td>
												</tr>
											</table>
										</fieldset>
									</td> 
								</tr> 
							</table>
						</form>
					</fieldset>
				</td>
			</tr> 
		</table> ";
	//echo "<hr style='width:1100;'/>";
				if($i==1){
					
					} else 
						echo "<hr style='width:1050;'/>";
	}
		

	?>
	
<script type="text/javascript">
   var bouton = document.getElementById('button-imprimer');
	bouton.onclick = function(e) {
	  e.preventDefault();
	  print();
	}
 </script>	
	
	<?php 
	}
	?>
	</div>
	</body>
</html>
