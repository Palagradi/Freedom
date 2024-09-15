<?php
	session_start(); 
	//convertion de chiffre en lettre 
		include 'connexion.php'; 
		include 'chiffre_to_lettre.php'; 		

	$s=mysql_query("SELECT * FROM location, compte1,client WHERE location.numfiche=compte1.numfiche and client.numcli=location.numcli and location.numfiche='".$_SESSION['numfich']."'");
	//echo ("SELECT * FROM location, compte1,client WHERE location.numfiche=compte1fiche.numfiche and client.numcli=location.numcli and numfiche='".$_SESSION['numfich']."'");
	$ez=mysql_fetch_array($s);
	$numcli=$ez['numcli'];
	$nomcli=$ez['nomcli'].' '.$ez['prenomcli'];
	$datearrive=$ez['datarriv'];
	$datsortie=$ez['datsortie'];
	//$due=$ez['due'];
	$mt=(1+$ez['ttva'])*($n*($ez['tarif']+$ez['ttax']));
	//echo $mt; 
	$var1=$ez['somme'];
	//if ($var1<0)
	$var = $ez['somme'] - $ez['due'];
	
?>
<html>
	<head>
	</head>
		<body bgcolor='#FFDAB9'>

			<table align='center' border='1' style="background-color:#E3EEFB;"> 
			<tr>
				<td>
					<table align='center' >
						<tr>
							<td width=''><font size='4' align='center'>ARCHEVECHE DE COTONOU</font > 
							<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CODIAM </td>
						    <td align='right'> Cotonou le, <?php echo date('d/m/Y');  ?>  </td>
						</tr>
						<tr>
							<td align='center'> <img src='logo/codi1.jpg' width='50px' height='50px'></td>
						</tr>
						<tr>
							<td align='center' colspan='2'><font size='4'> Reçu: <i><?php 
							$reqsel=mysql_query("SELECT * FROM configuration_facture");
							while($data=mysql_fetch_array($reqsel))
								{  //$num_fact=$data['num_fact']+1;
								   $num_fact=$data['num_fact'];
								}
							if(($num_fact>=0)&&($num_fact<=9))
									echo $num_recu="0000".$num_fact."/".substr(date('Y'),2,2);
							if(($num_fact>=10)&&($num_fact <=99))
									echo $num_recu="000".$num_fact."/".substr(date('Y'),2,2);
							if(($num_fact>=100)&&($num_fact<=999))
									echo $num_recu="00".$num_fact."/".substr(date('Y'),2,2);
							if(($num_fact>=1000)&&($num_fact<=1999))
									echo $num_recu="0".$num_fact."/".substr(date('Y'),2,2);	
							if($num_fact>1999)
									echo $num_recu=$num_fact."/".substr(date('Y'),2,2);	
								
									$query_Recordset1 = "SELECT codegrpe,nomcli,prenomcli from location,client where location.numcli=client.numcli AND numfiche='".$_SESSION['edit2']."'";
											$Recordset_2 = mysql_query($query_Recordset1);
											$data=mysql_fetch_array($Recordset_2);
											if($data['codegrpe']!='')
												$client=$data['codegrpe'];
											else
												{
												$client=$data['nomcli'].' '.$data['prenomcli'];
												}
						?></i></font></td>
						</tr>
						<tr>
							<td colspan='2' > <font size='5'>Client:</font> <?php echo $client ;?> </td>
						</tr>
						
						
						<tr>
							<td> <u>Objet</u> : Location </td>
							<td align='right'>Période du : <?php
									$query_Recordset1 = "SELECT date,tarif from compte1 where numfiche='".$_SESSION['edit2']."'";
									$Recordset_2 = mysql_query($query_Recordset1);
									$result=mysql_fetch_array($Recordset_2);$au=$result['date'];$tarif=$result['tarif'];
									if($au=='')
										{	$query_Recordset1 = "SELECT datarriv from location where numfiche='".$_SESSION['edit2']."'";
											$Recordset_2 = mysql_query($query_Recordset1);
											$data=mysql_fetch_array($Recordset_2);
											$au=substr($data['datarriv'],8,2).'/'.substr($data['datarriv'],5,2).'/'.substr($data['datarriv'],0,4);
											//echo $du=date('d/m/Y'); 
										}
									//else
										echo $du=$au;
							
									//echo $du=date('d/m/Y'); 							
							?>  au 
							<?php 
								//$date1=date('d'); $date2=date('m'); $date3=date('Y');
								$date1=substr($du,0,2); $date2=substr($du,3,2); $date3=substr($du,6,4);
								$d=date("d/m/Y", mktime(0,0,0,date($date2),date($date3)+$_SESSION['np'],date($date1)));
								echo $date=date("d/m/Y", mktime(0,0,0,date($date2),date($date1)+$_SESSION['np']-1,date($date3)));
							?></td>
						</tr>
						
						<tr>
							<td colspan='2' align='center'>
								<table border='1' align='center' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>
									<tr> 
										<td> Désignation</td>
										<td align='center'> Tarif </td>
										<td align='center'> Nbre de jours </td> 
										<td align='center'> Montant </td>
									</tr>
									<tr > 
										<td >  <?php 
																			
					echo $_SESSION['codesalle']; echo' ';echo' '; echo ($_SESSION['tch']);echo' ';echo''; echo ($_SESSION['occup']); echo'';?></td>
										<td align='center'> <?php echo $_SESSION['tarif1'];?>  </td>
										<td align='center'> <?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$_SESSION['nuite'];?>  </td> 
										<td align='right'> <?php echo round(($tarif*$_SESSION['nuite']),4);?>  </td>
									</tr>
									
									<tr>
										<td> TVA <?php echo 18;?> %</td>
										<td colspan='3' align='right'><?php echo $tva=round($tarif*$_SESSION['nuite']*0.18,4);?></td>
									</tr>
									<tr>
										<td> Montant TTC</td>
										<td  colspan='3' align='right'> <?php echo $montantTTC= round(($_SESSION['nuite']*$_SESSION['ttc_fixe']),4);?></td>
									</tr>
									<tr>
										<td> Somme Payée</td>
										<td colspan='3' align='right'><?php echo $_SESSION['somme_paye'];?> </td>
									</tr>
									<tr>
									 <?php $date_du_jour= date('d/m/Y');
									 $query_Recordset1 = "SELECT ($date_du_jour - datarriv) AS difference FROM location WHERE $date_du_jour > datarriv AND numfiche = '".$_SESSION['num']."'";
									$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
									$row_Recordset1 = mysql_fetch_assoc($Recordset1);
									$difference=$row_Recordset1['difference'];
									$dif = date('d', strtotime($difference));
									$num_Row=mysql_num_rows($Recordset1);
									//echo $dif;
									

									?>

									</tr></b>
								</table>
							</td>
						</tr>
						<tr> 
							<td colspan='2'><font size='4'>Arreté le présent reçu à la somme de:
							<?php 
								echo "<B>";$p=chiffre_en_lettre($_SESSION['somme_paye'], $devise1='francs CFA', $devise2='');  echo"</B>";
							?></font>  </td>
						</tr>
						<tr>
							<td align='right' colspan='2'>Signature,</td>
						</tr>
                        <tr> 
							<td align='right' colspan='2'>&nbsp;</td>
						</tr>


						<tr> 
							<td align='right' colspan='2'>Le Réceptioniste</td>
						</tr>
						<tr>
							<td colspan='2' align="center"> <font size='2'>01 BP 429 TEL 21 30 37 27 / 21 15 37 81 E-mail: codiamsa@gmail.com compte1 Bancaire B.O.A N°</font></td>
						</tr>
						<tr>
							<td colspan='2' align="center"><font size='2'>09784420021 CODIAM HOTEL SARL (ARCHEVECHE DE COTONOU ) REPUBLIQUE DU BENIN</font></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		
		<?php 
		echo "<table align='center' border='0' style='background-color:#FFDAB9;'> 
			<tr>
				<td><a href='loccup.php?sal=1' ><img src='logo/b_home.png' title='Accueil' class='noprt' alt='Menu Principal' width='20' height='20' border='0'></a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=''><img src='logo/im10.jpg' width='80' id='button-imprimer' class='noprt' title='Imprimer'  style='clear:both;'></a>
				</td>
			</tr>
		</table>";	
