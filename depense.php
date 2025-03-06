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
  <title>Depenses</title>
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
  </style>
</head>
<body>
<?php include('menu.php'); ?>


  <div class="content">
    <button class="btn" onclick="toggleSection('listStock')">Liste des depenses</button>
    <button class="btn" onclick="toggleSection('addStock')">Ajouter depenses </button>
    
    <!-- Liste Stock Section -->
    <div id="listStock" class="section">
      <h2>Liste des dépenses.</h2>
      <button class="btn" onclick="toggleList('ordinateurList')">Depenses</button>
      <div id="ordinateurList" class="stock-list" style="display: none;">
    <input type="text" id="searchOrdinateurs" onkeyup="searchTable('ordinateur')" placeholder="Rechercher dans la liste des ordinateurs" class="search-bar">    
  <table border="1">
        <thead>
            <tr>
                <th>Nom de la depense</th>
                <th>Prix</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require 'connexion.php';
            $sql = "SELECT * FROM depense";
            $result = $pdo->query($sql);
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['nom']}</td>
                        <td>{$row['prix']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</div>
<div id="addStock" class="section">
      <h2>Ajouter une ou plusieurs depenses</h2>
      <button class="btn" onclick="showForm('ordinateur')">Depenses</button>

      <div id="ordinateurForm" class="stock-form">
        <form id="stockFormOrdinateur" action="ajout_depense.php" method="POST">
          <input type="hidden" name="stock_ordinateur" value="1">
            <div id="formContainerOrdinateur">
              <div class="formRow">
                <input type="text" name="nom[]" placeholder="Nom de la depense">
                <input type="text" name="prix[]" placeholder="Prix">
               <button type="button" onclick="removeRow(this)">❌</button>
              </div>
            </div>
            <div class="button-container">
              <button type="button" onclick="addRow('formContainerOrdinateur')">Ajouter une ligne</button>
              <button type="submit">Enregistrer</button>
            </div>
        </form>
      </div>
</div>
  <script>
    // Fonction pour afficher/masquer une section
    function toggleSection(sectionId) {
    // Récupère toutes les sections
    var sections = document.querySelectorAll('.section');
    
    // Désactive toutes les sections
    sections.forEach(function(section) {
        if (section.id !== sectionId) {
            section.style.display = 'none';
        }
    });
    
    // Active la section souhaitée
    var section = document.getElementById(sectionId);
    section.style.display = (section.style.display === "none" || section.style.display === "") ? "block" : "none";
}

// Fonction pour afficher/masquer la liste des matériels
function toggleList(listId) {
    var list = document.getElementById(listId);
    list.style.display = (list.style.display === "none" || list.style.display === "") ? "block" : "none";
}


// Fonction pour ajouter une ligne dans le formulaire
function addRow(formContainerId) {
    var container = document.getElementById(formContainerId);

    // Crée une nouvelle ligne
    var newRow = document.createElement('div');
    newRow.classList.add('formRow');

    // Crée les champs pour la nouvelle ligne
    var nomInput = document.createElement('input');
    nomInput.type = 'text';
    nomInput.name = 'nom[]';
    nomInput.placeholder = "Nom de la depense";
    
    var prixInput = document.createElement('input');
    prixInput.type = 'text';
    prixInput.name = 'prix[]';
    prixInput.placeholder = "Prix";

    var removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.textContent = '❌';
    removeButton.onclick = function() {
        removeRow(removeButton);
    };

    // Ajoute les champs dans la nouvelle ligne
    newRow.appendChild(nomInput);
    newRow.appendChild(prixInput);
    newRow.appendChild(removeButton);

    // Ajoute la nouvelle ligne au conteneur
    container.appendChild(newRow);
}

// Fonction pour supprimer une ligne du formulaire
function removeRow(button) {
    var row = button.parentNode;
    row.parentNode.removeChild(row);
}

// Fonction pour ouvrir/fermer le menu hamburger
function toggleMenu() {
    var menu = document.querySelector('.menu');
    var hamburger = document.querySelector('.hamburger');
    
    menu.classList.toggle('active');
    hamburger.classList.toggle('active');
}

// Fonction pour filtrer les lignes des tableaux en fonction de la barre de recherche
function searchTable(type) {
    let input, filter, table, tr, td, i, txtValue;
    
    if (type === 'ordinateur') {
        input = document.getElementById('searchOrdinateurs');
        table = document.getElementById('ordinateurList').getElementsByTagName('table')[0];
    } else {
        input = document.getElementById('searchAutres');
        table = document.getElementById('autresList').getElementsByTagName('table')[0];
    }

    filter = input.value.toUpperCase();
    tr = table.getElementsByTagName('tr');

    // Parcourir toutes les lignes de la table et masquer celles qui ne correspondent pas à la recherche
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName('td');
        if (td.length > 0) {
            let rowContainsSearch = false;

            for (let j = 0; j < td.length; j++) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    rowContainsSearch = true;
                    break;
                }
            }

            if (rowContainsSearch) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

  </script>
</body>
</html>
