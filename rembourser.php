<?php
require 'connexion.php';

if (isset($_POST['type'])) {
    $type = $_POST['type']; // "ordinateur" ou "autres"
    
    if ($type === 'ordinateur') {
        $table = 'ordinateurs_vente';
        $checkboxName = 'selectOrdinateur';
    } else {
        $table = 'autres_materiels_vente';
        $checkboxName = 'selectAutres';
    }

    if (!empty($_POST[$checkboxName])) {
        $ids = $_POST[$checkboxName];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "UPDATE $table SET type = 'Acquis' WHERE id IN ($placeholders)";
        
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute($ids)) {
            echo "<script>alert('Les éléments sélectionnés ont été mis à jour en Acquis.'); window.location.href='votre_page.php';</script>";
        } else {
            echo "<script>alert('Erreur lors de la mise à jour.');</script>";
        }
    } else {
        echo "<script>alert('Veuillez sélectionner au moins un élément.'); window.location.href='remboursement.php';</script>";
    }
}
?>
