<?php
	include 'menu.php';unset($_SESSION['debuti']); unset($_SESSION['view']); unset($_SESSION['cham']); $_SESSION['Visualiser']=0;$_SESSION['pop']=0;unset($_SESSION['reference']);
	unset($_SESSION['HT_connexe']);unset($_SESSION['pourcent']);unset($_SESSION['sal']);unset($_SESSION['NuitePayee']);unset($_SESSION['Fconnexe']); unset($_SESSION['reference']);
	$_SESSION['vendeur']=$_SESSION['nom']." ".ucfirst(strtolower($_SESSION['prenom'])); unset($_SESSION['client']);
	unset($_SESSION['NumIFU']);unset($_SESSION['AdresseClt']);unset($_SESSION['TelClt']);unset($_SESSION['impaye']);unset($_SESSION['Foriginal1']);unset($_SESSION['Foriginal2']);
	unset($_SESSION['groupe1']);unset($_SESSION['groupe']);unset($_SESSION['num']);unset($_SESSION['client']);unset($_SESSION['date_emission']);unset($_SESSION['numrecu']);unset($_SESSION['numrecu']);unset($_SESSION['Nd']);
	unset($_SESSION['req1']);unset($_SESSION['req2']);unset($_SESSION['retro']);unset($_SESSION['Apply_AIB']);
	unset($_SESSION['DT_HEURE_MCF']);unset($_SESSION['QRCODE_MCF']);unset($_SESSION['SIGNATURE_MCF']);unset($_SESSION['COMPTEUR_MCF']);unset($_SESSION['NIM_MCF']);
	$sal=!empty($_GET['sal'])?$_GET['sal']:NULL; 
	$trie=!empty($_GET['trie'])?$_GET['trie']:NULL; $EtatG=!empty($_GET['EtatG'])?$_GET['EtatG']:NULL; unset($_SESSION['ValAIB']);unset($_SESSION['PourcentAIB']);
	$del=mysqli_query($con,"delete  FROM table_tempon");
	mysqli_query($con,"SET NAMES 'utf8'");
	unset( $_SESSION['remise']); unset($_SESSION['recufiche']); unset($_SESSION['Numreserv']); unset($_SESSION['button_checkbox_2']); unset($_SESSION['button_checkbox_3']);
	
	$query="DELETE FROM produitsencours  WHERE `Etat` = '4'";
	$res1=mysqli_query($con,$query);
	
	$query="DELETE FROM compte2  WHERE `client` = ''";
	$res1=mysqli_query($con,$query);