?>	
		
		<table align='center' border='1' style="background-color:#E3EEFB;"> 
			<tr>
				<td>
					<table align='center' >
						<tr>
							<td width=''><font size='4' align='center'>ARCHEVECHE DE COTONOU</font > 
							<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CODIAM </td>
						    <td align='right'> Cotonou le, <?php echo date('d/m/Y');  ?>  </td>
						</tr>
						<tr>
							<td align='center'> <img src='logo/codi1.jpg' width='50px' height='50px'></td>
						</tr>
						<tr>
							<td align='center' colspan='2'><font size='4'> Reçu: <i><?php 
							$reqsel=mysql_query("SELECT * FROM configuration_facture");
							while($data=mysql_fetch_array($reqsel))
								{  //$num_fact=$data['num_fact']+1;
								   $num_fact=$data['num_fact'];
								}
							if(($num_fact>=0)&&($num_fact<=9))
									echo $num_recu="0000".$num_fact."/".substr(date('Y'),2,2);
							if(($num_fact>=10)&&($num_fact <=99))
									echo $num_recu="000".$num_fact."/".substr(date('Y'),2,2);
							if(($num_fact>=100)&&($num_fact<=999))
									echo $num_recu="00".$num_fact."/".substr(date('Y'),2,2);
							if(($num_fact>=1000)&&($num_fact<=1999))
									echo $num_recu="0".$num_fact."/".substr(date('Y'),2,2);	
							if($num_fact>1999)
									echo $num_recu=$num_fact."/".substr(date('Y'),2,2);	
						?></i></font></td>
						</tr>
						<tr>
							<td colspan='2' > <font size='5'>Client:</font> <?php echo $client ;?> </td>
						</tr>
						
						
						<tr>
							<td> <u>Objet</u> : Location </td>
							<td align='right'>Période du : <?php
									$query_Recordset1 = "SELECT date from compte1 where numfiche='".$_SESSION['edit2']."'";
									$Recordset_2 = mysql_query($query_Recordset1);
									$result=mysql_fetch_array($Recordset_2);$au=$result['date'];
									if($au=='')
										{	$query_Recordset1 = "SELECT datarriv from location where numfiche='".$_SESSION['edit2']."'";
											$Recordset_2 = mysql_query($query_Recordset1);
											$data=mysql_fetch_array($Recordset_2);
											$au=substr($data['datarriv'],8,2).'/'.substr($data['datarriv'],5,2).'/'.substr($data['datarriv'],0,4);
											//echo $du=date('d/m/Y'); 
										}
									//else
										echo $du=$au;
							
									//echo $du=date('d/m/Y'); 							
							?>  au 
							<?php 
								//$date1=date('d'); $date2=date('m'); $date3=date('Y');
								$date1=substr($du,0,2); $date2=substr($du,3,2); $date3=substr($du,6,4);
								$d=date("d/m/Y", mktime(0,0,0,date($date2),date($date3)+$_SESSION['np'],date($date1)));
								echo $date=date("d/m/Y", mktime(0,0,0,date($date2),date($date1)+$_SESSION['np']-1,date($date3)));
							?></td>
						</tr>
						
						<tr>
							<td colspan='2' align='center'>
								<table border='1' align='center' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>
									<tr> 
										<td> Désignation</td>
										<td align='center'> Tarif </td>
										<td align='center'> Nbre de jours </td> 
										<td align='center'> Montant </td>
									</tr>
									<tr > 
										<td >  <?php 
																			
					echo $_SESSION['codesalle']; echo' ';echo' '; echo ($_SESSION['tch']);echo' ';echo''; echo ($_SESSION['occup']); echo'';?></td>
										<td align='center'> <?php echo $_SESSION['tarif1'];?>  </td>
										<td align='center'> <?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$_SESSION['nuite'];?>  </td> 
										<td align='right'> <?php echo round(($tarif*$_SESSION['nuite']),4);?>  </td>
									</tr>
									
									<tr>
										<td> TVA <?php echo 18;?> %</td>
										<td colspan='3' align='right'><?php echo $tva=round($tarif*$_SESSION['nuite']*0.18,4);?></td>
									</tr>
									<tr>
										<td> Montant TTC</td>
										<td  colspan='3' align='right'> <?php echo $montantTTC= round(($_SESSION['nuite']*$_SESSION['ttc_fixe']),4);?></td>
									</tr>
									<tr>
										<td> Somme Payée</td>
										<td colspan='3' align='right'><?php echo $_SESSION['somme_paye'];?> </td>
									</tr>
									<tr>
									 <?php $date_du_jour= date('d/m/Y');
									 $query_Recordset1 = "SELECT ($date_du_jour - datarriv) AS difference FROM location WHERE $date_du_jour > datarriv AND numfiche = '".$_SESSION['num']."'";
									$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
									$row_Recordset1 = mysql_fetch_assoc($Recordset1);
									$difference=$row_Recordset1['difference'];
									$dif = date('d', strtotime($difference));
									$num_Row=mysql_num_rows($Recordset1);
									//echo $dif;
									

									?>

									</tr></b>
								</table>
							</td>
						</tr>
						<tr> 
							<td colspan='2'><font size='4'>Arreté le présent reçu à la somme de:
							<?php 
								echo "<B>";$p=chiffre_en_lettre($_SESSION['somme_paye'], $devise1='francs CFA', $devise2='');  echo"</B>";
							?></font>  </td>
						</tr>
						<tr>
							<td align='right' colspan='2'>Signature,</td>
						</tr>
                        <tr> 
							<td align='right' colspan='2'>&nbsp;</td>
						</tr>


						<tr> 
							<td align='right' colspan='2'>Le Réceptioniste</td>
						</tr>
						<tr>
							<td colspan='2' align="center"> <font size='2'>01 BP 429 TEL 21 30 37 27 / 21 15 37 81 E-mail: codiamsa@gmail.com compte1 Bancaire B.O.A N°</font></td>
						</tr>
						<tr>
							<td colspan='2' align="center"><font size='2'>09784420021 CODIAM HOTEL SARL (ARCHEVECHE DE COTONOU ) REPUBLIQUE DU BENIN</font></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>

