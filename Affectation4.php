<?php
	  session_start(); 
	  if($_SESSION['poste']==cpersonnel)
		include 'menucp.php'; 
	   	   if($_SESSION['poste']==agent)
		include 'menuprin1.php'; 
			   if($_SESSION['poste']==directrice)
		include 'menudirec.php'; 
			   if($_SESSION['poste']==admin)
		include 'admin.php';
						if($_SESSION['poste']==secretaire)
		include 'menusecretaire.php';
	include 'connexion.php'; 
	include 'connexion_2.php';
	 mysql_query("SET NAMES 'utf8'");			
	
		 if (isset($_POST['Valider'])&& $_POST['Valider']=='Valider') 
	     {     

		 }
?>
<html>
	<head> 
		<title> SYGHOC </title> 
	</head>
	<body bgcolor='azure'>

		<div align="center" style="padding-top:40px;">
		    	 <form action="affectation4.php" method="POST"> 
				<table width="800" height="120" border="0" cellpadding="0" cellspacing="0" style="border:2px solid black;font-family:Cambria;margin-bottom:1px;">
					<tr>
						<td colspan="4">
							<h2 style="text-align:center; font-family:Cambria;color:blue;">Consultation des r&eacute;partitions de produits par service</h2>
						</td>
					</tr>
					<tr>
						<td>
						</td>
					</tr> <br/>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&eacute;lection du service&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
							<select name='filtre'/> 
								<option value=''> --Liste des services-- </option> 
									<?php
										$ret=mysql_query('SELECT DISTINCT service FROM affectation');
										while ($ret1=mysql_fetch_array($ret))
											{
												echo '<option value="'.$ret1['service'].'">';
												echo($ret1['service']);
												echo '</option>'; 
											}
									?> 								

							</select>
						<input type="submit" value="Valider" id="" class="les_boutons"  name="Valider" style="border:2px solid black;font-weight:bold;"/>
						</td>
					</tr>
				</table>	
				<?php
				if (isset($_POST['Valider'])&& $_POST['Valider']=='Valider') 
	            {echo'<table align="center" width="800" border="0" cellspacing="0" style="margin-top:40px;border-collapse: collapse;font-family:Cambria;">
					<caption style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;">  Liste des r&eacute;partition de produits par service<span style="font-style:italic;font-size:0.6em;color:black;"> (Service b&eacute;n&eacute;ficiaire ou personne:'.$_POST['filtre'].' ) </span></caption> 
					<tr style=" background-color:#FF8080;color:white;font-size:1.2em; padding-bottom:5px;">
						<td style="border-right: 2px solid #ffffff" align="center" >R&eacute;f&eacute;rence </td>
						<td style="border-right: 2px solid #ffffff" align="center" >D&eacute;signation</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Seuil</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Quantit&eacute; affect&eacute;e</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Quantit&eacute; restant</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Date d\'affectation</td>
					</tr>';
				$filtre=$_POST['filtre'];
		        { mysql_query("SET NAMES 'utf8'");
					  mysql_query("SET NAMES 'utf8'");
					  $query_Recordset1 = "SELECT DISTINCT entree_sortie.reference,entree_sortie.designation,entree_sortie.seuil,affectation.qte_affecte,quantite,affectation.date_affect FROM affectation,entree_sortie WHERE affectation.reference=entree_sortie.reference AND service='$filtre' ORDER BY service";
					   $Recordset_2 = mysql_query($query_Recordset1); //echo $query_Recordset1;
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
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['reference']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['designation']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['seuil']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['qte_affecte']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['quantite']."</td>";
                                        echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['date_affect']."</td>";
									echo " 	</tr> ";
							}
				 }
				}	?>
				</table>
			
				
			</form>
	
</body>	
</html>