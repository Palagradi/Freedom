<?php
	include 'menu.php';unset($_SESSION['debuti']); unset($_SESSION['view']); unset($_SESSION['cham']); unset($_SESSION['Nbre']); $_SESSION['Visualiser']=0;$_SESSION['pop']=0;
	unset($_SESSION['HT_connexe']);unset($_SESSION['pourcent']);unset($_SESSION['sal']);unset($_SESSION['NuitePayee']);unset($_SESSION['Fconnexe']);unset($_SESSION['reference']);
	$_SESSION['vendeur']=$_SESSION['nom']." ".ucfirst(strtolower($_SESSION['prenom'])); unset($_SESSION['client']);unset($_SESSION['Fusion']);
	unset($_SESSION['NumIFU']);unset($_SESSION['AdresseClt']);unset($_SESSION['TelClt']);unset($_SESSION['impaye']);unset($_SESSION['Foriginal1']);unset($_SESSION['Foriginal2']);
	unset($_SESSION['groupe1']);unset($_SESSION['groupe']);unset($_SESSION['num']);unset($_SESSION['client']);unset($_SESSION['date_emission']);unset($_SESSION['numrecu']);unset($_SESSION['numrecu']);unset($_SESSION['Nd']);
	unset($_SESSION['req1']);unset($_SESSION['req2']);unset($_SESSION['retro']);unset($_SESSION['Apply_AIB']);
	unset($_SESSION['DT_HEURE_MCF']);unset($_SESSION['QRCODE_MCF']);unset($_SESSION['SIGNATURE_MCF']);unset($_SESSION['COMPTEUR_MCF']);unset($_SESSION['NIM_MCF']);
	$sal=!empty($_GET['sal'])?$_GET['sal']:0;
	$trie=!empty($_GET['trie'])?$_GET['trie']:NULL; $EtatG=!empty($_GET['EtatG'])?$_GET['EtatG']:NULL; unset($_SESSION['ValAIB']);unset($_SESSION['PourcentAIB']);
	$del=mysqli_query($con,"delete  FROM table_tempon");
	mysqli_query($con,"SET NAMES 'utf8'");
	unset( $_SESSION['remise']); unset($_SESSION['recufiche']); unset($_SESSION['Numreserv']); unset($_SESSION['button_checkbox_2']); unset($_SESSION['button_checkbox_3']);
	if((!empty($_GET['impaye'])&&$_GET['impaye']==1)){
	echo "<script language='javascript'>";
		echo 'alertify.error("Encaissement impossible. Ce groupe est déjà en Impayé!");';
		echo "</script>";
	}

	$query="DELETE FROM produitsencours  WHERE `Etat` = '4'";    //echo $_SESSION['userId'];
	$res1=mysqli_query($con,$query);

	if($sal==1)
		 $query_Recordset1="SELECT DISTINCT compte1.numfiche,DATEDIFF('".$Jour_actuel."',datarriv) AS DiffDate,Periode,datdep,datarriv,ttc_fixe,ttc_fixeR,compte1.numfiche,codegrpe,Avertissement,somme,np,location.numcli,nomcli,prenomcli,ttva,codesalle,typeoccup,motifsejoiur,numiden,heuresortie,datsortie,Telephone FROM salle,location,compte1,client 
	  WHERE 
	  salle.numsalle=compte1.numsalle AND (location.numcli=client.numcli OR location.numcli=client.numcliS ) AND location.numfiche=compte1.numfiche AND location.etatsortie='NON'";
	else
		{//$re=mysqli_query($con,"SELECT * FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON'   ORDER BY nomch ASC");
		 if($EtatG%2==0)  $ordre="ASC"; else $ordre="DESC";
		 if($trie=='')
			   $query_Recordset1 = "SELECT DATEDIFF('".$Jour_actuel."',datarriv) AS DiffDate,Periode,datdep,datarriv,ttc_fixe,ttc_fixeR,mensuel_compte.numfiche,codegrpe,Avertissement,somme,np,mensuel_fiche1.numcli_1 AS numcli,mensuel_fiche1.numcli_2,nomcli,prenomcli,ttva,typeoccup,motifsejoiur,nomch,numiden,heuresortie,datsortie,Telephone FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.EtatChambre='active' AND chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON'   ORDER BY mensuel_fiche1.numfiche ASC";
		  else
		      $query_Recordset1 = "SELECT DATEDIFF('".$Jour_actuel."',datarriv) AS DiffDate,Periode,datdep,datarriv,ttc_fixe,ttc_fixeR,mensuel_compte.numfiche,codegrpe,Avertissement,somme,np,mensuel_fiche1.numcli_1 AS numcli,mensuel_fiche1.numcli_2,nomcli,prenomcli,ttva,typeoccup,motifsejoiur,nomch,numiden,heuresortie,datsortie,Telephone FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.EtatChambre='active' AND chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON'   ORDER BY $trie $ordre";
		}

		$re=mysqli_query($con,$query_Recordset1);

	$res=mysqli_query($con,"DROP TABLE `table_tempon`");
	$d=date("d/m/Y", mktime(0,0,0,date("m"),date("d")-40,date("Y")));
	$d2=date("Y-m-d", mktime(0,0,0,date("m"),date("d")-40,date("Y")));
	$query=mysqli_query($con,"DELETE FROM mensuel_encaissement  WHERE datencaiss < 'd' AND ref NOT IN (Select numfiche FROM mensuel_fiche1 WHERE etatsortie ='NON') AND ref NOT IN (Select numfiche FROM mensuel_compte WHERE due <> 0)");
	$query=mysqli_query($con,"DELETE FROM mensuel_fiche1  WHERE etatsortie <> 'NON' AND datsortie <'d2' AND numfiche NOT IN (Select numfiche from mensuel_compte WHERE due <> 0 ) ");
	$query=mysqli_query($con,"DELETE FROM mensuel_compte  WHERE due = 0 AND numfiche NOT IN (Select numfiche FROM mensuel_fiche1 ) ");

	//ECHO "SELECT * FROM chambre,fiche1,compte,client WHERE chambre.numch=compte.numch AND fiche1.numcli_1=client.numcli AND fiche1.numfiche=compte.numfiche AND fiche1.etatsortie='NON'  ORDER BY nomch ASC";
