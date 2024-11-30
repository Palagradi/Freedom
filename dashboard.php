<?php
	
include_once 'config.php';

$ref=mysqli_query($con,"SELECT * FROM factureResto WHERE date_emission LIKE '".$Jour_actuelp."'");
$nbreV=mysqli_num_rows($ref);
$ref=mysqli_query($con,"SELECT DISTINCT numTable FROM tableencours,RTables WHERE RTables.nomTable=tableencours.numTable AND created_at='".$Jour_actuel."' AND Etat <> 'Desactive' AND RTables.status=0");
$nbreTab=mysqli_num_rows($ref);
$ref=mysqli_query($con,"SELECT numTable FROM tableencours WHERE created_at='".$Jour_actuel."' AND Etat <> 'Desactive'");
$nbreCom=mysqli_num_rows($ref);

$ref=mysqli_query($con,"SELECT COUNT(LigneCde) AS NbreCom,LigneCde FROM tableencours WHERE Etat='Desactive' GROUP BY LigneCde ORDER BY NbreCom DESC LIMIT 6");

$reqTable=mysqli_query($con,"SELECT * FROM RTables WHERE NbreCV<>0"); 

$rk="SELECT * FROM tableEnCours WHERE created_at='".$Jour_actuel."' AND Etat <> 'Desactive' ORDER BY numCde DESC";
$req1 = mysqli_query($con,$rk) or die (mysqli_error($con));
$rand=rand(1,4);
if($rand==1){
	$result=mysqli_query($con,"SELECT MIN(QteStock) AS QteStock FROM boisson WHERE Depot = '2' AND QteStock>0 ");
	$libelle="au bar";
}
else if($rand==2){
	$result=mysqli_query($con,"SELECT MIN(QteStock) AS QteStock FROM boisson WHERE Depot = '1' AND QteStock>0 ");
	$libelle="au Dépôt";
}
else if($rand==3){
	$result=mysqli_query($con,"SELECT MIN(Nbre) AS QteStock FROM plat WHERE Nbre>0 ");
	$libelle="Repas";
}
else {
	$result=mysqli_query($con,"SELECT  MIN(Qte_Stock) AS QteStock FROM produits WHERE Type='".$_SESSION['menuParenT1']."' AND Qte_Stock>0 ");
	$libelle="Produits";
}
$resultB = mysqli_fetch_object($result); 
$QteStock=isset($resultB->QteStock)?$resultB->QteStock:0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord du Restaurant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
	
	.fixed-height {
    height: 300px !important; /* Hauteur fixe */
    overflow-y: auto; /* Défilement vertical */
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
                    <p class="fs-4" style='font-weight:bold;'><?=$nbreV;?></p>
					<i class="fa-solid fa-money-check-dollar" style="font-size:2em;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white text-center">
                <div class="card-body">
                    <h5>En attente</h5>  <!-- <h5>Commandes en attente</h5> !-->
                    <p class="fs-4"><span style='font-weight:bold;'> <?=$nbreCom;?></span>
					<span style='color:black;'>[Commandes]</span></p>
                    <i class="fas fa-clock fa-2x"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white text-center">
                <div class="card-body">
                    <h5>Tables occupées</h5>
                    <p class="fs-4" style='font-weight:bold;'><?=$nbreTab;?></p> 
                    <!-- <i class="fas fa-chair fa-2x"></i> !-->
					<i class="fa-solid fa-table" style="font-size:2em;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white text-center">
                <div class="card-body">
                    <h5>Stock faible</h5>
                    <p class="fs-4" style=''><span style='font-weight:bold;'><?=$QteStock;?></span>
					<span style='color:black;'>[<?=$libelle;?>]</span></p> 
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
				<?php
				$i=0;
				while($data=mysqli_fetch_array($ref)){
					$i++;
					if($i==1) $badge="badge bg-success rounded-pill"; else if($i==2) $badge="badge bg-info rounded-pill"; else if($i==3) $badge="badge bg-warning rounded-pill"; else if($i==4) $badge="badge bg-danger rounded-pill";  else $badge="badge bg-primary rounded-pill";
					echo '
                    <li class="list-group-item d-flex justify-content-between align-items-center">'.$data['LigneCde'].'
                        <span class="'.$badge.'">'.$data['NbreCom'].' commandes</span>
                    </li>';
				}
					?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
<!-- Statut des Tables -->
<div class="col-md-6">
    <h5 style=''>Statut des Tables</h5>
    <div class="table-responsive fixed-height"> <!-- Classe personnalisée -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>&nbsp;&nbsp;&nbsp;Table</th>
                    <th>État</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $reqTable = mysqli_query($con, "SELECT * FROM RTables WHERE NbreCV<>0"); 
            while ($dataT = mysqli_fetch_object($reqTable)) {            
                $i = $dataT->nomTable; 
                if ($dataT->RealNameTable != '') $ii = $dataT->RealNameTable; 
                else { 
                    if ($i < 10) $ii = "0" . $i; else $ii = $i;
                }
                echo '<tr>
                <td>&nbsp;&nbsp;&nbsp;' . $ii . '</td>';
                $req = "SELECT DISTINCT numTable FROM tableEnCours WHERE numTable='" . $i . "' AND created_at='" . $Jour_actuel . "' AND Etat <> 'Desactive'";
                $reqsel2 = mysqli_query($con, $req);
				if($dataT->status==1)$state = '<span class="badge bg-secondary">Désactivée</span>';
                else { 
					if (mysqli_num_rows($reqsel2) > 0) $state = '<span class="badge bg-danger">Occupée</span>';
					else $state = '<span class="badge bg-success">Libre</span>';
				}
                echo '<td>' . $state . '</td> 
                </tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

	<!-- Commandes en Cours -->
<div class="col-md-6">
    <h5 style=''>Commandes en Cours</h5>
    <div class="table-responsive fixed-height"> <!-- Classe personnalisée -->
        <ul class="list-group">
            <?php
                if (mysqli_num_rows($req1) > 0) {
                    while ($dataCde = mysqli_fetch_object($req1)) { 
                        echo '
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Commande #'; 
                        if (($dataCde->numCde >= 0) && ($dataCde->numCde <= 9)) {
                            $numCde = "00" . $dataCde->numCde;
                        } else if (($dataCde->numCde >= 10) && ($dataCde->numCde <= 99)) {
                            $numCde = "0" . $dataCde->numCde;
                        } else {
                            $numCde = $dataCde->numCde;
                        }
                        echo $numCde; 
                        if ($dataCde->EtatCde == 0) {
                            echo '<span class="badge bg-danger">En Cours</span>';
                        } else if ($dataCde->EtatCde == 1) {
                            echo '<span class="badge bg-secondary">Prête</span>';
                        } else {
                            echo '<span class="badge bg-primary">Déjà servie</span>';
                        }
                        echo '</li>';
                    }
                }else {
					 echo '<li class="list-group-item d-flex justify-content-between align-items-center">&nbsp;</li>';
				}
            ?>
        </ul>
    </div>
</div>


    </div>
</div>
</div>

<script>
// Configuration du graphique de ventes avec Chart.js
fetch('get_sales_data.php')
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
                datasets: [{
                    label: 'Ventes',
                    data: data, // Utilise les données récupérées depuis la base de données
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
    })
    .catch(error => console.error('Erreur lors du chargement des données :', error));

	
	


const popularItems = [
/*     { name: 'Pizza Margherita', orders: 120 },
    { name: 'Cheeseburger', orders: 95 }, */
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
