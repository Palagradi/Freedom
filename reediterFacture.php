<?php
	include 'menu.php';
	$trie=isset($_GET['trie'])?$_GET['trie']:NULL;
	echo $all=isset($_GET['all'])?$_GET['all']:NULL;
	if($trie==1) $trier= "num_art1";if($trie==2) $trier= "Nom ASC,prenoms";
	if($trie==3) $trier= "profession";if($trie==4) $trier= "quartier";
	if($trie==5) $trier= "Q";if($trie==6) $trier= "I";
	if($trie==7) $trier= "P";if($trie==8) $trier= "NC";
	if($trie==9) $trier= "loyer_mensuel";
	if($trie==10) $trier= "nbre_mois";

	$_SESSION['call_emecef']=0;

	//}

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>EFIFE - BENIN - COOP</title>
		<link rel="Stylesheet" href='css/table.css' />
		<link rel="Stylesheet" type="text/css"  href='css/input.css' />
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>
		<script type="text/javascript" src="js/jquery.js"></script>
		</script>	<script src="js/sweetalert.min.js"></script>
	</head>
	<body bgcolor="#99B5B6">
			<?php

			if(isset($_GET['px'])&&($_GET['px']!="null")){// echo $_GET['px']; //exit();
				$_SESSION['reference']=str_replace('-', '', $_GET['SIGNATURE_MCF']);

				$sqlA = "SELECT * FROM produitsencours,e_mecef WHERE produitsencours.SIGNATURE_MCF=e_mecef.SIGNATURE_MCF AND e_mecef.SIGNATURE_MCF='".$_GET['SIGNATURE_MCF']."'";
				//mysqli_query($con,"SET NAMES 'utf8' ");
				$query = mysqli_query($con, $sqlA);
				$query = mysqli_query($con,$sqlA);
				if (!$query) {
					printf("Error: %s\n", mysqli_error($con));
					exit();
				}
				$num=0;$data0="";$Mtotal=0; $TotalHT=0; $TotalTva=0;$TotalTva0=0;
				while($data=mysqli_fetch_array($query)){ $num++;
				$operat = explode("-",$data['operateur']);
				$_SESSION['userId']=$operat['0'];$_SESSION['vendeur']=$operat['1'];
				$_SESSION['objet']=utf8_encode($operat['3']); $_SESSION['modeReglement']=$operat['2'];
				$montant = explode("-",$data['Montant']);
				$Mtotal=$montant['1']-$montant['2'];
				$remise=$montant['2']; $Date=substr($data['DT_HEURE_MCF'],0,10);
				$client1 = explode("-",$data['clients']);
				$customerIFU=$client1['0']; if($customerIFU==0) $customerIFU=null;
				$userName=$client1['1'];	$_SESSION['initial_fiche'] = $data['NIM_MCF'] ;
				//$_SESSION['AdresseClt']=$data['quartier']." ".$data['ville'];$_SESSION['TelClt']=$data['Telephone'];
			/* 	if($data['GrpeTaxation']=='A') $GrpeTaxation="A-EX";
				else if($data['GrpeTaxation']=='B') $GrpeTaxation="B";
				else if($data['GrpeTaxation']=='F') $GrpeTaxation="F";
				else $GrpeTaxation="E";	 */

				$LigneCde=$data['LigneCde']; $GrpeTaxation=$data['GrpeTaxation']; $RegimeTVA=$data['RegimeTVA'];

				$etat=1;$nomcli=$data['Client'];$nomcli=$data['Client'];$prixUnit=$data['prix'];$Qte=$data['qte'];$nomcli=$data['Client'];
				$sql='INSERT INTO produitsencours(`Num`,`SIGNATURE_MCF`,`Client`,`LigneCde`,`prix`,`qte`,`Etat`,`GrpeTaxation`,`RegimeTVA`)
				VALUES(NULL,"","'.$nomcli.'","'.$LigneCde.'","'.$prixUnit.'","'.$Qte.'","'.$etat.'","'.$GrpeTaxation.'","'.$RegimeTVA.'") ';
				$query2 = mysqli_query($con, $sql);

				$LigneCde=$LigneCde." (".$GrpeTaxation.")";
				$prix=$data['prix'];$qte=$data['qte'];
				$mt=$prix*$qte; //$Mtotal+=$mt ;
/* 				$TotalHT0=round(($prix/1.18)*$qte) ;
				if($data['RegimeTVA']==1){
					$TotalTva0=round(($Mtotal/1.18)*0.18) ;
				}
				if($GrpeTaxation=="E"){
					$TotalHT0=$Mtotal ;
				}else{
					$TotalTva0=0 ;
					$prix=round($prix/1.18) ;
					$mt=$prix*$qte;
				}
				$TotalHT+=$TotalHT0 ;  $TotalTva+=$TotalTva0 ;  */

				$ecrire=fopen('txt/facture.txt',"w");
				$data0.=$LigneCde.';'.-$prix.';'.$qte.';'.-$mt."\n";
				$ecrire2=fopen('txt/facture.txt',"a+");
				fputs($ecrire2,$data0);
			}

			 //$_SESSION['objet']=utf8_decode("Transaction numérique") ; //$_SESSION['vendeur']=$_SESSION['nom'];
			 $_SESSION['TotalTTC']=-$Mtotal; $_SESSION['Mtotal']=-$Mtotal;  //$_SESSION['TotalTaxe']=1000;
			 $_SESSION['TotalHT']= -$Mtotal  ;
			 $_SESSION['TotalTva']= isset($TotalTva)?$TotalTva:0;
			 $_SESSION['NumIFU']=isset($customerIFU)?$customerIFU:NULL;
			 $_SESSION['client']=isset($userName)?$userName:NULL;
			 $_SESSION['Date_actuel']=$Date_actuel;
			 $_SESSION['FV']=0; // Pour facture d'avoir

			 $_SESSION['call_emecef']=1;
			 $_SESSION['norm']=isset($_GET['norm'])?$_GET['norm']:0;

				echo "<iframe src='checkingOK.php";  echo "' width='1000' height='800' scrolling='no' allowtransparency='true' FRAMEBORDER='yes' style='margin-left:10%;margin-top:-25px;'></iframe>";
				}
			else {
			if(isset($_GET['SIGNATURE_MCF']))  {

				if(isset($_GET['avoir'])){
				echo "<script language='javascript'>";
				echo 'swal("Vous êtes sur le point d\'éditer une facture d\'avoir. Ceci aura pour conséquence l\'annulation de la facture normalisée. Veuillez noter que cette action est irréversible.Voulez-vous continuer ?", {
					dangerMode: true, buttons: true,
				}).then((value) => { var Es = value;  document.location.href="reediterFacture.php?SIGNATURE_MCF='.$_GET['SIGNATURE_MCF'].'&px="+Es;
				}); ';
				echo "</script>";

				}else{

				echo $sqlA = "SELECT DISTINCT * FROM e_mecef,produitsencours WHERE e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF  AND e_mecef.SIGNATURE_MCF='".$_GET['SIGNATURE_MCF']."'";
				//mysqli_query($con,"SET NAMES 'utf8' ");
				$query = mysqli_query($con, $sqlA);$num=0;$data0="";$Mtotal=0; $TotalHT=0; $TotalTva=0;$TotalTva0=0;
				while($data=mysqli_fetch_array($query)){ $num++;

				$operat = explode("-",$data['operateur']);
				$_SESSION['userId']=$operat['0'];$_SESSION['vendeur']=$operat['1'];
				$_SESSION['objet']=$operat['3']; $_SESSION['modeReglement']=$operat['2'];
				$montant = explode("-",$data['Montant']);
				$Mtotal=$montant['1'];
				if($montant['2']>0)
					$Mtotal=$Mtotal-$montant['2'];
				$remise=$montant['2']; $Date=substr($data['DT_HEURE_MCF'],0,10);

				$client1 = explode("-",$data['clients']);

				$customerIFU=$client1['0']; if($customerIFU==0) $customerIFU=null;
				//$_SESSION['AdresseClt']=$data['quartier']." ".$data['ville'];$_SESSION['TelClt']=$data['Telephone'];

				$userName=$client1['1'];	$_SESSION['initial_fiche'] = $data['NIM_MCF'] ;

				$_SESSION['DT_HEURE_MCF']   = isset($data['DT_HEURE_MCF'])?$data['DT_HEURE_MCF']:NULL;
				$_SESSION['QRCODE_MCF']     = isset($data['QRCODE_MCF'])?$data['QRCODE_MCF']:NULL;
				$_SESSION['SIGNATURE_MCF']   = isset($data['SIGNATURE_MCF'])?$data['SIGNATURE_MCF']:NULL;
				$_SESSION['COMPTEUR_MCF']   = isset($data['COMPTEUR_MCF'])?$data['COMPTEUR_MCF']:NULL;
				$NIM_MCF = explode("-",$data['NIM_MCF']);$_SESSION['NIM_MCF']        = $NIM_MCF['0'];

				if($data['GrpeTaxation']=='A') $GrpeTaxation="A-EX";
				else if($data['GrpeTaxation']=='B') $GrpeTaxation="B";
				else if($data['GrpeTaxation']=='F') $GrpeTaxation="F";
				else $GrpeTaxation="E";
				$LigneCde=$data['LigneCde']." (".$GrpeTaxation.")";
				$prix=$data['prix'];
				$qte=$data['qte'];
				$mt=$prix*$qte;
				$ecrire=fopen('txt/facture.txt',"w");
				$data0.=$LigneCde.';'.$prix.';'.$qte.';'.$mt."\n";
				$ecrire2=fopen('txt/facture.txt',"a+");
				fputs($ecrire2,$data0);
			}

			 $_SESSION['TotalTTC']=$Mtotal; $_SESSION['Mtotal']=$Mtotal;  //$_SESSION['TotalTaxe']=1000;
			 $_SESSION['TotalHT']= $Mtotal  ;
			 $_SESSION['TotalTva']= $TotalTva;
			 $_SESSION['NumIFU']=$customerIFU;
			 $_SESSION['client']=$userName;
			 $_SESSION['remise']=$remise;
			 $_SESSION['Date_actuel']=$Date;
			 $_SESSION['FV']=1;
			 
			 $_SESSION['avanceA'] = $Mtotal;

			if(!isset($_GET['px'])){
				//$_SESSION['Apply_AIB']=1;
				$facture="FactureNormaliseeTPS";//$facture="facture2";$facture="facture3";
				echo "<iframe src='".$facture.".php";  echo "' width='1000' height='800' scrolling='no' allowtransparency='true' FRAMEBORDER='yes' style='margin-left:10%;margin-top:-25px;'></iframe>";
				}
			else
				echo '<meta http-equiv="refresh" content="0; url=reediterFacture.php?avoir=1" />';
			}
			}else{
			?>

			<form action="reediterFacture.php?<?php   if(isset($_GET['avoir'])) echo "avoir=".$_GET['avoir'];  ?>	" method="POST" style='text-align:center;font-family:cambria;'>
				<hr align='center' style='border:1px solid white;width:80%;'>

				<?php  $agent=1;
				//if(isset($_GET['p']))
				{
				echo "	<table align='center'>
				<td><br/><b>Période du :&nbsp;&nbsp; </b></td>
				<td>
					<br/><input type='date' required name='debut' id='' size='50'  style='width:200px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value''/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				<td> <br/><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AU:&nbsp;&nbsp; </b></td>
				<td>
					<br/><input type='date' required name='fin' id='' size='50'  style='width:200px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value''/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				</td>
				<td><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='Submit' name='OK' value='OK' class='bouton3' style='border:2px solid white;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;'/></td>

				<input type='hidden' name='agent' value='". $agent."'/>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				</table>";
					}//else echo "&nbsp;<br/>";
					?>
				<hr align='center' style='border:1px solid white;width:80%;'>
			</form>

			<!--fin du formulaire-->

			<!--preparation de l'affichage des resultats-->
			<div id="resultsC">

				<table align='center' width="80%"  border="0" cellspacing="0" style="border-collapse: collapse;font-family:Cambria;">
					<caption style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#B83A1B;">
					<?php if(isset($_GET['avoir']))  echo "ETABLISSEMENT D'UNE FACTURE D'AVOIR"; else echo "LISTE DE FACTURES NORMALISEES"; ?>
					<span style="font-style:italic;font-size:0.6em;color:black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					 <B>
					 <?php if(!isset($_GET['avoir']))  { ?>
					<span style='float:right;display:block;font-size:1.4em;color:white;'>&nbsp;&nbsp;Facture d'avoir </span>
					 <div style='float:right;border:2px solid white; background-color:#77b5fe;width:15px;height:15px;'> </div>
					 <?php } ?>
					</caption>
					<tr style=" background-color:#103550;color:white;font-size:1.2em; padding-bottom:5px;">
						<td style="border-right: 2px solid #ffffff" align="center">N° d'ordre</td>
						<td style="border-right: 2px solid #ffffff" align="center">Date d'émission</td>
						<td style="border-right: 2px solid #ffffff" align="center">Heure d'émission</td>
						<td style="border-right: 2px solid #ffffff" align="center">Opérateur/Emetteur</td>
						<td style="border-right: 2px solid #ffffff" align="center">Identité du Client</td>
						<td style="border-right: 2px solid #ffffff" align="center">Montant </td>
						<td align="center" >Actions</td>
					</tr>
					<?php
	/* 				if (isset($_POST['ok'])&& $_POST['ok']=='Rechercher')
							{  //$_SESSION['fiche']=1;
							   $edit4=trim(addslashes($_POST['edit4']));
							    $query_Recordset1 = "SELECT * FROM contribuable WHERE num_art1  LIKE '$edit4%' OR Nom LIKE '$edit4%' OR prenoms LIKE '$edit4%' ";
							   $fiche=$_POST['edit_4'];
							  // if($_SESSION['fiche']==1)
							}
							else  */
								//if($trie!='')
							   //  $query_Recordset1 = "SELECT * FROM contribuable WHERE annee='$annee' ORDER BY $trier ASC";
							// else


								if(isset($_POST['OK']) && $_POST['OK'] == "OK")
								$query_Recordset1 = "SELECT DISTINCT produitsencours.Client,e_mecef.COMPTEUR_MCF,e_mecef.SIGNATURE_MCF,id_request,DT_HEURE_MCF,clients,operateur,Montant FROM e_mecef,produitsencours WHERE e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF
								AND e_mecef.date BETWEEN '".$_POST['debut']."' AND '".$_POST['fin']."'";
								else
					            $query_Recordset1 = "SELECT DISTINCT produitsencours.Client,e_mecef.COMPTEUR_MCF,e_mecef.SIGNATURE_MCF,id_request,DT_HEURE_MCF,clients,operateur,Montant FROM e_mecef,produitsencours WHERE e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF AND e_mecef.date='".$Jour_actuel."' ORDER BY e_mecef.id_request DESC";

							$cpteur=1;mysqli_query($con,"SET NAMES 'utf8'");
							$Recordset_2 = mysqli_query($con,$query_Recordset1);$i=0;
							//$reqsel=mysql_query("SELECT * FROM contribuable WHERE commune='$commune_tempon' ");
							while($data=mysqli_fetch_array($Recordset_2))
							{	$i++;
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
								if(!isset($_GET['avoir']))   { if(substr($data['COMPTEUR_MCF'],0-2)!="FV") $bgcouleur="#77b5fe"; }
								echo " 	<tr bgcolor='".$bgcouleur."'>";
										//$operateur=$data['operateur'];
										$operat = explode("-",$data['operateur']);
										$id_operateur=$operat['0']; $operateur=$operat['1'];
										$montant = explode("-",$data['Montant']);
										$mtTTC=$montant['1'];
										if($montant['2']>0)
										$mtTTC=$mtTTC-$montant['2'];
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$i.".</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".substr($data['DT_HEURE_MCF'],0,10)."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".substr($data['DT_HEURE_MCF'],11,8)."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$data['Client']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$operateur."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$mtTTC."</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
										if(isset($_GET['avoir'])){
											if($data['EtatF']=="V")
											echo " &nbsp;&nbsp;	<a href='reimprimer.php?avoir=1&SIGNATURE_MCF=".$data['SIGNATURE_MCF']."&NIM_MCF=".$data['NIM_MCF']."'><img src='logo/b_drop.png' alt='Version imprimable' title='Annuler la facture' width='20' height='20' border='0'></a>";
											else if($data['EtatF']=="AN")
												echo "&nbsp;&nbsp;<a href='#' style='text-decoration:none;' title='Cette facture a été annulée.'><span style='color:green;font-size:1.2em;'> ✔</span></a>";
											else {
													$SIGNATURE_MCF = explode("|",$data['EtatF']); 
													$SIGNATURE_MCF0=isset($SIGNATURE_MCF['1'])?$SIGNATURE_MCF['1']:NULL;
													$SIGNATURE_MCF1=isset($SIGNATURE_MCF['2'])?$SIGNATURE_MCF['2']:NULL;													
													echo "&nbsp;&nbsp;<a href='#' style='text-decoration:none;' title='"; 
													echo "N° Facture originale : ". $SIGNATURE_MCF1;
													echo " (Réf. Facture originale : ". $SIGNATURE_MCF0.")";
													echo "'><span style='color:white;font-size:1.2em;'> ✔</span></a>";
												
												}
										}
										else {
											echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<a href='reimprimer.php?SIGNATURE_MCF=".$data['SIGNATURE_MCF']."&EtatF=".$data['EtatF']."'><img src='logo/b_print.png' alt='Version imprimable' title='Réimprimer la facture' width='20' height='20' border='0'></a>";
											
											}
									echo " 	</tr> ";
							}
					?>
				</table>
			</div>

			<?php
			}
			}
			?>
	<script type="text/javascript" >
			$(document).ready( function() {
		  // détection de la saisie dans le champ de recherche
		  $('#q').keyup( function(){
			$field = $(this);
			$('#resultsC').html(''); // on vide les resultats

			//document.getElementById('q').style.backgroundColor="#84CECC";
			var fiche =  document.getElementById('fiche');
			$('#ajax-loader').remove(); // on retire le loader

			// on commence à traiter à partir du 2ème caractère saisie
			if( $field.val().length > 1 )
			{  $('#resultsC').html('');
			  // on envoie la valeur recherché en GET au fichier de traitement
			  $.ajax({
			type : 'GET', // envoi des données en GET ou POST
			url : 'ajax-search.php' , // url du fichier de traitement
			data : 'q='+$(this).val() , // données à envoyer en  GET ou POST
			beforeSend : function() { // traitements JS à faire AVANT l'envoi
				$field.after('<img src="logo/wp2d14cca2.gif" alt="loader" id="ajax-loader" />'); // ajout d'un loader pour signifier l'action
			},
			success : function(data){ // traitements JS à faire APRES le retour d'ajax-search.php
				$('#ajax-loader').remove(); // on enleve le loader
				$('#resultsC').html(data); // affichage des résultats dans le bloc
			}
			  });
			}
		  });
		});
		</script>
	</body>
</html>
<?php
	// $Recordset1->Close();
?>