/* 	if(date('d')>=25){
	$ref=mysqli_query($con,"SELECT  mensuel_fiche1.numfiche AS numfiche from mensuel_fiche1,mensuel_compte where mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_compte.due=0 AND mensuel_fiche1.etatsortie='OUI'");
		while($data=mysql_fetch_array($ref))
		{$query=mysqli_query($con,"DELETE FROM mensuel_fiche1  WHERE numfiche='".$data['numfiche']."'");
		 $query=mysqli_query($con,"DELETE FROM mensuel_compte  WHERE numfiche='".$data['numfiche']."'");
		}
	$ref=mysqli_query($con,"SELECT  mensuel_fiche1.numfiche AS numfiche from mensuel_fiche1,mensuel_compte where mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_compte.due=0 AND mensuel_fiche1.etatsortie='RAS'");
		while($data2=mysql_fetch_array($ref))
		{$query=mysqli_query($con,"DELETE FROM mensuel_fiche1  WHERE numfiche='".$data2['numfiche']."'");
		 $query=mysqli_query($con,"DELETE FROM mensuel_compte  WHERE numfiche='".$data2['numfiche']."'");
		}
	$ref=mysqli_query($con,"DELETE  FROM `mensuel_compte` WHERE numfiche NOT IN (SELECT numfiche from mensuel_fiche1)");
	} */
	//$etatGet=1;

	?>
