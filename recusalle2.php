<?php
	session_start(); 
	//convertion de chiffre en lettre 
		include 'connexion.php'; include 'configuration.php'; 
		include 'chiffre_to_lettre.php'; 		
if($_SESSION['motif']=='tariffete')
	$motif='fête';
if($_SESSION['motif']=='tarifreunion')
	$motif="réunion";
?>
<html>
	<head>	<link rel="Stylesheet" type="text/css" media="screen, print" href='style.css' /> 
	<style type="text/css">
		@media print { .noprt {display:none} }
	</style>
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
							<td align='center'> <img src='<?php echo $logo; ?>' width='50px' height='50px'></td>
							<td align='right'> <div id="moncercle">Original&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
						</tr>
						<tr>
							<td align='center' colspan='2'><font size='4'> Reçu: <i><?php
								$reqsel=mysql_query("SELECT * FROM configuration_facture");
										while($data=mysql_fetch_array($reqsel))
											{  $num_fact=$data['num_fact'];
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
								?> </i></font></td>
						</tr>
						<tr>
							<td colspan='2' > <font size='5'>Client:</font> <?php echo $_SESSION['nomclient'];?> </td>
						</tr>
						<tr>
							<td> Objet : Location </td>
							<td align='right'> Période du :  <?php 
					$query_Recordset1 = "SELECT reedition_facture.au FROM reeditionfacture2,reedition_facture WHERE reeditionfacture2.numrecu=reedition_facture.numrecu AND reeditionfacture2.numfiche='".$_SESSION['edit2']."'";
					$Recordset_2 = mysql_query($query_Recordset1);
					$result=mysql_fetch_array($Recordset_2);$au=$result['au'];
							if($au=='')
								echo $au=$_SESSION['date'];
							else
								echo $au=$result['au'];
							?>  au 
							<?php 
					$s=mysql_query("SELECT * FROM location, compte1 WHERE location.numfiche=compte1.numfiche and location.numfiche='".$_SESSION['edit2']."'");
			        $ret1=mysql_fetch_array($s);
					$date1=substr($ret1['datarriv'],0,4); $date2=substr($ret1['datarriv'],5,2); $date3=substr($ret1['datarriv'],8,2);
					$d=date("d/m/Y", mktime(0,0,0,date($date2),date($date3)+$_SESSION['np']-1,date($date1)));
					echo $d; 
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
										$res=mysql_query('SELECT DISTINCT codesalle,recu_salle.tarif AS tarif FROM salle,recu_salle WHERE salle.typesalle=recu_salle.typesalle AND recu_salle.numfiche="'.$_SESSION['edit2'].'"');
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
										$res=mysql_query('SELECT DISTINCT sum(recu_salle.tarif) AS tarif FROM salle,recu_salle WHERE salle.typesalle=recu_salle.typesalle AND recu_salle.numfiche="'.$_SESSION['edit2'].'"');
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
									 $query_Recordset1 = "SELECT ($date_du_jour - datarriv) AS difference FROM fiche1 WHERE $date_du_jour > datarriv AND numfiche = '".$_SESSION['edit2']."'";
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
							<td colspan='2' align="center"> <font size='2'>01 BP 429 TEL 21 30 37 27 E-mail: codiamsa@gmail.com Compte Bancaire B.O.A N° 09784420021</font></td>
						</tr>
						<tr>
							<td colspan='2' align="center"><font size='2'>N° IFU 3201300800616 CODIAM HOTEL SARL - REPUBLIQUE DU BENIN</font></td>
						</tr>
					</table>
				</td>
			</tr>
<?php 
		echo "<table align='center' border='0' style='background-color:#FFDAB9;'> 
			<tr>
				<td><a href='recette2.php?agent=1' ><img src='logo/b_home.png' title='Accueil' class='noprt' alt='Menu Principal' width='20' height='20' border='0'></a>
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
						    <td align='right'> Cotonou le, <?php echo $date_edition=date('d/m/Y');  ?>  </td>
						</tr>
						<tr>
							<td align='center'> <img src='<?php echo $logo; ?>' width='50px' height='50px'></td>
							<td align='right'> <div id="moncercle">Souche&nbsp;&nbsp;&nbsp;</div></td>
						</tr>
						
						
						<tr>
							<td align='center' colspan='2'><font size='4'> Reçu: <i><?php
							$reqsel=mysql_query("SELECT * FROM configuration_facture");
							while($data=mysql_fetch_array($reqsel))
								{  $num_fact=$data['num_fact'];
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
									
								?> </i></font></td>
						</tr>
						<tr>
							<td colspan='2' > <font size='5'>Client:</font> <?php echo $_SESSION['nomclient'];?> </td>
						</tr>
						<tr>
							<td> Objet : Location </td>
							<td align='right'>Période du :  <?php 
					$query_Recordset1 = "SELECT reedition_facture.au FROM reeditionfacture2,reedition_facture WHERE reeditionfacture2.numrecu=reedition_facture.numrecu AND reeditionfacture2.numfiche='".$_SESSION['edit2']."'";
					$Recordset_2 = mysql_query($query_Recordset1);
					$result=mysql_fetch_array($Recordset_2);$au=$result['au'];
							if($au=='')
								echo $au=$_SESSION['date'];
							else
								echo $au=$result['au'];
							?>  au 
							<?php 
					$s=mysql_query("SELECT * FROM location, compte1 WHERE location.numfiche=compte1.numfiche and location.numfiche='".$_SESSION['edit2']."'");
			        $ret1=mysql_fetch_array($s);
					$date1=substr($ret1['datarriv'],0,4); $date2=substr($ret1['datarriv'],5,2); $date3=substr($ret1['datarriv'],8,2);
					$d=date("d/m/Y", mktime(0,0,0,date($date2),date($date3)+$_SESSION['np']-1,date($date1)));
					echo $d; 
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
										$res=mysql_query('SELECT DISTINCT codesalle,recu_salle.tarif AS tarif FROM salle,recu_salle WHERE salle.typesalle=recu_salle.typesalle AND recu_salle.numfiche="'.$_SESSION['edit2'].'"');
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
										$res=mysql_query('SELECT DISTINCT sum(recu_salle.tarif) AS tarif FROM salle,recu_salle WHERE salle.typesalle=recu_salle.typesalle AND recu_salle.numfiche="'.$_SESSION['edit2'].'"');
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
									 $query_Recordset1 = "SELECT ($date_du_jour - datarriv) AS difference FROM fiche1 WHERE $date_du_jour > datarriv AND numfiche = '".$_SESSION['edit2']."'";
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
							<td colspan='2' align="center"> <font size='2'>01 BP 429 TEL 21 30 37 27 E-mail: codiamsa@gmail.com Compte Bancaire B.O.A N° 09784420021</font></td>
						</tr>
						<tr>
							<td colspan='2' align="center"><font size='2'>N° IFU 3201300800616 CODIAM HOTEL SARL - REPUBLIQUE DU BENIN</font></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
<script type="text/javascript">
   var bouton = document.getElementById('button-imprimer');
bouton.onclick = function(e) {
  e.preventDefault();
  print();
}
 </script>
	</body>
</html>

<?php 
 $recu=substr($num_recu, 0, -3);$heure=date('H:i:s');$datej=date('Y-m-d');
 $tu=mysql_query("INSERT INTO reedition_facture VALUES ('$datej','$Heure_actuelle','".$_SESSION['login']."','$num_recu','$num_recu','".$_SESSION['nomclient']."','Location','$au','$d','','$var1','$var3','".$_SESSION['remise']."','".$_SESSION['somme']."')");
	mysql_query("SET NAMES 'utf8' ");
	$res=mysql_query('SELECT DISTINCT codesalle,recu_salle.tarif AS tarif FROM salle,recu_salle WHERE salle.typesalle=recu_salle.typesalle AND recu_salle.numfiche="'.$_SESSION['edit2'].'"');
	while ($ret=mysql_fetch_array($res)) 
		{	$designation=$ret['codesalle'];
			$tarif=$ret['tarif'];
			$var=round($ret['tarif']* $_SESSION['nbre2'],4);
			$tu=mysql_query("INSERT INTO reeditionfacture2 VALUES ('$num_recu','".$_SESSION['edit2']."','$designation','','$motif','".$_SESSION['tarif']."','".$_SESSION['Nuite_sal']."','$var')");
		}
?>