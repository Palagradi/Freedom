<?php
include_once 'menu.php';

/* 	$sql="SELECT ListeProduits,numero FROM plat WHERE ListeProduits <> '' ";
	$reqselz=mysqli_query($con,$sql);
	$produits = mysqli_fetch_all($reqselz, MYSQLI_ASSOC);
	foreach ($produits as $produit): 
	$ListeProduits = explode("|", ($produit['ListeProduits']) ?? "");
	for($j=0;$j<count($ListeProduits);$j++)
	{ 	if($ListeProduits[$j]!=''){
		$sqlt="SELECT Num AS produit_id,UniteStockage
		FROM produits
		WHERE  num= '".$ListeProduits[$j]."'";  
		$reqselt=mysqli_query($con,$sqlt);$dataz=mysqli_fetch_object($reqselt); 
		$sqltz="INSERT INTO plat_produit SET 
		id_plat='".$produit['numero']."',
		id_prd='".$dataz->produit_id."',
		unite='".$dataz->UniteStockage."'"; //echo "<br/>";
		$reqselzt=mysqli_query($con,$sqltz);	
		}
	}
	endforeach; */	

$sql_categorie = "SELECT * FROM categorieplat";  // Table contenant les catégories
$req_categories = mysqli_query($con, $sql_categorie);
$categories = mysqli_fetch_all($req_categories, MYSQLI_ASSOC);

$sql = "SELECT * FROM plat WHERE ListeProduits <> '' ORDER BY numero DESC LIMIT 1";  // Récupère le dernier plat ajouté
$reqk = mysqli_query($con, $sql);

if ($reqk) {
    $lastPlat = mysqli_fetch_assoc($reqk); // Récupère le dernier plat sous forme de tableau associatif
} else {
    echo "Erreur dans la requête : " . mysqli_error($con);
}

$sql = "SELECT * FROM plat";  // Récupère tous les plats.
$req_all = mysqli_query($con, $sql);
$plats=$req_all->fetch_all(MYSQLI_ASSOC);

// Récupérer toutes les unités de mesure depuis la base de données
 $sql = "SELECT  catPrd, id FROM UniteStockage"; // Table contenant les unités de mesure
$req_unites = mysqli_query($con, $sql);

if ($req_unites) {
    $unites_mesure = mysqli_fetch_all($req_unites, MYSQLI_ASSOC); // Récupérer les unités de mesure sous forme de tableau associatif
} else {
    echo "Erreur dans la requête des unités de mesure : " . mysqli_error($con);
}

$sql = "SELECT from_unit,to_unit,conversion_factor, id FROM unit_conversions"; // Table contenant les unités de mesure
$req_unites2 = mysqli_query($con, $sql);
if ($req_unites2) {
    $unites_mesure2 = mysqli_fetch_all($req_unites2, MYSQLI_ASSOC); // Récupérer les unités de mesure sous forme de tableau associatif
} else {
    echo "Erreur dans la requête des unités de mesure : " . mysqli_error($con);
}
?>

