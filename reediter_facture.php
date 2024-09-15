<?php
		include 'menu.php';
		include 'others/footerpdf.inc';
		//@session_start(); //unset($_SESSION['reimprime']);
		unset($_SESSION['Apply_AIB']); unset($_SESSION['ValAIB']);unset($_SESSION['PourcentAIB']);unset($_SESSION['numrecu']);unset($_SESSION['fact']);
		$reqsel=mysqli_query($con,"SELECT menu FROM role,affectationrole WHERE role.nomrole=affectationrole.nomrole  AND menuParent='Hébergement' AND menu='Check-in [Entrée]' AND Profil='".$_SESSION['poste']."'");
		if(mysqli_num_rows($reqsel)>0)
		  {$agent=1;//$et=0;
	    }//unset($_SESSION['SIGNATURE_MCF']);unset($_SESSION['SIGNATURE_MCF']);
	$agent=isset($_GET['agent'])?$_GET['agent']:$_SESSION['poste'];
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
	if(!isset($_GET['numrecu'])){ //echo 125;
	?>	<div align="" style="margin-top:-60px;">
		<form  action='reediter_facture.php?menuParent=Facturation&p=1' method='post' name='reediter_facture' id='chgdept'>
		<table align="center" width="1100" border="0" cellspacing="0" style="margin-top:40px;border-collapse: collapse;font-family:Cambria;">
			<tr>
				<td colspan='8'>
					<hr noshade size=3> <div align="center"><B>
					<FONT SIZE=6 COLOR="Maroon"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; REIMPRESSION DE FACTURES (DUPICATA) </FONT></B><B> <span style='font-style:italic;font-size:0.8em;color:#444739;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
					<br/><input type='date' name='debut' id=''  style='font-size:1.1em;width:200px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value''/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
	<h3 style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#444739;"><?php //echo "Liste des factures émises <span style='font-size:0.7em;font-style:italic;float:right;'>[Seules les factures établies aujourd'hui peuvent être annulées.]</span>";?>
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
							$query_Recordset1 = "SELECT DISTINCT e_mecef.id_request,produitsencours.Client,e_mecef.EtatF AS EtatF,e_mecef.COMPTEUR_MCF,e_mecef.SIGNATURE_MCF,DT_HEURE_MCF,clients,operateur,Montant,NIM_MCF FROM e_mecef,produitsencours WHERE e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF
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
										//if($montant['2']>0)
										//$mtTTC=$mtTTC-$montant['2']; 
										//$data['Client'];
										$clients = explode("|",$data['clients']);$client=$clients['1']; 
										$typeE='Facture ordinaire'; $typeI=2;
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$i.".</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$data['NIM_MCF']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".substr($data['DT_HEURE_MCF'],0,10)."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".substr($data['DT_HEURE_MCF'],11,8)."</td>";
										echo " 	<td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >&nbsp;&nbsp;&nbsp;".$client."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$operateur."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$mtTTC."</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
										
										//if(isset($_GET['avoir'])){
											//if($data['EtatF']=="V")
											echo " &nbsp;&nbsp;	<a class='info5'  href='reediter_facture.php?menuParent=Facturation&fact=".$typeI."&SIGNATURE_MCF=".$data['SIGNATURE_MCF']."&numrecu=".$data['NIM_MCF']."'>
											<img src='logo/Print.png' alt='' title='' width='20' height='20' border='0'><span style='font-size:0.9em;color:maroon;'>Réimprimer la Facture</span></a>";
											//else if($data['EtatF']=="AN")
											//	echo "&nbsp;&nbsp;<a class='info2'  href='#' style='text-decoration:none;' title='Cette facture a été annulée.'><span style='color:green;font-size:1.2em;'> ✔</span></a>";
/* 											else {
													$SIGNATURE_MCF = explode("|",$data['EtatF']); 
													$SIGNATURE_MCF0=isset($SIGNATURE_MCF['1'])?$SIGNATURE_MCF['1']:NULL;
													$SIGNATURE_MCF1=isset($SIGNATURE_MCF['2'])?$SIGNATURE_MCF['2']:NULL;													
													echo "&nbsp;&nbsp;<a class='info'  href='#' style='text-decoration:none;' title='"; 
													echo "N° Facture originale : ". $SIGNATURE_MCF1;
													echo " (Réf. Facture originale : ". $SIGNATURE_MCF0.")";
													echo "'><span style='color:white;font-size:1.2em;'> ✔</span></a>";
												
												} */
								/* 		}
										else {
											echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<a href='reediter_facture.php?SIGNATURE_MCF=".$data['SIGNATURE_MCF']."&EtatF=".$data['EtatF']."'><img src='logo/b_print.png' alt='Version imprimable' title='Réimprimer la facture' width='20' height='20' border='0'></a>";
											
											} */
									echo " 	</tr> ";
							}

			?>
			<tr>
				<td colspan='8' align='right'style='color:#444739;'> <br/> <b>Pour réimprimer toutes les factures émises durant une période donnée, <a class='' href='reediter_facture.php?menuParent=Facturation&p=1<?php //if(isset($agent)) echo "&agent=1"; ?>' style='text-decoration:none;'> Cliquez ici</a></b>
				</td>
			</tr>
	</table>

	<?php
		echo "</div>";
	}else {
		if(!empty($_GET['delete'])){ //$_SESSION['delete']=$_GET['clt'];
				echo "<script language='javascript'>";
				echo "var numrecu = '".$_GET['numrecu']."';";
				echo 'swal("Vous êtes sur le point d\'annuler la facture N° : "+numrecu +".	Ceci aura pour conséquence l\'établissement d\'une Facture d\'avoir. Veuillez noter que cette action est irréversible. Voulez-vous continuer ?", {
					dangerMode: true, buttons: true,
				}).then((value) => { var Es = value;  document.location.href="reediter_facture.php?menuParent='.$_SESSION['menuParenT'].'&numrecu='.$_GET['numrecu'].'&fact='.$_GET['fact'].'&test="+Es;
				}); ';
				echo "</script>";
			}
	else if(!empty($_GET['test'])&&($_GET['test']!="null")){   //Pour établir une facture d'avoir
		$sql="SELECT id_request FROM reedition_facture WHERE numFactNorm = '".$_GET['numrecu']."' AND state='1'";
		$query=mysqli_query($con,$sql);$data=mysqli_fetch_object($query);
		$id_request=$data->id_request;

		/*$query="SELECT requestjson,responsjson FROM t_mecef WHERE id_request='".$id_request."'";
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
				 $_SESSION['fact'] = $_GET['fact']; $_SESSION['NIM_MCF'] = $NIM_MCF; */

				//echo "<center><iframe src='checkingOK.php?numrecu=".$_GET['numrecu']."&fact=".$_GET['fact'];  echo "' width='1000' height='800' 		style=''></iframe></center>";

	//echo "<iframe src='reimpression.php?numrecu=".$_GET['numrecu']."&fact=".$_GET['fact'];  echo "' width='1000' height='800' 		style='margin-left:15%;'></iframe>";

	}
	else if(!empty($_GET['test'])&&($_GET['test']=="null"))
		{ echo "<script language='javascript'>";
			echo 'alertify.success("Vous venez de renoncer à l\'établissement de la Facture d\'avoir.");';
			echo "</script>";
		}
	else if(isset($_GET['fact'])&&($_GET['fact']!=1))
		{ 
			echo "<center><iframe src='reimpressionOK.php?numrecu=".$_GET['numrecu']."&fact=".$_GET['fact'];  echo "' width='1000' height='800' style=''></iframe></center>";

		}
	else
		{	echo "<center><iframe src='receiptH.php?numrecu=".$_GET['numrecu']."&fact=".$_GET['fact'];  echo "' width='600' height='675' scrolling='no' allowtransparency='true' FRAMEBORDER='yes' style='margin-top:-25px;'></iframe></center>";
		}
	}

	?>

	</body>

</html>
