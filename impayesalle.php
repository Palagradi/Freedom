<?php
	session_start(); 
	//convertion de chiffre en lettre 
		include 'connexion.php'; 
		include 'chiffre_to_lettre.php'; 		
if($_SESSION['motif']=='tariffete')
	$motif='fête';
if($_SESSION['motif']=='tarifreunion')
	$motif="réunion";
?>
<html>
	<head>
	</head>
	<body>
		<table align='center' border='1' style=""> 
			<tr>
				<td>
					<table align='center' >
						<tr>
							<td width=''><font size='4' align='center'>ARCHEVECHE DE COTONOU</font > <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CODIAM </td>
						    <td align='right'> Cotonou le, <?php echo $date_edition=date('d/m/Y');  ?>  </td>
						</tr>
						<tr>
							<td align='center'> <img src='logo/codi.jpg' width='50px' height='50px'></td>
						</tr>
						<tr>
							<td align='center' colspan='2'><font size='4'> Reçu: <i><?php
								$reqsel=mysql_query("SELECT * FROM configuration_facture");
										while($data=mysql_fetch_array($reqsel))
											{  $num_fact=$data['num_fact'];
											}
							if(($num_fact>=0)&&($num_fact<=9))
									echo $num_recu=$initial_fiche."0000".$num_fact."/".substr(date('Y'),2,2);
							if(($num_fact>=10)&&($num_fact <=99))
									echo $num_recu=$initial_fiche."000".$num_fact."/".substr(date('Y'),2,2);
							if(($num_fact>=100)&&($num_fact<=999))
									echo $num_recu=$initial_fiche."00".$num_fact."/".substr(date('Y'),2,2);
							if(($num_fact>=1000)&&($num_fact<=1999))
									echo $num_recu=$initial_fiche."0".$num_fact."/".substr(date('Y'),2,2);	
								?> </i></font></td>
						</tr>
						<tr>
							<td colspan='2' > <font size='5'>Client:</font> <?php echo $_SESSION['cli'];?> </td>
						</tr>
						<tr>
							<td> Objet : Location </td>
							<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Période du : <?php echo $du=date('d/m/Y'); ?>  au 
							<?php 
								$date1=date('d'); $date2=date('m'); $date3=date('Y');
								echo $date=date("d/m/Y", mktime(0,0,0,date($date2),date($date1)+$_SESSION['np'],date($date3)));
							?></td>
						</tr>
						<tr>
							<td colspan='2' align='center'>
								<table border='1' align='center' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>
									<tr> 
										<td> Désignation</td>
										<td align='center'> Montant HT </td>
										<td align='center'> Nbre de jours </td> 
										<td align='right'> Montant </td>
									</tr>									
										 <?php 												
										mysql_query("SET NAMES 'utf8' ");
										//echo 'SELECT DISTINCT codesalle,recu_salle.tarif AS tarif, sum(recu_salle.tarif) AS somme FROM salle,recu_salle WHERE salle.typesalle=recu_salle.typesalle AND recu_salle.numfiche="'.$_SESSION['num'].'"';
										$res=mysql_query('SELECT DISTINCT codesalle,recu_salle.tarif AS tarif FROM salle,recu_salle WHERE salle.typesalle=recu_salle.typesalle AND recu_salle.numfiche="'.$_SESSION['num'].'"');
										while ($ret=mysql_fetch_array($res)) 
											{	echo" <tr >";
												echo "<td>".$ret['codesalle']."&nbsp;(".$motif.")</td>"; 
												echo "<td align='center'>".$ret['tarif']."</td>";  
												echo "<td align='center'>".$_SESSION['Nuite_sal']."</td>";
												echo "<td align='right'>".$var=round($ret['tarif']* $_SESSION['nbre2'],4)."</td>";
												echo "</tr>";
											}
										?>								
									<tr>
										<td>TVA <?php echo 18;?> %</td>
									 <?php 												
										mysql_query("SET NAMES 'utf8' ");
										$res=mysql_query('SELECT DISTINCT sum(recu_salle.tarif) AS tarif FROM salle,recu_salle WHERE salle.typesalle=recu_salle.typesalle AND recu_salle.numfiche="'.$_SESSION['num'].'"');
										while ($ret=mysql_fetch_array($res)) 
											{	$var2=round($ret['tarif'],4);
												echo"<td colspan='3' align='right'>".$var1=round($ret['tarif']*0.18,4)."</td>";
											}
										?>										
									</tr>
									<tr>
										<td> Montant TTC</td>
										<td  colspan='3' align='right'> <?php echo $var3=(int)round($var1+$var2,4);?>  </td>
									</tr>
									<tr>
										<td> Somme Payée</td>
										<td colspan='3' align='right'><?php echo $_SESSION['somme'];?>  </td>
									</tr>
									<tr>
									 <?php $date_du_jour= date('d/m/Y');
									 $query_Recordset1 = "SELECT ($date_du_jour - datarriv) AS difference FROM fiche1 WHERE $date_du_jour > datarriv AND numfiche = '".$_SESSION['num']."'";
									$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
									$row_Recordset1 = mysql_fetch_assoc($Recordset1);
									$difference=$row_Recordset1['difference'];
									$dif = date('d', strtotime($difference));
									$num_Row=mysql_num_rows($Recordset1);
									?>
									</tr></b>
								</table>
							</td>
						</tr>
						<tr> 
							<td colspan='2'><font size='4'>Arreté le présent reçu à la somme de:
							<?php 
								echo "<B>";$p=chiffre_en_lettre($_SESSION['somme'], $devise1='francs CFA', $devise2=''); echo"</B>";
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
							<td colspan='2' align="center"> <font size='2'>01 BP 429 TEL 21 30 37 27 E-mail: codiamsa@gmail.com Compte Bancaire B.O.A N° 09784420006</font></td>
						</tr>
						<tr>
							<td colspan='2' align="center"><font size='2'>N° IFU 3201300800616 CODIAM HOTEL SARL - REPUBLIQUE DU BENIN</font></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		
