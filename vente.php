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
  <title>Vendus</title>
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

    .btn {
      padding: 10px 20px;
      margin: 10px;
      border: none;
      background: #007bff;
      color: white;
      font-size: 16px;
      cursor: pointer;
      border-radius: 5px;
      transition: background 0.3s ease;
    }
    .btn:hover {
      background: #0056b3;
    }

    .section {
      display: none;
      padding: 20px;
      background: #ffffff;
      margin-top: 10px;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      border-left: 5px solid #007bff;
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

    #stockForm {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .formRow {
      width: 75%;
      display: flex;
      align-items: center;
      gap: 10px;
      background: #f9f9f9;
      padding: 10px;
      border-radius: 5px;
      box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .formRow input {
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 5px;
      flex: 1;
      min-width: 100px; /* Largeur minimale pour plus d'espace */
      max-width: 100px; /* Largeur minimale pour plus d'espace */

    }

    .formRow button {
      background: red;
      color: white;
      border: none;
      padding: 5px;
      cursor: pointer;
      border-radius: 5px;
      font-size: 16px;
      transition: 0.3s;
    }

    .formRow button:hover {
      background: darkred;
    }

    .button-container {
  display: flex;
  justify-content: space-between; /* Alignement horizontal */
  gap: 10px; /* Espacement entre les boutons */
  margin-top: 15px; /* Espacement par rapport au formulaire */
}

.button-container button {
  padding: 10px 15px;
  font-size: 16px;
  font-weight: bold;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  transition: 0.3s ease-in-out;
}

.button-container button:first-child {
  background-color: #28a745; /* Vert pour ajouter une ligne */
  color: white;
}

.button-container button:first-child:hover {
  background-color: #218838;
}

.button-container button:last-child {
  background-color: #007bff; /* Bleu pour enregistrer */
  color: white;
}

.button-container button:last-child:hover {
  background-color: #0056b3;
}

/* Styles des tables */
  .stock-list {
      max-height: 400px; /* Limite la hauteur */
      overflow-y: auto; /* Ajoute un défilement vertical */
  }

  .search-bar {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
}
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

thead {
    background: #007bff;
    color: white;
    text-transform: uppercase;
}

th, td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

th {
    font-weight: bold;
}

tbody tr:last-child td {
    border-bottom: none;
}
    button:hover {
        background-color: #45a049;
    }

   /* Style pour le modal */
.modal {
    display: none; /* Masquer par défaut */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    overflow: auto;
    padding-top: 60px;
}

.modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    border-radius: 10px;
    width: 80%;
    max-width: 500px;
}

.close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: 25px;
    color: #333;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
}

