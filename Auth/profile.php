<?php
require_once "./shared/tokenManager.php";

header("Content-Type: application/json");

$method = $_SERVER["REQUEST_METHOD"];
echo "API: profile, Method: $method\n";

if ($method !== "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Metodo non consentito"]);
    exit;
}

$checkToken = verifyToken();

if($checkToken && json_decode($checkToken)->success) {
    $result = getData("users", ["uuid" => json_decode($checkToken)->uuid], "email, name, address, phone");

   echo json_encode([
        "success" => true,
        "profile" => [
            "data" => $result
        ]
    ]);
}else{
    http_response_code(401);
    echo json_encode([
        "success" => false,
        "message" => "Token non valido"
    ]);     
}