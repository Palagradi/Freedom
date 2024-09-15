<?php
include_once'menu.php';

		$numfiche=$_GET['numfiche']; $typeoccuprc=NULL;
		$reqsel=mysqli_query($con,"SELECT * FROM mensuel_compte,chambre WHERE chambre.numch=mensuel_compte.numch 	AND numfiche ='".$numfiche."' ");
		while($data=mysqli_fetch_array($reqsel))
			{  $numfiche=$data['numfiche'];
			   $numch=$data['numch'];
			   $nomch=$data['nomch'];
			   $typeoccup=$data['typeoccup'];
			   $tarif=$data['tarif'];
			   $nuite=$data['nuite'];
			   $taxe=$data['taxe'];
			   $ttc=$data['ttc'];
			   $somme=$data['somme'];
			   $np=$data['np'];
			}

	if (isset($_POST['ENREGISTRER'])&& $_POST['ENREGISTRER']=='ENREGISTRER')
		{ 	$reqsel=mysqli_query($con,"SELECT * FROM mensuel_compte,fiche1 WHERE .numfiche=fiche1.numfiche AND fiche1.etatsortie ='NON' AND mensuel_compte.numch='".$_POST['combo3']."'");
			$nbre=mysqli_num_rows($reqsel);
			if($nbre<=0)
			$reqsel=mysqli_query($con,"SELECT * FROM mensuel_compte,view_fiche2 WHERE mensuel_compte.numfiche=view_fiche2.numfiche AND view_fiche2.etatsortie ='NON' AND mensuel_compte.numch='".$_POST['combo3']."'");
				while($data=mysqli_fetch_array($reqsel))
				{ echo $np=$data['np'];
				}
				if($np>0)
					 { echo "<script language='javascript'>alert('Vous ne pouvez plus changer le type d'occupation pour cette chambre car un encaissement a déjà été effectué. Faites le départ de la chambre.');</script>";
						header('location:loccup.php');
					 }
				else
					{	if($_POST['combo4']=='double') $ttc_fixe=9500; else $ttc_fixe=7500;
						if($_POST['combo4']!='double') 	$update=mysql_query("UPDATE fiche1 SET numcli_2 ='' WHERE numfiche ='".$_POST['numfiche']."'");
						$update1=mysqli_query($con,"UPDATE mensuel_compte SET typeoccup='".$_POST['combo4']."',ttc='".$_POST['edit26']."',ttc_fixe='$ttc_fixe' WHERE numfiche ='".$_POST['numfiche']."'");
						$update2=mysqli_query($con,"UPDATE mensuel_mensuel_compte SET typeoccup='".$_POST['combo4']."',ttc='".$_POST['edit26']."',ttc_fixe='$ttc_fixe' WHERE numfiche ='".$_POST['numfiche']."'");
						$_SESSION['num']=$_POST['numfiche'];$_SESSION['npp']="";
						if($_POST['combo4']=='double')
							header('location:fiche2.php');
							else
							header('location:loccup.php');
					}
		}
?>
<html>
	<head>
		<title> SYGHOC </title>
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
	<div align="" style="">
		<table align='center' width="800">
		<tr>
				<td align='center'>
					<fieldset>
						<legend align='center'style='font-size:1.3em;color:#DA4E41;'><b> CHANGEMENT DU TYPE D'OCCUPATION DE LA CHAMBRE </b></legend>
						<form action='changement_type.php' method='post' >
				<table style='font-size:1.2em;'>
								<tr>
									<td align=''><input type='hidden' name='numfiche' id='' value='<?php echo $numfiche; ?>'readonly /></td>
								<tr>
								<tr>
									<td> Chambre N°: </td>
									<td>
										<select name='combo3' id='combo3' style='width:145px;'>
											<option value='<?php if($numch!='') echo $numch;?>'> <?php if($nomch!='') echo $nomch;
											else echo "-- Choix de chambre--"?></option>
												<?php
													$res=mysqli_query($con,'SELECT numch,nomch FROM chambre');
													while ($ret=mysqli_fetch_array($res))
														{
															echo '<option value="'.$ret['numch'].'">';
															echo($ret['nomch']);
															echo '</option>' ;
														}

												?>
										</select>
									</td>
									<td> Type de chambre: </td>
									<td> <input type='text' name='edit22' id='edit22' value='<?php
									{$res=mysqli_query($con,'SELECT typech FROM chambre WHERE numch="'.$numch.'"');
$ret=mysqli_fetch_assoc($res);  $type_ch=$ret['typech'];
}if($type_ch=='CL') $type_ch="Climatisée"; else $type_ch="Ventillée";
echo $type_ch;?>'/> </td>
								</tr>
								<tr>
									<td><br/> Type d'occupation: </td>
									<td>
										<br/><select name='combo4' id='combo4' style='width:145px;'>
