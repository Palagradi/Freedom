<?php
	//session_start(); 
	include 'config.php';
	//include 'connexion.php';	
	include 'chiffre_to_lettre.php'; 
	$_SESSION['lien']= $_SERVER['PHP_SELF'];
	
	//echo "SELECT *  FROM payement_loyer,loyer  WHERE loyer.Numero=payement_loyer.Numero AND Etat='paye' AND Loyer.numero='".$_SESSION['numfiche']."' AND  mois_payement='".$_SESSION['mois_payement']."'";
	$reqselP=mysqli_query($con,"SELECT *  FROM payement_loyer,loyer  WHERE loyer.Numero=payement_loyer.Numero AND Etat='paye' AND Loyer.numero='".$_SESSION['numfiche']."' AND  mois_payement='".$_SESSION['mois_payement']."'");
	$rowP=mysqli_fetch_assoc($reqselP);  
	$montant=$rowP['Montant']; $debut_jour=substr($rowP['DatePayement'],0,2);
	$client=$rowP['NomLoc'];
?>
<html>
	<head>	<link rel="Stylesheet" type="text/css" media="screen, print" href='style.css' /> 
	<style type="text/css">
		@media print { .noprt {display:none} }
	</style>
	<script type="text/javascript">

 window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
		window.close();
    }

</script>
	</head>
	<body bgcolor='#FFDAB9'>
<?php 			
$_SESSION['np']=1;
for($i=0;$i<=2;$i++)
	{echo "<table align='center' border='1' width='550' style='background-color:#E3EEFB;border-radius:10px;font-family:Cambria;'> 
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
							<td align='center' colspan='2'><font size='4'> <span style='font-weight:normal;'>Reçu N°:</span> <i><span style='font-weight:normal;'>";
							$reqsel=mysqli_query($con,"SELECT * FROM configuration_facture");
										while($data=mysqli_fetch_array($reqsel))
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
						echo "</span>
					   </i></font></td>
						</tr>
						<tr>
							<td colspan='2' > <font size='4'><span style='font-weight:normal;'><u>Client</u>:</font> <span style='font-weight:normal;'>". $client." </span></td>
						</tr>
						<tr>
							<td><span style='font-weight:normal;'> Objet: Location de salle  </span></td>
							<td align='right'><span style='font-weight:normal;'> Période du : ". 
								 $_SESSION['date'].
							" au ".
							$_SESSION['date2']."</span></td>
						</tr>
						<tr>
							<td colspan='2' align='center'>
								<table border='1' align='center' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>
									<tr> 
										<td> <b>Désignation</b></td>
										<td align='center'> <b>Tarif mensuel</b> </td>
										<td align='center'> <b>Nbre de mois</b> </td> 
										<td align='center'> <b>Montant</b> </td>
									</tr>
									<tr > 
										<td> Salle pour les réligieuses</td>
										<td align='center'> ". $montant." </td>
										<td align='center'> ". $_SESSION['np']." </td> 
										<td align='right' > ". $montant*$_SESSION['np']." </td>
									</tr>";
									if($TvaD==0)  
											{
											}else {
												echo "<tr>
												<td colspan='3' align='right'> TVA
												<td colspan='3' align='right'>". round($_SESSION['tva'],4)."</td>
												</tr>";
											}	
									echo "<tr>
										<td> Montant total</td>
										<td  colspan='3' align='right'> ". $montant."</td>
									</tr>
									<tr>
										<td> Somme Payée</td>
										<td colspan='3' align='right'>". $montant." </td>
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
							<td colspan='2'><font size='3'><span style='font-weight:normal;'>Arreté le présent reçu à la somme de:</span";
						
								echo "<B>";$p=chiffre_en_lettre($_SESSION['montant_ttc'], $devise1='francs CFA', $devise2=''); echo"</B>";
							echo "</font>  </td>
						</tr>"; 
							include ('footer_receipt.php');
					echo "</table>
				</td>
			</tr>
		</table>";
	if($i==0)
		{echo "<table align='center' border='0' style='background-color:#FFDAB9;'> 
				<tr>
					<td><a href='fiche.php?agent=1' ><img src='logo/b_home.png' title='Accueil' class='noprt' alt='Menu Principal' width='20' height='20' border='0'></a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href=''><img src='logo/im10.jpg' width='80' id='button-imprimer' class='noprt' title='Imprimer'  style='clear:both;'></a>
					</td>
				</tr>
				</table>";	
		}
	}		
	?>	
		
<?php 
		echo "<table align='center' border='0' style='background-color:#FFDAB9;'> 
			<tr>
				<td><a  class='info3' href='recette2.php?agent=1' ><img src='logo/b_home.png' title='Accueil' class='noprt' alt='Menu Principal' width='20' height='20' border='0'>
				<span style='font-size:0.8em;'>Accueil </span></a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a  class='info3' href=''><img src='logo/im10.jpg' width='80' id='button-imprimer' class='noprt' title=''  style='clear:both;'>
				<span style='font-size:0.8em;'>Imprimer </span></a>
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
$recu=substr($num_recu, 0, -3);$heure=date('H:i:s');
$tu=mysqli_query($con,"INSERT INTO reedition_facture VALUES ('".date('Y-m-d')."','$Heure_actuelle','".$_SESSION['login']."','$num_recu','$num_recu','Congregation les Filles de Padre Pio','Location de salle','".$_SESSION['date']."','".$_SESSION['date2']."','','$tva','".$_SESSION['montant_ttc']."','".$_SESSION['remise']."','".$_SESSION['montant_ttc']."')");
$tu=mysqli_query($con,"INSERT INTO reeditionfacture2 VALUES ('$num_recu','".$_SESSION['numfiche']."','Salle pour les religieuses','','','".$_SESSION['montant_ht']."','".$_SESSION['np']."','".$_SESSION['montant_ht']*$_SESSION['np']."')");
?>