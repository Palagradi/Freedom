<?php
	session_start(); 
	//convertion de chiffre en lettre 
		include 'connexion.php'; 
		include 'chiffre_to_lettre.php'; 
		$_SESSION['nbre_produit']=0;

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
							<td width=''><font size='4' align='center'>ARCHEVECHE DE COTONOU</font > <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CODIAM </td>
						    <td align='right'> Cotonou le, <?php echo date('d/m/Y');  ?>  </td>
						</tr>
						<tr>
							<td align='center'> <img src='logo/codi.jpg' width='50px' height='50px'></td>
						</tr>
						<tr>
							<td align='center' colspan='2'><font size='4'> Affectation N°: <i><?php 
							mysql_query("SET NAMES 'utf8'");	
								$reqsel=mysql_query("SELECT * FROM configuration_facture");
									while($data=mysql_fetch_array($reqsel))
										{  $num_afact=$data['num_afact'];
										}
								if(($num_afact>=0)&&($num_afact<=9))
										echo $initial_fiche."0000".$num_afact."/".substr(date('Y'),2,2);
								if(($num_afact>=10)&&($num_afact <=99))
										echo $initial_fiche."000".$num_afact."/".substr(date('Y'),2,2);
								if(($num_afact>=100)&&($num_afact<=999))
										echo $initial_fiche."00".$num_afact."/".substr(date('Y'),2,2);
								if(($num_afact>=1000)&&($num_afact<=1999))
										echo $initial_fiche."0".$num_afact."/".substr(date('Y'),2,2);											
						?> 
					   </i></font></td>
						</tr>
		
						<tr>
							<td> <u>Objet</u> : Affectation de produit </td>
							<td align='right'> <u>Service bénéficiaire</u> : <?php echo ucfirst($_SESSION['service']); ?></td>
						</tr>
						<tr>
							<td colspan='2' align='center'>
								<table border='1' align='center' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>
									<tr> 
										<td align='center'> <B>Référence</B> </td>
										<td align='center'> <B>Désignation</B></td>
										<td align='center'> <B>Quantité</B> </td>
									</tr>
									<?php 
								   $query_Recordset1 = mysql_query("SELECT distinct reference,designation,qte FROM produit_tempon");
									while($data=mysql_fetch_array($query_Recordset1))
										{echo "<tr > 
											<td align='center'>".$data['reference']."</td>
											<td align='center'>".$data['designation']."</td>
											<td align='center'>".$data['qte']."</td>
											</tr>";
										}
									?>
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
							<td align='center' colspan='2'>Signature,</td>
						</tr>
                        <tr> 
							<td align='right' colspan='2'>&nbsp;</td>
						</tr>
						 <tr> 
							<td align='right' colspan='2'>&nbsp;</td>
						</tr>

						<tr> 
							<td align='' colspan=''>Le représentant du service</td>
							<td align='right' colspan=''>L'affecteur des produits</td>
						</tr>
						 <tr> 
							<td align='right' colspan='2'>&nbsp;</td>
						</tr>
												 <tr> 
							<td align='right' colspan='2'>&nbsp;</td>
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
				<td><a href='affectation.php' ><img src='logo/b_home.png' title='Accueil' class='noprt' alt='Menu Principal' width='20' height='20' border='0'></a>
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
							<td width=''><font size='4' align='center'>ARCHEVECHE DE COTONOU</font > <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CODIAM </td>
						    <td align='right'> Cotonou le, <?php echo date('d/m/Y');  ?>  </td>
						</tr>
						<tr>
							<td align='center'> <img src='logo/codi.jpg' width='50px' height='50px'></td>
						</tr>
						<tr>
							<td align='center' colspan='2'><font size='4'> Affectation N°: <i><?php 
								$reqsel=mysql_query("SELECT * FROM configuration_facture");
									while($data=mysql_fetch_array($reqsel))
										{  $num_afact=$data['num_afact'];
										}
								if(($num_afact>=0)&&($num_afact<=9))
										echo $initial_fiche."0000".$num_afact."/".substr(date('Y'),2,2);
								if(($num_afact>=10)&&($num_afact <=99))
										echo $initial_fiche."000".$num_afact."/".substr(date('Y'),2,2);
								if(($num_afact>=100)&&($num_afact<=999))
										echo $initial_fiche."00".$num_afact."/".substr(date('Y'),2,2);
								if(($num_afact>=1000)&&($num_afact<=1999))
										echo $initial_fiche."0".$num_afact."/".substr(date('Y'),2,2);											
						?> 
					   </i></font></td>
						</tr>
		
						<tr>
							<td> <u>Objet</u> : Affectation de produit </td>
							<td align='right'> <u>Service bénéficiaire</u> : <?php echo ucfirst($_SESSION['service']); ?></td>
						</tr>
						<tr>
							<td colspan='2' align='center'>
								<table border='1' align='center' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>
									<tr> 
										<td align='center'> <B>Référence</B> </td>
										<td align='center'> <B>Désignation</B></td>
										<td align='center'> <B>Quantité</B> </td>
									</tr>
									<?php 
								   $query_Recordset1 = mysql_query("SELECT distinct reference,designation,qte FROM produit_tempon");
									while($data=mysql_fetch_array($query_Recordset1))
										{echo "<tr > 
											<td align='center'>".$data['reference']."</td>
											<td align='center'>".$data['designation']."</td>
											<td align='center'>".$data['qte']."</td>
											</tr>";
										}
									?>
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
							<td align='center' colspan='2'>Signature,</td>
						</tr>
                        <tr> 
							<td align='right' colspan='2'>&nbsp;</td>
						</tr>
						 <tr> 
							<td align='right' colspan='2'>&nbsp;</td>
						</tr>

						<tr> 
							<td align='' colspan=''>Le représentant du service</td>
							<td align='right' colspan=''>L'affecteur des produits</td>
						</tr>
						 <tr> 
							<td align='right' colspan='2'>&nbsp;</td>
						</tr>
												 <tr> 
							<td align='right' colspan='2'>&nbsp;</td>
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
		

	</body>
</html>
<script type="text/javascript">
   var bouton = document.getElementById('button-imprimer');
bouton.onclick = function(e) {
  e.preventDefault();
  print();
}
 </script>
<?php 
//$req=mysql_query("DROP TABLE IF EXISTS produit_tempon");
$req=mysql_query("DELETE FROM produit_tempon");
?>