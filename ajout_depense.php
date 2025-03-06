<?php
require 'connexion.php'; // Connexion à la base de données

$message = "nok"; // Par défaut, on considère que l'opération a échoué

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (isset($_POST['stock_ordinateur'])) {
            $nom = $_POST['nom'];
            $prix = $_POST['prix'];

            $sql = "INSERT INTO depense (nom, prix) 
            VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);

            for ($i = 0; $i < count($nom); $i++) {
                $stmt->execute([$nom[$i], $prix[$i]]);
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
    header("Location: depense.php?message=$message");
    exit();
}
?>
