<?php
require_once("../config.php");

// Test sur le cookie et le role

$conn = new mysqli($servername, $username, $password, $dbname);

$nb_products  = $conn->query("SELECT COUNT(*) as total FROM product")->fetch_assoc()['total'];
$nb_users     = $conn->query("SELECT COUNT(*) as total FROM account")->fetch_assoc()['total'];
$total_panier = $conn->query("SELECT SUM(quantity) as total FROM cart")->fetch_assoc()['total'];

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration - MaBoutique</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .admin-container { max-width: 1000px; margin: 0 auto; }
        h1 { color: #2c3e50; }
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-top: 4px solid #e67e22; }
        .stat-card h3 { margin: 0; color: #7f8c8d; font-size: 14px; text-transform: uppercase; }
        .stat-card .number { font-size: 32px; font-weight: bold; color: #2c3e50; margin-top: 10px; display: block; }
        .actions { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .btn-admin { display: inline-block; padding: 10px 20px; background: #3498db; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px; transition: 0.3s; }
        .btn-admin:hover { background: #2980b9; }
    </style>
</head>
<body>

<div class="admin-container">
    <?php require_once "menu-admin.php"; ?>

    <h1>Tableau de bord Admin</h1>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Produits en ligne</h3>
            <span class="number"><?php echo $nb_products; ?></span>
        </div>
        <div class="stat-card">
            <h3>Utilisateurs inscrits</h3>
            <span class="number"><?php echo $nb_users; ?></span>
        </div>
        <div class="stat-card">
            <h3>Articles en paniers</h3>
            <span class="number"><?php echo $total_panier ?? 0; ?></span>
        </div>
    </div>
</div>

</body>
</html>