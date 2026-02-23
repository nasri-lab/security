<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Produits</title>
    <style>
        /* Style Global */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }

        /* Container du tableau */
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Style du Tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Style du bouton Panier */
        .btn-cart {
            display: inline-block;
            background-color: #27ae60;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            transition: background 0.3s;
        }

        .btn-cart:hover {
            background-color: #2ecc71;
        }

        /* Badge pour la catégorie */
        .badge {
            background: #e0e0e0;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <?php require_once "menu.php"; ?>

    <div class="container">
        <h1>Produits disponibles</h1>

        <?php 
            require_once("config.php");
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("<p style='color:red;'>Erreur de connexion</p>");
            }

            // Petite correction sur votre SQL : p.label pour le produit, c.label pour la catégorie
            $result = $conn->query("SELECT p.id, p.label as prod_label, c.label as cat_label 
                                   FROM product p 
                                   INNER JOIN category c ON c.id = p.id_category");

            if ($result->num_rows <= 0) {
                echo '<p>Aucun produit trouvé</p>'; 
            } else {
                echo '<table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Produit</th>
                                <th>Catégorie</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>';

                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td>#<?php echo $row["id"]; ?></td>
                        <td><strong><?php echo $row["prod_label"]; ?></strong></td>
                        <td><span class="badge"><?php echo $row["cat_label"]; ?></span></td>
                        <td>
                            <a href="ajouter-panier.php?id=<?php echo $row["id"]; ?>" class="btn-cart">
                                🛒 Ajouter
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                echo '</tbody></table>';
            }
            $conn->close(); 
        ?>
    </div>

</body>
</html>