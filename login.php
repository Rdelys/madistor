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
            header("Location: stock.php"); // Redirection après connexion
            exit();
        } else {
            echo "<script>alert('Nom d\'utilisateur ou mot de passe incorrect');</script>";
        }
    } else {
        echo "<script>alert('Veuillez remplir tous les champs');</script>";
    }
}
?>
