<?php
if (isset($_POST['delete_sav'])) {
    $id = $_POST['id'];

    // Connexion à la base de données
    $conn = new mysqli("localhost", "root", "", "madistor");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Supprimer l'enregistrement
    $sql = "DELETE FROM sav WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Enregistrement supprimé avec succès.";
        header('Location: savfais.php');
    } else {
        echo "Erreur: " . $conn->error;
    }

    $conn->close();
}
?>
