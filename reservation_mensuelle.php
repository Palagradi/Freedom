<?php
	session_start(); 
	//session_start(); 
		   if($_SESSION['poste']==cpersonnel)
		include 'menucp.php'; 
	   	   if($_SESSION['poste']==agent)
		include 'menuprin1.php'; 
			   if($_SESSION['poste']==directrice)
		include 'menudirec.php'; 
			   if($_SESSION['poste']==admin)
		include 'admin.php';
		include 'connexion.php';
		include 'Connexion_2.php';
	$moisT = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aôut","Septembre","Octobre","Novembre","Décembre");
	$mois= date("m");
	$ans= date("Y");
	
	$login=$_SESSION['login'];
	

?>
<html>
	<head> 
		<title> SYGHOC </title> 
	</head>
	<body bgcolor='azure'>

		<div align="center" style="padding-top:30px;">
			<form action="reservation_mensuelle1.php" method="POST"> 
				<table width="800" height="280" border="0" cellpadding="0" cellspacing="0" style="border:2px solid black;font-family:Cambria;">
					<tr>
						<td colspan="4">
							<h2 style="text-align:center; font-family:Cambria;color:blue;">RESERVATION MENSUELLE <?php ?></h2>
							<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<span style="font-style:italic;font-size:0.9em;color:black;">Pour afficher la liste des reservations pour un mois donn&eacute; ; s&eacute;lectionnez le mois et l'ann&eacute;e</span>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;" >Mois  :</td>
						<td colspan="2">&nbsp;&nbsp;
						   <select name='mois' id='mois' style="width:150px;"  > 
								<option value=''> Mois</option> 
								<option value='1'> Janvier </option>
								<option value='2'> F&eacute;vrier </option>
								<option value='3'> Mars </option>
								<option value='4'> Avril </option>
								<option value='5'> Mai  </option>
								<option value='6'> Juin </option>
								<option value='7'> Juillet </option>
								<option value='8'> Août</option>
								<option value='9'> Septembre </option>
								<option value='10'> Octobre </option>
								<option value='11'> Novembre</option>
								<option value='12'> Decembre </option>
							</select> 
						</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;"> Ann&eacute;e : </td>
						<td colspan="2">&nbsp;&nbsp;
									<select name='ans'id='ans' style="width:150px;" > 
								<option> Ann&eacute;e </option> 
								<?php
									for ($i=date('Y'); $i<date('Y')+10; $i++)
									{
										echo '<option value="'.$i.'">';
										echo($i);
										echo '</option>'; 
									}
								?> 
							</select> 
						</td>
					</tr>		

					<tr>
						<td colspan="2" align="right" > <input type="submit" value="AFFICHER" id="" class="les_boutons"  name="AFFICHER" style="border:2px solid black;font-weight:bold;"/> </td>
						<td colspan="2">&nbsp;&nbsp;<input type="reset" value="ANNULER" class="les_boutons"  name="Annuler" style="border:2px solid black;font-weight:bold;"/> </td>
					</tr>
				</table>
		</div>
			<?php
			echo "<table align='center' style='border:0px solid black;'> <tr> <td style='font-weight:bold;'>
		    $msg
			 </td></tr></table>";
			?>
				<table align="center" width="1000" border="0" cellspacing="0" style="margin-top:40px;border-collapse: collapse;font-family:Cambria;">
					<caption style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;">  Liste des reservations de chambre de CODIAM<span style="font-style:italic;font-size:0.7em;color:black;"> (pour le mois de <?php echo $moisT[$mois-1]." ".$ans; ?>) </span></caption> 
					<tr style=" background-color:#FF8080;color:white;font-size:1.2em; padding-bottom:5px;">
						<td style="border-right: 2px solid #ffffff" align="center" >R&eacute;f&eacute;rence</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Nom</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Pr&eacute;noms</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Date d'entr&eacute;e</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Date de sortie</td>
						<td style="border-right: 2px solid #ffffff" align="center" >N° Chambre</td>
						<td align="center" >Actions</td>
					</tr>
					<?php
					   $connecter= new Connexion_2;
					   if($connecter->testConnexion())
					  {mysql_query("SET NAMES 'utf8'"); $ans=date(Y);$mois=date(m);
					  if(($mois!='')&&($ans!='')){
					   $query_Recordset1 = "SELECT * FROM reservationch,chambre where reservationch.numch=chambre.numch AND annee like $ans AND mois like $mois ";
					   $Recordset_2 = mysql_query($query_Recordset1);
							$cpteur=1;
							while($data=mysql_fetch_array($Recordset_2))
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
								$connecter = new Connexion_2;
								if($connecter->testConnexion())
								{
								}  
								echo " 	<tr bgcolor='".$bgcouleur."'>"; 
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['numresch']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['nomdemch']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['prenomdemch']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($data['datarrivch'],8,2).'-'.substr($data['datarrivch'],5,2).'-'.substr($data['datarrivch'],0,4)."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($data['datdepch'],8,2).'-'.substr($data['datdepch'],5,2).'-'.substr($data['datdepch'],0,4)."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['nomch']."</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
										echo " 	<a href='Reservation_modification.php?reference=".$data['numresch']."'><img src='logo/b_edit.png' alt='' title='Modifier' width='16' height='16' border='0'></a>";
										echo " 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
										echo " 	<a href=''><img src='logo/b_drop.png' alt='Supprimer' title='Supprimer' width='16' height='16' border='0'></a>";
										echo " 	</td>";
									echo " 	</tr> ";
							}
						}
					}
					?>
				</table><br/>
			<div align="" style='margin-left:400px;'>Pour afficher le planning du mois de <?php echo $moisT[$mois-1]." ".$ans; ?><a href="<?php if($sal!='') echo"planning_Salle.php"; else echo "planning_mois.php";?>?mois= <?php echo $mois?>&ans=<?php echo $ans?> " target='_blank' style="text-decoration:none;font-weight:bold;">, cliquer ici<a/></div>  
			</form>
</body>	
</html>