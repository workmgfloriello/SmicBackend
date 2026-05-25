<?php
require_once "./config/dbConfig.php";

function createToken(){
    $token = bin2hex(random_bytes(16)); // Genera un token casuale
    return $token;
}

function verifyToken(): string|false {
    // Il frontend manda il token nell'header Authorization: Bearer <token>
    $headers = getallheaders();
    $authHeader = $headers["Authorization"] ?? $headers["authorization"] ?? null;

    if (!$authHeader || !str_starts_with($authHeader, "Bearer ")) {
        return false;
    }

    $token = substr($authHeader, 7); // Rimuove "Bearer "

    if (empty($token)) {
        return false;
    }

    $result = getData("users", ["token" => hash("sha256", $token)], "uuid");

    if (!$result || count($result) === 0) {
        return false;
    }

    return json_encode([
        "success" => true,
        "message" => "Token valido",
        "uuid"    => $result[0]["uuid"]
    ]);
}