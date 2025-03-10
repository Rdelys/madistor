<?php
// Vérifie si une session est déjà démarrée, sinon démarre une nouvelle session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost';
$dbname = 'madistor';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifiez si l'utilisateur est connecté et récupérer le statut
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT status FROM user WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur est trouvé et a un statut, on l'affecte à une variable
    $status = $user ? $user['status'] : null;
} else {
    // Si l'utilisateur n'est pas connecté, on redirige vers la page de connexion
    header("Location: index.php");
    exit();
}
?>

<div class="navbar">
    <div class="logo">
        <img src="images/logo/logo.png" alt="Logo" onerror="this.style.display='none'">
    </div>
    <!-- Menu -->
    <ul class="menu">
        <li><a href="dashboard.php" <?php if ($status == '0') echo 'style="display:none;"'; ?>>Dashboard</a></li>
        <li class="dropdown">
            <a href="depense.php" <?php if ($status == '0') echo 'style="display:none;"'; ?>>Depenses</a>
        </li>

        <li class="dropdown">
            <a href="remboursement.php" <?php if ($status == '0') echo 'style="display:none;"'; ?>>Remboursement</a>
        </li>
        <li class="dropdown">
            <a href="#">Vente</a>
            <div class="dropdown-content">
                <a href="venteStock.php">Stock</a>
                <a href="venteEtagere.php">Etagere</a>
            </div>
        </li>

        <li class="dropdown">
            <a href="#">Stock</a>
            <div class="dropdown-content">
                <a href="stock.php">Stock</a>
                <a href="versEtagere.php">Vers l'étagere</a>
            </div>
        </li>

        <li class="dropdown">
            <a href="#">SAV</a>
            <div class="dropdown-content">
                <a href="sav.php">Produits vendu</a>
                <a href="savfais.php">Produit en SAV</a>
            </div>
        </li>

        <li class="dropdown">
            <a href="etagere.php">Étagère</a>
        </li>

        

        <li class="dropdown">
            <a href="vente.php">Produits vendus</a>
        </li>

        <!-- Menu de déconnexion -->
        <li class="dropdown">
            <a href="logout.php">Déconnexion</a>
        </li>
    </ul>

    <!-- Hamburger Button -->
    <div class="hamburger" onclick="toggleMenu()">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
