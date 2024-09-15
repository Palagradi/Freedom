<?php
include_once'menu.php';
unset($_SESSION['date_arrive2']);  unset($_SESSION['venant']); unset($_SESSION['allant']);	  unset($_SESSION['motif']); unset($_SESSION['motif']);unset($_SESSION['dateSortie']);

//$res=mysqli_query($con,"DELETE FROM client_tempon");

$req=mysqli_query($con,"CREATE TABLE IF NOT EXISTS NbreDouble(numero INT(6) AUTO_INCREMENT PRIMARY KEY,Numcli VARCHAR(50) )");
//$res=mysqli_query($con,"DELETE FROM NbreDouble");
  if (isset($_POST['ENREGISTRER'])&& $_POST['ENREGISTRER']=='Enrégistrer')
	{
		if(isset($_POST['exhonerer']) && $_POST['exhonerer']==1)
			$_SESSION['exhonerer']=$_POST['exhonerer']; $taxeU=$_POST['edit29']/$_POST['edit23'];
		if(isset($_POST['combo4'])&& isset($_POST['edit29'])&& isset($_POST['combo6'])&& isset($_POST['combo3'])&& isset($_POST['combo_5']))
			{  //echo 45;
			    $_SESSION['np']=$_POST['edit23'];   $_SESSION['numch']=$_POST['combo3'];  $_SESSION['mt']=$_POST['edit25'];   $_SESSION['Mttc1']=$_POST['edit26'];
				  $_SESSION['numero_c']= $_POST['combo_5'];	  $_SESSION['type_occupation1']= $_POST['combo4'];  $_SESSION['type_chambre']= $_POST['edit22'];
				  $_SESSION['tarif1']= $_POST['edit24']; $_SESSION['Ttaxe']=$taxeU;	$_SESSION['taxe1']=$_POST['edit28']; $_SESSION['Ttva1']=$_POST['combo6'];
				  $_SESSION['TVA1']=$_POST['edit29'];	 $_SESSION['date']= date('Y-m-d');

				 				  //+++++++++++++++A revoir +++++++++++++++++++++++
				  if(isset($_POST['edit26']) && ($_POST['edit23'])&& ($_POST['edit23']!=0))
				  $ttc_fixe=$_POST['edit26']/$_POST['edit23'];
				  mysqli_query($con,"SET NAMES 'utf8' ");
				  $res=mysqli_query($con,"SELECT numfiche FROM mensuel_fiche1 WHERE mensuel_fiche1.numcli_1='".$_SESSION['numero_c']."'AND mensuel_fiche1.etatsortie='NON' AND mensuel_fiche1.codegrpe='".$_SESSION['groupe']."' AND mensuel_fiche1.datarriv='".$_SESSION['date_arrive']."'");
				  $ret=mysqli_fetch_assoc($res);
				  $numero_f=$ret['numfiche'];

				$totalRows_Recordset = mysqli_num_rows($res);
				if($totalRows_Recordset==2) $etat_6=6;
				$numch= $_POST['combo3'];
				$date=$_POST['edit_24'];
				$_SESSION['type_occup']= $_POST['combo4'];
				if($_POST['combo4']=='double')	$etat1=1;
				if(isset($_POST['edit26']) && ($_POST['edit23'])&& ($_POST['edit23']!=0))
					$ttc_fixe=$_POST['edit26']/$_POST['edit23'];
				$Avance1=!empty($_POST['edit27'])?$_POST['edit27']:NULL;
				$numcli1=trim($_POST['combo_5']);

				$state=0;$continue=0;
				if($_SESSION['type_occupation1']=="double")
					{	$en=mysqli_query($con,"INSERT INTO NbreDouble VALUES (NULL,'$numcli1')");
						$ret="SELECT * FROM NbreDouble ";
						$ret1=mysqli_query($con,$ret);
						if(mysqli_num_rows($ret1)>=2){
						  $res=mysqli_query($con,"DELETE FROM NbreDouble");
						  unset($_SESSION['np']);  unset($_SESSION['numch']);  unset($_SESSION['mt']);  unset($_SESSION['Mttc1']); unset($_SESSION['numero_c']);
						  unset($_SESSION['type_occupation1']); unset($_SESSION['type_chambre']); unset($_SESSION['tarif1']);unset($_SESSION['Ttaxe']);
						  unset($_SESSION['taxe1']);	unset($_SESSION['Ttva1']);	 unset($_SESSION['TVA1']);
						$test = "UPDATE fiche1 SET numcli_2='$numcli1' WHERE numfiche='".$_SESSION['numero_f']."' ";	$query=mysqli_query($con,$test);
						$test=mysqli_query($con,"UPDATE view_fiche2 SET numcli='$numcli1' WHERE numfiche='".$_SESSION['numero_f']."'");	$query=mysqli_query($con,$test);
						$reqsupA = mysqli_query($con,"UPDATE mensuel_view_fiche2 SET numcli='$numcli1' WHERE numfiche='".$_SESSION['numero_f']."'");
						$reqsupB = mysqli_query($con,"UPDATE mensuel_fiche1 SET numcli_2='$numcli1' WHERE numfiche='".$_SESSION['numero_f']."' ");
						unset($_SESSION['numero_f']);
						echo "<script language='javascript'>";
						echo 'alertify.success("Enrégistrement effectué !");';
						echo "</script>";
						}else {
						echo "<script language='javascript'>";
						echo 'alertify.success("Enrégistrez maintenant le Second occupant de la chambre");';
						echo "</script>";	$_SESSION['numero_f']=$numero_f;
						$test=mysqli_query($con,"UPDATE view_fiche2 SET numcli='$numcli1' WHERE numfiche='".$numero_f."'");
						$test = "UPDATE fiche1 SET numcli_2='$numcli1' WHERE numfiche='".$numero_f."' ";
						$reqsupA = mysqli_query($con,"UPDATE mensuel_view_fiche2 SET numcli='$numcli1' WHERE numfiche='".$numero_f."'");
						$reqsupB = mysqli_query($con,"UPDATE mensuel_fiche1 SET numcli_2='$numcli1' WHERE numfiche='".$numero_f."' ");
						}
							$en=mysqli_query($con,"INSERT INTO client_tempon VALUES ('$numcli1')");
							$Recordset1=mysqli_query($con,"SELECT * FROM client_tempon");
							$totalRows_Recordset = mysqli_num_rows($Recordset1);
							if($totalRows_Recordset==$_SESSION['nombre1'])
								{$etat='OUI';$_SESSION['client_tempon']=0;
								} $state=1;
					$continue=1;
					//echo 13;
				}
				else{ //echo 12;

				unset($_SESSION['np']);  unset($_SESSION['numch']);  unset($_SESSION['mt']);  unset($_SESSION['Mttc1']); unset($_SESSION['numero_c']);
				unset($_SESSION['type_occupation1']); unset($_SESSION['type_chambre']); unset($_SESSION['tarif1']);unset($_SESSION['Ttaxe']);
				unset($_SESSION['taxe1']);	unset($_SESSION['Ttva1']);	 unset($_SESSION['TVA1']);

					$test=mysqli_query($con,"UPDATE fiche1 SET numcli_2='$numcli1' WHERE numfiche='$numero_f'");
					 $test=mysqli_query($con,"UPDATE view_fiche2 SET numcli='$numcli1' WHERE numfiche='$numero_f'");
					 $testA=mysqli_query($con,"UPDATE mensuel_fiche1 SET numcli_2='$numcli1' WHERE numfiche='$numero_f'");
					 $testB=mysqli_query($con,"UPDATE mensuel_view_fiche2 SET numcli='$numcli1' WHERE numfiche='$numero_f'");
					//}

					if (!empty($test))
					{$etat_2='true';
					 $en=mysqli_query($con,"INSERT INTO client_tempon VALUES ('$numcli1')");
					 }	$continue=1;
				}
				if($continue==1){
				$ret="SELECT * FROM mensuel_fiche1, compte WHERE mensuel_fiche1.numfiche=compte.numfiche and numch='$numch' and etatsortie='NON' ";
				$ret1=mysqli_query($con,$ret);
				$nbre2=mysqli_num_rows($ret1);

				if($nbre2>=1)
				{	if(isset($state)&&($state!=1)){
					echo "<script language='javascript'>";
					echo 'alertify.error("Cette chambre est occupée !");';
					echo "</script>";}

				} else
				{	$_SESSION['nuit']=$taxeU; $_SESSION['tch']=$_POST['edit22']; $_SESSION['tarif']=$_POST['edit24']; $_SESSION['taxe']=$_POST['edit28'];
					$_SESSION['tv']=$_POST['combo6']; $_SESSION['tva']=$_POST['edit29']; $_SESSION['due']=!empty($_POST['edit27'])?$_POST['edit31']:NULL;
					$sql='SELECT DISTINCT code_reel FROM groupe WHERE codegrpe LIKE "'.$_SESSION['groupe'].'"';
					$res=mysqli_query($con,$sql);
					$ret=mysqli_fetch_assoc($res);
					$code_grpe=$ret['code_reel'];
					//enregistrement du compte
					if (!empty($numero_f)AND !empty($numch)){
					$sql=mysqli_query($con,"SELECT avance FROM avance_tempon");
					$data= mysqli_fetch_assoc($sql);
					$avance=$data['avance'];
						//A revoir
					$numresch=!empty($_SESSION['numreserv'])?$_SESSION['numreserv']:NULL;
					$req=mysqli_query($con,"SELECT chambre.numch,chambre.nomch,reserverch.typeoccuprc,reserverch.tarifrc,reserverch.ttc,reserverch.nuite_payee FROM reserverch,chambre WHERE chambre.EtatChambre='active' AND chambre.numch=reserverch.numch AND numresch='".$numresch."'  AND chambre.numch='".$_POST['combo3']."' AND chambre.numch NOT IN (SELECT numch AS numch FROM chambre_tempon) LIMIT 1");
					 $result=mysqli_num_rows($req);
					 $data1= mysqli_fetch_assoc($req);
					 $np=$data1['nuite_payee'];
					 $np=!empty($np)?$np:NULL;
			         $montant=$ttc_fixe*$np;

          if($_POST['edit42']==0) //Non assujetti à la TVA
            $combo6=0; else $combo6=$_POST['combo6'];
					if($avance>0)
					{ $test = "UPDATE avance_tempon SET avance=avance-'$montant'";
					  $reqsup = mysqli_query($test) or die(mysqli_error($con));	 $date=$Date_actuel2;
					  //$reto=mysqli_query($con, "INSERT INTO compte VALUES ('".$numero_f."','".$numch."','". $_SESSION['type_occup']."','".$_POST['edit24']."','".$_POST['edit23']."','','".$taxeU."','".$combo6."','0','$ttc_fixe','$montant','0','$np','0','')");
					  //echo "INSERT INTO mensuel_compte VALUES ('$numero_f','".$numch."','". $_SESSION['type_occup']."','".$_POST['edit24']."','".$_POST['edit23']."','','".$taxeU."','".$combo6."','0','$ttc_fixe','$montant','0','$np','0','')";
            $post="VALUES ('".$numero_f."','".$numch."','". $_SESSION['type_occup']."','".$_POST['edit24']."','".$_POST['edit23']."','','".$taxeU."','".$combo6."','0','0',".$ttc_fixe."','$montant','0','$np','0','')";
             $req1="INSERT INTO mensuel_compte ".$post ;$req2="INSERT INTO compte ".$post ;
            $retoA=mysqli_query($con,$req1);$retoA=mysqli_query($con,$req2);
					  if(!empty($_POST['exhonerer']) && ($_POST['exhonerer']==1))
							$sql=mysqli_query($con,"INSERT INTO exonerer_tva VALUES('$date','".$_SESSION['groupe']."')");
					}
					else
					{  $due=isset($_SESSION['due'])?$_SESSION['due']:0;
           $post="VALUES ('".$numero_f."','".$numch."','". $_SESSION['type_occup']."','".$_POST['edit24']."','".$_POST['edit23']."','0','".$taxeU."','".$combo6."','0','0','".$ttc_fixe."','0','".$due."','0','0','')";
            $req1="INSERT INTO mensuel_compte ".$post ;$req2="INSERT INTO compte ".$post ;
           $retoA=mysqli_query($con,$req1);$retoA=mysqli_query($con,$req2);
						if(isset($_POST['exhonerer']) && $_POST['exhonerer']==1)
							$sql=mysqli_query($con,"INSERT INTO exonerer_tva VALUES('$date','".$_SESSION['groupe']."')");
					}

					}
				}
				}
				if(!empty($etat1) && ($etat1==1))
				  {if(!empty($etat_2) && $etat_2=='true')
					{
					 }
					else {
					if(isset($state)&&($state!=1)){
					echo "<script language='javascript'>";
					echo 'alertify.error("Cette chambre est déjà occupée !");';
					echo "</script>";}
					}
				  }

		if(isset($retoA)) {
		if(isset($state)&&($state!=1)){
		echo "<script language='javascript'>";
		echo 'alertify.success("Enrégistrement effectué !");';
		echo "</script>";
			}
		}
		else {
		}

		if(!empty($etat_2) && ($etat_2=='true'))
		{$date=$Date_actuel2;
		if(isset($_SESSION['numreserv']))$ret=mysqli_query($con,"INSERT INTO reservation_tempon VALUES ('$date','".$_SESSION['numreserv']."')");
		}
		}
		}
		$Recordset1=mysqli_query($con,"SELECT * FROM client_tempon");
		$ret=mysqli_fetch_assoc($Recordset1);
		 $totalRows_Recordset = mysqli_num_rows($Recordset1);
		if($totalRows_Recordset>=$_SESSION['nombre_1'])
		{ 	unset($_SESSION['np']);  unset($_SESSION['numch']);  unset($_SESSION['mt']);  unset($_SESSION['Mttc1']); unset($_SESSION['numero_c']);
			unset($_SESSION['type_occupation1']); unset($_SESSION['type_chambre']); unset($_SESSION['tarif1']);unset($_SESSION['Ttaxe']);
			unset($_SESSION['taxe1']);	unset($_SESSION['Ttva1']);	 unset($_SESSION['TVA1']);
			header('location:loccup.php?menuParent=Consultation');
			//$msg2="<span style='font-style:italic;font-size:0.9em;'> Pour éditer la facture de groupe, <a href='loccup.php?menuParent=Consultation' style='text-decoration:none;'>Cliquez ici</a><span>";
		}