input[type="number"] {
    padding: 10px;
    margin-top: 10px;
    width: 50%;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    padding: 10px 20px;
    margin-top: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

.final {
    padding: 8px;
    width: 100px;
    border: 1px solid #ccc;
    border-radius: 5px;
    text-align: center;
}
  </style>
</head>
<body>
<?php include('menu.php'); ?>


  <div class="content">
    <!-- Liste Stock Section -->
    <div id="listStock" class="section">
      <h2>Liste des matériels vendus</h2>
      <button class="btn" onclick="toggleList('ordinateurList')">Ordinateurs</button>
      <button class="btn" onclick="toggleList('autresList')">Autres Matériels</button>

    <div id="ordinateurList" class="stock-list" style="display: none;">
        <h3>Liste des Ordinateurs</h3>
        <input type="text" id="searchOrdinateurs" onkeyup="searchTable('ordinateur')" placeholder="Rechercher dans la liste des ordinateurs" class="search-bar">
        
        <table border="1">
            <thead>
                <tr>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>RAM</th>
                    <th>Disque Dur</th>
                    <th>Graphique</th>
                    <th>Accessoire</th>
                    <th>Type</th>
                    <th>Prix d'achat</th>
                    <th>Prix de vente</th>
                    <th>Prix de vente final</th>
                    <th>Date de vente</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    require 'connexion.php';
                    $sql = "SELECT * FROM ordinateurs_vente";
                    $result = $pdo->query($sql);
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>{$row['marque']}</td>
                                <td>{$row['modele']}</td>
                                <td>{$row['ram']}</td>
                                <td>{$row['disque_dur']}</td>
                                <td>{$row['graphique']}</td>
                                <td>{$row['accessoire']}</td>
                                <td>{$row['type']}</td>
                                <td>{$row['prixAchat']}</td>
                                <td>{$row['prixVente']}</td>
                                <td>{$row['prixVenteFinal']}</td>
                                <td>" . date('d/m/Y', strtotime($row['dateInsert'])) . "</td>
                              </tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <div id="autresList" class="stock-list" style="display: none;">
        <h3>Liste des Autres Matériels</h3>
        <input type="text" id="searchAutres" onkeyup="searchTable('autres')" placeholder="Rechercher dans la liste des autres matériels" class="search-bar">
        
        <table border="1">
            <thead>
                <tr>
                    <th>Marque</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Prix d'achat</th>
                    <th>Prix de vente</th>
                    <th>Prix de vente final</th>
                    <th>Date de vente</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    require 'connexion.php';
                    $sql = "SELECT * FROM autres_materiels_vente ";
                    $result = $pdo->query($sql);
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>{$row['marque']}</td>
                                <td>{$row['description']}</td>
                                <td>{$row['type']}</td>
                                <td>{$row['prixAchat']}</td>
                                <td>{$row['prixVente']}</td>
                                <td>{$row['prixVenteFinal']}</td>
                                <td>" . date('d/m/Y', strtotime($row['dateInsert'])) . "</td>
                              </tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
  <script>
    // Fonction pour filtrer les lignes des tableaux en fonction de la barre de recherche
// Fonction pour filtrer les lignes des tableaux en fonction de la barre de recherche
function searchTable(type) {
    let input, filter, table, tr, td, i, txtValue;
    if (type === 'ordinateur') {
        input = document.getElementById('searchOrdinateurs');
        table = document.getElementById('ordinateurList').getElementsByTagName('table')[0];  // Sélectionne la table
    } else {
        input = document.getElementById('searchAutres');
        table = document.getElementById('autresList').getElementsByTagName('table')[0];  // Sélectionne la table
    }

    filter = input.value.toUpperCase();
    tr = table.getElementsByTagName('tr');  // Obtient toutes les lignes de la table

    // Parcourir toutes les lignes de la table et masquer celles qui ne correspondent pas à la recherche
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName('td');  // Récupère toutes les cellules d'une ligne

        if (td.length > 0) {  // Vérifie si la ligne contient des cellules (pour ignorer l'en-tête)
            let rowContainsSearch = false;

            // Vérifier si l'une des cellules contient le texte de la recherche
            for (let j = 0; j < td.length; j++) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    rowContainsSearch = true;
                    break;
                }
            }

            // Affiche ou masque la ligne en fonction du texte trouvé
            if (rowContainsSearch) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}


    function toggleSection(sectionId) {
      var sections = ["listStock", "addStock"];

      sections.forEach(id => {
        var section = document.getElementById(id);
        section.style.display = (id === sectionId) ? "block" : "none";
      });
    }

    // Active par défaut la section "listStock" au chargement de la page
    document.addEventListener("DOMContentLoaded", function () {
      toggleSection("listStock");
    });


    // Fonction pour basculer l'affichage du menu sur mobile
    function toggleMenu() {
      const menu = document.querySelector('.menu');
      const hamburger = document.querySelector('.hamburger');
      menu.classList.toggle('active');
      hamburger.classList.toggle('active');
    }

    
  

    function toggleList(listId) {
    document.getElementById('ordinateurList').style.display = (listId === 'ordinateurList') ? 'block' : 'none';
    document.getElementById('autresList').style.display = (listId === 'autresList') ? 'block' : 'none';
  }
</script>
</body>
</html>
