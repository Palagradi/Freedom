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
		<form  action='' method='post' name=''>
			<table align='center'style='font-size:1.1em;'>				
				<tr> 
					<td style='color:#DA4E39;'> <center> <font color='green' size='6' >Encaissement de la recette d'un personnel</font> </center> </td> 
				</tr>
			</table>
	 <br/> 
			<table align='center' >
				<tr>
				<td><br/><B>Période du:</B></td>
				<td>
					<br/><input type="text" name="debut" id="" size="20" readonly style='<?php if($etat1_4==1)echo"background-color:#FDF1B8;";?>' value="" />
				   <a href="javascript:show_calendar('journal.debut');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
					 <img src="logo/cal.gif" style="border:1px solid blue;" alt="calendrier" title="calendrier"></a>
				</td>
				<td> <br/><B>AU:</B></td>
				<td>
					<br/><input type="text" name="fin" id="" size="20" readonly style='<?php if($etat1_4==1)echo"background-color:#FDF1B8;";?>' value="" />
				   <a href="javascript:show_calendar('journal.fin');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
					 <img src="logo/cal.gif" style="border:1px solid blue;" alt="calendrier" title="calendrier"></a>
				</td>
				<td><br/><input type='submit' name='ok' value='OK'/></td> 
				
				<input type='hidden' name='agent' value='<?php echo $agent;?>'/>
				
				
				</tr>
		</table>

		<?php 
		
	if (isset($_POST['Encaisser'])&& $_POST['Encaisser']=='Encaisser') 
	{	$date=date('Y-m-d'); $heure=date('H:i:s');$etat=1; 
		$encaisseur2=ucfirst($_SESSION['poste']);
		$choix ='';
		//on boucle
		for ($i=0;$i<count($_POST['choix']);$i++)
		{
		//on concatène
		 $choix .= $_POST['choix'][$i].'|';
		$explore = explode('|',$choix);
		}
 		 $choix;
		 foreach($explore as $valeur){
			if(!empty($valeur)){
			  $valeur;
			 $sql=mysql_query("update cloture SET etat=5,date_cloture='$date',heure_cloture ='$heure',encaisseur2 ='$encaisseur2' WHERE num_cloture ='$valeur'");
		}
		}
		//echo "update cloture SET etat=3,login='".$_SESSION['login']."' WHERE etat=1 AND  num_cloture ='".$_POST['num_cloture']."'";
	}
	
	
		$debut=date('Y-m');$debut.="-01"; $fin=date('Y-m');$fin.="-31";
		//echo "SELECT * FROM cloture WHERE date_cloture BETWEEN '$debut' AND '$fin' AND etat=3";
		$query_Recordset1=mysql_query("SELECT * FROM cloture WHERE date_cloture BETWEEN '$debut' AND '$fin' "); 
		$nbre=mysql_num_rows($query_Recordset1);

		if($nbre>0)
		{	echo "<table align='center' width='700' border='0' cellspacing='0' style='margin-top:20px;border-collapse: collapse;font-family:Cambria;'>
			<caption style='text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.5em;margin-bottom:5px;color:blue;'> <span style='font-style:italic;font-size:0.6em;color:black;'> 
			Du  &nbsp".substr($debut,8,2).'-'.substr($debut,5,2).'-'.substr($debut,0,4)."&nbsp;au &nbsp;".substr($fin,8,2).'-'.substr($fin,5,2).'-'.substr($fin,0,4)." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</span>  </caption> 
			<tr style='background-color:#FF8080;color:white;font-size:1.2em; padding-bottom:5px;'>
				<td style='border-right: 2px solid #ffffff' align='center' >Choix </td>
				<td style='border-right: 2px solid #ffffff' align='center' >Date </td>
				<td style='border-right: 2px solid #ffffff' align='center' >Heure </td>
				<td style='border-right: 2px solid #ffffff' align='center'> Montant </td>
				<td style='border-right: 2px solid #ffffff' align='center' >Agent </td>
				<td style='border-right: 2px solid #ffffff' align='center' >Encaisseur </td>
				<td style='border-right: 2px solid #ffffff' align='center' >Encaisseur Final</td>
			</tr>";
				mysql_query("SET NAMES 'utf8'");
				$date=date('Y-m-d');
				//$query_Recordset1 = "SELECT DISTINCT num_facture,heure_emission,objet,nom_client,somme_paye,reedition_facture.numrecu,reeditionfacture2.numfiche,reeditionfacture2.designation FROM reedition_facture, reeditionfacture2 WHERE reedition_facture.numrecu = reeditionfacture2.numrecu AND  reedition_facture.date_emission='$date' AND reedition_facture.receptionniste='".$_SESSION['login']."'";
			    //$Recordset_2 = mysql_query($query_Recordset1);
					$cpteur=1;
					$data="";$montant=0;
					while($row=mysql_fetch_array($query_Recordset1))
					{   //$nom_p=substr($row['code_reel'].' '.$row['prenoms'],0,15);if($row['due']<0) $due=-$row['due']; else $due=$row['due'];
					
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
								echo "  <td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>";
								if($row['etat']==4) 
									echo  "<input type='checkbox' name='choix[]' value='".$row['num_cloture']."' style='border:red;color:red;'/> "; 
								else
									echo  "<input type='checkbox' name='choix[]' value='".$row['num_cloture']."'/> "; 
								echo "</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($row['date_cloture'],8,2).'-'.substr($row['date_cloture'],5,2).'-'.substr($row['date_cloture'],0,4)."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['heure_cloture']."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['montant']."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".ucfirst($row['agent'])."</td>";
								if($row['etat']!=1)
									echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".ucfirst($row['encaisseur'])."</td>";
								else
									echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> --- </td>";
								if($row['etat']==5)
									echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['encaisseur2']."</td>";
								else
									echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> --- </td>";
						echo "</tr> "; $montant=$montant+$row['montant'].' F CFA';
					}
		echo"<tr align 'center'>
			<td>
			</td>
			<td> 
		</tr>
		</table>
		 <br/><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 Montant Total encaissé:</b>&nbsp;&nbsp;<span style='font-weight:bold;' >".$montant."</span>";
	}		
 echo " &nbsp;&nbsp;&nbsp;<input type='submit' name='Encaisser' id='' value='Encaisser'";  echo 'onclick="if(!confirm(\'Voulez-vous vraiment continuer?\')) return false;"'; echo"/>&nbsp;&nbsp;"; 

	echo "</form>";?>
</body>
</html>