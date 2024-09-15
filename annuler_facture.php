<?php
     ob_start();
	session_start(); 

		   if($_SESSION['poste']==cpersonnel)
		include 'menucp.php'; 
	   	   if($_SESSION['poste']==agent)
		include 'menuprin1.php'; 
			   if($_SESSION['poste']==directrice)
		include 'menudirec.php'; 
			   if($_SESSION['poste']==admin)
		include 'admin.php';
			  if($_SESSION['poste']==comptable)
		include_once 'menucomp.php';
		include 'connexion.php';
		
		$agent=$_GET['agent'];
?>
<html>
	<head> 
		<title> SYGHOC </title> 
		<script type="text/javascript" src="date-picker.js"></script>
	</head>
	<body bgcolor='azure'>
		<form  action='recette2.php' method='post' name='recette2'>
			<table align='center'style='font-size:1.1em;'>				
				<tr> 
					<td style='color:#DA4E39;'> <B>ANNULER UNE FACTURE POUR LE COMPTE D'UN CLIENT</B></td> 
				</tr>
			</table> <br/> 
			<table align='center'>
				
				</tr> 
				<tr>
					<td style='font-style:italic;'>Pendant toute la durée de votre connexion, et tant que vous n'avez pas clôturé votre point de caisse,<br/>
					vous pouvez annuler une facture. Ci-dessous la liste des factures que vous avez émises pour les clients.
					</td>				
				</tr>
		</table>
		
		<table align="center" width="" border="0" cellspacing="0" style="margin-top:40px;border-collapse: collapse;font-family:Cambria;">
			<caption style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;"><?php echo "Liste des factures émises ";?><span style="font-style:italic;font-size:0.6em;color:black;"> (par l'agent connecté le &nbsp;<?php echo $date=date('d-m-Y'); ?>)  </span></caption> 
			<tr style=" background-color:#FF8080;color:white;font-size:1.2em; padding-bottom:5px;">
				<td style="border-right: 2px solid #ffffff" align="center" >Référence facture</td>
				<td style="border-right: 2px solid #ffffff" align="center" >Objet de la facture</td>
				<td style="border-right: 2px solid #ffffff" align="center" >Nom du client</td>
				<td style="border-right: 2px solid #ffffff" align="center" >Montant encaissé</td>
				<?php if($et!=1) echo "<td align='center' >Actions</td>";?>
			</tr>
			<?php
				$date=date('Y-m-d');
				$query_Recordset1 = "SELECT * FROM reedition_facture, reeditionfacture2 WHERE reedition_facture.numrecu = reeditionfacture2.numrecu AND  reedition_facture.date_emission='$date' AND reedition_facture.receptionniste='".$_SESSION['login']."'";
			    //mysql_query("SET NAMES 'utf8'");
				$Recordset_2 = mysql_query($query_Recordset1);
					$cpteur=1;
					$data="";
					while($row=mysql_fetch_array($Recordset_2))
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
						echo " 	<tr bgcolor='".$bgcouleur."'>"; 
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['num_facture']."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['objet']."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['nom_client']."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['somme_paye']."</td>";
								echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
								echo " 	<a href='annuler_facture.php'><img src='logo/b_drop.png' alt='Annuler' title='Annuler' width='16' height='16' border='0'></a>";
								echo " 	</td>";
						echo "</tr> ";
					}

			?>
		</table>
	</form>
	<?php
	if (isset($_POST['ok'])&& $_POST['ok']=='OK') 
	{
	}
	?>
	
</html>