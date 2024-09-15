<?php
include_once'menu.php';

	if(!empty($trie)&&($trie)==1) $trier= "numcli";if(!empty($trie)&&($trie)==2) $trier= "nomcli ASC,prenomcli";
	if(!empty($trie)&&($trie)==3) $trier= "sexe";if(!empty($trie)&&($trie)==4) $trier= "datnaiss";
	if(!empty($trie)&&($trie)==5) $trier= "lieunaiss";if(!empty($trie)&&($trie)==6) $trier= "typepiece";
	if(!empty($trie)&&($trie)==7) $trier= "numiden";if(!empty($trie)&&($trie)==8) $trier= "date_livrais";
	if(!empty($trie)&&($trie)==9)$trier= "lieudeliv";if(!empty($trie)&&($trie)==10)$trier= "institutiondeliv";if(!empty($trie)&&($trie)==11) $trier= "pays";
	$reqsel=mysqli_query($con,"select * FROM client ");
		$nbre_prdts=mysqli_num_rows($reqsel);
		$prdtsParPage=1000; //Nous allons afficher 5 contribuable par page.
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

		// if(!isset($premiereEntree)) $premiereEntree=1;

		if(empty($trie))
			{mysqli_query($con,"SET NAMES 'utf8' ");
			//$sql="SELECT * FROM client ORDER BY nomcli ASC,prenomcli ASC LIMIT $premiereEntree, $prdtsParPage";
			 $sql="SELECT * FROM client ORDER BY nomcli ASC,prenomcli ASC LIMIT  $prdtsParPage";
			$res=mysqli_query($con,$sql); }
		else
		{mysqli_query($con,"SET NAMES 'utf8' ");
		$res=mysqli_query($con,"SELECT * FROM client ORDER BY $trier ASC LIMIT  $prdtsParPage"); }
		$nbre=mysqli_num_rows($res);
