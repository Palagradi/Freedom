<?php
	session_start(); 
     mysql_query("SET NAMES 'utf8'");
/* 	   if($_SESSION['poste']==cpersonnel)
		include 'menucp.php'; 
	   	   if($_SESSION['poste']==agent)
		include 'menuprin1.php'; 
			   if($_SESSION['poste']==directrice)
		include 'menudirec.php'; 
			   if($_SESSION['poste']==admin)
		include 'admin.php'; 
			  if($_SESSION['poste']==secretaire)
		include 'menusecretaire.php'; */
		include 'connexion_2.php';
		include 'connexion.php';	
		
	
	// automatisation de la r&eacute;f&eacute;rence
	function random($car) {
		$string = "REF";
		$chaine = "0123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
		}
		return $string;
		}
	$reqsel=mysql_query("SELECT * FROM configuration_facture");
	while($data=mysql_fetch_array($reqsel))
		{   $num_operation=$data['num_operation'];
		}
/* 		
		$reqsel=mysql_query("SELECT numero FROM operation");
	while($data=mysql_fetch_array($reqsel))
		{    $numero=$data['numero'];
				
			if(($numero>=0)&&($numero<=9))
			{ $ref_operation='REF0000'.$numero;
			echo $query ="UPDATE operation SET ref_operation='$ref_operation'  WHERE numero='$numero'"; 
			echo "<br/>";
			}
	else if(($numero>=10)&&($numero<=99))
		  { $ref_operation='REF000'.$numero;
		    echo $query ="UPDATE operation SET ref_operation='$ref_operation'  WHERE numero='$numero'"; echo "<br/>";
			}
	else if(($numero>=100)&&($numero<=999))
					{ $ref_operation='REF00'.$numero;
					echo $query ="UPDATE operation SET ref_operation='$ref_operation'  WHERE numero='$numero'"; echo "<br/>";
			}
	else if(($numero>=1000)&&($numero<=1999))
						{ $ref_operation='REF0'.$numero;
				    echo $query ="UPDATE operation SET ref_operation='$ref_operation'  WHERE numero='$numero'"; echo "<br/>";
			}
	else
						{ $ref_operation='REF'.$numero;
				   echo $query ="UPDATE operation SET ref_operation='$ref_operation'  WHERE numero='$numero'"; echo "<br/>";
			}
		$update=mysql_query($query);
		} */	
		
		
		$sql2=mysql_query("SELECT ref_operation,designation_operation,designation,seuil,Qte_initiale,Qte_entree,operation.date_modification AS date_modification FROM operation,entree_sortie WHERE Entree_Sortie.reference1=operation.reference1  AND operation.date_modification='".date('d-m-Y')."' ORDER BY designation ");
		$data="";
 		while($row=mysql_fetch_array($sql2))
		{ 
				  $ref_operation=$row['ref_operation'];   
				  $designation_operation=$row['designation_operation'];
				  $designation=$row['designation'];
				  $seuil=$row['seuil'];
				  $Qte_initiale=$row['Qte_initiale'];
				  $Qte_entree=$row['Qte_entree'];
		
			
			$ecrire=fopen('operation.txt',"w");
			$data.=$ref_operation.';'.$designation_operation.';'.$designation.';'.$seuil.';'.$Qte_initiale.';'.$Qte_entree."\n";
			$ecrire2=fopen('operation.txt',"a+");
			fputs($ecrire2,$data);
		}
			
		
		if (isset($_POST['ENREGISTRER'])&& ($_POST['ENREGISTRER']=='ENREGISTRER')&&(!empty($_POST['quantite']))) 
		{  $reference=$_POST['designation'];
		  $quantite_entree=$_POST['quantite'];
		  $date_modification = date('d-m-Y');
		  $heure_modification = date('H:i');
		  $connecter = new Connexion_2;
			if($connecter->testConnexion())
				{	mysql_query("SET NAMES 'utf8'");
					$reqsel=mysql_query("SELECT ref_operation  FROM operation WHERE ref_operation='".$_POST['r_operation']."'");
					$nbre=mysql_num_rows($reqsel);
					if($nbre<=0){
					$reqsel=mysql_query("SELECT quantite FROM entree_sortie WHERE reference1='$reference'");
					$nbre=mysql_num_rows($reqsel);
					while($data=mysql_fetch_array($reqsel))
					{   $quantite=$data['quantite'];
					}$quantiteF=$quantite+$quantite_entree; $quantiteF=$quantite_entree+$quantite;
					$re="INSERT INTO operation VALUES('','".$_POST['r_operation']."','".$_POST['operation']."','$reference','$quantite','".$_POST['quantite']."','$quantiteF','$date_modification','$heure_modification','','')"; 
					$reqsup = mysql_query($re) or die(mysql_error());
					$test = "UPDATE entree_sortie SET quantite=quantite+'$quantite_entree', date_modification='$date_modification' WHERE reference1='$reference' ";
					$reqsup = mysql_query($test) or die(mysql_error());
					$update=mysql_query("UPDATE configuration_facture SET num_operation=num_operation+1  WHERE num_operation!=''");
					$msg="<span style='color:#EF332A;font-style:italic;'>L'op&eacuteration a &eacute;t&eacute; enregistr&eacute;e avec succès</span>";
					//echo "<script language='javascript'>alert('L'opération a été enregistrée avec succès');</script>";
				echo "<script language='javascript'>"; 
				echo " alert('L'opération a été enregistrée avec succès.');";
				echo "</script>";
					$msg1="Retour";
					}
				}
			echo '<meta http-equiv="refresh" content="1; url=mise_a_jour.php" />';
	     }
