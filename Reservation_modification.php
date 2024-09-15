<?php
include_once'menu.php';
    mysql_query("SET NAMES 'utf8'");
	
	$chambre=$_GET['cham'];	
	//echo "SELECT * FROM reservationch,chambre WHERE reservationch.numch=chambre.numch AND reservationch.numreserv ='".$_GET['numreserv']."'AND reservationch.numresch ='".$_GET['reference']."'";
	if($_GET['cham']==2)
		{ $reqsel=mysql_query("SELECT * FROM reservationch,chambre WHERE reservationch.numch=chambre.numch AND reservationch.numreserv ='".$_GET['numreserv']."'");
			$nbre_r=mysql_num_rows($reqsel);}
	if($nbre_r<=0)
		$reqsel=mysql_query("SELECT * FROM reservationsal,salle WHERE reservationsal.numsalle=salle.numsalle AND reservationsal.numreserv ='".$_GET['numreserv']."'");
		while($data=mysql_fetch_array($reqsel))
			{  $rlt=$data['numreserv'];
			   $rlt0=$data['numreserv'];  
			   $rlt1=$data['numresch'];  
			   $rlt2=$data['nomdemch'];
			   $rlt3=$data['prenomdemch'];
			   $rlt4=$data['contactdemch'];
			   $rlt5=$data['datarrivch'];
			   $r1=substr($rlt5,8,2).'-'.substr($rlt5,5,2).'-'.substr($rlt5,0,4);
			   $rlt6=$data['datdepch'];
			   $r2=substr($rlt6,8,2).'-'.substr($rlt6,5,2).'-'.substr($rlt6,0,4);
			   if($nbre_r<=0)
				  {$rlt7=$data['codesalle'];
				   $rlt_7=$data['numsalle'];
				  }
			   else
					{$rlt7=$data['nomch'];
					$rlt_7=$data['numch'];
					$depart=substr($rlt7,8,2);
					}
			}
		if(isset($_POST['enregistrer']) && $_POST['enregistrer'] == "Modifier")
		{ 	$numch=$_POST['chambre'];
		if(($_POST['date_entre']>=date(d-m-Y))||($_POST['date_entre']>=date(d-m-Y))){
			$debut= substr($_POST['date_entre'],6,4).'-'.substr($_POST['date_entre'],3,2).'-'.substr($_POST['date_entre'],0,2); 
			$fin= substr($_POST['date_entre2'],6,4).'-'.substr($_POST['date_entre2'],3,2).'-'.substr($_POST['date_entre2'],0,2); 
			$mois=substr($_POST['date_entre'],3,2);$jr_debut=substr($_POST['date_entre'],0,2);$ans=substr($_POST['date_entre'],6,4);
			$sup_zero=substr($_POST['date_entre2'],3,1);
			if($sup_zero!=0)
			$mois2=substr($_POST['date_entre2'],3,2);
			else
			$mois2=substr($_POST['date_entre2'],4,1);
			$jour2=substr($_POST['date_entre2'],0,2);$ans2=substr($_POST['date_entre2'],6,4);
			$ch1=trim($_POST['chambre']);
			$ch2=trim($_POST['chambre1']);
			
		if($_POST['chambreT']==2){
		//L'utilisateur modifie seulement le nom, prenoms et contact du demandeur				
		if(($_POST['nom']!=$_POST['nom1'])||($_POST['prenom']!=$_POST['prenom1'])||($_POST['contact']!=$_POST['contact1']))
                {  if((trim($_POST['date_entree'])==trim($debut))&&(trim($_POST['date_entree2'])==trim($fin))&&($ch1==$ch2))
					{$test = "UPDATE reservationch SET nomdemch='".$_POST['nom']."', prenomdemch='".$_POST['prenom']."', contactdemch='".$_POST['contact']."' WHERE numresch='".$_POST['reference']."'";
					$reqsup = mysql_query($test) or die(mysql_error()); 				
						if ($reqsup)
						{ 	$msg="La modification de la reservation a &eacute;t&eacute; prise en compte";
					        //$msg1="Retour";	
							echo '<meta http-equiv="refresh" content="1; url=planning_php.php?cham=2" />';									
						}
					}
					//l'utilisateur veut seulement changer le numéro de chambre d'une reservation et quelque chose ds nom, prenoms, adresse
				    if((trim($_POST['date_entree'])==trim($debut))&&(trim($_POST['date_entree2'])==trim($fin))&&($ch1!=$ch2))
					{ 
					//traitement
					}
					//l'utilisateur veut seulement changer la période d'occupation d'une chambre
				    if((trim($_POST['date_entree'])!=trim($debut))||(trim($_POST['date_entree2'])!=trim($fin))&&($ch1==$ch2))
					{  //traitement
					 
					}
					//l'utilisateur veut seulement changer la période d'occupation d'une chambre et le numéro de la chambre
				    if((trim($_POST['date_entree'])!=trim($debut))&&(trim($_POST['date_entree2'])!=trim($fin))&&($ch1!=$ch2))
					{  //traitement
					}
				}
				// l'utilisateur désire tout changer sur la reservation: Autant lui demander de supprimer la reservation et de faire une nouvelle
			   if(($_POST['nom']!=$_POST['nom1'])&&($_POST['prenom']!=$_POST['prenom1'])&&($_POST['contact']!=$_POST['contact1'])){
					if((trim($_POST['date_entree'])!=trim($debut))&&(trim($_POST['date_entree2'])!=trim($fin))&&($ch1!=$ch2))
					{ //traitement

						echo "<script language='javascript'>"; 
						echo " alert('Vous êtes sur le point de modifier toutes les informations concernant la réservation, autant supprimer la réservation et de faire une nouvelle');";
						echo "</script>"; 
					}
				}// l'utilisateur n'a rien changer
			    if(($_POST['nom']==$_POST['nom1'])&&($_POST['prenom']==$_POST['prenom1'])&&($_POST['contact']==$_POST['contact1'])
				&&((trim($_POST['date_entree'])==trim($debut))&&(trim($_POST['date_entree2'])==trim($fin))&&($ch1==$ch2)))
				{ 	echo "<script language='javascript'>"; 
					echo " alert('Vous n\'avez rien modifier sur la réservation');";
					echo "</script>"; 
					//header('location:planning_php.php'); 					
				}
				// En supposant maintenant que l'utilisateur a l'intention de modifier bcq d'informations
			    if(($_POST['nom']!=$_POST['nom1'])||($_POST['prenom']!=$_POST['prenom1'])||($_POST['contact']!=$_POST['contact1'])||((trim($_POST['date_entree'])!=trim($debut))||(trim($_POST['date_entree2'])!=trim($fin))||($ch1!=$ch2)))
				{ 	$query_Recordset_3 = "SELECT numresch,numch,position FROM reservationch WHERE '$debut' > datarrivch AND '$debut'< datdepch AND numch like '".$_POST['chambre']."'";
					$Recordset_3 = mysql_query($query_Recordset_3) or die(mysql_error());
					$row_Recordset_3=mysql_fetch_assoc($Recordset_3);
					$numresch=$row_Recordset_3['numresch'];
					$numreserv=$row_Recordset_3['numreserv'];
					$totalRows_Recordset3 = mysql_num_rows($Recordset_3); 
					
					//echo $totalRows_Recordset3;
					
					$query_Recordset_4 = "SELECT numresch,numch,position FROM reservationch WHERE '$fin' > datarrivch AND '$fin' < datdepch AND numch like '".$_POST['chambre']."'";
					$Recordset_4= mysql_query($query_Recordset_4) or die(mysql_error());
					$row_Recordset_4=mysql_fetch_assoc($Recordset_4);
					$numresch1=$row_Recordset_4['numresch'];
					$numreserv1=$row_Recordset_4['numreserv'];
					$totalRows_Recordset4 = mysql_num_rows($Recordset_4); 

					//echo "<br/>".$totalRows_Recordset4;
					
					 //Si la requête renvoie un résultat et qu'il n'est pas question de l'occupant courant
					//if((($totalRows_Recordset3>0)||($totalRows_Recordset4>0))&&(($numresch!=$_POST['reference'])&&($numresch1!=$_POST['reference'])))
					if((($totalRows_Recordset3>0)||($totalRows_Recordset4>0))&&(($numreserv!=$_POST['numreserv'])&&($numreserv1!=$_POST['numreserv'])))
					{  $msg=" Cette chambre est déjà occupée pour cette période";
						echo '<meta http-equiv="refresh" content="1; url=planning_php.php?cham=2" />';					
					}
					else
					{ 	$query_Recordset_5 = "SELECT numresch,numch,position FROM reservationch WHERE annee like '$ans2' AND mois like '$mois2' AND  debut like '$jour2' AND numch like '".$_POST['chambre']."'";
						$sql= mysql_query($query_Recordset_5) or die(mysql_error());
						$total_Recordset = mysql_num_rows($sql); 
						if($total_Recordset<=0)
						{	$query_Recordset_5 = "SELECT numresch,numch,position FROM reservationch WHERE annee like '$ans2' AND mois like '$mois2' AND  fin like '$jr_debut' AND numch like '".$_POST['chambre']."'";
							$sql= mysql_query($query_Recordset_5) or die(mysql_error());
							$total_Recordset = mysql_num_rows($sql); 
						}
						while($row=mysql_fetch_array($sql))
							{	$numresch=$row['numresch'];
								$numch=$row['numch'];
								$positionCourant=$row['position'];
							}
					if(($total_Recordset>0)&&($positionCourant==1))  //Si tel est le cas, enregistrer tout en modifier la position
					 {$position=5;//echo 1111;
					 }
					else 
					 {$position=1; //echo 2222;
					 }			
					
					//Si la requête ne renvoie pas de résultat ou que le resultat concerne l'occupant courant, alors UPDATE. Là encore 2 cas: update simple et update à intervalle de date sur deux mois
						//echo "<br/>".$numresch1."&nbsp;==".$_POST['reference'];
					$difference_mois= substr($_POST['date_entre2'],3,2) - substr($_POST['date_entre'],3,2);
					$difference_ans = substr($_POST['date_entre2'],6,4) - substr($_POST['date_entre'],6,4);
					$difference_jour = substr($_POST['date_entre2'],0,2)- substr($_POST['date_entre'],0,2); 
					$jr_debut=substr($_POST['date_entre'],0,2);$jr_fin=substr($_POST['date_entre2'],0,2);
					$mois=substr($_POST['date_entre'],3,2);$ans=substr($_POST['date_entre'],6,4);
					
					if(($difference_ans==0)AND($difference_mois==0)AND($difference_jour<16))
					   {//update simple
							$test = "UPDATE reservationch SET nomdemch='".$_POST['nom']."', prenomdemch='".$_POST['prenom']."', contactdemch='".$_POST['contact']."', 
							debut= '$jr_debut', fin='$jr_fin', mois='$mois', annee='$ans',datarrivch = '$debut' , datdepch = '$fin', numch = '".$_POST['chambre']."',position='$position' WHERE numreserv='".$_POST['numreserv']."'";
							$reqsup = mysql_query($test) or die(mysql_error()); 				
								if ($reqsup)
								{ 	$msg="La modification de la reservation a &eacute;t&eacute; prise en compte";
									//$msg1="Retour";	
									echo '<meta http-equiv="refresh" content="1; url=planning_php.php?cham=2" />';											
								}
					   }
					else if (($difference_mois==1) AND($difference_ans==0) AND($difference_jour<=16))
					  {//update à cheval de date sur deux mois
					    $nbj=date("t",mktime(0,0,0,$mois,1,$ans));//nbre de jours du mois courant
						$test = "UPDATE reservationch SET nomdemch='".$_POST['nom']."', prenomdemch='".$_POST['prenom']."', contactdemch='".$_POST['contact']."', 
						debut= '$jr_debut', fin='$nbj', mois='$mois', annee='$ans',datarrivch = '$debut' , datdepch = '$fin', numch = '".$_POST['chambre']."',position='$position' WHERE numreserv='".$_POST['numreserv']."'";
						$reqsup = mysql_query($test) or die(mysql_error()); 				
							if ($reqsup)
							{ 	$test = "UPDATE reservationch SET nomdemch='".$_POST['nom']."', prenomdemch='".$_POST['prenom']."', contactdemch='".$_POST['contact']."', 
								debut= '01', fin='$jr_fin', mois='$mois+1', annee='$ans',datarrivch = '$debut' , datdepch = '$fin', numch = '".$_POST['chambre']."',position='$position' WHERE numreserv='".$_POST['numreserv']."'";
								$reqsup = mysql_query($test) or die(mysql_error()); 
								if ($reqsup)
								{ 	$msg="La modification de la reservation a &eacute;t&eacute; prise en compte";
									//$msg1="Retour";
									echo '<meta http-equiv="refresh" content="1; url=planning_php.php?cham=2" />';											
								}								
							}
								
					  }							  
				 }
		 }
		}else{
			//L'utilisateur modifie seulement le nom, prenoms et contact du demandeur				
		if(($_POST['nom']!=$_POST['nom1'])||($_POST['prenom']!=$_POST['prenom1'])||($_POST['contact']!=$_POST['contact1']))
                {  if((trim($_POST['date_entree'])==trim($debut))&&(trim($_POST['date_entree2'])==trim($fin))&&($ch1==$ch2))
					{ /*  $test = "UPDATE reservationsal SET nomdemch='".$_POST['nom']."', prenomdemch='".$_POST['prenom']."', contactdemch='".$_POST['contact']."' WHERE numresch='".$_POST['reference']."'";
					$reqsup = mysql_query($test) or die(mysql_error()); 				
						if ($reqsup)
						{ 	$msg="La modification de la reservation a &eacute;t&eacute; prise en compte";
					        //$msg1="Retour";
							echo '<meta http-equiv="refresh" content="1; url=planning_php.php?sal=2" />';									
						} */
					}
					//l'utilisateur veut seulement changer le numéro de chambre d'une reservation et quelque chose ds nom, prenoms, adresse
				    if((trim($_POST['date_entree'])==trim($debut))&&(trim($_POST['date_entree2'])==trim($fin))&&($ch1!=$ch2))
					{ 
					//traitement
					}
					//l'utilisateur veut seulement changer la période d'occupation d'une chambre
				    if((trim($_POST['date_entree'])!=trim($debut))||(trim($_POST['date_entree2'])!=trim($fin))&&($ch1==$ch2))
					{  //traitement
					 
					}
					//l'utilisateur veut seulement changer la période d'occupation d'une chambre et le numéro de la chambre
				    if((trim($_POST['date_entree'])!=trim($debut))&&(trim($_POST['date_entree2'])!=trim($fin))&&($ch1!=$ch2))
					{  //traitement
					}
				}
				// l'utilisateur désire tout changer sur la reservation: Autant lui demander de supprimer la reservation et de faire une nouvelle
			   if(($_POST['nom']!=$_POST['nom1'])&&($_POST['prenom']!=$_POST['prenom1'])&&($_POST['contact']!=$_POST['contact1'])){
					if((trim($_POST['date_entree'])!=trim($debut))&&(trim($_POST['date_entree2'])!=trim($fin))&&($ch1!=$ch2))
					{ //traitement

						echo "<script language='javascript'>"; 
						echo " alert('Vous êtes sur le point de modifier toutes les informations concernant la réservation, autant supprimer la réservation et de faire une nouvelle');";
						echo "</script>"; 
					}
				}// l'utilisateur n'a rien changer
			    if(($_POST['nom']==$_POST['nom1'])&&($_POST['prenom']==$_POST['prenom1'])&&($_POST['contact']==$_POST['contact1'])&&((trim($_POST['date_entree'])==trim($debut))&&(trim($_POST['date_entree2'])==trim($fin))&&($ch1==$ch2)))
				{ 	echo "<script language='javascript'>"; 
					echo " alert('Vous n\'avez rien modifier sur la réservation');";
					echo "</script>"; 
					//header('location:planning_php.php'); 					
				}
				// En supposant maintenant que l'utilisateur a l'intention de modifier bcq d'informations
			    if(($_POST['nom']!=$_POST['nom1'])||($_POST['prenom']!=$_POST['prenom1'])||($_POST['contact']!=$_POST['contact1'])||((trim($_POST['date_entree'])!=trim($debut))||(trim($_POST['date_entree2'])!=trim($fin))||($ch1!=$ch2)))
				{   $query_Recordset_3 = "SELECT numresch,numsalle,position FROM reservationsal WHERE '$debut' >= datarrivch AND '$debut'<= datdepch AND numsalle like '".$_POST['chambre']."'";
					$Recordset_3 = mysql_query($query_Recordset_3) or die(mysql_error());
					$row_Recordset_3=mysql_fetch_assoc($Recordset_3);
					$numresch=$row_Recordset_3['numresch'];
					$numreserv=$row_Recordset_3['numreserv'];
					$totalRows_Recordset3 = mysql_num_rows($Recordset_3); 
					
					//echo $totalRows_Recordset3;
					
					$query_Recordset_4 = "SELECT numresch,numsalle,position FROM reservationsal WHERE '$fin' >= datarrivch AND '$fin' <= datdepch AND numsalle like '".$_POST['chambre']."'";
					$Recordset_4= mysql_query($query_Recordset_4) or die(mysql_error());
					$row_Recordset_4=mysql_fetch_assoc($Recordset_4);
					$numresch1=$row_Recordset_4['numresch'];
					$numreserv1=$row_Recordset_3['numreserv1'];
					$totalRows_Recordset4 = mysql_num_rows($Recordset_4); 

					//echo "<br/>".$totalRows_Recordset4;
					
					 //Si la requête renvoie un résultat et qu'il n'est pas question de l'occupant courant
					//if((($totalRows_Recordset3>0)||($totalRows_Recordset4>0))&&(($numresch!=$_POST['reference'])&&($numresch1!=$_POST['reference'])))
					if((($totalRows_Recordset3>0)||($totalRows_Recordset4>0))&&(($numreserv!=$_POST['numreserv'])&&($numreserv1!=$_POST['numreserv'])))
					{  $msg=" Cette Salle est déjà occupée pour cette période";
						echo '<meta http-equiv="refresh" content="1; url=planning_php.php?sal=2" />';						
					}
					else
					{$query_Recordset_5 = "SELECT numresch,numsalle,position FROM reservationsal WHERE annee like '$ans2' AND mois like '$mois2' AND  debut like '$jour2' AND numsalle like '".$_POST['chambre']."'";
						$sql= mysql_query($query_Recordset_5) or die(mysql_error());
						$total_Recordset = mysql_num_rows($sql); 
						if($total_Recordset<=0)
						{	$query_Recordset_5 = "SELECT numresch,numsalle,position FROM reservationsal WHERE annee like '$ans2' AND mois like '$mois2' AND  fin like '$jr_debut' AND numsalle like '".$_POST['chambre']."'";
							$sql= mysql_query($query_Recordset_5) or die(mysql_error());
							$total_Recordset = mysql_num_rows($sql); 
						}
						while($row=mysql_fetch_array($sql))
							{	$numresch=$row['numresch'];
								$numch=$row['numsalle'];
								$positionCourant=$row['position'];
							}
					if(($total_Recordset>0)&&($positionCourant==1))  //Si tel est le cas, enregistrer tout en modifier la position
					 {$position=5;//echo 1111;
					 }
					else 
					 {$position=1; //echo 2222;
					 }			
					
					//Si la requête ne renvoie pas de résultat ou que le resultat concerne l'occupant courant, alors UPDATE. Là encore 2 cas: update simple et update à intervalle de date sur deux mois
						//echo "<br/>".$numresch1."&nbsp;==".$_POST['reference'];
					$difference_mois= substr($_POST['date_entre2'],3,2) - substr($_POST['date_entre'],3,2);
					$difference_ans = substr($_POST['date_entre2'],6,4) - substr($_POST['date_entre'],6,4);
					$difference_jour = substr($_POST['date_entre2'],0,2)- substr($_POST['date_entre'],0,2); 
					$jr_debut=substr($_POST['date_entre'],0,2);$jr_fin=substr($_POST['date_entre2'],0,2);
					$mois=substr($_POST['date_entre'],3,2);$ans=substr($_POST['date_entre'],6,4);
					
					if(($difference_ans==0)AND($difference_mois==0)AND($difference_jour<16))
					   {//update simple
							$test = "UPDATE reservationsal SET nomdemch='".$_POST['nom']."', prenomdemch='".$_POST['prenom']."', contactdemch='".$_POST['contact']."',debut= '$jr_debut', fin='$jr_fin', mois='$mois', annee='$ans',datarrivch = '$debut' , datdepch = '$fin', numsalle = '".$_POST['chambre']."',position='$position' WHERE numreserv='".$_POST['numreserv']."'";
							$reqsup = mysql_query($test) or die(mysql_error()); 				
								if ($reqsup)
								{ 	$msg="La modification de la reservation a &eacute;t&eacute; prise en compte";
									//$msg1="Retour";	 
									//echo '<meta http-equiv="refresh" content="1; url=planning_php.php?sal=2" />';											
								}
					   }
					else if (($difference_mois==1) AND($difference_ans==0) AND($difference_jour<=16))
					  {//update à cheval de date sur deux mois
					    $nbj=date("t",mktime(0,0,0,$mois,1,$ans));//nbre de jours du mois courant
						$test = "UPDATE reservationsal SET nomdemch='".$_POST['nom']."', prenomdemch='".$_POST['prenom']."', contactdemch='".$_POST['contact']."', 	debut= '$jr_debut', fin='$nbj', mois='$mois', annee='$ans',datarrivch = '$debut' , datdepch = '$fin', numsalle = '".$_POST['chambre']."',position='$position' WHERE numreserv='".$_POST['numreserv']."'";
						$reqsup = mysql_query($test) or die(mysql_error()); 				
							if ($reqsup)
							{ 	$test = "UPDATE reservationsal SET nomdemch='".$_POST['nom']."', prenomdemch='".$_POST['prenom']."', contactdemch='".$_POST['contact']."', 
								debut= '01', fin='$jr_fin', mois='$mois+1', annee='$ans',datarrivch = '$debut' , datdepch = '$fin', numsalle = '".$_POST['chambre']."',position='$position' WHERE numreserv='".$_POST['numreserv']."'";
								$reqsup = mysql_query($test) or die(mysql_error()); 
								if ($reqsup)
								{ 	$msg="La modification de la reservation a &eacute;t&eacute; prise en compte";
									//$msg1="Retour";	
									//echo '<meta http-equiv="refresh" content="1; url=planning_php.php?sal=2" />';									
								}								
							}
								
					  }	 							  
					}
			}
			
		}
		
		}else // l'utilisateur ne peut pas changer une réservation dont la date est échue
		{	echo "<script language='javascript'>"; 
			echo " alert('Vous ne pouvez plus modifier une réservation dont la période est antérieure à la date du jour');";
			echo "</script>";  
		}	  
}				
		if(isset($_POST['annuler']) && $_POST['annuler'] == "Annuler")
		{		if($_POST['chambreT']==2)
					header('location:planning_php.php?cham=2');
				else
					header('location:planning_php.php?sal=2');
		}
