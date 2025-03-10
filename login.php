<?php
session_start();
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE name = :name AND password = :password");
        $stmt->execute(['name' => $username, 'password' => $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name'];
            header("Location: stock.php");
            exit();
        } else {
            $_SESSION['error'] = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        $_SESSION['error'] = "Veuillez remplir tous les champs.";
    }
    header("Location: index.php");
    exit();
}
?>