/* 	if((!empty($_GET['impaye'])&&$_GET['impaye']==1)){
		echo "<script language='javascript'>";
		echo 'alertify.error("loccupV impossible. Ce groupe est déjà en Impayé!");';
		echo "</script>";
	} */
	//if($sal==1)
		 $query_Recordset1="SELECT SUM(PrixUnitaire*NbreUnites) AS montant ,date,numcli,NbreUnites,PrixUnitaire,code,compte2.numfiche,groupe,somme,nomcli,prenomcli,numiden,Telephone FROM fraisconnexe,compte2,client WHERE fraisconnexe.numfiche=compte2.client AND (compte2.client=client.numcli OR compte2.client=client.numcliS) AND fraisconnexe.Ferme='NON' GROUP BY numcli,groupe";
		
		$re=mysqli_query($con,$query_Recordset1); 
		if(mysqli_num_rows($re)==0){
		$query_Recordset1="SELECT SUM(PrixUnitaire*NbreUnites) AS montant ,NbreUnites,PrixUnitaire,code FROM fraisconnexe WHERE fraisconnexe.Ferme='NON' ";
		//$re=mysqli_query($con,$query_Recordset1);
		}


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
	<link rel="icon" href="<?php echo $icon; ?>" />
		<script type="text/javascript" src="js/jquery.js"></script>
		<script src="js/sweetalert.min.js"></script>
		<script type="text/javascript" src="date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<link rel="Stylesheet" href='css/table.css' />
		<meta name="viewport" content="width=device-width">
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>
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
	<?php

			?>
	<div align="" style="margin-top:-25px;">
		<table align='center'>
			<tr>
				<td>
					<hr noshade size=3> <div align="center"><B>
					
						  <span>
							<a class='info1' id='FraisC' target="_blank" style="text-decoration:none;" href="popup.php?vente=1<?php //echo isset($_GET['numfiche'])?$_GET['numfiche']:$_SESSION['num']; echo "&Numclt=" ; echo isset($_GET['Numclt'])?$_GET['Numclt']:NULL; ?>" onclick="window.open(this.href, 'Formulaire de Vente de produits ','target=_parent, height=450, width=750, top=180, left=250, color=black, toolbar=no, menubar=no, location=no, resizable=no, scrollbars=no, status=no'); return false">
							<img src='logo/add.png' alt='' title='' width='20' height='22' style='' border='0'><span style='' >&nbsp;Vente de produits
							<?php if(isset($Ttotalii)&&($Ttotalii>0)) echo "<center style='color:red;'> Total : ".$Ttotalii."</center>"; ?></span></a>
						 </span>
								 
								 
					<FONT SIZE=6 COLOR="Maroon"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; LISTE JOURNALIERE DES PRODUITS VENDUS<?php //if($sal==1) echo"DES OCCUPATIONS DE SALLES"; else echo"DES OCCUPANTS "; ?> </FONT></B><B> <span style='font-style:italic;'>(En date du <?php echo $Date_actuel2; //echo gmdate('d-m-Y');?>)</span></B>
					<FONT SIZE=4 COLOR="0000FF"> </FONT> </div> <hr noshade size=3>
				</td>
			</tr>
			<tr>
				<td>
					<table  border='1' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid black ;font-family:Cambria;'>

						<tr bgcolor='<?php echo "#CD5C5C"; ?>'align="center" style='font-weight:normal;'>
							<a href="" >
							<td align='center' style='border: 2px solid white;'> &nbsp;N° &nbsp;</td>
							<td align='center' style='border: 2px solid white;'><a class='info1' href='loccupV.php?menuParent=Consultation&trie=mensuel_fiche1.numfiche&etatget=<?php   if(!empty($_GET['etatget'])&&($_GET['trie']=='mensuel_fiche1.numfiche')) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget;?>&EtatG=<?php echo $etatget; ?>' style='text-decoration:none;color:black;' title=''> <span>Trier par Enrég. </span> &nbsp;N° Enrég.&nbsp; </a></td>
							<td align='center' style='border: 2px solid white;'><a class='info1' href='loccupV.php?menuParent=Consultation&trie=mensuel_fiche1.numfiche&etatget=<?php   if(!empty($_GET['etatget'])&&($_GET['trie']=='mensuel_fiche1.numfiche')) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget;?>&EtatG=<?php echo $etatget; ?>' style='text-decoration:none;color:black;' title=''> <span>Trier par Date </span> &nbsp;Date d'Enrég.&nbsp; </a></td>
							<td align='center' style='border: 2px solid white;'><a class='info1' href='loccupV.php?menuParent=Consultation&trie=nomcli&etatget=<?php  if(!empty($_GET['etatget'])&&($_GET['trie']=='nomcli')) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget;?>&EtatG=<?php echo $etatget; ?>' style='text-decoration:none;color:black;' title=''> <span>Trier par Nom</span> &nbsp;NOM ET PRENOMS&nbsp;</a> </td>
							<td align='center' style='border: 2px solid white;'><a class='info1' href='loccupV.php?menuParent=Consultation&trie=groupe&etatget=<?php  if(!empty($_GET['etatget'])&&($_GET['trie']=='groupe')) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget;?>&EtatG=<?php echo $etatget; ?>' style='text-decoration:none;color:black;' title=''>  <span>Trier par groupe</span>&nbsp;NOM DU GROUPE&nbsp;</a></td>
							<td align='center' style='border: 2px solid white;'><a class='info1' href='loccupV.php?menuParent=Consultation&trie=numiden&etatget=<?php  if(!empty($_GET['etatget'])&&($_GET['trie']=='numiden')) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget;?>&EtatG=<?php echo $etatget; ?>' style='text-decoration:none;color:black;' title=''> <span>Trier par Numéro pièce</span> PIECE N°</a></td>
							<td align='center' style='border: 2px solid white;'><a class='info1' href='loccupV.php?menuParent=Consultation&trie=adresse&etatget=<?php  if(!empty($_GET['etatget'])&&($_GET['trie']=='adresse')) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget;?>&EtatG=<?php echo $etatget; ?>' style='text-decoration:none;color:black;' title=''>  <span>Trier par Contact</span>CONTACT</a></td>
							<td align='center' style='border: 2px solid white;'><a class='' href='' style='text-decoration:none;color:black;' title=''>  <span></span>&nbsp;LISTE DE PRODUITS&nbsp;</a></td>
							<td align='center' style='border: 2px solid white;'>&nbsp; MONTANT&nbsp;</td>
							<td align='center' style='border: 2px solid white;'>SOMME PAYEE</td>
							<td align='center' style='border: 2px solid white;'> &nbsp;SOMME DUE&nbsp;</td>
							<td align='center' style='border: 2px solid white;'> &nbsp;ACTIONS&nbsp;</td>
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
										$k++;

											if(isset($ret1['numcli'])){
												$query_RecordsetC="SELECT nomcli, prenomcli FROM client WHERE numcli='".$ret1['numcli']."'";
												$RecordsetC = mysqli_query($con,$query_RecordsetC) or die(mysqli_error($con));
												$row_RecordsetC = mysqli_fetch_assoc($RecordsetC); 
												$second=$row_RecordsetC['nomcli']." ".substr($row_RecordsetC['prenomcli'],0,25);
												$Numclt=isset($numcli)?$ret1['numcli']:NULL;}
											else {
												$second="Client Divers";
												//$Numclt="2556";
											}
										//}
										if(!empty($ret1['groupe']))
										{
											
										}
										
											{
												/* if(isset($ret1['date'])){
												$Arriveei=substr($ret1['date'],8,2).'-'.substr($ret1['date'],5,2).'-'.substr($ret1['date'],0,4);$Sortiei=$Arriveei;
												$name=!empty($ret1['groupe'])?$ret1['groupe']:($ret1['nomcli']." ".$ret1['prenomcli']);									  
												$sql="SELECT numFactNorm,e_mecef.id_request FROM reedition_facture,e_mecef WHERE reedition_facture.id_request=e_mecef.id_request AND reedition_facture.nom_client = '".$name."' AND du ='".$Arriveei."' AND au ='".$Sortiei."' AND montant_ttc='".$due."' ";
												$query=mysqli_query($con,$sql);$dataR=mysqli_fetch_object($query);	
												
												if(isset($dataR->numFactNorm))	{ $bgcouleur = "#ffa97e";  } 
												} */
											
											}
										echo"<tr class='rouge1' bgcolor='".$bgcouleur."'>";
										//echo '<tr bgcolor="'.$bgcouleur.'" class="maclass" onmouserover="this.style.background-color: red;" onmouseout="this.style.background-color: inherit;"></tr>';
											echo " 	<td align='center' style='border: 2px solid white;'>"; echo $k;  echo ".</td>";
											if($_SESSION['poste']=="agent")
											{
												//$value=($ret1['ttc_fixe']*$ret1['somme'])/$ret1['ttc_fixe'];
												echo "<td align='center' style='border: 2px solid white;'>"; //echo "<a href='#' class='info'>Wi-Fi<span>contraction de Wireless Fidelity</span></a>";
/* 												echo " <a id='container' class='info' id='container2' href='";
											  if(!empty($ret1['groupe'])) echo "#"; else 
											  {

											echo "loccupV.php?menuParent=Consultation&Vente=1";

											echo "&solde=1&numfiche=".$ret1['numfiche']."&Numclt=".$ret1['numcli']."&due=".$due."&somme=".$ret1['somme'];
											  }
											echo "'> &nbsp;";
											
											echo $ret1['numfiche'];
																						
											if(empty($ret1['groupe'])) echo "<span> Encaisser pour le compte du client&nbsp;&nbsp;&nbsp;<span style='color:red;'>✔ ".$ret1['nomcli']."&nbsp;".$ret1['prenomcli']."</span>";
											echo "&nbsp; </span></a>"; */
											
											if(isset($ret1['numfiche'])) echo $ret1['numfiche'];
											
											if(!isset($dataR->numFactNorm)) {
											echo "<a class='info' style='color:red;text-decoration:none;' href='loccupV.php?menuParent=Consultation&delete=1";
											if(isset($ret1['numfiche'])) echo "&numfiche=".$ret1['numfiche']; 
											echo "'> <B>[-]</B><span>";
											echo "<span style='color:red;'>Supprimer l'enrégistrement. &nbsp;&nbsp;&nbsp;</span>";
											echo "</a>";
											}											
											echo "</td>"; 
											
											echo "<td align='center' style='border: 2px solid white;'>"; 
											if(isset($ret1['numfiche'])) echo substr($ret1['date'],8,2).'-'.substr($ret1['date'],5,2).'-'.substr($ret1['date'],0,4);  
											echo "</td>";

									/* 		echo "'>".$ret1['numfiche'];
											if((!empty($ret1['groupe'])&&($sal!=1))||($sal==1)) {} else
											echo "<span>Encaisser pour le compte du client&nbsp;&nbsp;&nbsp;<span style='color:red;'>".$ret1['nomcli']."&nbsp;".$ret1['prenomcli'];
											  echo "</span></span>";} echo "</a>"; echo "</td>"; */

											echo "<td align='center' style='border: 2px solid white;'>"; echo"&nbsp;&nbsp;&nbsp;&nbsp;"; echo " <a  "; //if(isset($_GET['sal'])) 	$direction="ficheS.php"; else 
											$direction="popup.php";
											echo "id='container2' class='info' id='container2'"; echo " href='#' style='color:black;text-decoration:none;' title=''>";
											if(isset($ret1['numfiche'])) echo substr(trim($ret1['nomcli']),0,25).'	'.substr($ret1['prenomcli'],0,25);
											echo "<span>";
											   // if(empty($second)&&($second=="")) 
													echo "<font style='color:red;'>✔ </font>Changer le Nom du client"; 
												//else echo "✔ Nom du Second occupant&nbsp; <span style='color:red;'>".$second.";
												echo "</span> </span></a>"; echo"</td>";
											if($sal!=1)
												{ if(!empty($somme_due)) {echo"<td align='center'>"; if(!empty($ret1['groupe'])) echo " <a class='info' href='loccupV.php?menuParent=Consultation&impaye=1' style='color:#800012;text-decoration:none;'
												title=''><span style='font-size:0.9em;color:red;'>&nbsp;&nbsp;".$ret1['groupe']."(+Impayé:&nbsp;".$somme_due.") </span> ".$ret1['groupe']."</a>"; else echo " - "; echo  "</td>";}
												else{ echo "<td align='center' style='border: 2px solid white;'>"; 
												if(isset($ret1['groupe'])&&($ret1['groupe']!='')) { //echo " <a  id='container' class='info' href='loccupV.php?menuParent=Consultation&Vente=1&solde=1&groupe=".$ret1['groupe']."' style='color:#800012;text-decoration:none;' title=''>".$ret1['groupe']."<span>Encaisser pour le compte du groupe&nbsp;&nbsp;&nbsp;<span style='color:red;'> ✔ ".$ret1['groupe']."</span></span></a>"; 
														echo $ret1['groupe'];
													}
													else { if(!isset($dataR->numFactNorm)) { ?>  
												<a href='popup2.php?Vente=1&numfiche=<?php if(isset($ret1['numfiche'])) echo $ret1['numfiche']."&client=".trim($ret1['nomcli']).' '.$ret1['prenomcli']; ?>' class='info3' style='text-decoration:none;' onclick="window.open(this.href, 'Formulaire pour ajout de Frais Connexes ','target=_parent, height=400, width=750, top=180, left=250, color=black, toolbar=no, menubar=no, location=no, resizable=no, scrollbars=no, status=no'); return false" ><span style='color:red;'>Passage en mode groupé</span><i style='color:maroon;' class='fas fa-american-sign-language-interpreting'></i></a> 
												<?php }} echo  "</td>";}
												}
											else
												{	  echo "<td align='center' style='border: 2px solid white;'>"; if($ret1['groupe']!='') echo " <a  id='container' class='info' href='encaissement2.php?sal=1&menuParent=Consultation&solde=1&groupe=".$ret1['groupe']."&Arrivee=".$ret1['datarriv']."' style='color:#800012;text-decoration:none;' title=''> <span>Encaisser pour le groupe&nbsp;&nbsp;&nbsp;<center style='color:red;'>".$ret1['groupe']."</center></span>  ".$ret1['groupe']."</a>"; else echo" - "; echo  "</td>";}
											} //Quand l'administrateur se connecte. ACCES -> CONSULTATION
											else
											{echo "<td align='center' style='border: 2px solid white;'>"; echo " <a id='container' class='container' href='"; echo "#"; if($sal!=1) echo"fiche=1"; else echo"sal=1"; echo "&numfiche=".$ret1['numfiche']."&due=".$due."&somme=".$ret1['somme']."'  title='&nbsp;&nbsp;&nbsp;"; echo"' style='text-decoration:none;color:#800000;'>".substr($ret1['numfiche'],0,8)."</a>"; echo "</td>";
											echo "<td align='center' style='border: 2px solid white;'>&nbsp;&nbsp;&nbsp;&nbsp;"; echo " <a  "; echo"style='color:black;text-decoration:none;' title='Réajustement du séjour'>".substr($ret1['nomcli'],0,25).'	'.substr($ret1['prenomcli'],0,25)."</a>"; echo"</td>";
											echo "<td align='center' style='border: 2px solid white;'>"; if($ret1['groupe']!='') { echo $ret1['groupe'];} else echo " - "; echo  "</td>";
											}
											echo "<td align='center' style='border: 2px solid white;'>"; if(isset($ret1['numiden'])) echo $ret1['numiden']; echo"</td>";

											$codesalle=!empty($ret1['codesalle'])?$ret1['codesalle']:NULL; 
											
											echo "<td align='center' style='border: 2px solid white;'>";
											
											if(isset($ret1['Telephone'])) echo $ret1['Telephone']; echo "</td>";
											
											echo "<td align='left' style='border: 2px solid white;'>";											
										
												$sql="SELECT NbreUnites,code,PrixUnitaire FROM fraisconnexe,compte2,client WHERE fraisconnexe.numfiche=compte2.client AND (compte2.client=client.numcli OR compte2.client=client.numcliS) AND fraisconnexe.Ferme='NON' AND compte2.numfiche='".$ret1['numfiche']."' ";
												$result=mysqli_query($con,$sql);
												if (!$result) {
													printf("Error: %s\n", mysqli_error($con));
													exit();
												} $i=0;$som=0;
												while($data0=mysqli_fetch_array($result)){
												$i++; $som+=$data0['PrixUnitaire']*$data0['NbreUnites'];;
												echo $i."-".$data0['code'];
												echo "<span style='color:red;'>[".$data0['NbreUnites']." x ".$data0['PrixUnitaire']."]</span> ";												
												if($i!=mysqli_num_rows($result))
												 echo " ; <br/>";
												}
											//echo $ret1['code']; 
											$numcli=isset($ret1['numcli'])?$ret1['numcli']:$ret1['numcliS'];
											
											//if(isset($ret1['numcli']))
												$query_Recordset1="SELECT numcli,numcliS,NbreUnites,PrixUnitaire,code FROM fraisconnexe,compte2,client WHERE fraisconnexe.numfiche=compte2.client AND (compte2.client=client.numcli OR compte2.client=client.numcliS) AND fraisconnexe.Ferme='NON' AND compte2.client='".$numcli."'";
											//else 
											//	$query_Recordset1="SELECT SUM(PrixUnitaire*NbreUnites) AS montant ,NbreUnites,PrixUnitaire,code FROM fraisconnexe WHERE fraisconnexe.Ferme='NON' ";
											$query=mysqli_query($con,$query_Recordset1);$Ttotal=mysqli_num_rows($query); //$data0=mysqli_fetch_object($query);
											$query0=mysqli_query($con,$query_Recordset1);
											if($Ttotal>1){
							/* 						echo "<a class='info2' style='color:red;text-decoration:none;' href='#'> <B>[+]</B><span>";
													//echo " <b style='color:red;'>[+]</b>";
												echo "<span style='color:red;'>LISTE DE TOUS LES PRODUITS &nbsp;&nbsp;&nbsp;<span style='color:red;margin-left:0%;font-size:1em;'>";
												while($data0=mysqli_fetch_array($query))
													{
													echo "<hr style='margin-top:-3px;'/> <center style='font-size:1em;color:maroon'>";
													echo $data0['NbreUnites']; echo " x&nbsp;[".$data0['code']."] = &nbsp;".$data0['PrixUnitaire']*$data0['NbreUnites'];
													$som0=$data0['PrixUnitaire']*$data0['NbreUnites'];
													echo "</center>";
													} 
												echo "</span>"; */
												}
											
											echo "</td>";
											
											echo "<td align='center' style='border: 2px solid white;'>";
			
												//echo $mt;
/* 												if($ret1['ttc_fixeR']>0){
													echo "<a class='info2' style='color:red;text-decoration:none;font-weight:bold;' href='loccupV.php?menuParent=Consultation&reduce=1&numfiche=".$ret1['numfiche']."'>
													[-]<span style='color:red;'>Supprimer la réduction<br/>appliquée au client </span></a>";
														echo "<a class='info2' style='color:black;text-decoration:none;' href='#'> ".$ret1['montant']."<span>";
													  //$diff=abs($mt-($mt/$ret1['ttc_fixeR'])*$ret1['ttc_fixe'])/$n; $mtdiff=($mt/$n)+$diff;
												  	//echo "✔ Prix réel de la chambre par nuitée : <font color='#5C110F'> <strong>".$mtdiff." ".$devise."</strong>  </font> .<br/> ✔ Réduction spéciale de<font color='#5C110F'> <strong>".$diff." ".$devise."</strong>  </font>appliquée au client. ";
												} */
												//else
												{
											echo "<a class='info2' style='color:black;text-decoration:none;' href='loccupV.php?menuParent=Consultation&changeP=1&numfiche=";
											if(isset($ret1['numfiche'])) echo $ret1['numfiche']; echo "'> ";
											echo $som ;
											echo "<span>";
														//	echo " Appliquer une réduction spécifique <br/><font style='color:red;'>✔ </font> sur le prix du produit";
												}
												echo "</span> </a>"; 
												
												if($Ttotal>1){
													echo "<a class='info2' style='color:red;text-decoration:none;' href='#'>  <B>[+]</B><span>";
													//echo " <b style='color:red;'>[+]</b>";
												echo "<span style='color:red;'>Détails du montant &nbsp;&nbsp;&nbsp;<span style='color:red;margin-left:0%;font-size:1em;'>";
									 			while($data1=mysqli_fetch_array($query0))
													{
													echo "<hr style='margin-top:-3px;'/> <center style='font-size:1em;color:maroon'>";
													echo $data1['NbreUnites']; echo " x&nbsp;[".$data1['PrixUnitaire']."] = &nbsp;".$data1['PrixUnitaire']*$data1['NbreUnites'];
													//echo "</span>";
													echo "</center>";
													}
												echo "</span>";
												}

											echo"</td>"; $var1=!empty($ret1['somme'])?$ret1['somme']:0 ;
											echo "<td align='center' style='border: 2px solid white;'>";
											if(isset($ret1['numfiche']))
												$sql="SELECT sum(PrixUnitaire*NbreUnites) AS MontantPaye FROM fraisconnexe WHERE numfiche='".$ret1['numfiche']."' AND Ferme='NON'";
											else 
												$sql="SELECT SUM(PrixUnitaire*NbreUnites) AS MontantPaye ,NbreUnites,PrixUnitaire,code FROM fraisconnexe WHERE fraisconnexe.Ferme='NON' ";
											$s=mysqli_query($con,$sql);
											if($nbreresult=mysqli_num_rows($s)>0)
												$retC=mysqli_fetch_assoc($s);
												$MontantPaye =$retC['MontantPaye'];$MontantPaye=0;

												echo $var1+$MontantPaye;  //Commentaire du 12.01.2022

											echo  "</td>";
											 $var = $som-$var1;
									echo "<td align='center' style='border: 2px solid white;'>";
									 if($var<=0) { echo $var;}
									 else {	 echo $var;	 
									 } 
									 echo"</td>"; $due=$var;
									 
									echo "<td align='center' style='border: 2px solid white;'>";																	
									{  
										if(!isset($dataR->numFactNorm)) 
										{echo " 	<a class='info1'";  echo "href='"; echo "loccupV.php?confirm=1&menuParent=Consultation&Nbre=".$i."&solde=0&Vente=1&impaye=1&Numclt=".$ret1['numcli']."&numfiche=".$ret1['numfiche']."&due=".$due."&Mtotal=".$due."&groupe=".$ret1['groupe']."&Totalpaye=".$ret1['somme'];   
										echo "'";  //echo 'onclick="return confirmation1();"'; 
										echo "style='text-decoration:none;'>
										&nbsp;<img src='logo/cal.gif' alt='' title='' width='16' height='16' style='border:1px solid red;' ><span style='font-size:0.9em;color:red;'>Normaliser sans <br/>Encaisser la facture</span></a>";
										}							
										echo "<a class='info2'"; echo "href='";  //echo 'onclick="return confirmation2();"';  else echo 'onclick="return confirmation3();"';
										echo "loccupV.php?menuParent=Consultation&Nbre=".$i."&"; if(!isset($dataR->numFactNorm)) echo "confirm=2"; else  echo "confirm=3";    echo "&solde="; if(!isset($dataR->numFactNorm)) echo 1; else echo 2; 
										if(isset($ret1['numcli'])) echo "&Vente=1&impaye=1&Numclt=".$ret1['numcli']."&numfiche=".$ret1['numfiche']."&due=".$due."&Mtotal=".$var."&groupe=".$ret1['groupe']."&Totalpaye=".$ret1['somme'];
										echo "'>&nbsp;&nbsp;&nbsp;<img src='logo/more.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.9em;color:maroon;'>Encaisser ";
										
										if(!isset($dataR->numFactNorm)) echo "et <br/>Normaliser la facture"; else echo "la Facture";
										
										echo "</span> </a>";
										
										echo " <a class='info2' href='#' style='text-decoration:none;'>
										&nbsp;<img src='logo/mail.png' alt='' title='' width='25' height='25' border='0' style='margin-bottom:-3px;'><span style='font-size:0.9em;'>Envoyer une lettre de relance </span></a>";
									}
									echo "</td>";
								
									echo"</tr>";
									$i=$i+1;
							//if(($n>=15)&&($ret1['Avertissement']!='OUI_D')) $trouver=1;
						}
					?>
					</table>
				</td>
			</tr>
		</table>
		<?php
