<?php
include_once'menu.php';

		if(isset($_GET['sal'])&&($_GET['sal']!=1)){
			$numfiche=isset($_GET['numfiche'])?$_GET['numfiche']:NULL;
			$reqsel=mysqli_query($con,"SELECT * FROM mensuel_compte,mensuel_fiche1,chambre WHERE mensuel_fiche1.numfiche=mensuel_compte.numfiche  AND chambre.numch=mensuel_compte.numch 	AND mensuel_compte.numfiche ='".$numfiche."' ");
			while($data=mysqli_fetch_array($reqsel))
				{  $numfiche=$data['numfiche'];  $numch=$data['numch'];  $nomch=$data['nomch'];  $typeoccup=$data['typeoccup'];  $tarif=$data['tarif'];
				   $nuite=$data['nuite'];  //$taxe=$data['taxe'];  //$ttc=$data['ttc'];
					 $somme=$data['somme'];  $np=$data['np']; $ttc_fixe=$data['ttc_fixe'];

					 $n=round((strtotime($Jour_actuel)-strtotime($data['datarriv']))/86400);
					 $dat=(date('H')+1);
					 settype($dat,"integer");
					 if ($dat<14){$n=$n;}else {$n= $n+1;}
					 if ($n==0){$n= $n+1;} $n=(int)$n;
					 $mt=$data['ttc_fixe']*$n;
					 $due = $mt-$data['somme'];
					 $somme=$data['somme'];
					 $N_reel=$n-$data['np'] ;
				}
		}

	if (isset($_POST['DELOGER'])&& $_POST['DELOGER']=='DELOGER')
		{  	//echo "SELECT * FROM mensuel_compte,mensuel_fiche1,chambre WHERE mensuel_compte.numfiche=mensuel_fiche1.numfiche AND chambre.numch=mensuel_compte.numch AND mensuel_fiche1.etatsortie ='NON' AND chambre.EtatChambre='active' AND mensuel_compte.numch='".$_POST['combo3']."'";
			 $typeoccup=$_POST['combo4'];$nuite=$_POST['edit24']; $ttc_fixe= isset($_POST['edit24'])?trim($_POST['edit24']):null; $ttc_fixeT=$N_reel*$ttc_fixe;
			//$reqsel=mysqli_query($con,"SELECT * FROM mensuel_compte,mensuel_fiche1,chambre WHERE mensuel_compte.numfiche=mensuel_fiche1.numfiche AND chambre.numch=mensuel_compte.numch AND mensuel_fiche1.etatsortie ='NON' AND chambre.EtatChambre='active' AND mensuel_compte.numch='".$_POST['combo3']."'");
			//$nbre=mysqli_num_rows($reqsel);
			//if($nbre<=0)
				 //{
				 // $reqselS=mysqli_query($con,"SELECT tarif from chambre WHERE EtatChambre='active' AND numch='".$_POST['combo3']."'");
				 // 		while($dataS=mysqli_fetch_array($reqselS))
					// 		{ if($typeoccup=="double")
					// 			    $tarif =$dataS['tarifdouble']; else  $tarif =$dataS['tarifsimple'];
					// 					$tarifT=round($tarif*$nuite,4) ;
					// 		}
				$update =0; $tarifT=0;
				if($_POST['somme']	> 0) {   //Ici le client a déjà payé quelque chose
					if($ttc_fixeT!=$_POST['due']){ //echo $ttc_fixeT;
						echo "<script language='javascript'>";
						echo 'alertify.error("Impossible de déloger. Le montant de la nouvelle chambre est différent du montant de l\'ancienne chambre. ");';
						echo "</script>";
					}else {  //Le client a déjà payé quelque chose a payé mais l'ancienne chambre et la nouvelle ont le même prix
						$update = 1;
					}
				}else {
					 $update = 1;
				}
				if($update == 1){
							 $sql="SET numch='".$_POST['combo3']."',typeoccup ='".$typeoccup."',ttc_fixe='".$ttc_fixe."'  WHERE numfiche ='".$_POST['numfiche']."'";
							 echo $sql2="UPDATE compte ".$sql; $sql3="UPDATE mensuel_compte ".$sql;
							 $update1=mysqli_query($con,$sql2);$update1=mysqli_query($con,$sql3);
							 $sql="SET numch='".$_POST['combo3']."'  WHERE ref='".$_POST['numfiche']."'";
							 $update1=mysqli_query($con,"UPDATE encaissement ".$sql);$update1=mysqli_query($con,"UPDATE mensuel_encaissement ".$sql);
							 header('location:loccup.php?menuParent=Consultation');
				}
				//echo "UPDATE compte SET numch='".$_POST['combo3']."',typeoccup ='".$typeoccup."',ht='".$tarifT."',ttc_fixe='".$ttc_fixe."',ttc='".$ttc_fixeT."'  WHERE numfiche ='".$_POST['numfiche']."'";
				  //echo $sql="UPDATE compte SET numch='".$_POST['combo3']."',typeoccup ='".$typeoccup."',ht='".$tarifT."',ttc_fixe='".$ttc_fixe."',ttc='".$ttc_fixeT."'  WHERE numfiche ='".$_POST['numfiche']."'";
					//$update1=mysqli_query($con,);
				  //$update3=mysqli_query($con,"UPDATE mensuel_compte SET numch='".$_POST['combo3']."',typeoccup ='".$typeoccup."',ht='".$tarifT."',ttc_fixe='".$ttc_fixe."',ttc='".$ttc_fixeT."'  WHERE numfiche ='".$_POST['numfiche']."'");
				  //$update2=mysqli_query($con,"UPDATE encaissement SET numch='".$_POST['combo3']."'  WHERE ref='".$_POST['numfiche']."'");
				  //$update4=mysqli_query($con,"UPDATE mensuel_encaissement SET numch='".$_POST['combo3']."'  WHERE ref='".$_POST['numfiche']."'");
				  //header('location:loccup.php?menuParent=Consultation');
/* 				 }
			else
				 { echo "<script language='javascript'>alert('Cette chambre est occupée');</script>";
				 } */
		}

	if(isset($_GET['sal'])&&($_GET['sal']!=1)){
		$numch = isset($_POST['combo3'])?$_POST['combo3']:$numch;
		$idr1 = isset($_POST['combo4'])?trim($_POST['combo4']):null;
		$idr2 = isset($_POST['edit22'])?trim($_POST['edit22']):null;

		$sql="SELECT nomch,tarifsimple,tarifdouble from chambre WHERE EtatChambre='active' AND numch='".$numch."' AND DesignationType='".$idr2."'";
		$reqselS=mysqli_query($con,$sql);
		while($dataS=mysqli_fetch_array($reqselS)){
		if($idr1=="double") $ttc_fixe =$dataS['tarifdouble'];	else $ttc_fixe =$dataS['tarifsimple'];
		$nomch =$dataS['nomch'];
		}
	}
