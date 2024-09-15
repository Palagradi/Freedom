<?php
	session_start(); 
	include_once 'menuprin1.php';
	include 'connexion.php'; 
	if (isset($_POST['va'])&& $_POST['va']=='VALIDER') 
		{
			$ret="SELECT * FROM fiche1, compte WHERE fiche1.numfiche=compte.numfiche and numch='".$_POST['combo3']."' and etatsortie='NON' ";
			//echo $ret; 
			$ret1=mysql_query($ret);
			$ret2=mysql_fetch_array($ret1);
			if ($ret2)
			{
				if (($ret2['datarriv']==date('Y-m-d')) and ($ret2['typeoccup'])=='double')
				{
					$reta=mysql_query("INSERT INTO compte VALUES ('".$_SESSION['num']."', '".$_POST['combo3']."', '".$_POST['combo4']."', '0', '0', '0','0','0','0','0','0','0','0','0')");
					//header('location:fiche.php');
				}
				else 
				{
					echo "<script language='javascript'>alert('Cette chambre est occupée');</script>";
				}
			} else 
			{
				$_SESSION['np']=$_POST['edit32']; 
				$_SESSION['nuit']=$_POST['combo5'];
				$_SESSION['numch']=$_POST['combo3']; 
				$_SESSION['tch']=$_POST['edit22']; 
				$_SESSION['occup']=$_POST['combo4']; 
				$_SESSION['tarif']=$_POST['edit24']; 
				$_SESSION['mt']=$_POST['edit25']; 
				$_SESSION['taxe']=$_POST['edit28']; 
				$_SESSION['tv']=$_POST['combo6']; 
				$_SESSION['tva']=$_POST['edit29']; 
				$_SESSION['ttc']=$_POST['edit26']; 
				$_SESSION['somme']=$_POST['edit30']; 
				$_SESSION['due']=$_POST['edit31']; 
				//enregistrement du compte 
				$reto=mysql_query("INSERT INTO compte VALUES ('".$_SESSION['num']."','".$_POST['combo3']."','".$_POST['combo4']."','".$_POST['edit24']."','".$_POST['edit23']."','".$_POST['edit25']."','".$_POST['combo5']."','".$_POST['edit28']."','".$_POST['combo6']."','".$_POST['edit29']."','".$_POST['edit26']."','".$_POST['edit30']."','".$_POST['edit31']."','".$_POST['edit32']."')");
				if ($reto)
				{
					if ($_POST['edit30']!=0)
					{
						$en=mysql_query("INSERT INTO encaissement VALUES ('".date('Y-m-d')."','".$_SESSION['num']."','".$_POST['edit30']."','".$_SESSION['login']."')");
						if ($en)
						{
							if ($_POST['edit30']!=0){ header('location:recufiche.php');} else {header('location:fiche.php');}
						} else 
						{
							echo "<script language='javascript'>alert('Echec d'enregistrement');</script>"; 
						}
					}
				} else {echo "<script language='javascript'>alert('Echec d'enregistrement'); </script>"; }
			}
			/*//requete pour compter le nombre d'occuper 
			$ze=mysql_query("SELECT count(numch) FROM fiche1, compte WHERE numch='".$_POST['combo3']."' and fiche1.numfiche=compte.numfiche and datarriv='".date('Y-m-d')."'");
			$zer=mysql_fetch_array($ze);
			if ($zer[0]==0)
			{
				echo $zer[0];
				$ze1=mysql_query("SELECT fiche1.numfiche FROM fiche1, compte WHERE etatsortie='NON' and fiche1.numfiche=compte.numfiche and numch='".$_POST['combo3']."'");
				echo "SELECT numfiche FROM fiche1, compte WHERE etatsortie='NON' and fiche1.numfiche=compte.numfiche and numch='".$_POST['combo3']."'"; 
				$zer1=mysql_fetch_array($ze1);
				if ($zer1)
					{"<script language='javascript'>alert('La chambre est occupée'); </script>"; }
					else
					{
						$_SESSION['np']=$_POST['edit32']; 
						$_SESSION['numch']=$_POST['combo3']; 
						$_SESSION['tch']=$_POST['edit22']; 
						$_SESSION['occup']=$_POST['combo4']; 
						$_SESSION['tarif']=$_POST['edit24']; 
						$_SESSION['mt']=$_POST['edit25']; 
						$_SESSION['taxe']=$_POST['edit28']; 
						$_SESSION['tv']=$_POST['combo6']; 
						$_SESSION['tva']=$_POST['edit29']; 
						$_SESSION['ttc']=$_POST['edit26']; 
						$_SESSION['somme']=$_POST['edit30']; 
						$_SESSION['due']=$_POST['edit31']; 
						//enregistrement du compte 
						$ret=mysql_query("INSERT INTO compte VALUES ('".$_SESSION['num']."','".$_POST['combo3']."','".$_POST['combo4']."','".$_POST['edit24']."','".$_POST['edit23']."','".$_POST['edit25']."','".$_POST['combo5']."','".$_POST['edit28']."','".$_POST['combo6']."','".$_POST['edit29']."','".$_POST['edit26']."','".$_POST['edit30']."','".$_POST['edit31']."','".$_POST['edit32']."')");
						if ($ret)
							{
								if ($_POST['edit30']!=0)
								{
									$en=mysql_query("INSERT INTO encaissement VALUES ('".date('Y-m-d')."','".$_SESSION['num']."','".$_POST['edit30']."','".$_SESSION['login']."')");
									if ($en)
										{
											if ($_POST['edit30']!=0)
											{ 
												header('location:recufiche.php');
											} else 
											{ 
												header('location:fiche.php');
											}
										} else 
										{
										echo "<script language='javascript'>alert('Echec d'enregistrement');</script>"; 
										}
								}
							} else {echo "<script language='javascript'>alert('Echec d'enregistrement'); </script>"; }
					}
			} else 
				{
					if ($zer[0]==1)
					{
					//echo "SELECT typeoccup FROM compte,fiche1 WHERE numch='".$_POST['combo3']."' and fiche1.numfiche=compte.numfiche and  datarriv='".date('Y-m-d')."'"; 
						$ze2=mysql_query("SELECT typeoccup FROM compte,fiche1 WHERE numch='".$_POST['combo3']."' and fiche1.numfiche=compte.numfiche and  datarriv='".date('Y-m-d')."'");
						$zer2=mysql_fetch_array($ze2);
						if ($zer2)
						{
							switch ($zer2)
							{
								//case 'individuelle': { echo "<script language='javascript'>alert('Cette chambre est occupée');</script>"; } break; 
								case 'double': 
									{$ret=mysql_query("INSERT INTO compte VALUES ('".$_SESSION['num']."', '".$_POST['combo3']."', '".$_POST['combo4']."', '0', '0', '0','0','0','0','0','0','0','0','0')");header('location:fiche.php');} break; 
								default: echo'blabla'; break; 
							}
						} 
					} else 
					{
						 echo "<script language='javascript'>alert('Cette chambre est occupée');</script>";
					}
				}*/
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
				document.getElementById("edit25").value=('\t'+document.getElementById("edit24").value)*document.getElementById("edit23").value; 
			}
		}
		function Aff1()
		{
			if (document.getElementById("edit23").value!='') 
			{
				document.getElementById("edit28").value=document.getElementById("edit23").value*document.getElementById('combo5').options[document.getElementById('combo5').selectedIndex].value; 
			}
		}
		function Aff2()
		{
			if (document.getElementById("edit25").value!='') 
			{
				document.getElementById("edit29").value=document.getElementById("edit25").value*document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value; 
				document.getElementById("edit26").value=parseInt(document.getElementById("edit28").value)+parseInt(document.getElementById("edit29").value)+parseInt(document.getElementById("edit25").value); 
			}
		}
		function Aff3()
		{
			if (document.getElementById("edit33").value!='') 
			{
				document.getElementById("edit31").value=parseInt(document.getElementById("edit26").value)-parseInt(document.getElementById("edit33").value);
				document.getElementById("edit32").value=document.getElementById("edit33").value/
							(parseInt(document.getElementById('combo5').options[document.getElementById('combo5').selectedIndex].value)+
							 ((document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value)*('\t'+document.getElementById("edit24").value)+parseInt('\t'+document.getElementById("edit24").value))); 
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
	<body>
		<table align='center'>
		<tr>
				<td>
					<fieldset> 
						<legend align='center'> OCCUPATION </legend> 
						<form action='occup.php' method='post' >
							<table> 
								<tr>
									<td> Chambre N°: </td>
									<td> 
										<select name='combo3' id='combo3'>
											<option value='Default'> -- Choix de chambre--</option>
												<?php
													$res=mysql_query('SELECT numch FROM chambre'); 
													while ($ret=mysql_fetch_array($res)) 
														{
															echo '<option value="'.$ret[0].'">';
															echo($ret[0]);
															echo '</option>' ; 
														}
														
												?>
										</select>
									</td>
									<td> Type de chambre: </td>
									<td> <input type='text' name='edit22' id='edit22'/> </td>
								</tr>
								<tr>
									<td> Type d'occupation: </td>
									<td> 
										<select name='combo4' id='combo4' >
											<option value='Default'> -Choix d'occupation-</option>
											<option value='individuelle'> INDIVIDUELLE</option>
											<option value='double'> DOUBLE</option>
										</select>
									</td>
									<td> Tarif: </td>
									<td> <input type='text' name='edit24' id='edit24' onblur="Aff();" readonly /> </td>
								</tr>
								<tr>
									<td> Nuitée: </td>
									<td> <input type='text' name='edit23' id='edit23' value='<?php echo $_SESSION['Nuite']; ?>'readonly /> </td>
									<td> Montant HT: </td>
									<td> <input type='text' name='edit25' id='edit25' readonly /> </td>
								</tr>
								<tr>
									<td> Taux sur Taxe: </td>
									<td> 
										<select name='combo5' id='combo5' onchange="Aff1(); " >
											<option value='Default'> -Taux-</option>
												<?php
													$res=mysql_query('SELECT * FROM taxenuite'); 
													while ($ret=mysql_fetch_array($res)) 
														{
															echo '<option value="'.$ret[0].'">';
															echo($ret[0]);
															echo '</option>' ; 
														}
														
												?>
										</select>
									</td>
									<td> Taxe Sur Nuitée: </td>
									<td> <input type='text' name='edit28' id='edit28' readonly /> </td>
								</tr>
								<tr>
									<td> Taux TVA: </td>
									<td> 
										<select name='combo6' id='combo6' onchange='Aff2(); '>
											<option value='Default'> -TVA-</option>
												<?php
													$res=mysql_query('SELECT * FROM tva '); 
													while ($ret=mysql_fetch_array($res)) 
														{
															echo '<option value="'.$ret[1].'">';
															echo($ret[1]);
															echo '</option>' ; 
														}
														
												?>
										</select>
									</td>
									<td> TVA: </td>
									<td> <input type='text' name='edit29' id='edit29' readonly /> </td>
								</tr>
								<tr>
									<td> Montant TTC: </td>
									<td> <input type='text' name='edit26' id='edit26'readonly /> </td>
									<td> Avance: </td>
									<td> <input type='text' name='edit27' id='edit27' value='<?php echo $_SESSION['avancef'] ?>' readonly /> </td>
								</tr>
								<tr>
									<td> Somme Remise : </td>
									<td> <input type='text' name='edit30' id='edit30' onblur='Aff4();'/> </td>
									<td> Total payé : </td>
									<td> <input type='text' name='edit30' id='edit33' onblur='Aff3();'/> </td>
								</tr>
								<tr>
								<td> Somme due : </td>
									<td> <input type='text' name='edit31' id='edit31' readonly /> </td>
									<td> Nuite Payée : </td>
									<td> <input type='text' name='edit32' id='edit32' readonly /> </td>
								</tr>
								<tr>
									<td colspan='4' align='center'> <input type='submit' name='va' id='va' value='VALIDER' /> </td>
								</tr>
							</table>
						</form>
					</fieldset>
				</td>
			</tr>
			
		</table>				
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
