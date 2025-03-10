<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Connexion à la base de données
$servername = "localhost";
$username = "root"; // Remplacez par votre nom d'utilisateur
$password = ""; // Remplacez par votre mot de passe
$dbname = "madistor";
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Requête pour la somme des acquisitions
$sql_acquis = "SELECT 
    (SELECT IFNULL(SUM(prixAchat), 0) FROM ordinateurs WHERE type = 'Acquis') +
    (SELECT IFNULL(SUM(prixAchat), 0) FROM autres_materiels WHERE type = 'Acquis') +
    (SELECT IFNULL(SUM(prixAchat), 0) FROM ordinateurs_etagere WHERE type = 'Acquis') +
    (SELECT IFNULL(SUM(prixAchat), 0) FROM autres_materiels_etagere WHERE type = 'Acquis') 
    AS total_acquis";

$result_acquis = $conn->query($sql_acquis);
$row_acquis = $result_acquis->fetch_assoc();
$total_acquis = $row_acquis['total_acquis'];

// Requête pour la somme des dettes
$sql_dette = "SELECT 
    (SELECT IFNULL(SUM(prixAchat), 0) FROM ordinateurs WHERE type = 'Dette') +
    (SELECT IFNULL(SUM(prixAchat), 0) FROM autres_materiels WHERE type = 'Dette') +
    (SELECT IFNULL(SUM(prixAchat), 0) FROM ordinateurs_etagere WHERE type = 'Dette') +
    (SELECT IFNULL(SUM(prixAchat), 0) FROM autres_materiels_etagere WHERE type = 'Dette') 
    AS total_dette";

$result_dette = $conn->query($sql_dette);
$row_dette = $result_dette->fetch_assoc();
$total_dette = $row_dette['total_dette'];

$sql_benefice = "SELECT 
    (((SELECT IFNULL(SUM(prixVenteFinal), 0) FROM ordinateurs_vente) +
    (SELECT IFNULL(SUM(prixVenteFinal), 0) FROM autres_materiels_vente)) -
    ((SELECT IFNULL(SUM(prixAchat), 0) FROM ordinateurs_vente) +
    (SELECT IFNULL(SUM(prixAchat), 0) FROM autres_materiels_vente))) -
    (SELECT IFNULL(SUM(prix), 0) FROM depense) AS total_benefice";

$result_benefice = $conn->query($sql_benefice);
$row_benefice = $result_benefice->fetch_assoc();
$total_benefice = $row_benefice['total_benefice'];

$sql_depense = "SELECT IFNULL(SUM(prix), 0) AS total_depense FROM depense";

$result_depense = $conn->query($sql_depense);
$row_depense = $result_depense->fetch_assoc();
$total_depense = $row_depense['total_depense'];

$sql_ventes = "SELECT DATE(dateInsert) AS date_jour, COUNT(*) AS total_ventes 
               FROM (
                   SELECT dateInsert FROM ordinateurs_vente 
                   UNION ALL 
                   SELECT dateInsert FROM autres_materiels_vente
               ) ventes 
               GROUP BY date_jour ORDER BY date_jour";

$result_ventes = $conn->query($sql_ventes);
$ventes_data = [];
while ($row_ventes = $result_ventes->fetch_assoc()) {
    $ventes_data[] = $row_ventes;
}


$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
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

    canvas {
      max-width: 1200px;
      width: 1200px;
      margin: 20px auto;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    h2{
      text-align: center;
    }


  </style>
</head>
<body>
  <?php include('menu.php'); ?>
  <div class="cards-container" style="      align-items: center;
display: flex; gap: 20px; padding: 20px; margin: 20px; justify-content: center;">
      <div class="card" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); width: 250px; text-align: center;">
          <h3>BUDGET (deboursé)</h3>
          <p style="font-size: 20px; font-weight: bold; color: green;"> <?php echo number_format($total_acquis, 0, ',', ' ') . ' Ariary'; ?> </p>
      </div>
      <div class="card" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); width: 250px; text-align: center;">
          <h3>BUDGET (Dette)</h3>
          <p style="font-size: 20px; font-weight: bold; color: red;"> <?php echo number_format($total_dette, 0, ',', ' ') . ' Ariary'; ?> </p>
      </div>
      <div class="card" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); width: 250px; text-align: center;">
        <h3>Bénéfice</h3>
        <p style="font-size: 20px; font-weight: bold; color: blue;"> <?php echo number_format($total_benefice, 0, ',', ' ') . ' Ariary'; ?> </p>
      </div>
      <div class="card" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); width: 250px; text-align: center;">
        <h3>Depense</h3>
        <p style="font-size: 20px; font-weight: bold; color: blue;"> <?php echo number_format($total_depense, 0, ',', ' ') . ' Ariary'; ?> </p>
      </div>
  </div>
  <h2>Nombre de ventes par jour</h2>
  <canvas id="salesChart"></canvas>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
     var ctx = document.getElementById('salesChart').getContext('2d');
    var ventesData = <?php echo json_encode($ventes_data); ?>;
    var labels = ventesData.map(item => item.date_jour);
    var data = ventesData.map(item => item.total_ventes);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Ventes par jour',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: { display: true, text: 'Date' },
                    grid: { display: false }
                },
                y: {
                    title: { display: true, text: 'Nombre de ventes' },
                    beginAtZero: true,
                    grid: { color: 'rgba(200, 200, 200, 0.3)' }
                }
            },
            plugins: {
                legend: { display: true, position: 'top' }
            }
        }
    });
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
