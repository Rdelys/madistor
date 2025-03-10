<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SAV</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      color: #333;
    }

    /* Style de la navbar horizontale */
    .navbar {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      background: #fff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      padding: 10px 30px;
      position: relative;
    }

    .logo {
      width: 120px;
      height: 50px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 30px;
    }

    .logo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .menu {
      display: flex;
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .menu > li {
      position: relative;
      margin: 0 20px;
    }

    .menu a {
      color: #333;
      text-decoration: none;
      padding: 15px;
      font-weight: bold;
      display: block;
      text-align: right;
      width: 100%;
      transition: all 0.3s ease-in-out;
    }

    .menu a:hover {
      color: #d32f2f;
    }

    /* Dropdown Styles */
    .dropdown-content {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background-color: #fff;
      min-width: 200px;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .dropdown-content a {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    .dropdown-content a:hover {
      background-color: #f1f1f1;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    .content {
      padding: 20px;
      text-align: center;
    }

    /* Styles pour la version mobile */
    @media (max-width: 768px) {
      .navbar {
        flex-direction: column;
        padding: 20px;
        position: relative;
      }

      .menu {
        flex-direction: column;
        display: none;
        width: 100%;
        margin-top: 10px;
      }

      .menu.active {
        display: block;
      }

      .menu > li {
        margin: 10px 0;
      }

      .menu a {
        text-align: left;
        padding: 12px;
      }

      /* Styles du bouton hamburger */
      .hamburger {
        display: block;
        cursor: pointer;
        width: 30px;
        height: 25px;
        position: absolute;
        top: 20px;
        right: 30px;
      }

      .hamburger div {
        width: 100%;
        height: 5px;
        background-color: #333;
        margin: 6px 0;
        transition: all 0.3s ease;
      }

      .hamburger.active div:nth-child(1) {
        transform: rotate(45deg);
        position: relative;
        top: 9px;
      }

      .hamburger.active div:nth-child(2) {
        opacity: 0;
      }

      .hamburger.active div:nth-child(3) {
        transform: rotate(-45deg);
        position: relative;
        top: -9px;
      }
    }
    /* Container pour les cartes */
.card-container {
  display: flex;
  flex-wrap: wrap; /* Permet de revenir à la ligne si nécessaire */
  gap: 20px; /* Espacement entre les cartes */
  justify-content: space-evenly; /* Espacement égal entre les cartes */
}

/* Style des cartes */
.card {
  background-color: white;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 20px;
  width: 300px; /* Largeur des cartes */
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

/* Au survol de la carte */
.card:hover {
  transform: scale(1.05); /* Effet zoom sur la carte */
}

/* Titre de la carte */
.card h3 {
  font-size: 18px;
  margin-bottom: 10px;
}

/* Informations supplémentaires sur la carte */
.card p {
  font-size: 14px;
  margin-bottom: 10px;
}

/* Boutons dans les cartes */
.card button {
  background-color: #4CAF50;
  color: white;
  padding: 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 10px;
}

.card button:hover {
  background-color: #45a049;
}

.card form {
  margin-top: 10px;
}

/* Styles pour les étapes spécifiques */
.card .etape {
  font-weight: bold;
  color: #d32f2f; /* Rouge pour les étapes à suivre */
}

.card .sav-fait {
  color: #1976d2; /* Bleu pour SAV fait */
}

/* Disposition horizontale sur grands écrans */
@media (min-width: 768px) {
  .card-container {
    flex-direction: row;
    justify-content: space-between;
  }
}

  </style>
</head>
<body>
  <?php include('menu.php'); ?>

  <?php
// Connexion à la base de données
$servername = "localhost";
$username = "root"; // Votre nom d'utilisateur
$password = ""; // Votre mot de passe
$dbname = "madistor"; // Remplacez par le nom de votre base de données

// Créez la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérez les données de la table 'sav'
$sql = "SELECT * FROM sav";
$result = $conn->query($sql);
?>

<div class="content">
  <div class="card-container">
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Récupérer les données de chaque enregistrement
            $id = $row['id'];
            $marque = $row['marque'];
            $modele = $row['modele'];
            $dateInsert = $row['dateInsert'];
            $etape = $row['etape'];
    ?>
      <!-- Affichage de la carte -->
      <div class="card">
        <h3><?php echo $marque . ' ' . $modele; ?></h3>
        <p>Date d'insertion: <?php echo $dateInsert; ?></p>
        
        <!-- Affichage de l'étape -->
        <p>Étape: <?php echo $etape == 0 ? 'Electricien' : ($etape == 1 ? 'SAV fait' : 'Retour client'); ?></p>
        
        <!-- Bouton pour modifier l'étape -->
        <?php if ($etape == 0): ?>
          <form action="modifier_etape.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit" name="update_etape" value="1">Passer à l'étape 2</button>
          </form>
        <?php elseif ($etape == 1): ?>
          <!-- Si l'étape est 1 (SAV fait), on propose un bouton pour passer à l'étape 3 -->
          <form action="modifier_etape.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit" name="update_etape" value="3">Retour client</button>
          </form>
        <?php endif; ?>

        <!-- Bouton pour supprimer l'enregistrement -->
        <form action="supprimer_sav.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?');">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <button type="submit" name="delete_sav">Supprimer</button>
        </form>
      </div>
    <?php
        }
    } else {
        echo "Aucun enregistrement trouvé.";
    }
    ?>
  </div>
</div>

<?php
$conn->close();
?>



  <script>
// Fonction pour ouvrir/fermer le menu hamburger
function toggleMenu() {
    var menu = document.querySelector('.menu');
    var hamburger = document.querySelector('.hamburger');
    
    menu.classList.toggle('active');
    hamburger.classList.toggle('active');
}
  </script>
</body>
</html>
