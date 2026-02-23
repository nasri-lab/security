<?php 
require_once("config.php");
require_once("menu.php"); 

// 1. On récupère l'ID passé dans l'URL (ex: profil.php?u=123)
// Si rien n'est passé, on met 0 par défaut
$user_id = isset($_GET['u']) ? intval($_GET['u']) : 0;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erreur de connexion");
}

// 2. On va chercher l'utilisateur spécifique
$sql_user = "SELECT * FROM account WHERE id = $user_id";
$res_user = $conn->query($sql_user);
$user = $res_user->fetch_assoc();

// 3. On compte ses articles dans le panier
$sql_cart = "SELECT SUM(quantity) as total_qty FROM cart WHERE user_id = $user_id";
$res_cart = $conn->query($sql_cart);
$cart_data = $res_cart->fetch_assoc();
$nb_articles = $cart_data['total_qty'] ?? 0;

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil de <?php echo htmlspecialchars($user['name'] ?? 'Inconnu'); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .profile-header {
            text-align: center;
            border-bottom: 2px solid #f4f7f6;
            margin-bottom: 30px;
            padding-bottom: 20px;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            background-color: #3498db;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 15px;
            font-weight: bold;
        }

        .info-card {
            background: #f8f9fa;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 4px solid #3498db;
        }

        .label { color: #7f8c8d; font-size: 12px; text-transform: uppercase; display: block; }
        .value { font-size: 18px; font-weight: bold; color: #2c3e50; }

        .stats-banner {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-action {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <?php if ($user): ?>
        <div class="profile-header">
            <div class="profile-avatar">
                <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
            </div>
            <h1><?php echo htmlspecialchars($user['name']); ?></h1>
            <p style="color: #95a5a6;">Membre de MaBoutique</p>
        </div>

        <div class="info-card">
            <span class="label">Adresse Email</span>
            <span class="value"><?php echo htmlspecialchars($user['email']); ?></span>
        </div>

        <div class="info-card">
            <span class="label">Type de profil</span>
            <span class="value"><?php echo htmlspecialchars($user['profile']); ?></span>
        </div>

        <div class="stats-banner">
            <span>🛒 <strong><?php echo $nb_articles; ?></strong> article(s) dans votre panier</span>
            <a href="panier.php?u=<?php echo $user_id; ?>" style="color: #155724; font-weight: bold;">Voir le panier →</a>
        </div>

    <?php else: ?>
        <div style="text-align: center; padding: 50px;">
            <h2>Utilisateur non trouvé</h2>
            <p>L'ID fourni ne correspond à aucun compte.</p>
            <a href="home.php" class="btn-action">Retour à l'accueil</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>