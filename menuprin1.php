<?php
session_start(); $heure_actuelle = date('H'); 
function Acueil()
	{
		if ($_GET['a']!=1) 
		{
			echo"<div style='float:left; border:1px solid red; '>
				ghgfhjfh
			</div>
			<div  style='border:1px solid red; width:300px; margin-left:100px; '>
				$content_middle
			</div>";
		}
	}

$titre = <<<TITRE
SYGHOC
TITRE;
$css = <<<CSS
<link rel="Stylesheet" type="text/css" media="screen, print" href='style.css' /> 
CSS;
$left = <<<HTML
	<div id="left" class="left">
		
		<table width='100%' align='center'> <tr> <td> 
		<div id="left_bottom" class="pd_menu_01 ">
			<ul>
				<li>	<a href="#"><img title='' src='logo/fichier.png' alt='' width='15' height='20' style='margin-top:5px;float:left;' />FICHIER</a>
					<ul>
						<li><a href="client.php?a=1">Client</a></li>
						<li><a href="groupe.php">Groupe</a></li>
					</ul>
				</li>
			</ul>
			<ul>
				<li>	<a href="#"><img title='' src='logo/Hebergement.png' alt='' width='15' height='20' style='margin-top:4px;float:left;' />HEBERGEMENT</a>
					<ul>
						<li><a href="fiche.php">Entrée</a></li>
						<li><a href="sortie.php">Sortie</a></li>
						<li><a href="impression.php">Impression de fiche</a></li>
					</ul>
				</li>
			</ul>

			<ul>
				<li>	<a href="reservationch2.php"><img title='' src='logo/Reservation.png' alt='' width='19' height='22' style='margin-top:3px;margin-left:-6px;float:left;' />GESTION DES RESERVATIONS</a>
				</li>
			</ul>
			<ul>
				<li>	<a href="#"><img title='' src='logo/Location.png' alt='' width='19' height='22' style='margin-top:3px;margin-left:-4px;float:left;' />LOCATION</a>
					<ul>
						<li><a href="fiche_1.php?sal=1">Entrée</a></li>
						<li><a href="sortie1.php?sal=1">Sortie</a></li>
					</ul>
				</li>
			</ul>
			<ul>
				<li><a href="#"><img title='' src='logo/Consultation.png' alt='' width='19' height='22' style='margin-top:3px;margin-left:-4px;float:left;' />CONSULTATION</a>
					<ul>
						<li><a href="lgroupe.php" target='' class="lastone">Liste des Groupes  </a></li>
						<li><a href="lclient.php" target='' class="lastone">Liste des Clients </a></li>
						<li><a href="loccup.php"  target='' class="lastone">Liste Journali&egrave;re des Occupants  </a></li>
						<li><a href="loccup.php?sal=1"  target='' class="lastone">Liste Journali&egrave;re de location de salles  </a></li>
						<li><a href="recette2.php?agent=1"  class="lastone">Recette journalière</a></li>
						<li><a href="grch3.php" >Liste de réservation des Chambres </a></li>
						<li><a href="grch3.php?sal=1"  class="lastone">Liste de réservation des salles </a></li>
						<li><a href="Ecris_Texte.php?val=1"  class="lastone">Liste des impay&eacute;s </a></li>
						<li><a href="Ecris_Texte.php?val=2"   class="lastone">A Faire Valoir </a></li>
						
					</ul>
				</li>
			</ul>
			<ul>
				<li><a href="#"><img title='' src='logo/Facturation.png' alt='' width='19' height='22' style='margin-top:4px;margin-left:-4px;float:left;' />FACTURATION</a>
					<ul>
						<li><a href="reediter_facture.php"  class="lastone">Réediter une facture </a></li>	
						<li><a href="">Clôturer sa caisse</a></li>	
						<li><a href="journal.php">Journal Encaissement</a></li>						
					</ul>
				</li>
			</ul>
			<ul>
				<li><a href="#"><img title='' src='logo/Grille.png' alt='' width='19' height='22' style='margin-top:4px;margin-left:-4px;float:left;' />GRILLE</a>
					<ul>
						<li><a href="planning_php.php?cham=1">Réservation Chambre </a></li>
						<li><a href="planning_php.php?sal=1"  class="lastone">Réservation des salles </a></li>
						<li><a href="planning.php" target='cible'>Planning de réservation des Chambres </a></li>
						<li><a href="planning_Salle.php"  target='cible' class="lastone">Planning de réservation des salles </a></li>
					</ul>
				</li>
			</ul>
			<ul >
				<li><a href="#"><img title='' src='logo/Modification.png' alt='' width='19' height='22' style='margin-top:4px;margin-left:-4px;float:left;' />MODIFICATION</a>
					<ul>
						<li><a href="planning_php.php?cham=2">Réservation Chambre </a></li>
						<li><a href="planning_php.php?sal=2">Réservation Salle  </a></li>
						<li><a href="modifclient.php"  >Renseignements client</a></li>
						<li><a href="modifgroupe.php"  >Informations de groupe</a></li>
						<li><a href="modifpass.php"  >Mot de passe</a></li>
					</ul>
				</li>
			</ul>
			<ul>
				<li><a href="#"><img title='' src='logo/Aide.png' alt='' width='19' height='22' style='margin-top:4px;margin-left:-4px;float:left;'/>AIDE</a>
					<ul>
						<li><a href="config1.php"  class="lastone">Configurations </a></li>
						<li><a href="aide.php" target='cible' class="lastone">Guide d'utilisation </a></li>						
					</ul>
				</li>
			</ul>
						
			<form action='deconnexion.php' method='post'> 
			<ul style="float:right; border:0px;">
				<li style="border:0px;"> <a href="#"><span style="color:black;">Connecté:</span> <span style="color:white;font-style:italic;">{$_SESSION['login']}</span></a></li>
				<li style="border:0px;font-style:bold;"><a><input type='submit' name='dec' style='border:2px solid black;font-weight:bold;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value='Déconnexion'/></a></li>
			</ul>
			</form>
		</div> 
		</td> </tr> </table> 
		
	</div>
