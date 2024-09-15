<?php
include_once'menu.php';
/* 	// automatisation de la r&eacute;f&eacute;rence
	function random($car) {
		$string = "REF";
		$chaine = "0123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
		}
		return $string;
		} */
	$reqsel=mysqli_query($con,"SELECT MAX(numero) AS Numop FROM operation ");
	$data=mysqli_fetch_assoc($reqsel);$Numop=1+$data['Numop'];if(($Numop>=0)&&($Numop<=9))$Numop='REF0000'.$Numop ;else if(($Numop>=10)&&($Numop<=99))$Numop='REF000'.$Numop ;else if(($Numop>=100)&&($Numop<=999)) $Numop='REF00'.$Numop ;	else if(($Numop>=1000)&&($Numop<=1999))	$Numop='REF0'.$Numop ;else $Numop='REF'.$Numop;

/* 		
		$reqsel=mysqli_query($con,"SELECT numero FROM operation");
	while($data=mysqli_fetch_array($reqsel))
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
		$update=mysqli_query($con,$query);
		} */	
		
		
/* 		$sql2=mysqli_query($con,"SELECT ref_operation,designation_operation,designation,seuil,Qte_initiale,Qte_entree,operation.date_modification AS date_modification FROM operation,entree_sortie WHERE Entree_Sortie.reference1=operation.reference1  AND operation.date_modification='".date('d-m-Y')."' ORDER BY designation ");
		$data="";
 		while($row=mysqli_fetch_array($sql2))
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
		} */
			
		
		if(isset($_POST['ENREGISTRER'])&& ($_POST['ENREGISTRER']=='Enrégistrer')) 
		{ 	$designation=$_POST['designation']; $quantite_entree=!empty($_POST['quantite'])?$_POST['quantite']:1;
			mysqli_query($con,"SET NAMES 'utf8'");
			$reqsel=mysqli_query($con,"SELECT ref_operation  FROM operation WHERE ref_operation='".$_POST['r_operation']."'");
			$nbre=mysqli_num_rows($reqsel);
			if($nbre<=0){
			$reqsel=mysqli_query($con,"SELECT Qte_Stock FROM produits WHERE Num='".$designation."'");
			$nbre=mysqli_num_rows($reqsel);
			while($data=mysqli_fetch_array($reqsel))
			{   $quantite=$data['Qte_Stock'];
			} 
			if($_POST['TypeOp']==1) { $TypeOp="Diminution du Stock"; $quantite_entree=(-$quantite_entree);} else $TypeOp="Augmentation du Stock";
			$quantiteF=$quantite+$quantite_entree; $operation=$TypeOp."|".$_POST['motif'];  
			$re="INSERT INTO operation VALUES(NULL,'".$_POST['r_operation']."','".$operation."','".$designation."','".$quantite."','".$quantite_entree."','".$quantiteF."','".$Jour_actuel."','".$Heure_actuelle."','','".abs($quantite_entree)."')"; 
			$reqsup = mysqli_query($con,$re) or die(mysqli_error($con));
			$test = "UPDATE produits SET Qte_Stock=Qte_Stock+'".$quantite_entree."',StockReel=StockReel+'".$quantite_entree."' WHERE Num='".$designation."' ";
			$reqsup = mysqli_query($con,$test) or die(mysqli_error($con));
			//$update=mysqli_query($con,"UPDATE configuration_facture SET num_operation=num_operation+1  WHERE num_operation!=''");
/* 			$msg="<span style='color:#EF332A;font-style:italic;'>L'op&eacuteration a &eacute;t&eacute; enregistr&eacute;e avec succès</span>";
			echo "<script language='javascript'>"; 
			echo " alert('L'opération a été enregistrée avec succès.');";
			echo "</script>";
			$msg1="Retour";
			}
			echo '<meta http-equiv="refresh" content="1; url=miseajour.php" />';  */
			
			if($reqsup)
				{echo "<script language='javascript'>";
				 //echo "var quantite = '".$qteAffecte."';"; 
				 //echo "var designation = '".$designation."';"; 
				// echo "var service = '".$service."';"; 
				 echo 'alertify.success("Mise à jour effectuée");';
				 echo "</script>";
				}
			}
		 
		 }

	$idr = isset($_POST['TypeOp'])?$_POST['TypeOp']:NULL; 
	
	$idr2 = isset($_POST['TypePrdts'])?$_POST['TypePrdts']:NULL; 
	
	$idr3 = isset($_POST['motif'])?$_POST['motif']:NULL; 	

