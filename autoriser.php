<?php
	session_start(); 

	//$agent=$_SESSION['agent'];
	   if($_SESSION['poste']==cpersonnel)
		include 'menucp.php'; 
	   	   if($_SESSION['poste']==agent)
		include 'menuprin1.php'; 
			   if($_SESSION['poste']==directrice)
		include 'menudirec.php'; 
			   if($_SESSION['poste']==admin)
		include 'admin.php';
			include 'connexion_2.php';
	include 'connexion.php';
    mysql_query("SET NAMES 'utf8'");
	
	        $numfiche=$_GET['numfiche'];$non=$_GET['non'];
			if(!empty($numfiche)) {
			if(empty($non))
				{$test = "UPDATE fiche1 SET Avertissement='OUI_D' WHERE numfiche='$numfiche' ";
				 $requpA = mysql_query("UPDATE mensuel_fiche1 SET Avertissement='OUI_D' WHERE numfiche='$numfiche' ");
				}
			else
				{$test = "UPDATE fiche1 SET Avertissement='NON_D' WHERE numfiche='$numfiche' ";
				$requpA = mysql_query("UPDATE mensuel_fiche1 SET Avertissement='NON_D' WHERE numfiche='$numfiche' ");
				}
			$requp = mysql_query($test) or die(mysql_error());
			if(requp) {
			if(empty($non)?
			$msg1="<div style='font-weight:bold;border:1px solid red ;background-color:#FF8080;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;'>L'autorisation a été accordée au client pour un séjour de plus de 15 jours</div>":
			$msg1="<div style='font-weight:bold;border:1px solid red ;background-color:#FF8080;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;'>L'autorisation non accordée au client pour un séjour de plus de 15 jours</div>")
			echo '<meta http-equiv="refresh" content="2; url=autoriser.php" />';}
			}
?>
				<table align="center" width="" border="0" cellspacing="0" style="margin-top:40px;border-collapse: collapse;font-family:Cambria;">
					<caption style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;">  Liste des excès de limite de date de séjour <span style="font-style:italic;font-size:0.6em;color:black;"> (pour accorder une autorisation à un client, faites un "double-clic" sur le bouton OUI. Dans le cas contraire "double cliquez" sur NON)  </span></caption> 
					<tr style=" background-color:#FF8080;color:white;font-size:1.1em; padding-bottom:5px;">
						<td style="border-right: 2px solid #ffffff" align="center" >N°</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Num&eacute;ro</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Nom et Pr&eacute;noms</td>
						<!-- <td style="border-right: 2px solid #ffffff" align="center" >Sexe</td> -->
						<td style="border-right: 2px solid #ffffff" align="center" >Date de naissance</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Lieu de naissance</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Profession</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Domicile habituel</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Motif du séjour</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Date d'arrivée</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Date de sortie </td>
						<td style="border-right: 2px solid #ffffff" align="center" >Pays d'origine</td>
						<td align="center" >Autoriser</td>
					</tr>
<?php
		
						$connecter= new Connexion_2;
					   if($connecter->testConnexion())
					  {mysql_query("SET NAMES 'utf8'");$date=date('Y-m-d');$null="RAS";
					 $query_Recordset1 = "SELECT * FROM fiche1,client WHERE fiche1.numcli_1=client.numcli AND fiche1.Avertissement='OUI' ";
					 $Recordset_2 = mysql_query($query_Recordset1);
							$cpteur=1;$i=0;
							while($data=mysql_fetch_array($Recordset_2))
							{$i++;
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
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$i.".</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['numcli']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['nomcli']." ".$data['prenomcli']."</td>";
										//echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['sexe']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['datnaiss']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['lieunaiss']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['profession']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['domicile']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['motifsejoiur']."</td>";
										//substr($data['datarriv'],8,2).'/'.substr($data['datarriv'],5,2).'/'.substr($data['datarriv'],0,4);
										echo " 	<td align='center'  style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($data['datarriv'],8,2).'-'.substr($data['datarriv'],5,2).'-'.substr($data['datarriv'],0,4)."</td>";
										echo " 	<td align='center'  style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($data['datsortie'],8,2).'-'.substr($data['datsortie'],5,2).'-'.substr($data['datsortie'],0,4)."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['pays']."</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
											echo " 	<a href='autoriser.php?numfiche=".$data['numfiche']."'><img src='logo/oui.png' alt='' title='oui' width='25' height='25' border='0'></a>";
											echo " 	&nbsp;&nbsp;";
											echo " 	<a href='autoriser.php?non=1&numfiche=".$data['numfiche']."'><img src='logo/non.png' alt='non' title='non' width='25' height='25' border='0'></a>";
										echo " 	</td>";
									echo " 	</tr> ";
							}
						}
?>
</table>
<br/>
<table align='center' >
	<tr>
		<td bgcolor='#FF8080' >
	       <?php echo $msg1;?>
		</td>
	</tr>
</table>