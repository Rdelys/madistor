<?php
require 'connexion.php'; // Connexion à la base de données

// Récupérer les données JSON envoyées par AJAX
$data = json_decode(file_get_contents('php://input'), true);

// Récupérer les items envoyés
$items = $data['items'];

try {
  // Début de la transaction
  $pdo->beginTransaction();

  // Parcourir les items sélectionnés
  foreach ($items as $item) {
    // Afficher les données reçues pour le débogage (si nécessaire)
    // echo '<pre>';
    // print_r($item);
    // echo '</pre>';

    if (isset($item['id']) && isset($item['marque']) && isset($item['modele'])) {
      // Insertion des données dans la table sav pour les ordinateurs
      $stmt = $pdo->prepare("INSERT INTO sav 
        (id, marque, modele, ram, disque_dur, graphique, accessoire, prixAchat, prixVente, prixVenteFinal)
        VALUES (:id, :marque, :modele, :ram, :disque_dur, :graphique, :accessoire, :prixAchat, :prixVente, :prixVenteFinal)");

      // Exécution de la requête avec les données du tableau
      $stmt->execute([
        ':id' => $item['id'],  // Inclure l'ID dans l'insertion
        ':marque' => $item['marque'],
        ':modele' => $item['modele'],
        ':ram' => $item['ram'],
        ':disque_dur' => $item['disqueDur'],
        ':graphique' => $item['graphique'],
        ':accessoire' => $item['accessoire'],
        ':prixAchat' => $item['prixAchat'],
        ':prixVente' => $item['prixVente'],
        ':prixVenteFinal' => $item['prixVenteFinal'],  // Utiliser prixVenteFinal
      ]);
    }
  }

  // Valider la transaction
  $pdo->commit();

  // Retourner une réponse JSON avec un statut de succès
  echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
  // Annuler la transaction en cas d'erreur
  $pdo->rollBack();
  echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