?>
<html>
	<head>
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<link rel="Stylesheet" href='css/table.css' />
		<style>
			.alertify-log-custom {
				background: blue;
			}
			td {
				padding: 8px 0;
			}
		</style>

		<script type="text/javascript">
		function Aff()
		{
			if (document.getElementById("edit23").value!='')
			{
				document.getElementById("edit25").value= (('\t'+document.getElementById("edit24").value)*document.getElementById("edit23").value).toFixed(4);
			}
		}
		function Aff5()
		{
			if (document.getElementById("edit25").value!='')
			{
				document.getElementById("edit_25").value=parseFloat(document.getElementById("edit_25").value)+parseFloat(document.getElementById("edit25").value);
			}
		}
		function Aff1()
		{
			if (document.getElementById("edit23").value!='')
			{   if (document.getElementById("combo4").value=='individuelle')
				document.getElementById("edit28").value=document.getElementById("edit23").value*document.getElementById('combo5').options[document.getElementById('combo5').selectedIndex].value;
				else
				document.getElementById("edit28").value=2*document.getElementById("edit23").value*document.getElementById('combo5').options[document.getElementById('combo5').selectedIndex].value;
			}
		}
		function Aff2()
		{
			if (document.getElementById("edit25").value!='')
			{
				document.getElementById("edit29").value=(document.getElementById("edit25").value*document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value).toFixed(4);
				document.getElementById("edit26").value=Math.round(parseFloat(document.getElementById("edit28").value)+parseFloat(document.getElementById("edit29").value)+parseFloat(document.getElementById("edit25").value));
			}
		}
		function Aff3()
		{
			if (document.getElementById("edit33").value!='')
			{
				document.getElementById("edit31").value=parseInt(document.getElementById("edit26").value)-parseInt(document.getElementById("edit33").value);
				document.getElementById("edit32").value=parseInt(document.getElementById("edit33").value/Math.round(
							(parseFloat(document.getElementById('combo5').options[document.getElementById('combo5').selectedIndex].value)+
							 ((document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value)*('\t'+document.getElementById("edit24").value)+parseInt('\t'+document.getElementById("edit24").value)))));
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
	<body bgcolor='azure' style="margin-top:-20px;padding-top:0px;"><br/>
		<div class="container" align="" style="">
				<table align='center' width='800' id="tab"> <tr> <td>
						<form action='deloger.php?menuParent=Consultation<?php if(isset($_GET['numfiche'])) echo "&numfiche=".$_GET['numfiche']; //echo getURI_();?>' method='post' id="chgdept">
		<?php
		if(isset($_GET['sal'])&&($_GET['sal']!=1))
		{
		$jSt='SELECT DesignationType FROM chambre WHERE numch="'.$numch.'"';
		$res=mysqli_query($con,$jSt);
		$ret=mysqli_fetch_assoc($res);  $type_ch=$ret['DesignationType'];

		?>
			<table width='' height='300' style='margin-left:50px;'>
								<tr>
							<td colspan="4"><h3 style="text-align:center; font-family:Cambria;color:maroon;font-weight:bold;">DELOGEMENT DU CLIENT</h3><br/>
							</td>
								</tr>
								<tr>
									<td colspan='4'><hr style='margin-bottom:-35px;margin-top:-20px;'/>&nbsp;</td>
								</tr>
								<input type='hidden' name='numfiche' id='' value='<?php echo $numfiche; ?>'readonly />
								<tr>
									<td> Chambre N° : </td>
									<td>&nbsp;
										<select name='combo3' id='combo3' style='width:210px;font-family:sans-serif;font-size:0.9em;' onchange="document.forms['chgdept'].submit();">
											<option value='<?php if(isset($numch)) echo $numch;?>'> <?php if(isset($nomch)) echo $nomch;
											else echo ""?></option>
												<?php
													$res=mysqli_query($con,"SELECT numch,nomch FROM chambre WHERE EtatChambre='active' AND numch NOT IN ($numch) AND numch NOT IN (SELECT mensuel_compte.numch FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.numfiche=mensuel_compte.numfiche and mensuel_fiche1.etatsortie='NON') ORDER BY nomch");
													while ($ret=mysqli_fetch_array($res))
														{   echo "<option value=''> </option>";
															echo '<option value="'.$ret['numch'].'">';
															echo($ret['nomch']);
															echo '</option>' ;
															echo "<option value=''> </option>";
														}

												?>
										</select>
									</td>
									<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type de chambre : </td>
									<td> <input type='text' name='edit22' id='edit22' value='<?php
									echo strtoupper($type_ch);?>'/> </td>
								</tr>
								<tr>
									<td> <br/>Type d'occupation : </td>
									<td> <br/>
										&nbsp;&nbsp;<select name='combo4' id='combo4' style='width:210px;font-family:sans-serif;font-size:0.9em;' id="Type" onchange="document.forms['chgdept'].submit();">
									<?php
											echo "<option value='"; echo $typeoccup; echo"'> "; echo strtoupper($typeoccup); echo"</option>"; ?>
											<option value=''> </option>
											<?php 
												//if($typeoccup!="INDIVIDUELLE")
											    echo "<option value='individuelle'> INDIVIDUELLE</option>";
											?>
											<option value=''> </option>
											<?php 
												//if($typeoccup!="DOUBLE")
											    echo "<option value='double'> DOUBLE</option>";
											?>
										</select>
									</td>
									<td> <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tarif de la chambre : &nbsp;</td>
									<td> <br/><input style='font-family:sans-serif;font-size:0.9em;' type='text' name='edit24' id='edit24' onblur="Aff();" readonly
										<?php if(!empty($ttc_fixe)) echo "value='".$ttc_fixe."'";?>/> </td>
								</tr>

								<input type='hidden' name='due' <?php if(!empty($due)) echo "value='".$due."'";?>/>
								<input type='hidden' name='somme' <?php if(!empty($somme)) echo "value='".$somme."'";?>/>
								<input type='hidden' name='edit23' id='edit23' value='<?php echo $nuite; ?>'readonly />

								<tr>
									<td colspan='4' align='center'> <br/><input class='bouton2' type='submit' name='DELOGER' id='DELOGER' value='DELOGER' /> </td>
								</tr>
							</table>
							<?php
							}
							?>
						</form>
				</td>
			</tr>

		</table>
	</div>
	</body>
	<script type="text/javascript">

		// fonction pour selectionner le type de chambre
		function action6(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit22').value = '\t'+leselect;
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