<?php 
 $recu=substr($num_recu, 0, -3);$heure=date('H:i:s');$datej=date('Y-m-d');
 //echo "INSERT INTO reedition_facture VALUES ('$datej','$heure','".$_SESSION['login']."','$num_recu','$num_recu','".$_SESSION['nomclient']."','Location','$d','$d2','','".$tva."','".$_SESSION['somme']."','".$_SESSION['somme_paye']."')";
 $tu=mysql_query("INSERT INTO reedition_facture VALUES ('$datej','$heure','".$_SESSION['login']."','$num_recu','$num_recu','".$client."','Location','$d','$d2','','".$_SESSION['tarif1']."','".$montantTTC."','".$_SESSION['somme_paye']."')");
	mysql_query("SET NAMES 'utf8' ");
	//echo 'SELECT DISTINCT codesalle,recu_salle.tarif AS tarif, sum(recu_salle.tarif) AS somme FROM salle,recu_salle WHERE salle.typesalle=recu_salle.typesalle AND recu_salle.numfiche="'.$_SESSION['num'].'"';
	$res=mysql_query('SELECT DISTINCT codesalle,recu_salle.tarif AS tarif FROM salle,recu_salle WHERE salle.typesalle=recu_salle.typesalle AND recu_salle.numfiche="'.$_SESSION['edit2'].'"');
	while ($ret=mysql_fetch_array($res)) 
		{	$designation=$ret['codesalle'];
			$tarif=$ret['tarif'];
			$var=round($ret['tarif'],4);
		$tu=mysql_query("INSERT INTO reeditionfacture2 VALUES ('$num_recu','".$_SESSION['numfiche']."','$designation','','$motif','".$tarif."','".$_SESSION['nuite']."','$var')");
		//echo "INSERT INTO reeditionfacture2 VALUES ('$num_recu','".$_SESSION['numfiche']."','$designation','','$motif','".$tarifT."','".$_SESSION['Nuite_sal']."','$var')";
		}
$s=mysql_query("UPDATE compte1 SET date='$date' WHERE numfiche='".$_SESSION['edit2']."'");
//echo "UPDATE compte1 SET date='$date' WHERE numfiche='".$_SESSION['edit2']."', np=np+'".$_SESSION['nuite']."'";
?>