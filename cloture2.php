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
		include 'chiffre_to_lettre.php';
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
					<td style='color:#DA4E39;'> <center> <font color='green' size='6' >Liste des montants que vous avez encaissé des différents agents</font></center></td> 
				</tr>
			</table> <br/> 
			<table align='center'>
		<?php 
				
	if (isset($_POST['RENDRE'])&& $_POST['RENDRE']=='RENDRE COMPTE') 
	{  
	}
		$res=mysql_query("SELECT * FROM cloture WHERE date_cloture='".date('Y-m-d')."' AND agent='".$_SESSION['login']."' AND etat=1"); 
		$nbre=mysql_num_rows($res);
		while ($ret=mysql_fetch_array($res)) 
		{	$encaisseur =$ret['encaisseur'];
			$etat=$ret['etat'];
		}

		if($nbre>0)
			{if(!empty($encaisseur))
				{$msg="<td style='font-weight:bold;font-size:1.1em;'> L'encaissement est en attente auprès de la/du <span style='color:red;'> ".$encaisseur."</span>. Rapprochez-vous de lui pour lui remettre le montant.</td></tr>";
					if($msg!="")
						echo $msg;
				}
			else{
				//echo"<tr> <td style='font-weight:bold;'>Vous avez déjà clôturé votre point de caisse. Mais la somme  n'est encore perçu pas aucune autorité habilleté.</td></tr>";
				echo "<tr>
									<td><b>Sélectionnez une personne à qui vous voulez rendre compte ou passer la main : </b>																		
									<select name='edit6' id='edit6'  style='width:150px;' >
											<option value='".$codegrpe."'>".$codegrpe."</option>";
												mysql_query("SET NAMES 'utf8' ");
													$res=mysql_query('SELECT poste AS poste,login AS login FROM utilisateur WHERE poste NOT IN ("agent","admin")
													UNION
													SELECT nom AS poste,login AS login  FROM utilisateur WHERE poste LIKE "agent"'); 
													while ($ret=mysql_fetch_array($res)) 
														{	$poste=ucfirst($ret['poste']);
															if($ret['poste']=="cpersonnel")
															$poste="Chef personnel";
															echo '<option value="'.$poste.'">';
															echo $poste;
															echo '</option>' ; 
														}														
				echo "</select> 
									<input type='submit' name='RENDRE' id='' value='RENDRE COMPTE'"; echo 'onclick="if(!confirm(\'Voulez-vous vraiment continuer?\')) return false;"'; echo"/><td>
				</tr>";
				}
			}


		?>
<table align="center" width="" border="0" cellspacing="0" style="margin-top:5px;border-collapse: collapse;font-family:Cambria;">
			<caption style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;"><?php echo "Liste des recettes ";?><span style="font-style:italic;font-size:0.6em;color:black;"> (En date du &nbsp;<?php echo $date=date('d-m-Y'); ?>)  </span></caption> 
			<tr style=" background-color:#FF8080;color:white;font-size:1.2em; padding-bottom:5px;">
			<td style="border-right: 2px solid #ffffff" align="center" >Choix</td>
				<td style="border-right: 2px solid #ffffff" align="center" >Date de l'opération </td>
				<td style="border-right: 2px solid #ffffff" align="center" >Heure de l'opération</td>
				<td style="border-right: 2px solid #ffffff" align="center" >Agent</td>
				<td style="border-right: 2px solid #ffffff" align="center" >Montant encaissé</td>
			</tr>
			<?php
				mysql_query("SET NAMES 'utf8'");
				$montant1=0;
		$res=mysql_query("SELECT * FROM cloture WHERE etat=3 AND login='".$_SESSION['login']."'"); 
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
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['date_cloture']."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['heure_cloture']."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".ucfirst($row['agent'])."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$row['montant']."</td>";
						echo "</tr> ";
						$montant1=$montant1+$montant.' F CFA'; 
		}
				

			?>
		<tr align 'center'>
			<td>
			</td>
		</tr>
	</table>
<?php
		echo "<table>
			<tr>
				<td align='center'><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Sélectionnez une personne à qui vous voulez rendre compte : </b>																		
				<select name='edit6' id='edit6'  style='width:150px;' >
						<option value='".$codegrpe."'>".$codegrpe."</option>";
							mysql_query("SET NAMES 'utf8' ");
								$res=mysql_query('SELECT poste AS poste,login AS login FROM utilisateur WHERE poste NOT IN ("agent","admin")
								UNION
								SELECT nom AS poste,login AS login  FROM utilisateur WHERE poste LIKE "agent"'); 
								while ($ret=mysql_fetch_array($res)) 
									{	$poste=ucfirst($ret['poste']);
										if($ret['poste']=="cpersonnel")
										$poste="Chef personnel";
										echo '<option value="'.$poste.'">';
										echo $poste;
										echo '</option>' ; 
									}														
				echo "</select> 
					
				</tr>
			</table>";
?>
	<table>	
			<tr> 
				<td WIDTH='' align='center'><B><br/> 
				&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
				&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
				&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
				Montant total encaissé: &nbsp;<?php echo $montant1; ?> </B>
				

		<?php
		$date_reference='2014-10-03';
		$res=mysql_query("SELECT max(num_encaisse) AS maximum FROM encaissement WHERE datencaiss>='$date_reference' and encaissement.agenten='".$_SESSION['login']."'"); 
			while ($ret=mysql_fetch_array($res)) 
				{  $maximum=$ret['maximum'];}
		$res=mysql_query("SELECT * FROM cloture WHERE date_cloture='".date('Y-m-d')."' AND agent='".$_SESSION['login']."' AND etat=1"); 
		$nbre=mysql_num_rows($res);
		while ($ret=mysql_fetch_array($res)) 
		{	$encaisseur =$ret['encaisseur'];
		}
		if($nbre<=0)
		{$res=mysql_query("SELECT * FROM cloture WHERE num_cloture='$maximum' AND agent='".$_SESSION['login']."' AND etat=3"); 
			$nbre=mysql_num_rows($res);
			while ($ret=mysql_fetch_array($res)) 
			{	$encaisseur2 =$ret['encaisseur'];
			}
		}
		//if($nbre1==2)
			//{
			echo "&nbsp; &nbsp;<input type='submit' name='RENDRE' id='' value='RENDRE COMPTE'"; echo 'onclick="if(!confirm(\'Voulez-vous vraiment continuer?\')) return false;"'; echo"/>";
			//}
		//else  echo  "&nbsp; &nbsp;<input type='submit' name='CAISSE2' id='' value='CAISSE CLOTUREE'/>";	
		echo "</td>
		</tr>";
		if($nbre>0)
			{
			}
		?>
		</table>
	</form>
	<?php
	if (isset($_POST['RENDRE'])&& !empty($_POST['choix']))
	{	 //on déclare une variable
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
	   $sql=mysql_query("update cloture SET encaisseur2='".$_POST['edit6']."',etat=4 WHERE num_cloture='$valeur'");
		}
		}
	$res=mysql_query("SELECT * FROM cloture WHERE etat=4"); 
		while ($ret=mysql_fetch_array($res)) 
		{	$encaisseur2 =$ret['encaisseur2'];
			$etat=$ret['etat'];
		}
		echo $msg="</br><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		L'encaissement est en attente auprès de la/du <span style='color:red;'> <b>".$encaisseur2."</b></span>. Rapprochez-vous de lui pour lui remettre le montant.</b>";
	}		

//	}

	?>
	
</html>