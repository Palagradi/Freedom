<?php
		include 'menu.php';
		include 'others/footerpdf.inc';
		//@session_start(); //unset($_SESSION['reimprime']);
		unset($_SESSION['Apply_AIB']); unset($_SESSION['ValAIB']);unset($_SESSION['PourcentAIB']);unset($_SESSION['numrecu']);unset($_SESSION['fact']);
		$reqsel=mysqli_query($con,"SELECT menu FROM role,affectationrole WHERE role.nomrole=affectationrole.nomrole  AND menuParent='Hébergement' AND menu='Check-in [Entrée]' AND Profil='".$_SESSION['poste']."'");
		if(mysqli_num_rows($reqsel)>0)
		  {$agent=1;//$et=0;
	    }
	$agent=isset($_GET['agent'])?$_GET['agent']:$_SESSION['poste'];
	unset($_SESSION['num']);unset($_SESSION['code_reel']);unset($_SESSION['avanceA']);	unset($_SESSION['groupe']);unset($_SESSION['groupe1']); unset($_SESSION['fiche']); unset($_SESSION['code_reel']); unset($_SESSION['Normalise']);	unset($_SESSION['remise']);unset($_SESSION['exhonerer_aib']);unset($_SESSION['exhonerer_tva']);unset($_SESSION['aIb']);unset($_SESSION['tVa']);unset($_SESSION['nature']);
	unset($_SESSION['Numreserv']); unset($_SESSION['client']); unset($_SESSION['TotalTaxe']);