?>
<html>
	<head>
		<link rel="Stylesheet" href='css/table.css' />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
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
		td {
			  padding: 12px 0;
		}
		</style>
		<script type="text/javascript">
		function Aff()
		{
			if (document.getElementById("edit23").value!='')
			{
				document.getElementById("edit25").value=(('\t'+document.getElementById("edit24").value)*document.getElementById("edit23").value).toFixed(4);
			}
		}
		function Aff1()
		{
			if (document.getElementById("edit23").value!='')
			{
				if ((document.getElementById("combo4").value=='individuelle')||(document.getElementById("edit_28").value==1))
				document.getElementById("edit28").value=document.getElementById("edit23").value*document.getElementById('combo5').options[document.getElementById('combo5').selectedIndex].value;
				else
				document.getElementById("edit28").value=document.getElementById("edit_28").value*document.getElementById("edit23").value*document.getElementById('combo5').options[document.getElementById('combo5').selectedIndex].value;
			}
		}
		function Aff2()
		{
			if (document.getElementById("edit25").value!='')
			{
				document.getElementById("edit29").value=((document.getElementById("edit25").value*document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value)+
				(document.getElementById("edit28").value*document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value)
				).toFixed(4);
				y=0.1+parseFloat(document.getElementById("edit28").value)+parseFloat(document.getElementById("edit29").value)+parseFloat(document.getElementById("edit25").value);
				document.getElementById("edit26").value=Math.floor(y);
			}
		}
		function Aff3()
		{
			if (document.getElementById("edit33").value!='')
			{
				document.getElementById("edit31").value=parseInt(document.getElementById("edit_38").value)-parseInt(document.getElementById("edit33").value);
				document.getElementById("edit32").value=Math.floor(document.getElementById("edit33").value/
							(parseInt(document.getElementById('combo5').options[document.getElementById('combo5').selectedIndex].value)+
							 ((document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value)*('\t'+document.getElementById("edit24").value)+parseInt('\t'+document.getElementById("edit24").value))));
			}
		}
		function Aff4()
		{
			if (document.getElementById("edit27").value!='')
			{
				document.getElementById("edit33").value=parseInt(document.getElementById("edit30").value)+parseInt(document.getElementById("edit27").value);
			} else
			{
				document.getElementById("edit33").value=parseInt(document.getElementById("edit30").value);
			}
		}
			</script>
	</head>
	<body bgcolor='azure' style="margin-top:-20px;padding-top:0px;">
	<div class='container' align='' style=''>
		<table align='center' id="tab" style='font-size:1.1em;' width='800'>
		<tr>
	<?php
