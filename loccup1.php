<?php
include_once'menu.php';
	$sal=$_GET['sal'];
	mysql_query("SET NAMES 'utf8'");
	if($sal==1)
	$re=mysql_query("SELECT * FROM salle,location,compte1,client WHERE salle.numsalle=compte1.numsalle AND location.numcli=client.numcli AND location.numfiche=compte1.numfiche AND location.etatsortie='NON'");
	else 
	$re=mysql_query("SELECT * FROM chambre,fiche1,compte,client WHERE chambre.numch=compte.numch AND fiche1.numcli_1=client.numcli AND fiche1.numfiche=compte.numfiche AND fiche1.etatsortie='NON'  ORDER BY nomch ASC");
?>
<html>
	<head> 
		<title> SYGHOC </title> 
		<link rel="Stylesheet" type="text/css" media="screen, print" href='style.css' /> 
	</head>
	<body bgcolor='azure' style="margin-top:-1%;">
		<table align='center'> 
			<tr>
				<td>
					<hr noshade size=3> <div align="center"><B>
					<FONT SIZE=6 COLOR="Maroon"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; LISTE JOURNALIERE <?php if($sal==1) echo"DES OCCUPATIONS DE SALLES"; else echo"DES OCCUPANTS "; ?> </FONT></B><B> <span style='font-style:italic;'>(En date du <?php echo gmdate('d-m-Y');?>)</span></B>
					<FONT SIZE=4 COLOR="0000FF"> </FONT> </div> <hr noshade size=3>
				</td>
			</tr>
			<tr> 
				<td>
					<table  border='1' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>
					
						<tr bgcolor='<?php if($_SESSION['poste']=="agent") echo "#CD5C5C"; else echo "black";?>'align="center" <?php if($_SESSION['poste']!="agent") echo "style='color:white;'";?>> 
							<td> N° d'ordre</td> 
							<td> N° FICHE</td> 
							<td > NOM ET PRENOMS </td> 
							<td > NOM DU GROUPE</td> 
							<td> PIECE N°</td> 
							<td> ARRIVE LE </td> 
							<td> DEPART LE </td> 
							<td> <?php if($sal==1) echo "SALLE"; else echo "CHAMBRE";?> </td> 
							<td> <?php if($sal==1) echo "MOTIF DE LA LOCATION"; else echo "TYPE OCCUPATION";?> </td> 
							<td> CONTACT</td> 
							<td> MONTANT</td> 
							<td> SOMME PAYEE</td> 
							<td> SOMME DUE</td> 
						</tr>
					<?php
						$i=1; $cpteur=1;
						while($ret1=mysql_fetch_array($re))
						{ if($cpteur == 1)
								{
									$cpteur = 0;
									$bgcouleur = "#acbfc5";
								}
								else
								{
									$cpteur = 1;
									$bgcouleur = "#dfeef3";
								}
										$n=round((strtotime(date('Y-m-d'))-strtotime($ret1['datarriv']))/86400);
										$dat=(date('H')+1); 
										settype($dat,"integer");
										if ($dat<14){$n=$n;}else {$n= $n+1;}
										if ($n==0){$n= $n+1;} $n=(int)$n;
										$mt=$ret1['ttc_fixe']*$n;
										$due = $mt-$ret1['somme']; if($due<0) $due=-$due;
										
										
										if($ret1['codegrpe']!='')
										{//Ici, pour un groupe en impayés, on va selectionner ce qu'il devait et on additionne à ce qu'il doit à la date du jour	 
										$sql2=mysql_query("SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,
										view_client.prenomcli AS prenom2, chambre.nomch, compte.tarif, compte.tva,compte.ttc_fixe, compte.taxe,compte.typeoccup, compte.ttc, fiche2.datarriv,compte.nuite,compte.np,compte.due AS due
										FROM client, fiche2, chambre, compte, view_client
										WHERE fiche2.numcli_1 = client.numcli
										AND fiche2.numcli_2 = view_client.numcli
										AND fiche2.codegrpe = '".$ret1['codegrpe']."'
										AND chambre.numch = compte.numch
										AND compte.numfiche = fiche2.numfiche
										AND fiche2.etatsortie = 'OUI' AND compte.due>0
										LIMIT 0 , 30");
										$somme_due=0;$datarriv=array("");
										while($row=mysql_fetch_array($sql2))
											{  	$N_reel=$row['N_reel'];
												$due2=$row['due'];$ttc=$row['ttc'];
												//if($datarriv==$row['datarriv'])
												$somme_due+=$due2;
												//$i++;
											}
										}
										if(!empty($somme_due))
										$due=$due+$somme_due;	
																				
										echo"<tr bgcolor='".$bgcouleur."'>"; 
											echo"<td align='center'>"; echo $i;  echo "</td>";
											//echo"<td align='center'>"; echo  "<input type='checkbox' name='choix[]' value='".$ret1['nomch']."'> "; echo "</td>";
											if($_SESSION['poste']=="agent")
											{echo"<td align=''>"; echo " <a id='container' class='container' href='"; if((($ret1['codegrpe']=="")&&($sal!=1))||($sal==1)) echo "loccup1.php?"; else echo "loccup1.php?"; if($sal!=1) echo"fiche=1"; else echo"sal=1"; echo "&numfiche=".$ret1['numfiche']."&due=".$due."&somme=".$ret1['somme']."'  title='Encaisser pour&nbsp;:&nbsp;&nbsp;"; if($ret1['codegrpe']=="") echo $ret1['nomcli']."&nbsp;".$ret1['prenomcli']; echo"' style='text-decoration:none;color:#800000;'>".substr($ret1['numfiche'],0,8)."</a>"; echo "</td>";
											echo"<td align=''>&nbsp;&nbsp;&nbsp;&nbsp;"; echo " <a  class='info' "; if($sal!=1) echo "id='container2' class='container2'"; echo " href='loccup1.php?numfiche=".$ret1['numfiche']."' style='color:black;text-decoration:none;' title='Changer le nom du client'>".substr($ret1['nomcli'],0,25).'	'.substr($ret1['prenomcli'],0,25)."</a>"; echo"</td>";
											if($sal!=1) 
												{ if(!empty($somme_due)) {echo"<td align='center'>"; if($ret1['codegrpe']!='') echo " <a href='loccup1.php?codegrpe=".$ret1['codegrpe']."&impaye=1' style='color:#800012;text-decoration:none;' title='Encaisser pour&nbsp;:&nbsp;&nbsp;".$ret1['codegrpe']."(+Impayé:&nbsp;".$somme_due.")'>".$ret1['codegrpe']."</a>"; else echo" - "; echo  "</td>";}
												else{ echo"<td align='center'>"; if($ret1['codegrpe']!='') echo " <a  class='info' id='container' class='container' href='loccup1.php?codegrpe=".$ret1['codegrpe']."' style='color:#800012;text-decoration:none;' title='Encaisser pour&nbsp;:&nbsp;&nbsp;".$ret1['codegrpe']."'>".$ret1['codegrpe']."</a>"; else echo" - "; echo  "</td>";}
												}
											else 
												{echo"<td align='center'>"; if($ret1['codegrpe']!='') { echo " <a class='info' " ; if($sal!=1) echo "id='container2' class='container2'"; echo" href='"; if($sal!=1) echo "loccup1.php?codegrpe=".$ret1['codegrpe']; echo"' style='color:#800012;text-decoration:none;' title='Encaisser pour&nbsp;:&nbsp;&nbsp;".$ret1['codegrpe']."'>".$ret1['codegrpe']."</a>";} else echo" - "; echo  "</td>";}
											}
											else
											{echo"<td align=''>"; echo " <a class='info' id='container' class='container' href='"; echo "reajuster.php?"; if($sal!=1) echo"fiche=1"; else echo"sal=1"; echo "&numfiche=".$ret1['numfiche']."&due=".$due."&somme=".$ret1['somme']."'  title='&nbsp;&nbsp;&nbsp;"; echo"' style='text-decoration:none;color:#800000;'>  <span>Supprimer cette fiche</span>".substr($ret1['numfiche'],0,8)."</a>"; echo "</td>";
											echo"<td align=''>&nbsp;&nbsp;&nbsp;&nbsp;"; echo " <a  class='info' "; echo"style='color:black;text-decoration:none;' title=''>".substr($ret1['nomcli'],0,25).'	'.substr($ret1['prenomcli'],0,25)."</a>"; echo"</td>";
											echo"<td align='center'>"; if($ret1['codegrpe']!='') { echo $ret1['codegrpe'];} else echo" - "; echo  "</td>";
											}
											echo"<td align=''>"; echo $ret1['numiden']; echo"</td>";
											echo"<td align='center'>"; echo substr($ret1['datarriv'],8,2).'-'.substr($ret1['datarriv'],5,2).'-'.substr($ret1['datarriv'],0,4); echo "</td>";
											echo"<td align='center'>"; echo substr($ret1['datsortie'],8,2).'-'.substr($ret1['datsortie'],5,2).'-'.substr($ret1['datsortie'],0,4); echo"</td>";
											if($_SESSION['poste']=="agent")
											{echo"<td align='center'>".$ret1['codesalle']." <a id='container' class='container' href='loccup1.php?numfiche=".$ret1['numfiche']."' style='color:black;text-decoration:none;' title='Déloger et changer de chambre'>".$ret1['nomch']."</a></td>	
											<td align='center'>"; if($sal!=1) echo " <a id='container' class='container' href='loccup1.php?numfiche=".$ret1['numfiche']."' style='color:black;text-decoration:none;' title='Changer le type'>".$typeoccup=ucfirst($ret1['typeoccup'])."</a>"; 
											 else echo $motifsejoiur=ucfirst($ret1['motifsejoiur']); }
											 else{
											 echo"<td align='center'>".$ret1['codesalle'].$ret1['nomch']."</td>	
											<td align='center'>"; if($sal!=1) echo $typeoccup=ucfirst($ret1['typeoccup']); 
											 else echo $motifsejoiur=ucfirst($ret1['motifsejoiur']);}
											 echo"</td>											 
											<td align=''>". $ret1['adresse']."</td>
											<td align='center'>";
												$n=round((strtotime(date('Y-m-d'))-strtotime($ret1['datarriv']))/86400);
												$dat=(date('H')+1); 
												settype($dat,"integer");
												if ($dat<14){$n=$n;}else {$n= $n+1;}
												if ($n==0){$n= $n+1;} $n=(int)$n;
												$mt=$ret1['ttc_fixe']*$n; 
												echo $mt;  
											echo"</td>"; $var1=$ret1['somme'] ;
											echo"<td align='center'>"; echo $ret1['somme']; echo  "</td>";
											 $var = $mt-$var1;
									 if($var<=0) {echo"<td align='center' style='' >"; echo $var;echo"</td>";}
									 else {echo"<td align='center' style='background-color:red;'>"; echo $var;echo"</td>";}
									echo"</tr>";
									$i=$i+1;  
						} 
					?> 
					</table>
				</td> 
			</tr> 
		</table> 
	</body>
</html> 