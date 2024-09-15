<?php
		include 'menu.php';

		$agent=!empty($_GET['agent'])?$_GET['agent']:NULL;
		$trie=!empty($_GET['trie'])?$_GET['trie']:NULL;$debut=!empty($_GET['debut'])?$_GET['debut']:NULL;$fin=!empty($_GET['fin'])?$_GET['fin']:NULL;
		$debutA=substr($debut,8,2).'-'.substr($debut,5,2).'-'.substr($debut,0,4);$finA=substr($fin,8,2).'-'.substr($fin,5,2).'-'.substr($fin,0,4);
		//$update=mysqli_query($con,"UPDATE reedition_facture SET objet='Hébergement' WHERE objet='Hebergement'");
		//$update=mysqli_query($con,"UPDATE encaissement SET tarif=6355.9323 WHERE Type_encaisse='Facture de groupe' and ttc_fixe=9500");
		$delete=mysqli_query($con,"DELETE FROM encaissement  WHERE np=0");
		$delete=mysqli_query($con,"DELETE FROM mensuel_encaissement  WHERE np=0");

		$reqsel=mysqli_query($con,"SELECT menu FROM role,affectationrole WHERE role.nomrole=affectationrole.nomrole  AND menuParent='Hébergement' AND menu='Check-in [Entrée]' AND Profil='".$_SESSION['poste']."'");
		if(mysqli_num_rows($reqsel)>0)
		  {//$agent=1;//$et=0;
	    }