$numreserv=!empty($_SESSION['numreserv'])?$_SESSION['numreserv']:NULL;
$sql=mysqli_query($con,"SELECT sum(reserverch.ttc*reserverch.nuite_payee) AS avance FROM reserverch,chambre WHERE chambre.EtatChambre='active' AND chambre.numch=reserverch.numch AND numresch='".$numreserv."' ORDER BY reserverch.nuite_payee DESC LIMIT 1");
while ($data= mysqli_fetch_array($sql))
	{  $avance_groupe=$data['avance'];
	}
	$sql=mysqli_query($con,"SELECT * FROM avance_tempon");
	$nbre=mysqli_num_rows($sql);
	if($nbre<=0)
	$en=mysqli_query($con,"INSERT INTO avance_tempon VALUES ('$avance_groupe')");
	?>
				<td>
					<fieldset style='border:0px solid white;background-color:#D0DCE0;font-family:Cambria;'>
					<legend align='center' style='font-size:1.3em;color:#3EB27B;'>	<h3 style="text-align:center; font-family:Cambria;color:maroon;font-weight:bold;"></h3></legend>
						<form action='selection_chambre.php?menuParent=Hébergement' method='post' >
						<input type='hidden' name='edit_35' id='edit_35' value='<?php echo $chaine = random('F',5);?>'/>
		<?php
		if(!empty($numreserv))
		{echo"<table align='center'>
		<tr><td align='center'> <span style=' font-style:italic;font-size:1em;'> Avance de Réservation payée par le groupe:</span>
			<input type='text' name='edit27' id='edit27' value='".$avance_groupe."' readonly /> </td>
		</tr>
		<tr>";
			$sql=mysqli_query($con,"SELECT chambre.numch,chambre.nomch,reserverch.typeoccuprc,reserverch.tarifrc,reserverch.ttc,reserverch.nuite_payee FROM reserverch,chambre WHERE chambre.EtatChambre='active' AND chambre.numch=reserverch.numch AND numresch='".$_SESSION['numreserv']."' AND chambre.numch NOT IN (SELECT numch AS numch FROM chambre_tempon)");
			$nbre=mysqli_num_rows($sql);
			if($nbre>0)
			{echo"<td><span style='color:black; font-style:italic;'> Liste des chambres reservées:</span> ";
			$compteur=0;
			while ($data= mysqli_fetch_array($sql))
			{	$numch=$data['numch'];
				if($compteur%5==0)
				echo"";
				echo "<span style='color:#CD5C5C;font-size:0.8em; font-style:italic;'>".$nomch=$data['nomch'];
				echo "</span> <span style='color:white;font-size:0.8em; font-style:italic;'>(".$typeoccuprc=$data['typeoccuprc']; echo") </span>;&nbsp;";
				$compteur++;

			}

		echo"</td></tr>
		</table>";
		}
		}
		?>
		<table style='' align='center'  >
					<tr>
						<td colspan="4">
							<h3 style='text-align:center; font-family:Cambria;color:maroon;font-weight:bold;margin-top:-25px;'>SELECTION DES CHAMBRES</h3>
							<hr style='width:100%;'/>
						</td>
					</tr>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span style='font-style:italic;font-size:0.7em;'> </span>
			<?php
			$s=mysqli_query($con,"SELECT * FROM mensuel_fiche1,client WHERE mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.etatsortie='NON' and mensuel_fiche1.codegrpe='".$_SESSION['groupe']."' AND mensuel_fiche1.datarriv='".$_SESSION['date_arrive']."' ");
			$ret1=mysqli_fetch_assoc($s); $ret1['nomcli'];

           	?>

			<tr>
			<?php
				if(isset($_SESSION['type_occupation1'])&& ($_SESSION['type_occupation1']=="double")) echo "<td style='color:maroon;font-weight:bold;'>Second occupant : &nbsp; </td>";
				else echo "<td> Occupant de la chambre : &nbsp;</td>";
			?>
				 <td>
				 <select name='combo_5' id='combo_5' onchange=" " style='width:200px;font-family:sans-serif;font-size:80%;'>
					<option value=''> </option>
			<?php
					$Recordset1=mysqli_query($con,"SELECT * FROM client_tempon");
					$ret=mysqli_fetch_assoc($Recordset1);
					$nombre=mysqli_num_rows($Recordset1);
					$totalRows_Recordset = mysqli_num_rows($Recordset1);
					if(($totalRows_Recordset!=$_SESSION['nombre_1'])){
					mysqli_query($con,"SET NAMES 'utf8' ");
					$res=mysqli_query($con,"SELECT DISTINCT client.numcli,client.nomcli,client.prenomcli FROM mensuel_fiche1,client WHERE mensuel_fiche1.numcli_1=client.numcli AND etatsortie='NON' and codegrpe='".$_SESSION['groupe']."' AND mensuel_fiche1.datarriv='".$_SESSION['date_arrive']."' AND mensuel_fiche1.numcli_1 NOT IN(SELECT * FROM client_tempon)
					AND mensuel_fiche1.numcli_1 NOT IN(SELECT * FROM client_tempon)");
					while ($ret=mysqli_fetch_array($res))
							{
								echo '<option value="'.$ret['numcli'].'">';
								echo($ret['nomcli'].' '.$ret['prenomcli']);
								echo '</option>' ;
								echo "<option value=''> </option>";
							}
							}
					else{
						}
												?>
					</select>
					</td>
						<td> 	&nbsp; &nbsp;&nbsp;Nuitée : </td>
						<td> 	<input type='text' name='edit23' id='edit23' readonly /> </td>
					</tr>

								<tr>
									<td> Chambre N° : </td>
									<td>

										<select name='combo3' id='combo3' style='width:200px;font-family:sans-serif;font-size:80%;'>
										<?php
										if(isset($_SESSION['numch']))  {echo "<option value='".$_SESSION['numch']."'>";
											$res=mysqli_query($con,'SELECT nomch FROM chambre WHERE EtatChambre="active" AND numch= "'.$_SESSION['numch'].'"');
											$ret=mysqli_fetch_assoc($res);
											echo $nomch=$ret['nomch']."
											</option>";}
											else{echo "<option value=''> </option>";
												$res=mysqli_query($con,"SELECT numch,nomch FROM chambre WHERE EtatChambre='active' AND numch NOT IN (SELECT compte.numch FROM mensuel_fiche1,compte WHERE chambre.EtatChambre='active' AND mensuel_fiche1.numfiche=compte.numfiche and mensuel_fiche1.etatsortie='NON' UNION SELECT compte.numch FROM mensuel_fiche1,compte WHERE mensuel_fiche1.numfiche=compte.numfiche and mensuel_fiche1.etatsortie='NON')AND numch NOT IN (SELECT numch FROM chambre_tempon) ") or die (mysql_error());
													while ($ret=mysqli_fetch_array($res))
														{
															echo '<option value="'.$ret['numch'].'">';
															echo($ret['nomch']);
															echo '</option>' ;
															echo "<option value=''> </option> "; 
														}
											}
										?>
										</select>
									</td>
									 <td>&nbsp; &nbsp;&nbsp;  Type chambre :&nbsp; </td>
									<td>  <input type='text' name='edit22' id='edit22' readonly value='<?php if(isset($_SESSION['type_chambre'])) echo $_SESSION['type_chambre'];?>'/> </td>
								</tr>

                <input type='hidden' required='required'  id='TvaD'  value='<?php echo $TvaD;?>'/>
                <input type='hidden' required='required' name='edit42' id='edit42'  value='<?php //if(!empty($RegimeTVA)&&($RegimeTVA==1)) echo 1; else echo $TvaD;?>'/>

								<tr>
									<td>  Type d'occupation : </td>
									<td>
										 <select name='combo4' id='combo4' style='width:200px;font-family:sans-serif;font-size:80%;'>
										<?php
										if(isset($_SESSION['type_occupation1'])) {echo "<option value='".$_SESSION['type_occupation1']."'>".$_SESSION['type_occupation1']."</option>";}
											else{	echo "<option value=''> </option>
													<option value='individuelle'> INDIVIDUELLE</option>
													<option value=''> </option> 
													<option value='double'> DOUBLE</option>";
											}
										?>

										</select>
									</td>
									<td> &nbsp; &nbsp;&nbsp; Tarif HT : </td>
									<td>  <input type='text' name='edit24' id='edit24' onblur="Aff();" readonly value='<?php if(isset($_SESSION['tarif1'])) echo $_SESSION['tarif1'];?>'/> </td>

                   <td> <input type='hidden' name='edit_24' id='edit_24' value="<?php echo date('Y-m-d') ?>"/>  <td>
                    <td> <input type='hidden' name='edit_25' id='edit_25' value="<?php echo date('d/m/Y') ?>"/>  <td>

								</tr>
								<tr>

									<td>  Montant HT : </td>
									<td>  <input type='text' name='edit25' id='edit25' readonly value='<?php if(isset($_SESSION['mt'])) echo $_SESSION['mt'];?>' style='width:200px;'/> </td>

								<input type='hidden' name='combo6' id='' readonly value='<?php if(isset($TvaD)) echo $TvaD;  ?>'/>

								<!--	<td>  Taux sur Taxe: </td>
									<td>
										<select name='combo5' id='combo5' onchange="Aff1();" style='width:165px;font-family:sans-serif;font-size:80%;'>
										<?php
										/*  if(isset($_SESSION['Ttaxe']))
											 echo "<option value='".$_SESSION['Ttaxe']."'>".$_SESSION['Ttaxe']."</option>";
										else {
												echo "<option value=''></option>";
												echo "<option value='".$Mtaxe."'>".$Mtaxe."</option>";
										} */
										?>
										</select><input type='hidden' name='edit_28' id='edit_28' readonly  value='<?php echo $etat_taxe; ?>' />
									</td> !-->
									<td> &nbsp; &nbsp;&nbsp; Valeur TVA : </td>
									<td>  <input type='text' name='edit28' id='edit28' readonly  value='<?php if(isset($_SESSION['taxe1'])) echo $_SESSION['taxe1'];?>' style='width:200px;'/> </td>
								</tr>
								<!-- <tr>
								<td>  Taux TVA: </td>
									<td>

										<select name='combo6' id='combo6' onchange='Aff2();'style='width:165px;font-family:sans-serif;font-size:80%;'>

												<?php
/* 												 if(isset($_SESSION['Ttva1'])){echo "<option value='".$_SESSION['Ttva1']."'>"; echo 100*$_SESSION['Ttva1']; echo "% </option>";
												 }
												 else{
												$TVa=$TvaD*100;
												echo "<option value=''> </option>";
												echo '<option value="'.$TvaD.'">';
												echo $TVa;
												echo '%</option>' ;
												 } */
												?>
										</select>
									</td>
								</tr>!-->
								<tr>
									<td>  Taxe de séjour : </td>
									<td>  <input type='text' name='edit29' id='edit29' readonly value='<?php if(isset($_SESSION['TVA1'])) echo $_SESSION['TVA1'];?>' style='width:200px;'/> </td>

									<td>  &nbsp; &nbsp;&nbsp; Montant TTC : </td>
									<td>  <input type='text' name='edit26' id='edit26'readonly value='<?php if(isset($_SESSION['Mttc1'])) echo $_SESSION['Mttc1'];?>' /> </td>
								</tr>

								</tr>

								<tr>
								<?php
                                   if(!empty($etat_3) && $etat_3==5) echo '<td colspan="4" align="center">   <input class="bouton2" type="submit" name="ENREGISTRE" id="ENREGISTRE" value="Enrégistrer" onclick="if(!confirm(\'Voulez-vous vraiment continuer?\')) return false;"  />&nbsp;</td>';
								   else
								   echo "<td colspan='4' align='center'>
								   <br/><input type='submit' class='bouton2' name='ENREGISTRER' id='ENREGISTRER' value='Enrégistrer' style=''/>&nbsp;</td>";

								?>
								</tr>
								<tr>
								<td>
								<?php $msg2=!empty($msg2)?$msg2:NULL; echo $msg2;  $msg=!empty($msg)?$msg:NULL; ?>
								</td>
								<td>
								</tr>
							</table>

						</form>
					</fieldset>
				</td>
			</tr>


		</table>
<?php //echo $msg;
 ?>
	</div>
	</body>
	<script type="text/javascript">


		// fonction pour selectionner le type de chambre
		function action6(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						//document.getElementById('edit22').value = '\t'+leselect;
            var mavariable = leselect.split('|');
            document.getElementById('edit42').value = mavariable[1];
            document.getElementById('edit22').value = '\t'+mavariable[0];
            //document.getElementById('edit22').value = '\t'+leselect;
            if(document.getElementById('edit42').value ==0)
            alertify.success("Non Assujetti(e) à la TVA");
					}
				}
				xhr.open("POST","ftypech.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo3');
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("numch="+sh);
		}

				// fonction pour selectionner nuitee de l'occupant
		function action_06(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit23').value = '\t'+leselect;
					}
				}
				xhr.open("POST","fnuitee.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo_5');
				sh = sel.options[sel.selectedIndex].value;

				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("numcli="+sh);
		}


		// fonction pour selectionner le tarif
		function action7(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						if(leselect<=20000)
							var TaxeSejour = 500;
						else if((leselect>20000) && (leselect<=100000))
							var TaxeSejour = 1500;
						else
							var TaxeSejour = 2500;
						//document.getElementById('edit24').value = leselect;
						var NbreNuite = 1; if(document.getElementById('edit23').value>0) NbreNuite =document.getElementById('edit23').value;

            var TvaD =document.getElementById("TvaD").value;
            var diviseur=1; if ((document.getElementById("edit42").value!=0))	var diviseur =parseFloat(diviseur)+parseFloat(TvaD);

						document.getElementById('edit24').value = Math.round((leselect-TaxeSejour)/diviseur);
            if(diviseur==1) document.getElementById('edit28').value = 0;
						else document.getElementById('edit28').value = Math.round (NbreNuite*(((leselect-TaxeSejour)/diviseur)*TvaD));
						document.getElementById('edit29').value = TaxeSejour * NbreNuite;
						document.getElementById('edit26').value = leselect * NbreNuite;
						document.getElementById('edit25').value = NbreNuite*document.getElementById('edit24').value;
						//document.getElementById('edit25').value = (document.getElementById('edit24').value *document.getElementById('edit23').value).toFixed(4);
					}
				}
				xhr.open("POST","others/ftarif.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo4');
				sel1 = document.getElementById('combo3');
				sh1=sel1.options[sel1.selectedIndex].value;
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("objet="+sh+"&numch="+sh1);
		}

		//affichage des informations concernant le client


		var momoElement1 = document.getElementById("combo3");
		if(momoElement1.addEventListener){
		  momoElement1.addEventListener("change", action6, false);
		 // momoElement1.addEventListener("change", action7, false);
		  //momoElement1.addEventListener("change", Verif, false);
		}else if(momoElement1.attachEvent){
		  momoElement1.attachEvent("onchange", action6);
		 // momoElement1.attachEvent("onchange", action7);
		  //momoElement1.attachEvent("onchange", verif);
		}

		var momoElement2 = document.getElementById("combo4");
		if(momoElement2.addEventListener){
		  momoElement2.addEventListener("change", action7, false);

		}else if(momoElement2.attachEvent){
		  momoElement2.attachEvent("onchange", action7);

		}

		var momoElement3 = document.getElementById("combo_5");
		if(momoElement3.addEventListener){
		  momoElement3.addEventListener("change", action_06, false);

		}else if(momoElement3.attachEvent){
		  momoElement3.attachEvent("onchange", action_06);

		}



		//fonction standard
		function getXhr(){
			xhr=null;
				if(window.XMLHttpRequest){
					xhr=new XMLHttpRequest();
				}
				else if(window.ActiveXObject){
					try {
			                xhr = new ActiveXObject("Msxml2.XMLHTTP");
			            } catch (e) {
			                xhr = new ActiveXObject("Microsoft.XMLHTTP");
			            }
				}
				else{
					alert("votre navigateur ne suporte pas les objets XMLHttpRequest");
				}
				return xhr;
			}
	</script>
</html>
