<?php
		include_once'menu.php';

		$agent=!empty($_GET['agent'])?$_GET['agent']:NULL;
		$trie=!empty($_GET['trie'])?$_GET['trie']:NULL;$debut=!empty($_GET['debut'])?$_GET['debut']:NULL;$fin=!empty($_GET['fin'])?$_GET['fin']:NULL;
		$debut=substr($debut,6,4).'-'.substr($debut,3,2).'-'.substr($debut,0,2); $fin=substr($fin,6,4).'-'.substr($fin,3,2).'-'.substr($fin,0,2);
		$debutA=substr($debut,6,4).'-'.substr($debut,3,2).'-'.substr($debut,0,2);$finA=substr($fin,6,4).'-'.substr($fin,3,2).'-'.substr($fin,0,2);
		$reqsel=mysqli_query($con,"SELECT menu FROM role,affectationrole WHERE role.nomrole=affectationrole.nomrole  AND menuParent='Hébergement' AND menu='Check-in [Entrée]' AND Profil='".$_SESSION['poste']."'");
		if(mysqli_num_rows($reqsel)>0)
		  {$agent=1;//$et=0;
	      }
?>
<html>
	<head>
		<script type="text/javascript" src="js/date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script type="text/javascript">

		</script>
		<style>
			.alertify-log-custom {
				background: blue;
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
		#bouton3:hover{
			cursor:pointer;background-color: #000000;color:white;font-weight:bold;
		}
		#info:hover{

		}
		</style>
	<body bgcolor='azure' style="">
	<div align="center" style="">
	<?php
		if(isset($_GET['num_facture']))
			{	echo "<iframe src='ex.php"; echo "?num_facture=".$_GET['num_facture']."' width='1000' height='800' style='margin-left:5%;'></iframe>";
			}
			else{
	?>

		<form  action='pevente.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&p=1' method='post' name='pevente'>
			<center> <font color='green' size='7' > <?php  if(isset($_GET['p'])) $recette= "RECETTE PERIODIQUE"; else $recette="RECETTE JOURNALIERE";
 			if (isset($_POST['ok'])&& $_POST['ok']=='OK')
			{	$debut=substr($_POST['debut'],6,4).'-'.substr($_POST['debut'],3,2).'-'.substr($_POST['debut'],0,2);
				$fin=substr($_POST['fin'],6,4).'-'.substr($_POST['fin'],3,2).'-'.substr($_POST['fin'],0,2);
				$debutA=substr($_POST['debut'],0,2).'-'.substr($_POST['debut'],3,2).'-'.substr($_POST['debut'],6,4);
				$finA=substr($_POST['fin'],0,2).'-'.substr($_POST['fin'],3,2).'-'.substr($_POST['fin'],6,4); $debuT=$_POST['debut'];  $fiN=$_POST['fin'];
					if(empty($_POST['agent']))
					{
						//$sql="SELECT somme_paye FROM factureeconomat WHERE date_emission>='".$debuT."' and date_emission<='".$fiN."' ORDER BY date_emission";
							$query_Recordset1 = "SELECT DISTINCT produitsencours.Client,e_mecef.COMPTEUR_MCF,e_mecef.SIGNATURE_MCF,id_request,DT_HEURE_MCF,clients,operateur,Montant FROM e_mecef,produitsencours WHERE e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF	AND e_mecef.date BETWEEN '".$_POST['debut']."' AND '".$_POST['fin']."'";
						//else
							//$query_Recordset1 = "SELECT DISTINCT produitsencours.Client,e_mecef.COMPTEUR_MCF,e_mecef.SIGNATURE_MCF,id_request,DT_HEURE_MCF,clients,operateur,Montant FROM e_mecef,produitsencours WHERE e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF AND e_mecef.date='".$Jour_actuel."' ORDER BY e_mecef.id_request DESC";
					}
					else
					{
						//$sql="SELECT somme_paye FROM factureeconomat WHERE  date_emission>='".$debuT."' and date_emission<='".$fiN."' AND receptionniste='".$_SESSION['login']."' ORDER BY date_emission";
					//	$query_Recordset1 = "SELECT DISTINCT produitsencours.Client,e_mecef.COMPTEUR_MCF,e_mecef.SIGNATURE_MCF,id_request,DT_HEURE_MCF,clients,operateur,Montant FROM e_mecef,produitsencours WHERE e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF	AND e_mecef.date BETWEEN '".$_POST['debut']."' AND '".$_POST['fin']."'";
						//else
						$query_Recordset1 = "SELECT DISTINCT produitsencours.Client,e_mecef.COMPTEUR_MCF,e_mecef.SIGNATURE_MCF,id_request,DT_HEURE_MCF,clients,operateur,Montant FROM e_mecef,produitsencours WHERE e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF AND e_mecef.date='".$Jour_actuel."' ORDER BY e_mecef.id_request DESC";
					}
					// $ref=mysqli_query($con,$sql);
					// $montant0=0;$i=1; $cpteur=1;$montant=0;
					// while ($rerf=mysqli_fetch_array($ref))
					// { 	$montant0=$rerf['somme_paye'];
					// 	$montant=$montant+$montant0;
					//
					// }
			}else
				$query_Recordset1 = "SELECT DISTINCT produitsencours.Client,e_mecef.COMPTEUR_MCF,e_mecef.SIGNATURE_MCF,id_request,DT_HEURE_MCF,clients,operateur,Montant FROM e_mecef,produitsencours WHERE e_mecef.SIGNATURE_MCF=produitsencours.SIGNATURE_MCF AND e_mecef.date='".$Jour_actuel."' ORDER BY e_mecef.id_request DESC";
			?>
			</font> </center>
			<center>
			<table align='center' width='900'>
				<tr>
				<td colspan='6'>
					<hr noshade size=3> <div align="left"><B>

					<?php
					echo "<span style='font-style:italic;font-size:0.8em;'>";
					$mt=0; 	$i=1; $cpteur=1;
					// if(isset($agent))
					// {
					//  $sql="SELECT somme_paye FROM factureeconomat WHERE  date_emission='".date('Y-m-d')."'  AND receptionniste='".$_SESSION['login']."' ";
					// $res=mysqli_query($con,$sql);
					// while ($ret=mysqli_fetch_array($res))
					// 	{	$mt=$mt+$ret['somme_paye'];
					// 	}
					// }else
					// { $sql="SELECT somme_paye FROM factureeconomat WHERE  date_emission='".date('Y-m-d')."' ";
					// $res=mysqli_query($con,$sql);
					// while ($ret=mysqli_fetch_array($res))
					// 	{			//$mt=$mt+$ret['ttc_fixe']*$ret['np'].'';
					// 				$mt=$mt+$ret['somme_paye'];
					// 	}
					// }
						if(empty($montant)||($montant==0)){
							echo'<span style="align:center;color:#444739;float:left;">'; echo '
							<B> TOTAL HT : &nbsp;&nbsp;</b>'.$mt." ".$devise.'</span>'; }
						else{
							echo'<span style="align:center;color:#444739;float:left;">'; echo '
							<B> TOTAL HT : &nbsp;</b>'.$montant." ".$devise.'';
						}
						echo "</span>";
					echo "<FONT SIZE=6 COLOR='Maroon'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$recette."</FONT>&nbsp;&nbsp;&nbsp;
					<span style='color:#444739;font-style:italic;float:right'>";
					if(isset($debuT))
						echo "(Du&nbsp;".substr($_POST['debut'],8,2).'-'.substr($_POST['debut'],5,2).'-'.substr($_POST['debut'],0,4)." au&nbsp;".substr($_POST['fin'],8,2).'-'.substr($_POST['fin'],5,2).'-'.substr($_POST['fin'],0,4).")";
					else
						echo "Date:&nbsp;". date('d-m-Y')."";
					?></span>
					<FONT SIZE=4 COLOR="0000FF"> </FONT> </div> <hr noshade size=3>
				</td>
				</tr>

		</table>


		<table align="center" width="900" border="0" cellspacing="0" style="margin-top:0px;border-collapse: collapse;font-family:Cambria;">
		<?php
			if(isset($_GET['p'])){
				echo "	<td colspan='8' style='font-style:italic;'>
				<table align='center'>
				<td><b>Période du:&nbsp;&nbsp; </b></td>
				<td>
					<input type='date' name='debut' id='' size='20'  style='width:150px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value'";if(empty($debuT)) echo date('d-m-Y'); else echo $debuT; echo "'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				<td> <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AU:&nbsp;&nbsp; </b></td>
				<td>
					<input type='date' name='fin' id='' size='20'  style='width:150px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value'"; if(empty($fiN)) echo date('d-m-Y'); else echo $fiN; echo"'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='Submit' name='ok' value='OK' class='bouton3' style='border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;'/></td>

				<input type='hidden' name='agent' value='". $agent."'/>
				</tr>

			</table></td> ";
				}else { //echo "&nbsp;<br/>";
				?>
					<tr>
						<td colspan='8' align='right' style='color:#444739;'> <b>
						<a class='' href='pevente.php?menuParent=<?php echo $_SESSION['menuParenT']."&p=1"; ?>' style='text-decoration:none;color:maroon;'>
						-> Recette périodique</a>
						</b>
						</td>
					</tr>
					<tr>
						<td colspan='8' align='right' style='color:#444739;'> &nbsp;
						</td>
					</tr>
				<?php  }

			if(isset($_GET['p'])) echo "<tr><td colspan='8'><hr noshade size=3></td></tr>";

			if(isset($_GET['debut'])) $debuT=substr($_GET['debut'],8,2).'-'.substr($_GET['debut'],5,2).'-'.substr($_GET['debut'],0,4); else $debuT=date('d-m-Y');
			if(isset($_GET['fin'])) $fiN=substr($_GET['fin'],8,2).'-'.substr($_GET['fin'],5,2).'-'.substr($_GET['fin'],0,4); else $fiN=date('d-m-Y');

			if (isset($_POST['ok'])&& $_POST['ok']=='OK')
			 {	//$debut=substr($_POST['debut'],6,4).'-'.substr($_POST['debut'],3,2).'-'.substr($_POST['debut'],0,2);
			// 	 $fin=substr($_POST['fin'],6,4).'-'.substr($_POST['fin'],3,2).'-'.substr($_POST['fin'],0,2);
			// 	 echo "<span style='font-style:italic;font-size:0.8em;color:black;'>";  $debuT=$_POST['debut'];  $fiN=$_POST['fin'];
			// 	//echo "<center> (Du&nbsp;".$debuT." &nbsp;au&nbsp;".$_POST['fin'].")</center></span>";
			// 	$trie=!empty($_GET['trie'])?$_GET['trie']:NULL;
			// 			if(empty($agent))
			// 			{//mysqli_query($con,"SET NAMES 'utf8' ");
			// 				$ref=mysqli_query($con,"SELECT * FROM factureeconomat WHERE date_emission>='".$debuT."' and date_emission<='".$fiN."' ORDER BY date_emission");
			// 				$ref3=mysqli_query($con,"SELECT SUM(Remise) AS Remise FROM factureeconomat WHERE  date_emission>='".$debuT."' and date_emission<='".$fiN."' ");
			// 				$data=mysqli_fetch_assoc($ref3);$remise=$data['Remise'];
			// 			//$ref=mysqli_query($con,"SELECT * FROM encaissement WHERE datencaiss>='".$debut."' and datencaiss<='".$fin."' ORDER BY datencaiss");
			// 			}
			// 			else
			// 			{//mysqli_query($con,"SET NAMES 'utf8' ");
			// 			$ref=mysqli_query($con,"SELECT * FROM factureeconomat WHERE  date_emission>='".$debuT."' and date_emission<='".$fiN."' AND receptionniste='".$_SESSION['login']."' ORDER BY date_emission");
			// 			$ref3=mysqli_query($con,"SELECT SUM(Remise) AS Remise FROM factureeconomat WHERE  date_emission>='".$debuT."' and date_emission<='".$fiN."' AND receptionniste='".$_SESSION['login']."' ");
			// 			$data=mysqli_fetch_assoc($ref3);$remise=$data['Remise'];
			// 			//$ref=mysqli_query($con,"SELECT * FROM encaissement WHERE datencaiss>='".$debut."' and datencaiss<='".$fin."' and agenten='".$_SESSION['login']."' ORDER BY datencaiss");
			// 			}
			//
			// 	$montant=0;
		}
		 else
			  {	//mysqli_query($con,"SET NAMES 'utf8'");	$date=date('Y-m-d');
			// 	if(empty($agent))
			// 	{if(!empty($trie)&&(empty($debut))){ //echo 13;
			// 		$ref=mysqli_query($con,"SELECT * FROM factureeconomat WHERE date_emission LIKE '".$date."' ORDER BY $trie ASC");
			// 		$ref3=mysqli_query($con,"SELECT SUM(Remise) AS Remise FROM factureeconomat WHERE  date_emission LIKE '".$date."' ");
			// 	}else if(!empty($trie)&&(!empty($debut))){
			// 		$ref=mysqli_query($con,"SELECT * FROM factureeconomat WHERE date_emission>='".$debut."' and date_emission<='".$fin."' ORDER BY $trie ");
			// 		$ref3=mysqli_query($con,"SELECT SUM(Remise) AS Remise FROM factureeconomat WHERE  date_emission>='".$debut."' and date_emission<='".$fin."' ");
			// 	} else {
			// 		$ref=mysqli_query($con,"SELECT * FROM factureeconomat WHERE  date_emission LIKE '$date' ORDER BY  date_emission,heure_emission DESC");
			// 		$ref3=mysqli_query($con,"SELECT SUM(Remise) AS Remise FROM factureeconomat WHERE  date_emission LIKE '$date' ORDER BY  date_emission,heure_emission DESC");
			//
			// 	}
			// 		$data=mysqli_fetch_assoc($ref3);$remise=$data['Remise'];
			// 	}
			// else
			// 	{	//if(!empty($trie)&&(empty($debut))){ //echo 1;
			// // 		$ref=mysqli_query($con,"SELECT * FROM factureeconomat WHERE date_emission LIKE '$date' AND receptionniste='".$_SESSION['login']."' ORDER BY $trie ASC");
			// // 		$ref3=mysqli_query($con,"SELECT SUM(Remise) AS Remise FROM factureeconomat WHERE  date_emission LIKE '$date' AND receptionniste='".$_SESSION['login']."'");
			// // 	}else if(!empty($trie)&&(!empty($debut))){
			// // 		$ref=mysqli_query($con,"SELECT * FROM factureeconomat WHERE date_emission>='".$debut."' and date_emission<='".$fin."' AND receptionniste='".$_SESSION['login']."' ORDER BY $trie ASC");
			// // 		$ref3=mysqli_query($con,"SELECT SUM(Remise) AS Remise FROM factureeconomat WHERE  date_emission>='".$debut."' and date_emission<='".$fin."' AND receptionniste='".$_SESSION['login']."' ");
			// // 		}else{
			// // 		$ref=mysqli_query($con,"SELECT * FROM factureeconomat WHERE date_emission LIKE '$date' AND receptionniste='".$_SESSION['login']."' ORDER BY date_emission");
			// // 		$ref3=mysqli_query($con,"SELECT SUM(Remise) AS Remise FROM factureeconomat WHERE date_emission LIKE '$date' AND receptionniste='".$_SESSION['login']."' ORDER BY date_emission");
			// // 		}
			// // 	$data=mysqli_fetch_assoc($ref3);$remise=$data['Remise'];
			// }
			}
		?>
					<tr style="background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;">
					<!--<tr style='background-color:#EEEE99;'> -->
							<td WIDTH='' align='center'>N° </td>
							<td WIDTH='' align='center'>&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td WIDTH='' align='center'>&nbsp;Heure&nbsp;&nbsp;&nbsp;</td>
							<td WIDTH='' align='center'>Réf. Facture</td>
							<td WIDTH='' align='right' ><a class='info' style='color:white;' href="pVente.php?menuParent=<?php echo $_SESSION['menuParenT']; if(!empty($agent)) echo "&agent=1&p=1";  echo "&trie=somme_paye&debut=".$debuT."&fin=".$fiN; ?>">Montant HT<span style='font-size:0.8em;'>Trier suivant le montant</span></a></td>
							<td WIDTH='' align='right' ><a class='info' style='color:white;' href="pVente.php?menuParent=<?php echo $_SESSION['menuParenT']; if(!empty($agent)) echo "&agent=1&p=1";  echo "&trie=tva&debut=".$debuT."&fin=".$fiN; ?>">TVA Collectée<span style='font-size:0.8em;'>Trier suivant la TVA</span></a></td>
							<td WIDTH='' align='center'><a class='info' style='color:white;' href="pVente.php?menuParent=<?php echo $_SESSION['menuParenT']; if(!empty($agent)) echo "&agent=1&p=1";  echo "&trie=Client&debut=".$debuT."&fin=".$fiN; ?>"><span style='font-size:0.8em;'>Trier suivant le client</span>Raison sociale</a></td>
							<td WIDTH='' align='center'><a class='info' style='color:white;' href="pVente.php?menuParent=<?php echo $_SESSION['menuParenT']; if(!empty($agent)) echo "&agent=1&p=1";  echo "&trie=objet&debut=".$debuT."&fin=".$fiN; ?>"><span style='font-size:0.8em;'></span>✔</a></td>
				   </tr>
				   <?php //echo "Récapitulatif des recttes ";?> <?php


			 //echo ")  </span>";
		//echo "<table align='center' border='1' width='40%'> ";
		$montant0=0;$j=0; $cpteur=1;//$tva=0;
		while ($rerf=mysqli_fetch_array($ref))
		{ 	if($cpteur == 1)
			{
				$cpteur = 0;
				$bgcouleur = "#acbfc5";
			}
			else
			{
				$cpteur = 1;
				$bgcouleur = "#dfeef3";
			}
			$NomClient=addslashes($rerf['Client']);
			//$i=$rerf['numTable'];if($i<10) $ii="0".$i; else $ii=$i;
			//if($ii==0) $type="Takeaway" ; else $type="@ Table N° : ".$ii ; ;
		if(isset($rerf['Client'])){
		$req="SELECT NomClt FROM clients WHERE Num='".$rerf['Client']."' AND Clients.Type='".$_SESSION['menuParenT1']."'";
		$reqsel=mysqli_query($con,$req);$NClient=mysqli_fetch_assoc($reqsel);$Nomclt=$NClient['NomClt'];
	}else $Nomclt="Non renseigné";
			$numFacture=$rerf['num_facture'];  $somme_paye=$rerf['somme_paye']-$rerf['tva'];
				//if(($nbre>=0)&&($nbre<=9)) $nbre="0000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="000".$nbre ;else $nbre="00".$nbre ;
				echo"<tr class='rouge1' bgcolor='".$bgcouleur."'> "; 	$j++;
					echo"<td align='center'> ";echo $j;echo".</td> ";
					echo"<td align='center'> "; echo substr($rerf['date_emission'],8,2).'-'.substr($rerf['date_emission'],5,2).'-'.substr($rerf['date_emission'],0,4);echo"</td> ";
					echo"<td align='center'> ";echo ucfirst($rerf['heure_emission']);echo"</td> ";
					echo"<td align='center'> ";echo $numFacture;echo"</td> ";
					echo"<td align='right'> ";echo $somme_paye;echo"</td> ";
					echo"<td align='right'> ";echo $rerf['tva'];echo"</td> ";
					echo"<td align='center'> ";echo $Nomclt;echo"</td> ";
					echo"<td align='center'>  ";?>

					<a class='info' href='pevente.php?menuParent=<?php echo $_SESSION['menuParenT'].'&num_facture='.$numFacture; ?>' style='color:#FF00FF;' > <img src='logo/Print.png' alt='' title='' width='16' height='16' border='0'> <span style='font-size:0.8em;'>Rééditer la facture</span></a>

					<?php echo "</td> ";
				echo "</tr>";
			$montant0=$rerf['somme_paye'];
			//$montant=$montant+$montant0;

		}
		//$montant=!empty($montant)?$montant:NULL;

/* 		echo "<br>";
		echo"<table align='center'>";
			echo "<tr>";
				 if($remise>0) {  echo"<td align='center'><br><span style=''>";  echo "Remise accordée: <B>";  echo $remise;   echo " F CFA</B></span></td> ";}
				echo"<td align='center'><br><span style='font-size:1.2em;'>"; if($remise>0) echo "&nbsp;|&nbsp;"; echo "Montant Total perçu durant cette période: <B>"; if(is_int($montant)) echo $montant; else echo round($montant,4);  echo " F CFA</B></span></td> ";
		echo"</tr>
		</table>"; */
 ?>
	</table>
	</form>
	<?php
		}
	?>
	</div>
</body>
</html>
