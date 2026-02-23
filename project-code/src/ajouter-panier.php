<?php
require_once("config.php");

// 1. Récupération des données
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = 123; // ID utilisateur fixe

if ($product_id > 0) {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    // 2. Logique d'ajout ou de mise à jour (Cumulatif)
    $check = $conn->query("SELECT id, quantity FROM cart WHERE user_id = $user_id AND product_id = $product_id");

    if ($check->num_rows > 0) {
        // Déjà présent : on incrémente
        $row = $check->fetch_assoc();
        $new_qty = $row['quantity'] + 1;
        $sql = "UPDATE cart SET quantity = $new_qty WHERE id = " . $row['id'];
    } else {
        // Nouveau : on insère
        $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)";
    }

    // 3. Exécution et redirection vers la LISTE
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        // Redirige vers home.php au lieu de panier.php
        header("Location: home.php?added=1"); 
        exit();
    } else {
        $conn->close();
        header("Location: home.php?error=1");
        exit();
    }
} else {
    header("Location: home.php");
    exit();
}