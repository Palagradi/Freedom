<?php
	// pages à inclure
	session_start();
	if(isset($_SESSION['login'])){ // si le membre est connecté
		 if(isset($_SESSION['timestamp'])){ // si $_SESSION['timestamp'] existe
				 if($_SESSION['timestamp'] + 600 > time()){
						$_SESSION['timestamp'] = time();
				 }else{  header("Location: logout.php");exit();}
		 }else{ $_SESSION['timestamp'] = time(); }
	}
	require("Connexion.php");
	$connecter = new Connexion;
	if($connecter->testConnexion())
	{mysql_query("SET NAMES 'utf8'");
		$req=mysql_query("SELECT * FROM config ")or die ("Erreur de requête".mysql_error());
			while($data=mysql_fetch_array($req))
			{   $annee=$data['annee'];
			    $exercice=$data['exercice'];
				$commune_tempon =$data['commune_tempon'];
				$taux =$data['taux'];
			}
	
	if(isset($_POST['enregistrer']) && $_POST['enregistrer'] == "ENREGISTRER")
		{	
			if( !empty($_POST['choix'])){
					//echo '<pre>';
				//print_r($_POST['choix']);
				//echo '</pre>';
				//on déclare une variable
				$choix ='';
				//on boucle
				for ($i=0;$i<count($_POST['choix']);$i++)
				{	//on concatène
					$choix .= $_POST['choix'][$i].'|';
					$explore = explode('|',$choix);
					if($explore[$i]!='')
						{	$reqsel=mysql_query("SELECT * FROM entreprise WHERE commune='$commune_tempon' AND annee='$annee' AND exercice='$exercice' AND num_art=1+'".$i."'");
							while($data=mysql_fetch_array($reqsel))
							{  $loyer_annuel=$data['loyer_mensuel']*$data['nbre_mois'];  
								$impot=($loyer_annuel-(0.3*$loyer_annuel)-0.1*(0.6*$loyer_annuel));
								  $DS=$impot*($taux/100);	//echo "-".$explore[$i]."<br/> ";					
							}
								if($explore[$i]<= $DS)	
									{ $etat=5;
									  $reqsel=mysql_query("UPDATE entreprise SET acompte_verse='".$explore[$i]."' WHERE num_art=1+'".$i."'");										
									}
								else{  $etat=6;								
									}									
						}		
				}
			if( $etat==6){
				echo "<script language='javascript'>"; 
				echo " alert('L\'avance sur l'acompte ne doit pas être supérieur au montant du Droit simple');";
				echo "</script>";
			}				
			}
			
				if( !empty($_POST['choix1'])){
				$choix1 ='';
				for ($i=0;$i<count($_POST['choix1']);$i++)
				{	$choix1 .= $_POST['choix1'][$i].'|';
					$explore1 = explode('|',$choix1);
					if($explore1[$i]!='')				
						{	if($explore1[$i]<=100)
								{$reqsel1=mysql_query("UPDATE entreprise SET penalite_montant='".$explore1[$i]."' WHERE num_art=1+'".$i."'");	
								 $etat=4;
								}
							else
							{ $etat=3;
							}	 					
						}						
				}	
			}
			if( $etat==3){
				echo "<script language='javascript'>"; 
				echo " alert('Le taux de pénalité ne doit pas dépassé 100');";
				echo "</script>";
			}

								
			if( !empty($_POST['choix2'])){
				$choix2 ='';
				for ($i=0;$i<count($_POST['choix2']);$i++)
				{	$choix2 .= $_POST['choix2'][$i].'|';
					$explore2 = explode('|',$choix2);
					if($explore2[$i]!='')			
						$reqsel2=mysql_query("UPDATE entreprise SET penalite_acompte='".$explore2[$i]."' WHERE num_art=1+'".$i."'");	
				}		
			}
			if(( (!empty($_POST['choix3'])&& isset($_POST['choix3']))||(!empty($_POST['choix4'])&& isset($_POST['choix4']))) && isset($_POST['choix0'])){
				//echo '<pre>';
				//print_r($_POST['choix0']);
				//echo '</pre>';
				//on déclare une variable
				$choix0 ='';
				//on boucle
				for ($i=0;$i<count($_POST['choix0']);$i++)
				{
				//on concatène
				$choix0 .= $_POST['choix0'][$i].'|';
				$explore0 = explode('|',$choix0);
					//echo $i."<br/>";
					//echo $explore0[$i];
				if(!empty($_POST['choix3']))
					$reqsel4=mysql_query("UPDATE entreprise SET penalite_montant='".$_POST['choix3']."' WHERE num_art='".$explore0[$i]."'");
				if(!empty($_POST['choix4']))
					$reqsel5=mysql_query("UPDATE entreprise SET penalite_acompte='".$_POST['choix4']."' WHERE num_art='".$explore0[$i]."'");						
				}
			}			
			
			if(($reqsel)||($reqsel1)||($reqsel2)||($reqsel3)||($reqsel4)||($reqsel5))
				{	echo "<script language='javascript'>"; 
					echo " alert('Les modifications ont été prises en compte');";
					echo "</script>";
				}
			
			//else{
				//echo 'Vous n\'avez rien sélectionné';
			//}
		}
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>TPS - TAXE PROFESSIONNELLE SYNTHETIQUE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>	
			<script type="text/javascript" src="js/fonctions_utiles.js"></script>	
	</head>
	<body bgcolor="#99B5B6">   <form action="" method="POST"> 
				<?php
						$reqsel=mysql_query("SELECT * FROM entreprise WHERE commune='$commune_tempon' AND annee='$annee' AND exercice='$exercice' ORDER BY num_art  DESC ");
						$nbre_entreprise=mysql_num_rows($reqsel);
						$entreprisesParPage=50; //Nous allons afficher 5 entreprise par page.
						$nombreDePages=ceil($nbre_entreprise/$entreprisesParPage); //Nous allons maintenant compter le nombre de pages.
						 
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
						$premiereEntree=($pageActuelle-1)*$entreprisesParPage;

					?>
					<table align='center' width=""  border="0" cellspacing="0" style="margin-top:40px;border-collapse: collapse;font-family:Cambria;">
					<caption style="text-align:left;text-decoration:none; font-family:Cambria;margin-bottom:5px;">  <span style='font-weight:bold;font-size:1.3em;color:#8F0059;'>Liste des entreprises </span><span style='font-size:0.9em;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php
						echo "<div style='float:right;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Page : "; //Pour l'affichage, on centre la liste des pages
						for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
						{
							 //On va faire notre condition
							 if($i==$pageActuelle) //Si il s'agit de la page actuelle...
							 {
								 echo ' [ '.$i.' ] '; 
							 }	
							 else //Sinon...
							 {
								  echo ' <a href="liste_contribuable.php?all=true&page='.$i.'">'.$i.'</a> ';
							 }
						}
						echo "  </div>";
						
					?></caption> 
					  
					<tr style=" background-color:#103550;color:white;font-size:1em; padding-bottom:5px;">
						<td  style="border-right: 2px solid #ffffff" align="center" > Choix</td> 
						<td  style="border-right: 2px solid #ffffff" align="center" >N° Enrég.</td>
						<td  style="border-right: 2px solid #ffffff" align="center" >Nom et prénoms</td>
						<td  style="border-right: 2px solid #ffffff" align="center" >N° IFU</td>
						<td  style="border-right: 2px solid #ffffff" align="center" >Raison sociale</td>
						<td  style="border-right: 2px solid #ffffff" align="center">Q</td>
						<td  style="border-right: 2px solid #ffffff" align="center">I</td>
						<td  style="border-right: 2px solid #ffffff" align="center">P</td>
						<td  style="border-right: 2px solid #ffffff" align="center">NC</td>
						<td  style="border-right: 2px solid #ffffff" align="center">L. mensuel</td>
						<td  style="border-right: 2px solid #ffffff" align="center">Base d'impo</td>
						<td  style="border-right: 2px solid #ffffff" align="center">Montant à verser</td>
						<td  style="border-right: 2px solid #ffffff" align="center">Pénalité (en %)</td>
						<td  style="border-right: 2px solid #ffffff" align="center">Acompte DS</td>
						<td  style="border-right: 2px solid #ffffff" align="center">Acompte Pénalité</td>						
					</tr>

			
					<?php
					
					$req=mysql_query("SELECT * FROM config ")or die ("Erreur de requête".mysql_error());
					while($data=mysql_fetch_array($req))
					{   $annee=$data['annee'];
						$exercice=$data['exercice'];
						$commune_tempon =$data['commune_tempon'];
						$taux =$data['taux'];
					}

							$cpteur=1;
							$reqsel=mysql_query("SELECT * FROM entreprise WHERE commune='$commune_tempon' AND annee='$annee' AND exercice='$exercice'");
							while($data=mysql_fetch_array($reqsel))
							{  $loyer_annuel=$data['loyer_mensuel']*$data['nbre_mois'];  
								$impot=($loyer_annuel-(0.3*$loyer_annuel)-0.1*(0.6*$loyer_annuel));
							    $DS=$impot*($taux/100);
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
										echo"   <td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>"; echo  "<input type='checkbox' name='choix0[]' value='".$data['num_art']."'> "; echo "</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$data['num_art']."</td>";
										echo " 	<td align='left' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$data['Nom']."&nbsp;&nbsp;".$data['prenoms']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['ifu']."</td>";
										echo " 	<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['Rsociale']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['Q']."</td>";
									    echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$data['I']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' >".$data['P']."</td>";
										echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['NC']."</td>";
										echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data['loyer_mensuel']."</td>";
										echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$impot."</td>";
										echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$DS."</td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";	echo " <input  type='text' name='choix1[]' style='width:100px;background-color:#DFEEF3;text-align:center;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value='".$data['penalite_montant']."' maxlength='3' onkeypress='testChiffres(event);' /></td>";
										echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><input  type='text' name='choix[]' style='width:100px;background-color:#E5E5E5;text-align:center;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'value='".$data['acompte_verse']."' onkeypress='testChiffres(event);'/></td>";
										echo " 	<td align='center' style='border-top: 2px solid #ffffff'><input  type='text' name='choix2[]' style='width:100px;background-color:#E5E5E5;text-align:center;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'value='".$data['penalite_acompte']."' onkeypress='testChiffres(event);'/>";
										echo " 	</td>";
									echo " 	</tr> ";
							}
					?>
				</table>
					<table>
						<tr>
							<td style="padding-left:50px;" >	<br/> <input type="submit" value="ENREGISTRER" id="" class="les_boutons"  name="enregistrer" style="margin-bottom:5px;border:2px solid #8F0059;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;"/> </td>
							<td >&nbsp;&nbsp;<br/> <input type="reset" value="ANNULER" class="les_boutons"  name="Annuler" style="margin-bottom:5px;border:2px solid #8F0059;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;"/> </td>
						</tr>
					</table>
			</form>		
	</body>
</html>
<?php

?>