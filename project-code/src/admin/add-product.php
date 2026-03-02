<?php 
require_once("../config.php");

if(isset($_POST['libelle'])) {
    $libelle = $_POST['libelle'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price']; // On récupère le prix

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Note pour l'atelier : Cette requête est vulnérable aux injections SQL
    // Ordre des colonnes : id, label, price, id_category, description
    $query = "INSERT INTO product VALUES(null, '" . $libelle . "', " . $price . ", " . $category_id . ", '" . $description . "')";

    $result = $conn->query($query);

    if (!$result) {
        $error_msg = "Erreur SQL : " . $conn->error;
    } else {
        $conn->close(); 
        header ('Location:./products.php?category_id=' . $category_id);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Produit - Admin</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .admin-container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        
        h1 { color: #2c3e50; text-align: center; margin-bottom: 25px; }
        
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #7f8c8d; font-weight: bold; font-size: 14px; }
        
        input[type="text"], 
        input[type="number"], 
        textarea { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
            box-sizing: border-box; /* Évite que l'input dépasse */
            font-family: inherit;
        }

        textarea { height: 100px; resize: vertical; }
        
        .btn-submit { 
            background-color: #27ae60; 
            color: white; 
            border: none; 
            padding: 12px 20px; 
            width: 100%; 
            border-radius: 4px; 
            font-weight: bold; 
            cursor: pointer; 
            font-size: 16px;
            margin-top: 10px;
        }
        
        .btn-submit:hover { background-color: #2ecc71; }
        .error { color: #e74c3c; background: #fdf2f2; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="admin-container">
    <?php require_once "menu-admin.php"; ?>

    <h1>➕ Ajouter un produit</h1>

    <?php if(isset($error_msg)) echo "<div class='error'>$error_msg</div>"; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label>Libellé du produit</label>
            <input type="text" name="libelle" placeholder="ex: Casque Bluetooth" required />
        </div>

        <div class="form-group">
            <label>Prix (€)</label>
            <input type="number" step="0.01" name="price" placeholder="ex: 19.99" required />
        </div>

        <div class="form-group">
            <label>ID Catégorie</label>
            <input type="number" name="category_id" placeholder="ex: 1" required />
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" placeholder="Détails du produit..."></textarea>
        </div>

        <input type="submit" class="btn-submit" value="Enregistrer le produit" />
    </form>
    
    <p style="text-align: center; margin-top: 20px;">
        <a href="categories.php" style="color: #3498db; text-decoration: none;">← Annuler et revenir</a>
    </p>
</div>

</body>
</html>