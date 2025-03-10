<?php
if (isset($_POST['update_etape'])) {
    $id = $_POST['id'];
    $nouvelle_etape = $_POST['update_etape'];
    
    // Connexion à la base de données
    $conn = new mysqli("localhost", "root", "", "madistor");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Mise à jour de l'étape
    $sql = "UPDATE sav SET etape = $nouvelle_etape WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Étape mise à jour avec succès.";
        header('Location: savfais.php'); // Redirection vers la page principale
    } else {
        echo "Erreur: " . $conn->error;
    }

    $conn->close();
}
?>
