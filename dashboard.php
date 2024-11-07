<?php
	
include_once 'config.php';

$ref=mysqli_query($con,"SELECT * FROM factureResto WHERE date_emission LIKE '".$Jour_actuelp."'");
$nbreV=mysqli_num_rows($ref);
$ref=mysqli_query($con,"SELECT DISTINCT numTable FROM tableencours,RTables WHERE RTables.nomTable=tableencours.numTable AND created_at='".$Jour_actuel."' AND Etat <> 'Desactive' AND RTables.status=0");
$nbreTab=mysqli_num_rows($ref);
$ref=mysqli_query($con,"SELECT numTable FROM tableencours WHERE created_at='".$Jour_actuel."' AND Etat <> 'Desactive'");
$nbreCom=mysqli_num_rows($ref);

/* while($data1=mysqli_fetch_array($ref)){
   echo "<br/>".$sql = "SELECT * FROM tableEnCours WHERE numTable='".$data1['numTable']."' AND created_at='".$Jour_actuel."' AND Etat <> 'Desactive'";
	  $reqselRTables=mysqli_query($con,$sql);
	  while($data2=mysqli_fetch_array($reqselRTables)){
		  
	  }
} */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord du Restaurant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
	<style>
	.card {
    background-color: #ffffff;
    border: 1px solid #e0e0e0;
    padding: 15px;
    border-radius: 8px;
	}
	h5 {
		font-weight: bold;
		color: #333;
	}

	.list-group-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 1.1em;
	}
	</style>
</head>
<body>

<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Restaurant</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Commandes</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Stocks</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Rapports</a></li>
            </ul>
        </div>
    </div>
</nav> !-->  
<div style='margin-top:-25px;'>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white text-center">
                <div class="card-body">
                    <h5>Ventes aujourd'hui</h5>
                    <p class="fs-4"><?=$nbreV;?></p>
                    <i class="fas fa-dollar-sign fa-2x"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white text-center">
                <div class="card-body">
                    <h5>Commandes</h5>  <!-- <h5>Commandes en attente</h5> !-->
                    <p class="fs-4"><?=$nbreCom;?></p>
                    <i class="fas fa-clock fa-2x"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white text-center">
                <div class="card-body">
                    <h5>Tables occupées</h5>
                    <p class="fs-4"><?=$nbreTab;?></p>
                    <i class="fas fa-chair fa-2x"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white text-center">
                <div class="card-body">
                    <h5>Stock faible</h5>
                    <p class="fs-4">5</p>
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <!-- Rapport de Ventes -->
        <div class="col-md-6">
            <div class="card shadow-sm p-3 mb-5 bg-white rounded">
                <h5>Rapport de Ventes</h5>
                <canvas id="salesChart" style="width: 100%; max-width: 600px;"></canvas>
            </div>
        </div>

        <!-- Produits les plus Vendus -->
        <div class="col-md-6">
            <div class="card shadow-sm p-3 mb-5 bg-white rounded">
                <h5>Produits les plus Vendus</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Pizza Margherita
                        <span class="badge bg-success rounded-pill">120 commandes</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cheeseburger
                        <span class="badge bg-info rounded-pill">95 commandes</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Salade César
                        <span class="badge bg-warning rounded-pill">80 commandes</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Spaghetti Bolognaise
                        <span class="badge bg-danger rounded-pill">70 commandes</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <!-- Statut des Tables -->
        <div class="col-md-6">
            <h5>Statut des Tables</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Table</th>
                            <th>État</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><span class="badge bg-success">Libre</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><span class="badge bg-danger">Occupée</span></td>
                        </tr>
						<tr>
                            <td>3</td>
                            <td><span class="badge bg-success">Libre</span></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><span class="badge bg-danger">Occupée</span></td>
                        </tr>
						<tr>
                            <td>5</td>
                            <td><span class="badge bg-success">Libre</span></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td><span class="badge bg-danger">Libre</span></td>
                        </tr>
						<tr>
                            <td>7</td>
                            <td><span class="badge bg-success">Occupée</span></td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td><span class="badge bg-danger">Libre</span></td>
                        </tr>
						<tr>
                            <td></td>
                            <td><span class="badge bg-success">Occupée</span></td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td><span class="badge bg-danger">Libre</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Commandes en Cours -->
        <div class="col-md-6">
            <h5>Commandes en Cours</h5>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Commande #123 <span class="badge bg-primary">En Cours</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Commande #124 <span class="badge bg-secondary">Prête</span>
                </li>
            </ul>
        </div>
    </div>
</div>
</div>

<script>
// Configuration du graphique de ventes avec Chart.js
const ctx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
        datasets: [{
            label: 'Ventes',
            data: [120, 150, 180, 220, 170, 190, 210],
            borderColor: 'rgba(75, 192, 192, 1)',
            fill: false,
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true }
        }
    }
});



const popularItems = [
    { name: 'Pizza Margherita', orders: 120 },
    { name: 'Cheeseburger', orders: 95 },
];

const listGroup = document.querySelector('.list-group');
popularItems.forEach(item => {
    const listItem = document.createElement('li');
    listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
    listItem.innerHTML = `${item.name} <span class="badge bg-primary rounded-pill">${item.orders} commandes</span>`;
    listGroup.appendChild(listItem);
});

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
