<?php
include_once'menu.php';
	$_SESSION['nuiteA']='';	$_SESSION['mt']=''; $_SESSION['av']='';	$_SESSION['mtht']=''; 	$_SESSION['mtttc']='';
	$_SESSION['avc']='';$_SESSION['avc_salle']=''; 	$_SESSION['tn']=''; $_SESSION['tva']=''; 	$_SESSION['numresch']='';
	$_SESSION['exhonerer1']='';$_SESSION['exhonerer2']='';$_SESSION['exhonerer_aib']='';

 	$query1=mysqli_query($con,"CREATE TABLE SalleTempon (`nom` VARCHAR( 50 ) NOT NULL ,`designation` VARCHAR( 50 ) NOT NULL ,`tarif` DOUBLE NOT NULL ,PRIMARY KEY ( `designation` , `tarif` ))");

	$req=mysqli_query($con,"SELECT * FROM salle");
	while($reqi=mysqli_fetch_array($req)){
	    $codesalle=$reqi['codesalle']." pour fête";$nom=$reqi['codesalle']." <br/>pour fête";
		$ret=mysqli_query($con,"INSERT INTO SalleTempon VALUES('$nom','$codesalle','".$reqi['tariffete']."')");
		//$req=mysqli_query($con,$ret);
	}
	$req=mysqli_query($con,"SELECT codesalle,tarifreunion  FROM salle");
	while($reqi=mysqli_fetch_array($req)){
		$codesalle=$reqi['codesalle']." pour réunion";$nom=$reqi['codesalle']." <br/>pour réunion";
		$ret=mysqli_query($con,"INSERT INTO SalleTempon VALUES('$nom','$codesalle','".$reqi['tarifreunion']."')");
		//$req=mysqli_query($con,$ret);
	}
		//$query1=mysqli_query($con," CREATE TABLE `codiam`.`DateTempon` (`id` INT NOT NULL AUTO_INCREMENT ,`debut` DATE NOT NULL ,`fin` DATE NOT NULL ,PRIMARY KEY ( `id` )) ");


		// if (isset($_POST['Nouveau'])&& $_POST['Nouveau']=='Sauver & Nouveau') {
		// 	$demandeur=$_POST['demandeur']; $groupe=$_POST['groupe']; $adresse=$_POST['adresse'];$telephone=$_POST['telephone'];$typechambre=$_POST['typechambre'];$occupation=$_POST['occupation'];$typesalle=$_POST['typesalle'];
		// 	$du=$_POST['ladate'];$au=$_POST['ladate2'];
		// 	$debut=substr($_POST['ladate'],6,4).'-'.substr($_POST['ladate'],3,2).'-'.substr($_POST['ladate'],0,2);
		// 	$fin=substr($_POST['ladate2'],6,4).'-'.substr($_POST['ladate2'],3,2).'-'.substr($_POST['ladate2'],0,2);
		// 		 $etat=0;
		// 		if(!empty($_POST['typechambre'])||!empty($_POST['typesalle'])){
		// 			if(!empty($_POST['typechambre'])){
		// 			if(!empty($_POST['occupation']))
		// 			{ 	if($_POST['occupation']=="individuelle")
		// 					  $sql="SELECT tarifsimple AS tarif FROM chambre  WHERE DesignationType='".$_POST['typechambre']."' AND EtatChambre='active' LIMIT 1";
		// 				else
		// 					  $sql="SELECT tarifdouble AS tarif FROM chambre  WHERE DesignationType='".$_POST['typechambre']."' AND EtatChambre='active' LIMIT 1";
		// 				$req=mysqli_query($con,$sql);
		// 				$reqi=mysqli_fetch_assoc($req); $tarif=$reqi['tarif'];
		// 				if(empty($_POST['NbreChambre'])|| ($_POST['NbreChambre']==1) )
		// 					{$Designation="Chambre"; $Tchambre=$_POST['typechambre'];}
		// 				else
		// 					{$Designation="Chambres"; $Tchambre=$_POST['typechambre']."s";}
		// 					if(empty($_POST['NbreChambre'])) $NbreChambre=1; else $NbreChambre=$_POST['NbreChambre'] ;
		// 				echo $ret="INSERT INTO facturepro VALUES('".$_POST['edit1']."','$Designation','".$_POST['occupation']."','$Tchambre','$tarif','".$NbreChambre."','$debut','$fin')"; echo "<br/>";
		// 				$req=mysqli_query($con,$ret);
		// 				$etat=1;
		// 				$typechambre='';$occupation='';
		//
		// 			}else
		// 			{	$etat=0;
		// 				echo "<script language='javascript'>";
		// 				echo 'alertify.error("Renseignez le type d\'occupation SVP");';
		// 				echo "</script>";
		// 			}
		// 			}
		// 			if(!empty($_POST['typesalle'])){
		// 				$sql="SELECT nom,tarif  FROM salletempon  WHERE designation='".$_POST['typesalle']."'";
		// 				$req=mysqli_query($con,$sql);$reqi=mysqli_fetch_assoc($req); $tarif=$reqi['tarif']; $nom=$reqi['nom'];
		//
		// 				if(empty($_POST['NbreSalle'])|| ($_POST['NbreSalle']==1) )
		// 					{$Designation="Salle"; $Tsalle=$_POST['typesalle'];}
		// 				else
		// 					{$Designation="Salles"; $Tsalle=$_POST['typechambre']."s";}
		// 				if(empty($_POST['NbreSalle'])) $NbreSalle=1; else $NbreSalle=$_POST['NbreSalle'] ;
		// 				echo "<br/>";
		// 				$ret="INSERT INTO facturepro VALUES('".$_POST['edit1']."','$nom','','','$tarif','".$NbreSalle."','$debut','$fin')";
		// 				$req=mysqli_query($con,$ret);
		// 				$etat=2;$typesalle='';
		// 			}
		// 			if(($etat==1)||($etat==2)){ //echo $etat;
		// 				echo "<script language='javascript'>";
		// 				echo 'alertify.success(" Données Enregistrées. Entrez un Nouveau type de chambre ou de salle");';
		// 				echo "</script>";}
		// 			}else
		// 			{	$etat=0;
		// 				echo "<script language='javascript'>";
		// 				echo 'alertify.error("Veuillez spécifier un type de chambre ou de type salle SVP !");';
		// 				echo "</script>";
		// 			}
		//
		// }


 $demandeur=isset($_GET['demandeur'])?$_GET['demandeur']:NULL; $groupe=isset($_GET['groupe'])?$_GET['groupe']:NULL; $adresse=isset($_GET['adresse'])?$_GET['adresse']:NULL;$telephone=isset($_GET['telephone'])?$_GET['telephone']:NULL;
 $groupe=isset($_GET['groupe'])?$_GET['groupe']:NULL; $debut=isset($_GET['debut'])?$_GET['debut']:NULL;$fin=isset($_GET['fin'])?$_GET['fin']:NULL;