<html>
	<head>

	<script src="js/sweetalert.min.js"></script>
		<style>
			.alertify-log-custom {
				background: blue;
			}
			td {
			  padding: 8px 0;
			}
		</style>
	</head>
	<body style='background-color:peachpuff;'>

	<div align="" style="margin-top:-25px;">
		<table align='center'>
			<tr>
				<td>
					<hr noshade size=3> <div align="center"><B>

					<FONT SIZE=6 COLOR="Maroon"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; LISTE JOURNALIERE <?php if($sal==1) echo"DES OCCUPATIONS DE SALLES"; else echo"DES OCCUPANTS "; ?> </FONT></B><B> <span style='font-style:italic;'>(En date du <?php echo $Date_actuel2; //echo gmdate('d-m-Y');?>)</span></B>
					<FONT SIZE=4 COLOR="0000FF"> </FONT> </div> <hr noshade size=3>
				</td>
			</tr>
			<tr>
				<td>
					<table  border='1' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>

						<tr bgcolor='<?php echo "#CD5C5C"; ?>'align="center" style='font-weight:normal;'>
							<a href="" >
							<td> N° d'ordre</td>
							<td><a class='info1' href='loccup.php?menuParent=Consultation&trie=mensuel_fiche1.numfiche&etatget=<?php   if(!empty($_GET['etatget'])&&($_GET['trie']=='mensuel_fiche1.numfiche')) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget;?>&EtatG=<?php echo $etatget; ?>' style='text-decoration:none;color:black;' title=''> <span>Trier par Numéro fiche</span> N° FICHE</a></td>
							<td ><a class='info1' href='loccup.php?menuParent=Consultation&trie=nomcli&etatget=<?php  if(!empty($_GET['etatget'])&&($_GET['trie']=='nomcli')) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget;?>&EtatG=<?php echo $etatget; ?>' style='text-decoration:none;color:black;' title=''> <span>Trier par Nom</span> NOM ET PRENOMS</a> </td>
							<td ><a class='info1' href='loccup.php?menuParent=Consultation&trie=codegrpe&etatget=<?php  if(!empty($_GET['etatget'])&&($_GET['trie']=='codegrpe')) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget;?>&EtatG=<?php echo $etatget; ?>' style='text-decoration:none;color:black;' title=''>  <span>Trier par groupe</span>NOM DU GROUPE</a></td>
							<td><a class='info1' href='loccup.php?menuParent=Consultation&trie=numiden&etatget=<?php  if(!empty($_GET['etatget'])&&($_GET['trie']=='numiden')) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget;?>&EtatG=<?php echo $etatget; ?>' style='text-decoration:none;color:black;' title=''> <span>Trier par Numéro pièce</span> PIECE N°</a></td>
							<td> <a class='info1' href='loccup.php?menuParent=Consultation&trie=datarriv&etatget=<?php  if(!empty($_GET['etatget'])&&($_GET['trie']=='datarriv')) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget;?>&EtatG=<?php echo $etatget; ?>' style='text-decoration:none;color:black;' title=''> <span>Trier par Date arrivée</span>DATE D'ARRIVEE </a></td>
							<td> <a class='info1' href='loccup.php?menuParent=Consultation&trie=datdep&etatget=<?php  if(!empty($_GET['etatget'])&&($_GET['trie']=='datdep')) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget;?>&EtatG=<?php echo $etatget; ?>' style='text-decoration:none;color:black;' title=''> <span>Trier par Date départ</span>DATE DE DEPART </a></td>
							<td> <?php if($sal==1) echo "SALLE"; else {echo " <a class='info1' href='loccup.php?menuParent=Consultation&trie=nomch&etatget=";  if(!empty($_GET['etatget'])&&($_GET['trie']=='nomch')) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget."&EtatG="; echo $etatget;   echo"' style='text-decoration:none;color:black;' title=''><span>Trier par chambre</span>CHAMBRE</a>";}?> </td>
							<td> <?php if($sal==1) echo "MOTIF DE LA LOCATION"; else {echo " <a class='info1' href='loccup.php?menuParent=Consultation&trie=typeoccup&etatget=";  if(!empty($_GET['etatget'])&&($_GET['trie']=='typeoccup')) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget."&EtatG="; echo $etatget;   echo" ' style='text-decoration:none;color:black;' title=''> <span>Trier par Type Chambre</span>TYPE OCCUPATION</a>";}?> </td>
							<td> <a class='info1' href='loccup.php?menuParent=Consultation&trie=adresse&etatget=<?php  if(!empty($_GET['etatget'])&&($_GET['trie']=='adresse')) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget;?>&EtatG=<?php echo $etatget; ?>' style='text-decoration:none;color:black;' title=''>  <span>Trier par Contact</span>CONTACT</a></td>
							<td> MONTANT</td>
							<td>SOMME PAYEE</td>
							<td> SOMME DUE</td>
							</a>
						</tr>

					<?php
						$i=1; $k=0; $cpteur=1;$trouver=0;
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
										if($ret1['datdep']!=$ret1['datsortie'])
										{
											$sql="UPDATE mensuel_fiche1 SET datdep='".$ret1['datsortie']."' WHERE numfiche='".$ret1['numfiche']."'";
											$fet2=mysqli_query($con,$sql);
										}

										$n=round((strtotime($Jour_actuel)-strtotime($ret1['datarriv']))/86400);
										$dat=(date('H')+1);
										settype($dat,"integer");
										if(!isset($_SESSION['sal'])){
											if ($dat<14){$n=$n;}else {$n= $n+1;}
											if ($n==0){$n= $n+1;}
										}else {
											$n= $n+1;
										}
										$n=(int)$n;

										if($sal==1) $n=($ret1['DiffDate']>0)?$ret1['DiffDate']:1;

										$k++;

										if($ret1['ttc_fixeR']>0) $mt=$ret1['ttc_fixeR']*$n;  else $mt=$ret1['ttc_fixe']*$n;
										$due = $mt-$ret1['somme']; //if($due<0) $due=-$due;
										$second="";
										$query_RecordsetS="SELECT numcli_1, numcli_2 FROM fiche1 WHERE numfiche='".$ret1['numfiche']."'";
										$RecordsetS = mysqli_query($con,$query_RecordsetS) or die(mysqli_error($con));
										$row_RecordsetS = mysqli_fetch_assoc($RecordsetS); $numcli_1=$row_RecordsetS['numcli_1'];$numcli_2=$row_RecordsetS['numcli_2'];
										if($numcli_1!=$numcli_2)
										{$query_RecordsetC="SELECT nomcli, prenomcli FROM client WHERE numcli='".$numcli_2."'";
										 $RecordsetC = mysqli_query($con,$query_RecordsetC) or die(mysqli_error($con));
										 $row_RecordsetC = mysqli_fetch_assoc($RecordsetC); $second=$row_RecordsetC['nomcli']." ".substr($row_RecordsetC['prenomcli'],0,25); $Numclt=isset($numcli_1)?$numcli_1:$numcli_2;
										}
										if(!empty($ret1['codegrpe']))
										{//Ici, pour un groupe en impayés, on va selectionner ce qu'il devait et on additionne à ce qu'il doit à la date du jour
										//echo "<br/>";
										$req="SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,
										view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif,mensuel_compte.ttc_fixeR,mensuel_compte.ttc_fixe,mensuel_compte.typeoccup,mensuel_fiche1.datarriv,mensuel_compte.nuite,mensuel_compte.np,mensuel_compte.due AS due
										FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
										WHERE chambre.EtatChambre='active' AND mensuel_fiche1.numcli_1 = client.numcli
										AND mensuel_fiche1.numcli_2 = view_client.numcli
										AND mensuel_fiche1.codegrpe = '".$ret1['codegrpe']."' AND mensuel_fiche1.numfiche='".$ret1['numfiche']."' AND chambre.numch = mensuel_compte.numch
										AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
										AND mensuel_fiche1.etatsortie = 'OUI' AND mensuel_compte.due>0
										LIMIT 0 , 30";
										$sql2=mysqli_query($con,$req);
										$somme_due=0;$datarriv=array("");
										while($row=mysqli_fetch_array($sql2))
											{  	//$N_reel=$row['N_reel'];
												$due2=$row['due'];$ttc=$row['ttc'];
												//if($datarriv==$row['datarriv'])
												$somme_due+=$due2;
												//$i++;
											}
										}
										if(isset($somme_due)&&($somme_due>0))
										$due=$due+$somme_due;
										if((($n>15)||(($n==15)&&(date('H')>=14)))&&($ret1['Avertissement']!='OUI_D')) //Sortie automatique à partir de 12H:00
											{$date=date('Y-m-d');$heure=(date('H')) .":".date('i');
											 $fe="UPDATE fiche1 SET datsortie='".$date."', heuresortie='".$heure."', etatsortie='OUI',Avertissement='OUI' WHERE numfiche='".$ret1['numfiche']."'"; //echo "<br/>";
											 //$fet=mysqli_query($con,$fe);
											 $fe="UPDATE mensuel_fiche1 SET datsortie='".$date."', heuresortie='".$heure."', etatsortie='OUI',Avertissement='OUI' WHERE numfiche='".$ret1['numfiche']."'"; //echo "<br/>";
											 //$fet=mysqli_query($con,$fe);
											 $fe="UPDATE view_fiche2 SET datsortie='".$date."', heuresortie='".$heure."', etatsortie='OUI',Avertissement='OUI' WHERE numfiche='".$ret1['numfiche']."'"; //echo "<br/>";
											 //$fet=mysqli_query($con,$fe);
											 $fe="UPDATE mensuel_view_fiche2 SET datsortie='".$date."', heuresortie='".$heure."', etatsortie='OUI',Avertissement='OUI' WHERE numfiche='".$ret1['numfiche']."'"; //echo "<br/>";
											 //$fet=mysqli_query($con,$fe);
											$n=round((strtotime($Jour_actuel)-strtotime($ret1['datarriv']))/86400);
											$dat=(date('H')+1);
											settype($dat,"integer");
											if ($dat<14){$n=$n;}else {$n= $n+1;}
											if ($n==0){$n= $n+1;} $n=(int)$n;
											if($sal==1) $n=($ret1['DiffDate']>0)?$ret1['DiffDate']:1;
											if($ret1['ttc_fixeR']>0) $mT=$ret1['ttc_fixeR']*$n; else $mT=$ret1['ttc_fixe']*$n;
											$var2=$ret1['somme'] ;
											$due = $mT-$var2;
											$N_reel=$n-$ret1['np'] ;
											//$fe1="UPDATE compte SET  due='".$due."',N_reel='".$N_reel."' WHERE CONVERT( `compte`.`numfiche` USING utf8 ) = '".$numfiche2."' " ;
											//$fet1=mysqli_query($con,$fe1);
											//$fe1="UPDATE mensuel_compte SET  due='".$due."',N_reel='".$N_reel."' WHERE CONVERT( `compte`.`numfiche` USING utf8 ) = '".$numfiche2."' " ;
											//$fet1=mysqli_query($con,$fe1);
											}
										echo"<tr class='rouge1' bgcolor='".$bgcouleur."'>";
										//echo '<tr bgcolor="'.$bgcouleur.'" class="maclass" onmouserover="this.style.background-color: red;" onmouseout="this.style.background-color: inherit;"></tr>';
											echo"<td align='center'>"; echo $k;  echo ".</td>";
											if($_SESSION['poste']=="agent")
											{$value=($ret1['ttc_fixe']*$n-$ret1['somme'])/$ret1['ttc_fixe'];
											echo"<td align=''>"; //echo "<a href='#' class='info'>Wi-Fi<span>contraction de Wireless Fidelity</span></a>";
											if($Encaisser==1){
											echo " <a id='container' class='info' id='container2' href='";
											  if(!empty($ret1['codegrpe'])) echo "#"; else {

											echo "encaissement.php?menuParent=Consultation&";

											if($sal!=1) echo "fiche=1"; else echo "sal=1";    //if(isset($Numclt)) echo "&Numclt=".$Numclt;   //Commentaire du 12.01.2022

											echo "&solde=1&numfiche=".$ret1['numfiche']."&Numclt=".$ret1['numcli']."&due=".$due."&somme=".$ret1['somme']."&Mtotal=".$mt."&n=".(int)$value."&np=".$ret1['np']."&typeoccup=".$ret1['typeoccup']."&client=".$ret1['nomcli']."&nbsp;".$ret1['prenomcli']; echo "&ttva=".$ret1['ttva']; echo "&Periode=".$ret1['Periode'];
											  }
											  echo "'>";
											}
											echo " &nbsp;".$ret1['numfiche'];
											if($Encaisser==1) { 
												if(empty($ret1['codegrpe'])) echo "<span> Encaisser pour le compte du client&nbsp;&nbsp;&nbsp;<span style='color:red;'>✔ ".$ret1['nomcli']."&nbsp;".$ret1['prenomcli']."</span>";
												echo "&nbsp; </span></a>";
											}
											echo "</td>";

									/* 		echo "'>".$ret1['numfiche'];
											if((!empty($ret1['codegrpe'])&&($sal!=1))||($sal==1)) {} else
											echo "<span>Encaisser pour le compte du client&nbsp;&nbsp;&nbsp;<span style='color:red;'>".$ret1['nomcli']."&nbsp;".$ret1['prenomcli'];
											  echo "</span></span>";} echo "</a>"; echo "</td>"; */

											echo"<td align=''>&nbsp;&nbsp;&nbsp;&nbsp;"; echo " <a  "; if(isset($_GET['sal'])) $direction="ficheS.php"; else $direction="fiche.php";
											echo "id='container2' class='info' id='container2'"; echo " href='".$direction."?menuParent=Consultation&numfiche=".$ret1['numfiche']."&change=1"; if(isset($_GET['sal'])) echo "&sal=".$_GET['sal']; echo "&Periode=".$ret1['Periode']; echo "' style='color:black;text-decoration:none;' title=''>".substr(trim($ret1['nomcli']),0,25).'	'.substr($ret1['prenomcli'],0,25)."<span>";
											    if(empty($second)&&($second=="")) { echo "<font style='color:red;'>✔ </font>Changer le Nom "; if($sal==1) echo "du locataire"; else "de l'occupant"; }else echo "✔ Nom du Second occupant&nbsp; <span style='color:red;'>".$second."</span> </span></a>"; echo"</td>";
											if($sal!=1)
												{ if(!empty($somme_due)) {echo"<td align='center'>"; if(!empty($ret1['codegrpe'])) echo " <a class='info' href='loccup.php?menuParent=Consultation&impaye=1' style='color:#800012;text-decoration:none;'
												title=''><span style='font-size:0.9em;color:red;'>&nbsp;&nbsp;".$ret1['codegrpe']."(+Impayé:&nbsp;".$somme_due.") </span> ".$ret1['codegrpe']."</a>"; else echo " - "; echo  "</td>";}
												else{ echo"<td align='center'>"; 
												if($ret1['codegrpe']!='')  {
													if($Encaisser==1) echo " <a  id='container' class='info' href='encaissement2.php?menuParent=Consultation&solde=1&codegrpe=".$ret1['codegrpe']."&Arrivee=".$ret1['datarriv']."&Periode=".$ret1['Periode']."' style='color:#800012;text-decoration:none;' title=''>";
												echo $ret1['codegrpe']; 
													if($Encaisser==1) echo "<span>Encaisser pour le compte du groupe&nbsp;&nbsp;&nbsp;<span style='color:red;'> ✔ ".$ret1['codegrpe']."</span></span></a>";
												}
												else { 
												if(($sal==0)&&($conversion0==1)) { ?>
												<a href='popup2.php?numfiche=<?php echo $ret1['numfiche']."&client=".trim($ret1['nomcli']).' '.$ret1['prenomcli']; echo "&sal=".$sal;?>' class='info3' style='text-decoration:none;' onclick="window.open(this.href, 'Formulaire pour ajout de Frais Connexes ','target=_parent, height=400, width=750, top=180, left=250, color=black, toolbar=no, menubar=no, location=no, resizable=no, scrollbars=no, status=no'); return false" >
												<span style='color:red;'>Réconversion en Hébergement groupé</span><i style='color:green;' class='fas fa-american-sign-language-interpreting'></i></a>
												<?php } } echo  "</td>";}
												}
											else
												{	 echo"<td align='center'>"; if($ret1['codegrpe']!='') echo " <a  id='container' class='info' href='encaissement2.php?sal=1&menuParent=Consultation&solde=1&codegrpe=".$ret1['codegrpe']."&Arrivee=".$ret1['datarriv']."&Periode=".$ret1['Periode']."' style='color:#800012;text-decoration:none;' title=''> 
													<span>Encaisser pour le groupe&nbsp;&nbsp;&nbsp;<center style='color:red;'>".$ret1['codegrpe']."</center></span>  ".$ret1['codegrpe']."</a>"; 
													else {
													if(($sal==1)&&($conversion1==1)) { ?>
													<a href='popup2.php?numfiche=<?php echo $ret1['numfiche']."&client=".trim($ret1['nomcli']).' '.$ret1['prenomcli']; echo "&sal=".$sal;?>' class='info3' style='text-decoration:none;' onclick="window.open(this.href, 'Formulaire pour ajout de Frais Connexes ','target=_parent, height=400, width=750, top=180, left=250, color=black, toolbar=no, menubar=no, location=no, resizable=no, scrollbars=no, status=no'); return false" >
													<span style='color:red;'>Réconversion en Location groupée</span><i style='color:green;' class='fas fa-american-sign-language-interpreting'></i></a>
													<?php } 
													}
													echo  "</td>";
													}
											} //Quand l'administrateur se connecte. ACCES -> CONSULTATION
											else
											{echo"<td align=''>"; echo " <a id='container' class='container' href='"; echo "#"; if($sal!=1) echo"fiche=1"; else echo"sal=1"; echo "&numfiche=".$ret1['numfiche']."&due=".$due."&somme=".$ret1['somme']."'  title='&nbsp;&nbsp;&nbsp;"; echo"' style='text-decoration:none;color:#800000;'>".substr($ret1['numfiche'],0,8)."</a>"; echo "</td>";
											echo"<td align=''>&nbsp;&nbsp;&nbsp;&nbsp;"; echo " <a  "; echo"style='color:black;text-decoration:none;' title='Réajustement du séjour'>".substr($ret1['nomcli'],0,25).'	'.substr($ret1['prenomcli'],0,25)."</a>"; echo"</td>";
											echo"<td align='center'>"; if($ret1['codegrpe']!='') { echo $ret1['codegrpe'];} else echo " - "; echo  "</td>";
											}
											echo"<td align=''>"; echo $ret1['numiden']; echo"</td>";
											echo"<td align='center' "; if(($n>=15)&&($ret1['Avertissement']!='OUI_D'))  echo "style='color:#DE2623;'"; echo ">&nbsp;"; echo "<a class='info' href='#' style='text-decoration:none;color:black;' title='' >". substr($ret1['datarriv'],8,2).'-'.substr($ret1['datarriv'],5,2).'-'.substr($ret1['datarriv'],0,4); echo "&nbsp;<span>
											Heure"; if($sal==1)  echo " d'enrégistrement"; else echo " d'arrivée";
											echo "&nbsp;<span style='color:red;'><font style='color:green;'>✔ </font> [".$ret1['heuresortie']."]</span</span></a></td>";
											echo"<td align='center'";  if(($n>=15)&&($ret1['Avertissement']!='OUI_D'))  echo " style='color:#DE2623;'"; echo">&nbsp;"; echo substr($ret1['datsortie'],8,2).'-'.substr($ret1['datsortie'],5,2).'-'.substr($ret1['datsortie'],0,4); echo"&nbsp;</td>";
											$codesalle=!empty($ret1['codesalle'])?$ret1['codesalle']:NULL;
											if($_SESSION['poste']=="agent")
											{
												echo"<td align='center'>";
												if($deloger==1)
												echo " <a class='info' id='container' class='container' href='deloger.php?menuParent=Consultation&numfiche=".$ret1['numfiche']."&sal=".$sal."' style='color:black;text-decoration:none;' title=''>";
												if($sal!=1) echo $ret1['nomch']; else echo $codesalle;
												echo "<span><font style='color:red;'>";
												if($deloger==1) { if($sal==1) echo "Changement de salle"; else echo "Déloger le Client";}
													else echo "✔ ";												
												echo "</font></span></a></td>
											<td align='center'>"; if($sal!=1) { echo " <a class='info' id='container' class='container' ";
											//href='changement_type.php?menuParent=Consultation&numfiche=".$ret1['numfiche']."'
											echo "href='#'";
											echo "style='color:black;text-decoration:none;' title=''>".$typeoccup=ucfirst($ret1['typeoccup']).
											"<span><font style='color:red;'>✔ </font> Changer le Type d'occupation</span></a>";}
											 else echo $motifsejoiur=ucfirst($ret1['motifsejoiur']); }
											 else{
											 echo"<td align='center'>";if(isset($ret1['codesalle'])) echo $ret1['codesalle']; if(isset($ret1['nomch']))  $ret1['nomch']; echo "</td>
											<td align='center'>"; if($sal!=1) echo $typeoccup=ucfirst($ret1['typeoccup']);
											 else echo $motifsejoiur=ucfirst($ret1['motifsejoiur']);}
											 echo"</td>
											<td align=''>". $ret1['Telephone']."</td>
											<td align='center'>";
												$n=round((strtotime($Jour_actuel)-strtotime($ret1['datarriv']))/86400);
												$dat=(date('H')+1);
												settype($dat,"integer");
												if ($dat<14){$n=$n;}else {$n= $n+1;}
												if ($n==0){$n= $n+1;} $n=(int)$n;
												if($sal==1) $n=($ret1['DiffDate']>0)?$ret1['DiffDate']:1;
												if($ret1['ttc_fixeR']>0) $mt=$ret1['ttc_fixeR']*$n; else $mt=$ret1['ttc_fixe']*$n;

												$Rnumfiche = $ret1['numfiche'] ;
												$query="SELECT * FROM fraisconnexe WHERE numfiche='".$Rnumfiche."' AND Ferme='NON'";
												$s=mysqli_query($con,$query);
												if(mysqli_num_rows($s)<=0){
													if(!empty($ret1['codegrpe'])){
														$sql0="SELECT code_reel FROM groupe WHERE codegrpe='".$ret1['codegrpe']."'";
														$req0 = mysqli_query($con,$sql0) or die (mysqli_error($con));
														$datap=mysqli_fetch_object($req0);
														$Rnumfiche = $datap->code_reel;
														$query="SELECT * FROM fraisconnexe WHERE numfiche='".$Rnumfiche."' AND Ferme='NON'";
														$s=mysqli_query($con,$query);
													}
												}

											$ListeConnexe=array(); $PrixConnexe=array(); $id=array();$i=0; $Ttotal=0;
											if($nbreresult=mysqli_num_rows($s)>0)
												{	while($retA=mysqli_fetch_array($s))
														{ 	$ListeConnexe[$i]=$retA['code'];
															$Unites =$retA['NbreUnites']; $MontantUnites =$retA['PrixUnitaire'];
															$PrixConnexe[$i]=$Unites*$MontantUnites; $id[$i] =$retA['id']+$i; $i++;
															//$MontantPaye =$retA['MontantPaye'];
															$NbreUnites =$retA['NbreUnites'];  $Ttotali = $NbreUnites * $MontantUnites ;
															$Ttotal+=$Ttotali;
														}$Tmt=$mt+$Ttotal;
												//if($Ttotal!=$MontantPaye)
												echo " <a class='info' id='container' class='container' href='#' style='color:black;text-decoration:none;font-size:1em;' title=''>";
												echo $Tmt;
												echo "</span></a>";

												}
												//else
												if($sal==1)  $objetT="salle"; else $objetT="chambre";//echo $mt;
												if(($ret1['ttc_fixeR']!=$ret1['ttc_fixe'])&&($ret1['ttc_fixeR']!=0)){
														 $diff=abs($mt-($mt/$ret1['ttc_fixeR'])*$ret1['ttc_fixe'])/$n; 
														 $mtdiff=($mt/$n)+$diff; 
													echo "<a class='info2' style='color:red;text-decoration:none;' href='loccup.php?menuParent=Consultation&sal=".$sal; 
													if($ret1['ttc_fixeR']>$ret1['ttc_fixe']) echo "&increase=1"; else echo "&decrease=1"; 
													echo "&numfiche=".$ret1['numfiche']."'>
													<b>[-]</b><span style='color:red;'>Supprimer la";
													 	if($ret1['ttc_fixeR']>$ret1['ttc_fixe'])	echo " majoration"; else echo " réduction";
													 echo "<br/>appliquée au client </span></a>";
														echo "<a class='info2' style='color:black;text-decoration:none;' href='#'> "; 
														if($Ttotal==0) echo $mt; 
														echo "<span>";
												  	echo "✔ Le montant initial de la ".$objetT." est : <font color='#5C110F'> <strong>".$ret1['ttc_fixe']." ".$devise."/nuitée </strong>  </font> 
													<br/>  soit une ";  if($ret1['ttc_fixeR']>$ret1['ttc_fixe']) echo " majoration ponctuelle"; else echo " réduction ponctuelle"; echo " de<font color='#5C110F'> <strong>".$diff." ".$devise."</strong>  </font>appliquée au client. ";
												}
												else{ if((($reduce0==1)&&($sal!=1))||(($reduce1==1)&&($sal==1))){
															echo "<a class='info2' style='color:black;text-decoration:none;' href='loccup.php?menuParent=Consultation&changeP=1&numfiche=".$ret1['numfiche']."&sal=".$sal."'> ";
															}
															if($Ttotal==0) echo $mt;
															if((($reduce0==1)&&($sal!=1))||(($reduce1==1)&&($sal==1))){
																echo "<span>";
																echo " Appliquer une <font style='color:red;'>Réduction/Majoration</font>  <br/>ponctuelle sur le prix de la ".$objetT;
															}
													}
												echo "</span>"; //echo $mt; 
												echo "</a>";

												if($Ttotal>0){
													echo "<a class='info2' style='color:red;text-decoration:none;font-weight:bold;' href='#'> [+]<span>";
													//echo " <b style='color:red;'>[+]</b>";
												echo "<span>Détails sur le montant TTC &nbsp;&nbsp;&nbsp;<span style='color:red;margin-left:0%;font-size:1em;font-weight:bold;'>";
												if($sal==1) echo "Location de salle"; else echo "Hébergement"; echo " :&nbsp;".$mt." - Frais connexes :&nbsp;".$Ttotal;
												for($i=0;$i<count($ListeConnexe);$i++)
													{
													echo "<hr style='margin-top:-3px;'/> <center style='font-size:1em;color:maroon'>";
													echo $i+1; echo "-&nbsp;&nbsp;".$ListeConnexe[$i]." :&nbsp;".$PrixConnexe[$i];
													//echo "</span>";
													echo "</center>";
													}
												echo "</span>";
												}


											echo"</td>"; $var1=$ret1['somme'] ;
											echo"<td align='center'>";
										/*
												if($MontantPaye>0)
													{$Spaye=1000;
													echo " <a class='info' id='container' class='container' href='#' style='color:black;text-decoration:none;' title=''>".$Spaye."<span>Détails du montant&nbsp;&nbsp;&nbsp;<span style='color:red;margin-left:-75%;'>Hébergement payé:&nbsp;".$mt." - Frais connexes payés:&nbsp;".$Ttotal."<span style='color:#00A9E2;align:center;margin-left:50%;'>Wifi:&nbsp;".$Ttotal."</span></span></span></a>";
												}else */
										$sql="SELECT sum(PrixUnitaire*NbreUnites) AS MontantPaye FROM fraisconnexe WHERE numfiche='".$ret1['numfiche']."' AND Ferme='NON'";
										$s=mysqli_query($con,$sql);
											if($nbreresult=mysqli_num_rows($s)>0)
												$retC=mysqli_fetch_assoc($s);
												$MontantPaye =$retC['MontantPaye'];$MontantPaye=0;

													echo $ret1['somme']+$MontantPaye;  //Commentaire du 12.01.2022

											echo  "</td>";
											 $var = $mt-$var1+$Ttotal;
									 if($var<=0) {echo"<td align='center' style='' >"; echo $var;echo"</td>";}
									 else {echo"<td align='center' style='background-color:red;color:white;'>";
									 echo $var;
									 echo"</td>";}
									echo"</tr>";
									$i=$i+1;
							if(($n>=15)&&($ret1['Avertissement']!='OUI_D')) $trouver=1;
						}
					?>
					</table>
				</td>
			</tr>
		</table>
		<?php
		if($trouver==1)
		{echo "<br/><table align='center' style='font-size:1em;color:black;'>
			<tr align='center'>
				<td> <b>L</b>es périodes mentionnées en rouge indiquent que les clients concernés ont atteint le délai maximum de séjour soit <span style='font-weight:bold;color:red;'><i>15 jours</i></span>. La sortie groupée sera automatique à partir de <span style='font-weight:bold;color:red;'><i>12H:00</i></span>.
				</td>
			</tr>
		</table>";

		}
		?>
