<?php
require 'connexion.php';  // Assurez-vous que la connexion à la base de données est bien établie

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données envoyées par AJAX
    $type = $_POST['type'];  // 'ordinateur' ou 'autres'
    $ids = json_decode($_POST['ids']);  // Décoder les IDs envoyés (tableau d'IDs sélectionnés)

    if ($type == 'ordinateur') {
        // Insérer dans la table "ordinateurs_etagere"
        foreach ($ids as $id) {
            $sql = "SELECT * FROM ordinateurs WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Préparer l'insertion dans la table ordinateurs_etagere avec l'ID
            $insert = "INSERT INTO ordinateurs_etagere (id, marque, modele, ram, disque_dur, graphique, accessoire, prixAchat, prixVente)
                       VALUES (:id, :marque, :modele, :ram, :disque_dur, :graphique, :accessoire, :prixAchat, :prixVente)";
            $insertStmt = $pdo->prepare($insert);
            $insertStmt->execute([
                'id' => $row['id'],  // Ajouter l'ID
                'marque' => $row['marque'],
                'modele' => $row['modele'],
                'ram' => $row['ram'],
                'disque_dur' => $row['disque_dur'],
                'graphique' => $row['graphique'],
                'accessoire' => $row['accessoire'],
                'prixAchat' => $row['prixAchat'],
                'prixVente' => $row['prixVente']
            ]);
        }

        echo "Les ordinateurs ont été transférés avec succès !";
    } elseif ($type == 'autres') {
        // Insérer dans la table "autres_materiels_etagere"
        foreach ($ids as $id) {
            $sql = "SELECT * FROM autres_materiels WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Préparer l'insertion dans la table autres_materiels_etagere avec l'ID
            $insert = "INSERT INTO autres_materiels_etagere (id, marque, description, prixAchat, prixVente)
                       VALUES (:id, :marque, :description, :prixAchat, :prixVente)";
            $insertStmt = $pdo->prepare($insert);
            $insertStmt->execute([
                'id' => $row['id'],  // Ajouter l'ID
                'marque' => $row['marque'],
                'description' => $row['description'],
                'prixAchat' => $row['prixAchat'],
                'prixVente' => $row['prixVente']
            ]);
        }

        echo "Les autres matériels ont été transférés avec succès !";
    } else {
        echo "Type invalide.";
    }
} else {
    echo "Requête invalide.";
}
?>