<hr style='width:520px;'/>

	</body>
</html>

<?php 
 $recu=substr($num_recu, 0, -3);$heure=date('H:i:s');$datej=date('Y-m-d');
 $tu=mysql_query("INSERT INTO reedition_facture VALUES ('$datej','$heure','".$_SESSION['login']."','$recu','$num_recu','".$_SESSION['cli']."','Location','$du','$date','','$var1','$var3','".$_SESSION['somme']."')");
	mysql_query("SET NAMES 'utf8' ");
	//echo 'SELECT DISTINCT codesalle,recu_salle.tarif AS tarif, sum(recu_salle.tarif) AS somme FROM salle,recu_salle WHERE salle.typesalle=recu_salle.typesalle AND recu_salle.numfiche="'.$_SESSION['num'].'"';
	$res=mysql_query('SELECT DISTINCT codesalle,recu_salle.tarif AS tarif FROM salle,recu_salle WHERE salle.typesalle=recu_salle.typesalle AND recu_salle.numfiche="'.$_SESSION['num'].'"');
	while ($ret=mysql_fetch_array($res)) 
		{	$designation=$ret['codesalle'];
			$tarif=$ret['tarif'];
			$var=round($ret['tarif']* $_SESSION['nbre2'],4);
			echo" <tr >";
			echo "<td>".$designation."&nbsp;(".$motif.")</td>"; 
			echo "<td align='center'>".$tarif."</td>";  
			echo "<td align='center'>".$_SESSION['Nuite_sal']."</td>";
			echo "<td align='right'>".$var."</td>";
			echo "</tr>";
		$tu=mysql_query("INSERT INTO reeditionfacture2 VALUES ('$recu','".$_SESSION['numfiche']."','$Salle $designation','','$motif','".$_SESSION['tarif']."','".$_SESSION['Nuite_sal']."','$var')");
		}
?>