<?php
	include 'menu.php';
	$sal=!empty($_GET['sal'])?$_GET['sal']:NULL;
	$trie=!empty($_GET['trie'])?$_GET['trie']:NULL;
	mysqli_query($con,"SET NAMES 'utf8'");
	if($sal==1)
	$re=mysqli_query($con,"SELECT * FROM salle,location,compte1,client WHERE salle.numsalle=compte1.numsalle AND location.numcli=client.numcli AND location.numfiche=compte1.numfiche AND location.etatsortie='NON'");
	else
	$re=mysqli_query($con,"SELECT * FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON'  ORDER BY nomch ASC");
	$query_Recordset1 = "SELECT * FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.EtatChambre='active' AND chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON'   ORDER BY $trie ASC";

		if(isset($_POST['SUPPRIMER']) && !empty($_POST['choix'])){
		//on déclare une variable
		$choix ='';
		//on boucle
		for ($i=0;$i<count($_POST['choix']);$i++)
		{
		$choix .= $_POST['choix'][$i].'|';
		$explore = explode('|',$choix);
		}
		 foreach($explore as $valeur){
			if(!empty($valeur)){
			//echo $valeur.'<br/>';
			$_SESSION['edit12']=$valeur;
			if($i==1)
				{	//header('location:loccup2.php');
					$ras=mysqli_query($con,"SELECT * FROM fiche1,client,mensuel_compte,chambre WHERE chambre.numch=mensuel_compte.numch AND fiche1.numcli_1=client.numcli and fiche1.numfiche=mensuel_compte.numfiche and  etatsortie='NON' and nomch='".$valeur."'");
					$rat=mysqli_fetch_array($ras);
					$numfiche= $rat['numfiche']; $numch= $rat['numch'];
					if(($rat['somme']==0)&&($rat['due']==0))
						{
							$ras1=mysqli_query($con,"DELETE FROM fiche1 WHERE numfiche='$numfiche'");
							$ras2=mysqli_query($con,"DELETE FROM compte WHERE numfiche='$numfiche'");
							$ras3=mysqli_query($con,"DELETE FROM mensuel_fiche1 WHERE numfiche='$numfiche'");
							$ras4=mysqli_query($con,"DELETE FROM mensuel_compte WHERE numfiche='$numfiche'");
						}
					else
						{
							echo $msg='Vous ne pouvez pas supprimer une entrée dont le montant a déjà été encaissé. ';
						}


				}
			else
				{ echo $msg='Vous ne pouvez pas supprimer plus ';

			}
		}
	}
	$re=mysqli_query($con,"SELECT * FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON' ORDER BY nomch ASC");
}
	if(isset($_POST['LIBERER']) && !empty($_POST['choix'])){
		//on déclare une variable
		$choix ='';
		//on boucle
		for ($i=0;$i<count($_POST['choix']);$i++)
		{
		//on concatène
		//$choix .= $_POST['choix'][$i];
		$choix .= $_POST['choix'][$i].'|';
		$explore = explode('|',$choix);
		}
 		//echo $choix;
		 foreach($explore as $valeur){
			if(!empty($valeur)){
				//echo $valeur;
			//echo $valeur.'<br/>';
			//$_SESSION['edit12']=$valeur;
		/* 	if($i==1)
				{	header('location:loccup2.php');
				}
			else */
				//{
				$sql = "SELECT * FROM mensuel_fiche1,client,mensuel_compte,chambre WHERE chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli and mensuel_fiche1.numfiche=mensuel_compte.numfiche and  etatsortie='NON' and nomch='".$valeur."'";
				$ras=mysqli_query($con,$sql);
			  	$rat=mysqli_fetch_array($ras);
				$numfiche= $rat['numfiche']; $numch= $rat['numch'];

				$arrhes=$rat['somme']-($rat['ttc_fixe']*$rat['np']);

				if($arrhes>0) { $Rnp=$arrhes/$rat['ttc_fixe']; if(is_int($Rnp)) {
						echo "<script language='javascript'>";
						echo 'alertify.error("Vous devez d\'abord éditer la facture du client !");';
						echo "</script>";
					}
					exit();
				}

				//$heure=(date('H')) .":".date('i');
				//$date=date('Y-m-d');
				$date=$Jour_actuel;
				$heure=$Heure_actuelle;
				$s=mysqli_query($con,"SELECT * FROM mensuel_fiche1 WHERE numfiche='".$numfiche."'");$nbre_result=mysqli_num_rows($s);
 			   if($nbre_result>0)
			   { $fet1=mysqli_query($con,"UPDATE fiche1 SET datsortie='".$date."', heuresortie='".$heure."', etatsortie='OUI' WHERE numfiche='".$numfiche."'");
				 $fet2=mysqli_query($con,"UPDATE mensuel_fiche1 SET datsortie='".$date."', heuresortie='".$heure."', etatsortie='OUI' WHERE numfiche='".$numfiche."'");
				}
			   else {$req="UPDATE fiche1 SET datsortie='".$date."', heuresortie='".$heure."', etatsortie='OUI' WHERE numfiche='".$numfiche."'";
				     $fet1=mysqli_query($con,$req);
					 $fet2=mysqli_query($con,"UPDATE mensuel_fiche1 SET datsortie='".$date."', heuresortie='".$heure."', etatsortie='OUI' WHERE numfiche='".$numfiche."'");
					 $fe1="UPDATE view_fiche2 SET datsortie='".$date."', heuresortie='".$heure."', etatsortie='OUI' WHERE numfiche='".$numfiche."'";
				     $fet1=mysqli_query($con,$fe1);
				}
					$n=round((strtotime($Jour_actuel)-strtotime($rat['datarriv']))/86400);
					$dat=(date('H')+1);
					settype($dat,"integer");
					if ($dat<14){$n=$n;}else {$n= $n+1;}
					if ($n==0){$n= $n+1;} $n=(int)$n;
					$mt=$rat['ttc_fixe']*$n;
					$var1=$rat['somme'] ;
					$due = $mt-$var1;
					$N_reel=$n-$rat['np'] ;
			 $update = "UPDATE compte SET  due='".$due."',N_reel='".$N_reel."' WHERE CONVERT( `compte`.`numfiche` USING utf8 ) = '".$numfiche."' AND CONVERT( `compte`.`numch` USING utf8 ) = '$numch' LIMIT 1" ;
		    $fet1=mysqli_query($con,$update);
		    $fet2=mysqli_query($con,"UPDATE mensuel_compte SET  due='".$due."',N_reel='".$N_reel."' WHERE CONVERT( `mensuel_compte`.`numfiche` USING utf8 ) = '".$numfiche."' AND CONVERT( `mensuel_compte`.`numch` USING utf8 ) = '$numch' LIMIT 1" );

 				if(isset($numfiche)){
					$sql="SELECT numfiche AS numficheS FROM mensuel_compte where numfiche='".$numfiche."' and mensuel_compte.due=0";
					$query=mysqli_query($con,$sql);
					$data=mysqli_fetch_assoc($query);$numficheS= $data['numficheS'];
					//$query1=mysqli_query($con,"DELETE FROM  mensuel_fiche1 WHERE numfiche='".$numficheS."'");
					//$query2=mysqli_query($con,"DELETE FROM  mensuel_compte WHERE numfiche='".$numficheS."'");
					}


					$ok=1;

				//$fet1=mysqli_query($con,"DELETE FROM etat_facture WHERE numfiche='".$numfiche."'");

				//echo '<meta http-equiv="refresh" content="1; url=sortie.php?menuParent='.$_SESSION['menuParenT'].'" />';
			//}
		}


	}if(isset($ok) && ($ok==1)){
			echo "<script language='javascript'>";
			echo 'alertify.success("Chambre(s) libérée(s) avec succès !");';
			echo "</script>";
	}



	$re=mysqli_query($con,"SELECT * FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON' ORDER BY nomch ASC");
}
	else{
		//echo 'Sélectionner un choix!';
	}