// enregistrement dans reservationch
	if (isset($_POST['ENREGISTRER'])&& $_POST['ENREGISTRER']=='Enrégistrer')
		{
			$demandeur=$_POST['demandeur']; $groupe=$_POST['groupe']; $adresse=$_POST['adresse'];$telephone=$_POST['telephone'];$groupe=$_POST['groupe'];

			$typechambre=$_POST['typechambre'];$occupation=$_POST['occupation'];$typesalle=$_POST['typesalle'];
			$du=!empty($_POST['ladate'])?$_POST['ladate']:"0000-00-00";$au=!empty($_POST['ladate2'])?$_POST['ladate2']:"0000-00-00";
			 $debut=!empty($_POST['ladate'])?$_POST['ladate']:"0000-00-00";$fin=!empty($_POST['ladate2'])?$_POST['ladate2']:"0000-00-00";
			if(!empty($_POST['typechambre'])||!empty($_POST['typesalle'])){
			if(!empty($_POST['typechambre'])){
			if(!empty($_POST['occupation']))
			{	if($_POST['occupation']=="individuelle")
					  $sql="SELECT tarifsimple AS tarif,RegimeTVA FROM chambre  WHERE DesignationType='".$_POST['typechambre']."' AND EtatChambre='active' LIMIT 1";
				else
					  $sql="SELECT tarifdouble AS tarif,RegimeTVA FROM chambre  WHERE DesignationType='".$_POST['typechambre']."' AND EtatChambre='active' LIMIT 1";
				$req=mysqli_query($con,$sql);
				$reqi=mysqli_fetch_assoc($req);  $tarif=$reqi['tarif'];  if($reqi['RegimeTVA']==0) $tva=0; else $tva=$TvaD;
				if(empty($_POST['NbreChambre'])|| ($_POST['NbreChambre']==1) )
					{$Designation="Chambre"; $Tchambre=$_POST['typechambre'];}
				else
					{$Designation="Chambres"; $Tchambre=$_POST['typechambre']."s";}
					if(empty($_POST['NbreChambre'])) $NbreChambre=1; else $NbreChambre=$_POST['NbreChambre'] ; $occupation=$_POST['occupation']."s";
					echo "<br/>";
				$ret="INSERT INTO facturepro VALUES('".$_POST['edit1']."','$Designation','".$occupation."','$Tchambre','$tarif','".$tva."','".$NbreChambre."','".$debut."','".$fin."')";
				$req=mysqli_query($con,$ret);
				//$etat=1;
				$typechambre='';$occupation='';

				echo "<script language='javascript'>";
				echo 'alertify.success("Enrégistrement effectué.");';
				echo "</script>";

				$etat=4;
				}else
				{	echo "<script language='javascript'>";
					echo 'alertify.error("Renseignez le type d\'occupation SVP");';
					echo "</script>";
				}
				}
				if(!empty($_POST['typesalle'])){ //$_SESSION['objetS']=2; $_SESSION['objetC']=0;
						$sql="SELECT nom,tarif  FROM salletempon  WHERE designation='".$_POST['typesalle']."'";
					$req=mysqli_query($con,$sql);$reqi=mysqli_fetch_assoc($req); $tarif=$reqi['tarif']; $tarif=$reqi['tarif']; $nom=$reqi['nom'];

					if(empty($_POST['NbreSalle'])|| ($_POST['NbreSalle']==1) )
						{$Designation="Salle"; $Tsalle=$_POST['typesalle'];}
					else
						{$Designation="Salles"; $Tsalle=$_POST['typechambre']."s";}
					if(empty($_POST['NbreSalle'])) $NbreSalle=1; else $NbreSalle=$_POST['NbreSalle'] ;
					$ret="INSERT INTO facturepro VALUES('".$_POST['edit1']."','$nom','','','$tarif','".$NbreSalle."','$debut','$fin')";
					$req=mysqli_query($con,$ret);
					$etat=5;$typesalle='';

						echo "<script language='javascript'>";
						echo 'alertify.success("Enrégistrement effectué.");';
						echo "</script>";
				}
				}else
				{	echo "<script language='javascript'>";
					echo 'alertify.error("Veuillez spécifier un type de chambre ou de type salle SVP");';
					echo "</script>";
				}
				$agent=$_SESSION['login'];
				$_SESSION['debut']=isset($_POST['ladate'])?$_POST['ladate']:NULL;
				$_SESSION['fin']=isset($_POST['ladate2'])?$_POST['ladate2']:NULL;
				$_SESSION['contact']=isset($_POST['edit5'])?$_POST['edit5']:NULL;
				$_SESSION['groupe']=isset($_POST['combo1'])?$_POST['combo1']:NULL;
				$_SESSION['nom']=isset($_POST['edit3'])?$_POST['edit3']:NULL;
				$_SESSION['numFacture']=isset($_POST['edit1'])?$_POST['edit1']:NULL;

				$Sql="SELECT numFacture FROM factureproforma WHERE numFacture LIKE '".$_POST['edit1']."'";$Query=mysqli_query($con,$Sql);

				$etat=!empty($etat)?$etat:NULL;
				if(($etat==4)||($etat==5)){ $mtTTC=!empty($mtTTC)?$mtTTC:0.0;
				  if(mysqli_num_rows($Query)<=0) {$pre_sql1="INSERT INTO factureproforma VALUES('".$_POST['edit1']."','".$Date_actuel2."','".$_POST['demandeur']."','".$_POST['adresse']."','".$_POST['telephone']."','".$_POST['groupe']."','$debut','$fin','$mtTTC','".$_SESSION['login']."')";
					$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
					}


				   // $pre_sql1="INSERT INTO facturepro VALUES('','".$_POST['edit1']."','".$_POST['typechambre']."','".$_POST['edit12']."','".$_POST['typesalle']."','$mtHT','".$_POST['edit13']."')";
					//$req1 = mysqli_query($con,$pre_sql1) or die (mysql_error());

				}

	if (isset($_POST['Nouveau'])){
		 $typechambre=$_POST['typechambre'];$occupation=$_POST['occupation'];$typesalle=$_POST['typesalle'];
		$du=$_POST['ladate'];$au=$_POST['ladate2'];
		echo '<meta http-equiv="refresh" content="1; url=proforma.php?menuParent=Facturation&demandeur='.$demandeur.'&groupe='.$groupe.'&adresse='.$adresse.'&telephone='.$telephone.'&debut='.$debut.'&fin='.$fin.'&groupe='.$groupe.'" />';

		if(($etat==1)||($etat==2)){ //echo $etat;
		echo "<script language='javascript'>";
		echo 'alertify.success(" Données Enregistrées. Ajoutez une nouvelle ligne.");';
		echo "</script>";}

	}else {
		//$Sql="SELECT numFacture FROM factureproforma WHERE numFacture LIKE '".$_POST['edit1']."'";$Query=mysqli_query($con,$Sql);
		if(mysqli_num_rows($Query)>0){ //$_SESSION['objet']=isset($_SESSION['objetC'])?$_SESSION['objetC']:0 + isset($_SESSION['objetS'])?$_SESSION['objetS']:0;
			$update=mysqli_query($con,"UPDATE configuration_facture SET num_proForma=num_proForma+1 ");
			 if($RegimeTVA==0) $location='FactureProFormaTPS.php'; else $location='FactureProForma.php';
			echo "<iframe src='"; echo $location;  echo "' width='1000' height='800' style='margin-left:10%;'></iframe>";
		}else{
			//echo "<script language='javascript'>";
			//echo 'alertify.error(" Aucune donnée Enregistrée.");';
			//echo "</script>";
			echo '<meta http-equiv="refresh" content="1; url=proforma.php?menuParent=Facturation" />';
			}
		}
	}

	//$demandeur=$_POST['demandeur']; $groupe=$_POST['groupe']; $adresse=$_POST['adresse'];$telephone=$_POST['telephone'];

	//}
