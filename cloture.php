<?php
     ob_start();
	session_start();

		   if($_SESSION['poste']==cpersonnel)
		include 'menucp.php';
	   	   if($_SESSION['poste']==agent)
		include 'menuprin1.php';
		   if($_SESSION['poste']==directrice)
		include 'menudirec.php';
		  if($_SESSION['poste']==admin)
		include 'admin.php';
		  if($_SESSION['poste']==comptable)
		include_once 'menucomp.php';
		include 'connexion.php';
		include 'chiffre_to_lettre.php';
		$agent=$_GET['agent'];
?>
<html>
	<head>
		<script type="text/javascript" src="date-picker.js"></script>
	</head>
	<body bgcolor='azure'>
		<form  action='' method='post' name=''>
			<table align='center'style='font-size:1.1em;'>
				<tr>
					<td style='color:#DA4E39;'> <center> <font color='green' size='6' >TABLEAU RECAPITULATIF DES OPERATIONS EFFECTUEES</font></center></td>
				</tr>
			</table> <br/>
			<table align='center'>
		<?php
/* 		echo "SELECT max(num_cloture) AS maximum1 FROM cloture WHERE  agent='".$_SESSION['login']."'";
		$res=mysql_query("SELECT max(num_cloture) AS maximum1 FROM cloture WHERE  agent='".$_SESSION['login']."'");
			while ($ret=mysql_fetch_array($res))
				{   $maximum1=$ret['maximum1'];} if($maximum1=="")  */ $maximum1=0;

			$res=mysql_query("SELECT max(num_encaisse) AS maximum2 FROM encaissement WHERE  agenten='".$_SESSION['login']."' AND num_encaisse> '$maximum1'");
			while ($ret=mysql_fetch_array($res))
				{   $maximum2=$ret['maximum2'];} if($maximum2=="")  $maximum2=0;
		echo "<input type='hidden' name='maximum' value='".$maximum2."' />";

			$date_reference='2015-07-15';
		$res=mysql_query("SELECT max(num_encaisse) AS maximum FROM encaissement WHERE datencaiss>='$date_reference' and encaissement.agenten='".$_SESSION['login']."'");
			while ($ret=mysql_fetch_array($res))
				{  $maximum=$ret['maximum'];}

	if (isset($_POST['RENDRE'])&& $_POST['RENDRE']=='RENDRE COMPTE')
	{	$date=date('Y-m-d'); $heure=date('H:i:s');$etat=1;
	    $sql=mysql_query("update cloture SET encaisseur='".$_POST['edit6']."' ,num_cloture ='".$_POST['maximum']."' WHERE etat=1 AND agent='".$_SESSION['login']."'");
		//echo "update cloture SET encaisseur='".$_POST['edit6']."' WHERE etat=1 ";
		$msg="<tr> <td style='font-weight:bold;font-size:1.1em;'> L'encaissement est en attente auprès de la/du <span style='color:red;'> ".$encaisseur."</span>.Rapprochez-vous de lui pour remettre le montant.</td></tr>";
	}
		$res=mysql_query("SELECT * FROM cloture WHERE date_cloture='".date('Y-m-d')."' AND agent='".$_SESSION['login']."' AND etat=1");
		$nbre=mysql_num_rows($res);
		while ($ret=mysql_fetch_array($res))
		{	$encaisseur =$ret['encaisseur'];
			$etat=$ret['etat'];
		}

		if($nbre>0)
			{if(!empty($encaisseur))
				{$msg="<td style='font-weight:bold;font-size:1.1em;'> L'encaissement est en attente auprès de la/du <span style='color:red;'> ".$encaisseur."</span>. Rapprochez-vous de lui pour remettre le montant.</td></tr>";
					if($msg!="")
						echo $msg;
				}
			else{
				//echo"<tr> <td style='font-weight:bold;'>Vous avez déjà clôturé votre point de caisse. Mais la somme  n'est encore perçu pas aucune autorité habilleté.</td></tr>";
				echo "<tr>
									<td><b>Sélectionnez une personne à qui vous voulez rendre compte ou passer la main : </b>
									<select name='edit6' id='edit6'  style='width:150px;' >
											<option value='".$codegrpe."'>".$codegrpe."</option>";
												mysql_query("SET NAMES 'utf8' ");
													$res=mysql_query('SELECT poste AS poste,login AS login FROM utilisateur WHERE poste NOT IN ("agent","admin")
													UNION
													SELECT nom AS poste,login AS login  FROM utilisateur WHERE poste LIKE "agent"');
													while ($ret=mysql_fetch_array($res))
														{	$poste=ucfirst($ret['poste']);
															if($ret['poste']=="cpersonnel")
															$poste="Chef personnel";
															echo '<option value="'.$poste.'">';
															echo $poste;
															echo '</option>' ;
														}
				echo "</select>
									<input type='submit' name='RENDRE' id='' value='RENDRE COMPTE' style='border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;'"; echo 'onclick="if(!confirm(\'Voulez-vous vraiment continuer?\')) return false;"'; echo"/><td>
								</tr>";
				}
			}
		else
			echo "</tr>
					<td style='font-style:italic;'>Pendant toute la durée de votre connexion, et tant que vous n'avez pas clôturé votre point de caisse,
					vous pouvez réediter une facture. Ci-dessous<br/> un récapitulatif des recettes effectuées. Une fois, que vous clôturez votre point de caisse en cliquant  sur le bouton Clôturer, allez rendre compte au
					<br/> <span style='color:red;' > Chef personnel; Comptable; Directrice</span>. Assurez-vous par la suite qu'il a reconnu que vous lui avez fait le compte des recettes.
					</td>
				</tr>";
		?>








			<tr>
				<td align='center'>
					<B>
					<B> <?php
				$mt1=0; 	$i=1; $cpteur=1;
				$res=mysql_query("SELECT * FROM encaissement WHERE num_encaisse>'$maximum1' and agenten='".$_SESSION['login']."'");
				while ($ret=mysql_fetch_array($res))
					{			$mt1=$mt1+$ret['ttc_fixe']*$ret['np'].' F CFA';
					}

					echo'<span style=""><br/> Agent:&nbsp;'; echo ucfirst($_SESSION['login']); echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B> TOTAL: &nbsp;&nbsp;</b>'.$mt1.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:  '; echo date('d-m-Y'); ?> </B>
					<hr noshade size=3>
				</td>
			</tr>

		</table>

		<table align="center" width="950" border="0" cellspacing="0" style="margin-top:0px;border-collapse: collapse;font-family:Cambria;">
			<caption style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;"><?php echo "Liste des hébergements, locations et réservations ";?><span style="font-style:italic;font-size:0.6em;color:black;"> (par l'agent connecté le &nbsp;<?php echo $date=date('d-m-Y'); ?>)  </span></caption>
			<tr style=" background-color:black;color:white;font-size:1.2em; padding-bottom:5px;">
				<td style="border-right: 2px solid #ffffff" align="center" >N° FICHE </td>
				<td style="border-right: 2px solid #ffffff" align="center" >Date de l'opération</td>
				<td style="border-right: 2px solid #ffffff" align="center" >Type d'encaissement</td>
				<td style="border-right: 2px solid #ffffff" align="center" >Montant encaissé</td>
			</tr>
					<?php
				$mt=0; 	$i=1; $cpteur=1;
				$res=mysql_query("SELECT * FROM encaissement WHERE agenten='".$_SESSION['login']."'AND ref NOT IN
				(SELECT ref FROM encaissement,fiche2 WHERE datencaiss='".date('Y-m-d')."' and encaissement.agenten='".$_SESSION['login']."' AND encaissement.ref=fiche2.numfiche)
				AND Type_encaisse NOT IN
				('Reservation chambre') ");
						while ($ret=mysql_fetch_array($res))
							{if($cpteur == 1)
								{
									$cpteur = 0;
									$bgcouleur = "#acbfc5";
								}
								else
								{
									$cpteur = 1;
									$bgcouleur = "#dfeef3";
								}
								echo"<tr bgcolor='".$bgcouleur."'>";
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".$ret['ref']; echo '</td>';
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".substr($ret['datencaiss'],8,2).'-'.substr($ret['datencaiss'],5,2).'-'.substr($ret['datencaiss'],0,4)."&nbsp;&nbsp;&nbsp; à &nbsp;&nbsp;&nbsp;".$ret['heure_emission']; echo '</td>';
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".$ret['Type_encaisse']; echo '</td>';
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".$ret['ttc_fixe']*$ret['np']; echo '</td>';
									//}
								echo'</tr>';
								$mt=$mt+$ret['ttc_fixe']*$ret['np'].' F CFA';
							}

						$res=mysql_query("SELECT DISTINCT ref,datencaiss,heure_emission,Type_encaisse,sum(ttc_fixe*np) AS somme FROM encaissement,fiche2 WHERE encaissement.agenten='".$_SESSION['login']."' AND encaissement.ref=fiche2.numfiche  AND num_encaisse>'$maximum1' GROUP BY fiche2.numfiche");
						while ($ret=mysql_fetch_array($res))
							{if($cpteur == 1)
								{
									$cpteur = 0;
									$bgcouleur = "#acbfc5";
								}
								else
								{
									$cpteur = 1;
									$bgcouleur = "#dfeef3";
								}
								echo"<tr bgcolor='".$bgcouleur."'>";
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".$ret['ref']; echo '</td>';
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".substr($ret['datencaiss'],8,2).'-'.substr($ret['datencaiss'],5,2).'-'.substr($ret['datencaiss'],0,4)."&nbsp;&nbsp;&nbsp; à &nbsp;&nbsp;&nbsp;".$ret['heure_emission']; echo '</td>';
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".$ret['Type_encaisse']; echo '</td>';
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".$ret['somme']; echo '</td>';
								echo'</tr>';
								$mt=$mt+$ret['somme'].' F CFA';
							}



						$res=mysql_query("SELECT DISTINCT ref,datencaiss,heure_emission,Type_encaisse,sommen AS sommen FROM encaissement WHERE encaissement.agenten='".$_SESSION['login']."' AND encaissement.Type_encaisse='Reservation chambre'AND num_encaisse>'$maximum1'");
						while ($ret=mysql_fetch_array($res))
							{if($cpteur == 1)
								{
									$cpteur = 0;
									$bgcouleur = "#acbfc5";
								}
								else
								{
									$cpteur = 1;
									$bgcouleur = "#dfeef3";
								}
								echo"<tr bgcolor='".$bgcouleur."'>";
								//for ($i=0;$i<3;$i++)
								//	{
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".$ret['ref']; echo '</td>';
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".substr($ret['datencaiss'],8,2).'-'.substr($ret['datencaiss'],5,2).'-'.substr($ret['datencaiss'],0,4)."&nbsp;&nbsp;&nbsp; à &nbsp;&nbsp;&nbsp;".$ret['heure_emission']; echo '</td>';
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".$ret['Type_encaisse']; echo '</td>';
										echo' <td width="200" align="center"> '; echo "&nbsp;&nbsp;".$ret['sommen']; echo '</td>';
									//}
								echo'</tr>';
								$mt=$mt+$ret['sommen'].' F CFA';
							}
					?>
						<td> </td>
					</table>
				</td>
			</tr>

		<table align='center'>
			<tr>
				<td WIDTH='' ><B><br/>
				Montant total encaissé: &nbsp;&nbsp;</b> <?php echo $mt1; ?> </B>
				 &nbsp;&nbsp;(<?php echo chiffre_en_lettre($mt1, $devise1='CFA', $devise2=''); ?>)

		<?php
		$date_reference='2015-07-15';
		$res=mysql_query("SELECT max(num_encaisse) AS maximum FROM encaissement WHERE datencaiss>='$date_reference' and encaissement.agenten='".$_SESSION['login']."'");
			while ($ret=mysql_fetch_array($res))
				{  $maximum=$ret['maximum'];}
		$res=mysql_query("SELECT * FROM cloture WHERE date_cloture='".date('Y-m-d')."' AND agent='".$_SESSION['login']."' AND etat=1");
		$nbre=mysql_num_rows($res);
		while ($ret=mysql_fetch_array($res))
		{	$encaisseur =$ret['encaisseur'];
		}
		if($nbre<=0)
		{/* $res=mysql_query("SELECT * FROM cloture WHERE num_cloture='$maximum' AND agent='".$_SESSION['login']."' AND etat=3");
			$nbre=mysql_num_rows($res);
			while ($ret=mysql_fetch_array($res))
			{	$encaisseur2 =$ret['encaisseur'];
			} */
		}
		if(($nbre<=0)&&($mt>0))
			{
			echo "&nbsp; &nbsp;<input type='submit' name='CLOTURER' id='' value='CLOTURER' style='border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;'"; echo 'onclick="if(!confirm(\'Voulez-vous vraiment clôturer la caisse?\')) return false;"'; echo"/>";
			}
		else  echo  "&nbsp; &nbsp;<input type='submit' name='CAISSE2' id='' value='CAISSE CLOTUREE' style='border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;'/>";
		echo "</td>
		</tr>";
		if($nbre>0)
			{
			}
		?>
		</table>
	</form>
	<?php
	if (isset($_POST['CLOTURER'])&& $_POST['CLOTURER']=='CLOTURER')
	{	$montant=0;	$date_reference='2015-07-15';
		$res=mysql_query("SELECT * FROM encaissement WHERE agenten='".$_SESSION['login']."' AND num_encaisse>'$maximum1'");
		while ($ret=mysql_fetch_array($res))
		{	$montant=$montant+$ret['ttc_fixe']*$ret['np'];
		}
	$date=date('Y-m-d'); $heure=date('H:i:s');$etat=1;
	$sql=mysql_query("INSERT INTO cloture  VALUES ('$date','$heure','".$_SESSION['login']."','$montant','$etat','','')");
	}

	?>

</html>