<html>
    <head>
        <link href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
        <link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
        <link rel="Stylesheet" href='css/table.css' />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f0f2f5;
                margin-top: 30px;
            }
            .card {
                margin-bottom: 30px; 
            }
            .container {
                min-width: 800px;
            }
            .form-group {
                margin-bottom: 15px;
            }
            .card-body {
                padding: 25px;
            }
            #produitsSection {
                border-radius: 0 0 15px 15px;
                border: 1px solid #ddd;
				padding: 25px;
            }
            #platSelect {
                margin-bottom: 15px;
            }
            .card-header, .card-footer {
                border-radius: 15px 15px 0 0;
            }
            .form-control, .form-select {
                border-radius: 10px;
                border: 1px solid #ccc;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }
            .form-control:focus, .form-select:focus {
                border-color: #007bff;
                box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
            }
            .badge {
                font-size: 1.1em;
            }
            .btn-primary {
                background-color: #007bff;
                border: none;
                padding: 10px 20px;
                border-radius: 20px;
            }
            .btn-primary:hover {
                background-color: #0056b3;
            }
            .input-group-text {
                border-radius: 0;
                background-color: #f8f9fa;
                border: 1px solid #ccc;
				width:300px;
            }
            .input-group {
                margin-bottom: 10px;
            }
            .input-group input {
                border-radius: 10px;
            }
			input[type="number"], select.form-select {
    height: 38px;
    font-size: 1rem;
    padding: 5px;
    line-height: 1.5;
    border-radius: 5px; /* Coins arrondis */
    border: 1px solid #ccc; /* Bordure légère */
    background-color: #f8f9fa; /* Fond légèrement plus clair */
}
/* Container centré avec une largeur définie */
.container {
    margin: 0 auto; /* Centrer horizontalement */
    padding: 0; /* Aucune marge/padding supplémentaire */
    width: 80%; /* Largeur du container (ajustable) */
    max-width: 1200px; /* Largeur maximale */
    display: flex;
    justify-content: center; /* Centre les éléments horizontalement */
    flex-direction: column; /* Disposition verticale */
	 background-color: #e9f7fd;
}

/* La card aura la même largeur que le container */
.card {
    width: 100%; /* La carte prendra toute la largeur du container */
    margin: 0; /* Supprimer les marges externes */
    padding: 0; /* Aucun padding supplémentaire */
}

        </style>
    </head>
    <body>
        <div class="container">
            <!-- Formulaire de sélection du plat -->
            <div class="card">
                <h2 class="text-center mb-4" style="margin-top:15px;">Gestion des Quantités de Produits</h2>
                <div class="card-body">
                    <form id="platForm">
			<div class="form-group d-flex align-items-center">
				<label class="col-md-5" for="categPlatSelect">Catégorie :</label>
				<select class="form-select col-md-7" id="categPlatSelect" onchange="afficherPlats()">
					<option value="">Choisir une catégorie...</option>
					<?php if (!empty($categories)): ?>
						<?php foreach ($categories as $categorie): ?>
							<option value="<?= $categorie['id']; ?>">
								<?= htmlspecialchars($categorie['catPlat']); ?>
							</option>
						<?php endforeach; ?>
					<?php else: ?>
						<option value="">Aucune catégorie disponible</option>
					<?php endif; ?>
				</select>
			</div>
                        
				<div class="form-group d-flex align-items-center">
					<label class="col-md-5" for="platSelect">Désignation du Plat :</label>
					<select class="form-select col-md-7" id="platSelect" onchange="afficherProduits()">
						<option value="">Choisir un plat...</option>
						<?php if (!empty($plats)): ?>
							<?php foreach ($plats as $plat): ?>
								<option value="<?= $plat['numero']; ?>">
									<?= htmlspecialchars($plat['designation']); ?>
								</option>
							<?php endforeach; ?>
						<?php else: ?>
							<option value="">Aucun plat disponible</option>
						<?php endif; ?>
					</select>
				</div>
			</form>
		</div>
            </div>

            <!-- Section pour afficher les produits du plat sélectionné -->
            <div id="produitsSection" class="card" style="display: none;">
			 <h5 class="card-title">Liste des Produits  
		
			 <?php //du Plat  : ucfirst($lastPlat['designation']); ?></h5>
                    <form id="produitsForm">
                <div class="card-body">
                   
                        <!-- Les produits seront ajoutés dynamiquement ici -->
                    </form>
                </div>
				<div> Equivalence : 
					 <?php foreach ($unites_mesure2 as $unite): ?>
				<?php if($unite['from_unit']!=$unite['to_unit']) 
					echo "1".$unite['from_unit'] ."=>".$unite['conversion_factor']." ". $unite['to_unit']."|"; ?>
				<?php endforeach; ?>
				</div>
                <div class="text-center" style="margin-top: 50px;">
                    <button id="submitBtn" class="btn btn-primary" style="display:none;" onclick="soumettreQuantites()">Soumettre</button>
                </div>
            </div>
        </div>

        <!-- Script JS pour la gestion dynamique des produits -->
        <script>
            window.onload = function() {
                const platId = <?php echo $lastPlat['numero']; ?>; 
                const platSelect = document.getElementById('platSelect');
                platSelect.value = platId; 
                afficherProduits();
				
				const categorieId = <?php echo $lastPlat['categPlat']; ?>; 
				const categPlatSelect = document.getElementById('categPlatSelect');
                categPlatSelect.value = categorieId; 
            };
			
	function afficherPlats() {
    const categorieSelect = document.getElementById('categPlatSelect');
    const platSelect = document.getElementById('platSelect');
    const categorieId = categorieSelect.value; // Récupère l'id de la catégorie sélectionnée

    // Réinitialiser le select des plats
    platSelect.innerHTML = '<option value="">Choisir un plat...</option>';

    if (categorieId) {
        // Si une catégorie est sélectionnée, faire une requête pour obtenir les plats de cette catégorie
        fetch(`get_plats_par_categorie.php?categorie_id=${categorieId}`)
            .then(response => response.json())
            .then(plats => {
                if (plats.length > 0) {
                    plats.forEach(plat => {
                        const option = document.createElement('option');
                        option.value = plat.numero;
                        option.textContent = `${plat.designation}`;
                        platSelect.appendChild(option);
                    });
                } else {
                    platSelect.innerHTML = '<option value="">Aucun plat disponible pour cette catégorie</option>';
                }
            })
            .catch(error => {
                platSelect.innerHTML = '<option value="">Erreur de chargement des plats</option>';
            });
    } else {
        // Si aucune catégorie n'est sélectionnée, on réinitialise le select des plats
        platSelect.innerHTML = '<option value="">Choisir un plat...</option>';
    }
}


function afficherProduits() {
    const platSelect = document.getElementById('platSelect');
    const platId = platSelect.value;
    const produitsSection = document.getElementById('produitsSection');
    const submitBtn = document.getElementById('submitBtn');
    const produitsForm = document.getElementById('produitsForm');

    produitsForm.innerHTML = ''; // Réinitialiser la section des produits
    produitsSection.style.display = platId ? 'block' : 'none'; // Afficher ou masquer la section des produits

    fetch(`get_produits.php?plat_id=${platId}`)
        .then(response => response.json())
        .then(produits => {
            if (produits.length > 0) {
                let counter = 0; // Initialisation du compteur pour alterner les couleurs

                produits.forEach(produit => {
                    const produitDiv = document.createElement('div');
                    produitDiv.classList.add('form-group', 'input-group');

                    // Appliquer la couleur alternée directement dans le style en ligne
                    if (counter % 2 === 0) {
                        produitDiv.style.backgroundColor = '#f9f9f9'; // Couleur claire
                    } else {
                        produitDiv.style.backgroundColor = '#e9ecef'; // Couleur légèrement plus foncée
                    }

                    // Générer le HTML pour chaque produit
					produitDiv.innerHTML = `
						<span class="input-group-text">${produit.produit_nom}</span>
						<span class="input-group-text" style='width:75px;'>${produit.produit_unite}</span>
						<input type="number" class="form-control" id="${produit.produit_id}" name="${produit.produit_id}" style='background-color:white;' min="0" step="1" value="${produit.produit_qte}" placeholder="">
						<select class="form-select" id="unite_${produit.produit_id}" name="unite_${produit.produit_id}">
							<option value="">${produit.produit_unite}</option>
							<?php foreach ($unites_mesure as $unite): ?>
								<option value="<?= $unite['id']; ?>"><?= htmlspecialchars($unite['catPrd']); ?></option>
							<?php endforeach; ?>
						</select>
					`;

                    produitsForm.appendChild(produitDiv); // Ajouter le produit au formulaire

                    // Incrémenter le compteur pour alterner la couleur
                    counter++;
                });

                submitBtn.style.display = 'inline-block'; // Afficher le bouton de soumission
            } else {
                produitsForm.innerHTML = '<p>Aucun produit trouvé pour ce plat.</p>';
            }
        })
        .catch(error => {
            produitsForm.innerHTML = '<p>Erreur de chargement des produits.</p>';
        });
}

function soumettreQuantites() {
    const produitsForm = document.getElementById('produitsForm');
    const quantites = {};
    const unites = {}; // Objet pour stocker les unités de mesure
    const inputs = produitsForm.querySelectorAll('input');
    const selects = produitsForm.querySelectorAll('select');
    let quantiteManquante = false; // Variable pour vérifier s'il manque une quantité

    inputs.forEach(input => {
        const produitId = input.name; // Assurez-vous que le nom de l'input est l'ID du produit
        const quantite = input.value;

        if (!quantite || quantite < 0) {
            quantiteManquante = true; // Marquer qu'il manque une quantité valide
            input.style.borderColor = "red"; // Optionnel: pour marquer les inputs invalides
        } else {
            quantites[produitId] = quantite; // Récupérer les quantités valides
            input.style.borderColor = ""; // Réinitialiser la couleur du bord si la quantité est valide
        }
    });

    selects.forEach(select => {
        const produitId = select.id.split('_')[1]; // Extraire l'ID du produit de l'ID du select
        const uniteId = select.value;

        // Ne mettre à jour l'unité que si elle est définie et non vide
        if (uniteId) {
            unites[produitId] = uniteId; // Stocker l'unité pour ce produit
        }
    });

    // Si une quantité est manquante, afficher un message d'erreur et ne pas soumettre
    if (quantiteManquante) {
        alert("Veuillez spécifier une quantité valide pour chaque produit.");
        return; // Ne pas soumettre si la quantité est manquante
    }

    // Préparer les données à envoyer
    const data = {
        quantites: quantites,
        unites: unites
    };

    // Envoi des données via Fetch (POST) à update_quantites.php
    fetch('update_quantites.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Afficher un message de succès
            alert("Quantités mises à jour avec succès!");

            // Réinitialiser le formulaire sans supprimer la liste des produits
            produitsForm.reset();

            // Garder la section des produits visible
            document.getElementById('produitsSection').style.display = 'block';
        } else {
            // Si une erreur est survenue, afficher un message d'erreur
            alert("Erreur: " + data.error);
        }
    })
    .catch(error => {
        console.error("Erreur de requête : ", error);
        alert("Erreur de mise à jour.");
    });
}

        </script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    </body>
</html>
