<?php
		include 'menu.php'; 

?>
	<body bgcolor='azure' style="">
	<div align="" style="margin-top:0px;">
				<table align="center" width="" border="0" cellspacing="0" style="margin-top:0px;border-collapse: collapse;font-family:Cambria;">
				<hr noshade size=3> <div align="left">
					<FONT SIZE=5 COLOR="Maroon">  <B>LISTE DE TOUS LES CLIENTS</B>&nbsp;</FONT>
						
					<span style='color:red;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre total de clients:
						<?php 
					mysqli_query($con,"SET NAMES 'utf8' ");
					$res=mysqli_query($con,'SELECT * FROM client ORDER BY nomcli ASC'); 
					$nbre=mysqli_num_rows($res);


					echo "<span style='color:black;'>&nbsp;&nbsp;".$nbre."</span>"; ?> </B>  
					<?php
					$reqsel=mysqli_query($con,"SELECT * FROM client ORDER BY nomcli ASC ");
					$nbre_client=mysqli_num_rows($reqsel);
					$clientsParPage=1000; //Nous allons afficher 5 contribuable par page.
					$nombreDePages=ceil($nbre_client/$clientsParPage); //Nous allons maintenant compter le nombre de pages.
					 
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
					 $premiereEntree=($pageActuelle-1)*$clientsParPage;
					
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:red;'>Page :</span> "; //Pour l'affichage, on centre la liste des pages
						for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
						{
							 //On va faire notre condition
							 if($i==$pageActuelle) //Si il s'agit de la page actuelle...
							 {
								 echo ' [ '.$i.' ] '; 
							 }	
							 else //Sinon...
							 {	echo ' <a href="modifclient.php?menuParent=Modification&groupe=1&page='.$i.'">'.$i.'</a> ';
							 }
						}
					?>
					</span></span> <hr noshade size=3>
					<tr bgcolor='#3EB27B' style="color:white;font-size:1.2em; ">
						<td style="border-right: 2px solid #ffffff" align="center" >Num&eacute;ro</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Nom et Pr&eacute;noms</td>
						
						<td style="border-right: 2px solid #ffffff" align="center" >Date de naissance</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Lieu de naissance</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Type de pi&egrave;ce</td>
						<td style="border-right: 2px solid #ffffff" align="center" >N° de la pi&egrave;ce</td>
						<td style="border-right: 2px solid #ffffff" align="center" >D&eacute;livr&eacute; le</td>
						<td style="border-right: 2px solid #ffffff" align="center" >A</td>
				
						<td style="border-right: 2px solid #ffffff" align="center" >Pays d'origine</td>
						<td align="center" >Actions</td>
					</tr>
<?php
		
					mysqli_query($con,"SET NAMES 'utf8'");
					  $query_Recordset1 = "SELECT * FROM client ORDER BY nomcli ASC LIMIT $premiereEntree, $clientsParPage";
					   $Recordset_2 = mysqli_query($con,$query_Recordset1);
							$cpteur=1;
							while($data=mysqli_fetch_array($Recordset_2))
							{
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
								echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>"; 
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['numcli']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['nomcli']." ".$data['prenomcli']."</td>";
										//echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['sexe']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['datnaiss']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['lieunaiss']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['typepiece']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['numiden']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['date_livrais']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['lieudeliv']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['pays']."</td>";
										//echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['pays']."</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
											echo " 	<a href='";
											//echo "modification_client.php?menuParent=Modification&numcli=".$data['numcli'];
											echo "'><img src='logo/b_edit.png' alt='' title='Modifier' width='16' height='16' border='0'>";
											echo "</a>";
											echo " 	&nbsp;";
											echo " 	<a href='";
											//echo "suppression_client.php?menuParent=Modification&numcli=".$data['numcli'];
											echo "'><img src='logo/b_drop.png' alt='Supprimer' title='Supprimer' width='16' height='16' border='0'></a>";
										echo " 	</td>";
									echo " 	</tr> ";
							}
						
?>
</table>
</div>
</body>