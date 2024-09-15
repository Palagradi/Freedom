<?php
include_once 'menu.php';
	unset($_SESSION['nuiteA']);	unset($_SESSION['mt']); unset($_SESSION['av']);	unset($_SESSION['mtht']); 	unset($_SESSION['mtttc']);
	unset($_SESSION['avc']);unset($_SESSION['avc_salle']); 	unset($_SESSION['tn']); unset($_SESSION['tva']); 	unset($_SESSION['numresch']);
	unset($_SESSION['exhonerer1']);unset($_SESSION['exhonerer2']);unset($_SESSION['exhonerer_aib']);unset( $_SESSION['remise']);  unset( $_SESSION['nbch1']);

unset($_SESSION['salle']);

// enregistrement dans reservationch
	if (isset($_POST['ok'])&& $_POST['ok']=='VALIDER')
		{  	if(!empty($_POST['edit3'])&&!empty($_POST['edit4'])&&!empty($_POST['edit5'])&&!empty($_POST['ladate'])&&!empty($_POST['ladate2'])&&(!empty($_POST['edit6'])||!empty($_POST['edit12'])))
			{$jour=date('d-m-Y');
			$now = date('Y-m-d');
			$debut=substr($_POST['ladate'],0,4).'-'.substr($_POST['ladate'],5,2).'-'.substr($_POST['ladate'],8,2);
			$fin=substr($_POST['ladate2'],0,4).'-'.substr($_POST['ladate2'],5,2).'-'.substr($_POST['ladate2'],8,2);
			//$expire1 = '2012-01-01';$expire2 = '2012-01-01';
			$expire1 = $debut;
			$expire2 = $fin;
			// format the 2 dates using DateTime
			$now = new DateTime( $now );
			$now = $now->format('Ymd');
			$expire1 = new DateTime( $expire1 );
			$expire1 = $expire1->format('Ymd');
			$expire2 = new DateTime( $expire2 );
			$expire2 = $expire2->format('Ymd');
			//comparaison de 2 dates
			if(($now <= $expire1)||($now <= $expire2))
			{ 	$exec=mysqli_query($con,"SELECT DATEDIFF('".$fin."','".$debut."') AS DiffDate");
			$row_Recordset1 = mysqli_fetch_assoc($exec);
			$row_Recordset=$row_Recordset1['DiffDate'];
			$_SESSION['Nuite']= $row_Recordset;

			$nuite=(strtotime($fin)-strtotime($debut))/86400;
			$agent=$_SESSION['login'];
			$_SESSION['nuite']=nbJours($debut,$fin);
			$_SESSION['nuiteA']=1+nbJours($debut,$fin);
			//echo $_SESSION['nuite'];
			$_SESSION['debut']=$debut;	$_SESSION['dat1']=$fin;	$_SESSION['fin']=$fin;
			$_SESSION['numresch']=!empty($_POST['edit1'])?$_POST['edit1']:NULL;
			$_SESSION['date_du_jour']=!empty($_POST['edit2'])?$_POST['edit2']:NULL;
			$_SESSION['contact']=!empty($_POST['edit5'])?$_POST['edit5']:NULL;
			$_SESSION['groupe']=$_POST['combo1'];
			//$_SESSION['nom']=!empty($_POST['edit3'])?$_POST['edit3']:NULL;
			//$_SESSION['prenom']=!empty($_POST['edit4'])?$_POST['edit4']:NULL;
			$_SESSION['nomT']=$_POST['edit3'];$_SESSION['prenomT']=$_POST['edit4'];
			$_SESSION['client'] = $_SESSION['nomT']." ".$_SESSION['prenomT'];
			$_SESSION['nbch']=!empty($_POST['edit6'])?$_POST['edit6']:0;
			$_SESSION['nbsal']=!empty($_POST['edit12'])?$_POST['edit12']:0;
			$_SESSION['nbch1']=!empty($_POST['edit6'])?$_POST['edit6']:0;
			$_SESSION['nbsal1']=!empty($_POST['edit12'])?$_POST['edit12']:0;
			$_SESSION['ans']=substr($_POST['ladate'],0,4);$_SESSION['mois']=substr($_POST['ladate'],5,2);
			$_SESSION['mois2']=substr($_POST['ladate2'],5,2);$_SESSION['jr_debut']=substr($_POST['ladate'],8,2);
			$_SESSION['jr_fin']=substr($_POST['ladate2'],8,2);

            $difference_mois= substr($_POST['ladate2'],5,2) - substr($_POST['ladate'],5,2);
			$difference_ans = substr($_POST['ladate2'],0,4) - substr($_POST['ladate'],0,4);
			$difference_jour = substr($_POST['ladate2'],8,2)- substr($_POST['ladate'],8,2);

			$nbre_jrs=nbJours("$debut", "$fin"); $_SESSION['difference_mois']=$difference_mois;
			if(($_POST['edit6']!='')||($_POST['edit12']!=''))
			  { if($_SESSION['nuite']<0){
					echo "<script language='javascript'>";
					echo 'alertify.error("La date de départ est antérieure à la date d\'arrivée. Réverifiez vos entrées");';
					echo "</script>";
					}
					else if(($_SESSION['nuite']<=15)&&($_SESSION['nuite']>=0))
	           {$_SESSION['difference_mois']=$difference_mois;
				//$update=mysqli_query($con,"UPDATE configuration_facture SET num_reserv=num_reserv+1  WHERE num_reserv!=''");
					     if($_POST['edit6']!='')
							{ header('location:reserverch.php?menuParent=Gestion des Réservations');
							}
				     if(!empty($_POST['edit12'])AND empty($_POST['edit6']))
					    header('location:reserversal.php?menuParent=Gestion des Réservations');
						}
				           // if (($difference_mois==1) AND($difference_ans==0) AND($nbre_jrs<=16))
				             // {$_SESSION['difference_mois']=$difference_mois;
					           // header('location:reserverch.php');}
			        else {
								//$msg1="Aucune r&eacute;servation ne doit pas exc&eacute;der <span style ='font-style:italic;color:red;'> 15 jours</span>. Veuillez contacter l'administrateur.";
								echo "<script language='javascript'>";
								echo 'alertify.error("Aucune réservation ne doit excèder <span style ="font-style:italic;color:red;"> 15 jours</span>. Veuillez contacter l\'administrateur.");';
								echo "</script>";
							}
			  }else	{ $msg1="<span style ='font-style:italic;color:red;'>Vous devez renseigner le nom du demandeur, la date de r&eacute;servation et mentionner au mois le nombre de chambre ou de salle</span>";}
		  //echo "UPDATE nombre_reservation SET nbre_chambre='".$_SESSION['nbch1']."',nbre_salle='".$_SESSION['nbsal1']."'WHERE nbre_chambre='0' OR nbre_salle='0'";
		  $de=mysqli_query($con,"UPDATE nombre_reservation SET nbre_chambre='".$_SESSION['nbch1']."' WHERE nbre_chambre='0' OR nbre_salle='0'");
	}else	{echo "<script language='javascript'>";
			echo " alert('Aucune réservation ne doit être antérieure à la date du jour');";
			echo "</script>";}
	}else
		{	echo "<script language='javascript'>";
			echo " alert('VOUS DEVEZ RENSEIGNER LES CHAMPS OBLIGATOIRES');";
			echo "</script>";
		}
}
?>
<html>
	<head>
		<link rel="Stylesheet" href='css/table.css' />
		<script type="text/javascript" src="js/date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
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
			#info:hover{

			}


		</style>

	</head>
	<body bgcolor='azure' style=""><br/>
	<div class="container" align="" style="">
		<table align='center' width='' id="tab"> <tr> <td>
			<form action='reservationch2.php?menuParent=Gestion des Réservations' method='post' name='form1' onSubmit='Verif(); '>
				<table width='' height='400' style='margin-left:50px;margin-right:50px;'>
					<tr>
						<td colspan="4">
							<h3 style='text-align:center; font-family:Cambria;color:maroon;font-weight:bold;'>RESERVATION DE CHAMBRES </h3>
						</td>
					</tr>
					<tr>
						<td colspan='4'><hr style='margin-bottom:-35px;margin-top:-5px;'/>&nbsp;</td>
					</tr>
					<tr><input type='hidden' name='edit2' value="<?php echo $Date_actuel2; ?>" readonly />
						<td colspan="" style=''>Réservation N° : </td>
						<td><input type='text' name='edit1' id='edit1' readonly style='' value="<?php	echo $numReserv;?>"/>
						</td>
						<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nom du groupe :</td>
						<td>
						<select name='combo1' style='width:210px;'  />
								<option value=''>  </option>
									<?php
									    mysqli_query($con,"SET NAMES 'utf8'");
										$ret=mysqli_query($con,'SELECT trim(codegrpe) AS codegrpe FROM groupe ORDER BY codegrpe ASC');
										while ($ret1=mysqli_fetch_array($ret))
											{
												echo '<option value="'.$ret1[0].'">';
												echo($ret1[0]);
												echo '</option>';
												echo '<option value=""></option>';
											}
									?>
							</select></td>
					</tr>
					<tr>
						<td> Nom : <span style='color:red;font-style:italic;'>*</span></td>
						<td> <input  required='required' type='text' name='edit3' onkeyup='this.value=this.value.toUpperCase()'/> </td>
						<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pr&eacute;noms :<span style='color:red;font-style:italic;'>*</span> </td>
						<td> <input type='text' name='edit4' onkeyup='this.value=this.value.toUpperCase()'/> </td>
					</tr>
					<tr>
						<td>Contact :<span style='color:red;font-style:italic;'>*</span> </td>
						<td> <input  required='required' type='text' name='edit5'onkeypress="testChiffres(event);"/> </td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre de chambres : </td>
						<?php
							$res=mysqli_query($con,'SELECT count(numch) AS nbre FROM chambre where EtatChambre="active"');
							$ret=mysqli_fetch_assoc($res);$nbre=$ret['nbre'];
						?>
						<td><input type="number"  min="1" required max="<?php echo $nbre; ?>" id="" name="edit6" style="" onkeypress="testChiffres(event);"/>
						</td>
					</tr>

					<tr>
						<td>Date d'arrivée :<span style='color:red;font-style:italic;'>*</span> </td>
							  <td style=" border: 0px solid black;"><input  required='required' type="date" name="ladate" id="ladate" size="20" />
								<!--   <a class='info'  href="javascript:show_calendar('form1.ladate');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
									 <img src="logo/cal.gif" style="border:0px solid red;" alt="calendrier" title=""><span style='font-size:0.8em;color:maroon;'>Calendrier</span></a> !-->
							  </td>
						<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date de Départ :<span style='color:red;font-style:italic;'>*</span> </td>
							  <td style=" border: 0px solid black;"> <input  required='required' type="date" name="ladate2" id="ladate2" size="20" />
								  <!-- <a class='info'  href="javascript:show_calendar('form1.ladate2');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
									 <img src="logo/cal.gif" style="border:0px solid red;" alt="calendrier" title=""><span style='font-size:0.8em;color:maroon;'>Calendrier</span></a> !-->
							  </td>
					</tr>
					<tr> <td><input type='hidden' name='nui' id='nui'/> </td><td> <input type='hidden' name='edit18' value="<?php echo $Jour_actuelp; ?>" readonly /> </td></tr>
					<tr> <br/>
						<td colspan='4' align='center'>  <br/> <input type='submit' name='ok' value='VALIDER' class='bouton2' style=""/> </td>
					</tr>
				</table>
			</form>
	</td> </tr> </table> <?php $msg1=!empty($msg1)?$msg1:NULL;
		echo "<h4 align='center'>";echo $msg1."</h4>" ; ?>
	</div>
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
