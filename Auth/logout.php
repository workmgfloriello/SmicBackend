<?php
require_once "./config/dbConfig.php";
require_once "./shared/tokenManager.php";

header("Content-Type: application/json");

$method = $_SERVER["REQUEST_METHOD"];

if ($method !== "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Metodo non consentito"]);
    exit;
}

// Recupera il token dal cookie
$token = $_COOKIE["auth_token"] ?? "";

if (empty($token)) {
    http_response_code(400);
    echo json_encode(["error" => "Token mancante"]);
    exit;
}

// Hash del token per confrontarlo con il database
$hashedToken = hash('sha256', $token);

// Rimuove il token dal database
sendData("users", ["token" => null], ["token" => $hashedToken]);

// Elimina il cookie
setcookie(
    "auth_token",
    "",
    time() - 3600,
    "/",
    "",
    false,
    true
);

// Risposta di successo
echo json_encode([
    "success" => true,
    "message" => "Logout effettuato con successo"
]);
?>