?>
<html>
	<head> 
	<script type="text/javascript" src="js/fonctions_utiles.js"></script>
	<link rel="Stylesheet" href='css/table.css' />
		<style type="text/css">
		.div1 {
		width: 50px;
		overflow: hidden;
		}
		</style>
		<script type="text/javascript">  
		var timer1;
		function scrollDiv(divId, depl) {
		   var scroll_container = document.getElementById(divId);
		   scroll_container.scrollTop -= depl;
		   timer1 = setTimeout('scrollDiv("'+divId+'", '+depl+')', 20);
		}
		</script>
	</head>
	<body bgcolor='azure' style="">
	<div align="" style="">
		<div align="center" style="padding-top:0px;">
			<form action="" method="POST" name='miseajour?menuParent=<?php echo $_SESSION['menuParenT']; ?>' id="chgdept"> 
				<table width="750" height="" border="0" cellpadding="0" cellspacing="0"  id='tab' >
					<tr>
						<td colspan="2">
							<h3 style='text-align:center; font-family:Cambria;color:maroon;font-weight:bold;'>ENREGISTREMENT - D'UNE OPERATION</h3>
						</td>
					</tr>
					<tr style='background:#EFECCA;'>
						<td colspan='2'><hr/>
						</td>
					</tr>
					<tr><td> 
					<table ALIGN='CENTER' height="" cellpadding="8" cellspacing="8">					
					<tr>
						<td colspan="2" style="" >R&eacute;f&eacute;rence de l'op&eacute;ration :</td>
						<td colspan="2"><input type="text" id="" name="r_operation" readonly value="<?php echo $Numop;	?>" style="width:200px;"/> </td>
					</tr>
					

						<?php 
						if(isset($idr)&& !empty($idr)) {
						echo "<input readonly type='hidden' name='TypeOp' value='".$idr."' style='width:200px;' >";
						//	   else echo "<input readonly type='text' name='TypeOp' value='Augmentation du Stock' style='width:200px;'>";
						}else {
						?>
						<tr>
						<td colspan='2' style=''> Type de l'op&eacute;ration : </td>
						<td colspan='2'>	
						<select name='TypeOp' required='required' style='font-family:sans-serif;font-size:80%;width:200px;'  onchange="document.forms['chgdept'].submit();">
						<option value=''></option>
						<option value='1'> Diminution du Stock </option>
						<option value='2'> Augmentation du Stock </option> 
						</select>
						</td>
					</tr><?php } ?>
					<tr>
						<td colspan="2" style=""> Motif de l'op&eacute;ration : <span style="font-style:italic;font-size:0.8em;color:#ACBFC5;"></span></td>
						<td colspan="2"><input type="text" id="" name="motif" required='required' style="width:200px;" value='<?php echo $idr3; ?>' placeholder=" Raison qui justifie l'opération..."/> </td>
					</tr>
					<tr>
						<td colspan="2" style=""> Type de produits : </td>
						<td colspan="2">
						<select name='TypePrdts' required='required' style='font-family:sans-serif;font-size:80%;width:200px;' onchange="document.forms['chgdept'].submit();">
						<option value='<?php if(isset($idr2)&& !empty($idr2)) echo $idr2; ?>'><?php if(isset($idr2)&& !empty($idr2)) { if($idr2==1) echo "Produits Vendables"; else echo "Produits Non Vendables"; }  ?></option>
						<option value='1'> Produits Vendables </option>
						<option value='2'> Produits Non Vendables </option>
						</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="">Produit concern&eacute; : </td>
						<td colspan="2">
						<select name="designation" required='required' style="width:200px;font-family:sans-serif;font-size:80%;" >
							<?php
								echo "<option value=''></option>";
								if(isset($idr2)&& !empty($idr2)) {  
									mysqli_query($con,"SET NAMES 'utf8'");
									$req1=mysqli_query($con,"SELECT Num,Designation FROM produits WHERE TypePrdts='".$idr2."'")or die ("Erreur de requête".mysql_error());
									while($data=mysqli_fetch_array($req1))
									{    
										echo" <option value ='".$data['Num']."'> ".$data['Designation']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option> ";
									}
								} 
							?>
						</select>
						</td>
					</tr>
					 <?php if(isset($idr)&& !empty($idr)) { if($idr==1) $var="diminuer "; else $var="augmenter"; ?>
					<tr>
						<td colspan="2" style=""> Quantit&eacute;e &agrave; <span style='color:maroon;'> <?=$var ?> : </span> <span style="font-style:italic;font-size:0.8em;color:#ACBFC5;"></span></td>
						<td colspan="2"><input type="number" name="quantite" min='1'  style="width:200px;font-family:sans-serif;font-size:80%;" onkeypress='testChiffres(event);' placeholder='1'/> </td>
					</tr>
					 <?php } ?>
					<tr style=''>
						<td colspan='2'>&nbsp;
						</td>
					</tr>
					<tr>
						<td colspan="2" align="right" > <input type="submit" value="Enrégistrer" id="" class="bouton2"  name="ENREGISTRER" style=""/> </td>
						<td colspan="2">&nbsp;&nbsp;<input type="reset" value="Annuler" class="bouton2"  name="Annuler" style=""/> </td>
					</tr>
					</td>
					</tr>
				</table>&nbsp;
				</table>
		</div>
			<?php
			echo "<table align='center' style='border:0px solid black;'> <tr> <td style='font-weight:bold;'>";
		   if(isset($msg)) echo $msg;
			echo " </td>
			</tr></table>";
			?>
			<span style='display:block;float:right;right:0px;font-size:95%;'>
			<a style= 'text-decoration:none;' href="javascript:void(0)" onmouseover="scrollDiv('MyDiv', 3)" onmouseout="clearTimeout(timer1)">Haut </a> | 
			<a style= 'text-decoration:none;' href="javascript:void(0)" onmouseover="scrollDiv('MyDiv', -3)" onmouseout="clearTimeout(timer1)">Bas</a>
			</span>
			<div id='MyDiv' style='width: 100%; height: 100%; border: 0px solid; overflow: hidden;'>
				<table id='' align="center" width="" border="0" cellspacing="0" style="margin-top:20px;border-collapse: collapse;font-family:Cambria;">
					<tr><td colspan='11' > <span style="font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#4C767A;" > Liste des op&eacute;rations <span style="font-style:italic;font-size:0.7em;color:black;"> 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php
					//$connecter= new Connexion_2;
					 //if($connecter->testConnexion())
					//{
					$reqsel=mysqli_query($con,"SELECT ref_operation,designation_operation,designation,seuil,Qte_initiale,Qte_entree,quantite,operation.date_modification AS date_modification FROM operation,entree_sortie WHERE Entree_Sortie.reference1=operation.reference1  ORDER BY operation.numero ");
					$nbre_prdts=mysqli_num_rows($reqsel);
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
					
					if($nbre_prdts> $prdtsParPage ) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span style='color:red;'>Page :</span> "; //Pour l'affichage, on centre la liste des pages
						if(isset($_GET['page'])) $k=$_GET['page'] -1; if(empty($_GET['page'])) $T=50; else $T=$_GET['i']-50;
					if(isset($k) && ($k>0))
						echo ' <a href="miseajour.php?page='.$k.'&i='.$T.'" title="Précédent" style="text-decoration:none;">  &nbsp;&nbsp;<<&nbsp;&nbsp;  </a> ';
						
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
									echo ' <a href="miseajour.php?page='.$i.'&i=0">'.$i.'</a> ';
								  else 
									echo ' <a href="miseajour.php?page='.$i.'&i=0">'.$i.'</a> ';
							 }
						}
						if(isset($_GET['page'])) $j=$_GET['page'] +1; //else {    $j=$_GET['page'] +2; } 
						if(empty($_GET['page'])) $T=50; else $T=50*$_GET['page'];
						if((isset($i)&& isset($j)) && ($i>=$j))
							echo ' <a href="miseajour.php?page='.$j.'&i='.$T.'" title="Suivant" style="text-decoration:none;">  &nbsp;&nbsp;>>&nbsp;&nbsp;  </a> ';
					//}
					?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<form class="ajax" action="" method="get" >

					</form>
					<form action='search.php' method='post'  name='miseajour' style='float:right;'>
					
							<!-- <b>Du:</b>
							 <input type="date" name="debut" id="" size="20"     style='width:130px; border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value='<?php if(!empty($_GET['debut'])) echo $_GET['debut']; ?>' />
						
							
							 <b>Au:</b>
							 <input type="date" name="fin" id="" size="20"  style='width:130px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value="<?php if(!empty($_GET['fin'])) echo $_GET['fin']; ?>'" />
							  </span>  !-->
					 </form>

					</span>
					</td> </tr> 
					<tr style=" background-color:#3EB27B;color:white;font-size:1.2em; ">
						<td style="border-right: 2px solid #ffffff" align="center" >Num</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Date</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Heure</td>
						<td style="border-right: 2px solid #ffffff" align="center" >&nbsp;R&eacute;férence&nbsp;</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Type d'opération</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Motif de l'op&eacute;ration</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Produit concern&eacute;</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Seuil</td>
						<td style="border-right: 2px solid #ffffff" align="center" >&nbsp;Stock&nbsp;</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Qt&eacute; +/-</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Qt&eacute; finale</td>
						</tr>
					<?php
					  // $connecter= new Connexion_2;
					 //  if($connecter->testConnexion())
					 // {	
					mysqli_query($con,"SET NAMES 'utf8'");
						if (isset($_POST['ok'])&& $_POST['ok']=='Rechercher') 
							{    $edit4=trim(addslashes($_POST['edit4'])); $_SESSION['produit']=trim(addslashes($_POST['edit4']));
								 $query_Recordset1 = "SELECT ref_operation,heure_operation,qte_finale,designation_operation,designation,seuil,Qte_initiale,Qte_entree,quantite,operation.date_modification AS date_modification FROM operation,entree_sortie WHERE designation LIKE '$edit4%' AND Entree_Sortie.reference1=operation.reference1  ORDER BY operation.numero   ASC LIMIT $premiereEntree, $prdtsParPage";
							}
						else
					   $query_Recordset1 = "SELECT ref_operation,heure_operation,qte_finale,designation_operation,designation,seuil,Qte_initiale,Qte_entree,Qte_Stock,operation.date_modification AS date_modification FROM operation,produits WHERE produits.Num=operation.reference1 ";
					   $query_Recordset1 .="AND (designation_operation LIKE 'Augmentation du Stock%' OR designation_operation LIKE 'Diminution du Stock%' ) ORDER BY operation.numero ASC ";
					   $Recordset_2 = mysqli_query($con,$query_Recordset1);
							$cpteur=1; if(!empty($_GET['i'])) $i=$_GET['i']; else  $i=0;
							while($data=mysqli_fetch_array($Recordset_2))
							{	$i++;
								$explore = explode('|',$data['designation_operation']);
								
								if($explore[0] == 'Augmentation du Stock')
								{
									$cpteur = 0;
									$bgcouleur = "#DDEEDD"; $signe="+";$type_operation="Augmentation du Stock";
								}
								else
								{
									$cpteur = 1;
									$bgcouleur = "#dfeef3";$signe="-";$type_operation="Diminution du Stock";
								}

								//$qtefinale=$data['Qte_entree']+$data['qte_finale'];
								echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>"; 
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$i.".</td>"; 
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($data['date_modification'],8,2).'-'.substr($data['date_modification'],5,2).'-'.substr($data['date_modification'],0,4)."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['heure_operation']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['ref_operation']."</td>";
										echo " 	<td align='left' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$type_operation; if($signe=="-") echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; echo "&nbsp;[<span style='color:red;'>".$signe." </span>]</td>";
										echo " 	<td align='left' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$explore[1]."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['designation']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['seuil']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['Qte_initiale']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['Qte_entree']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['qte_finale']."</td>";

									echo " 	</tr> ";
							}
						//}
					?>
				</table></div>
	</form>		
		
	</div>
</body>	
</html>