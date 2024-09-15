<?php
	session_start(); 
		include 'connexion.php'; 
		include 'chiffre_to_lettre.php';
		include 'configuration.php'; 		
	if($_SESSION['update']==1)
		$update=mysql_query("UPDATE configuration_facture SET num_fact=num_fact+1 ");
		unset($_SESSION['update']);
		
$_SESSION['lien']= $_SERVER['PHP_SELF'];
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
	{	echo "<table align='center' border='1' style='background-color:#E3EEFB;border-radius:10px;'> 
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
										{  $num_fact=$data['num_fact'];;
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
						
						echo "</i></font></td>
						</tr>
						<tr>
							<td colspan='2' > <font size='5'>Client:</font> ". $_SESSION['client']." </td>
						</tr>
						<tr>";				
				$s=mysql_query("SELECT * FROM reservationsal,salle,reserversal WHERE salle.numsalle=reservationsal.numsalle AND reservationsal.numresch= reserversal.numresch and reserversal.numresch='".$_SESSION['numresch']."'");
				$nbre=mysql_num_rows($s);							
				if($nbre==0)
					{   $chambre=1;
					 
					}
					else
					{	$s=mysql_query("SELECT * FROM reservationch,reserverch WHERE reservationch.numresch=reserverch.numresch and reserverch.numresch='".$_SESSION['numresch']."'");
						$nbre=mysql_num_rows($s);							
						if($nbre==0)
						$salle=1;
						else
						$chambre_salle=1;
					}					
					
						if($chambre_salle==1)
							{echo "<td> <u>Objet</u>: Réservation de Chambre-Salle </td> ";
                             $ret=mysql_query('SELECT datarrivch,datdepch FROM reservationch WHERE numresch="'. $_SESSION['numresch'].'"');
							 $i=1;}							
                        if($chambre==1)
                            {echo "<td> <u>Objet</u>: Réservation de chambre </td> ";
							$ret=mysql_query('SELECT datarrivch,datdepch FROM reservationch WHERE numresch="'. $_SESSION['numresch'].'"');
							 $i=1;}
                        if($salle==1) {echo "<td> <u>Objet</u>: Réservation de salle </td> ";
							$ret=mysql_query('SELECT datarrivch,datdepch FROM reservationsal WHERE numresch="'. $_SESSION['numresch'].'"');}								

							echo "<td align='right'> Période du : ". $_SESSION['debut']."  au ";
							$jour=substr($_SESSION['debut'],0,2); $mois=substr($_SESSION['debut'],3,2); $ans=substr($_SESSION['debut'],6,4);
					//$_SESSION['fin']=date("d/m/Y", mktime(0, 0, 0,date($mois),date($jour)+$_SESSION['np_sal'],date($ans)));
					echo $_SESSION['fin']; 
							echo "</td>
						</tr>
						<tr>
							<td colspan='2' align='center'>
								<table border='1' align='center' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>
									<tr> 
										<td colspan='2'><span style='font-weight:bold;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Désignation</span></td>
										<td colspan='4'><span style='font-weight:bold;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tarif </span></td>";
										if($chambre==1)
											echo "<td colspan='2' align='center'><span style='font-weight:bold;'> Nuitée</span> </td>"; 
										else
											echo "<td colspan='2' align='center'><span style='font-weight:bold;'> Nbre de jrs</span> </td>"; 
										echo "<td colspan='2'><span style='font-weight:bold;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Montant</span> </td>
									</tr>";
										$s=mysql_query("SELECT DISTINCT chambre.numch,chambre.nomch,chambre.typech,reservationch.nuiterc FROM reservationch,reserverch,chambre WHERE chambre.EtatChambre='active' AND reservationch.numch=chambre.numch AND reservationch.numresch='".$_SESSION['numresch']."'");
											while ($ret1=mysql_fetch_array($s))
											{   $typech=$ret1['typech'];
												$numch=$ret1['numch'];
												if($typech=="V") $type="Ventillée"; else $type="Climatisée";													
												$sql=mysql_query("SELECT DISTINCT reserverch.typeoccuprc,reserverch.tarifrc FROM reserverch WHERE numresch='".$_SESSION['numresch']."' AND numch='$numch'");
												while ($ret2=mysql_fetch_array($sql))
												{	if($ret2['typeoccuprc']=='individuelle') $taxe=1000*$ret1['nuiterc']; else $taxe=2000*$ret1['nuiterc'];
													echo " <tr><td colspan='2'>"; echo"&nbsp;"."Chambre"." ".($ret1['nomch']." "."(".$ret2['typeoccuprc'].")"." ".$type); echo "</td>"; 
													echo "<td colspan='4'>"; echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($ret2['tarifrc']); echo "</td>"; 
													echo "<td colspan='2' align='center'>"; echo"".($ret1['nuiterc']); echo "</td>";$mt_ht_chambre=$ret2['tarifrc']*$ret1['nuiterc'];
													echo "<td align='right' colspan='2'>"; echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($mt_ht_chambre); echo "</td></tr>"; 
												}													
											}
									echo "<tr> ";
										  $somme_ht_salle=0;
										  //ECHO 'SELECT mtrc FROM reserversal WHERE reserversal.numresch="'. $_SESSION['numresch'].'"';
											$ret=mysql_query('SELECT mtrc FROM reserversal WHERE reserversal.numresch="'. $_SESSION['numresch'].'"');
											while ($ret1=mysql_fetch_array($ret))
											{ 	 /*   if($ret1['typeoccuprc']=='reunion')
														 $tarif=$ret1['tarifreunion'];
											       else
														 $tarif=$ret1['tariffete']; */
														 $mtrc=$ret1['mtrc'];
												  // $somme_ht_salle+=$mtrc;	//echo "<BR/>";
											}
											$mt_ht_salle=0;
											mysql_query("SET NAMES 'utf8'");
											$ret=mysql_query('SELECT DISTINCT salle.codesalle,reserversal.typeoccuprc,salle.tariffete,salle.tarifreunion,reserversal.nuite_payee,mtrc,nuiterc FROM reservationsal,reserversal,salle WHERE reservationsal.numresch=reserversal.numresch AND salle.numsalle=reserversal.numsalle AND reserversal.numresch="'. $_SESSION['numresch'].'"');
											while ($ret1=mysql_fetch_array($ret))
											{      	echo " <tr><td colspan='2'>";echo"&nbsp;".""."".($ret1['codesalle']." "."(".$ret1['typeoccuprc'].")"); echo "</td>";
											       $nuite_payee=$ret1['nuite_payee'];$nuiterc=$ret1['nuiterc'];
												   if($ret1['typeoccuprc']=='reunion')
														$tarif=$ret1['tarifreunion'];
											       else
														$tarif=$ret1['tariffete'];
													echo "<td colspan='4'>";echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tarif; echo "</td>"; 
													echo "<td align='center'colspan='2'>"; echo $nuiterc; echo "</td>"; 
													echo "<td align='right'colspan='2'>"; echo $mt_ht_salle1=$tarif*$nuiterc; echo "</td>";  
													$mt_ht_salle+=$mt_ht_salle1;
													//echo  "<td align='right' colspan='2'>"; echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($somme_ht_salle); echo "</td>";  
											}
											
											
											
				$s=mysql_query("SELECT * FROM reservationsal,salle,reserversal WHERE salle.numsalle=reservationsal.numsalle AND reservationsal.numresch= reserversal.numresch and reserversal.numresch='".$_SESSION['numresch']."'");
				$nbre=mysql_num_rows($s);							
				if($nbre==0)
					{	$s=mysql_query("SELECT * FROM reservationch,reserverch WHERE reservationch.numresch=reserverch.numresch and reserverch.numresch='".$_SESSION['numresch']."'");
						while($ez=mysql_fetch_array($s))
						{
						}
						 
					}
					else
					{
					}
					
					echo "</tr>
							<tr>
								<td> Montant HT</td>
								<td colspan='10' align='right'> ". $mtht=round($mt_ht_chambre+$mt_ht_salle,4)." </td>
							</tr>";
							if(($chambre!=0)||($chambre_salle!=0))
							echo "<tr>
								<td> Taxe sur nuite </td>
								<td colspan='10' align='right'>". $_SESSION['taxe']." </td>
							</tr>";
							echo "<tr>
								<td> TVA  </td>"; 
										//echo $_SESSION['exhonerer_tva'];
										if (!empty($_SESSION['exhonerer_tva']))  
											{
											echo "<td colspan='10' align='left'>
											<span style='font-style:italic;font-size:0.9em;'>Exonéré de TVA</span>
											<span style='display:block;float:right;'>(-".$_SESSION['tVa'].")</span>
											</td>";
											}
										else
											{
											echo "<td colspan='10' align='right'>".$_SESSION['tva']=round(0.18*$mtht,4)." </td>";
											}
							echo "</tr>";  
								if (!empty($_SESSION['exhonerer_aib']))  
									{
										echo "<tr>
											<td> AIB  </td><td colspan='10' align='left'>
											<span style='font-style:italic;font-size:0.9em;'>Exonéré de l'AIB</span>
											<span style='display:block;float:right;'>(-".round(0.01*$mtht,4).")</span>
											</td></tr>";
									}
							echo "<tr>
								<td> Montant TTC </td>
								<td colspan='10' align='right'> ". $_SESSION['mtttc']." </td>
							</tr>";
								if(!empty($_SESSION['remise'])&& ($_SESSION['remise']>0)){
									echo "<tr>
										<td> Remise accordée</td>
										<td  colspan='10' align='right'>". $_SESSION['remise']."  </td>
									</tr>";
									}
							echo "<tr>
								<td><b> Somme Payée</b></td>
								<td colspan='10' align='right'><b> ". $_SESSION['avc']." </b></td>
							</tr>
						</table>
					</td>
				</tr>
						<tr> 
							<td colspan='2'><font size='2'>Arreté le présent Reçu à la somme de:"; 
							
								echo "<B>"; $p=chiffre_en_lettre($_SESSION['mtttc'], $devise1='Francs CFA', $devise2=''); echo"</B>";
							echo "</font> </td>
						</tr>";
							include ('footer_receipt.php');
						echo "</table>";
		if($i==0){
				echo "<table align='center' border='0' style='background-color:#FFDAB9;'> 
			<tr>
				<td><a class='info2' href='recette2.php?agent=1' ><img src='logo/b_home.png' title='' class='noprt' alt='Menu Principal' width='20' height='20' border='0'><span style='font-size:0.9em;'>Accueil </span></a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a class='info2' href=''><img src='logo/im10.jpg' width='80' id='button-imprimer' class='noprt' title=''  style='clear:both;'><span style='font-size:0.9em;'>Imprimer </span></a>
				</td>
			</tr>
		</table>";	
			
		}
						
	}


	
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
							<td align='center' colspan='2'><font size='4'> Reçu: <i>
						<?php 
								$reqsel=mysql_query("SELECT * FROM configuration_facture");
									while($data=mysql_fetch_array($reqsel))
										{  $num_fact=$data['num_fact'];;
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
						?> 
						</i></font></td>
						</tr>
						<tr>
							<td colspan='2' > <font size='5'>Client:</font> <?php echo $_SESSION['client'];?> </td>
						</tr>
						<tr>
				<?php					
				$s=mysql_query("SELECT * FROM reservationsal,salle,reserversal WHERE salle.numsalle=reservationsal.numsalle AND reservationsal.numresch= reserversal.numresch and reserversal.numresch='".$_SESSION['numresch']."'");
				$nbre=mysql_num_rows($s);							
				if($nbre==0)
					{   $chambre=1;
					 
					}
					else
					{	$s=mysql_query("SELECT * FROM reservationch,reserverch WHERE reservationch.numresch=reserverch.numresch and reserverch.numresch='".$_SESSION['numresch']."'");
						$nbre=mysql_num_rows($s);							
						if($nbre==0)
						$salle=1;
						else
						$chambre_salle=1;
					}					
					
						if($chambre_salle==1)
							{echo "<td> <u>Objet</u>: "; echo $objet="Réservation de Chambre-Salle"; echo"</td> ";
                             $ret=mysql_query('SELECT datarrivch,datdepch FROM reservationch WHERE numresch="'. $_SESSION['numresch'].'"');
							 $i=1;}							
                        if($chambre==1)
                            {echo "<td> <u>Objet</u>: "; echo $objet="Réservation de chambre"; echo"</td> ";
							$ret=mysql_query('SELECT datarrivch,datdepch FROM reservationch WHERE numresch="'. $_SESSION['numresch'].'"');
							 $i=1;}
                        if($salle==1) {echo "<td> <u>Objet</u>: "; echo $objet="Réservation de salle"; echo " </td> ";
							$ret=mysql_query('SELECT datarrivch,datdepch FROM reservationsal WHERE numresch="'. $_SESSION['numresch'].'"');}								
							?>
							
							<td align='right'>  Période du :
							<?php echo $_SESSION['debut'];  ?> 
							au 
							<?php 
								  echo $_SESSION['fin']; 
							?></td>
						</tr>
						<tr>
							<td colspan='2' align='center'>
								<table border='1' align='center' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>
									<tr> 
										<td colspan='2'><span style='font-weight:bold;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Désignation</span></td>
										<td colspan='4'><span style='font-weight:bold;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tarif </span></td>
										<?php 
										if($chambre==1)
											echo "<td colspan='2' align='center'><span style='font-weight:bold;'> Nuitée</span> </td>"; 
										else
											echo "<td colspan='2' align='center'><span style='font-weight:bold;'> Nbre de jrs</span> </td>"; 
										?>
										<td colspan='2'><span style='font-weight:bold;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Montant</span> </td>
									</tr>
									
										<?php
										$s=mysql_query("SELECT DISTINCT chambre.numch,chambre.nomch,chambre.typech,reservationch.nuiterc FROM reservationch,reserverch,chambre WHERE EtatChambre='active' AND reservationch.numch=chambre.numch AND reservationch.numresch='".$_SESSION['numresch']."'");
												while ($ret1=mysql_fetch_array($s))
												{   $typech=$ret1['typech'];
													$numch=$ret1['numch'];
												    if($typech=="V") $type="Ventillée"; else $type="Climatisée";													
													$sql=mysql_query("SELECT DISTINCT reserverch.typeoccuprc,reserverch.tarifrc FROM reserverch WHERE numresch='".$_SESSION['numresch']."' AND numch='$numch'");
													while ($ret2=mysql_fetch_array($sql))
													{	if($ret2['typeoccuprc']=='individuelle') $taxe=1000*$ret1['nuiterc']; else $taxe=2000*$ret1['nuiterc'];
														echo " <tr><td colspan='2'>"; echo"&nbsp;"."Chambre"." ".($ret1['nomch']." "."(".$ret2['typeoccuprc'].")"." ".$type); echo "</td>"; 
														echo "<td colspan='4'>"; echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($ret2['tarifrc']); echo "</td>"; 
														echo "<td colspan='2' align='center'>"; echo"".($ret1['nuiterc']); echo "</td>";
														echo "<td align='right' colspan='2'>"; echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($ret2['tarifrc']*$ret1['nuiterc']); echo "</td></tr>"; 
													}													
												}
										?>
									<tr> 
										<?php
										    mysql_query("SET NAMES 'utf8'");
											$ret=mysql_query('SELECT DISTINCT salle.codesalle,reserversal.typeoccuprc,salle.tariffete,salle.tarifreunion,reserversal.nuite_payee,mtrc,nuiterc FROM reservationsal,reserversal,salle WHERE reservationsal.numresch=reserversal.numresch AND salle.numsalle=reserversal.numsalle AND reserversal.numresch="'. $_SESSION['numresch'].'"');
											$mt_ht_salle=0;
											while ($ret1=mysql_fetch_array($ret))
											{      	echo " <tr><td colspan='2'>";echo"&nbsp;".""."".($ret1['codesalle']." "."(".$ret1['typeoccuprc'].")"); echo "</td>";
											       $nuite_payee=$ret1['nuite_payee'];$nuiterc=$ret1['nuiterc'];
												   if($ret1['typeoccuprc']=='reunion')
														$tarif=$ret1['tarifreunion'];
											       else
														$tarif=$ret1['tariffete'];
													echo "<td colspan='4'>";echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tarif; echo "</td>"; 
													echo "<td align='center'colspan='2'>"; echo $nuiterc; echo "</td>"; 
													echo "<td align='right'colspan='2'>"; echo $mt_ht_salle1=$tarif*$nuiterc; echo "</td>";  
													$mt_ht_salle+=$mt_ht_salle1; 
											}															
				$s=mysql_query("SELECT * FROM reservationsal,salle,reserversal WHERE salle.numsalle=reservationsal.numsalle AND reservationsal.numresch= reserversal.numresch and reserversal.numresch='".$_SESSION['numresch']."'");
				$nbre=mysql_num_rows($s);							
				if($nbre==0)
					{	$s=mysql_query("SELECT * FROM reservationch,reserverch WHERE reservationch.numresch=reserverch.numresch and reserverch.numresch='".$_SESSION['numresch']."'");
						while($ez=mysql_fetch_array($s))
						{
						}						 
					}
					else
					{
					}				
							?>
							</tr>
							<tr>
								<td> Montant HT</td>
								<td colspan='10' align='right'> <?php echo $mtht=round($mt_ht_chambre+$mt_ht_salle,4);?> </td>
							</tr>
							<?php
							if(($chambre!=0)||($chambre_salle!=0))
							echo "<tr>
								<td> Taxe sur nuite </td>
								<td colspan='10' align='right'>". $_SESSION['taxe']." </td>
							</tr>";
							?>
								<tr>
								<td> TVA  </td>
									<?php  
										if (!empty($_SESSION['exhonerer_tva']))
											{
											echo "<td colspan='10' align='left'>
											<span style='font-style:italic;'>Exonéré de TVA</span>
											<span style='display:block;float:right;'>(-".$_SESSION['tVa'].")</span>
											</td>";
											}
										else
											{
											echo "<td colspan='10' align='right'>".$_SESSION['tva']=round(0.18*$mtht,4)." </td>";
											}
									?>
							</tr>
							
							<?php   
								if (!empty($_SESSION['exhonerer_aib']))   
									{
										echo "<tr>
											<td> AIB  </td><td colspan='10' align='left'>
											<span style='font-style:italic;'>Exonéré de l'AIB</span>
											<span style='display:block;float:right;'>(-".round(0.01*$mtht,4).")</span>
											</td></tr>";
									}
							?>
							<tr>
								<td> Montant TTC </td>
								<td colspan='10' align='right'> <?php echo $_SESSION['mtttc'];?> </td>
							</tr>
							<?php
								if(!empty($_SESSION['remise'])&& ($_SESSION['remise']>0)){
									echo "<tr>
										<td> Remise accordée</td>
										<td  colspan='10' align='right'>". $_SESSION['remise']."  </td>
									</tr>";
									}
									?>
							<tr>
								<td><b> Somme Payée</b></td>
								<td colspan='10' align='right'><b> <?php echo $_SESSION['avc'];?>  </b></td>
							</tr>
						</table>
					</td>
				</tr>
						<tr> 
							<td colspan='2'><font size='2'>Arreté le présent Reçu à la somme de: 
							<?php 
								echo "<B>";$p=chiffre_en_lettre($_SESSION['mtttc'], $devise1='Francs CFA', $devise2=''); echo"</B>";
							?></font> </td>
						</tr>
						<tr>
							<td align='right' colspan='2'>Signature,</td>
						</tr>
						<tr> 
							<td align='right' colspan='2'>&nbsp; </td>
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
 $recu=substr($num_recu, 0, -3);$heure=date('H:i:s');
 
$ret=mysql_query('SELECT * FROM reservationch,reserverch,chambre WHERE reservationch.numresch=reserverch.numresch AND reserverch.numch=chambre.numch AND reserverch.numresch="'. $_SESSION['numresch'].'"');
while ($ret1=mysql_fetch_array($ret))
	{   $typech=$ret1['typech'];
		if($typech=="V") $type="Ventillée"; else $type="Climatisée";
		$nomch=$ret1['nomch']; $_SESSION['occup']=$ret1['typeoccuprc'];
		$_SESSION['tarif']=$ret1['mtrc']; $nuiterc=$ret1['nuiterc'];
		$var=$ret1['tarifrc']*$nuiterc;
		$tu=mysql_query("INSERT INTO reeditionfacture2 VALUES ('$num_recu','".$_SESSION['numresch']."','Chambre $nomch','".$type."','".$_SESSION['occup']."','".$_SESSION['tarif']."','".$nuiterc."','$var')");
	}
$ret=mysql_query('SELECT * FROM reservationsal,reserversal,salle WHERE reservationsal.numresch=reserversal.numresch AND reserversal.numsalle=salle.numsalle AND reserversal.numresch="'. $_SESSION['numresch'].'"');
while ($ret1=mysql_fetch_array($ret))
	{   $typeoccuprc=ucfirst($ret1['typeoccuprc']);
		$codesalle=$ret1['codesalle']; $_SESSION['occup']=$ret1['typeoccuprc'];
		$_SESSION['tarif']=$ret1['mtrc']; $nuiterc=$ret1['nuiterc'];
		$var=$ret1['tarifrc']*$nuiterc; 
		$tu=mysql_query("INSERT INTO reeditionfacture2 VALUES ('$num_recu','".$_SESSION['numresch']."','$codesalle','".$typeoccuprc."','','".$_SESSION['tarif']."','".$nuiterc."','".$tarif."')");
	}
 $tu=mysql_query("INSERT INTO reedition_facture VALUES ('".date('Y-m-d')."','$Heure_actuelle','".$_SESSION['login']."','$num_recu','$num_recu','".addslashes($_SESSION['client'])."','$objet','".$_SESSION['debut']."','".$_SESSION['fin']."','".$_SESSION['taxe']."','".$_SESSION['tva']."','".$_SESSION['mtttc']."','".$_SESSION['remise']."','".$_SESSION['avc']."')");

//Attention, une fois la facture imprimée, on vide la session
/*  $_SESSION['numresch']='';
 $_SESSION['mtht']="";
 $_SESSION['mtttc']=""; */
?>