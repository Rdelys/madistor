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
  <title>Stock</title>
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
      margin-top: 20px;
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

  </style>
</head>
<body>
  <div class="navbar">
    <div class="logo">
      <img src="images/logo/logo.png" alt="Logo" onerror="this.style.display='none'">
    </div>
    <!-- Menu -->
    <ul class="menu">
      <li><a href="#dashboard">Dashboard</a></li>
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
          <a href="#sav1">Sous-menu 1</a>
          <a href="#sav2">Sous-menu 2</a>
        </div>
      </li>
      <li class="dropdown">
        <a href="etagere.php">Étagère</a>
      </li>
    </ul>

    <!-- Hamburger Button -->
    <div class="hamburger" onclick="toggleMenu()">
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>

  <div class="content">
    <!-- Buttons to toggle between sections -->
    <button class="btn" onclick="toggleSection('listStock')">Liste Stock</button>
    <button class="btn" onclick="toggleSection('addStock')">Ajouter Stock</button>
    
    <!-- Liste Stock Section -->
    <div id="listStock" class="section">
      <h2>Liste des stocks</h2>
      <button class="btn" onclick="toggleList('ordinateurList')">Ordinateurs</button>
      <button class="btn" onclick="toggleList('autresList')">Autres Matériels</button>

      <div id="ordinateurList" class="stock-list" style="display: none;">
        <h3>Liste des Ordinateurs</h3>
        <table border="1">
          <thead>
            <tr>
              <th>Marque</th>
              <th>Modèle</th>
              <th>RAM</th>
              <th>Disque Dur</th>
              <th>Graphique</th>
              <th>Accessoire</th>
              <th>Prix d'achat</th>
              <th>Prix de vente</th>
           </tr>
          </thead>
        <tbody>
        <?php
        require 'connexion.php';
        $sql = "SELECT * FROM ordinateurs";
        $result = $pdo->query($sql);
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          echo "<tr>
                  <td>{$row['marque']}</td>
                  <td>{$row['modele']}</td>
                  <td>{$row['ram']}</td>
                  <td>{$row['disque_dur']}</td>
                  <td>{$row['graphique']}</td>
                  <td>{$row['accessoire']}</td>
                  <td>{$row['prixAchat']}</td>
                  <td>{$row['prixVente']}</td>
                </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <div id="autresList" class="stock-list" style="display: none;">
    <h3>Liste des Autres Matériels</h3>
    <table border="1">
      <thead>
        <tr>
          <th>Marque</th>
          <th>Description</th>
          <th>Prix d'achat</th>
          <th>Prix de vente</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM autres_materiels";
        $result = $pdo->query($sql);
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          echo "<tr>
                  <td>{$row['marque']}</td>
                  <td>{$row['description']}</td>
                  <td>{$row['prixAchat']}</td>
                  <td>{$row['prixVente']}</td>
                </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
    <div id="addStock" class="section">
      <h2>Ajouter un stock</h2>
      <button class="btn" onclick="showForm('ordinateur')">Ordinateur</button>
      <button class="btn" onclick="showForm('autres')">Autres matériels</button>

      <div id="ordinateurForm" class="stock-form">
        <form id="stockFormOrdinateur" action="ajout_stock.php" method="POST">
          <input type="hidden" name="stock_ordinateur" value="1">
            <div id="formContainerOrdinateur">
              <div class="formRow">
                <input type="text" name="marque[]" placeholder="Marque">
                <input type="text" name="modele[]" placeholder="Modèle">
                <input type="text" name="ram[]" placeholder="RAM">
                <input type="text" name="dur[]" placeholder="Disque Dur">
                <input type="text" name="graphique[]" placeholder="Graphique">
                <input type="text" name="accessoire[]" placeholder="Accessoire">
                <input type="text" name="prixAchat[]" placeholder="Prix d'achat">
                <input type="text" name="prixVente[]" placeholder="Prix de vente">
                <button type="button" onclick="removeRow(this)">❌</button>
              </div>
            </div>
            <div class="button-container">
              <button type="button" onclick="addRow('formContainerOrdinateur')">Ajouter une ligne</button>
              <button type="submit">Enregistrer</button>
            </div>
        </form>
      </div>

  <div id="autresForm" class="stock-form" style="display:none;">
    <form id="stockFormAutres" action="ajout_stock.php" method="POST">
      <input type="hidden" name="stock_autres" value="1">
        <div id="formContainerAutres">
          <div class="formRow">
            <input type="text" name="marque[]" placeholder="Marque">
            <input type="text" name="description[]" placeholder="Description">
            <input type="text" name="prixAchat[]" placeholder="Prix d'achat">
            <input type="text" name="prixVente[]" placeholder="Prix de vente">
            <button type="button" onclick="removeRow(this)">❌</button>
          </div>
        </div>
        <div class="button-container">
          <button type="button" onclick="addRow('formContainerAutres')">Ajouter une ligne</button>
          <button type="submit">Enregistrer</button>
        </div>
    </form>
  </div>
</div>

  <script>
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

    function addRow(containerId) {
    var container = document.getElementById(containerId);
    var newRow = document.createElement("div");
    newRow.className = "formRow";
    newRow.innerHTML = containerId === 'formContainerOrdinateur' ?
      '<input type="text" name="marque[]" placeholder="Marque">' +
      '<input type="text" name="modele[]" placeholder="Modèle">' +
      '<input type="text" name="ram[]" placeholder="RAM">' +
      '<input type="text" name="dur[]" placeholder="Disque Dur">' +
      '<input type="text" name="graphique[]" placeholder="Graphique">' +
      '<input type="text" name="accessoire[]" placeholder="Accessoire">' +
      '<input type="text" name="prixAchat[]" placeholder="Prix d'/'achat">' +
      '<input type="text" name="prixVente[]" placeholder="Prix de vente">' +
      '<button type="button" onclick="removeRow(this)">❌</button>' :
      '<input type="text" name="marque[]" placeholder="Marque">' +
      '<input type="text" name="description[]" placeholder="Description">' +
      '<input type="text" name="prixAchat[]" placeholder="Prix d'/'achat">' +
      '<input type="text" name="prixVente[]" placeholder="Prix de vente">' +
      '<button type="button" onclick="removeRow(this)">❌</button>';
    container.appendChild(newRow);
  }

  function removeRow(button) {
    button.parentElement.remove();
  }

  function showForm(type) {
    document.getElementById('ordinateurForm').style.display = (type === 'ordinateur') ? 'block' : 'none';
    document.getElementById('autresForm').style.display = (type === 'autres') ? 'block' : 'none';
  }

  const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');

    if (message === "ok") {
        alert("Données ajoutées avec succès !");
    } else if (message === "nok") {
        alert("Erreur lors de l'ajout des données !");
    }

    function toggleList(listId) {
    document.getElementById('ordinateurList').style.display = (listId === 'ordinateurList') ? 'block' : 'none';
    document.getElementById('autresList').style.display = (listId === 'autresList') ? 'block' : 'none';
  }

  function clearCacheAndReload() {
    // Afficher l'alerte
    if (confirm("Êtes-vous sûr de vouloir continuer ?")) {
        // Forcer la suppression du cache en rechargant la page avec un identifiant unique
        var url = window.location.href;
        
        // Ajouter un paramètre unique (timestamp) à l'URL pour éviter le cache
        var newUrl = url.indexOf('?') > -1 ? url + '&t=' + new Date().getTime() : url + '?t=' + new Date().getTime();

        // Rediriger vers la même page avec un paramètre unique
        window.location.href = newUrl;
    }
}

  </script>
</body>
</html>