/* 		if($trouver==1)
		{echo "<br/><table align='center' style='font-size:1em;color:black;'>
			<tr align='center'>
				<td> <b>L</b>es périodes mentionnées en rouge indiquent que les clients concernés ont atteint le délai maximum de séjour soit <span style='font-weight:bold;color:red;'><i>15 jours</i></span>. La sortie groupée sera automatique à partir de <span style='font-weight:bold;color:red;'><i>12H:00</i></span>.
				</td>
			</tr>
		</table>";

		} */
		?>
</div>
<?php
if(isset($_GET['confirm'])){ 
		echo "<script language='javascript'>";
		//solde=0&Vente=1&impaye=1&Numclt=".$ret1['numcli']."&numfiche=".$ret1['numfiche']."&due=".$due."&Mtotal=".$due."&groupe=".$ret1['groupe']."&Totalpaye=".$ret1['somme']
		echo "var solde = '".$_GET['solde']."';";   echo "var Vente = '".$_GET['Vente']."';";
		echo "var Numclt = '".$_GET['Numclt']."';";	echo "var numfiche = '".$_GET['numfiche']."';";
		echo "var due = '".$_GET['due']."';";		echo "var Mtotal = '".$_GET['Mtotal']."';";
		echo "var groupe = '".$_GET['groupe']."';";	echo "var Totalpaye = '".$_GET['Totalpaye']."';";
		echo "var Nbre = '".$_GET['Nbre']."';";
		if(($_GET['confirm']==1)){
			echo 'swal("Normaliser la facture sans Encaisser pour N° Enrég. : "+numfiche+". \n Veuillez noter que cette action est irréversible. \nVoulez-vous vraiment continuer ?", {
				dangerMode: true, buttons: true,
			}).then((value) => { var Es = value;  document.location.href="loccupV.php?menuParent=Consultation&Nbre="+Nbre+"&solde="+solde+"&Vente="+Vente+"&Numclt="+Numclt+"&numfiche="+numfiche+"&due="+due+"&Mtotal="+Mtotal+"&groupe="+groupe+"&Totalpaye="+Totalpaye+"&px1="+Es;
			}); ';
		}else if(($_GET['confirm']==2)){
			echo 'swal("Encaisser & Normaliser la facture pour N° Enrég. : "+numfiche+". \n Veuillez noter que cette action est irréversible. \nVoulez-vous vraiment continuer ?", {
				dangerMode: true, buttons: true,
			}).then((value) => { var Es = value;  document.location.href="loccupV.php?menuParent=Consultation&Nbre="+Nbre+"&solde="+solde+"&Vente="+Vente+"&Numclt="+Numclt+"&numfiche="+numfiche+"&due="+due+"&Mtotal="+Mtotal+"&groupe="+groupe+"&Totalpaye="+Totalpaye+"&px2="+Es;
			}); ';
		}else {
			echo 'swal("Cette facture est déjà normalisée. Vous êtes sur le point de l\'encaisser. \nVoulez-vous vraiment continuer ?", {
				dangerMode: true, buttons: true,
			}).then((value) => { var Es = value;  document.location.href="loccupV.php?menuParent=Consultation&Nbre="+Nbre+"&solde="+solde+"&Vente="+Vente+"&Numclt="+Numclt+"&numfiche="+numfiche+"&due="+due+"&Mtotal="+Mtotal+"&groupe="+groupe+"&Totalpaye="+Totalpaye+"&px3="+Es;
			}); ';	
		}
		echo "</script>";
}

