<?php
	//session_start(); 	//include 'connexion.php';
	include 'menu.php';	include 'chiffre_to_lettre.php';
	$reqsel=mysqli_query($con,"SELECT logo FROM autre_configuration");
	$data=mysqli_fetch_assoc($reqsel);	$logo=$data['logo'];
//$_SESSION['recufiche']=1;
		$req="SELECT encaissement.typeoccup AS typeoccup,encaissement.np AS np,chambre.typech AS typech FROM encaissement,chambre WHERE EtatChambre='active' AND encaissement.numch=chambre.numch AND encaissement.ref='".$_SESSION['num']."'";
		$reqsel=mysqli_query($con,$req);
			while($data=mysqli_fetch_array($reqsel))
				{  $typeoccup=$data['typeoccup'];
				   $typech=$data['typech'];
				   $np=$data['np'];  				   			
				}
		  //if(isset($_SESSION['recufiche']))$taxe= $np*1000; else $taxe=$_SESSION['nuit']*$_SESSION['ttax']; 
		  //if(($typeoccup!='individuelle')||($etat_taxe=1)) $taxe*=$etat_taxe;	
		  $taxe=$_SESSION['nuit']*$_SESSION['np']; 		  
		  $_SESSION['lien']= $_SERVER['PHP_SELF'];
?>
<html>
	<head>	
	<link rel="Stylesheet" type="text/css" media="screen, print" href='style.css' /> 
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
	<body bgcolor='#84CECC'> 
