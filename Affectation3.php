<?php
include_once'menu.php';
		 if (isset($_POST['VALIDER'])&& $_POST['VALIDER']=='VALIDER') 
	     {  $debut=$_POST['debut'];	  $condense=$_POST['condense'];	
			$fin=$_POST['fin'];
			$j= 0;
			$req = mysqli_query($con,"SELECT DISTINCT date_modification  FROM operation WHERE date_modification>='".$debut."' and date_modification<='".$fin."'");
			while($data = mysqli_fetch_array($req))
			{ $date_modification[$j] = $data['date_modification']; 		
			  $j++;
			}
			$totalRows_Recordset = mysqli_num_rows($req);
		 } $_SESSION['logo']= $logo;
?>
<html>
	<head> 
		<link rel="Stylesheet" type="text/css" media="screen, print" href='style.css' /> 
	</head>
	<body bgcolor='azure' style="margin-top:0%;">

		<div align="center" style=""><br/>
		     <form action="Affectation3.php" method="POST"> 
			 	<table align='center'style='font-size:1.2em;'>				
				<tr> 
					<td style=''> <center> <font color='green' size='5' >CONSULTATION DE L'ETAT DES AFFECTATIONS DE PRODUITS POUR UNE PERIODE </font></center></td> 
				</tr>
			</table> 
	
		 </div>
				<?php	//echo $totalRows_Recordset;
				if($totalRows_Recordset==0) echo "
				<center> Aucune affectation durant cette période</center>";
			if($condense!=1)
			{for($n=0;$n<$totalRows_Recordset;$n++) 
				{ mysqli_query($con,"SET NAMES 'utf8'");	
				  $query_Recordset1 = "SELECT * FROM operation,entree_sortie WHERE entree_sortie.reference1=operation.reference1 AND operation.date_modification='".$date_modification[$n]."'";
			     $Recordset_2 = mysqli_query($con,$query_Recordset1);
				 $nbre = mysqli_num_rows($Recordset_2);
				   if($nbre>0)
				   {echo "<table align='center' width='800' border'0' cellspacing='0'style='margin-top:20px;border-collapse: collapse;font-family:Cambria;'>
					<caption style='text-align:left;text-decoration:none; font-family:Cambria;font-size:1em;margin-bottom:5px;'>Affectation des produits en date du <span style='color:blue;'>".$date_modification[$n]." </span></caption> 
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
					$fichier='etat_affectation1'.$date_affect[$n];
					//$magasin=$LibMag[$n];
					while($row=mysqli_fetch_array($Recordset_2))
					{  	
		  $ref_operation=$row['reference1'];   
		  $designation=$row['designation'];
		  $service=$row['service'];
		  $qte_initial=$row['qte_initial'];
		  $qte_affecte=$row['qte_affecte'];
		  $qte_restant=$row['qte_restant'];
		
			
		$ecrire=fopen($fichier.'.txt',"w");
		$data.=$ref_operation.';'.$designation.';'.$service.';'.$qte_initial.';'.$qte_affecte.';'.$qte_restant."\n";
		$ecrire2=fopen($fichier.'.txt',"a+");
		fputs($ecrire2,$data);

		
		
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
						echo " 	<tr class='rouge2' bgcolor='".$bgcouleur."'>"; 
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['reference1']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['designation']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['service']."</td>";
										echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$quantite."</td>";
										echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['qte_affecte']."</td>";
										echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$restant."</td>";
								echo " 	</tr> ";
					}
					echo "</table>";
				}
echo "	<br/>
		<div align='center' style='color:black;font-size:1.1em;color:#800000;'>Pour afficher l'état des Affectations au format pdf, 
		<a href='etat_affectation.php?fichier=".$fichier."&date1=".$date_affect[$n]."' target='_blank' style='text-decoration:none;font-weight:bold;'> Cliquer ici <img src='logo/pdf_small.gif'style=''/> <a/></div>";				
	}
}	
else
{ mysqli_query($con,"SET NAMES 'utf8'");	
				 $query_Recordset1 = "SELECT * FROM operation,entree_sortie WHERE entree_sortie.reference1=operation.reference1 AND operation.date_modification BETWEEN '$debut' AND '$fin' AND  designation_operation='Affection de produit'";
			     $Recordset_2 = mysqli_query($con,$query_Recordset1);
				 $nbre = mysqli_num_rows($Recordset_2);
				   if($nbre>0)
				   {echo "<table align='center' width='800' border'0' cellspacing='0'style='margin-top:20px;border-collapse: collapse;font-family:Cambria;'>
					<caption style='text-align:left;text-decoration:none; font-family:Cambria;font-size:1em;margin-bottom:5px;'>Affectation des produits en date du <span style='color:blue;'>".$debut." &nbsp;&nbsp;&nbsp;au ".$fin."</span></caption> 
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
					$fichier='etat_affectation1'.$debut;
					//$magasin=$LibMag[$n];
					while($row=mysqli_fetch_array($Recordset_2))
					{  	
		  $ref_operation=$row['reference1'];   
		  $designation=$row['designation'];
		  $service=$row['service'];
		  $qte_initial=$row['qte_initial'];
		  $qte_affecte=$row['qte_affecte'];
		  $qte_restant=$row['qte_restant'];
		
			
		$ecrire=fopen($fichier.'.txt',"w");
		$data.=$ref_operation.';'.$designation.';'.$service.';'.$qte_initial.';'.$qte_affecte.';'.$qte_restant."\n";
		$ecrire2=fopen($fichier.'.txt',"a+");
		fputs($ecrire2,$data);

		
		
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
						echo " 	<tr class='rouge2' bgcolor='".$bgcouleur."'>"; 
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['reference1']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['designation']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['service']."</td>";
										echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$quantite."</td>";
										echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['qte_affecte']."</td>";
										echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$restant."</td>";
								echo " 	</tr> ";
					}
					echo "</table>";
				}
echo "	<br/>
		<div align='center' style='color:black;font-size:1.1em;color:#800000;'>Pour afficher l'état des entrées-sorties au format pdf, 
		<a href='etat_affectation.php?fichier=".$fichier."&date1=".$fin."' target='_blank' style='text-decoration:none;font-weight:bold;'> Cliquer ici <img src='logo/pdf_small.gif'style=''/> <a/></div>";	
}		
	?>
			
			</form>

</body>	
</html>