?>


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>SYGHOC</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>
		<script type="text/javascript" src="date-picker.js"></script>
	</head>
	<body bgcolor='azure' style="margin-top:-1%;">
		<div align="center">
			<form action="reservation_modification.php" method="POST" name="reservation_modification">
				<table width="700" height="200" border="0" cellpadding="2" cellspacing="0" style="margin-top:50px; border:2px solid; font-family:Cambria;">
					<tr>
						<td colspan="4">
						<input type="hidden" id="" name="chambreT" value="<?php echo $chambre ?>" onFocus="this.blur()" style="width:200px;" />
							<h2 style="text-align:center; font-family:Cambria;color:#a4660d;">MODIFICATION D'UNE RESERVATION DE 
							<?php 
							if($chambre==2)
								echo 'CHAMBRE';
							else
								echo 'SALLE';
							?>
							</h2>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;">R&eacute;f&eacute;rence : </td>
						<td colspan="2"> <input type="text" id="" name="reference" value="<?php echo $rlt1 ?>" onFocus="this.blur()" style="width:200px;" /> </td>
					<input type="hidden" id="" name="numreserv" value="<?php echo $rlt0 ?>" style="width:200px;"/></tr>
					<tr> 
						<td colspan="2" style="padding-left:100px;"> Nom du demandeur : </td>
						<td colspan="2"> <input type="text" id="" name="nom" value="<?php echo $rlt2 ?>" style="width:200px;"/> 
						<input type="hidden" id="" name="nom1" value="<?php echo $rlt2 ?>" style="width:200px;"/> </td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;"> Pr&eacute;noms du demandeur : </td>
						<td colspan="2"> 
		               <input type="text" id="" name="prenom"  value="<?php echo $rlt3 ?> "  style="width:200px;" />
					    <input type="hidden" id="" name="prenom1"  value="<?php echo $rlt3 ?> "  style="width:200px;" />
						</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;">Contact du demandeur : </td>
						<td colspan="2">
                       <input type="text" id="" name="contact"  value="<?php echo $rlt4 ?> "  style="width:200px;" />
					   <input type="hidden" id="" name="contact1"  value="<?php echo $rlt4 ?> "  style="width:200px;" />
						</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;">Date d'entr&eacute;e envisag&eacute;e: </td>						
					   <td colspan="2" style=" border: 0px solid black;"> <input type="text" name="date_entre" id="date_entre" size=""  value="<?php
