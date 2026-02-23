<?php
require_once("config.php");

// 1. On initialise le compteur à 0
$total_items = 0;
$user_id = 123; // Votre ID utilisateur statique

// 2. On compte la somme des quantités dans le panier
$conn_menu = new mysqli($servername, $username, $password, $dbname);
if (!$conn_menu->connect_error) {
    $sql_count = "SELECT SUM(quantity) as total FROM cart WHERE user_id = $user_id";
    $res_count = $conn_menu->query($sql_count);
    if ($res_count) {
        $row_count = $res_count->fetch_assoc();
        $total_items = $row_count['total'] ?? 0; // Si le panier est vide, on met 0
    }
    $conn_menu->close();
}
?>

<style>
    /* Reset & Style de la Navbar */
    .navbar {
        background-color: #2c3e50;
        padding: 0.8rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        border-radius: 8px;
    }

    .navbar-brand {
        color: #ecf0f1;
        font-weight: bold;
        font-size: 1.2rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .navbar-links {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    /* Style des liens du menu */
    .nav-link {
        color: #bdc3c7;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        padding: 8px 12px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .nav-link:hover {
        color: #ffffff;
        background-color: rgba(255, 255, 255, 0.1);
    }

    /* Style spécial pour le bouton Admin */
    .nav-link-admin {
        background-color: #e67e22;
        color: white !important;
    }

    .nav-link-admin:hover {
        background-color: #d35400;
    }

    /* Séparateur visuel (remplace les tirets) */
    .nav-separator {
        width: 1px;
        height: 20px;
        background-color: #455a64;
    }
.badge-cart {
        background-color: #e74c3c;
        color: white;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 11px;
        margin-left: 5px;
        vertical-align: middle;
        font-weight: bold;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .nav-link {
        display: flex;
        align-items: center;
    }
</style>

<nav class="navbar">
    <a href="home.php" class="navbar-brand">🛒 MaBoutique</a>

    <div class="navbar-links">
        <a href="home.php" class="nav-link">Tous les produits</a>
        <div class="nav-separator"></div>
        
        <a href="panier.php?u=123" class="nav-link">
            Mon panier 
            <?php if ($total_items > 0): ?>
                <span class="badge-cart"><?php echo $total_items; ?></span>
            <?php endif; ?>
        </a>
        
        <a href="profil.php?u=123" class="nav-link">Mon profil</a>
        <a href="logout.php" class="nav-link" style="color: #e74c3c;">Déconnexion</a>
        
        <div class="nav-separator"></div>
        <a href="admin/admin.php" class="nav-link nav-link-admin">Admin</a>
    </div>
</nav>