<?php  
	for($i=0;$i<=1;$i++)
	{echo "<table align='center' border='1' width='550' style='background-color:#E3EEFB;border-radius:10px;font-family:Cambria;'> 
			<tr>
				<td>
					<table align='center' >
						<tr>
							<td width=''><font size='4' align='center'>&nbsp;&nbsp;&nbsp;&nbsp;".$nomHotel."</font ></td>
						    <td align='right'> Cotonou le, ".$Date_actuel." </td>
						</tr>
						<tr>
							<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp; <img src='".$logo."' width='150px' height='75px'></td>
							<td align='right'> </td>
						</tr>
						<tr>
							<td align='center' colspan='2'><font size='4'> Reçu N°: <i>"; 
						 	$reqsel=mysqli_query($con,"SELECT numrecu FROM configuration_facture");
							$data=mysqli_fetch_object($reqsel);
							echo $num_recu=NumeroFacture($data->numrecu);

					   echo "</i></font></td>
						</tr>
						<tr>
							<td colspan='2' > <font size='4'>Client:&nbsp;</font>".$_SESSION['cli']."</td>
						</tr>
						<tr>
							<td> Objet : Hébergement </td>
							<td align='right'>Période du : ";
							if(isset($_SESSION['recufiche'])){
							$heure=(date('H')); $minuite=(date('i'));
							if(($heure>=05))
								echo $du=date('d/m/Y');
							else
								echo $du=date("d/m/Y", mktime(0,0,0,date("m"),date("d")-1,date("Y")));
							echo  " au ";
							
								if(!empty($_SESSION['date']))
									echo $au=$_SESSION['date']; 
								else
									{	$d=date("d/m/Y", mktime(0,0,0,date("m"),date("d")+$_SESSION['np'],date("Y")));
										if(($heure>=05))
											echo $au=$d;
										else
											echo $au=$d=date("d/m/Y", mktime(0,0,0,date("m"),date("d")+$_SESSION['np']-1,date("Y")));
									}
							}else{
							$query_Recordset1 = "SELECT max(reedition_facture.au) AS au FROM reeditionfacture2,reedition_facture WHERE reeditionfacture2.numrecu=reedition_facture.numrecu AND reeditionfacture2.numfiche='".$_SESSION['num']."'";
							$Recordset_2 = mysqli_query($con,$query_Recordset1);
							$result=mysqli_fetch_array($Recordset_2);$au=$result['au'];
							if(empty($au))
								echo $du=$_SESSION['date'];
							else
								echo $du=$au;
							echo "  au ";
							$s=mysqli_query($con,"SELECT * FROM fiche1, compte WHERE fiche1.numfiche=compte.numfiche and fiche1.numfiche='".$_SESSION['num']."'");
							$ret1=mysqli_fetch_array($s);
							$date1=substr($ret1['datarriv'],0,4); $date2=substr($ret1['datarriv'],5,2); $date3=substr($ret1['datarriv'],8,2);
							$d=date("d/m/Y", mktime(0,0,0,date($date2),date($date3)+$_SESSION['np'],date($date1)));
							echo $d;	
							}
							echo "</td>
						</tr>
						<tr>
							<td colspan='2' align='center'>
								<table border='1' align='center' width='100%' cellpadding='0' cellspacing='0' style='border:1px solid black;font-family:Cambria;'>
									<tr> 
										<td> <B>Désignation</B></td>
										<td align='center'><B> Tarif</B> </td>
										<td align='center'> <B>Nuitée </B></td> 
										<td align='right'><B> Montant </B></td>
									</tr>
									<tr > 
										<td> Chambre&nbsp;";
								   
								  if(isset($_SESSION['recufiche'])){
									   $query_Recordset1 = "SELECT nomch FROM chambre WHERE EtatChambre='active' AND numch LIKE '".$_SESSION['numch']."'";
									   $Recordset1 = mysqli_query($con,$query_Recordset1) or die(mysqli_error($con));
									   $row_Recordset1 = mysqli_fetch_assoc($Recordset1);									
									   echo $nomch=$row_Recordset1['nomch'];
								   }else{ echo $nomch=$_SESSION['nomch'];}

										echo'&nbsp;';echo $_SESSION['tch'];echo'     ';  echo"("; echo($_SESSION['occup']);echo")</td>";
										echo "<td align='center'> ".$_SESSION['tarif']." </td>
										<td align='center'>"; if($_SESSION['np']>0) echo $_SESSION['np']; else echo "-";   echo " </td> 
										<td align='right' >".$_SESSION['tarif']*$_SESSION['np']."</td>									
								
										
									</tr>";
										$req="SELECT *   FROM connexe,fraisconnexe WHERE connexe.id = fraisconnexe.id and fraisconnexe.numfiche='".$_SESSION['num']."'";
										$s=mysqli_query($con,$req);
										if($nbreresult=mysqli_num_rows($s)>0)
											{while($ret1=mysqli_fetch_array($s))
												{ 	 $NomFraisConnexe =$ret1['NomFraisConnexe'];
													$Unites =$ret1['Unites'];
													$MontantUnites =$ret1['MontantUnites'];
													$NbreUnites =$ret1['NbreUnites'];$Ttotal = $NbreUnites * $MontantUnites ;
													
													echo "<tr > 
														<td>".$NomFraisConnexe." </td>
														<td align='center'> ".$MontantUnites." </td>
														<td align='center'>".$NbreUnites."  </td> 
														<td align='right'>".$Ttotal."  </td>
													</tr>";
												} 
											}
											$taxe=isset($taxe)?$taxe:0;		 $Ttotal=isset($Ttotal)?$Ttotal:0;
									echo "		 
									<tr>
										<td> Taxe sur Nuitée </td>
										<td colspan='3' align='right'>".$taxe."</td>
									</tr>"; 

										if($TvaD==0)  
											{
											}else {
												echo "<tr>
												<td>TVA </td>
												<td colspan='3' align='right'>". round($_SESSION['tva'])."</td>
												</tr>";
											}
									echo "<tr>
										<td> Montant TTC</td>
										<td  colspan='3' align='right'>";
										if(isset($_SESSION['recufiche']))
											echo $var=round($_SESSION['nuit']+round($_SESSION['tva'])+$_SESSION['tarif']*$_SESSION['np']+$_SESSION['Fconnexe']); // -($TvaD*$taxe)
										 else 
											echo $var= $Ttotal+$_SESSION['nuit']*$_SESSION['ttc_fixe'];   
										
										//$var=$_SESSION['ttc'];
										
										echo" </td>
									</tr>";
										if(isset($_SESSION['reduction'])&& ($_SESSION['reduction']>0)) 
											{	echo "<tr>
												<td>Remise accordée </td>
												<td colspan='3' align='right'>". round($_SESSION['reduction'],4)."</td>
												</tr>";
											}else {

											}
									if(!empty($_SESSION['remise'])&& ($_SESSION['remise']>0)){
									echo "<tr>
										<td> Remise accordée</td>
										<td  colspan='3' align='right'> ".$_SESSION['remise']."</td>
									</tr>";
									}
									echo "<tr>
										<td>"; echo "Somme Payée"; if(($_SESSION['modulo']==0)&&($_SESSION['somme']< $var))  echo "&nbsp;&nbsp;(Arrhes)"; echo "</td>
										<td colspan='3' align='right'>".$_SESSION['somme']." </td>
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
							<B>"; echo $p=chiffre_en_lettre($var, $devise1='francs CFA', $devise2=''); echo"</B>
							</font>  </td>
						</tr>";

						include ('others/footer_receipt.php');
						
					echo "</table>
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
 </script>  </iframe>
	</body>
</html>

<?php 
unset($_SESSION['pre']); 
unset($_SESSION['npp']);unset($_SESSION['db']);
if($typech=="V")
	$typech=utf8_decode("Ventillée");
else
	$typech=utf8_decode("Climatisée");  $numfiche = isset($_SESSION['edit2'])?$_SESSION['edit2']:$_SESSION['num'];
	$recu=substr($num_recu, 0, -3);$heure=date('H:i:s'); $remise=isset($_SESSION['reduction'])?$_SESSION['reduction']:$_SESSION['remise']; $remise=!empty($remise)?$remise:0;
	$sql=mysqli_fetch_assoc(mysqli_query($con,"SELECT date FROM compte WHERE numfiche='".$numfiche."'"));$tva =isset($_SESSION['tva'])? round($_SESSION['tva'],4):NULL;
	$req1="INSERT INTO reedition_facture VALUES ('".$Jour_actuel."','$Heure_actuelle','".$_SESSION['login']."','$num_recu','0','0','".addslashes($_SESSION['cli'])."','Hébergement','$du','$au','$taxe','$tva','$var','".$remise."','".$_SESSION['somme']."')";
	$req2="INSERT INTO reeditionfacture2 VALUES ('$num_recu','".$numfiche."','Chambre $nomch','".$_SESSION['tch']."','".$_SESSION['occup']."','".$_SESSION['tarif']."','".$_SESSION['np']."','".$_SESSION['tarif']*$_SESSION['np']."')";
$tu=mysqli_query($con,$req1);
$tu=mysqli_query($con,$req2);
?>