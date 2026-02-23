<?php 
    require_once("config.php");

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //$connectedId = null;
    $message = '';

    if(isset($_POST['email'])) {
        $email = $conn->real_escape_string($_POST['email']); // Sécurité
        $user_password = $_POST['password'];

        // Note: MD5 est obsolète pour la sécurité, mais je le garde pour rester compatible avec votre base actuelle
        $sql = "SELECT * FROM account WHERE email = '$email' AND password = '" . MD5($user_password) . "' ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            if($row = $result->fetch_assoc()) {
                //$connectedId = $row["id"];

				setcookie("user_id", $row["id"], time() + 3600, "/");
                setcookie("user_role", $row["profile"], time() + 3600, "/");

                header('Location: ./home.php');
                die();
            }
        } else {
            $message = 'Identifiants incorrects. Veuillez réessayer.';
        }
    }
    $conn->close(); 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - MaBoutique</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-card h1 {
            margin-top: 0;
            color: #2c3e50;
            text-align: center;
            font-size: 24px;
        }

        .error-msg {
            background-color: #ffeef0;
            color: #d73a49;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ffcfd4;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e0;
            border-radius: 8px;
            box-sizing: border-box; /* Important pour que le padding ne dépasse pas */
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background-color: #2980b9;
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #718096;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h1>Bienvenue</h1>

        <?php if ($message): ?>
            <div class="error-msg"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <form action='index.php' method="post">
            <div class="form-group">
                <label>Adresse Email</label>
                <input type="email" name="email" required placeholder="nom@exemple.com"/>
            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" required placeholder="••••••••"/>
            </div>

            <button type="submit" class="btn-login">Se connecter</button>
        </form>

        <div class="footer-text">
            Accès réservé aux membres.
        </div>
    </div>

</body>
</html>