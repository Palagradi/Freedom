<?php
		if($_SESSION['poste']==cpersonnel)
		include 'menucp.php'; 
	   	   if($_SESSION['poste']==agent)
		include 'menuprin1.php'; 
			   if($_SESSION['poste']==directrice)
		include 'menudirec.php'; 
			   if($_SESSION['poste']==admin)
		include 'admin.php';
		include 'connexion.php';
?> 
	
<html>
	<head> 
		<title> SYGHOC </title> 
	</head>
	<body>
		<P align="center" style="font-weight:bold;font-size:1.2em;">
			 SYGHOC est une application développée pour le gestion hotelière du CODIAM 
			
		</p>
		<P style="font-weight:bold;">
			
			 Enregistrement des arrivés:
			 
		</p>
		<P>
			Cliquez sur Herbergement dans le menu principal. Cliquez ensuite sur arrivé. Un formulaire s'affiche, renseigner le formulaire. Cliquez ensuite sur valider, un autre formulaire s'affiche.
			faite l'attribution de chambre. choisissez la chambre , le type de chambre s'affiche. chosissez le type d'occupation le tarif s'affiche. Cliquez dans le champs du tarif ensuite dans un autre champs, les différents calculs s'affichent.
			faites le choix des différents taxes et saisissez la somme remise. ensuite cliquer sur valider.
			 
		</p>
	</body>
</html>