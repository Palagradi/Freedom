<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des Quantités de Produits</title>
  <!-- Liens vers Bootstrap pour le style et la réactivité -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f7fb;
      margin-top: 30px;
    }

    .container {
      max-width: 900px;
      padding: 20px;
    }

    .card {
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

    .card-title {
      font-size: 1.5rem;
      color: #495057;
    }

    .form-group label {
      font-weight: bold;
      color: #343a40;
    }

    .form-select, .form-control {
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-select:focus, .form-control:focus {
      border-color: #007bff;
      box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
    }

    .btn {
      border-radius: 8px;
      padding: 10px 20px;
      font-size: 1.1rem;
      transition: background-color 0.3s;
    }

    .btn-primary {
      background-color: #007bff;
      border: none;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    .btn-primary:focus {
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .card-body {
      background-color: #ffffff;
    }

    .alert {
      border-radius: 8px;
    }

    .text-muted {
      color: #6c757d !important;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group input {
      font-size: 1.1rem;
    }

    .section-header {
      font-size: 1.25rem;
      color: #333;
      margin-bottom: 15px;
    }

  </style>
</head>
<body>
  <div class="container">
    <h1 class="text-center mb-4">Gestion des Quantités de Produits</h1>
    
    <!-- Formulaire de sélection du plat -->
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Sélectionner un Plat</h5>
        <form id="platForm">
          <div class="form-group">
            <label for="platSelect">Plat :</label>
            <select class="form-select" id="platSelect" onchange="afficherProduits()">
              <option value="">Choisir un plat...</option>
              <option value="1">Plat 1</option>
              <option value="2">Plat 2</option>
              <option value="3">Plat 3</option>
            </select>
          </div>
        </form>
      </div>
    </div>

    <!-- Section pour afficher les produits du plat sélectionné -->
    <div id="produitsSection" class="card" style="display:none;">
      <div class="card-body">
        <h5 class="section-header">Produits du Plat Sélectionné</h5>
        <form id="produitsForm">
          <!-- Les produits seront ajoutés dynamiquement ici -->
        </form>
      </div>
    </div>
    
    <!-- Section pour le bouton de soumission -->
    <div class="text-center">
      <button id="submitBtn" class="btn btn-primary" style="display:none;" onclick="soumettreQuantites()">Soumettre</button>
  