if(isset($_GET['px1'])&&($_GET['px1']!="null")){//echo 4;
	echo "<script language='javascript'>";
	echo "var solde = '".$_GET['solde']."';";   echo "var Vente = '".$_GET['Vente']."';";
	echo "var Numclt = '".$_GET['Numclt']."';";	echo "var numfiche = '".$_GET['numfiche']."';";
	echo "var due = '".$_GET['due']."';";		echo "var Mtotal = '".$_GET['Mtotal']."';";
	echo "var groupe = '".$_GET['groupe']."';";	echo "var Totalpaye = '".$_GET['Totalpaye']."';";
	echo "var Nbre = '".$_GET['Nbre']."';";
	echo 'document.location.href="encaissement.php?menuParent=Consultation&Nbre="+Nbre+"&solde="+solde+"&Vente="+Vente+"&Numclt="+Numclt+"&numfiche="+numfiche+"&due="+due+"&Mtotal="+Mtotal+"&groupe="+groupe+"&Totalpaye="+Totalpaye;';
	echo "</script>";
}
if(isset($_GET['px2'])&&($_GET['px2']!="null")){ //echo 5;
	echo "<script language='javascript'>";
	echo "var solde = '".$_GET['solde']."';";   echo "var Vente = '".$_GET['Vente']."';";
	echo "var Numclt = '".$_GET['Numclt']."';";	echo "var numfiche = '".$_GET['numfiche']."';";
	echo "var due = '".$_GET['due']."';";		echo "var Mtotal = '".$_GET['Mtotal']."';";
	echo "var groupe = '".$_GET['groupe']."';";	echo "var Totalpaye = '".$_GET['Totalpaye']."';";
	echo "var Nbre = '".$_GET['Nbre']."';";
	echo 'document.location.href="encaissement.php?menuParent=Consultation&Nbre="+Nbre+"&solde="+solde+"&Vente="+Vente+"&Numclt="+Numclt+"&numfiche="+numfiche+"&due="+due+"&Mtotal="+Mtotal+"&groupe="+groupe+"&Totalpaye="+Totalpaye;';
	echo "</script>";
}
if(isset($_GET['px3'])&&($_GET['px3']!="null")){//echo 6;
	echo "<script language='javascript'>";
	echo "var solde = '".$_GET['solde']."';";   echo "var Vente = '".$_GET['Vente']."';";
	echo "var Numclt = '".$_GET['Numclt']."';";	echo "var numfiche = '".$_GET['numfiche']."';";
	echo "var due = '".$_GET['due']."';";		echo "var Mtotal = '".$_GET['Mtotal']."';";
	echo "var groupe = '".$_GET['groupe']."';";	echo "var Totalpaye = '".$_GET['Totalpaye']."';";
	echo "var Nbre = '".$_GET['Nbre']."';";
	echo 'document.location.href="encaissement.php?menuParent=Consultation&Nbre="+Nbre+"&solde="+solde+"&Vente="+Vente+"&Numclt="+Numclt+"&numfiche="+numfiche+"&due="+due+"&Mtotal="+Mtotal+"&groupe="+groupe+"&Totalpaye="+Totalpaye;';
	echo "</script>";
}

