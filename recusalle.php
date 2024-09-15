<?php
	session_start(); 
	include 'configuration.php';
	include 'connexion.php';	
	include 'chiffre_to_lettre.php';  		
if($_SESSION['motif']=='tariffete')
	$motif='fête';
if($_SESSION['motif']=='tarifreunion')
	$motif="réunion";
$_SESSION['lien']= $_SERVER['PHP_SELF']
?>
<html>
	<head>	<link rel="Stylesheet" type="text/css" media="screen, print" href='style.css' /> 
	<style type="text/css">
		@media print { .noprt {display:none} }
	</style>
	</head>
	<body bgcolor='#FFDAB9'>
	<?php	
	for($i=0;$i<=1;$i++)
	{
	echo "<table align='center' border='1' width='550' style='background-color:#E3EEFB;font-family:Cambria;'> 
			<tr>
				<td>
					<table align='center' >					
						<tr>
							<td width=''><font size='4' align='center'>".$nomHotel."</font ></td>
						    <td align='right'> Cotonou le, ".$Date_actuel." </td>
						</tr>
						<tr>
							<td align='center'> <img src='".$logo."' width='150px' height='75px'></td>
							<td align='right'> </td>
						</tr>
						<tr>
							<td align='center' colspan='2'><font size='4'> Reçu: <i>";
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
								echo " </i></font></td>
						</tr>
						<tr>
							<td colspan='2' > <font size='4'><u>Client</u>:</font> "; if(!empty($_SESSION['codegrpe'])) echo $_SESSION['codegrpe']; echo $_SESSION['cli']; 
							echo "</td>
						</tr>
						<tr>
							<td> Objet : Location </td>
							<td align='right'>Période du : ";
									$query_Recordset1 = "SELECT date from compte1 where numfiche='".$_SESSION['num']."'";
									$Recordset_2 = mysql_query($query_Recordset1);
									$result=mysql_fetch_array($Recordset_2);$au=$result['date'];
									if($au=='')
										echo $du=date('d/m/Y'); 
									else
										echo $du=$au;							
							echo " au ";
						
								//$date1=date('d'); $date2=date('m'); $date3=date('Y');
								$date1=substr($du,0,2); $date2=substr($du,3,2); $date3=substr($du,6,4);
								$d=date("d/m/Y", mktime(0,0,0,date($date2),date($date3)+$_SESSION['np'],date($date1)));
								echo $date=date("d/m/Y", mktime(0,0,0,date($date2),date($date1)+$_SESSION['np'],date($date3)));
							echo "</td>
						</tr>
						<tr>
							<td colspan='2' align='center'>
								<table border='1' align='center' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>
									<tr> 
										<td> Désignation</td>
										<td align='center'> Montant HT </td>
										<td align='center'> Nbre de jours </td> 
										<td align='right'> Montant </td>
									</tr>";												
										mysql_query("SET NAMES 'utf8' ");
										$res=mysql_query('SELECT DISTINCT codesalle,recu_salle.tarif AS tarif FROM salle,recu_salle WHERE salle.typesalle=recu_salle.typesalle AND recu_salle.numfiche="'.$_SESSION['num'].'"');
										while ($ret=mysql_fetch_array($res)) 
											{	echo" <tr >";
												echo "<td>".$ret['codesalle']."&nbsp;(".$motif.")</td>"; 
												echo "<td align='center'>".$ret['tarif']."</td>";  
												echo "<td align='center'>".$_SESSION['Nuite_sal']."</td>";
												echo "<td align='right'>".$var=round($ret['tarif']* $_SESSION['nbre2'],4)."</td>";
												echo "</tr>";
											}						

									if($TvaD==0)  
											{
									}else {
											echo " <tr><td>TVA</td>";
										
										mysql_query("SET NAMES 'utf8' ");
										$res=mysql_query('SELECT DISTINCT sum(recu_salle.tarif) AS tarif FROM salle,recu_salle WHERE salle.typesalle=recu_salle.typesalle AND recu_salle.numfiche="'.$_SESSION['num'].'"');
										while ($ret=mysql_fetch_array($res)) 
											{	$var2=round($ret['tarif'],4);
												echo"<td colspan='3' align='right'>"; if($_SESSION['exhonerer']==1) echo $var1=0; else echo $var1=round($ret['tarif']*0.18,4); echo "</td>";
											}
										echo "</tr>";
									}
											
											
									echo "<tr>
										<td> Montant TTC</td>
										<td  colspan='3' align='right'>"; if(!empty($_SESSION['total_salle'])) echo $var3=$_SESSION['total_salle']; else echo $var3=(int)round($var1+$var2,4); 
									echo "</td>
									</tr>
									<tr>
										<td> Somme Payée</td>
										<td colspan='3' align='right'>". $_SESSION['somme']." </td>
									</tr>
									<tr>";
									  $date_du_jour= date('d/m/Y');
									 $query_Recordset1 = "SELECT ($date_du_jour - datarriv) AS difference FROM fiche1 WHERE $date_du_jour > datarriv AND numfiche = '".$_SESSION['num']."'";
									$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
									$row_Recordset1 = mysql_fetch_assoc($Recordset1);
									$difference=$row_Recordset1['difference'];
									$dif = date('d', strtotime($difference));
									$num_Row=mysql_num_rows($Recordset1);
									echo "
									</tr></b>
								</table>
							</td>
						</tr>
						<tr> 
							<td colspan='2'><font size='3'>Arreté le présent reçu à la somme de:";
							
							 if($_SESSION['exhonerer']==1)
								{echo "<B>";$p=chiffre_en_lettre((int)($_SESSION['total_salle']), $devise1='francs CFA', $devise2=''); echo"</B>";}
							else
								{ echo "<B>";$p=chiffre_en_lettre($_SESSION['somme'], $devise1='francs CFA', $devise2=''); echo"</B>";}
							echo "</font>  </td>
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
							<td colspan='2' align='center'> <font size='2' >"; 
							if(!empty($Apostale)) 
								echo $Apostale."&nbsp;&nbsp;"; 
							if((!empty($telephone1))||(!empty($telephone2))) 
							{ echo "TEL ".$telephone1."/".$telephone2."&nbsp;";}  
						    if(!empty($Email))
								echo "&nbsp;&nbsp;E-mail: ".$Email."&nbsp;&nbsp;";
							if(!empty($NumBancaire))
								echo "Compte Bancaire ".$NumBancaire; 
							if(!empty($NumUFI))
								echo "&nbsp;&nbsp;N° IFU ".$NumUFI."&nbsp;&nbsp;";
						    if(!empty($nomHotel))
						  	  echo $nomHotel; 
						    echo "&nbsp;- REPUBLIQUE DU BENIN";
							echo "</font>
							</td>
						</tr>
					 </table>
				</td>
			</tr>
		</table>";
		
	if($i==0)
			{ echo "<table align='center' border='0' style='background-color:#FFDAB9;'> 
			<tr>
				<td><a href='fiche_1.php?agent=1' ><img src='logo/b_home.png' title='Accueil' class='noprt' alt='Menu Principal' width='20' height='20' border='0'></a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=''><img src='logo/im10.jpg' width='80' id='button-imprimer' class='noprt' title='Imprimer'  style='clear:both;'></a>
				</td>
			</tr>
			</table>";}	
	}			
?>
		
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
 $tu=mysql_query("INSERT INTO reedition_facture VALUES ('$datej','$Heure_actuelle','".$_SESSION['login']."','$num_recu','$num_recu','".$_SESSION['cli']."','Location','$du','$date','','$var1','$var3','".$_SESSION['remise']."','".$_SESSION['somme']."')");
	mysql_query("SET NAMES 'utf8' ");
	//echo 'SELECT DISTINCT codesalle,recu_salle.tarif AS tarif, sum(recu_salle.tarif) AS somme FROM salle,recu_salle WHERE salle.typesalle=recu_salle.typesalle AND recu_salle.numfiche="'.$_SESSION['num'].'"';
	$res=mysql_query('SELECT DISTINCT codesalle,recu_salle.tarif AS tarif FROM salle,recu_salle WHERE salle.typesalle=recu_salle.typesalle AND recu_salle.numfiche="'.$_SESSION['num'].'"');
	while ($ret=mysql_fetch_array($res)) 
		{	$designation=$ret['codesalle'];
			$tarif=$ret['tarif'];
			$var=round($ret['tarif']* $_SESSION['nbre2'],4);
		$tu=mysql_query("INSERT INTO reeditionfacture2 VALUES ('$num_recu','".$_SESSION['numfiche']."','$designation','','$motif','".$tarif."','".$_SESSION['Nuite_sal']."','$var')");
		}
$s=mysql_query("UPDATE compte1 SET date='$date' WHERE numfiche='".$_SESSION['num']."'");
?>