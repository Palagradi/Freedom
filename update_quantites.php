<?php
include_once 'connexion.php'; // Inclure la connexion à la base de données

// Vérifier si les données sont envoyées en JSON
$inputData = json_decode(file_get_contents("php://input"), true);

// Vérifier si les quantités ont été envoyées
if (isset($inputData['quantites']) && isset($inputData['unites'])) {
    $quantites = $inputData['quantites'];
    $unites = $inputData['unites'];

    // Commencer une transaction pour garantir la cohérence des données
    mysqli_begin_transaction($con);

    try {
        // Mettre à jour chaque produit
        foreach ($quantites as $produitId => $quantite) {
            // Créer la requête SQL pour mettre à jour la quantité
            $updateQuery = "UPDATE plat_produit SET qte = $quantite WHERE id_prd = $produitId";
            
            // Exécuter la requête avec mysqli_query
            $stmt = mysqli_query($con, $updateQuery);

            if (!$stmt) {
                throw new Exception("Erreur lors de la mise à jour du produit avec l'ID $produitId : " . mysqli_error($con));
            }
        }

        // Valider la transaction
        mysqli_commit($con);

        // Répondre en JSON pour indiquer le succès
        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        mysqli_rollBack($con);

        // Répondre en JSON pour indiquer l'échec
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

} else {
    echo json_encode(['success' => false, 'error' => 'Aucune donnée reçue.']);
}
?>
