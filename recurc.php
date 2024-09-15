<?php
include 'menu.php';
	if($_SESSION['update']==1){
	$update=mysqli_query($con,"UPDATE configuration_facture SET num_fact=num_fact+1 ");
	$_SESSION['update']=0;
	}
	include 'chiffre_to_lettre.php'; 
	$reqsel=mysqli_query($con,"SELECT logo FROM autre_configuration");
	$data=mysqli_fetch_assoc($reqsel);
	$logo=$data['logo'];
?>
<html>
	<head>	<link rel="Stylesheet" type="text/css" media="screen, print" href='style.css' /> 
	<style type="text/css">
		@media print { .noprt {display:none} }
		@page {size: portrait; }		
		hr {
		height: none;
		border: none;
		border-top: 2px dashed grey;width:37%;
		}
	</style>
	</head>
	<body bgcolor='#FFDAB9'>

<?php 
	for($i=0;$i<=1;$i++)
	{echo"	<table align='center' border='1' width='575' style='background-color:#E3EEFB;border-radius:10px;font-family:Cambria;'> 
			<tr>
				<td>
					<table align='center' >
						<tr>
							<td width=''><font size='4' align='center'>".$nomHotel."</font ></td>
						    <td align='right'> Cotonou le, ".$Date_actuel." </td>
						</tr>
						<tr>
							<td align='left'> <img src='".$logo."' width='150px' height='75px'></td>
							<td align='right'> </td>
						</tr>				

						<tr>
							<td align='center' colspan='2'><font size='4'> Reçu N°: <i>".$num_recu."											
						</i></font></td>
						</tr>
						<tr>
							<td > <font size='4'><u>Client</u>:&nbsp;</font>"; if(!empty($_SESSION['groupe'])) echo $_SESSION['client']=$_SESSION['groupe']; else  echo $_SESSION['client']=$_SESSION['nom']." ".$_SESSION['prenom'];
						echo "</td><td align='right'> <u>Objet</u>:&nbsp;"; echo $objet="Réservation"; echo "</td>
						</tr>";
						    $ret=mysqli_query($con,'SELECT datarrivch,datdepch FROM reservationch WHERE numresch="'. $_SESSION['numresch'].'"');
							$retS=mysqli_query($con,'SELECT datarrivch,datdepch FROM reservationsal WHERE numresch="'. $_SESSION['numresch'].'"');

							if(mysqli_num_rows($retS)>0)
								{	while ($ret1=mysqli_fetch_object($retS))
									{ $debut=$ret1->datarrivch; $fin=$ret1->datdepch;  	}
									  $debutS=substr($debut,8,2).'/'.substr($debut,5,2).'/'.substr($debut,0,4);
									  $finS=substr($fin,8,2).'/'.substr($fin,5,2).'/'.substr($fin,0,4);
									  echo"<tr> 
									  <td>Réservation de Salle </td> 
									  <td align='right'>  Période du : ".$debutS." au ".	 $finS."</td></tr>";
								}
							if(mysqli_num_rows($ret)>0)
								{	while ($ret1=mysqli_fetch_object($ret))
									{ $debut=$ret1->datarrivch; $fin=$ret1->datdepch;  	}
									  $debut=substr($debut,8,2).'/'.substr($debut,5,2).'/'.substr($debut,0,4);
									  $fin=substr($fin,8,2).'/'.substr($fin,5,2).'/'.substr($fin,0,4);
									  echo"<tr>
									    <td>Réservation de Chambre </td> 
										<td align='right'>  Période du : ".$debut." au ".	 $fin."</td><tr>";
								}
							//{echo "<td> Objet:&nbsp;"; echo $objet="Réservation de Chambre-Salle"; echo "</td> ";

                           // {echo "<td> Objet:&nbsp;"; echo $objet="Réservation de chambre"; echo"</td> ";

                           // else {echo "<td> Objet:&nbsp;"; echo $objet="Réservation de salle"; echo "</td> ";
							
							//echo"<td align='right'>  Période du : ".$debut." au ".	 $fin."</td>";
							//}								
							
						echo "<tr>
							<td colspan='2' align='center'>
								<table border='1' align='center' width='100%' cellpadding='0' cellspacing='0' style='border:1px solid;font-family:Cambria;'>
									<tr> 
										<td colspan='2'><span style='font-weight:bold;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Désignation</span></td>
										<td colspan='4'><span style='font-weight:bold;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tarif </span></td>
										<td align='center' colspan='2'><span style='font-weight:bold;'>";
										 if ((!empty($_SESSION['nbch1'])AND(!empty($_SESSION['nbsal1'])))||(!empty($_SESSION['nbch1'])AND(empty($_SESSION['nbsal1']))))
											 echo "Nuitée"; else echo "Nbre de jrs"; echo "</span> </td> 
										<td colspan='2'><span style='font-weight:bold;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Montant</span> </td>
									</tr>";
									
								$ret=mysqli_query($con,'SELECT * FROM reserverch,chambre WHERE chambre.EtatChambre="active" AND reserverch.numch=chambre.numch AND numresch="'. $_SESSION['numresch'].'"');
								while ($ret1=mysqli_fetch_array($ret))
									{   $typech=$ret1['typech'];
										if($typech=='V') $type="Ventillée"; else $type="Climatisée";
										echo " <tr><td colspan='2'>"; echo"&nbsp;"."Chambre"." ".($ret1['nomch']." "."(". $type.")"." ".$ret1[2]  ); echo "</td>";
										echo "<td colspan='4'>"; echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($ret1[3]); echo "</td>"; 
										echo "<td colspan='2' align='center'>"; echo"".($_SESSION['nuite']); echo "</td>";
										echo "<td colspan='2' align='right'>"; echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($ret1['tarifrc']*$_SESSION['nuite']); echo "</td></tr>"; 
									}
									echo"<tr>"; 
										    mysqli_query($con,"SET NAMES 'utf8'");
											$ret=mysqli_query($con,'SELECT * FROM reserversal,salle WHERE salle.numsalle=reserversal.numsalle AND numresch="'. $_SESSION['numresch'].'"');
											while ($ret1=mysqli_fetch_array($ret))
											{   echo " <tr><td colspan='2'>";echo"&nbsp;".""."".($ret1['codesalle']." "."(".$ret1[3].")"); echo "</td>";
											       if($ret1['typeoccuprc']=='reunion')
														$tarif=$ret1['tarifreunion'];
											       else
														$tarif=$ret1['tariffete'];$nuite_payee=$_SESSION['nuiteA'];
													echo "<td colspan='4'>";echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tarif; echo "</td>"; 
													echo "<td colspan='2' align='center'>"; echo "".$nuite_payee."</td>"; 
													echo  "<td align='right' colspan='2'>"; echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($tarif*$_SESSION['nuiteA']); echo "</td>";  
											}
								echo"</tr>
									<tr>
										<td> Montant HT</td>
										<td colspan='10' align='right'>".$_SESSION['mtht']." </td>
									</tr>";
									 if(($_SESSION['nbsal1']=='')AND($_SESSION['nbch1']!=''))
									echo"<tr>
										<td> Taxe sur nuite </td>
										<td colspan='10' align='right'>".$_SESSION['tn']."</td>
									</tr>";
									echo "<tr>
										<td> TVA </td>
										<td colspan='10' align='right'>".$_SESSION['tva']."</td>
									</tr>
									<tr>
										<td> Montant TTC </td>
										<td colspan='10' align='right'>".$_SESSION['mtttc']."</td>
									</tr>
									<tr>
										<td><b> Somme Payée</b></td>
										<td colspan='10' align='right'><b>".$somme=$_SESSION['avc']+$_SESSION['avc_salle']." </b></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr> 
							<td colspan='2'><font size='2'>Arreté le présent Reçu à la somme de:";
								echo "<B>";$p=chiffre_en_lettre(ceil($_SESSION['mtttc']), $devise1='Francs CFA', $devise2=''); echo"</B>";
						echo"</font> </td>
						</tr>";
						include ('footer_receipt.php');
					echo "</table>
				</td>
			</tr>
			

				</td>
			</tr>
			
		</table>";
		if($i==0)
		{echo "<table align='center' border='0' style='background-color:#84CECC;'> 
				<tr>
					<td >
					
					<a href=''><img src='logo/im10.jpg' width='80' id='button-imprimer' class='noprt' title='Imprimer'  style='clear:both;'></a>
					</td>
				</tr>
				</table>";	
				
				echo "<hr/><br/>";
		}
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
 $recu=substr($num_recu, 0, -3);$heure=date('H:i:s'); $remise=isset($_SESSION['remise'])?$_SESSION['remise']:NULL; $somme=isset($_SESSION['somme'])?$_SESSION['somme']:NULL;
 
$ret=mysqli_query($con,'SELECT * FROM reserverch,chambre WHERE EtatChambre="active" AND reserverch.numch=chambre.numch AND numresch="'. $_SESSION['numresch'].'"');
while ($ret1=mysqli_fetch_array($ret))
	{   $typech=$ret1['typech'];
		if($typech=='V') $type="Ventillée"; else $type="Climatisée";
		$nomch=$ret1['nomch']; $_SESSION['occup']=$ret1[2];
		$_SESSION['tarif']=$ret1[3]; 
		$var=$ret1['tarifrc']*$_SESSION['nuite'];
		$tu=mysqli_query($con,"INSERT INTO reeditionfacture2 VALUES ('$num_recu','".$_SESSION['numresch']."','Chambre $nomch','".$type."','".$_SESSION['occup']."','".$_SESSION['tarif']."','".$_SESSION['nuite']."','$var')");
	}
$ret=mysqli_query($con,'SELECT * FROM reserversal,salle WHERE reserversal.numsalle=salle.numsalle AND numresch="'. $_SESSION['numresch'].'"');
while ($ret1=mysqli_fetch_array($ret))
	{   $typeoccuprc=ucfirst($ret1['typeoccuprc']);
		$codesalle=$ret1['codesalle']; $_SESSION['occup']=$ret1[2];
		$_SESSION['tarif']=$ret1['mtrc']; 
		$var=$ret1['tarifrc']*$_SESSION['nuiteA'];
		$tu=mysqli_query($con,"INSERT INTO reeditionfacture2 VALUES ('$num_recu','".$_SESSION['numresch']."','$codesalle','".$typeoccuprc."','','".$_SESSION['tarif']."','".$_SESSION['nuiteA']."','".$tarif."')");
	}
 $tu=mysqli_query($con,"INSERT INTO reedition_facture VALUES ('".date('Y-m-d')."','$heure','".$_SESSION['login']."','$num_recu','$num_recu','".addslashes($_SESSION['client'])."','$objet','$debut','$fin','".$_SESSION['tn']."','".$_SESSION['tva']."','".$_SESSION['mtttc']."','".$remise."','".$somme."')");
?>