?>
<html>
	<head>
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width">
		<style>
		.alertify-log-custom {
				background: blue;
			}
		#lien1:hover {
			text-decoration:underline;background-color: gold;font-size:1.1em;
		}
		.bouton2 {
			border-radius:12px 0 12px 0;
			background: white;
			border:2px solid #B1221C;
			color:#B1221C;
			font:bold 12px Verdana;
			height:auto;font-family:cambria;font-size:0.9em;
		}
		.bouton2:hover{color:white;
			cursor:pointer;background-color: #B1221C;border:2px solid #B1221C;
		}
		</style>
	</head>
	<div align="" style="margin-top:-25px;">
	<form name="sortie.php" method="post">
		<table align='center'>
			<tr>
				<td><hr noshade size=3> <div align="center"><B>
				
					<FONT SIZE=6 COLOR="Maroon"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; LISTE JOURNALIERE <?php if($sal==1) echo"DES OCCUPATIONS DE SALLES"; else echo"DES OCCUPANTS "; ?> </FONT></B><B> <span style='font-style:italic;'>(En date du <?php echo gmdate('d-m-Y');?>)</span></B>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
					<FONT SIZE=4 COLOR="0000FF"> </FONT> 
					<input type='submit' name='<?php  echo "CHECK OUT";   ?>' value='<?php echo "CHECK OUT";  ?>' <?php echo 'onclick="if(!confirm(\'Cette action est irréversible. Voulez-vous vraiment continuer?\')) return false;"'; ?>  style='float:right;border:2px solid black;font-weight:bold;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'<?php echo 'onclick="if(!confirm(\'Voulez-vous vraiment continuer?\')) return false;"'; ?>>
					</div> <hr noshade size=3>
				</td>
			</tr>
			<tr>
				<td>
					<table  border='1' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>

						<tr bgcolor='<?php if($_SESSION['poste']=="agent") echo "#CD5C5C"; else echo "black";?>'align="center" <?php if($_SESSION['poste']!="agent") echo "style='color:white;'";?>>
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
							<td> &nbsp;&nbsp;&nbsp;✔&nbsp;&nbsp;&nbsp; </td>
						</tr>
					<?php
						$i=1; $cpteur=1;
						while($ret1=mysqli_fetch_array($re))
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
										$n=round((strtotime($Jour_actuel)-strtotime($ret1['datarriv']))/86400);
										$dat=(date('H')+1);
										settype($dat,"integer");
										if ($dat<14){$n=$n;}else {$n= $n+1;}
										if ($n==0){$n= $n+1;} $n=(int)$n;
										$mt=$ret1['ttc_fixe']*$n;
										$due = $mt-$ret1['somme']; if($due<0) $due=-$due;


										if($ret1['codegrpe']!='')
										{//Ici, pour un groupe en impayés, on va selectionner ce qu'il devait et on additionne à ce qu'il doit à la date du jour
										$sql2=mysqli_query($con,"SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,
										view_client.prenomcli AS prenom2, chambre.nomch, compte.tarif, compte.ttc_fixe, compte.typeoccup, fiche1.datarriv,compte.nuite,compte.np,compte.due AS due
										FROM client, fiche1, chambre, compte, view_client
										WHERE fiche1.numcli_1 = client.numcli
										AND fiche1.numcli_2 = view_client.numcli
										AND fiche1.codegrpe = '".$ret1['codegrpe']."'
										AND chambre.numch = compte.numch
										AND compte.numfiche = fiche1.numfiche
										AND fiche1.etatsortie = 'OUI' AND compte.due>0
										LIMIT 0 , 30");
										$somme_due=0;$datarriv=array("");
										while($row=mysqli_fetch_array($sql2))
											{  	//$N_reel=$row['N_reel'];
												$due2=$row['due'];//$ttc=$row['ttc'];
												//if($datarriv==$row['datarriv'])
												$somme_due+=$due2;
												//$i++;
											}
										}
										if(!empty($somme_due))
										$due=$due+$somme_due;

										echo"<tr class='rouge1' bgcolor='".$bgcouleur."'>";?>

											<?php
											//if($_SESSION['poste']=="agent")
											//{
											echo"<td align='center'>";
											if($ret1['codegrpe']!='') echo substr($ret1['numfiche'],0,8);
											else echo "&nbsp;".$ret1['numfiche'];
											echo "</td>";
											echo"<td align=''>&nbsp;&nbsp;&nbsp;&nbsp;";
											echo substr($ret1['nomcli'],0,25).'	'.substr($ret1['prenomcli'],0,25)."</a>";
											echo"</td>";
											if($sal!=1)
												{ if(!empty($somme_due)) {echo"<td align='center'>"; if($ret1['codegrpe']!='') echo " <a href='encaissement.php?codegrpe=".$ret1['codegrpe']."&impaye=1' style='color:#800012;text-decoration:none;' title='Encaisser pour&nbsp;:&nbsp;&nbsp;".$ret1['codegrpe']."(+Impayé:&nbsp;".$somme_due.")'>".$ret1['codegrpe']."</a>"; else echo" - "; echo  "</td>";}
												else{ echo"<td align='center'>"; if($ret1['codegrpe']!='') echo $ret1['codegrpe']; else echo" - "; echo  "</td>";}
												}
											else
												{echo"<td align='center'>"; if($ret1['codegrpe']!='') { echo $ret1['codegrpe'];} else echo" - "; echo  "</td>";}
											//}
											//else
											//{
											//echo"<td align=''>"; echo " <a id='container' class='container' href='"; echo "reajuster.php?"; if($sal!=1) echo"fiche=1"; else echo"sal=1"; echo "&numfiche=".$ret1['numfiche']."&due=".$due."&somme=".$ret1['somme']."'  title='Réajustement du séjour&nbsp;&nbsp;&nbsp;"; echo"' style='text-decoration:none;color:#800000;'>".substr($ret1['numfiche'],0,8)."</a>"; echo "</td>";
											//echo"<td align=''>&nbsp;&nbsp;&nbsp;&nbsp;"; echo " <a  "; echo"style='color:black;text-decoration:none;' title='Réajustement du séjour'>".substr($ret1['nomcli'],0,25).'	'.substr($ret1['prenomcli'],0,25)."</a>"; echo"</td>";
											//echo"<td align='center'>"; if($ret1['codegrpe']!='') { echo $ret1['codegrpe'];} else echo" - "; echo  "</td>";
											//}
											echo"<td align=''>"; echo "&nbsp;".$ret1['numiden']; echo"</td>";
											echo"<td align='center' "; if($n>=15) echo "style=''"; echo ">"; echo "&nbsp;".substr($ret1['datarriv'],8,2).'-'.substr($ret1['datarriv'],5,2).'-'.substr($ret1['datarriv'],0,4); echo "</td>";
											echo"<td align='center'";  if($n>=15) echo " style=''"; echo">"; echo "&nbsp;".substr($ret1['datsortie'],8,2).'-'.substr($ret1['datsortie'],5,2).'-'.substr($ret1['datsortie'],0,4); echo"</td>";
											if($_SESSION['poste']=="agent")
											{echo"<td align='center'>".$ret1['nomch']."</a></td>
											<td align='center'>"; if($sal!=1) echo $typeoccup=ucfirst($ret1['typeoccup']);
											 else echo $motifsejoiur=ucfirst($ret1['motifsejoiur']); }
											 else{
											 echo"<td align='center'>"; if(isset($ret1['codesalle'])) echo $ret1['codesalle']; if(isset($ret1['nomch'])) echo $ret1['nomch']; echo"</td>
											<td align='center'>"; if($sal!=1) echo $typeoccup=ucfirst($ret1['typeoccup']);
											 else echo $motifsejoiur=ucfirst($ret1['motifsejoiur']);}
											 echo"</td>
											<td align=''>&nbsp;". $ret1['adresse']."</td>
											<td align='center'>";
												$n=round((strtotime($Jour_actuel)-strtotime($ret1['datarriv']))/86400);
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
									 else {echo"<td align='center' style='background-color:red;'>"; echo $var;echo"</td>";}   ?>

									 <td align='center'>
									<input type="checkbox" name="choix[]" value="<?php if(isset($ret1['nomch'])) echo $ret1['nomch']; ?>"/>
									</td>

									<?php
									echo"</tr>";
									$i=$i+1;
							if($n>=15) $trouver=1;
						}
					?>
					</table>
				</td>
			</tr>
		</table>
		 </form>
		 </div>
	</body>
</html>
