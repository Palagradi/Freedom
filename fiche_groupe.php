<?php
include_once'menu.php';
	//$_SESSION['re']='';
	$etat_1=!empty($_GET['etat_1'])?$_GET['etat_1']:NULL;
	$numreserv=!empty($_GET['numreserv'])?$_GET['numreserv']:NULL;
	unset($_SESSION['exhonerer']);
	$res=mysqli_query($con,"DELETE FROM client_tempon");
	if (isset($_POST['VALIDER'])&& $_POST['VALIDER']=='VALIDER')
	      {$_SESSION['nombre1']=$_POST['nombre'];  $_SESSION['nombre_1']=$_POST['nombre'];   $_SESSION['nombre2']=$_POST['nombre1'];  $_SESSION['combo1']=$_POST['combo1'];
		  mysqli_query($con,"SET NAMES 'utf8'");
		  $res=mysqli_query($con,'SELECT DISTINCT codegrpe FROM groupe WHERE code_reel= "'.$_POST['combo1'].'"');
		  $ret=mysqli_fetch_assoc($res);
		  $codegrpe=$ret['codegrpe'];
		  $_SESSION['groupe']=trim($codegrpe);   $_SESSION['num2']=$_POST['edit1'];   $_SESSION['nombre_01']=1;  if($_POST['numreserv']!='')  $_SESSION['numreserv']=$_POST['numreserv'];
			
			$Query1=mysqli_query($con,"SELECT Periode FROM fiche1 WHERE codegrpe='".$_SESSION['groupe']."' AND etatsortie='NON'");
			$data1=mysqli_fetch_object($Query1); 
			if(isset($data1->Periode))
			$_SESSION['periode']=$data1->Periode;		 //Là on incrémente pas. Les clients sont entrées ensemble.
			else {
			$Query1=mysqli_query($con,"SELECT MAX(Periode) AS Periode,etatsortie FROM fiche1 WHERE codegrpe='".$_SESSION['groupe']."' AND codegrpe <>''");
			$data1=mysqli_fetch_object($Query1); $data1->Periode; 
			$_SESSION['periode']=isset($data1->Periode)?(1+$data1->Periode):1;
			}
							
	       header('location:fiche_groupe2.php?menuParent=Hébergement');
		 }
	//enregistrement de la fiche

	$res=mysqli_query($con,"DELETE FROM client_tempon");

?>