?>
<html>
	<head>
		<link rel="Stylesheet" href='css/table.css' />
		<link rel="Stylesheet" type="text/css"  href='css/input.css' />
		<script type="text/javascript" src="js/date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
	<style>
			td {
			  padding: 7px 0;
			}
		</style>
	</head>
	<script>
	function FuncToCall(){
	  //cc.innerHTML = "<input type='text' name='edit5' id='edit5' style='width:200px;' required='required'/> ";
	  //document.getElementById("edit5").value=12;
	}
	</script>

	<body bgcolor='azure' style="">
		<?php
	if(!isset($_GET['p'])) {
	?><br/>
	<div align="" style="">
	<table align='center'  id="tab" >
		<tr>
			<td>
			<fieldset  style='margin-left:auto; margin-right:auto;border:0px solid white;background-color:#D0DCE0;font-family:Cambria;width:950px;'>
			<legend align='center' style='font-size:1.3em;color:#3EB27B;'></legend>
			<form action='proforma.php?menuParent=Facturation&p=1' method='post' name='form1' onSubmit='Verif(); '>
				<h3 style="text-align:center; font-family:Cambria;color:maroon;font-weight:bold;"> EDITION DE FACTURE PRO FORMA </h3>
				<table width='' height='' align='center' style='margin-left:45px;margin-right:45px;'>
				 <input type='hidden' name='etat' value='<?php if(!empty($etat)) echo $etat;?>'/>
				 	<tr>
						<td colspan='4'><hr style='margin-top:-20px;margin-bottom:-15px;'/>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Numéro : </td>
						<td><input type='text' name='edit1' id='edit1' readonly style='width:250px;' value="<?php
									/* if($etat_facture=='AA')
									{   $chaine1 = substr(random($Nbre_char,''),0,3);
										$chaine2 = substr(random($Nbre_char,''),5,2);
										$year=(substr(date('Y'),3,1)+substr(date('Y'),2,1))-5;
										echo $chaine = $initial_proforma.$year.$chaine1.$chaine2;
									}
									if($etat_facture=='AI')
									{ */	if(($num_proForma >=0)&&($num_proForma <=9))
												echo $initial_proforma.'0000'.$num_proForma  ;
										else if(($num_proForma >=10)&&($num_proForma <=99))
												echo $initial_proforma.'000'.$num_proForma  ;
										else if(($num_proForma >=100)&&($num_proForma <=999))
												echo $initial_proforma.'00'.$num_proForma  ;
										else if(($num_proForma >=1000)&&($num_proForma <=1999))
												echo $initial_proforma.'0'.$num_proForma  ;
										else
												echo $initial_proforma.$num_proForma ;
									//}
									?>"/>
									</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nom du Groupe : </td>
						<td>
						<select name='groupe' style='font-family:sans-serif;font-size:80%;width:250px;'/>
								<option value='<?php if(!empty($groupe)) echo $groupe;?>'><?php if(!empty($groupe)) echo $groupe;?> </option>
									<?php
									    mysqli_query($con,"SET NAMES 'utf8'");
										$ret=mysqli_query($con,'SELECT codegrpe FROM groupe');
										while ($ret1=mysqli_fetch_array($ret))
											{
												echo '<option value="'.$ret1[0].'">';
												echo($ret1[0]);
												echo '</option>';
											}
									?>
							</select> </td>
					</tr>
					<tr>
						<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demandeur : <span style='color:red;font-style:italic;'>*</span></td>
						<td> <input type='text' name='demandeur' onkeyup='this.value=this.value.toUpperCase()' placeholder=' Nom & prénoms' required='required' style='' value='<?php if(!empty($demandeur)) echo $demandeur;?>'/> </td>
					<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adresse : <span style='color:red;font-style:italic;'>*</span></td>
						<td>
						<input type='text' name='adresse' id='edit5' style='' required='required' value='<?php if(!empty($adresse)) echo $adresse;?>'/>
						</td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N° de Téléphone : <span style='color:red;font-style:italic;'>*</span></td>
						<td> <input type='text' name='telephone'onkeypress="testChiffres(event);" style='' required='required' value='<?php if(!empty($telephone)) echo $telephone;?>'/> </td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre de Chambres : <span style='color:red;font-style:italic;'></span></td>
						<td>
								<?php
								$res=mysqli_query($con,'SELECT count(numch) AS nbre FROM chambre where EtatChambre="active"');
									while ($ret=mysqli_fetch_array($res))
									{$nbre=$ret['nbre'];
									}
								?>


							<input type='number' min='1' <?php echo "max='".$nbre."'"; ?> name='NbreChambre' id='NbreChambre' onkeypress="testChiffres(event);" style=''  placeholder='0'/>
							</td>

					</tr>
					<tr>
						<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type de Chambres  : </td>
						<td>
							<select name='typechambre' style='font-family:sans-serif;font-size:80%;' />
								<option value='<?php if(!empty($typechambre)) echo $typechambre;?>'><?php if(!empty($typechambre)) echo $typechambre;?>  </option>
									<?php
									    mysqli_query($con,"SET NAMES 'utf8'");
										$ret=mysqli_query($con,'SELECT DISTINCT DesignationType FROM chambre WHERE EtatChambre="active" AND RegimeTVA ="'.$RegimeTVA.'"');
										while ($ret1=mysqli_fetch_array($ret))
											{
												echo '<option value="'.$ret1['DesignationType'].'">';
												echo strtoupper($ret1['DesignationType']."S");
												echo '</option>';
											}
									?>
							</select>
						</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type d'occupation : </td>
						<td>
							 <select name='occupation' id='occupation' style='font-family:sans-serif;font-size:80%;' onchange='FuncToCall()'>
								<option value='<?php if(!empty($occupation)) echo $occupation;?>'><?php if(!empty($occupation)) echo $occupation;?> </option>
								<option value='individuelle'>Individuelle</option>
								<option value='double'>Double</option>
							</select></td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type de Salles  : </td>
						<td>
							<select name='typesalle' style='font-family:sans-serif;font-size:80%;'/>
								<option value=''><?php if(!empty($typesalle)) echo $typesalle;?> </option>
									<?php
									    mysqli_query($con,"SET NAMES 'utf8'");
										$ret=mysqli_query($con,'SELECT DISTINCT designation,tarif FROM SalleTempon');
										while ($ret1=mysqli_fetch_array($ret))
											{
												echo '<option value="'.$ret1[0].'">';
												echo($ret1[0]);
												echo '</option>';
											}
									?>
							</select>
						</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre de Salles : </td>
						<td>
								<?php
								$res=mysqli_query($con,"SELECT codesalle AS nbre FROM salle");
								$nbre=mysqli_num_rows($res);
								?>
								<input type='number' min='1' <?php echo "max='".$nbre."'"; ?> name='NbreSalle' id='NbreSalle' onkeypress="testChiffres(event);" style='' placeholder='0'/>
							</td>
						<td>

					</tr>

						<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Période du : </td>
							  <td style=" border: 0px solid black;"><input  type="date" name="ladate" id="ladate" size="25"  value='<?php if(isset($debut)) echo $debut;?>'/>
								  <!-- <a href="javascript:show_calendar('form1.ladate');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
									 <img src="logo/cal.gif" style="border:0px solid red;margin-bottom:-2px;" alt="calendrier" title="calendrier"></a> !-->
							  </td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Au : </td>
							  <td style=" border: 0px solid black;"> <input  type="date" name="ladate2" id="ladate2" size="20" value='<?php if(!empty($fin)) echo $fin;?>'/>
								<!--   <a href="javascript:show_calendar('form1.ladate2');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
									 <img src="logo/cal.gif" style="border:0px solid red;margin-bottom:-2px;" alt="calendrier" title="calendrier"></a> !-->
							  </td>
					</tr>
					<tr> <td><input type='hidden' name='nui' id='nui'/> </td><td> <input type='hidden' name='edit18' value="<?php echo date('Y-m-d') ?>" readonly /> </td></tr>
					<tr>
					<tr> <br/>
						<td colspan='4' align='center'>

						<span style='float:left'><input checked type='checkbox' name='Nouveau' id='button_checkbox1'  onclick='pal2();'>
						<label for='button_checkbox1' style='color:#444739;'>Ajouter à nouveau</label></span>

						<br/><a href='#' class='info2'> <input type='submit' name='ENREGISTRER' value='Enrégistrer' class='bouton2' style=""/>
						<!-- <span style='font-size:0.8em;'>Tout enrégistrer et sortir la facture proforma </span> !-->
						</a>
						<span style='float:right'><input disabled checked type='checkbox' name='RegimeTVA' id='button_checkbox2' value='<?php if(isset($RegimeTVA)&&($RegimeTVA==0)) echo "0"; else echo 2; ?>' >
						<label for='button_checkbox2' style='color:#444739;'><?php   if(isset($RegimeTVA)&&($RegimeTVA==0)) echo "Exempté(e) de la TVA"; else echo "Assujetti(e) à la TVA";?> </label></span>
					</td>
					</tr>
					<!-- <tr>
						<td colspan='4' align='center'>  &nbsp;</td>
					</tr> !-->
				</table>
			</form>
		</fieldset>
	 <?php $msg1=!empty($msg1)?$msg1:NULL; echo "<h4 align='center'>";echo $msg1."</h4>" ; ?>
	 </td>
		</tr>
	</table>
	</div>
		<?php
	}
	?>
	</body>
   <script type="text/javascript">

   		//uppercase first letter
			function ucfirst(field) {
				field.value = field.value.substr(0, 1).toUpperCase() + field.value.substr(1);
			}

		function Nuite()
			{
				var d1=document.getElementById("edit18").value;
				var d2=document.getElementById('se6').options[document.getElementById('se6').selectedIndex].value+'-'+document.getElementById('se5').options[document.getElementById('se5').selectedIndex].value+'-'+document.getElementById('se4').options[document.getElementById('se4').selectedIndex].value;
				var date1= new Date(d1);
				var date2= new Date(d2);
				var nuite=(date2-date1)/86400000;
				//alert (nuite);
				if (nuite==0)
				{nuite=nuite+1}
				document.getElementById("nui").value=nuite;
			}



		// fonction pour selectionner le nom du client
	   function action(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
					//id du champ qui receptionne le résultat
						document.getElementById('edit3').value = leselect;

					}
				}
				//nom du fichier qui exécute la requete
				xhr.open("POST","fnomcli.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				//id du numcli
				sel = document.getElementById('edit2').value;
				//affectation de la valeur saisie a la requete php
				xhr.send("numcli="+sel);
		}
		// fonction pour selectionner le prenom du client
		function action1(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit4').value=leselect;

					}
				}
				xhr.open("POST","fprenomcli.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}
		//fonction pour selectionner le sexe du client
		function action2(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit5').value = leselect;

					}
				}
				xhr.open("POST","fsexecli.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}
		// fonction pour selectionner la date de naissance du client
		function action3(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit6').value = leselect;

					}
				}
				xhr.open("POST","fdatnaisscli.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}
		// fonction pour selectionner le lieu de naissance du client
		function action4(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit7').value = leselect;

					}
				}
				xhr.open("POST","flieucli.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}
		// fonction pour selectionner le pays du client
		function action5(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit8').value = leselect;

					}
				}
				xhr.open("POST","fpayscli.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}
		// fonction pour selectionner le type de chambre
		function action6(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit22').value = leselect;
					}
				}
				xhr.open("POST","ftypech.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo3');
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("numch="+sh);
		}
		// fonction pour selectionner le tarif
		function action7(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit24').value = leselect;
					}
				}
				xhr.open("POST","ftarif.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo4');
				sel1 = document.getElementById('combo3');
				sh1=sel1.options[sel.selectedIndex].value;
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("objet="+sh+"&numch="+sh1);
		}

		//affichage des informations concernant le client
		var momoElement = document.getElementById("edit2");
		if(momoElement.addEventListener){
		  momoElement.addEventListener("blur", action, false);
		  momoElement.addEventListener("keyup", action, false);
		   momoElement.addEventListener("blur", action1, false);
		  momoElement.addEventListener("keyup", action1, false);
		  momoElement.addEventListener("blur", action2, false);
		  momoElement.addEventListener("keyup", action2, false);
		  momoElement.addEventListener("blur", action3, false);
		  momoElement.addEventListener("keyup", action3, false);
		  momoElement.addEventListener("blur", action4, false);
		  momoElement.addEventListener("keyup", action4, false);
		  momoElement.addEventListener("blur", action5, false);
		  momoElement.addEventListener("keyup", action5, false);
		}else if(momoElement.attachEvent){
		  momoElement.attachEvent("onblur", action);
		  momoElement.attachEvent("onkeyup", action);
		  momoElement.attachEvent("onblur", action1);
		  momoElement.attachEvent("onkeyup", action1);
		   momoElement.attachEvent("onblur", action2);
		  momoElement.attachEvent("onkeyup", action2);
		   momoElement.attachEvent("onblur", action3);
		  momoElement.attachEvent("onkeyup", action3);
		   momoElement.attachEvent("onblur", action4);
		  momoElement.attachEvent("onkeyup", action4);
		   momoElement.attachEvent("onblur", action5);
		  momoElement.attachEvent("onkeyup", action5);
		  //momoElement.attachEvent("onchange", action1);
		}

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
