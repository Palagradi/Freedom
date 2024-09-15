<?php
	include_once'menu.php';
			$j= 0;$date=date('d-m-Y');
			//echo "SELECT DISTINCT  date_modification  FROM operation WHERE date_modification LIKE '".$date."' ORDER BY date_modification DESC";
			$req = mysqli_query($con,"SELECT DISTINCT  date_modification  FROM operation WHERE date_modification LIKE '".$date."' ORDER BY date_modification DESC");
			while($data = mysqli_fetch_array($req))
			{ $date_modification[$j] = $data['date_modification']; 
			
	 $query_Recordset1 = "SELECT * FROM operation,entree_sortie WHERE entree_sortie.reference1=operation.reference1 AND operation.date_modification='".$date_modification[$j]."'  ORDER BY operation.numero ASC";
	$Recordset_2 = mysqli_query($con,$query_Recordset1);
	$data="";
 		while($row=mysqli_fetch_array($Recordset_2))
		{		  $ref_operation=$row['reference1'];   
				  $designation=$row['designation'];
				  $service=$row['service'];
				  $qte_initial=$row['qte_initial'];
				  $qte_affecte=$row['qte_affecte'];
				  $qte_restant=$row['qte_restant'];
		

		}
		
			  $j++;
			}
			$totalRows_Recordset = mysqli_num_rows($req);


?> <!--
<html>
	<head> 
		<script type="text/javascript" src="date-picker.js"></script>
	</head>
	<body bgcolor='azure' style="margin-top:2px;">
	<div align="" style="width:1100px;margin:15px 10%;border:2px solid white;background-color:#D0DCE0;border-radius: 5px;-moz-border-radius: 5px;">
		<form  action='Affectation3.php?menuParent=Economat' method='post' name='Affectation2'>
				<br/><table align='center'style='font-size:1.2em;'>				
				<tr> 
					<td style=''> <center> <font color='green' size='6' >CONSULTATION DE L'ETAT JOURNALIER DES AFFECTATIONS </font></center></td> 
				</tr>
			</table> 
			<br/> 
			<table  align='center' style='font-weight:bold;font-size:1.2em;'>
				
				</tr> 
			<tr>
				

				<td>Période du: </td>
				<td>
					<input type="text" name="debut" id="" size="20" readonly style='<?php if(isset($etat1_4)&&($etat1_4==1)) echo"background-color:#FDF1B8;";?>' value="" />
				   <a href="javascript:show_calendar('Affectation2.debut');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
					 <img src="logo/cal.gif" style="border:1px solid blue;" alt="calendrier" title="calendrier"></a>
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Au: </td>
				<td>
					<input type="text" name="fin" id="" size="20" readonly style='<?php  if(isset($etat1_4)&&($etat1_4==1)) echo"background-color:#FDF1B8;";?>' value="" />
				   <a href="javascript:show_calendar('Affectation2.fin');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
					 <img src="logo/cal.gif" style="border:1px solid blue;" alt="calendrier" title="calendrier"></a>
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-size:0.6em;font-style:italic;'>Condensé:</span> </td> <td> <input type='checkbox' name='condense' checked='checked' value='1'> </td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type='submit' name='VALIDER' value='VALIDER' class="bouton3" style="border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;"/>	</td>
				
				</tr>
		</table>
				<?php		
				for($n=0;$n<$totalRows_Recordset;$n++) 
				{ mysqli_query($con,"SET NAMES 'utf8'");	
				 $query_Recordset1 = "SELECT * FROM operation,entree_sortie WHERE designation_operation='Affection de produit' AND entree_sortie.reference1=operation.reference1 AND operation.date_modification='".$date_modification[$n]."'  ORDER BY numero ASC";
			     $Recordset_2 = mysqli_query($con,$query_Recordset1);
				 $nbre = mysqli_num_rows($Recordset_2);
				   if($nbre>0)
				   {echo "<table align='center' width='900' border'0' cellspacing='0'style='margin-top:20px;border-collapse: collapse;font-family:Cambria;'>
					<caption style='text-align:left;text-decoration:none; font-family:Cambria;font-size:1em;margin-bottom:5px;'>Affectation des produits en date du <span style='color:blue;'>$date_modification[$n] </span>.&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
					</caption> 
					<tr style='background-color:#FF8080;color:white;font-size:1.2em; padding-bottom:5px;'>
						<td style='border-right: 2px solid #ffffff' align='center' >Référence </td>
						<td style='border-right: 2px solid #ffffff' align='center' >D&eacute;signation </td>
						<td style='border-right: 2px solid #ffffff' align='center' >Service béneficiaire</td>
						<td style='border-right: 2px solid #ffffff' align='center' >Stock initial</td>
						<td style='border-right: 2px solid #ffffff' align='center' >Qt&eacute; affect&eacute;e</td>
						<td style='border-right: 2px solid #ffffff' align='center' >Stock final</td>
					</tr>";
					$cpteur=1;
					$data="";
					//$fichier='p_r_stock'.$NumMag[$n];
					//$magasin=$LibMag[$n];
					while($row=mysqli_fetch_array($Recordset_2))
					{  	//$prix=$row['prix']." ".$devise;
						//$ecrire=fopen($fichier.'.txt',"w");
						//$data.=$row['Numproduit'].';'.utf8_decode($row['Designation']).';'.$prix.';'.$row['Seuil'].';'.$row['qte_stock'].';'."\n";						
						//$ecrire2=fopen($fichier.'.txt',"a+");
						//fputs($ecrire2, $data); 
						$quantite=$row['quantite'];
						$restant=$row['quantite']-$row['qte_affecte'];
						if($cpteur == 1)
						{
							$cpteur = 0;
							$bgcouleur = "#acbfc5";
						}
						else
						{
							$cpteur = 1;
							$bgcouleur = "#dfeef3";
						} 
						echo " 	<tr bgcolor='".$bgcouleur."'>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['reference1']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['designation']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['service']."</td>";
										echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['Qte_initiale']."</td>";
										echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['Qte_entree']."</td>";
										echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['qte_finale']."</td>";
								echo " 	</tr> ";
								
							$ecrire=fopen('etat_affectation1.txt',"w");
							$data.=$row['reference1'].';'.$row['designation'].';'.$row['service'].';'.$row['Qte_initiale'].';'.$row['Qte_entree'].';'.$row['qte_finale']."\n";
							$ecrire2=fopen('etat_affectation1.txt',"a+");
							fputs($ecrire2,$data);
					}
					echo "</table>";
				}				
				}
				
				  	?>
		<table align='center'style='font-size:1.1em;'>
		<tr>
		
		</tr>
		</table>
		
	</form>
		<br/>
		<div align="center" style="color:black;font-size:1.1em;color:#800000;">Pour afficher l'état des entrées-sorties au format pdf, 
		<a href="etat_affectation.php?date1=<?php echo $date; ?>" target='_blank' style="text-decoration:none;font-weight:bold;"> Cliquer ici <img src="logo/pdf_small.gif"style=""/> <a/></div>
	</div>
	</body> 
</html>
