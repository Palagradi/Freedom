<?php
		include 'menu.php';
		include 'others/footerpdf.inc';
		//@session_start(); //unset($_SESSION['reimprime']);
		unset($_SESSION['Apply_AIB']); unset($_SESSION['ValAIB']);unset($_SESSION['PourcentAIB']);unset($_SESSION['numrecu']);unset($_SESSION['fact']);
		$reqsel=mysqli_query($con,"SELECT menu FROM role,affectationrole WHERE role.nomrole=affectationrole.nomrole  AND menuParent='Hébergement' AND menu='Check-in [Entrée]' AND Profil='".$_SESSION['poste']."'");
		if(mysqli_num_rows($reqsel)>0)
		  {$agent=1;//$et=0;
	    }
	unset($_SESSION['num']);unset($_SESSION['code_reel']);unset($_SESSION['avanceA']);	unset($_SESSION['groupe']);unset($_SESSION['groupe1']); unset($_SESSION['fiche']); unset($_SESSION['code_reel']); unset($_SESSION['Normalise']);	unset($_SESSION['remise']);unset($_SESSION['exhonerer_aib']);unset($_SESSION['exhonerer_tva']);unset($_SESSION['aIb']);unset($_SESSION['tVa']);unset($_SESSION['nature']);
	unset($_SESSION['Numreserv']); unset($_SESSION['client']); unset($_SESSION['TotalTaxe']);
	
	
 $begin  = isset($_POST['debut'])?$_POST['debut']:$Jour_actuel; 
 $end  = isset($_POST['fin'])?$_POST['fin']:$Jour_actuel;   

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
	
				if(isset($_GET['px'])&&($_GET['px']!="null")){// echo $_GET['px']; //exit();
			
				//echo  $_SESSION['ref_initial']=isset($_GET['NIM_MCF'])?$_GET['NIM_MCF']:NULL;			
				//$_SESSION['reference']=str_replace('-', '', $_GET['SIGNATURE_MCF']); //$_SESSION['id_request']=isset($_GET['SIGNATURE_MCF'])?$_GET['SIGNATURE_MCF']:NULL;
							 
				$sqlA = "SELECT * FROM produitsencours,e_mecef WHERE produitsencours.SIGNATURE_MCF=e_mecef.SIGNATURE_MCF AND e_mecef.SIGNATURE_MCF='".$_GET['SIGNATURE_MCF']."' AND (e_mecef.EtatF='V')";
				mysqli_query($con,"SET NAMES 'utf8' ");
				//$query = mysqli_query($con, $sqlA);
				$query = mysqli_query($con,$sqlA);
				if (!$query) {
					printf("Error: %s\n", mysqli_error($con));
					exit();
				}
				$num=0;$data0="";$Mtotal=0; $TotalHT=0; $TotalTva=0;$TotalTva0=0;
				while($data=mysqli_fetch_array($query)){ $num++;
				$operat = explode("|",$data['operateur']);
				$_SESSION['userId']=$operat['0'];$_SESSION['vendeur']=$operat['1'];
				$_SESSION['objet']=utf8_encode($operat['3']); $_SESSION['modeReglement']=$operat['2'];
				$montant = explode("|",$data['Montant']); 
				$Mtotal=$montant['1']-$montant['2'];
				$remise=$montant['2']; $Date=substr($data['DT_HEURE_MCF'],0,10);
				$client1 = explode("|",$data['clients']);
				$customerIFU=$client1['0']; if($customerIFU==0) $customerIFU=null;
				$userName=$client1['1'];	$_SESSION['initial_fiche'] = $data['NIM_MCF'] ;

				$_SESSION['SIGNATURE_MCF0']=isset($_GET['SIGNATURE_MCF'])?$_GET['SIGNATURE_MCF']:NULL;
				$_SESSION['SIGNATURE_MCF1']=isset($_GET['NIM_MCF'])?$_GET['NIM_MCF']:NULL;

				$sqlB = "SELECT du,au FROM reedition_facture WHERE id_request='".$data['id_request']."'";
				mysqli_query($con,"SET NAMES 'utf8' ");
				$queryZ = mysqli_query($con,$sqlB);
				$dataZ=mysqli_fetch_object($queryZ);
				$_SESSION['debut']= $dataZ->du;$_SESSION['fin']= $dataZ->au;

				$LigneCde=$data['LigneCde']; $GrpeTaxation=$data['GrpeTaxation']; $RegimeTVA=$data['RegimeTVA']; $taxSpecific=0;

				$etat=4;$nomcli=trim($data['Client']);$nomcli=str_replace(';',' ', $nomcli);$prixUnit=$data['prix'];$Qte=$data['qte'];//$nomcli=$data['Client'];
				$insert="INSERT INTO produitsencours SET Num=NULL,SIGNATURE_MCF='',Client='".$nomcli."', LigneCde ='".$LigneCde."',prix ='".$prixUnit."',qte ='".$Qte."',Etat='".$etat."',GrpeTaxation='".$GrpeTaxation."',taxSpecific='".$taxSpecific."',RegimeTVA='".$RegimeTVA."',Type=1";
				$query2 = mysqli_query($con, $insert);

				$LigneCde=$LigneCde." (".$GrpeTaxation.")";$numcli='';
				$prix=$data['prix'];$qte=$data['qte'];
				$mt=$prix*$qte; 
				 $_SESSION['EtatF']='A'; //Ceci est une facture d'avoir
				$ecrire=fopen('txt/facture.txt',"w");
				//$data0.=$LigneCde.';'.$prix.';'.$qte.';'.$mt."\n";
				if(($_SESSION['objet']=="Location de salle")||($_SESSION['objet']=="Restauration"))
					$data0.=$numcli.';'.$nomcli.';'.$LigneCde.';'.$prix.';'.$qte.';'.$mt."\n";
				else 
					$data0.=$numcli.';'.$nomcli.';'.$LigneCde.';'.$prix.';'.$qte.';'.$mt."\n";
				$ecrire2=fopen('txt/facture.txt',"a+");
				fputs($ecrire2,$data0);
			}

			$update=mysqli_query($con,"UPDATE configuration_facture SET numFactNorm=numFactNorm+1 ");
			
			 $_SESSION['TotalTTC']=-$Mtotal; $_SESSION['Mtotal']=-$Mtotal;  //$_SESSION['TotalTaxe']=1000;
			 $_SESSION['TotalHT']= -$Mtotal  ;
			 $_SESSION['TotalTva']= isset($TotalTva)?$TotalTva:0;
			 $_SESSION['NumIFU']=isset($customerIFU)?$customerIFU:NULL;
			 $_SESSION['client']=isset($userName)?$userName:NULL;
			 $_SESSION['Date_actuel']=$Date_actuel;
			 //$_SESSION['FV']=0; // Pour facture d'avoir
			 $_SESSION['call_emecef']=1;
			 $_SESSION['norm']=isset($_GET['norm'])?$_GET['norm']:0; 
			 $_SESSION['EtatF']="A";
			 $_SESSION['avanceA']=0;

				//echo "<center><iframe src='checkingOK.php";  echo "' width='1000' height='800' scrolling='no' allowtransparency='true' FRAMEBORDER='yes' style=''></iframe></center>";
				  echo "<center><iframe src='checkingOK.php";  echo "' width='1000' height='800' style=''></iframe></center>";
			}
			else if(isset($_GET['avoir']))  { 
			
			$_SESSION['EtatF']=isset($_GET['EtatF'])?$_GET['EtatF']:NULL;
			
			if(isset($_GET['SIGNATURE_MCF']))  {
			
				$_SESSION['id_request']=$_GET['SIGNATURE_MCF']; $_SESSION['reference']=str_replace('-', '', $_GET['SIGNATURE_MCF']);
				$_SESSION['ref_initial']=isset($_GET['ref_initial'])?$_GET['ref_initial']:NULL;
				
				 $query="DELETE FROM produitsencours WHERE SIGNATURE_MCF='' AND `Etat` = '1'";
				 //$res1=mysqli_query($con,$query);

				if(isset($_GET['avoir'])){  //$_GET['SIGNATURE_MCF0'];
				echo "<script language='javascript'>";
				echo 'swal("Vous êtes sur le point d\'éditer une facture d\'avoir. Ceci aura pour conséquence l\'annulation de la facture normalisée. Veuillez noter que cette action est irréversible.Voulez-vous continuer ?", {
					dangerMode: true, buttons: true,
				}).then((value) => { var Es = value;  document.location.href="FactureAvoir.php?menuParent=Facturation&SIGNATURE_MCF='.$_GET['SIGNATURE_MCF'].'&SIGNATURE_MCF='.$_GET['SIGNATURE_MCF'].'&px="+Es;   SIGNATURE_MCF0
				}); ';
				echo "</script>";

				}else{ 
				
				$sqlA = "SELECT DISTINCT * FROM e_mecef,produitsencours WHERE e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF  AND e_mecef.SIGNATURE_MCF='".$_GET['SIGNATURE_MCF']."'";
				//mysqli_query($con,"SET NAMES 'utf8' ");
				$query = mysqli_query($con, $sqlA);$num=0;$data0="";$Mtotal=0; $TotalHT=0; $TotalTva=0;$TotalTva0=0;
				while($data=mysqli_fetch_array($query)){ $num++;

				$operat = explode("|",$data['operateur']);
				$_SESSION['userId']=$operat['0'];$_SESSION['vendeur']=$operat['1'];
				$_SESSION['objet']=$operat['3']; $_SESSION['modeReglement']=$operat['2'];
				$montant = explode("|",$data['Montant']);
				$Mtotal=$montant['1'];
				if($montant['2']>0)
					$Mtotal=$Mtotal-$montant['2'];
				$remise=$montant['2']; $Date=substr($data['DT_HEURE_MCF'],0,10);

				$client1 = explode("|",$data['clients']);

				$customerIFU=$client1['0']; if($customerIFU==0) $customerIFU=null;
				//$_SESSION['AdresseClt']=$data['quartier']." ".$data['ville'];$_SESSION['TelClt']=$data['Telephone'];

				$userName=$client1['1'];	

				$_SESSION['DT_HEURE_MCF']   = isset($data['DT_HEURE_MCF'])?$data['DT_HEURE_MCF']:NULL;
				$_SESSION['QRCODE_MCF']     = isset($data['QRCODE_MCF'])?$data['QRCODE_MCF']:NULL;
				$_SESSION['SIGNATURE_MCF']   = isset($data['SIGNATURE_MCF'])?$data['SIGNATURE_MCF']:NULL;
				$_SESSION['COMPTEUR_MCF']   = isset($data['COMPTEUR_MCF'])?$data['COMPTEUR_MCF']:NULL;
				//$NIM_MCF = explode("|",$data['NIM_MCF']);$_SESSION['NIM_MCF']        = $NIM_MCF['0'];

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
				
				$_SESSION['EtatF']=$data['EtatF'];
				$_SESSION['initial_fiche']=$data['NIM_MCF'];	
			}

			 $_SESSION['TotalTTC']=$Mtotal; $_SESSION['Mtotal']=$Mtotal;  //$_SESSION['TotalTaxe']=1000;
			 $_SESSION['TotalHT']= $Mtotal  ;
			 $_SESSION['TotalTva']= $TotalTva;
			 $_SESSION['NumIFU']=$customerIFU;
			 $_SESSION['client']=$userName;
			 $_SESSION['remise']=$remise;
			 $_SESSION['Date_actuel']=$Date;


			if(!isset($_GET['px'])){  
				//echo $_SESSION['EtatF']=isset($_GET['EtatF'])?$_GET['EtatF']:NULL; 
				if($_SESSION['EtatF']=="AN") $_SESSION['EtatF']='V';
				else if(substr($_SESSION['EtatF'],0,1)=="A") $_SESSION['EtatF']='A';
				else $_SESSION['EtatF']='V';
				$facture="facture2";//$facture="facture2";$facture="facture3";
				echo "<center><iframe src='".$facture.".php";  echo "' width='1000' height='800' scrolling='no' allowtransparency='true' FRAMEBORDER='yes' style=''></iframe></center>";
				}
			else
				echo '<meta http-equiv="refresh" content="0; url=FactureAvoir.php?menuParent=Facturation&avoir=1" />';
			}
			}
		}		
	else { //echo 125;
	?>	<div align="" style="margin-top:-60px;">
		<form  action='FactureAvoir.php?menuParent=Facturation&p=1' method='post' name='FactureAvoir' id='chgdept'>
		<table align="center" width="1100" border="0" cellspacing="0" style="margin-top:40px;border-collapse: collapse;font-family:Cambria;">
			<tr>
				<td colspan='8'>
					<hr noshade size=3> <div align="center"><B>
					<FONT SIZE=6 COLOR="Maroon"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ETABLISSEMENT D'UNE FACTURE D'AVOIR </FONT></B><B> <span style='font-style:italic;font-size:0.8em;color:#444739;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php
					echo "<span style=font-size:1.2em;float:right;>";
					if(isset($_POST['debut'])) $debut=$_POST['debut']; if(isset($_POST['fin']))  $fin=$_POST['fin'];
					if(isset($debut))
						echo "(Du&nbsp;".substr($debut,8,2).'-'.substr($debut,5,2).'-'.substr($debut,0,4)." au&nbsp;".substr($fin,8,2).'-'.substr($fin,5,2).'-'.substr($fin,0,4).")";
					else
							echo "(En date du ".gmdate('d-m-Y').")";
					?></span></B>
					<FONT SIZE=4 COLOR="0000FF"> </FONT> </div> <hr noshade size=3>
				</td>
			</tr>
			<tr>
				<td colspan='7' style='font-style:italic;'>
				<?php
				if(isset($_GET['p'])){
				echo "	<table align='center'>
				<td><br/><b>Période du:&nbsp;&nbsp; </b></td>
				<td>
					<br/><input type='date' name='debut' id='' style='font-size:1.1em;width:200px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value''/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				<td> <br/><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AU:&nbsp;&nbsp; </b></td>
				<td>
					<br/><input type='date' name='fin' id=''  style='font-size:1.1em;width:200px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'";
                    ?>onchange="document.forms['chgdept'].submit();" 
					<?php 
					echo "value''/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				</td>
				<td><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				//<input type='Submit' name='ok' value='OK' class='bouton3' style='border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;'/>
				echo "</td>

				<input type='hidden' name='agent' value='";  if(isset($agent)) echo $agent; echo "'/>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>";
				}else echo "&nbsp;<br/>";
				?>
				</td>
			</tr>
			</form>
			<tr><td colspan='8'>
	<h3 style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#444739;"><?php echo "Liste des factures émises <span style='font-size:0.7em;font-style:italic;float:right;color:maroon;'>[Seules les factures établies le ".substr($Jour_actuel,8,2).'-'.substr($Jour_actuel,5,2).'-'.substr($Jour_actuel,0,4)." peuvent être annulées.]</span>";?>
					<!--<span style="font-style:italic;font-size:0.7em;color:black;font-weight:normal;"> (par l'agent connecté &nbsp; -->
					<?php //if(isset($agent)) echo "le&nbsp;".$date=gmdate('d-m-Y'); else echo "pour la période du &nbsp;".$_POST['debut']."&nbsp;au&nbsp;".$_POST['fin'];?>
					<!--)  </span></h3> -->
			</td></tr>
				<tr style=" background-color:#103550;color:white;font-size:1.2em; padding-bottom:5px;">
						<td style="border-right: 2px solid #ffffff" align="center">N° d'ordre</td>
						<td style="border-right: 2px solid #ffffff" align="center">N° Facture</td>
						<td style="border-right: 2px solid #ffffff" align="center">Date d'émission</td>
						<td style="border-right: 2px solid #ffffff" align="center">Heure </td>
						<td style="border-right: 2px solid #ffffff" align="center">Identité du Client</td>
						<td style="border-right: 2px solid #ffffff" align="center">Opérateur/Emetteur</td>
						<td style="border-right: 2px solid #ffffff" align="center">Montant </td>
						<td align="center" >Actions</td>
				</tr>
			<?php
				mysqli_query($con,"SET NAMES 'utf8'");
				$date = new DateTime("now"); // 'now' n'est pas nécéssaire, c'est la valeur par défaut
				$tz = new DateTimeZone('Africa/Porto-Novo');
				$date->setTimezone($tz);$Heure_actuelle= $date->format("H") .":". $date->format("i").":". $date->format("s");
				$date=$date->format("Y") ."-". $date->format("m")."-". $date->format("d");
				//if(isset($_POST['debut'])) $debut=$_POST['debut'];  //$debut=substr($_POST['debut'],6,4).'-'.substr($_POST['debut'],3,2).'-'.substr($_POST['debut'],0,2);
				//if(isset($_POST['fin']))  $fin=$_POST['fin'];  //$fin=substr($_POST['fin'],6,4).'-'.substr($_POST['fin'],3,2).'-'.substr($_POST['fin'],0,2);

			  $query="SELECT numFactNorm AS numFactNormId FROM reedition_facture WHERE id IN (SELECT MAX(id) FROM reedition_facture)";
				$res1=mysqli_query($con,$query); $dataId=mysqli_fetch_object($res1);
		  	//	echo $dataId->numFactNormId;

						//if(isset($_POST['OK']) && $_POST['OK'] == "OK")
							$query_Recordset1 = "SELECT DISTINCT e_mecef.id_request,produitsencours.Client,EtatF,e_mecef.COMPTEUR_MCF,e_mecef.SIGNATURE_MCF,DT_HEURE_MCF,clients,operateur,Montant,NIM_MCF FROM e_mecef,produitsencours WHERE e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF
							AND e_mecef.date BETWEEN '".$begin."' AND '".$end."' GROUP BY e_mecef.id_request ORDER BY e_mecef.id_request DESC";
							//else
					       //$query_Recordset1 = "SELECT DISTINCT produitsencours.Client,EtatF,e_mecef.COMPTEUR_MCF,e_mecef.SIGNATURE_MCF,id_request,DT_HEURE_MCF,clients,operateur,Montant,NIM_MCF FROM e_mecef,produitsencours WHERE e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF AND e_mecef.date='".$Jour_actuel."' ORDER BY e_mecef.id_request DESC";

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
								//if(!isset($_GET['avoir'])) 
								{ if(substr($data['COMPTEUR_MCF'],0-2)!="FV") $bgcouleur="#77b5fe"; }
								//if($data['EtatF']=="A") $bgcouleur="#77b5fe"; 
								echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>";
										//$operateur=$data['operateur'];
										$operat = explode("|",$data['operateur']);
										$id_operateur=$operat['0']; $operateur=$operat['1'];
										$montant = explode("|",$data['Montant']);
										$mtTTC=$montant['1'];
										if($montant['2']>0)
										$mtTTC=$mtTTC-$montant['2'];
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$i.".</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$data['NIM_MCF']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".substr($data['DT_HEURE_MCF'],0,10)."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".substr($data['DT_HEURE_MCF'],11,8)."</td>";
										echo " 	<td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >&nbsp;&nbsp;&nbsp;".$data['Client']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$operateur."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$mtTTC."</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
										//if(isset($_GET['avoir'])){
											if($data['EtatF']=="V")
											echo " &nbsp;&nbsp;	<a class='info2'  href='FactureAvoir.php?menuParent=Facturation&avoir=1&SIGNATURE_MCF=".$data['SIGNATURE_MCF']."&NIM_MCF=".$data['NIM_MCF']."'>
											<img src='logo/b_drop.png' alt='' title='' width='20' height='20' border='0'><span style='color:red;'>Annuler la facture</span></a>";
											else if($data['EtatF']=="AN")
												echo "&nbsp;&nbsp;
													<a class='info2'  href='#' style='text-decoration:none;'>
													<B style='color:green;font-size:1.2em;'>✔</B><span style='color:green;'>Cette facture a été annulée.</span></a>";
											else {
													$SIGNATURE_MCF = explode("|",$data['EtatF']); 
													$SIGNATURE_MCF0=isset($SIGNATURE_MCF['1'])?$SIGNATURE_MCF['1']:NULL;
													$SIGNATURE_MCF1=isset($SIGNATURE_MCF['2'])?$SIGNATURE_MCF['2']:NULL;													
													echo "&nbsp;&nbsp;<a class='info2'  href='#' style='text-decoration:none;'> "; 													
													echo " <B style='color:red;font-size:1.2em;'>✔</B><span style='color:red;'>N° Facture originale : ". $SIGNATURE_MCF1."(Réf. Facture originale : ". $SIGNATURE_MCF0.")</span></a>";
															
												}
								/* 		}
										else {
											echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<a href='FactureAvoir.php?SIGNATURE_MCF=".$data['SIGNATURE_MCF']."&EtatF=".$data['EtatF']."'><img src='logo/b_print.png' alt='Version imprimable' title='Réimprimer la facture' width='20' height='20' border='0'></a>";
											
											} */
									echo " 	</tr> ";
							}

			?>
			<tr>
				<td colspan='8' align='right'style='color:#444739;'> <br/> <b>Pour réimprimer toutes les factures émises durant une période donnée, <a class='' href='FactureAvoir.php?menuParent=Facturation&p=1<?php //if(isset($agent)) echo "&agent=1"; ?>' style='text-decoration:none;'> Cliquez ici</a></b>
				</td>
			</tr>
	</table>

	<?php
		echo "</div>";
		
	}