echo $rlt_5=substr($rlt5,8,2).'-'.substr($rlt5,5,2).'-'.substr($rlt5,0,4);  ?> " readonly style="width:200px;" />
						   <a href="javascript:show_calendar('reservation_modification.date_entre');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
							<img src="logo/cal.gif" border="0" alt="calendrier" title="calendrier"></a>
						<input type="hidden" name="date_entree" id="date_entree" size=""  value="<?php
echo $rlt5;  ?> " readonly style="width:200px;" />
					  </td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;">Date de sortie envisag&eacute;e : </td>					
						<td colspan="2" style=" border: 0px solid black;"> <input type="text" name="date_entre2" id="date_entre2" size=""  value="<?php 
echo $rlt_6=substr($rlt6,8,2).'-'.substr($rlt6,5,2).'-'.substr($rlt6,0,4); ?> " readonly style="width:200px;" />
						 <a href="javascript:show_calendar('reservation_modification.date_entre2');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
						<img src="logo/cal.gif" border="0" alt="calendrier" title="calendrier"></a>
						<input type="hidden" name="date_entree2" id="date_entree2" size=""  value="<?php
echo $rlt6; ?> " readonly style="width:200px;" />
					  </td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;">
						<?php 
							if($nbre_r<=0)
								echo 'Salle'; 
							else
								echo 'Chambre';
						?>
							 choisie : </td>
						<td colspan="2">
							<select name='chambre' id='chambre' style='width:205px;'>
								<option value='<?php echo $rlt_7 ?>'><?php echo $rlt7 ?></option>
									<?php
										if($nbre_r<=0)
										{$res=mysql_query('SELECT numsalle,codesalle FROM salle'); 
										while ($ret=mysql_fetch_array($res)) 
											{
												echo '<option value="'.$ret['numsalle'].'">';
												echo($ret['codesalle']);
												echo '</option>' ; 
											}
										}
										else{										
										$res=mysql_query('SELECT numch,nomch FROM chambre'); 
										while ($ret=mysql_fetch_array($res)) 
											{
												echo '<option value="'.$ret['numch'].'">';
												echo($ret['nomch']);
												echo '</option>' ; 
											}
										}	
											
									?>
							</select>
					<input type="hidden" id="" name="chambre1"  value="<?php echo $rlt_7 ?> "  style="width:200px;" />
						</td>
					</tr>
					<tr>
						<td colspan="2" align="right" style="padding-right: 20px;"> <br/><input type="submit" class="les_boutons" value="Modifier" id="" name="enregistrer" style="border:2px solid #317082;margin-bottom:20px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;"/> </td>
						<td colspan="2">  <br/><input type="submit" name="annuler" class="les_boutons" value="Annuler"/ style="border:2px solid #317082;margin-bottom:20px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;"> </td>
					</tr>

				</table>
			</form>
			<table width="582" border="0" cellspacing="0" cellpadding="0">
			<tr>
			    <td>
				<h4 style="text-align:center; font-family:Cambria;color:#a4660d;"> <?php echo $msg ?></h4>
				</td>
			</tr>
			<tr>
			    <td>
				<a href="<?php
				if($chambre==2)
					echo'planning_php.php?cham=2';
				else
					echo 'planning_php.php';
				?>
				" style="text-decoration:none;"><span style="text-align:center; font-family:Cambria;color:blue;margin-left:250px;"><?php echo $msg1 ?></span></a>
				</td>
			</tr>
			</table>
		</div>
	</body>
</html>