?>
<html>
	<head>
		<script type="text/javascript" src="js/date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
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
	<div align="" style="">
		<form  action='recette2.php?menuParent=Consultation&p=1' method='post' name='recette2'>
			<center> <font color='green' size='7' > <?php  if(isset($_GET['p'])) $recette= "RECETTE PERIODIQUE"; else $recette="RECETTE JOURNALIERE";
			if (isset($_POST['ok'])&& $_POST['ok']=='OK')
			{$debut=substr($_POST['debut'],6,4).'-'.substr($_POST['debut'],3,2).'-'.substr($_POST['debut'],0,2);
			$fin=substr($_POST['fin'],6,4).'-'.substr($_POST['fin'],3,2).'-'.substr($_POST['fin'],0,2);
			$debutA=substr($_POST['debut'],0,2).'-'.substr($_POST['debut'],3,2).'-'.substr($_POST['debut'],6,4);
			$finA=substr($_POST['fin'],0,2).'-'.substr($_POST['fin'],3,2).'-'.substr($_POST['fin'],6,4); $debuT=$_POST['debut'];  $fiN=$_POST['fin'];
				if(empty($_POST['agent']))
				{$ref=mysqli_query($con,"SELECT somme_paye FROM reedition_facture WHERE date_emission>='".$debuT."' and date_emission<='".$fiN."' AND state <> '1' AND somme_paye <> '0' ORDER BY date_emission");
				}
				else
				{$ref=mysqli_query($con,"SELECT somme_paye FROM reedition_facture WHERE  date_emission>='".$debuT."' and date_emission<='".$fiN."' AND receptionniste='".$_SESSION['login']."' AND state <> '1' AND somme_paye <> '0' ORDER BY date_emission");
				}
		$montant0=0;$i=1; $cpteur=1;$montant=0;
		while ($rerf=mysqli_fetch_array($ref))
		{ 	$montant0=$rerf['somme_paye'];
			$montant+=$montant0;

		}
			}
			?>
			</font> </center>
			<center>
			<table align='center' width='1000'>
				<tr>
				<td colspan='7'>
					<hr noshade size=3> <div align="left"><B>

					<?php
					echo "<span style='font-style:italic;font-size:0.8em;'>";
					$mt=0; 	$i=1; $cpteur=1; //$montant=5; $mt=2;
					if(isset($agent))
					{
					$res=mysqli_query($con,"SELECT somme_paye,numrecu,num_facture,Arrhes,numFactNorm FROM reedition_facture WHERE  date_emission='".$Jour_actuel."'  AND receptionniste='".$_SESSION['login']."' AND state <> '1' AND somme_paye <> '0' ");
					//$res=mysqli_query($con,"SELECT * FROM encaissement WHERE datencaiss='".date('Y-m-d')."' and agenten='".$_SESSION['login']."'");
					while ($ret=mysqli_fetch_array($res))
						{	$somme_paye=$ret['somme_paye'];
							if(!empty($ret['numrecu'])&& (!empty($ret['num_facture']) || !empty($ret['numFactNorm'] )) )
							{  //if($ret['Arrhes']>0) $somme_paye-=$ret['Arrhes'];
							}
							//else
								//{	//if($ret['Arrhes']>0) $somme_paye-=$ret['Arrhes'];

								//}
							$mt=$mt+$somme_paye;
						}
					}else
					{
					$res=mysqli_query($con,"SELECT somme_paye,numrecu,num_facture,numFactNorm FROM reedition_facture WHERE  date_emission='".$Jour_actuel."' AND state <> '1' AND somme_paye <> '0' ");
					//$res=mysqli_query($con,"SELECT * FROM encaissement WHERE datencaiss='".date('Y-m-d')."'");
					while ($ret=mysqli_fetch_array($res))
						{
							$somme_paye=$ret['somme_paye'];

							if(!empty($ret['numrecu'])&& (!empty($ret['num_facture']) || !empty($ret['numFactNorm'] )) )
							{  //if($ret['Arrhes']>0) $somme_paye-=$ret['Arrhes'];
							}
/* 							else if(!empty($ret['numrecu'])&&!empty($ret['numFactNorm']))
							{
							} */
					/* 		else
								{
								} */
								$mt=$mt+$somme_paye;  //$montant=5; $mt=2;
						}
					}//$montant=0;//$mt=0;
						if(empty($montant)||($montant==0)){echo'<span style="align:center;color:#444739;">'; echo '
						<B> TOTAL : &nbsp;&nbsp;</b>'.$mt." ".$devise.'</span>'; $montantT=$mt;}
						else
						{echo'<span style="color:#444739;"> <br/>'; echo '
						<B> TOTAL : &nbsp;</b>'.$montant." ".$devise.'';$montantT=$montant;
						}
						echo "</span>";
					echo "<FONT SIZE=6 COLOR='Maroon'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$recette."</FONT>&nbsp;&nbsp;&nbsp;<span style='color:#444739;font-style:italic;'>";

					//echo "<span style='font-style:italic;font-size:0.8em;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:". date('d-m-Y')."</span>";
					if(isset($debuT))
						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						(Du&nbsp;".substr($debuT,8,2).'-'.substr($debuT,5,2).'-'.substr($debuT,0,4)." au&nbsp;".substr($fiN,8,2).'-'.substr($fiN,5,2).'-'.substr($fiN,0,4).")";
					else
						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;". $Date_actuel2."";
					?></span>
					<FONT SIZE=4 COLOR="0000FF"> </FONT> </div> <hr noshade size=3>
				</td>
				</tr>

		</table>


		<table align="center" width="1000" border="0" cellspacing="0" style="margin-top:0px;border-collapse: collapse;font-family:Cambria;">
		<?php
		if(empty($_POST['agent'])) $colspan=8; else $colspan=7;
			if(isset($_GET['p'])){
				echo "	<td
				colspan='".$colspan."' style='font-style:italic;'>
				<table align='center'>
				<td><br/><b>Période du:&nbsp;&nbsp; </b></td>
				<td>
					<br/><input type='date' name='debut' id='' size='20'  style='width:150px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value'";if(empty($debuT)) echo date('d-m-Y'); else echo $debuT; echo "'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				<td> <br/><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AU:&nbsp;&nbsp; </b></td>
				<td>
					<br/><input type='date' name='fin' id='' size='20'  style='width:150px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value'"; if(empty($fiN)) echo date('d-m-Y'); else echo $fiN; echo"'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				</td>
				<td><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='Submit' name='ok' value='OK' class='bouton3' style='border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;'/></td>

				<input type='hidden' name='agent' value='". $agent."'/>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table></td> ";
				}else echo "&nbsp;<br/>";

			if(isset($_GET['p'])) echo "<tr><td colspan='7'><br/></td></tr>";


			//if(isset($_POST['debut'])) $debuT=$_POST['debut'];else $debuT=substr($_GET['debut'],8,2).'-'.substr($_GET['debut'],5,2).'-'.substr($_GET['debut'],0,4);
			//if(isset($_POST['fin'])) $fiN=$_POST['fin'];else $fiN=substr($_GET['fin'],8,2).'-'.substr($_GET['fin'],5,2).'-'.substr($_GET['fin'],0,4);

			if(isset($_GET['debut'])) $debuT=substr($_GET['debut'],8,2).'-'.substr($_GET['debut'],5,2).'-'.substr($_GET['debut'],0,4); else $debuT=date('d-m-Y');
			if(isset($_GET['fin'])) $fiN=substr($_GET['fin'],8,2).'-'.substr($_GET['fin'],5,2).'-'.substr($_GET['fin'],0,4); else $fiN=date('d-m-Y');

			if (isset($_POST['ok'])&& $_POST['ok']=='OK')
			{	 $debut=substr($_POST['debut'],6,4).'-'.substr($_POST['debut'],3,2).'-'.substr($_POST['debut'],0,2);
				 $fin=substr($_POST['fin'],6,4).'-'.substr($_POST['fin'],3,2).'-'.substr($_POST['fin'],0,2);
				 echo "<span style='font-style:italic;font-size:0.8em;color:black;'>";  $debuT=$_POST['debut'];  $fiN=$_POST['fin'];
				//echo "<center> (Du&nbsp;".$debuT." &nbsp;au&nbsp;".$_POST['fin'].")</center></span>";
				$trie=!empty($_GET['trie'])?$_GET['trie']:NULL;
						if(empty($agent))
						{//mysqli_query($con,"SET NAMES 'utf8' ");
							$ref=mysqli_query($con,"SELECT * FROM reedition_facture WHERE date_emission>='".$debuT."' and date_emission<='".$fiN."' AND state <> '1' AND somme_paye <> '0' ORDER BY date_emission");
							$ref2=mysqli_query($con,"SELECT SUM(Remise) AS Remise FROM reedition_facture WHERE  date_emission>='".$debuT."' and date_emission<='".$fiN."' AND state <> '1' AND somme_paye <> '0' ");
							$data=mysqli_fetch_assoc($ref2);$remise=$data['Remise'];
							//echo 1254;
						//$ref=mysqli_query($con,"SELECT * FROM encaissement WHERE datencaiss>='".$debut."' and datencaiss<='".$fin."' ORDER BY datencaiss");
						}
						else
						{//mysqli_query($con,"SET NAMES 'utf8' ");
						$ref=mysqli_query($con,"SELECT * FROM reedition_facture WHERE  date_emission>='".$debuT."' and date_emission<='".$fiN."' AND receptionniste='".$_SESSION['login']."' AND state <> '1' AND somme_paye <> '0' ORDER BY date_emission");
						$ref2=mysqli_query($con,"SELECT SUM(Remise) AS Remise FROM reedition_facture WHERE  date_emission>='".$debuT."' and date_emission<='".$fiN."' AND receptionniste='".$_SESSION['login']."' AND state <> '1' AND somme_paye <> '0' ");
						$data=mysqli_fetch_assoc($ref2);$remise=$data['Remise'];
						//$ref=mysqli_query($con,"SELECT * FROM encaissement WHERE datencaiss>='".$debut."' and datencaiss<='".$fin."' and agenten='".$_SESSION['login']."' ORDER BY datencaiss");
						}

				$montant=0; //echo 14;
		}
		 else
			 {mysqli_query($con,"SET NAMES 'utf8'");	$date=$Jour_actuel;
				if(empty($agent))
			{//mysqli_query($con,"SET NAMES 'utf8' ");
			//$ref=mysqli_query($con,"SELECT * FROM encaissement WHERE datencaiss LIKE '$date' ORDER BY datencaiss");
			//echo 12;
			if(!empty($trie)&&(empty($debut))){ //echo 13;
			//echo "SELECT * FROM reedition_facture WHERE date_emission LIKE '$date' ORDER BY $trie ASC";
				$ref=mysqli_query($con,"SELECT * FROM reedition_facture WHERE date_emission LIKE '".$Jour_actuel."' AND state <> '1' AND somme_paye <> '0' ORDER BY $trie ASC");
				$ref2=mysqli_query($con,"SELECT SUM(Remise) AS Remise FROM reedition_facture WHERE  date_emission LIKE '".$Jour_actuel."' AND state <> '1' AND somme_paye <> '0'");
			}else if(!empty($trie)&&(!empty($debut))){
				//echo "SELECT * FROM reedition_facture WHERE date_emission>='".$debut."' and date_emission<='".$fin."' ORDER BY $trie ASC";
				$ref=mysqli_query($con,"SELECT * FROM reedition_facture WHERE date_emission>='".$debut."' and date_emission<='".$fin."'  AND state <> '1' AND somme_paye <> '0' ORDER BY $trie ");
				$ref2=mysqli_query($con,"SELECT SUM(Remise) AS Remise FROM reedition_facture WHERE  date_emission>='".$debut."' and date_emission<='".$fin."' AND state <> '1' AND somme_paye <> '0' ");
			} else {
				$ref=mysqli_query($con,"SELECT * FROM reedition_facture WHERE  date_emission LIKE '".$Jour_actuel."' AND state <> '1' AND somme_paye <> '0' ORDER BY  date_emission");
				$ref2=mysqli_query($con,"SELECT SUM(Remise) AS Remise FROM reedition_facture WHERE  date_emission LIKE '".$Jour_actuel."' AND state <> '1' AND somme_paye <> '0' ORDER BY  date_emission");

			}
				$data=mysqli_fetch_assoc($ref2);$remise=$data['Remise'];
			}
			else
			{//mysqli_query($con,"SET NAMES 'utf8' ");
			//echo 13;
			//$ref=mysqli_query($con,"SELECT * FROM encaissement WHERE datencaiss LIKE '$date' AND agenten='".$_SESSION['login']."' ORDER BY datencaiss");
			if(!empty($trie)&&(empty($debut))){ //echo 1;
				$ref=mysqli_query($con,"SELECT * FROM reedition_facture WHERE date_emission LIKE '".$Jour_actuel."' AND receptionniste='".$_SESSION['login']."' AND state <> '1' AND somme_paye <> '0' ORDER BY $trie ASC");
				$ref2=mysqli_query($con,"SELECT SUM(Remise) AS Remise FROM reedition_facture WHERE  date_emission LIKE '".$Jour_actuel."' AND receptionniste='".$_SESSION['login']."' AND state <> '1' AND somme_paye <> '0'");
			}else if(!empty($trie)&&(!empty($debut))){
				$ref=mysqli_query($con,"SELECT * FROM reedition_facture WHERE date_emission>='".$debut."' and date_emission<='".$fin."' AND receptionniste='".$_SESSION['login']."' AND state <> '1' AND somme_paye <> '0' ORDER BY $trie ASC");
				$ref2=mysqli_query($con,"SELECT SUM(Remise) AS Remise FROM reedition_facture WHERE  date_emission>='".$debut."' and date_emission<='".$fin."' AND receptionniste='".$_SESSION['login']."' AND state <> '1' AND somme_paye <> '0'");
				}else{
					 $sql="SELECT * FROM reedition_facture WHERE date_emission LIKE '".$Jour_actuel."' AND receptionniste='".$_SESSION['login']."' AND state <> '1' AND somme_paye <> '0' ORDER BY date_emission,heure_emission DESC";
					$ref=mysqli_query($con,$sql);
					$ref2=mysqli_query($con,"SELECT SUM(Remise) AS Remise FROM reedition_facture WHERE date_emission LIKE '".$Jour_actuel."' AND receptionniste='".$_SESSION['login']."' AND state <> '1' AND somme_paye <> '0' ORDER BY date_emission,heure_emission DESC");
				}
			$data=mysqli_fetch_assoc($ref2);$remise=$data['Remise'];
			}
			}
		?>
					<tr style="background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;">
					<!--<tr style='background-color:#EEEE99;'> -->
							<td WIDTH='' align='center'>N° </td>
							<td WIDTH='' align='center'>Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td WIDTH='' align='center'>Heure&nbsp;&nbsp;&nbsp;</td>
							<td WIDTH='' align='center'>N°. Facture</td>
							<td WIDTH='' align='center'>Type de Facture</td>
							<td WIDTH='' align='right' ><a class='info' style='color:white;' href="recette2.php?menuParent=Consultation<?php if(!empty($agent)) echo "&agent=1&p=1&";  echo "trie=somme_paye&debut=".$debuT."&fin=".$fiN; ?>">Montant<span style='font-size:0.8em;'>Trier suivant le montant</span></a></td>
							<td WIDTH='' align='center'><a class='info' style='color:white;' href="recette2.php?menuParent=Consultation<?php if(!empty($agent)) echo "&agent=1&p=1&";  echo "trie=objet&debut=".$debuT."&fin=".$fiN; ?>"><span style='font-size:0.8em;'>Trier suivant le type</span>Catégorie</a></td>
							<?php if(empty($_POST['agent'])) { ?>
							<td WIDTH='' align='center'><a class='info' style='color:white;' href="recette2.php?menuParent=Consultation<?php if(!empty($agent)) echo "&agent=1&p=1&";  echo "trie=agent&debut=".$debuT."&fin=".$fiN; ?>"><span style='font-size:0.8em;'>Trier suivant l'agent</span>Agent</a></td>
					 		<?php  } ?>
					 </tr>
				   <?php //echo "Récapitulatif des recttes ";?> <?php


			 //echo ")  </span>";
		//echo "<table align='center' border='1' width='40%'> ";
		//if(!empty($rerf['numrecu'])){
		//}

		$montant0=0;$i=0; $cpteur=1;$Arrhes=0;
		//$nbre=mysqli_num_rows($ref);
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
			$nom_client=addslashes($rerf['nom_client']);
			if(!empty($nom_client))
				$ref2=mysqli_query($con,"SELECT codegrpe FROM groupe WHERE codegrpe='".$nom_client."'");

				//echo "SELECT codegrpe FROM groupe WHERE codegrpe='".$nom_client."'";

			$nbreResult=mysqli_num_rows($ref2);
			//if($nbreResult>0)  $type="Facture de groupe";  else
			$type=$rerf['objet'];
			$somme_paye=$rerf['somme_paye'];$Arrhes+=$rerf['Arrhes'];
			if(!empty($ret['numrecu'])&& (!empty($ret['num_facture']) || !empty($ret['numFactNorm'] )) )
				{
					//if($rerf['Arrhes']>0) $somme_paye-=$rerf['Arrhes'];
					}
			if(!empty($rerf['numrecu'])) { $numrecu=$rerf['numrecu']; $typeE='Reçu ticket';	}else if(!empty($rerf['num_facture'])) {$numrecu=$rerf['num_facture']; $typeE='Facture ordinaire';
/* 			 $sql="SELECT DISTINCT(somme_paye) AS somme_payeF,numrecu AS numrecuF FROM reedition_facture WHERE date_emission LIKE '".$date."' AND receptionniste='".$_SESSION['login']."' AND num_facture = '".$rerf['num_facture']."' AND (numrecu  <> 0 AND numrecu  <> '')";
			$Query=mysqli_query($con,$sql); $data=mysqli_fetch_object($Query);   if(isset($data->somme_payeF)) $somme_paye-=$data->somme_payeF; */

			}else {$numrecu=$rerf['numFactNorm'];$typeE='Facture normalisée';
/* 			 $sql="SELECT DISTINCT(somme_paye),numrecu AS numrecuF AS somme_payeN FROM reedition_facture WHERE date_emission LIKE '".$date."' AND receptionniste='".$_SESSION['login']."' AND numFactNorm = '".$rerf['numFactNorm']."' AND (numrecu  <> 0 AND numrecu  <> '')";
			$Query=mysqli_query($con,$sql); $data=mysqli_fetch_object($Query);   if(isset($data->somme_payeN)) $somme_paye-=$data->somme_payeN; */
			}
				echo"<tr class='rouge1' bgcolor='".$bgcouleur."'> "; 	$i++;
					echo"<td align='center'> ";echo $i;echo".</td> ";
					echo"<td align='center'> "; echo substr($rerf['date_emission'],8,2).'-'.substr($rerf['date_emission'],5,2).'-'.substr($rerf['date_emission'],0,4);echo"</td> ";
					echo"<td align='center'> ";echo ucfirst($rerf['heure_emission']);echo"</td> ";
					echo"<td align='center'> ";
					//if($data->numrecuF) echo "<a class='info4' href=''><span>Reçu ticket associé : </span>";
						echo $numrecu;
					//if($data->numrecuF)  echo "</a> ";
					echo"</td> ";
					echo"<td align=''> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";echo $typeE; echo"</td> ";
					echo"<td align='right'> ";echo $somme_paye;echo"</td> ";
					echo"<td align='center'>&nbsp;&nbsp;&nbsp;&nbsp;";echo $type;echo"</td> ";

					if(empty($_POST['agent'])) {
							echo"<td align='center'>&nbsp;&nbsp;&nbsp;&nbsp;";echo ucfirst($rerf['receptionniste']) ;echo"</td> ";
					}
					echo "</tr>";
					$montant0+=$rerf['somme_paye'];
			//$montant=$montant+$montant0;
		}
		if((mysqli_num_rows($ref)==$i)&&($Arrhes>0)) {
			if($montantT>$montant0)	$montant0-=$Arrhes;

/* 			echo"<tr class='rouge1' bgcolor='beige'> ";
			echo"<td colspan='5' align='right' style='font-size:1.2em;'> Avance consommée par le client : </td>";
			echo"<td  align='right'> ".$Arrhes." </td>";	echo"<td  align='right'> &nbsp; </td>";
			echo "</tr>";

			echo"<tr class='rouge1' bgcolor='#acbfc5'> ";
			echo"<td colspan='5' align='right' style='font-size:1.2em;'> Montant Total réellement encaissé : </td>";
			echo"<td  align='right'> ".$montant0." ".$devise." </td>";	echo"<td  align='right'> &nbsp; </td>";
			echo "</tr>"; */

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
		<tr>
			<td
			<?php
			if(empty($_POST['agent'])) echo "colspan='8'"; else echo "colspan='7'";	 
			?>
			align='right' style='color:#444739;'> <br/> <b>Pour réimprimer toute la recette d'une période donnée, <a class='' href='recette2.php?menuParent=Consultation&p=1<?php //if(isset($agent)) echo "&agent=1"; ?>' style='text-decoration:none;'> Cliquez ici</a></b>
			</td>
		</tr>
	</table>
	</div>
</body>
</html>
