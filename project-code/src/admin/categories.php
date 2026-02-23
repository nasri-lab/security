<?php 
require_once("../config.php");

// SÉCURITÉ : Vérifier si l'utilisateur est admin
if (!isset($_COOKIE['user_role']) || $_COOKIE['user_role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Catégories - Admin</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .admin-container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        
        h1 { color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #34495e; color: white; padding: 12px; text-align: left; font-size: 14px; }
        td { padding: 12px; border-bottom: 1px solid #eee; color: #444; }
        tr:hover { background-color: #f1f4f6; }

        .btn-view { 
            background-color: #3498db; 
            color: white; 
            padding: 6px 12px; 
            text-decoration: none; 
            border-radius: 4px; 
            font-size: 13px;
            transition: 0.2s;
        }
        .btn-view:hover { background-color: #2980b9; }

        .badge-id { 
            background: #95a5a6; 
            color: white; 
            padding: 2px 6px; 
            border-radius: 4px; 
            font-family: monospace; 
        }
    </style>
</head>
<body>

<div class="admin-container">
    <?php require_once "menu-admin.php"; ?>

    <h1>Liste des Catégories</h1>
    <p style="color: #7f8c8d;">Sélectionnez une catégorie pour gérer ses produits associés.</p>

    <?php 
        $result = $conn->query("SELECT * FROM category");

        if ($result->num_rows <= 0) {
            echo '<div style="padding: 20px; background: #fff3cd; border-radius: 5px;">Aucune catégorie trouvée.</div>'; 
        } else {
    ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th>Nom de la catégorie</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><span class="badge-id"><?php echo $row["id"]; ?></span></td>
                        <td><strong><?php echo $row["label"]; ?></strong></td>
                        <td>
                            <a href="products.php?category_id=<?php echo $row["id"]; ?>" class="btn-view">
                                📦 Voir les produits
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php 
        }
        $conn->close(); 
    ?>
</div>

</body>
</html>