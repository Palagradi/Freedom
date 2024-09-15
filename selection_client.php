<?php
	include 'menu.php';

    mysqli_query($con,"SET NAMES 'utf8'");
	$groupe=!empty($_GET['groupe'])?$_GET['groupe']:NULL;$fiche=!empty($_GET['fiche'])?$_GET['fiche']:NULL;$fiche1=!empty($_GET['fiche1'])?$_GET['fiche1']:NULL;
	$sal=!empty($_GET['sal'])?$_GET['sal']:NULL;$numero=!empty($_GET['numero'])?$_GET['numero']:NULL;$numresch=!empty($_GET['numresch'])?$_GET['numresch']:NULL;
	$trie=!empty($_GET['trie'])?$_GET['trie']:NULL;$groupe=!empty($_GET['groupe'])?$_GET['groupe']:NULL;$groupe=!empty($_GET['groupe'])?$_GET['groupe']:NULL;

	if($trie==1) $trier= "numcli";if($trie==2) $trier= "nomcli ASC,prenomcli";
	if($trie==3) $trier= "sexe";if($trie==4) $trier= "datnaiss";
	if($trie==5) $trier= "lieunaiss";if($trie==6) $trier= "typepiece";
	if($trie==7) $trier= "numiden";if($trie==8) $trier= "date_livrais";
	if($trie==9) $trier= "lieudeliv";if($trie==10) $trier= "institutiondeliv";if($trie==11) $trier= "pays";

	$_SESSION['fiche']=$fiche;$_SESSION['groupeA']=$groupe;$_SESSION['fiche1']=$fiche1;$_SESSION['sal']=$sal;$_SESSION['numero']=$numero;$_SESSION['numresch']=$numresch;
  if(empty($sal)){ 
	$insert=" WHERE numcli <> ''";$insert2="WHERE numcli <> '' AND ";
	} else { $insert=""; 
	}
				
				?> <html>
	<head>
		<link rel="Stylesheet" type="text/css" media="screen, print" href='style.css' />
		<style type="text/css"> </style>
		<script type="text/javascript" src="js/jquery.js"></script>
	</head>
	<body> <hr noshade size=3 style='margin-top:-10px;'>
				 <form class="ajax" action="" method="get" style='margin:-10px 0;text-align:center;font-family:cambria;'>
				 <input style='' type="hidden" name="fiche" id="fiche" value="<?php echo $fiche;?>"/>
					<p align='center'>
						<label style='font-size:25px;font-weight:bold; padding:3px;color:#444739;font-family:cambria;' for="q">Rechercher
						<span style='font-size:12px;color:#777;font-style:italic;'></span></label>
						<input  style='font-style:italic;background-color:#EFFBFF;width:400px;padding:4px;border:1px solid #aaa;-moz-border-radius:7px;-webkit-border-radius:7px;border-radius:7px;height:32px;line-height:25px;' type="text" name="q" id="q" placeholder='Nom ou Prénoms'/>
					</p>
				</form>
			<hr noshade size=3>
				<style>
				form.ajax p{
					margin:20px 0;
					text-align:center;
				}
				form.ajax label{
					font-size:16px;
					font-weight:bold;
					padding:3px;
				}
				form.ajax label span{
					font-size:12px;
					color:#777;
				}
				form.ajax input{
					width:500px;
					padding:3px;
					border:1px solid #aaa;
					-moz-border-radius:7px;
					-webkit-border-radius:7px;
					border-radius:7px;
					height:22px;
					line-height:22px;
				}
				#ajax-loader{
					margin:15px auto 0 auto;
					display:block;
				}
				div.article-result{
					padding:2px 10px 10px 10px;
					margin-bottom:10px;
					border-bottom:1px solid #ccc;
				}
				div.article-result p.url{
					color:#777;
				}
				</style>
	<div id="results">
					<h3 style="text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#444739;">  LISTE DES CLIENTS <span style="font-style:italic;font-size:0.6em;color:black;">
					<span style=''> <B>
					<span style='color:red;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</B>
					<?php
					$sql="SELECT * FROM client  ".$insert." ORDER BY nomcli ASC";
					mysqli_query($con,"SET NAMES 'utf8'");
					$res=mysqli_query($con,$sql);
					$nbre=mysqli_num_rows($res);


					$reqsel=mysqli_query($con,"SELECT * FROM client ".$insert." ORDER BY nomcli ASC ");
					$nbre_client=mysqli_num_rows($reqsel);
					$clientsParPage=1000; //Nous allons afficher 5 contribuable par page.
					$nombreDePages=ceil($nbre_client/$clientsParPage); //Nous allons maintenant compter le nombre de pages.

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
					 $premiereEntree=($pageActuelle-1)*$clientsParPage;
					$res=mysqli_query($con,"SELECT * FROM client ".$insert." ORDER BY nomcli ASC LIMIT $premiereEntree, $clientsParPage");
					$nbre1=mysqli_num_rows($res);


					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span style='color:#C9001A;font-size:1.3em;'>Page :</span> "; //Pour l'affichage, on centre la liste des pages
					$k=!empty($_GET['page'])?$_GET['page']-1:NULL;
						if($k>0)
								{
								 if(!empty($fiche))
									echo ' <a href="selection_client.php?menuParent='.$_GET['menuParent'].'&fiche=1&page='.$k.'" title="Suivant" style="text-decoration:none;"> &nbsp;<<&nbsp; </a> ';
								  else  if(!empty($fiche1))
									echo ' <a href="selection_client.php?menuParent='.$_GET['menuParent'].'&fiche1=5&page='.$k.'" title="Suivant" style="text-decoration:none;"> &nbsp;<<&nbsp; </a> ';
								  else
									echo ' <a href="selection_client.php?menuParent='.$_GET['menuParent'].'&groupe=1&page='.$k.'" title="Suivant" style="text-decoration:none;"> &nbsp;<<&nbsp; </a> ';
								}
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
									echo ' <a href="selection_client.php?menuParent='.$_GET['menuParent'].'&fiche=1&page='.$i.'">'.$i.'</a> ';
								  else  if(!empty($fiche1))
									echo ' <a href="selection_client.php?menuParent='.$_GET['menuParent'].'&fiche1=5&page='.$i.'">'.$i.'</a> ';
								  else
									echo ' <a href="selection_client.php?menuParent='.$_GET['menuParent'].'&groupe=1&page='.$i.'">'.$i.'</a> ';
							 }
						}
						if(empty($_GET['page'])) $j=!empty($_GET['page'])?$_GET['page'] +2:NULL; else $j=!empty($_GET['page'])?$_GET['page'] +1:NULL;
						if($i>=$j)
								{
								 if(!empty($fiche))
									echo ' <a href="selection_client.php?menuParent='.$_GET['menuParent'].'&fiche=1&page='.$j.'" title="Suivant" style="text-decoration:none;"> &nbsp;>>&nbsp; </a> ';
								  else  if(!empty($fiche1))
									echo ' <a href="selection_client.php?menuParent='.$_GET['menuParent'].'&fiche1=5&page='.$j.'" title="Suivant" style="text-decoration:none;"> &nbsp;>>&nbsp; </a> ';
								  else
									echo ' <a href="selection_client.php?menuParent='.$_GET['menuParent'].'&groupe=1&page='.$j.'" title="Suivant" style="text-decoration:none;"> &nbsp;>>&nbsp; </a> ';
								}
					echo "<span style='display:block; float:right;align:right;font:1.2em;font-style:italic;color:#C9001A;'>".$nbre1."/".$nbre."</span>";
					?>
					</span> </span></span> </h3>
				<table align="center" width="" border="0" cellspacing="0" style="margin-top:0px;border-collapse: collapse;font-family:Cambria;">

					<tr  style=" background-color:#66858D;color:white;font-size:1.2em; padding-bottom:5px;">
						<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>
						<?php
						echo "<a class='info' href='#' style='color:white;'>Info<span style='font-size:0.8em;'>Informations complémentaires</span></a>";
						?>
						</td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info' href='selection_client.php?menuParent= <?php if(isset($_GET['menuParent']))  echo $_GET['menuParent']; if(isset($_GET['sal']))  echo "&sal=".$_GET['sal']; ?>  &
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];   if(isset($_GET['invoice'])) echo '&invoice='.$_GET['invoice'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=1' style='text-decoration:none;color:white;' title="">Num&eacute;ro<span style='font-size:0.8em;'>Trier par Numéro</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?menuParent=<?php if(isset($_GET['menuParent']))  echo $_GET['menuParent']; if(isset($_GET['sal']))  echo "&sal=".$_GET['sal'];?>&
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];  if(isset($_GET['invoice'])) echo '&invoice='.$_GET['invoice'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=2' style='text-decoration:none;color:white;' title=''>Nom et Pr&eacute;noms<span style='font-size:0.8em;'>Trier par Nom et Prénoms</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?menuParent=<?php if(isset($_GET['menuParent']))  echo $_GET['menuParent']; if(isset($_GET['sal']))  echo "&sal=".$_GET['sal'];?>&
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];   if(isset($_GET['invoice'])) echo '&invoice='.$_GET['invoice'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=3' style='text-decoration:none;color:white;' title=''>Sexe<span style='font-size:0.8em;'>Trier par Sexe</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?menuParent=<?php if(isset($_GET['menuParent']))  echo $_GET['menuParent']; ?>&
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];   if(isset($_GET['invoice'])) echo '&invoice='.$_GET['invoice'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=4' style='text-decoration:none;color:white;' title=''>Date de naissance<span style='font-size:0.8em;'>Trier par Date de naissance</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?menuParent=<?php if(isset($_GET['menuParent']))  echo $_GET['menuParent']; if(isset($_GET['sal']))  echo "&sal=".$_GET['sal'];?>&
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];   if(isset($_GET['invoice'])) echo '&invoice='.$_GET['invoice'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=5' style='text-decoration:none;color:white;' title=''>Lieu de naissance<span style='font-size:0.8em;'>Trier par Lieu de naissance</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?menuParent=<?php if(isset($_GET['menuParent']))  echo $_GET['menuParent']; if(isset($_GET['sal']))  echo "&sal=".$_GET['sal'];?>&
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];   if(isset($_GET['invoice'])) echo '&invoice='.$_GET['invoice'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=6' style='text-decoration:none;color:white;' title=''>Type de pi&egrave;ce<span style='font-size:0.8em;'>Trier par Type de pièce</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?menuParent=<?php if(isset($_GET['menuParent']))  echo $_GET['menuParent'];if(isset($_GET['sal']))  echo "&sal=".$_GET['sal']; ?>&
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];   if(isset($_GET['invoice'])) echo '&invoice='.$_GET['invoice'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=7' style='text-decoration:none;color:white;' title=''>N° de la pi&egrave;ce<span style='font-size:0.8em;'>Trier par N° de la pièce</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?menuParent=<?php if(isset($_GET['menuParent']))  echo $_GET['menuParent']; if(isset($_GET['sal']))  echo "&sal=".$_GET['sal'];?>&
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];    if(isset($_GET['invoice'])) echo '&invoice='.$_GET['invoice'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=8' style='text-decoration:none;color:white;' title=''>D&eacute;livr&eacute; le<span style='font-size:0.8em;'>Trier par Date de livraison</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?menuParent=<?php if(isset($_GET['menuParent']))  echo $_GET['menuParent']; if(isset($_GET['sal']))  echo "&sal=".$_GET['sal'];?>&
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];   if(isset($_GET['invoice'])) echo '&invoice='.$_GET['invoice'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=9' style='text-decoration:none;color:white;' title=''>Lieu de délivrance<span style='font-size:0.8em;'>Trier par Lieu de délivrance</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?menuParent=<?php if(isset($_GET['menuParent']))  echo $_GET['menuParent']; if(isset($_GET['sal']))  echo "&sal=".$_GET['sal'];?>&
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];   if(isset($_GET['invoice'])) echo '&invoice='.$_GET['invoice'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=10' style='text-decoration:none;color:white;' title=''>D&eacute;livr&eacute; par<span style='font-size:0.8em;'>Trier par institution de livraison</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?menuParent=<?php if(isset($_GET['menuParent']))  echo $_GET['menuParent']; if(isset($_GET['sal']))  echo "&sal=".$_GET['sal'];?>&
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];   if(isset($_GET['invoice'])) echo '&invoice='.$_GET['invoice'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=11' style='text-decoration:none;color:white;' title="">Pays d'origine<span style='font-size:0.8em;'>Trier par Pays d'origine</span></a></td>
						<td align="center" >Actions</td>
					</tr>


				<?php 
				 if(!empty($_GET['q'])){
					echo $_GET['q'];
					}else {
						 if($trie!='')
							     $query_Recordset1 = "SELECT * FROM client  ".$insert." ORDER BY $trier ASC LIMIT $premiereEntree, $clientsParPage";
							 else
					             $query_Recordset1 = "SELECT * FROM client  ".$insert." ORDER BY nomcli ASC LIMIT $premiereEntree, $clientsParPage";
							$Recordset_2 = mysqli_query($con,$query_Recordset1);
							$cpteur=1;
							while($data=mysqli_fetch_array($Recordset_2))
							{if($cpteur == 1)
								{
									$cpteur = 0;
									$bgcouleur = "#acbfc5";
								}
								else
								{
									$cpteur = 1;
									$bgcouleur = "#dfeef3";
								}
									$query_Recordset1 = "SELECT  max(datarriv)  AS date FROM fiche1 WHERE  numcli_1='".$data['numcli']."'";
								 $query=mysqli_query($con,$query_Recordset1);$result=mysqli_fetch_array($query);$Dvisite=substr($result['date'],8,2).'-'.substr($result['date'],5,2).'-'.substr($result['date'],0,4);
								 if(empty($result['date']))
									 {	$query_Recordset1 = "SELECT  max(datarriv)  AS date FROM fiche1 WHERE  numcli_2='".$data['numcli']."'";
										$query=mysqli_query($con,$query_Recordset1);$result=mysqli_fetch_array($query);$Dvisite=substr($result['date'],8,2).'-'.substr($result['date'],5,2).'-'.substr($result['date'],0,4);
									 }

								 $query_Recordset1 = "SELECT  count(fiche1.numfiche)  AS nbre FROM fiche1 WHERE  fiche1.numcli_1='".$data['numcli']."'";
								 $query=mysqli_query($con,$query_Recordset1);$result=mysqli_fetch_array($query); $nbre=$result['nbre'];
								 if($nbre<=0)
									 {	$query_Recordset1 = "SELECT  count(fiche1.numfiche)  AS nbre FROM fiche1 WHERE  fiche1.numcli_2='".$data['numcli']."'";
										$query=mysqli_query($con,$query_Recordset1);$result=mysqli_fetch_array($query); $nbre=$result['nbre'];
									 }
								/* 	 if(($NbreX>0)&&($frequenceX=="Mois")){
											$moisC=date('m'); $ansC=date('Y'); $Debutmois=$ansC.'-'.$moisC.'-'.'01'; $Finmois=$ansC.'-'.$moisC.'-'.'31';
											$DebutAns=$ansC.'-'.'01'.'-'.'01'; $FinAns=$ansC.'-'.'12'.'-'.'31';
											$query_Recordset2 = "SELECT  count(fiche1.numfiche)  AS nbre FROM fiche1 WHERE  fiche1.numcli_1='".$data['numcli']."' and datarriv BETWEEN $Debutmois AND $Finmois";
											$query2=mysql_query($query_Recordset2);$result=mysql_fetch_array($query2); $nbr2=$result['nbre'];
											 if($nbr2<=0)
												 {	$queryRecordset1 = "SELECT  count(fiche1.numfiche)  AS nbre FROM fiche1 WHERE  fiche1.numcli_2='".$data['numcli']."' and datarriv BETWEEN $Debutmois AND $Finmois";
													$query2=mysql_query($queryRecordset1);$result=mysql_fetch_array($query); $nbr2=$result['nbre'];
												 }
										} */
										/* 	$moisC=date('m'); $ansC=date('Y'); $Debutmois=$ansC.'-'.$moisC.'-'.'01'; $Finmois=$ansC.'-'.$moisC.'-'.'31';
											$DebutAns=$ansC.'-'.'01'.'-'.'01'; $FinAns=$ansC.'-'.'12'.'-'.'31';
											$query_Recordset2 = "SELECT  NomCat,frequence  FROM categorieclient WHERE  Nbre>='".$nbre."' ";
											$query2=mysql_query($query_Recordset2);
											 while ($ret= mysql_fetch_array($query2))
												{   $NomCat=$ret['NomCat']; $frequence=$ret['frequence'];
													if(!empty($NomCat)){
													if($frequence=="Mois")
														{
															 $query_Recordset3 = "SELECT  count(fiche1.numfiche)  AS nbre FROM fiche1 WHERE  fiche1.numcli_1='".$data['numcli']."' and datarriv BETWEEN $Debutmois AND $Finmois";
															$query3=mysql_query($query_Recordset3);$resultZ=mysql_fetch_array($query3); $nbr2=$resultZ['nbre'];if($nbre==$nbr2)$categorie=$NomCat;

														}else if($frequence=="Ans"){
															  $query_Recordset3 = "SELECT  count(fiche1.numfiche)  AS nbre FROM fiche1 WHERE  fiche1.numcli_1='".$data['numcli']."' and datarriv BETWEEN $DebutAns AND $FinAns";
															//echo  "<br/>";
															$query3=mysql_query($query_Recordset3);$resultZ=mysql_fetch_array($query3); $nbr2=$resultZ['nbre'];if($nbre==$nbr2)$categorie=$NomCat;


														}else {
															$categorie=$NomCat;
														}

													}
												} */
							//	}



								echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>";
									echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> 	<a class='info' href=''><img src='logo/logo5.png' alt='' title='' width='16' height='16' border='0'><span style='color:maroon;margin-left:-5%;'>Nbre de visite:&nbsp;".$nbre." | Dernière visite:&nbsp;".$Dvisite."<span style='color:red;margin-left:-5%;'>Catégorie :&nbsp;Client&nbsp;".$data['Categorie']."</span></span></a>";
									echo "</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['numcli']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['nomcli']." ".$data['prenomcli']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['sexe']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($data['datnaiss'],8,2).'-'.substr($data['datnaiss'],5,2).'-'.substr($data['datnaiss'],0,4)."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['lieunaiss']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['typepiece']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['numiden']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($data['date_livrais'],8,2).'-'.substr($data['date_livrais'],5,2).'-'.substr($data['date_livrais'],0,4)."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['lieudeliv']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['institutiondeliv']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['pays']."</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";

										if(($groupe==1)||($fiche==11))
											$fiche="fiche_groupe2.php";
										if(($fiche==1)||($fiche==5)||($fiche1==5)||isset($_GET['change']))
											$fiche="fiche.php";
										if($sal==1)
											$fiche="FicheS.php";
										if($fiche==2)
											$fiche="fiche2.php";
											//if(isset($_GET['change']))
												//$fiche="ChangeName.php";
										echo " 	<a class='info2' href='"; echo $fiche; echo"?menuParent=". $_GET['menuParent']."&numcli=".$data['numcli'];  if(isset($_GET['idr'])) echo "&idr=".$_GET['idr'];
										if(isset($_GET['invoice'])) echo "&invoice=".$_GET['invoice']."&state=1"; if(!empty($_GET['numfiche'])) echo "&numfiche=".$_GET['numfiche'];  if(isset($_GET['change'])) echo "&change=".$_GET['change'];
										echo "'><img src='logo/more.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.9em;color:maroon;'>Ajouter le client</span></a>";
										echo " 	</td>";
									echo " 	</tr> ";

							}
							}

?>
</div>
</table>


<script type="text/javascript">
$(document).ready( function() {
  // détection de la saisie dans le champ de recherche
  $('#q').keyup( function(){
    $field = $(this);
    $('#results').html(''); // on vide les resultats

	//document.getElementById('q').style.backgroundColor="#84CECC";
	var fiche =  document.getElementById('fiche');
    $('#ajax-loader').remove(); // on retire le loader

    // on commence à traiter à partir du 2ème caractère saisie
    if( $field.val().length > 1 )
    {  $('#resultsA').html('');
      // on envoie la valeur recherché en GET au fichier de traitement
      $.ajax({
  	type : 'GET', // envoi des données en GET ou POST
	url : 'ajax-search.php' , // url du fichier de traitement
	data : 'q='+$(this).val() , // données à envoyer en  GET ou POST
	beforeSend : function() { // traitements JS à faire AVANT l'envoi
		$field.after('<img src="logo/wp2d14cca2.gif" alt="loader" id="ajax-loader" />'); // ajout d'un loader pour signifier l'action
	},
	success : function(data){ // traitements JS à faire APRES le retour d'ajax-search.php
		$('#ajax-loader').remove(); // on enleve le loader
		$('#results').html(data); // affichage des résultats dans le bloc
	}
      });
    }
  });
});
</script>
	</body>
</html>