?>
<html>
	<head> 
		<title> SYGHOC </title> 
		<script type="text/javascript" src="date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
	</head>
	<body bgcolor='azure'>

		<div align="center" style="padding-top:50px;">
			<form action="search.php" method="POST" name='miseajour'> 
				<table width="800" height="280" border="0" cellpadding="0" cellspacing="0" style="border:2px solid black;font-family:Cambria;">
					<tr>
						<td colspan="4">
							<h2 style="text-align:center; font-family:Cambria;color:blue;">ENREGISTREMENT D'UNE OPERATION</h2>
						</td>
					</tr>					
					<tr>
						<td colspan="2" style="padding-left:100px;" ><B>R&eacute;f&eacute;rence de l'op&eacute;ration :</B></td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="" name="r_operation" readonly value="<?php 
										if(($num_operation>=0)&&($num_operation<=9))
												echo 'REF0000'.$num_operation ;
										else if(($num_operation>=10)&&($num_operation<=99))
												echo 'REF000'.$num_operation ;
										else if(($num_operation>=100)&&($num_operation<=999))
												echo 'REF00'.$num_operation ;
										else if(($num_operation>=1000)&&($num_operation<=1999))
												echo 'REF0'.$num_operation ;
										else
												echo 'REF'.$num_operation;			
						?>" style="width:200px;"/> </td>
					</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;"><B> Nom de l'op&eacute;ration:</B> </td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="" name="operation" style="width:200px;"/> </td>
					</tr>

					<tr>
						<td colspan="2" style="padding-left:100px;"> <B>D&eacute;signation du produit :</B> </td>
						<td colspan="2">&nbsp;&nbsp;
						<select name="designation" style="border:0px solid black;width:200px;" >
							<?php
								$connecter = new Connexion_2;
								if($connecter->testConnexion())
								{mysql_query("SET NAMES 'utf8'");
									echo "<option value=''></option>";
									$req1=mysql_query("SELECT  reference1,designation FROM entree_sortie")or die ("Erreur de requête".mysql_error());
									while($data=mysql_fetch_array($req1))
									{    
										echo" <option value ='".$data['reference1']."'> ".$data['designation']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option> ";
									}
									mysql_free_result($req1);
									mysql_close();
								}
							?>
						</select>
						</td>
						</tr>
					<tr>
						<td colspan="2" style="padding-left:100px;"><B> Quantit&eacute;e &agrave; entr&eacute;e :</B> <span style="font-style:italic;font-size:0.8em;color:#ACBFC5;"></span></td>
						<td colspan="2">&nbsp;&nbsp;<input type="text" id="" name="quantite" style="width:200px;"onkeypress="testChiffres(event);"/> </td>
					</tr>
	
					<tr>
						<td colspan="2" align="right" > <input type="submit" value="ENREGISTRER" id="" class="les_boutons"  name="ENREGISTRER" style="border:2px solid black;font-weight:bold;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;"/> </td>
						<td colspan="2">&nbsp;&nbsp;<input type="reset" value="ANNULER" class="les_boutons"  name="Annuler" style="border:2px solid black;font-weight:bold;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;"/> </td>
					</tr>
				</table>
		</div>
			<?php
			echo "<table align='center' style='border:0px solid black;'> <tr> <td style='font-weight:bold;'>
		    $msg
			 </td></tr></table>";
			?>
				<table align="center" width="" border="0" cellspacing="0" style="margin-top:40px;border-collapse: collapse;font-family:Cambria;">
					<caption style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;">  Liste des op&eacute;rations <span style="font-style:italic;font-size:0.6em;color:black;"> 
					<?php   
					

						$connecter= new Connexion_2;
					   if($connecter->testConnexion())
					  {	mysql_query("SET NAMES 'utf8'");
						if (isset($_POST['Rechercher'])&& $_POST['Rechercher']=='Rechercher') 
							{    $edit4=trim(addslashes($_POST['edit4'])); $produit=trim(addslashes($_POST['edit4']));
								 $query_Recordset1 = "SELECT ref_operation,heure_operation,qte_finale,designation_operation,designation,seuil,Qte_initiale,Qte_entree,quantite,operation.date_modification AS date_modification FROM operation,entree_sortie WHERE designation LIKE '$edit4%' AND Entree_Sortie.reference1=operation.reference1  ORDER BY operation.numero  LIMIT 50";
							}
						else if (isset($_POST['OK'])&& $_POST['OK']=='OK') 
							{    $debut=$_POST['debut']; $fin=$_POST['fin']; 
								 $query_Recordset1 = "SELECT ref_operation,heure_operation,qte_finale,designation_operation,designation,seuil,Qte_initiale,Qte_entree,quantite,operation.date_modification AS date_modification FROM operation,entree_sortie WHERE  operation.date_modification BETWEEN '$debut' AND '$fin' AND Entree_Sortie.reference1=operation.reference1  ORDER BY operation.numero  LIMIT 50";
							}
						else
					   $query_Recordset1 = "SELECT ref_operation,heure_operation,qte_finale,designation_operation,designation,seuil,Qte_initiale,Qte_entree,quantite,operation.date_modification AS date_modification FROM operation,entree_sortie WHERE Entree_Sortie.reference1=operation.reference1  ORDER BY operation.numero  ";
				   
				   }
					if(!empty($_GET['produit']))  $produit=$_GET['produit']; if(!empty($_GET['debut']))  $debut=$_GET['debut'];if(!empty($_GET['fin']))  $fin=$_GET['fin'];
				   	$connecter= new Connexion_2;
					 if($connecter->testConnexion())
					{
						if(!empty($produit))
							$reqsel=mysql_query("SELECT ref_operation,designation_operation,designation,seuil,Qte_initiale,Qte_entree,quantite,operation.date_modification AS date_modification FROM operation,entree_sortie WHERE Entree_Sortie.reference1=operation.reference1 and designation LIKE '$produit' ORDER BY operation.numero");
						else if(!empty($debut)&&(!empty($fin)))
							$reqsel=mysql_query("SELECT ref_operation,designation_operation,designation,seuil,Qte_initiale,Qte_entree,quantite,operation.date_modification AS date_modification FROM operation,entree_sortie WHERE operation.date_modification BETWEEN '$debut' AND '$fin' AND Entree_Sortie.reference1=operation.reference1  ORDER BY operation.numero");
						else
							$reqsel=mysql_query("SELECT ref_operation,designation_operation,designation,seuil,Qte_initiale,Qte_entree,quantite,operation.date_modification AS date_modification FROM operation,entree_sortie WHERE Entree_Sortie.reference1=operation.reference1  ORDER BY operation.numero");
					$nbre_prdts=mysql_num_rows($reqsel);
					$prdtsParPage=50; //Nous allons afficher 5 contribuable par page.
					$nombreDePages=ceil($nbre_prdts/$prdtsParPage); //Nous allons maintenant compter le nombre de pages.
					 
					if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
					{
						  $pageActuelle=intval($_GET['page']);
					 
						 if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
						 {
							   $pageActuelle=$nombreDePages;
						 }
					}
					else // Sinon
					{
						  $pageActuelle=1; // La page actuelle est la n°1    
					}
					 $premiereEntree=($pageActuelle-1)*$prdtsParPage;
					} 
					
				   ?>
					<?php

					if($nbre_prdts> $prdtsParPage ) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:red;'>Page :</span> "; //Pour l'affichage, on centre la liste des pages
						$k=$_GET['page'] -1;  if(empty($_GET['page'])) $T=50; else $T=$_GET['i']-50;
					if($k>0)
						echo ' <a href="search.php?page='.$k.'&produit='.$produit.'&debut='.$debut.'&fin='.$fin.'" title="Précédent" style="text-decoration:none;">  &nbsp;&nbsp;<<&nbsp;&nbsp;  </a> ';
						
						for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
						{
							 //On va faire notre condition
							 if($i==$pageActuelle) //Si il s'agit de la page actuelle...
							 {
								 echo ' [ '.$i.' ] '; 
							 }	
							 if($i==1)
							 {
								  if(!empty($fiche))
									echo ' <a href="search.php?page='.$i.'&produit='.$produit.'&debut='.$debut.'&fin='.$fin.'&i=0">'.$i.'</a> ';
								  else 
									echo ' <a href="search.php?page='.$i.'&produit='.$produit.'&debut='.$debut.'&fin='.$fin.'&i=0">'.$i.'</a> ';
							 }
						}
						if(empty($_GET['page']))$j=$_GET['page'] +2; else $j=$_GET['page'] +1; if(empty($_GET['page'])) $T=50; else $T=50*$_GET['page'];
						if($i>=$j)
							echo ' <a href="search.php?page='.$j.'&produit='.$produit.'&debut='.$debut.'&fin='.$fin.'&i='.$T.'" title="Suivant" style="text-decoration:none;">  &nbsp;&nbsp;>>&nbsp;&nbsp;  </a> ';
					//echo $produit;
					?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<form action='search.php' method='post'  name='miseajour'>
								  <span style='margin-left:0px;font-size:1.3em;color:red;'>
								  <b>Produit:</b> 
								 <input type='text' name='edit4'id='edit4'  style='width:130px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;' value='<?php if(!empty($_GET['produit'])) echo $_GET['produit']; ?>'/> 
								 <input type='hidden' name='edit_4'id='edit_4' value='' />
								 <a href='' style='text-decoration:none;'>
								 <input type='submit' name='Rechercher' value='Rechercher' style='width:90px; border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;'/> </a>
								
								 <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Du:</b>
								 <input type="text" name="debut" id="" size="20"  readonly   style='width:130px; border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value="<?php if(!empty($_GET['debut'])) echo $_GET['debut']; ?>" />
								<a href="javascript:show_calendar('miseajour.debut');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
								<img src="logo/cal.gif" style="border:1px solid blue;" alt="calendrier" title="calendrier"></a>
								
								 <b>Au:</b>
								 <input type="text" name="fin" id="" size="20" readonly style='width:130px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value="<?php if(!empty($_GET['fin'])) echo $_GET['fin']; ?>" />
								<a href="javascript:show_calendar('miseajour.fin');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
								<img src="logo/cal.gif" style="border:1px solid blue;" alt="calendrier" title="calendrier"></a>
								 <input type='submit' name='OK' value='OK' style='width:40px; border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;'/>
								  </span>
						 </form>
					</caption> 
					<tr style=" background-color:#FF8080;color:white;font-size:1.2em; padding-bottom:5px;">
						<td style="border-right: 2px solid #ffffff" align="center" >Num</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Date. Op&eacute;ration</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Heure</td>
						<td style="border-right: 2px solid #ffffff" align="center" >R&eacute;f. op&eacute;ration</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Op&eacute;ration</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Type d'opération</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Produit concern&eacute;</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Seuil</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Qt&eacute; en stock</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Qt&eacute; +/-</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Qt&eacute; finale</td>
						</tr>
					<?php
					//echo "SELECT ref_operation,designation_operation,designation,seuil,Qte_initiale,Qte_entree,quantite,operation.date_modification AS date_modification FROM operation,entree_sortie WHERE Entree_Sortie.reference1=operation.reference1  and designation LIKE '$produit' ORDER BY operation.numero LIMIT $premiereEntree, $prdtsParPage";
					  if(!empty($_GET['produit'])) 
						 $query_Recordset1="SELECT ref_operation,heure_operation,qte_finale,designation_operation,designation,seuil,Qte_initiale,Qte_entree,quantite,operation.date_modification AS date_modification FROM operation,entree_sortie WHERE Entree_Sortie.reference1=operation.reference1  and designation LIKE '".$_GET['produit']."' ORDER BY operation.numero LIMIT $premiereEntree, $prdtsParPage";
					  if(!empty($_GET['debut'])) 
						  $query_Recordset1="SELECT ref_operation,heure_operation,qte_finale,designation_operation,designation,seuil,Qte_initiale,Qte_entree,quantite,operation.date_modification AS date_modification FROM operation,entree_sortie WHERE Entree_Sortie.reference1=operation.reference1  and operation.date_modification BETWEEN '".$_GET['debut']."'  AND '".$_GET['fin']."'  ORDER BY operation.numero LIMIT $premiereEntree, $prdtsParPage";
						$Recordset_2 = mysql_query($query_Recordset1);
							$cpteur=1;if(!empty($_GET['i'])) $i=$_GET['i']; else  $i=0;
							while($data=mysql_fetch_array($Recordset_2))
							{	$i++;
								if($data['designation_operation'] != 'Affection de produit')
								{
									$cpteur = 0;
									$bgcouleur = "#acbfc5"; $signe="+";$type_operation="Augmentation du Stock";
								}
								else
								{
									$cpteur = 1;
									$bgcouleur = "#dfeef3";$signe="-";$type_operation="Diminution du Stock";
								}
								$connecter = new Connexion_2;
								if($connecter->testConnexion())
								{
								}
								//$qtefinale=$data['Qte_entree']+$data['qte_finale'];
								echo " 	<tr bgcolor='".$bgcouleur."'>"; 
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$i.".</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['date_modification']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['heure_operation']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['ref_operation']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['designation_operation']."</td>";
										echo " 	<td align='left' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$type_operation; if($signe=="-") echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; echo "&nbsp;[<span style='color:red;'>".$signe." </span>]</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['designation']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['seuil']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['Qte_initiale']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['Qte_entree']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['qte_finale']."</td>";

									echo " 	</tr> ";
							}
						
					?>
				</table>
			
		
	</form>
</body>	
</html>