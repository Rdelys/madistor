<?php
require 'connexion.php'; // Connexion à la base de données

// Récupérer les données JSON envoyées par AJAX
$data = json_decode(file_get_contents('php://input'), true);

// Récupérer les items et le type (ordinateurs ou autres matériels)
$items = $data['items'];
$type = $data['type'];

try {
  // Début de la transaction
  $pdo->beginTransaction();

  // Parcourir les items sélectionnés
  foreach ($items as $item) {
    if ($type === 'ordinateur') {
      // Insertion des données dans la table ordinateurs_vente
      $stmt = $pdo->prepare("INSERT INTO ordinateurs_vente (id, marque, modele, ram, disque_dur, graphique, accessoire, type, prixAchat, prixVente, prixVenteFinal, typeVente)
                              VALUES (:id, :marque, :modele, :ram, :disque_dur, :graphique, :accessoire, :type, :prixAchat, :prixVente, :prixVenteFinal, :typeVente)");

      $stmt->execute([
        ':id' => $item['id'],  // Inclure l'ID dans l'insertion
        ':marque' => $item['marque'],
        ':modele' => $item['modele'],
        ':ram' => $item['ram'],
        ':disque_dur' => $item['disqueDur'],
        ':graphique' => $item['graphique'],
        ':accessoire' => $item['accessoire'],
        ':type' => $item['type'],
        ':prixAchat' => $item['prixAchat'],
        ':prixVente' => $item['prixVente'],
        ':prixVenteFinal' => $item['prixFinal'],
        ':typeVente' => 'etagere'  // Ajouter la valeur par défaut 'stock'
      ]);
    } elseif ($type === 'autres') {
      // Insertion des données dans la table autres_materiels_vente
      $stmt = $pdo->prepare("INSERT INTO autres_materiels_vente (id, marque, description, type, prixAchat, prixVente, prixVenteFinal, typeVente)
                              VALUES (:id, :marque, :description, :type, :prixAchat, :prixVente, :prixVenteFinal, :typeVente)");

      $stmt->execute([
        ':id' => $item['id'],  // Inclure l'ID dans l'insertion
        ':marque' => $item['marque'],
        ':description' => $item['description'],
        ':type' => $item['type'],
        ':prixAchat' => $item['prixAchat'],
        ':prixVente' => $item['prixVente'],
        ':prixVenteFinal' => $item['prixFinal'],
        ':typeVente' => 'etagere'  // Ajouter la valeur par défaut 'stock'
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