if(isset($_GET['delete']) && ($_GET['delete']==1)){ 
		echo "<script language='javascript'>";
		//echo "var Nprix = '".$_GET['Nprix']."';";
		echo "var numfiche = '".$_GET['numfiche']."';";
		echo 'swal("Vous êtes sur le point de supprimer la ligne ayant pour \nN° Enrég. : "+numfiche+". \n Voulez-vous vraiment continuer ?", {
			dangerMode: true, buttons: true,
		}).then((value) => { var Es = value;  document.location.href="loccupV.php?menuParent=Consultation&numfiche="+numfiche+"&px="+Es;
		}); ';
		echo "</script>";

}
if(isset($_GET['px'])&&($_GET['px']!="null")){
		$sql="SELECT compte2.client AS numcli FROM compte2,fraisconnexe WHERE fraisconnexe.numfiche=compte2.client  AND compte2.numfiche ='".$_GET['numfiche']."'";
		$Select=mysqli_query($con,$sql);
		$data=mysqli_fetch_object($Select);//echo $dataT=$data->numcli;
			
		$pre_sql1="DELETE FROM compte2 WHERE numfiche='".$_GET['numfiche']."'";
		$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
		$pre_sql1="DELETE FROM fraisconnexe WHERE numfiche='".$data->numcli."'";
		$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
		echo "<script language='javascript'>";
		echo 'swal("Suppression effectuée avec succès","","success")';
		echo "</script>";
		echo '<meta http-equiv="refresh" content="1; url=loccupV.php?menuParent=Consultation" />';
}


