<?php
	session_start(); 
	//convertion de chiffre en lettre 
		include 'connexion.php'; include 'configuration.php'; 
		include 'chiffre_to_lettre.php'; 		

	$s=mysql_query("SELECT * FROM fiche1, compte,client WHERE fiche1.numfiche=compte.numfiche and client.numcli=fiche1.numcli_1 and fiche1.numfiche='".$_SESSION['numfich']."'");
	//echo ("SELECT * FROM fiche1, compte,client WHERE fiche1.numfiche=comptefiche.numfiche and client.numcli=fiche1.numcli and numfiche='".$_SESSION['numfich']."'");
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
	<head>	<link rel="Stylesheet" type="text/css" media="screen, print" href='style.css' /> 
	<style type="text/css">
		@media print { .noprt {display:none} }
	</style>
	</head>
		<body bgcolor='#FFDAB9'>
		<table align='center' border='1' style="background-color:#E3EEFB;border-radius:10px;"> 
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
							<td align='right'> </td>
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
							<td colspan='2' > <font size='5'>Client:</font> <?php echo $_SESSION['nomclient'] ;?> </td>
						</tr>
						<tr>
							<td> <u>Objet</u>: Hébergement </td>
							<td align='right'> Période du : <?php 
					$s=mysql_query("SELECT * FROM fiche1, compte WHERE fiche1.numfiche=compte.numfiche and fiche1.numfiche='".$_SESSION['edit2']."'");
			        $ret1=mysql_fetch_array($s);
					$n=(strtotime(date('Y-m-d'))-strtotime($ret1['datarriv']))/86400;
					$dat=(date('H')+1); 
					settype($dat,"integer");
					if ($dat<12){$n=$n;}else {$n= $n+1;}
					if ($n==0){$n= $n+1;}
								$jr=$ret1['np']-1;
								$fin1=substr($ret1['datarriv'],0,4);$fin2=substr($ret1['datarriv'],5,2);$fin3=substr($ret1['datarriv'],8,2);
								//$fin_3=date("d/m/Y", mktime(0, 0, 0, date($fin2 )  , date($fin3), date($fin1)));
								//$fin4=substr($fin_3,8,2).'/'.substr($fin_3,5,2).'/'.substr($fin_3,0,4);
			$query_Recordset1 = "SELECT max(reedition_facture.au) AS au FROM reeditionfacture2,reedition_facture WHERE reeditionfacture2.numrecu=reedition_facture.numrecu AND reeditionfacture2.numfiche='".$_SESSION['edit2']."'";
			$Recordset_2 = mysql_query($query_Recordset1);
			$result=mysql_fetch_array($Recordset_2);$au=$result['au'];
							if(!empty($au))
								{	$fin4=substr($au,0,2);$fin5=substr($au,3,2);$fin6=substr($au,6,4);
									$au=date("d/m/Y", mktime(0, 0, 0, date($fin5 ) , date($fin4)+1, date($fin6)));
									echo $du=$au;
								}
							else 
									echo $du=$fin3."/".$fin2."/".$fin1;
							?>  au 
							<?php 
							    //$date1=substr($ret1['datarriv'],0,4); $date2=substr($ret1['datarriv'],5,2); $date3=substr($ret1['datarriv'],8,2);
								$fin7=substr($du,0,2);$fin8=substr($du,3,2);$fin9=substr($du,6,4);
							echo $d=date("d/m/Y", mktime(0,0,0,date($fin8),date($fin7)+$_SESSION['nuite'],date($fin9)));
							?></td>
						</tr>
						<tr>
							<td colspan='2' align='center'>
								<table border='1' align='center' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>
									<tr> 
										<td> Désignation</td>
										<td align='center'> Tarif </td>
										<td align='center'> Nuite </td> 
										<td align='right'> Montant </td>
									</tr>
									<tr > 
										<td> Chambre <?php echo ($_SESSION['nomch']);echo' ';echo' '; echo ($_SESSION['tch']);echo' ';echo'('; echo ($_SESSION['occup']); echo')';?></td>
										<td align='center'> <?php echo $_SESSION['tarif1'];?>  </td>
										<td align='center'> <?php echo  $_SESSION['nuite'];?>  </td> 
										<td align='right'> <?php echo $_SESSION['tarif1']*$_SESSION['nuite'];?>  </td>
									</tr>
									
									<tr>
										<td> Taxe sur Nuité </td>
										<td colspan='3' align='right'><?php echo $_SESSION['nuite']*$_SESSION['ttax'];?></td>
									</tr>
									<tr>
										<td> TVA <?php echo 18;?> %</td>
										<td colspan='3' align='right'><?php echo $tva=round($_SESSION['tarif1']*$_SESSION['nuite']*0.18,4);?></td>
									</tr>
									<tr>
										<td> Montant TTC</td>
										<td  colspan='3' align='right'> <?php echo ($_SESSION['nuite']*$_SESSION['ttc_fixe']);?></td>
									</tr>
									<tr>
										<td> Somme Payée</td>
										<td colspan='3' align='right'><?php echo $_SESSION['somme_paye'];?> </td>
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
							<td colspan='2'><font size='3'>Arreté le présent reçu à la somme de:
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
							<td colspan='2' align="center"> <font size='2'>01 BP 429 TEL 21 30 37 27 E-mail: codiamsa@gmail.com Compte Bancaire B.O.A N° 09784420021</font></td>
						</tr>
						<tr>
							<td colspan='2' align="center"><font size='2'>N° IFU 3201300800616 CODIAM HOTEL SARL - REPUBLIQUE DU BENIN</font></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
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
		<table align='center' border='1' style="background-color:#E3EEFB;border-radius:10px;"> 
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
							<td align='right'> </td>
						</tr>
						<tr>
							<td align='center' colspan='2'><font size='4'> Reçu: <i><?php 
							$reqsel=mysql_query("SELECT * FROM configuration_facture");
							while($data=mysql_fetch_array($reqsel))
								{  $num_fact=$data['num_fact'];
								}
							if(($num_fact>=0)&&($num_fact<=9))
									echo "0000".$num_fact."/".substr(date('Y'),2,2);
							if(($num_fact>=10)&&($num_fact <=99))
									echo "000".$num_fact."/".substr(date('Y'),2,2);
							if(($num_fact>=100)&&($num_fact<=999))
									echo "00".$num_fact."/".substr(date('Y'),2,2);
							if(($num_fact>=1000)&&($num_fact<=1999))
									echo "0".$num_fact."/".substr(date('Y'),2,2);
							if($num_fact>1999)
									echo $num_recu=$num_fact."/".substr(date('Y'),2,2);									
						?> </i></font></td>
						</tr>
						<tr>
							<td colspan='2' > <font size='5'>Client:</font> <?php echo $_SESSION['nomclient'] ;?> </td>
						</tr>
						<tr>
							<td> <u>Objet</u>: Hébergement </td>
							<td align='right'>Période du : <?php 
					$s=mysql_query("SELECT * FROM fiche1, compte WHERE fiche1.numfiche=compte.numfiche and fiche1.numfiche='".$_SESSION['edit2']."'");
			        $ret1=mysql_fetch_array($s);
					$n=(strtotime(date('Y-m-d'))-strtotime($ret1['datarriv']))/86400;
					$dat=(date('H')+1); 
					settype($dat,"integer");
					if ($dat<12){$n=$n;}else {$n= $n+1;}
					if ($n==0){$n= $n+1;}
								$jr=$ret1['np']-1;
								$fin1=substr($_SESSION['datarriv'],0,4);$fin2=substr($_SESSION['datarriv'],5,2);$fin3=substr($_SESSION['datarriv'],8,2);
								$fin_3=date("d/m/Y", mktime(0, 0, 0, date($fin2 )  , date($fin3)+$jr, date($fin1)));
								$fin4=substr($fin_3,8,2).'/'.substr($fin_3,5,2).'/'.substr($fin_3,0,4);//echo $fin_3;
			$query_Recordset1 = "SELECT max(reedition_facture.au) AS au FROM reeditionfacture2,reedition_facture WHERE reeditionfacture2.numrecu=reedition_facture.numrecu AND reeditionfacture2.numfiche='".$_SESSION['edit2']."'";
			$Recordset_2 = mysql_query($query_Recordset1);
			$result=mysql_fetch_array($Recordset_2);$au=$result['au'];

								echo $du;
							?>  au 
							<?php 
								echo $d; 
							?></td>
						</tr>
						<tr>
							<td colspan='2' align='center'>
								<table border='1' align='center' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>
									<tr> 
										<td> Désignation</td>
										<td align='center'> Tarif </td>
										<td align='center'> Nuite </td> 
										<td align='right'> Montant </td>
									</tr>
									<tr > 
										<td> Chambre <?php echo $nomch=$_SESSION['nomch'];echo' ';echo' '; echo ($_SESSION['tch']);echo' ';echo'('; echo ($_SESSION['occup']); echo')';?></td>
										<td align='center'> <?php echo $_SESSION['tarif1'];?>  </td>
										<td align='center'> <?php echo $_SESSION['nuite'];?>  </td> 
										<td align='right'> <?php echo $_SESSION['tarif1']*$_SESSION['nuite'];?>  </td>
									</tr>
									
									<tr>
										<td> Taxe sur Nuité </td>
										<td colspan='3' align='right'><?php echo $taxe=$_SESSION['nuite']*$_SESSION['ttax'];?></td>
									</tr>
									<tr>
										<td> TVA <?php echo 18;?> %</td>
										<td colspan='3' align='right'><?php echo $tva=round($_SESSION['tarif1']*$_SESSION['nuite']*0.18,4);?></td>
									</tr>
									<tr>
										<td> Montant TTC</td>
										<td  colspan='3' align='right'> <?php echo $var=$_SESSION['nuite']*$_SESSION['ttc_fixe'];?></td>
									</tr>
									<tr>
										<td> Somme Payée</td>
										<td colspan='3' align='right'><?php echo $_SESSION['somme_paye'];?> </td>
									</tr>
									<tr>
									 <?php $date_du_jour= date('d/m/Y');
									 $query_Recordset1 = "SELECT ($date_du_jour - datarriv) AS difference FROM fiche1 WHERE $date_du_jour > datarriv AND numfiche = '".$_SESSION['num']."'";
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
							<td colspan='2'><font size='3'>Arreté le présent reçu à la somme de:
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
	$query_Recordset1 = "SELECT reedition_facture.au FROM reeditionfacture2,reedition_facture WHERE reeditionfacture2.numrecu=reedition_facture.numrecu AND reeditionfacture2.numfiche='".$_SESSION['edit2']."'";
	$Recordset_2 = mysql_query($query_Recordset1);
	$result=mysql_fetch_array($Recordset_2);
	$au=$result['au']; if(empty($au)) $au=$_SESSION['date'];
 $recu=substr($num_recu, 0, -3);$heure=date('H:i:s');$type_c=utf8_decode($_SESSION['tch']);
 $tu=mysql_query("INSERT INTO reedition_facture VALUES ('".date('Y-m-d')."','$Heure_actuelle','".$_SESSION['login']."','$num_recu','$num_recu','".addslashes($_SESSION['nomclient'])."','Hebergement','$au','$d','$taxe','$tva','$var','".$_SESSION['remise']."','".$_SESSION['somme_paye']."')");
 $tu=mysql_query("INSERT INTO reeditionfacture2 VALUES ('$num_recu','".$_SESSION['edit2']."','Chambre $nomch','$type_c','".$_SESSION['occup']."','".$_SESSION['tarif1']."','".$_SESSION['nuite']."','".$_SESSION['tarif1']*$_SESSION['nuite']."')");
?>