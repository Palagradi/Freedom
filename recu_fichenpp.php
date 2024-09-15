<?php
	//session_start(); 
	include 'config.php';
	include 'connexion.php';	
	include 'chiffre_to_lettre.php'; 

?>
<html>
	<head>	<link rel="Stylesheet" type="text/css" media="screen, print" href='style.css' /> 
	<style type="text/css">
		@media print { .noprt {display:none} }
	</style>
	</head>
		<body bgcolor='#FFDAB9'>
		<img src='logo/im10.jpg' width='80' id="button-imprimer" class="noprt" style='margin-left:600px;'> 
		<?php
		
			echo "<table align='center' border='1' style='background-color:#E3EEFB;'> 
			<tr>
				<td>
					<table align='center' >
						<tr>
							<td width=''><font size='4' align='center'>ARCHEVECHE DE COTONOU</font > 
							<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CODIAM </td>
						    <td align='right'> Cotonou le, ".date('d/m/Y')." </td>
						</tr>
						<tr>
							<td align='center'> <img src='".$logo."' width='50px' height='50px'></td>
						</tr>
						<tr>
							<td align='center' colspan='2'><font size='4'> Reçu N°: <i>";
									$reqsel=mysqli_query($con,"SELECT * FROM configuration_facture");
										while($data=mysqli_fetch_array($reqsel))
											{  $num_fact=$data['num_fact'];
											}
								if(($num_fact>=0)&&($num_fact<=9))	echo "0000".$num_fact."/".substr(date('Y'),2,2);
								if(($num_fact>=10)&&($num_fact <=99))	echo "000".$num_fact."/".substr(date('Y'),2,2);
								if(($num_fact>=100)&&($num_fact<=999))	echo "00".$num_fact."/".substr(date('Y'),2,2);
								if(($num_fact>=1000)&&($num_fact<=1999)) echo "0".$num_fact."/".substr(date('Y'),2,2);	
								if($num_fact>1999)	echo $num_recu=$num_fact."/".substr(date('Y'),2,2);											
						
					   echo "</i></font></td>
						</tr>
						<tr>
							<td colspan='2' > <font size='4'>Client:</font>".$_SESSION['cli']." </td>
						</tr>
						<tr>
							<td> <u>Objet</u> : Hébergement </td>
							<td align='right'>Période du : ";
							$heure=(date('H')); $minuite=(date('i'));
							if(($heure>=05))
								 $date=date('d/m/Y');
							else
								 $date=date("d/m/Y", mktime(0,0,0,date("m"),date("d")-1,date("Y")));
								 
							 $date=date("d/m/Y", mktime(0,0,0,date("m"),date("d")+$_SESSION['pre'],date("Y"))); 
								 echo $date;
							echo "au ";
					
									{	$d=date("d/m/Y", mktime(0,0,0,date("m"),date("d")+$_SESSION['npp']+$_SESSION['pre'],date("Y")));
										if(($heure>=05))
											$d;
										else
											$d=date("d/m/Y", mktime(0,0,0,date("m"),date("d")+$_SESSION['npp']+$_SESSION['pre']-1,date("Y")));
									
									echo $d;
									}

							echo "</td>
						</tr>
						<tr>
							<td colspan='2' align='center'>
								<table border='1' align='center' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>
									<tr> 
										<td> Désignation</td>
										<td align='center'> Tarif </td>
										<td align='center'> Nuitée </td> 
										<td align='right'> Montant </td>
									</tr>
									<tr > 
										<td> Chambre";
								   $query_Recordset1 = "SELECT nomch FROM chambre WHERE numch LIKE '".$_SESSION['numch']."'";
								   $Recordset1 = mysqli_query($con,$query_Recordset1) or die(mysqli_error($con));
								   $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
									
									
									echo $row_Recordset1['nomch'];echo'&nbsp;';echo $_SESSION['tch'];echo'     ';  echo"("; echo($_SESSION['occup']);echo")</td>
										<td align='center'> ".$_SESSION['tarif']."  </td>
										<td align='center'> "; echo (int)$_SESSION['npp']." </td> 
										<td align='right' > ". $_SESSION['tarif']*$_SESSION['npp']."  </td>
									</tr>
									
									<tr>
										<td> Taxe sur Nuitée </td>
										<td colspan='3' align='right'>". round($_SESSION['taxe1'],4)." </td>
									</tr>
									<tr>
										<td>TVA "; echo "18"; echo "%</td>
										<td colspan='3' align='right'>".round($_SESSION['tva1'],4)." </td>
									</tr>
									<tr>
										<td> Montant TTC</td>
										<td  colspan='3' align='right'> ".$var=round($_SESSION['taxe1']+round($_SESSION['tva1'],4)+$_SESSION['tarif']*$_SESSION['npp'])."</td>
									</tr>
									<tr>
										<td> Somme Payée</td>
										<td colspan='3' align='right'>". $_SESSION['somme']."</td>
									</tr>
									<tr>";
									$date_du_jour= date('d/m/Y');
									 $query_Recordset1 = "SELECT ($date_du_jour - datarriv) AS difference FROM fiche1 WHERE $date_du_jour > datarriv AND numfiche = '".$_SESSION['num']."'";
									$Recordset1 = mysqli_query($con,$query_Recordset1) or die(mysqli_error($con));
									$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
									$difference=$row_Recordset1['difference'];
									$dif = date('d', strtotime($difference));
									$num_Row=mysqli_num_rows($Recordset1);
									
								echo "</tr></b>
								</table>
							</td>
						</tr>
						<tr> 
							<td colspan='2'><font size='3'>Arreté le présent reçu à la somme de:
							<B>"; echo $p=chiffre_en_lettre($_SESSION['somme'], $devise1='francs CFA', $devise2=''); echo"</B>
							</font>  </td>
						</tr>";

						include ('footer_receipt.php');
						
					echo "</table>
				</td>
			</tr>
		</table>";
		
		echo "<table align='center' border='0' style='background-color:#FFDAB9;'> 
			<tr>
				<td><a href='recette2.php?agent=1' ><img src='logo/b_home.png' title='Accueil' class='noprt' alt='Menu Principal' width='20' height='20' border='0'></a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=''><img src='logo/im10.jpg' width='80' id='button-imprimer' class='noprt' title='Imprimer'  style='clear:both;'></a>
				</td>
			</tr>
		</table>";	
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
$_SESSION['pre']=''; 
$_SESSION['npp']='';
$_SESSION['taxe1']='';
$_SESSION['tva1']='';
$_SESSION['somme']='';
if($typech=="V")
	$typech=utf8_decode("Ventillée");
else
	$typech=utf8_decode("Climatisée");
$recu=substr($num_recu, 0, -3);$heure=date('H:i:s');
$tu=mysqli_query("INSERT INTO reedition_facture VALUES ('".date('Y-m-d')."','$heure','".$_SESSION['login']."','$recu','$num_recu','".addslashes($_SESSION['cli'])."','Hebergement','$du','$au','$taxe','$tva','$var','".$_SESSION['remise']."','".$_SESSION['somme']."')");
$tu=mysqli_query("INSERT INTO reeditionfacture2 VALUES ('$recu','".$_SESSION['num']."','Chambre $nomch','$typech','".$_SESSION['occup']."','".$_SESSION['tarif']."','".$_SESSION['np']."','".$_SESSION['tarif']*$_SESSION['np']."')");
?>