/* 	if(1!=2) {    //Revoir ce commentaire après
		if(!empty($_GET['delete'])){ //$_SESSION['delete']=$_GET['clt'];
				echo "<script language='javascript'>";
				echo "var numrecu = '".$_GET['numrecu']."';";
				echo 'swal("Vous êtes sur le point d\'annuler la facture N° : "+numrecu +".	Ceci aura pour conséquence l\'établissement d\'une Facture d\'avoir. Veuillez noter que cette action est irréversible. Voulez-vous continuer ?", {
					dangerMode: true, buttons: true,
				}).then((value) => { var Es = value;  document.location.href="FactureAvoir.php?menuParent='.$_SESSION['menuParenT'].'&numrecu='.$_GET['numrecu'].'&fact='.$_GET['fact'].'&test="+Es;
				}); ';
				echo "</script>";
			}
	else if(!empty($_GET['test'])&&($_GET['test']!="null")){   //Pour établir une facture d'avoir

		echo $sql="SELECT * FROM reedition_facture,produitsencours,e_mecef WHERE numFactNorm = '".$_GET['numrecu']."' AND e_mecef.id_request=reedition_facture.id_request AND state='1' AND produitsencours.SIGNATURE_MCF=e_mecef.SIGNATURE_MCF AND e_mecef.EtatF='0' AND e_mecef.date='".gmdate('Y-m-d')."'";
		$query=mysqli_query($con,$sql);$data=mysqli_fetch_object($query); $id_request=isset($data->SIGNATURE_MCF)?$data->SIGNATURE_MCF:NULL;
		//$id_request=$data->SIGNATURE_MCF;
		 $query="SELECT requestjson,responsjson FROM t_mecef WHERE id_request='".$id_request."'";
		$res1=mysqli_query($con,$query);
		if(mysqli_num_rows($res1)>0){
				$data=mysqli_fetch_object($res1);
				$result = array (); $result0 = array ();
				$result = json_decode($data->responsjson); $result0 = json_decode($data->requestjson);

				$TC_COMPTEURTOTAL_MCF   = isset($result->TC_COMPTEURTOTAL_MCF)?$result->TC_COMPTEURTOTAL_MCF:NULL;
				$NIM_MCF ="ED04001173-".$TC_COMPTEURTOTAL_MCF;

				$jsonDataT = array(
				 "CLE_SERVICEKEY" => isset($result0->CLE_SERVICEKEY)?$result0->CLE_SERVICEKEY:NULL,
				 "ID_DUVENDEUR" => isset($result0->ID_DUVENDEUR)?$result0->ID_DUVENDEUR:NULL,
				 "NOM_DUVENDEUR" => isset($result0->NOM_DUVENDEUR)?$result0->NOM_DUVENDEUR:NULL ,
				 "IFU_DUCLIENT"=> isset($result0->IFU_DUCLIENT)?$result0->IFU_DUCLIENT:NULL,
				 "NOM_DUCLIENT"=> isset($result0->NOM_DUCLIENT)?$result0->NOM_DUCLIENT:NULL,
				 "AIB_DUCLIENT"=> isset($result0->AIB_DUCLIENT)?$result0->AIB_DUCLIENT:NULL,
				 "REF_FACTAREMB"=>$NIM_MCF,
				 "EXPORTATION"=>false,
				 "MENTION_COPIE"=>false,
				 "TOTAL_TTCFACT"=>isset($result0->TOTAL_TTCFACT)?$result0->TOTAL_TTCFACT:NULL,
				 "PA_LPAIEMENT"=>isset($result0->PA_LPAIEMENT)?$result0->PA_LPAIEMENT:NULL,
				 "MP_MONTANTPAYE"=>isset($result0->MP_MONTANTPAYE)?$result0->MP_MONTANTPAYE:NULL,
				 "TAXE_A"=>"",
				 "TAXE_B"=>"",
				 "TAXE_C"=>"",
				 "TAXE_D"=>"",
				 "PRODUITMCF" => isset($result0->PRODUITMCF)?$result0->PRODUITMCF:NULL
				);
				$jsonData = json_encode($jsonDataT) ;
				$query="INSERT INTO  t_mecef VALUES (NULL,'".$jsonData."','0','',NULL,NULL,NULL)";
				$res1=mysqli_query($con,$query); }

				 $_SESSION['numrecu'] = $_GET['numrecu']; //$numrecu = $_GET['numrecu'];
				 $_SESSION['fact'] = $_GET['fact']; $_SESSION['NIM_MCF'] = $NIM_MCF;
				
			echo $id_request=isset($_GET['SIGNATURE_MCF'])?$_GET['SIGNATURE_MCF']:NULL;
				
			if(isset($id_request)){	 
				$_SESSION['reference']=str_replace('-', '', $id_request);   $_SESSION['id_request'] =$id_request;
				 			
				 echo $query="DELETE FROM produitsencours WHERE SIGNATURE_MCF='' AND `Etat` = '1'";
				 $res1=mysqli_query($con,$query);
				 
				 $sqlA = "SELECT * FROM produitsencours,e_mecef WHERE produitsencours.SIGNATURE_MCF=e_mecef.SIGNATURE_MCF AND e_mecef.SIGNATURE_MCF='".$id_request."' AND e_mecef.EtatF='0'";
				$query = mysqli_query($con, $sqlA);
				$query = mysqli_query($con,$sqlA);
				if (!$query) {
					printf("Error: %s\n", mysqli_error($con));
					exit();
				}
				$num=0;$data0="";$Mtotal=0; $TotalHT=0; $TotalTva=0;$TotalTva0=0;
				while($data=mysqli_fetch_array($query)){ $num++;
				$operat = explode("|",$data['operateur']);
				$_SESSION['userId']=$operat['0'];$_SESSION['vendeur']=$operat['1'];
				$_SESSION['objet']=utf8_encode($operat['3']); $_SESSION['PaymentDto']=$operat['2']; //$_SESSION['modeReglement']=$operat['2'];
				$montant = explode("|",$data['Montant']); 
				$Mtotal=$montant['1']-$montant['2'];
				$remise=$montant['2']; $Date=substr($data['DT_HEURE_MCF'],0,10);
				$client1 = explode("|",$data['clients']);
				$customerIFU=$client1['0']; if($customerIFU==0) $customerIFU=null;
				$userName=$client1['1'];	$_SESSION['initial_fiche'] = $data['NIM_MCF'] ; 
				$_SESSION['reference0'] = $data['NIM_MCF'] ; 
				$LigneCde=$data['LigneCde']; $GrpeTaxation=$data['GrpeTaxation']; $RegimeTVA=$data['RegimeTVA'];$taxSpecific=0;$Type=1;
				$etat=4;$nomcli=$data['Client'];$nomcli=$data['Client'];$prixUnit=$data['prix'];$Qte=$data['qte'];$nomcli=$data['Client'];
				$sql='INSERT INTO produitsencours(`Num`,`SIGNATURE_MCF`,`Client`,`LigneCde`,`prix`,`qte`,`Etat`,`GrpeTaxation`,`taxSpecific`,`RegimeTVA`,`Type`)
				VALUES(NULL,"","'.$nomcli.'","'.$LigneCde.'","'.$prixUnit.'","'.$Qte.'","'.$etat.'","'.$GrpeTaxation.'","'.$taxSpecific.'","'.$RegimeTVA.'","'.$Type.'") ';
				$query2 = mysqli_query($con, $sql);

				$LigneCde=$LigneCde." (".$GrpeTaxation.")";
				$prix=$data['prix'];$qte=$data['qte'];
				$mt=$prix*$qte;
				$ecrire=fopen('txt/facture.txt',"w");
				$data0.=$LigneCde.';'.-$prix.';'.$qte.';'.-$mt."\n";
				$ecrire2=fopen('txt/facture.txt',"a+");
				fputs($ecrire2,$data0);
			}

			 $_SESSION['TotalTTC']=-$Mtotal; $_SESSION['Mtotal']=-$Mtotal; 
			 $_SESSION['TotalHT']= -$Mtotal  ;
			 $_SESSION['TotalTva']= isset($TotalTva)?$TotalTva:0;
			 $_SESSION['NumIFU']=isset($customerIFU)?$customerIFU:NULL;
			 $_SESSION['client']=isset($userName)?$userName:NULL;
			 $_SESSION['Date_actuel']=$Date_actuel;
			 
			  $sql="SELECT somme_paye,du,au FROM reedition_facture WHERE numFactNorm = '".$_GET['numrecu']."' AND state='2'";
			  $query=mysqli_query($con,$sql);$data=mysqli_fetch_object($query); 
			  $_SESSION['avanceA']=isset($data->somme_paye)?$data->somme_paye:0;
			  $_SESSION['debut']=isset($data->du)?$data->du:NULL;
			  $_SESSION['fin']=isset($data->au)?$data->au:NULL;
		
			 //$_SESSION['avanceA']= 0;  
			 //$_SESSION['debut']=''; 
			 //$_SESSION['fin']='';
			 
			 $_SESSION['FV']=0; // Pour facture d'avoir  
			 
			 $Tps=1;  //L'entreprise est en mose TPS
			 
			 $update=mysqli_query($con,"UPDATE configuration_facture SET numFactNorm=numFactNorm+1 ");
			 
			 //$_SESSION['call_emecef']=1;
			 //$_SESSION['norm']=isset($_GET['norm'])?$_GET['norm']:0;
 
		echo "<center><iframe src='checkingFAvoir.php' width='1000' height='800' style=''></iframe></center>";
	}
	//echo "<iframe src='reimpression.php?numrecu=".$_GET['numrecu']."&fact=".$_GET['fact'];  echo "' width='1000' height='800' 		style='margin-left:15%;'></iframe>";

	}
	else if(!empty($_GET['test'])&&($_GET['test']=="null"))
		{ echo "<script language='javascript'>";
			echo 'alertify.success("Vous venez de renoncer à l\'établissement de la Facture d\'avoir.");';
			echo "</script>";
			header('location:FactureAvoir.php?menuParent=Facturation');
		}
	else	if(isset($_GET['fact'])&&($_GET['fact']!=1))
		{ //include ('reimpression.php');
			echo "<center><iframe src='reimpressionOK.php?numrecu=".$_GET['numrecu']."&fact=".$_GET['fact'];  echo "' width='1000' height='800' style=''></iframe></center>";

		}
	else
		{	echo "<center><iframe src='receiptH.php?numrecu=".$_GET['numrecu']."&fact=".$_GET['fact'];  echo "' width='600' height='675' scrolling='no' allowtransparency='true' FRAMEBORDER='yes' style=''></iframe></center>";
		}
	}

		//unset($_SESSION['reference']); */
	?>

	</body>

</html>