</div>
<?php
if(!empty($_GET['increase']) && ($_GET['increase']==1)){ 
		echo "<script language='javascript'>";
		echo "var sal = '".$_GET['sal']."';";
		echo "var numfiche = '".$_GET['numfiche']."';";
			echo 'swal("Vous êtes sur le point de supprimer la majoration initialement appliquée au client. Voulez-vous vraiment continuer ?", {
				dangerMode: true, buttons: true,
			}).then((value) => { var Es = value;  document.location.href="loccup.php?menuParent='.$_SESSION['menuParenT'].'&numfiche="+numfiche+"&increase=0&test1="+Es+"&sal="+sal;
			}); ';
		echo "</script>";
}
if(!empty($_GET['decrease']) && ($_GET['decrease']==1)){ 
		echo "<script language='javascript'>";
		//echo "var Nprix = '".$_GET['Nprix']."';";
		echo "var numfiche = '".$_GET['numfiche']."';";
		echo "var sal = '".$_GET['sal']."';";
		echo 'swal("Vous êtes sur le point de supprimer la réduction initialement appliquée au client. Voulez-vous vraiment continuer ?", {
				dangerMode: true, buttons: true,
			}).then((value) => { var Es = value;  document.location.href="loccup.php?menuParent='.$_SESSION['menuParenT'].'&numfiche="+numfiche+"&decrease=0&test1="+Es+"&sal="+sal;
			}); ';	
		echo "</script>";
}
if(!empty($_GET['test1'])&&($_GET['test1']=="true")){
			if(isset($_GET['sal'])&&($_GET['sal']==1))
				$sql="SELECT ttc_fixe,somme,ttax,ttva,tarif FROM compte1 WHERE numfiche ='".$_GET['numfiche']."'";
			else 
				$sql="SELECT ttc_fixe,somme,ttax,ttva,tarif FROM mensuel_compte WHERE numfiche ='".$_GET['numfiche']."'";
			$update1=mysqli_query($con,$sql);
			$data=mysqli_fetch_object($update1);$dataT=$data->ttc_fixe;$SumT=$data->somme;$ttax=$data->ttax; //$diff=abs($dataT-$_GET['Nprix']);
			if($data->ttva!=0){
				$Ntarif=round(($dataT-$ttax)/(1+$data->ttva));
			}else $Ntarif=$data->tarif;
				$sql="SET ttc_fixeR='0',tarif='".$Ntarif."' WHERE numfiche ='".$_GET['numfiche']."'";
				if(isset($_GET['sal'])&&($_GET['sal']==1)) $update1=mysqli_query($con,"UPDATE compte1 ".$sql);
				else { $update1=mysqli_query($con,"UPDATE compte ".$sql);$update1=mysqli_query($con,"UPDATE mensuel_compte ".$sql);}
				echo "<script language='javascript'>";
				if(isset($_GET['sal'])&&($_GET['sal']==1))
					echo "var Tobjet = 'salle';";
				else 
					echo "var Tobjet = 'chambre';";
				echo 'alertify.success("Modification effectuée. Le montant initial de la "+Tobjet+" a été rétabli.");';
				echo "</script>";
				echo '<meta http-equiv="refresh" content="2; url=loccup.php?menuParent='.$_SESSION['menuParenT'].'&sal='.$_GET['sal'].'" />';
}
if(!empty($_GET['changeP']) && ($_GET['changeP']==1)){
echo "<script language='javascript'>";
echo "var numfiche = '".$_GET['numfiche']."';";
if(isset($_GET['sal'])&&($_GET['sal']==1))
	echo "var Tobjet = 'salle';";
else 
	echo "var Tobjet = 'chambre';";
echo "var sal = '".$_GET['sal']."';";
echo 'swal("Réduction ou Majoration du montant de la "+Tobjet, {
		content: {
		element: "input",
		attributes: {
		placeholder: " Saisissez le nouveau montant de la "+Tobjet+" ici",
		},
		},
		})
		.then((value) => {
			document.location.href="loccup.php?menuParent='.$_SESSION['menuParenT'].'&numfiche="+numfiche+"&Nprix="+value+"&sal="+sal;
		}); ';
