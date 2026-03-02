<?php
require_once("../config.php");
// On garde la sécurité admin pour que l'atelier soit réaliste

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Diagnostic Réseau - Admin</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .admin-container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; }
        input[type="text"] { width: 70%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 20px; background: #34495e; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .result-box { background: #2d2d2d; color: #00ff00; padding: 20px; border-radius: 5px; margin-top: 20px; font-family: 'Courier New', monospace; white-space: pre-wrap; overflow-x: auto; }
    </style>
</head>
<body>

<div class="admin-container">
    <?php require_once "menu-admin.php"; ?>

    <h1>Diagnostic Serveur (Taille de dossier)</h1>
    <p>Entrez une chemin de dossier.</p>

    <form method="POST">
        <input type="text" name="target" placeholder="/var/www/html par exemple" required>
        <button type="submit">Lancer le Test</button>
    </form>

    <?php
    if (isset($_POST['target'])) {
        $target = $_POST['target'];

        echo "<h3>Résultat pour : " . htmlspecialchars($target) . "</h3>";
        echo "<div class='result-box'>";

        // LA FAILLE EST ICI : On concatène directement la saisie dans la commande shell
        // Exemple de paramètre /var/www/html
        $cmd = "du -sh " . $target;

        // shell_exec exécute la commande et retourne le résultat sous forme de chaîne
        $output = shell_exec($cmd);

        echo $output;
        echo "</div>";
    }
    ?>
</div>

</body>
</html>