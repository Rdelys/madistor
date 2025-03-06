<?php
require 'connexion.php'; // Connexion à la base de données

$message = "nok"; // Par défaut, on considère que l'opération a échoué

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (isset($_POST['stock_ordinateur'])) {
            $marques = $_POST['marque'];
            $modeles = $_POST['modele'];
            $rams = $_POST['ram'];
            $disques = $_POST['dur'];
            $graphiques = $_POST['graphique'];
            $accessoires = $_POST['accessoire'];
            $prixAchat = $_POST['prixAchat'];
            $prixVente = $_POST['prixVente'];
            $type = $_POST['type'];


            $sql = "INSERT INTO ordinateurs (marque, modele, ram, disque_dur, graphique, accessoire, prixAchat, prixVente, type) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            for ($i = 0; $i < count($marques); $i++) {
                $stmt->execute([$marques[$i], $modeles[$i], $rams[$i], $disques[$i], $graphiques[$i], $accessoires[$i], $prixAchat[$i], $prixVente[$i], $type[$i]]);
            }
            $message = "ok"; // Succès
        }

        if (isset($_POST['stock_autres'])) {
            $marques = $_POST['marque'];
            $descriptions = $_POST['description'];
            $prixAchat = $_POST['prixAchat'];
            $prixVente = $_POST['prixVente'];
            $type = $_POST['type'];


            $sql = "INSERT INTO autres_materiels (marque, description, prixAchat, prixVente, type) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            for ($i = 0; $i < count($marques); $i++) {
                $stmt->execute([$marques[$i], $descriptions[$i], $prixAchat[$i], $prixVente[$i], $type[$i]]);
            }
            $message = "ok"; // Succès
        }
    } catch (Exception $e) {
        $message = "nok"; // Échec
    }

    // Empêcher le cache du navigateur pour éviter la soumission répétée du formulaire
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Redirection vers index.php avec le message de confirmation
    header("Location: stock.php?message=$message");
    exit();
}
?>