<?php
		echo "<option value='"; echo $typeoccup;echo"'> "; echo $typeoccup; echo"</option>"; ?>
											<option value='individuelle'> INDIVIDUELLE</option>
											<option value='double'> DOUBLE</option>
										</select>
									</td>
									<td><br/> Tarif: </td>
									<td><br/> <input type='text' name='edit24' id='edit24' onblur="Aff();" readonly <?php if($tarif!='') echo "value='".$tarif."'";?>/> </td>
								</tr>
								<tr>
									<td><br/> Nuitée: </td>
									<td><br/> <input type='text' name='edit23' id='edit23' value='<?php echo $nuite; ?>'readonly /> </td>
									<td><br/> Montant HT: </td>
									<td><br/> <input type='text' name='edit25' id='edit25'  onblur="Aff5();"  readonly  value='<?php //echo $nuite*$tarif;?>'/>
                                       <input type='hidden' name='edit_25' id='edit_25'   readonly  value="0"/> </td>
								</tr>
								<tr>
									<td><br/>Taux sur Taxe: </td>
									<td>
										<br/><select name='combo5' id='combo5' onchange="Aff1();" style='width:145px;' >
											<option value='<?php if($typeoccuprc=='individuelle') echo 1000; else if($typeoccuprc=='double') echo 2000; else echo '';?>'> <?php if($typeoccuprc=='individuelle') echo 1000; else if($typeoccuprc=='double') echo 2000; else echo '-Taux-';?></option>
												<?php
													$res=mysqli_query($con,'SELECT taxe FROM autre_configuration');
													while ($ret=mysqli_fetch_array($res))
														{
															echo '<option value="'.$ret['taxe'].'">';
															echo($ret['taxe']);
															echo '</option>' ;
														}

												?>
										</select>
									</td>
									<td><br/> Taxe Sur Nuitée: </td>
									<td><br/> <input type='text' name='edit28' id='edit28' readonly  value='<?php //echo $taxe; ?>'/> </td>
								</tr>
								<tr>
									<td> <br/>Taux TVA: </td>
									<td>
										<br/><select name='combo6' id='combo6' onchange='Aff2();' style='width:145px;'>
											<option value=''> <?php echo 'Taux'; ?></option>
												<?php
													$res=mysqli_query($con,'SELECT * FROM tva ');
													while ($ret=mysqli_fetch_array($res))
														{
															echo '<option value="'.$ret[0].'">';
															echo($ret[1]);
															echo '</option>' ;
														}

												?>
										</select>
									</td>
									<td> <br/>TVA: </td>
									<td><br/> <input type='text' name='edit29' id='edit29' readonly value='<?php //echo $tva=0.18*$nuite*$tarif;?>'/> </td>
								</tr>
								<tr>
									<td><br/> Montant TTC: </td>
									<td><br/> <input type='text' name='edit26' id='edit26'readonly value='<?php //echo $ttc;?>'/> </td>

									<td> <br/>Avance: </td>
									<td><br/> <input type='text' name='edit27' id='edit27' value='<?php if(isset($_SESSION['advance'])) echo $_SESSION['advance']; //else  echo $nuite_payee*$ttc1;?>' readonly /> </td>
								</tr>

								<tr>
									<td colspan='4' align='center'> <br/><input class='mybutton' type='submit' name='ENREGISTRER' id='ENREGISTRER' value='ENREGISTRER'  style="border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;"/> </td>
								</tr>
							</table>
						</form>
					</fieldset>
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