<html>
	<head>
		<title>  </title>
		<script type="text/javascript" src="date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width">
		<link rel="Stylesheet" href='css/table.css' />
	</head>
			<script type="text/javascript">
	  function Aff1()
		{
			if (document.getElementById("combo1").value!='')
			{
				document.getElementById("edit1").value=document.getElementById("combo1").value;
			}
		}
			</script>
	<body bgcolor='azure' style="">
	<div align="" style="" >
		<table id="tab" align='center'>
			<tr>
				<td>
						<fieldset  style='margin-left:auto; margin-right:auto;border:0px solid white;background-color:#D0DCE0;font-family:Cambria;width:800px;height:265px;'>
						<legend align='center' style='font-size:1.3em;color:#3EB27B;'>	<h3 style="text-align:center; font-family:Cambria;color:maroon;font-weight:bold;"></h3></legend>
						<form action='fiche_groupe.php' method='post' id='form1' >
						<h3 style='text-align:center; font-family:Cambria;color:maroon;font-weight:bold;'>INFORMATIONS SUR LE GROUPE</h3><br/>
							<table style="">
								<tr>
								<?php
								echo " <input type='hidden' name='numreserv' value='".$numreserv."' />";
								//echo "SELECT code_reel ,codegrpe FROM groupe,reservationch WHERE reservationch.codegrpe=groupe.codegrpe AND reservationch='".$numreserv."'";
								?>
									<td style='padding-left:70px;'> Nom du Groupe :</td> <td>
									<select name='combo1' id='combo1' onchange="Aff1();" style='font-family:sans-serif;font-size:80%;width:170px;' required>
									<?php
									if($numreserv!='')
									{	mysqli_query($con,"SET NAMES 'utf8' ");
											$res=mysqli_query($con,'SELECT groupe.code_reel ,groupe.codegrpe FROM groupe,reservationch WHERE reservationch.codegrpe=groupe.codegrpe AND reservationch.numresch="'.$numreserv.'" LIMIT 1');
											while ($ret=mysqli_fetch_array($res))
												{$code_reel=$ret['code_reel'];
													echo '<option value="'.$code_reel.'">';
													echo($ret['codegrpe']);
													echo '</option>';
													echo '<option value=""></option>';
												}
											$res=mysqli_query($con,'SELECT code_reel ,codegrpe FROM groupe order by codegrpe ASC');
												while ($ret=mysqli_fetch_array($res))
													{
														echo '<option value="'.$ret[0].'">';
														echo($ret[1]);
														echo '</option>';
														echo '<option value=""></option>';
													}
									}
									else
										{		echo"<option value='' style='font-style:italic;'><span></span></option> ";
												mysqli_query($con,"SET NAMES 'utf8' ");
												$res=mysqli_query($con,'SELECT code_reel ,codegrpe FROM groupe order by codegrpe ASC');
												while ($ret=mysqli_fetch_array($res))
													{
														echo '<option value="'.$ret[0].'">';
														echo($ret[1]);
														echo '</option>';
														echo '<option value=""></option>';
													}
										}
										?>

									</select> </td>
									<td width=''>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									Numéro du groupe : </td>
									<td width=''>
									<input type='text' name='edit1' id='edit1' <?php if($numreserv!='') echo "value='".$code_reel."'";?> readonly />
									</td>


								</tr>
								<tr>
										<td style='padding-left:70px;'> <br/>Nombre d'occupants : </td> <td>
											  <br/> 
											  
											<input type='number' name='nombre' min='1' id='nombre'  value='1' style='font-family:sans-serif;font-size:80%;width:170px;' required />  
											
												</td>
										<td>
										 <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre de chambres : </td> <td>
											 <br/>
											 <input type='number' name='nombre1' min='1' id='nombre1'  value='1' style='font-family:sans-serif;font-size:80%;width:170px;' required /> 

										</td>
								</tr>
									<tr >
            						<td>
									</td>
									</tr>
							</table>
							<table  align='center'>
									<tr><td><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<br/><input type="submit" class='bouton2' name="VALIDER" value="VALIDER" style=""/></td></tr>
							</table>
						</form>
					</fieldset>
				</td>
			</tr>
		</table>
		</div>
	</body>
		<script type="text/javascript">
		function VerifForm()
		{
			if ((document.form1.edit1.value=='')|| (document.form1.edit2.value=='')||(document.form1.edit3.value=='')||(document.form1.edit4.value=='')||(document.form5.edit1.value=='')||(document.form1.edit6.value=='')||(document.form1.edit7.value=='')||(document.form1.edit8.value=='')||(document.form1.combo1.value=='Default')||(document.form1.combo2.value=='Default')||(document.form1.edit9.value=='')||(document.form1.edit10.value=='')||(document.form1.edit11.value=='')||(document.form1.edit12.value=='')||(document.form1.edit13.value=='')||(document.form1.se1.value=='Default')||(document.form1.se2.value=='Default')||(document.form1.se3.value=='Default')||(document.form1.se4.value=='Default')||(document.form1.se5.value=='Default')||(document.form1.se6.value=='Default')||(document.form1.edit21.value=='')||(document.form1.combo3.value=='Default')||(document.form1.edit22.value=='')||(document.form1.combo4.value=='Default')||(document.form1.edit23.value=='')||(document.form1.edit24.value=='')||(document.form1.edit25.value=='')||(document.form1.edit26.value=='')||(document.form1.edit27.value=='')||(document.form1.edit28.value==''))
			{
				alert('Un champ est vide');
			}
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

			function CalculMt()
			{
				var montant=(document.getElementById("edit23").value* document.getElementById("edit24").value);
				document.getElementById("edit25").value=montant;
			}

			function CalculSD()
			{
				var due=(document.getElementById("edit25").value- document.getElementById("edit26").value);
				document.getElementById("edit27").value=due;

				var nt=(document.getElementById("edit26").value/ document.getElementById("edit24").value);
				document.getElementById("edit28").value=nt;
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
