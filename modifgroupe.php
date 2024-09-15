<?php
	session_start(); 
	ob_start();
			session_start(); 
			if($_SESSION['poste']==cpersonnel)
		include 'menucp.php'; 
	   	   if($_SESSION['poste']==agent)
		include 'menuprin1.php'; 
			   if($_SESSION['poste']==directrice)
		include 'menudirec.php'; 
			   if($_SESSION['poste']==admin)
		include 'admin.php';
			 if($_SESSION['poste']==comptable)
		include 'menucomp.php';
	include 'connexion.php';

?>
<html>
	<head>
		<title>SYGHOC</title>

	</head>
	<body> 
			<table align="center" width="" border="0" cellspacing="0" style="margin-top:40px;border-collapse: collapse;font-family:Cambria;">
			<caption style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;"><?php echo "Liste des groupes ";?><span style="font-style:italic;font-size:0.6em;color:black;"> (Possibilité de modification et de suppression) 
			<?php 
				$reqsel=mysql_query("select * FROM groupe ");
					$nbre_prdts=mysql_num_rows($reqsel);
					$prdtsParPage=50; //Nous allons afficher 5 contribuable par page.
					$nombreDePages=ceil($nbre_prdts/$prdtsParPage); //Nous allons maintenant compter le nombre de pages.
					 
					if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
					{
						  $pageActuelle=intval($_GET['page']);
					 
						 if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
						 {
							   $pageActuelle=$nombreDePages;
						 }
					}
					else // Sinon
					{
						  $pageActuelle=1; // La page actuelle est la n°1    
					}
					 $premiereEntree=($pageActuelle-1)*$prdtsParPage;
					
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:red;'>Page :</span> "; //Pour l'affichage, on centre la liste des pages
						for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
						{
							 //On va faire notre condition
							 if($i==$pageActuelle) //Si il s'agit de la page actuelle...
							 {
								 echo ' [ '.$i.' ] '; 
							 }	
							 else //Sinon...
							 {
								  if(!empty($fiche))
									echo ' <a href="modifgroupe.php?page='.$i.'">'.$i.'</a> ';
								  else 
									echo ' <a href="modifgroupe.php?page='.$i.'">'.$i.'</a> ';
							 }
						}
					//}
					?>
				</span></caption> 
			<tr style=" background-color:#FF8080;color:white;font-size:1.2em; padding-bottom:5px;">
				<td style="border-right: 2px solid #ffffff" align="center" >Code du groupe</td>
				<td style="border-right: 2px solid #ffffff" align="center" >Nom du groupe</td>
				<td style="border-right: 2px solid #ffffff" align="center" >Adresse du groupe</td>
				<td style="border-right: 2px solid #ffffff" align="center" >N° de téléphone</td>
				<?php if($et!=1) echo "<td align='center' >Actions</td>";?>
			</tr>
			<?php
				mysql_query("SET NAMES 'utf8'");$ans=date(Y);$mois=date(m);
				$query_Recordset1 = "select * FROM groupe LIMIT $premiereEntree, $prdtsParPage";
			    $Recordset_2 = mysql_query($query_Recordset1);
					$cpteur=1;
					$data="";
					while($row=mysql_fetch_array($Recordset_2))
					{   //$nom_p=substr($row['code_reel'].' '.$row['prenoms'],0,15);if($row['due']<0) $due=-$row['due']; else $due=$row['due'];
					
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
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['code_reel']."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['codegrpe']."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['adressegrpe']."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['contactgrpe']."</td>";
								echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
								echo " 	<a href='grpe_modification.php?reference=".$row['code_reel']."'><img src='logo/b_edit.png' alt='' title='Modifier' width='16' height='16' border='0'></a>";
								echo " 	&nbsp;&nbsp;&nbsp;&nbsp;";
								echo " 	<a href=''><img src='logo/b_drop.png' alt='Supprimer' title='Supprimer' width='16' height='16' border='0'></a>";
								echo " 	</td>";
						echo "</tr> ";
					}

			?>
		</table>
</div> 

	</body>

</html> 