?>
<html>
	<head>
	</head>
	<body bgcolor='azure' style="">
	<div align="center" style="">
	<table>
			<tr>
				<td>
					<hr noshade size=3> <div align="left">
					<FONT SIZE=5 COLOR="Maroon">  <B>LISTE DE TOUS LES CLIENTS</B>&nbsp;</FONT>

					<span style='font-style:italic;font-size:0.9em;color:#6694AE;'></span> <span style=''> &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
					&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
					&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; <?php //echo $nbre."/".$nbre_prdts;
					echo "<span style='float:right;color:red;'>Page : "; //Pour l'affichage, on centre la liste des pages
						//if(!empty($_GET['page']))
							$k=!empty($_GET['page'])?$_GET['page']-1:NULL;
						if($k>0)
							echo ' <a href="lclient.php?menuParent=Consultation&page='.$k.'" title="Précédent" style="text-decoration:none;">  &nbsp;<<&nbsp;  </a> ';

						for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
						{
							 //On va faire notre condition
							 if($i==$pageActuelle) //Si il s'agit de la page actuelle...
							 {
								 echo ' [ '.$i.' ] ';
							 }
							 else //Sinon...
							 {
								  if($i==1)
									{echo ' <a href="lclient.php?menuParent=Consultation&page='.$i.'">'.$i.'</a> ';

									}
								  else
									{
									}
							 }
						}
						if(empty($_GET['page']))$j=!empty($_GET['page'])?$_GET['page']+2:NULL; else $j=!empty($_GET['page'])?$_GET['page']+1:NULL;
						if($i>=$j)
							echo ' <a href="lclient.php?menuParent=Consultation&page='.$j.'" title="Suivant" style="text-decoration:none;">  <span style="font-weight:bold;">&nbsp; >>&nbsp;<span>  </a> ';

					?> </span></span>
					<FONT SIZE=4 COLOR="0000FF"> </FONT> </div> <hr noshade size=3>
				</td>
			</tr>
			<tr>
				<td>
				<span style='color:#3B5998;font-style:italic;'></span>
					<table align='center' border='1'   width='100%' cellpadding='0' cellspacing='0' style='border:1px solid gray;font-family:Cambria;background-color:#D0DCE0;'>

						<tr  bgcolor='#3EB27B' style=''>
							<td  align='center'><b><a href='lclient.php?menuParent=Consultation&trie=1' style='text-decoration:none;color:white;' title="Trier par Numéro client">&nbsp; N° Client</a></b></td>
							<td  align='center'><b><a href='lclient.php?menuParent=Consultation&trie=2' style='text-decoration:none;color:white;' title="Trier par Nom">&nbsp;NOM & PRENOMS</a></b> </td>
							<td align='center'> <b><a href='lclient.php?menuParent=Consultation&trie=3' style='text-decoration:none;color:white;' title="Trier par Sexe">&nbsp;&nbsp;SEXE</a></b> </td>
							<td align='center'><b><a href='lclient.php?menuParent=Consultation&trie=4' style='text-decoration:none;color:white;' title="Trier par Date de naissance">&nbsp; DATE DE NAISSANCE</a></b> </td>
							<td align='center'><b><a href='lclient.php?menuParent=Consultation&trie=5' style='text-decoration:none;color:white;' title="Trier par Lieu de naissance">&nbsp;&nbsp; LIEU DE NAISSANCE</a></b> </td>
							<td align='center'><b><a href='lclient.php?menuParent=Consultation&trie=12' style='text-decoration:none;color:white;' title="Trier par Lieu de naissance">&nbsp; N° DE TELEPHONE</a></b> </td>
							<td align='center'><b><a href='lclient.php?menuParent=Consultation&trie=6' style='text-decoration:none;color:white;' title="Trier par Type de pièce">&nbsp; TYPE DE PIECE</a></b> </td>
						    <td align='center'><b><a href='lclient.php?menuParent=Consultation&trie=7' style='text-decoration:none;color:white;' title="Trier par N° pièce d'identité">&nbsp; N° PIECE D'IDENTITE</a></b> </td>
						    <td align='center'><b><a href='lclient.php?menuParent=Consultation&trie=8' style='text-decoration:none;color:white;' title="Trier par Date de délivrance">&nbsp; DELIVRE LE</a></b> </td>
							<td align='center'><b><a href='lclient.php?menuParent=Consultation&trie=9' style='text-decoration:none;color:white;' title="Trier par Lieu de délivrance"> A </a></b> </td>
							<td align='center'><b><a href='lclient.php?menuParent=Consultation&trie=10' style='text-decoration:none;color:white;' title="Trier par Délivreur"> PAR</a></b> </td>
							<td align='center'><b><a href='lclient.php?menuParent=Consultation&trie=11' style='text-decoration:none;color:white;' title="Trier par Pays d'origine"> &nbsp;PAYS D'ORIGINE</a></b></td>
						</tr>
					<?php $cpteur=1; //$i=0;
						while ($ret=mysqli_fetch_array($res))
							{//$i++;
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
								echo "<tr bgcolor='".$bgcouleur."' class='rouge1'> ";
										echo' <td width=""  align="center"> '; echo $ret[0]; echo '</td>';
										echo' <td width=""  align="">&nbsp;&nbsp; ';
										echo strtoupper($ret[2]).'&nbsp;&nbsp;&nbsp;&nbsp;'.$ret[3];
										echo '</td>';
										echo' <td width=""  align="center"> '; echo $ret[4]; echo '</td>';
										echo' <td width=""  align="center"> '; echo substr($ret[5],8,2)."-".substr($ret[5],5,2)."-".substr($ret[5],0,4); echo '</td>';
										echo' <td width=""  align="">&nbsp;&nbsp; '; echo $ret[6]; echo '</td>';
										echo' <td width=""  align="center">'; echo $ret[15]; echo '</td>';
										echo' <td width=""  align="">&nbsp;&nbsp; '; echo $ret[7]; echo '</td>';
											echo' <td width=""  align="">&nbsp;&nbsp; '; echo $ret[8]; echo '</td>';
										echo' <td width=""  align="center"> '; echo substr($ret[9],8,2)."-".substr($ret[9],5,2)."-".substr($ret[9],0,4); echo '</td>';
										echo' <td width=""  align="">&nbsp; '; echo $ret[10]; echo '</td>';
										echo' <td width=""  align="">&nbsp; '; echo $ret[11]; echo '</td>';
										echo' <td width=""  align="">&nbsp; '; echo $ret[13]; echo '</td>';
								echo'</tr>';
							}
					?>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
