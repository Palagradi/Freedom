<?php
	include_once'menu.php';
	$val=!empty($_GET['val'])?$_GET['val']:NULL;
	$et=!empty($_GET['et'])?$_GET['et']:NULL; $trie=!empty($_GET['trie'])?$_GET['trie']:NULL;
	unset( $_SESSION['remise']); 

	if(!empty($trie))
		 $Req="SELECT *  FROM payement_loyer,loyer  WHERE loyer.Numero=payement_loyer.Numero AND Etat='Npaye' ORDER BY $trie ASC";
	else 
		$Req="SELECT *  FROM payement_loyer,loyer  WHERE loyer.Numero=payement_loyer.Numero AND Etat='Npaye'";
	$reqselP=mysqli_query($con,$Req);

?>
<html>
	<head>
	</head>
	<body bgcolor='azure' style="font-family:Cambria;">
	<div align="" style="">

			<table align="center" width="" border="0" cellspacing="0" style="border-collapse: collapse;font-family:Cambria;">
			<tr>
				<td colspan='8'>
					<h3 style="float:left;text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;margin-bottom:5px;color:maroon;">  <?php echo "Liste des Locations mensuelles"; ?>
					</h3> 

				</td>
			</tr>
			<tr style=" background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;">
			<td style="border-right: 2px solid #ffffff" align="center" >  N° d'ordre </td>
				<td style="border-right: 2px solid #ffffff" align="center" > <a class='info' href='LocationMensuelle.php?menuParent=Location&trie=loyer.Numero' style='text-decoration:none;color:white;'> <span style='font-size:0.8em;color:red;'>Trier par Numéro</span> N° Location</a> </td>
				<td style="border-right: 2px solid #ffffff" align="center" ><a class='info1' href='LocationMensuelle.php?menuParent=Location&trie=NomLoc' style='text-decoration:none;color:white;'> <span style='font-size:0.8em;color:red;'>Trier par Nom</span> Nom du locataire</a>  </td>
				<td style="border-right: 2px solid #ffffff" align="center" ><a class='info1' href='LocationMensuelle.php?menuParent=Location&trie=ContactLoc' style='text-decoration:none;color:white;'> <span style='font-size:0.8em;color:red;'>Trier par Contact</span> Contact</a> </td>
				<td style="border-right: 2px solid #ffffff" align="center" > <a class='info1' href='LocationMensuelle.php?menuParent=Location&trie=Designation' style='text-decoration:none;color:white;'> <span style='font-size:0.8em;color:red;'>Trier par Désignation</span> Désignation </a> </td>
				<td style="border-right: 2px solid #ffffff" align="center" > <a class='info1' href='LocationMensuelle.php?menuParent=Location&trie=DatePayement' style='text-decoration:none;color:white;'> <span style='font-size:0.8em;color:red;'>Trier par Date Payement</span> Date Payement</a> </td>
				<td style="border-right: 2px solid #ffffff" align="center" ><a class='info1' href='LocationMensuelle.php?menuParent=Location&trie=Montant' style='text-decoration:none;color:white;'> <span style='font-size:0.8em;color:red;'>Trier par Montant</span> Montant</a>  </td>
					<?php if($et!=1) echo "<td align='center' >Actions</td>";?>
			</tr>
			<?php
				mysqli_query($con,"SET NAMES 'utf8'");$ans=date('Y');$mois=date('m');
		
/* 					if($cpteur ==1)
					 $bgcouleur = "#acbfc5";
					else
					  $bgcouleur = "#dfeef3"; */
					//if($trouver =='NON') 
					 //{ 	
						$jour=date("d");$j=1;
					 		while($row=mysqli_fetch_array($reqselP))
							{	//if(($jour==20)||($jour==21)||($jour==22)||($jour==23)||($jour==24)||($jour==25)||($jour==26)||($jour==27)||($jour==28)||($jour==29)||($jour==30)||($jour==31))
								$mois=$row['mois_payement'];
								$annee=$row['annee_payement'];
								$montant_ttc=$row['Montant'];
								$moisT = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aôut","Septembre","Octobre","Novembre","Décembre");
							if($cpteur == 1)
								{
									$cpteur = 0;
									$bgcouleur = "#DDEEDD";
								}
								else
								{
									$cpteur = 1;
									$bgcouleur = "#dfeef3";
								} 
				$Sortie=!empty($Sortie)?$Sortie:NULL;
					 echo " <tr class='rouge1' bgcolor='".$bgcouleur."' style=''>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$j.".</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['Numero']."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['NomLoc']."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['ContactLoc']."</td>";
								echo " 	<td align='left' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['Designation']."</td>";
								echo " 	<td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><span style=''>".substr($row['DatePayement'],0,2)." ".$moisT[$mois-1]." ".$annee."</span></td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$montant_ttc."</td>";
								echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
								//if($et!=1) {
								echo " 	<a class='info2' href='encaisse_loyer.php?menuParent=Location&numero=".$row['Numero']."&mois=".$mois."&ans=".$annee."'>  
								<img src='logo/more.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.9em;color:red;'>Encaisser </span> </a>";
								echo " <a class='info2' target='_blank' href='"; echo"relance.php?menuParent=Location&numero=".$row['Numero']."&Sortie=".$Sortie."' style='text-decoration:none;'>  
								&nbsp;<img src='logo/mail.png' alt='' title='' width='25' height='25' border='0' style='margin-bottom:-3px;'><span style='font-size:0.9em;color:red;'>Envoyer une lettre de relance </span></a>";
								//}
								echo "</td>";
					echo " 	</tr> ";$j++;								
							}
					//}
			?>
			<tr>
				<td colspan='8' align='right'>
					<span style="font-size:95%;color:black;">
					<span style="font-family:Cambria;font-weight:bold;font-size:1.1em;margin-bottom:5px;color:#4C767A;" >Pour afficher la liste au format pdf, 
					<a href='pdfLocation.php<?php if(!empty($trie)) echo "?trie=".$trie;?> ' target='_blank' style="text-decoration:none;font-weight:bold;"> Cliquer ici <img src="logo/pdf_small.gif" style="" width='20'/> <a/> </span>
				</td>
			</tr>
		</table>
</div> 

	</body>

</html> 