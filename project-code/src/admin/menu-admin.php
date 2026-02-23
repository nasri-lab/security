<style>
    .admin-nav { 
        background: #2c3e50; 
        padding: 15px; 
        border-radius: 8px; 
        margin-bottom: 30px; 
        display: flex; 
        gap: 20px; 
        font-family: 'Segoe UI', sans-serif;
    }
    .admin-nav a { 
        color: white; 
        text-decoration: none; 
        font-weight: bold; 
        font-size: 14px; 
        opacity: 0.8; 
        transition: 0.3s;
    }
    .admin-nav a:hover { 
        opacity: 1; 
    }
</style>

<nav class="admin-nav">
    <a href="../home.php">⬅ Retour au Site</a>
    <a href="admin.php">Dashboard</a>
    <a href="categories.php">Gestion Produits</a>
    <a href="users.php">Gestion Utilisateurs</a>
    <a href="../logout.php" style="color: #e74c3c;">Déconnexion</a>
</nav>