<?php
require("menu.php");
?> 
	
<html>

	<body>
		<P align="center" style="font-weight:bold;font-size:1.2em;">
			 SYGHOC est une application développée pour le gestion hotelière
			
		</p>

		
<strong>Types d'utilisateurs définis par le système</strong><br/>
En fonction des besoins de l'hôte, trois profils d'utilisateurs ont été définis: Directrice, chef personne, comptabe,caissier<br/>
<em>Profil de la Directrice</em><br/>
Quand a Directrice se connecte au système, quatre menus s'offrent à elle: Menu Consultation, Menu Grille, Menu Opérations, Menu Aide. 
Dans le Menu Consultation, un panel d'états se trouvent en consutation à savoir: Les Recettes, La liste journalière des occupants, La liste journalière de location de Salles, La Liste des Réservations des chambres, La Liste des Réservations des salles, La Liste des impayés, La liste des montants à faire valoir.<br/>
Dans le Menu Grille, il y a La Réservations des chambres (en consultation en version moins améliorée), La Liste des Réservations (en consultation aussi), Le Planning de Réservations de chambres, Le Planning de Réservations de salles, <br/> Dans le Menu Opérations, il y a un sous menu Autorisation de Séjour<br/>Le Menu Aide est subdivisé en deux à savoir: Guide d'utiisation et A propos <br/>
<ul>
<li>Pour afficher la recette d'une période donnée (par agent), allez dans le menu <em>Consultation</em>, ensuite <em>Recette</em>, Séectionnez la période et validez</li>
<li>Pour afficher la liste des Réservations de chambres suuivant un mois donné, allez dans le Menu Grille, ensuite Réservations de chambres. Par défaut, la liste des Réservations de chambres du mois courant est affiché, pour afficher pour un autre mois(passé ou à venir), sélectionnez le mois et l'année, puis cliquez sur le bouton Afficher. Idem, Pour afficher la liste des Réservations de chambres
</li>
<li>En cliquant sur Planning de réservations des chambres (de salles) dans le menu Grille, un onglet s'ouvre, et on a une affichage de toutes les réservations de chambres(salles) du mois courant sous forme de grille de réservation. 
</li>
<li>Pour afficher le Planning de réservations des chambres (de salles) d'un mois donné autre que le mois courant, allez dans le menu Grille, Réservation de chambres(de salles). Séectionnez le mois et l'année et faites Afficher. Une fois la liste des réservations affichées, Ciquez sur le lien <em>Cliquez ici </em> en bas du tableau, 
</li>
<li>Pour afficher la liste des séjours qui demandent une autorisation, allez dans la menu Opérations, ensuite Autorisation de Séjour. En effet, Suivant les régles de gestion, aucun(e) séjour/réservation ne peut excéder quinze(15) jours. Toutefois, la Directrice, peut autoriser spécialement un séjour de plus de 15jours. Pour ce faire identifiez le client à qui l'autorisation sera accordée, ensuite double-cliquez sur le bouton Autoriser.
</li>
</ul>
<P>
		<P style="font-weight:bold;">
			
			 Enregistrement des arrivés:
			 
		</p>
			Cliquez sur Hébergement dans le menu principal. Cliquez ensuite sur arrivée. Un formulaire s'affiche, renseigner le formulaire. Cliquez ensuite sur valider, un autre formulaire s'affiche.
			faite l'attribution de chambre. choisissez la chambre , le type de chambre s'affiche. chosissez le type d'occupation le tarif s'affiche. Cliquez dans le champs du tarif ensuite dans un autre champs, les différents calculs s'affichent.
			faites le choix des différents taxes et saisissez la somme remise. ensuite cliquer sur valider.
			 
		</p>
	</body>
</html>