?>
<html>
	<head>
		<link rel="Stylesheet" type="text/css" media="screen, print" href='style.css' />
		<script type="text/javascript" src="date-picker.js"></script>
		<script type="text/javascript">
		function edition() { options = "Width=600,Height=675" ; window.open( "receiptH.php", "edition", options ) ; }
		</script>
		</script>
		<script src="js/sweetalert.min.js"></script>
	</head>
	<body bgcolor='azure' style="">

		<?php 
			if(isset($_GET['id_request']))
				{
				$sqlA = "SELECT produits.Designation, produitsencours.GrpeTaxation,taxSpecific,RegimeTVA,produits.Designation AS LigneCde,produitsencours.prix,produitsencours.qte
				From e_mecef,produitsencours,produits WHERE produits.Num = produitsencours.LigneCde AND produitsencours.SIGNATURE_MCF = e_mecef.SIGNATURE_MCF  AND id_request='".$_GET['id_request']."'";
				mysqli_query($con,"SET NAMES 'utf8' ");
				$query = mysqli_query($con, $sqlA);
				$num=0;$data0="";$Mtotal=0; $TotalHT=0; $TotalTva=0;$TotalTva0=0;
				while($data=mysqli_fetch_array($query)){ $num++;
/* 				$customerIFU=$data['NumIFU']; if($customerIFU==0) $customerIFU=0;
				$userName=!empty($data['RaisonSociale'])?$data['RaisonSociale']:$data['Client'];
				$_SESSION['AdresseClt']=!empty($data['AdresseEn'])?$data['AdresseEn']:$data['AdresseClt'];
				$_SESSION['TelClt']=!empty($data['TelEn'])?$data['TelEn']:$data['TelClt']; */
				if($data['GrpeTaxation']=='A') $GrpeTaxation="A-EX";
				else if($data['GrpeTaxation']=='B') $GrpeTaxation="B";
				else if($data['GrpeTaxation']=='F') $GrpeTaxation="F";
				else $GrpeTaxation="E";

				$LigneCde=$data['LigneCde'];

				$LigneCde=$LigneCde." (".$GrpeTaxation.")";
				$prix=$data['prix'];
				$qte=$data['qte'];
				$mt=$prix*$qte; $Mtotal+=$mt ;
				$TotalHT0=round(($prix/1.18)*$qte) ;
				if($data['RegimeTVA']==1){
					//$TotalHT0=round($Mtotal/1.18) ;
					$TotalTva0=round(($Mtotal/1.18)*0.18) ;
				}
				//else
				if($GrpeTaxation=="E"){
					$TotalHT0=$Mtotal ;
				}else{
					//$TotalHT0=$Mtotal ;
					$TotalTva0=0 ;
					$prix=round($prix/1.18) ;
					$mt=$prix*$qte;
				}

				$TotalHT+=$TotalHT0 ;  $TotalTva+=$TotalTva0 ;

				$ecrire=fopen('txt/facture.txt',"w");
				$data0.=$LigneCde.';'.$prix.';'.$qte.';'.$mt."\n";
				$ecrire2=fopen('txt/facture.txt',"a+");
				fputs($ecrire2,$data0);
				}
				
				$sqlA = "SELECT * From e_mecef WHERE id_request='".$_GET['id_request']."'";
				$query = mysqli_query($con, $sqlA);$data=mysqli_fetch_object($query);
				$Montant = explode("-",$data->Montant);
				$operateur = explode("-",$data->operateur);
				$clients = explode("-",$data->clients);
				$_SESSION['TotalHT']=isset($Montant['0'])?$Montant['0']:0;
				$_SESSION['TotalTTC']=isset($Montant['1'])?$Montant['1']:0;
				$_SESSION['TotalTva']=$_SESSION['TotalTTC']-$_SESSION['TotalHT']; //A vérifier 
				$_SESSION['NumIFU']=isset($clients['0'])?$clients['0']:NULL;
				$_SESSION['client']=isset($clients['1'])?$clients['1']:NULL;
				$_SESSION['userId'] =isset($operateur['0'])?$operateur['0']:NULL; 
				$_SESSION['vendeur'] =isset($operateur['1'])?$operateur['1']:NULL;
				$_SESSION['objet'] =isset($operateur['3'])?$operateur['3']:NULL;
				$_SESSION['Mtotal']=$_SESSION['TotalTTC'];		

				$_SESSION['DT_HEURE_MCF']   = $data->DT_HEURE_MCF;
				$_SESSION['QRCODE_MCF']     = $data->QRCODE_MCF;
				$_SESSION['SIGNATURE_MCF']  = $data->SIGNATURE_MCF;
				$_SESSION['COMPTEUR_MCF']   = $data->COMPTEUR_MCF;
				$_SESSION['NIM_MCF']        = $data->NIM_MCF;
				
				//$_SESSION['date_emission']=			  
				
				if(substr($data->COMPTEUR_MCF,0-2)=="FV") $_SESSION['FV']=1; $_SESSION['Date_actuel'] = $Date_actuel;    
														
				if(isset($_GET['receipt'])) 
					{ include('receiptH.php');
					}else { 
					echo "<center><iframe src='facture1.php";   echo "' width='1000' height='800' style=''></iframe></center>";	
					}
				}
			else {
					
		?>
			<form action="reediterFacturee.php?menuParent=Facturation<?php   if(isset($_GET['avoir'])) echo "&avoir=".$_GET['avoir'];  ?>	" method="POST" style='text-align:center;font-family:cambria;'>
				<hr align='center' style='border:1px solid white;width:80%;'>

				<?php  $agent=1;
				//if(isset($_GET['p']))
				{
				echo "	<table align='center'>
				<td><b>Période du :&nbsp;&nbsp; </b></td>
				<td>
					<input type='date' required name='debut' id='' size='50'  style='height:25px;width:200px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value''/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				<td> <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AU:&nbsp;&nbsp; </b></td>
				<td>
					<input type='date' required name='fin' id='' size='50'  style='height:25px;width:200px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value''/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='Submit' name='OK' value='OK' class='bouton3' style='border:2px solid white;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;'/></td>

				<input type='hidden' name='agent' value='". $agent."'/>
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
					<tr style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#B83A1B;">
					<?php if(isset($_GET['avoir']))   $tx="ETABLISSEMENT D'UNE FACTURE D'AVOIR"; else  $tx="LISTE DE FACTURES NORMALISEES"; 
					?>
					<td colspan='2' style="" align="left"><?php echo $tx;?></td>
					
					 <?php if(!isset($_GET['avoir']))  { ?>
							<!--<span style='float:right;display:block;font-size:1.4em;color:white;'>&nbsp;&nbsp;Facture d'avoir </span>-->
					 <?php } ?>
					</tr>
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
									$query_Recordset1 = "SELECT DISTINCT id_request,produitsencours.Client,e_mecef.COMPTEUR_MCF,e_mecef.SIGNATURE_MCF,id_request,DT_HEURE_MCF,clients,operateur,Montant FROM e_mecef,produitsencours WHERE e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF AND e_mecef.date BETWEEN '".$_POST['debut']."' AND '".$_POST['fin']."'";
								else
									$query_Recordset1 = "SELECT DISTINCT id_request,produitsencours.Client,e_mecef.COMPTEUR_MCF,e_mecef.SIGNATURE_MCF,id_request,DT_HEURE_MCF,clients,operateur,Montant FROM e_mecef,produitsencours WHERE e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF AND e_mecef.date='".$Jour_actuel."' ORDER BY e_mecef.id_request DESC";

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
										
										$sqlA = "SELECT * From e_mecef WHERE id_request='".$data['id_request']."'";
										$query = mysqli_query($con, $sqlA);$data0=mysqli_fetch_object($query);
										//$Montant = explode("-",$data->Montant);
										//$operateur = explode("-",$data->operateur);
										$clients = explode("-",$data0->clients);
										$client=isset($clients['1'])?$clients['1']:NULL;										
				
										$operat = explode("-",$data['operateur']);
										$id_operateur=$operat['0']; $operateur=$operat['1'];
										$montant = explode("-",$data['Montant']);
										$mtTTC=$montant['1'];
										if($montant['2']>0)
										$mtTTC=$mtTTC-$montant['2'];
										//$clients = explode("-",$data['Clients']);
										
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$i.".</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".substr($data['DT_HEURE_MCF'],0,10)."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".substr($data['DT_HEURE_MCF'],11,8)."</td>";
										echo " 	<td align='left' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >&nbsp;&nbsp;".$client."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$operateur."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$mtTTC."</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
										if(isset($_GET['avoir'])){
											if(substr($data['COMPTEUR_MCF'],0-2)=="FV"){
												
												
											}
											//echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<a href='reimprimer.php?avoir=1&SIGNATURE_MCF=".$data['SIGNATURE_MCF']."'><img src='images/b_drop.png' alt='Version imprimable' title='Annuler la facture' width='20' height='20' border='0'></a>";
											else
												echo "Facture annulée ";
										}
										else{
												echo "<a class='info' href='reediterFacturee.php?menuParent=Facturation&receipt=0&id_request=".$data['id_request']."' style='color:pick;'>
													<span style='font-size:0.9em;font-style:normal;color:pick;'>Reçu de caisse
													</span>	 <i class='fas fa-print' aria-hidden='true' style='font-size:100%;'></i></a>";
												echo "&nbsp;&nbsp;
												<a class='info2' href='reediterFacturee.php?menuParent=Facturation&id_request=".$data['id_request']."' style='color:pick;'>
												<span style='font-size:0.9em;font-style:normal;color:pick;'>Facture client
												</span>	 <i class='fas fa-file-pdf' aria-hidden='true' style='font-size:100%;'></i></a>";
												//echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<a href='reimprimer.php?SIGNATURE_MCF=".$data['SIGNATURE_MCF']."'><img src='images/b_print.png' alt='Version imprimable' title='Réimprimer la facture' width='20' height='20' border='0'></a>";
											}
											
									echo " 	</tr> ";
							}
					?>
				</table>
			</div>
		<?php 
			}					
		?>
	</body>

</html>