echo "</script>";
}
if(isset($_GET['Nprix'])&&($_GET['Nprix']>0)&&(empty($_GET['test']))){ //$_SESSION['delete']=$_GET['clt'];
		echo "<script language='javascript'>";
		echo "var Nprix = '".$_GET['Nprix']."';";  echo "var numfiche = '".$_GET['numfiche']."';";
		echo "var sal = '".$_GET['sal']."';";
		if(isset($_GET['sal'])&&($_GET['sal']==1))
			echo "var Tobjet = 'salle';";
		else 
			echo "var Tobjet = 'chambre';";
		echo 'swal("Vous êtes sur le point de changer le prix de la "+Tobjet+". Le client concerné sera désormais facturé à "+Nprix+". Voulez-vous vraiment continuer ?", {
			dangerMode: true, buttons: true,
		}).then((value) => { var Es = value;  document.location.href="loccup.php?menuParent='.$_SESSION['menuParenT'].'&numfiche="+numfiche+"&Nprix='.$_GET['Nprix'].'&test="+Es+"&sal="+sal;
		}); ';
		echo "</script>";
	} if(!empty($_GET['test'])&&($_GET['test']=="true")){
			if(isset($_GET['sal'])&&($_GET['sal']==1))
				$query="SELECT ttc_fixe,somme,ttax,ttva,tarif FROM compte1 WHERE numfiche ='".$_GET['numfiche']."'";
			else 
				$query="SELECT ttc_fixe,somme,ttax,ttva,tarif FROM mensuel_compte WHERE numfiche ='".$_GET['numfiche']."'";
			$update1=mysqli_query($con,$query);
			$data=mysqli_fetch_object($update1);$dataT=$data->ttc_fixe;$diff=abs($dataT-$_GET['Nprix']);$SumT=$data->somme;$ttax=$data->ttax;
			if($data->ttva!=0){
				$Ntarif=round(($_GET['Nprix']-$ttax)/(1+$data->ttva));
			}else $Ntarif=$data->tarif;
			if($SumT<=0){
			//if($dataT>$_GET['Nprix']){
				$sql="SET ttc_fixeR='".$_GET['Nprix']."',tarif='".$Ntarif."' WHERE numfiche ='".$_GET['numfiche']."'";
				if(isset($_GET['sal'])&&($_GET['sal']==1)) $update1=mysqli_query($con,"UPDATE compte1 ".$sql);
				else {
					$update1=mysqli_query($con,"UPDATE compte ".$sql);
					$update1=mysqli_query($con,"UPDATE mensuel_compte ".$sql);
				}
				echo "<script language='javascript'>";	
				echo "var diff = '".$diff."';";
				if(isset($_GET['sal'])&&($_GET['sal']==1))
					echo "var Tobjet = 'salle';";
				else 
					echo "var Tobjet = 'chambre';";
				if($dataT<$_GET['Nprix'])
					echo 'alertify.success(" Vous venez d\'appliquer une majoration d\'une valeur de "+diff+" sur le prix de la "+Tobjet+" !");';
				else
					echo 'alertify.success(" Vous venez d\'appliquer une réducton d\'une valeur de "+diff+" sur le prix de la "+Tobjet+" !");';
				echo "</script>";
				echo '<meta http-equiv="refresh" content="2; url=loccup.php?menuParent='.$_SESSION['menuParenT'].'&sal='.$_GET['sal'].'" />';
			// }
			// else {
			// 	echo "<script language='javascript'>";
			// 	echo 'alertify.error("Dans le cas d\'une réduction, le nouveau montant doit être inférieur au montant réel de la chambre ");';
			// 	echo "</script>";
			// }
		}else{
			echo "<script language='javascript'>";
			echo 'alertify.error("Désolé ! Un encaissement a été déjà effectué. Vous ne pouvez plus appliquer une réduction sur le montant de la chambre.");';
			echo "</script>";
		}
		}
		if(!empty($_GET['test'])&&($_GET['test']=="null")){
			  echo "<script language='javascript'>";
				echo 'alertify.error(" L\'opération a été annulée !");';
			 	echo "</script>";
		}
		if(!empty($_GET['test1'])&&($_GET['test1']=="null")){
			  echo "<script language='javascript'>";
				echo 'alertify.error(" L\'opération a été annulée !");';
			 	echo "</script>";
		}
	// }else if(empty($_GET['Nprix'])){
	// 	echo "<script language='javascript'>";
	// 	echo 'alertify.error(" L\'opération a été annulée !");';
	// 	echo "</script>";
	// }
	else {

	}

?>
	</body>
</html>
