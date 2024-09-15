<?php
include_once'menu.php';
	
	        $numfiche=$_GET['numfiche'];$date=date('Y-m-d');$null="RAS";
			if($numfiche!='') {
		    $test = "UPDATE fiche1 SET Avertissement IN('OUI_D','NON_D') WHERE numfiche='$numfiche' AND fiche1.etatsortie='$null' AND datdep >='$date' ";
			$requp = mysql_query($test) or die(mysql_error());
			if(requp) 
			$msg1="<span style='font-weight:bold;'>L'autorisation a été accordée au client pour un séjour de plus de 15 jours</span>";
			}
?>
				<table align="center" width="" border="0" cellspacing="0" style="margin-top:40px;border-collapse: collapse;font-family:Cambria;">
					<caption style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;">  Liste des excès de date de séjour autoriser par la Directrice</caption> 
					<tr style=" background-color:#FF8080;color:white;font-size:1.1em; padding-bottom:5px;">
						<td style="border-right: 2px solid #ffffff" align="center" >Num&eacute;ro</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Nom et Pr&eacute;noms</td>
						<!-- <td style="border-right: 2px solid #ffffff" align="center" >Sexe</td> -->
						<!-- <td style="border-right: 2px solid #ffffff" align="center" >Date de naissance</td>-->
						<td style="border-right: 2px solid #ffffff" align="center" >Lieu de naissance</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Profession</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Domicile habituel</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Motif du séjour</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Date d'arrivée</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Date de sortie envisagée</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Pays d'origine</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Autoriser</td>
						<td align="center" >Continuer</td>
					</tr>
<?php
		
					$connecter= new Connexion_2;
					   if($connecter->testConnexion())
					  {mysql_query("SET NAMES 'utf8'");
					  $query_Recordset1 = "SELECT * FROM fiche1 WHERE fiche1.Avertissement NOT IN ('OUI','NON')";
					   $Recordset_2 = mysql_query($query_Recordset1);
							$cpteur=1;
							while($data=mysql_fetch_array($Recordset_2))
							{
								if($cpteur == 1)
								{
									$cpteur = 0;
									$bgcouleur = "#acbfc5";
								}
								else
								{
									$cpteur = 1;
									$bgcouleur = "#dfeef3";
								}
								$connecter = new Connexion_2;
								if($connecter->testConnexion())
								{
								}
								echo " 	<tr bgcolor='".$bgcouleur."'>"; 
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['numcli']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['nomcli']." ".$data['prenomcli']."</td>";
										//echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['sexe']."</td>";
										//echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['datnaiss']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['lieunaiss']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['profession']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['domicile']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['motifsejoiur']."</td>";
										//substr($data['datarriv'],8,2).'/'.substr($data['datarriv'],5,2).'/'.substr($data['datarriv'],0,4);
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($data['datarriv'],8,2).'-'.substr($data['datarriv'],5,2).'-'.substr($data['datarriv'],0,4)."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($data['datsortie'],8,2).'-'.substr($data['datsortie'],5,2).'-'.substr($data['datsortie'],0,4)."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['pays']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>";
											if ($data['Avertissement']=='OUI_D') echo " 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=''><img src='logo/oui.png' alt='' title='oui' width='25' height='25' border='0'></a>";
										    //echo " 	&nbsp;&nbsp;";
											else echo " 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=''><img src='logo/non.png' alt='non' title='non' width='25' height='25' border='0'></a>";
										echo "</td>";
										if ($data['Avertissement']=='OUI_D'){
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
											echo " 	<a href='fiche_1.php?numfiche=".$data['numfiche']."'><img src='logo/oui.png' alt='' title='oui' width='25' height='25' border='0'></a>";
										    echo " 	&nbsp;&nbsp;";
										    echo " 	<a href='fiche_1.php?numfiche=".$data['numfiche']."'><img src='logo/non.png' alt='non' title='non' width='25' height='25' border='0'></a>";
										echo " </td>";}
										else {echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";echo " 	&nbsp;&nbsp;R.A.S"; echo " </td>";}
									echo " 	</tr> ";
							}
						}
?>
</table>
<br/>
<table align='center' >
	<tr>
		<td bgcolor='green' >
	       <?php echo $msg1;?>
		</td>
	</tr>
</table>