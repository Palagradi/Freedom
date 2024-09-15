<?php
		include 'menu.php';
		

?>
<html>
	<head>
		<title> SYGHOC </title>
	</head>
	<body bgcolor='azure' style="">
	<div align="" style="">
		<table align='center' style='min-width:90%;'>
			<tr>
				<td align='left'>
					<hr noshade size=3> <B>
					<FONT SIZE=6 COLOR="Maroon"><span> LISTE DES GROUPES </span>&nbsp &nbsp;</FONT></B>
					<span style='float:right;'> <?php
				$reqsel=mysqli_query($con,"select * FROM groupe ");
					$nbre_prdts=mysqli_num_rows($reqsel);
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

					//}
					?>
					<?php mysqli_query($con,"SET NAMES 'utf8'"); $res=mysqli_query($con,'SELECT * FROM groupe ORDER BY codegrpe ASC'); $nbre=mysqli_num_rows($res); //echo "Nbre:&nbsp;".$nbre;

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
									echo ' <a href="lgroupe.php?menuParent=Consultation&page='.$i.'">'.$i.'</a> ';
								  else
									echo ' <a href="lgroupe.php?menuParent=Consultation&page='.$i.'">'.$i.'</a> ';
							 }
						}
					?></span>
					<FONT SIZE=4 COLOR="0000FF"> </FONT>  <hr noshade size=3>
				</td>
			</tr>
			<tr>
				<td align='center'>
					<table border='1' align='center' width='100%'  cellpadding='0' cellspacing='0' style='border:2px solid gray;font-family:Cambria;background-color:#D0DCE0;'>

						<tr bgcolor='#3EB27B' style='color:white; font-size:16px; '>
							<td align='center'> <b> N° d'ordre </b></td>
							<td align='center'> <b> CODE </b></td>
							<td align='center'> <b> N° IFU </b></td>
							<td align='center'> <b> DESIGNATION DU GROUPE </b></td>
							<td align='center'> <b> ADRESSE</b></td>
							<td align='center'> <b> CONTACT  </b></td>
							<td align='center'> <b> EMAIL  </b></td>

						</tr>

					<?php
						$res=mysqli_query($con,"SELECT * FROM groupe ORDER BY codegrpe ASC LIMIT $premiereEntree, $prdtsParPage"); $j=1;
						$cpteur=1; $i=0;
						while ($ret=mysqli_fetch_array($res))
							{ $i++;	if($cpteur == 1)
								{
									$cpteur = 0;
									$bgcouleur = "#DDEEDD";   //$email="entreprise".$i."@yahoo.fr";
								}
								else
								{
									$cpteur = 1;
									$bgcouleur = "#F5F5DC";   //$email="entreprise".$i."@gmail.com";
								}
								echo '<tr bgcolor="'.$bgcouleur.'" class="rouge1" >';
								echo' <td align="center"> '; echo $j; echo '</td>';
							//	for ($i=0;$i<4;$i++)
								//	{
									
								  //$IFU=random(12,1);
								//$update=mysqli_query($con,"UPDATE groupe SET email='".$email."' WHERE code_reel='".$ret['code_reel']."'");
		
								//$update=mysqli_query($con,"UPDATE groupe SET codegrpe='".trim($ret['codegrpe'])."' WHERE code_reel='".$ret['code_reel']."'");
		
								echo' <td align="center">&nbsp; '; echo $ret['code_reel']; echo '&nbsp;</td>';
								echo' <td align="center">&nbsp;&nbsp; '; echo $ret['NumIFU']; echo '&nbsp;&nbsp;</td>';
								echo' <td align="left">&nbsp;&nbsp;&nbsp; '; echo $ret['codegrpe']; echo '</td>';
								echo' <td align="center"> '; echo $ret['adressegrpe']; echo '</td>';
								echo' <td align="center"> '; echo $ret['contactgrpe']; echo '</td>';
								echo' <td align="">&nbsp;&nbsp; '; echo $ret['email']; echo '&nbsp;&nbsp;</td>';
								//	}
								echo'</tr>'; $j++;
							}
					?>
					</table>
				</td>
			</tr>
		</table>
		</div>
	</body>
</html>
