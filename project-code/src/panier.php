<?php 
require_once("config.php");
require_once("menu.php"); 

$user_id = isset($_GET['u']) ? $_GET['u'] : 123; // Securisé
//$user_id = isset($_GET['u']) ? intval($_GET['u']) : 123; // Securisé

$conn = new mysqli($servername, $username, $password, $dbname);
$grand_total = 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier - MaBoutique</title>
    <style>
        /* Harmonisation avec le reste du site */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #3498db;
            color: white;
            padding: 12px 15px;
            text-align: left;
            text-transform: uppercase;
            font-size: 14px;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        /* Styles spécifiques aux éléments du panier */
        .price {
            font-weight: bold;
            color: #27ae60;
        }

        .badge-qty {
            background: #e0e0e0;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: bold;
        }

        .btn-delete {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
        }

        .btn-delete:hover {
            text-decoration: underline;
        }

        .cart-footer {
            margin-top: 30px;
            padding: 20px;
            background: #ecf0f1;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-price {
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
        }

        .btn-checkout {
            background-color: #27ae60;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn-checkout:hover {
            background-color: #2ecc71;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Mon Panier</h1>

    <?php
    $sql = "SELECT c.id as cart_id, p.label, p.price, c.quantity 
            FROM cart c 
            INNER JOIN product p ON c.product_id = p.id 
            WHERE c.user_id = $user_id";

    //echo  $sql;
    
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0): 
    ?>
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix Unit.</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): 
                    $subtotal = $row['price'] * $row['quantity'];
                    $grand_total += $subtotal;
                ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($row['label']); ?></strong></td>
                    <td class="price"><?php echo number_format($row['price'], 2); ?> €</td>
                    <td><span class="badge-qty"><?php echo $row['quantity']; ?></span></td>
                    <td class="price"><?php echo number_format($subtotal, 2); ?> €</td>
                    <td>
                        <a href="supprimer-item.php?id=<?php echo $row['cart_id']; ?>" class="btn-delete" onclick="return confirm('Supprimer cet article ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="cart-footer">
            <a href="home.php" style="color: #7f8c8d; text-decoration: none;">← Continuer les achats</a>
            <div>
                <span style="margin-right: 15px;">Total à payer : <span class="total-price"><?php echo number_format($grand_total, 2); ?> €</span></span>
                <a href="commander.php" class="btn-checkout">Valider la commande</a>
            </div>
        </div>

    <?php else: ?>
        <p style="text-align: center; padding: 40px; color: #7f8c8d;">
            Votre panier est vide pour le moment.
        </p>
        <div style="text-align: center;">
            <a href="home.php" class="btn-checkout" style="background-color: #3498db;">Découvrir nos produits</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>