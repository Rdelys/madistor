<div class="navbar">
    <div class="logo">
      <img src="images/logo/logo.png" alt="Logo" onerror="this.style.display='none'">
    </div>
    <!-- Menu -->
    <ul class="menu">
      <li><a href="dashboard.php">Dashboard</a></li>
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
      <li class="dropdown">
        <a href="depense.php">Depenses</a>
      </li>
    </ul>

    <!-- Hamburger Button -->
    <div class="hamburger" onclick="toggleMenu()">
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>