if(!empty($_GET['changeP']) && ($_GET['changeP']==1)){
echo "<script language='javascript'>";
echo "var numfiche = '".$_GET['numfiche']."';";
echo 'swal("Réduction sur le montant de la Chambre ", {
		content: {
		element: "input",
		attributes: {
		placeholder: " Saisissez le nouveau montant de la chambre ici",
		},
		},
		})
		.then((value) => {
			document.location.href="loccupV.php?menuParent='.$_SESSION['menuParenT'].'&numfiche="+numfiche+"&Nprix="+value;
		}); ';
echo "</script>";
}
if(isset($_GET['Nprix'])&&($_GET['Nprix']>0)&&(empty($_GET['test']))){ //$_SESSION['delete']=$_GET['clt'];
		echo "<script language='javascript'>";
		echo "var Nprix = '".$_GET['Nprix']."';"; echo "var numfiche = '".$_GET['numfiche']."';";
		echo 'swal("Vous êtes sur le point de changer le prix de la chambre. Le client concerné sera désormais facturé à "+Nprix+". Voulez-vous vraiment continuer ?", {
			dangerMode: true, buttons: true,
		}).then((value) => { var Es = value;  document.location.href="loccupV.php?menuParent='.$_SESSION['menuParenT'].'&numfiche="+numfiche+"&Nprix='.$_GET['Nprix'].'&test="+Es;
		}); ';
		echo "</script>";
	} if(!empty($_GET['test'])&&($_GET['test']=="true")){
			$update1=mysqli_query($con,"SELECT ttc_fixe,somme,ttax,ttva,tarif FROM mensuel_compte WHERE numfiche ='".$_GET['numfiche']."'");
			$data=mysqli_fetch_object($update1);$dataT=$data->ttc_fixe;$diff=abs($dataT-$_GET['Nprix']);$SumT=$data->somme;$ttax=$data->ttax;
			if($data->ttva!=0){
				$Ntarif=round(($_GET['Nprix']-$ttax)/(1+$data->ttva));
			}else $Ntarif=$data->tarif;
			if($SumT<=0){
			if($dataT>$_GET['Nprix']){
				$sql="SET ttc_fixeR='".$_GET['Nprix']."',tarif='".$Ntarif."' WHERE numfiche ='".$_GET['numfiche']."'";
				$update1=mysqli_query($con,"UPDATE compte ".$sql);$update1=mysqli_query($con,"UPDATE mensuel_compte ".$sql);
				echo "<script language='javascript'>";	echo "var diff = '".$diff."';";
				echo 'alertify.success(" Vous venez d\'appliquer une réducton d\'une valeur de "+diff+" sur le prix de la chambre !");';
				echo "</script>";
				echo '<meta http-equiv="refresh" content="2; url=loccupV.php?menuParent='.$_SESSION['menuParenT'].'" />';
			}else {
				echo "<script language='javascript'>";
				echo 'alertify.error("Dans le cas d\'une réduction, le nouveau montant doit être inférieur au montant réel de la chambre ");';
				echo "</script>";
			}
		}else{
			echo "<script language='javascript'>";
			echo 'alertify.error("Désolé ! Un loccupV a été déjà effectué. Vous ne pouvez plus appliquer une réduction sur le montant de la chambre.");';
			echo "</script>";
		}
		}
		if(!empty($_GET['test'])&&($_GET['test']=="null")){
			  echo "<script language='javascript'>";
				echo 'alertify.error(" L\'opération a été annulée !");';
			 	echo "</script>";
		}
		if(!empty($_GET['px'])&&($_GET['px']=="null")){
			  echo "<script language='javascript'>";
				echo 'alertify.error(" L\'opération a été annulée !");';
			 	echo "</script>";
		}
		if(!empty($_GET['px1'])&&($_GET['px1']=="null")){
			  echo "<script language='javascript'>";
				echo 'alertify.error(" L\'opération a été annulée !");';
			 	echo "</script>";
		}
		if(!empty($_GET['px2'])&&($_GET['px2']=="null")){
			  echo "<script language='javascript'>";
				echo 'alertify.error(" L\'opération a été annulée !");';
			 	echo "</script>";
		}
		if(!empty($_GET['px3'])&&($_GET['px3']=="null")){
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
