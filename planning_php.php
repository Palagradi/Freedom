<?php
    $cham=!empty($_GET['cham'])?$_GET['cham']:NULL;
	$sal=!empty($_GET['sal'])?$_GET['sal']:NULL;
		
		include 'menu.php'; 
/* 		if (isset($_POST['AFFICHER'])&& $_POST['AFFICHER']=='AFFICHER') 
		   {	$moisT = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aôut","Septembre","Octobre","Novembre","Décembre");
				$mois= $_POST['mois'];
				$ans= $_POST['ans'];	
				$login=$_SESSION['login'];
		   }
		else{
				$moisT = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aôut","Septembre","Octobre","Novembre","Décembre");
				$mois= date("m");
				$ans= date("Y");
				} */
	
	$trie=!empty($_GET['trie'])?$_GET['trie']:NULL;	
	$moisT = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aôut","Septembre","Octobre","Novembre","Décembre");
	$mois=!empty($_POST['mois'])?$_POST['mois']:date("m");
	$ans=!empty($_POST['ans'])?$_POST['ans']:date("Y");

?>
<html>
	<head> 
		<link rel="Stylesheet" type="text/css" media="screen, print" href='style.css' /> 
	</head>
	<body bgcolor='azure' style="">
	<div align="" style="">
			<form action="planning_php.php?menuParent=Modification<?php if($sal!='') echo "&sal=2"; if($cham!='') echo "&cham=2";?>" method="POST" id="chgdept"> 
				<table align="center" width="800" height="280" border="0" cellpadding="0" cellspacing="0" style="border:2px solid white;font-family:Cambria;background-color:#D0DCE0;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;">
					<tr>
						<td colspan="4">
						<h3 style='text-align:center; font-family:Cambria;color:maroon;font-weight:bold;'>RESERVATION MENSUELLE</h3>
							<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<span style="font-style:italic;font-size:0.9em;color:black;">Pour afficher la liste des réservations pour un mois donn&eacute; ; s&eacute;lectionnez le mois et l'ann&eacute;e</span>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:150px;font-size:1.2em;" >Mois  :</td>
						<td colspan="2">&nbsp;&nbsp;
						   <select name='mois' id='mois' style="width:200px;font-size:1em;"  > 
								<option value=''> </option> 
								<option value='1'> Janvier </option>
								<option value=''> </option> 
								<option value='2'> F&eacute;vrier </option>
								<option value=''> </option> 
								<option value='3'> Mars </option>
								<option value=''> </option> 
								<option value='4'> Avril </option>
								<option value=''> </option> 
								<option value='5'> Mai  </option>
								<option value=''> </option> 
								<option value='6'> Juin </option>
								<option value=''> </option> 
								<option value='7'> Juillet </option>
								<option value=''> </option> 
								<option value='8'> Aôut</option>
								<option value=''> </option> 
								<option value='9'> Septembre </option>
								<option value=''> </option> 
								<option value='10'> Octobre </option>
								<option value=''> </option> 
								<option value='11'> Novembre</option>
								<option value=''> </option> 
								<option value='12'> Décembre </option>
							</select> 
						</td>
					</tr>
					<tr>
						<td >&nbsp;&nbsp;

						</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:150px;font-size:1.2em;"> Ann&eacute;e : </td>
						<td colspan="2">&nbsp;&nbsp;
								<select name='ans'id='ans' style="width:200px;font-size:1em;" onchange="document.forms['chgdept'].submit();"> 
								<option value=''> </option> 
								<?php
									for ($i=2022; $i<date('Y')+10; $i++)
									{
										echo '<option value="'.$i.'">';
										echo($i);
										echo '</option><option value=""> </option> '; 
										
									}
								?> 
							</select> 
						</td>
					</tr>	
					
					<input type='hidden' name='chambre' />
					<tr>
						<td colspan="2" align="right" > <!--<input type="submit" value="AFFICHER" id="" class='bouton2'  name="AFFICHER" style=""/> !--></td>
						<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
					</tr>
				</table>
		</div>

				<table align="center" width="800" border="0" cellspacing="0" style="margin-top:40px;border-collapse: collapse;font-family:Cambria;">
					<tr><td colspan='7'>
					<h3 style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#444739;">   Liste des réservations de  <?php if(($cham==2)||($cham==1)) echo"chambre"; if(($sal==2)||($sal==1)) echo"salle";?> de  <?php //echo $nomHotel;?> <span style="font-style:italic;font-size:0.7em;color:teal;"> (pour le mois de <?php echo $moisT[$mois-1]." ".$ans; ?>) </span> </h3>
					</td></tr>
						<tr style=" background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px; border:2px solid white;">
						<td style="border-right: 2px solid #ffffff" align="center" ><a href='planning_php.php?menuParent=Modification&trie=numresch<?php if($cham!='') echo "&cham=".$cham;else echo "&sal=".$sal;?>' style='text-decoration:none;color:white;' title='Trie par Réference'>R&eacute;f&eacute;rence</a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a href='planning_php.php?menuParent=Modification&trie=nomdemch<?php if($cham!='') echo "&cham=".$cham;else echo "&sal=".$sal;?>'style='text-decoration:none;color:white;' title='Trie par Nom'>Nom</a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a href='planning_php.php?menuParent=Modification&trie=prenomdemch<?php if($cham!='') echo "&cham=".$cham;else echo "&sal=".$sal;?>'style='text-decoration:none;color:white;' title='Trie par Prénoms'>Pr&eacute;noms</a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a href='planning_php.php?menuParent=Modification&trie=datarrivch<?php if($cham!='') echo "&cham=".$cham;else echo "&sal=".$sal;?>'style='text-decoration:none;color:white;' title="Trie par Date d'entrée">Date d'entr&eacute;e</a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a href='planning_php.php?menuParent=Modification&trie=datdepch<?php if($cham!='') echo "&cham=".$cham;else echo "&sal=".$sal;?>'style='text-decoration:none;color:white;'title='Trie par Date de sortie'>Date de sortie</a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><?php if(($cham==2)||($cham==1)) {echo "						
						<a href='planning_php.php?menuParent=Modification&trie=chambre.numch"; if($cham!='') echo "&cham=".$cham; echo "'style='text-decoration:none;color:white;'title='Trie par Chambre'>Chambre</a>";						
						}
						 if(($sal==2)||($sal==1)) {echo "						
						<a href='planning_php.php?menuParent=Modification&trie=salle.numsalle"; if($sal!='') echo "&sal=".$sal; echo "'style='text-decoration:none;color:white;'title='Trie par Salle'>Salle</a>";						
						}?>
						 </td> 
						<?php if($_SESSION['poste']=='agent') echo "<td align='center'>Actions</td>";?>
					</tr>
					<?php
					if (isset($_POST['mois'])&& isset($_POST['ans'])&& ($_POST['mois']!='')&& ($_POST['ans']!='')) 
					   {	$moisT = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aôut","Septembre","Octobre","Novembre","Décembre");
							$mois= $_POST['mois'];
							$ans= $_POST['ans'];	
							$login=$_SESSION['login'];
							
							$sal=!empty($_GET['sal'])?$_GET['sal']:NULL;
							$cham=!empty($_GET['cham'])?$_GET['cham']:NULL;
					    mysqli_query($con,"SET NAMES 'utf8'");if(!empty($mois)&& !empty($ans)){
					  if(isset($sal))
					    $query_Recordset1 = "SELECT * FROM salle,reservationsal where reservationsal.numsalle=salle.numsalle AND annee like $ans AND mois like $mois ";
					  else
					    $query_Recordset1 = "SELECT * FROM chambre,reservationch where reservationch.numch=chambre.numch AND annee like $ans AND mois like $mois ";
					   $Recordset_2 = mysqli_query($con,$query_Recordset1);
							$cpteur=1;
							while($data=mysqli_fetch_array($Recordset_2))
							{
								if($cpteur == 1)
								{
									$cpteur = 0;
									$bgcouleur = "#acbfc5";
								}
								else
								{
									$cpteur = 1;
									$bgcouleur = "#dfeef3";
								}  //$data=substr($data['datdepch'],8,2).'-'.substr($data['datdepch'],5,2).'-'.substr($data['datdepch'],0,4)
								echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>"; 
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['numresch']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>&nbsp;&nbsp;".$data['nomdemch']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>&nbsp;&nbsp;".$data['prenomdemch']."</td>";
										echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($data['datarrivch'],8,2).'-'.substr($data['datarrivch'],5,2).'-'.substr($data['datarrivch'],0,4)."</td>";
										echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($data['datdepch'],8,2).'-'.substr($data['datdepch'],5,2).'-'.substr($data['datdepch'],0,4)."</td>";
									if($sal!='')   
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['codesalle']."</td>";
									else
									echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['nomch']."</td>";
									if($_SESSION['poste']=='agent')
											{echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
											//echo " 	<a href='Reservation_modification.php?menuParent=Modification&cham=2&reference=".$data['numresch']." &numreserv=".$data['numreserv']."'>";
											echo "<img src='logo/b_edit.png' alt='' title='Modifier' width='16' height='16' border='0'>";
											//echo "</a>";
											
											echo " 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
											if($cham==2) {
											//echo " 	<a href='Reservation_suppression.php?menuParent=Modification&cham=2&numreserv=".$data['numreserv']."'>";
											echo "<img src='logo/b_drop.png' alt='Supprimer' title='Supprimer' width='16' height='16' border='0'>";
											//echo "</a>";
											}
											else {
											//echo " 	<a href='Reservation_suppression.php?menuParent=Modification&sal=2&numreserv=".$data['numreserv']."'>";
											echo "<img src='logo/b_drop.png' alt='Supprimer' title='Supprimer' width='16' height='16' border='0'>";
											//echo "</a>";
											}
										echo " 	</td>";}
									echo " 	</tr> ";
							}
				
						}
					}
					else{
					  mysqli_query($con,"SET NAMES 'utf8'");$ans=date('Y');$mois=date('m');
					   if(($cham==2)||($cham==1))
					   {  if($trie=='')
							$query_Recordset1 = "SELECT * FROM reservationch,chambre where reservationch.numch=chambre.numch AND annee like $ans AND mois like $mois ORDER BY chambre.numch ASC ";
						  else
						   $query_Recordset1 = "SELECT * FROM reservationch,chambre where reservationch.numch=chambre.numch AND annee like $ans AND mois like $mois ORDER BY $trie ASC";
					   }
					   if(($sal==2)||($sal==1))
					   {if(empty($trie))
							$query_Recordset1 = "SELECT * FROM reservationsal,salle where reservationsal.numsalle=salle.numsalle AND annee like $ans AND mois like $mois ";
					   else
							$query_Recordset1 = "SELECT * FROM reservationsal,salle where reservationsal.numsalle=salle.numsalle AND annee like $ans AND mois like $mois ORDER BY $trie ASC";
					   }$Recordset_2 = mysqli_query($con,$query_Recordset1);
							$cpteur=1;
							if (!$Recordset_2) {
								printf("Error: %s\n", mysqli_error($con));
								exit();
							}
							
							while($data=mysqli_fetch_array($Recordset_2))
							{
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
						  
								echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>"; 
										echo " 	<td  align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['numresch']."</td>";
										echo " 	<td  align=''style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['nomdemch']."</td>";
										echo " 	<td  align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".ucfirst($data['prenomdemch'])."</td>";
										echo " 	<td  align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($data['datarrivch'],8,2).'-'.substr($data['datarrivch'],5,2).'-'.substr($data['datarrivch'],0,4)."</td>";
										echo " 	<td  align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($data['datdepch'],8,2).'-'.substr($data['datdepch'],5,2).'-'.substr($data['datdepch'],0,4)."</td>";
										if($cham!='') echo "<td  align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['nomch']."</td>";
										else
										echo "<td  align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['codesalle']."</td>";
										if($_SESSION['poste']=='agent')
										{if($cham==2)
											{echo " <td align='center' style='border-top: 2px solid #ffffff'>";
											//echo " 	<a href='Reservation_modification.php?menuParent=Modification&cham=2&reference=".$data['numresch']." &numreserv=".$data['numreserv']."'>";
											echo "<img src='logo/b_edit.png' alt='' title='Modifier' width='16' height='16' border='0'>";
											//echo "</a>";
											echo " 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
											//echo " 	<a href='Reservation_suppression.php?menuParent=Modification&cham=2&reference=".$data['numresch']." &numreserv=".$data['numreserv']."'>";
											echo "<img src='logo/b_drop.png' alt='Supprimer' title='Supprimer' width='16' height='16' border='0'>";
											//echo "</a>";
											echo " 	</td>";
											}
										if($cham!=2)
											{echo " <td align='center' style='border-top: 2px solid #ffffff'>";
											//echo " 	<a href='Reservation_modification.php?menuParent=Modification&sal=2&reference=".$data['numresch']." &numreserv=".$data['numreserv']."'>";
											echo "<img src='logo/b_edit.png' alt='' title='Modifier' width='16' height='16' border='0'>";
											//echo "</a>";
											echo " 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
											//echo " 	<a href='Reservation_suppression.php?menuParent=Modification&sal=2&reference=".$data['numresch']." &numreserv=".$data['numreserv']."''>";
											echo "<img src='logo/b_drop.png' alt='Supprimer' title='Supprimer' width='16' height='16' border='0'>";
											//echo "</a>";
											echo " 	</td>";
											}
										
										} 
								}
							echo " 	</tr> ";
							
						}
					?>
					<tr><td colspan='7' align='right' ><br/>
					Pour afficher le planning du mois de <?php echo $moisT[$mois-1]." ".$ans; ?><a href="<?php //if($sal!='') { } //echo"planning.php"; else { } //echo "planning.php";?>
					<!-- ?mois=  > !-->
					<?php //echo $mois?>
					<!-- &ans= !-->
					<?php //echo $ans?> "  style="text-decoration:none;font-weight:bold;">, Cliquez ici !<a/>
					</td></tr>
				</table>
			
			
			
	<?php		
		if(!empty($cham)) echo "<input type='hidden' name='edit' id='edit' value='".$cham."' readonly/>";
		if(!empty($sal)) echo "<input type='hidden' name='edit1' id='edit1' value='".$sal."' readonly/>";?>
	</form>
</body>	
</html>