<?php
require_once "./config/dbConfig.php";
require_once "./shared/PasswordManager.php";
require_once "./shared/tokenManager.php";

header("Content-Type: application/json");

$method = $_SERVER["REQUEST_METHOD"];

if ($method !== "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Metodo non consentito"]);
    exit;
}

// Legge JSON dal body
$data = json_decode(file_get_contents("php://input"), true);

$email = $data["email"] ?? "";
$password = $data["password"] ?? "";

if (empty($email) || empty($password)) {
    http_response_code(400);
    echo json_encode(["error" => "Dati mancanti"]);
    exit;
}

// Cerca utente
$field = (strpos($email, "@") !== false) ? "email" : "username";

$result = getData("users", [$field => $email]);

if (!$result || count($result) == 0) {
    echo json_encode(["error" => "Utente non trovato"]);
    exit;
}

$userData = $result[0];

// Verifica password
if (!verifyPassword($password, $userData["password"])) {
    echo json_encode(["error" => "Password errata"]);
    exit;
}

// Crea token e salva nel database
$token = createToken();
saveCookieToken($token, $userData["uuid"]);

sendData("users", ["token" =>hash('sha256', $token)], ["uuid" => $userData["uuid"]]);

// Successo
echo json_encode([
    "success" => true,
    "user" => [
        "uuid" => $userData["uuid"],
        "email" => $userData["email"]
    ]
]);