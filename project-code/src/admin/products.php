<?php 
require_once("../config.php");


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Récupération sécurisée du category_id (force l'entier)
$id_category = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Produits - Admin</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .admin-container { max-width: 1100px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        
        h1 { color: #2c3e50; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #34495e; color: white; padding: 12px; text-align: left; font-size: 14px; }
        td { padding: 12px; border-bottom: 1px solid #eee; color: #444; font-size: 14px; }
        tr:hover { background-color: #f9f9f9; }

        .description { color: #7f8c8d; font-style: italic; font-size: 13px; }
        
        .btn-delete { color: #e74c3c; text-decoration: none; font-weight: bold; }
        .btn-delete:hover { text-decoration: underline; }
        
        .add-link { 
            display: inline-block; 
            margin-top: 20px; 
            background: #27ae60; 
            color: white; 
            padding: 10px 15px; 
            text-decoration: none; 
            border-radius: 5px; 
            font-weight: bold;
        }
        .add-link:hover { background: #2ecc71; }
    </style>
</head>
<body>

<div class="admin-container">
    <?php require_once "menu-admin.php"; ?>

    <h1>Gestion des Produits</h1>

    <?php 
        $sql = "SELECT * FROM product WHERE id_category = $id_category";
        $result = $conn->query($sql);

        if ($result->num_rows <= 0) {
            echo '<p>Aucun produit trouvé dans cette catégorie.</p>'; 
        } else {
    ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Label</th>
                    <th>Cat.</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row["id"]; ?></td>
                        <td><strong><?php echo $row["label"]; ?></strong></td>
                        <td><span style="background: #eee; padding: 2px 6px; border-radius: 4px;"><?php echo $row["id_category"]; ?></span></td>
                        <td class="description"><?php echo $row["description"]; ?></td>
                        <td>
                            <a href="delete-product.php?id=<?php echo $row["id"]; ?>" 
                               class="btn-delete" 
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                               🗑 Supprimer
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

    <a href="add-product.php" class="add-link">+ Ajouter un nouveau produit</a>
</div>

</body>
</html>