HTML;
$content_middle= <<<HTML
	
	<div id="content" class="content_middle" style='border:0px solid red; width:300px; margin-left:3px; '>
		
	</div>
HTML;

$content = <<<HTML
	<div>
		<div>
			$left
		</div>
		<div>
			<div style='float:left; border:0px solid red; '>
				
			</div>
				
				$content_middle
		</div>
	</div>
	
HTML;
$lapage = <<<PAGE
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
		<title>{$titre}</title>
		{$css}
		<link rel="shortcut icon" type="image" href="logo/codi.jpg" />
	</head>
	<body bgcolor="{$_SESSION['fond']}"  >
	
	$content
	</body>
</html>
PAGE;
echo $lapage;

 $jour=date('d');$mois=date('m');
 include 'connexion.php';  
	$reqse2=mysql_query("SELECT num_fact from configuration_facture ");
	while($data2=mysql_fetch_array($reqse2))
		{	$num_fact= $data2['num_fact'];
		}
 if(($jour=='01')&&($mois=='01')&&($num_fact>500))
 {	$res=mysql_query('update configuration_facture set num_fact=0 WHERE num_fact!=0');
 }

include 'connexion.php';
$res=mysql_query('CREATE TABLE IF NOT EXISTS reservation_tempon (
jour VARCHAR( 10) NOT NULL, num_reserv VARCHAR( 25)
) ENGINE = InnoDB ');
$res2=mysql_query('CREATE TABLE IF NOT EXISTS reservation_tempon2 (
jour VARCHAR( 10) NOT NULL, num_reserv VARCHAR( 25)
) ENGINE = InnoDB ');
?>