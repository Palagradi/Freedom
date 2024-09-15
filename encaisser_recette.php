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
					<td style='color:#DA4E39;'> <center> <font color='green' size='6' >Encaissement de la recette d'un agent</font> </center> </td> 
				</tr>
			</table> <br/> 
			<table align='center'>
		<?php 
			
	if (isset($_POST['Encaisser'])&& $_POST['Encaisser']=='Encaisser') 
	{	$date=date('Y-m-d'); $heure=date('H:i:s');$etat=1; 
	
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
			 $sql=mysql_query("update cloture SET etat=3,login='".$_SESSION['login']."',heure_cloture ='$heure' WHERE etat=1 AND  num_cloture ='$valeur'");
		}
		}
		//echo "update cloture SET etat=3,login='".$_SESSION['login']."' WHERE etat=1 AND  num_cloture ='".$_POST['num_cloture']."'";
	}
		if(($_SESSION['poste']=='directrice')||($_SESSION['poste']=='admin'))
			$res=mysql_query("SELECT * FROM cloture WHERE etat=1 UNION SELECT * FROM cloture WHERE etat=4"); 
		else
			$res=mysql_query("SELECT * FROM cloture WHERE etat=1");
		$nbre=mysql_num_rows($res);
		while ($ret=mysql_fetch_array($res)) 
		{	$encaisseur =$ret['encaisseur'];
			$agent =$ret['agent'];
			$etat=$ret['etat'];
			$montant=$ret['montant'];
		//}
		if($nbre>0)
			{	

			}
		else
			{	$res=mysql_query("SELECT * FROM cloture WHERE etat=3"); 
				$nbre=mysql_num_rows($res);
				while ($ret=mysql_fetch_array($res)) 
				{	$encaisseur =$ret['encaisseur'];
					$agent =ucfirst($ret['agent']);
					$etat=$ret['etat'];
					$montant=$ret['montant'];$login=$ret['login'];
				}
				if($nbre>0){
				$res=mysql_query("SELECT login FROM utilisateur WHERE login='$login'"); 
				$rers=mysql_fetch_array($res);
				if($rers['login']==$_SESSION['login'])
					echo "<tr> <td align='center' style='font-weight:bold;'>Vous avez reçu une somme de <span style='color:red;'> ".$montant."&nbsp;F</span> de l'agent <span style='color:red;'> ".$agent;
				}
			}
		//echo "<hr/>";
		}
		?>
				
		</table>
		
		<table align="center" width="700" border="0" cellspacing="0" style="margin-top:0px;border-collapse: collapse;font-family:Cambria;">
			<caption style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:0px;color:blue;">
			<?php echo "Liste des recettes ";?><span style="font-style:italic;font-size:0.6em;color:black;"> (En date du &nbsp;<?php echo $date=date('d-m-Y'); ?>)  </span></caption> 
			<tr style=" background-color:#FF8080;color:white;font-size:1.2em; padding-bottom:0px;">
			<td style="border-right: 2px solid #ffffff" align="center" >Choix </td>
				<td style="border-right: 2px solid #ffffff" align="center" >Agent </td>
				<td style="border-right: 2px solid #ffffff" align="center" >Date de l'opération</td>
				<td style="border-right: 2px solid #ffffff" align="center" >Montant encaissé</td>
			</tr>
			<?php
				mysql_query("SET NAMES 'utf8'");
				$montant1=0;
		if(($_SESSION['poste']=='directrice')||($_SESSION['poste']=='admin'))
			$res=mysql_query("SELECT * FROM cloture WHERE etat=1 UNION SELECT * FROM cloture WHERE etat=4"); 
		else
			$res=mysql_query("SELECT * FROM cloture WHERE etat=1");
			
		$nbre=mysql_num_rows($res);
		while ($row=mysql_fetch_array($res)) 
		{	$encaisseur =$row['encaisseur'];
			$num_cloture =$row['num_cloture'];  
			echo "<input type='hidden' name='num_cloture' value='".$num_cloture."'/>";
			$agent =ucfirst($row['agent']);
			$etat=$row['etat'];
			$montant=$row['montant'];
					
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
								echo "  <td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>"; echo  "<input type='checkbox' name='choix[]' value='".$row['num_cloture']."'> "; echo "</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".ucfirst($row['agent'])."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($row['date_cloture'],8,2).'-'.substr($row['date_cloture'],5,2).'-'.substr($row['date_cloture'],0,4)." &nbsp;à &nbsp;".$row['heure_cloture']."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['montant']."</td>";
						echo "</tr> ";
						$montant1=$montant1+$montant.' F CFA'; 
		}
				

			?>
		<tr align 'center'>

		<?php
		$res=mysql_query("SELECT * FROM cloture WHERE date_cloture='".date('Y-m-d')."' AND agent='".$_SESSION['login']."' AND etat=1"); 
		$nbre=mysql_num_rows($res);
		while ($ret=mysql_fetch_array($res)) 
		{	$encaisseur =$ret['encaisseur'];
		}
		if($nbre<=0)
			echo "<br/>&nbsp; &nbsp;
		</td>
		</tr>";
		if($nbre>0)
			{
			}
		?>
		</table>
			 <br/><span style='display:block;margin-left:35%;'> Montant Total:&nbsp;&nbsp;  <?php echo "<span style='font-weight:bold;' >".$montant1."</span>"; ?>
		
			<?php echo " &nbsp;&nbsp;&nbsp;<input type='submit' name='Encaisser' id='' value='Encaisser'";  echo 'onclick="if(!confirm(\'Voulez-vous vraiment continuer?\')) return false;"'; echo"/>&nbsp;&nbsp;"; ?>
			</span><td> 
	</form>
	<?php
	if (isset($_POST['CLOTURER'])&& $_POST['CLOTURER']=='CLOTURER') 
	{	$montant=0; 
		$res=mysql_query("SELECT * FROM encaissement WHERE datencaiss='".date('Y-m-d')."' and agenten='".$_SESSION['login']."'"); 
		while ($ret=mysql_fetch_array($res)) 
		{	$montant=$montant+$ret['ttc_fixe']*$ret['np']; 
		}
	$date=date('Y-m-d'); $heure=date('H:i:s');$etat=1;
	$sql=mysql_query("INSERT INTO cloture  VALUES ('$date','$heure','".$_SESSION['login']."','$montant','$etat','')");
	}

	?>
	
</html>