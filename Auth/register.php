<?php
require_once "./config/dbConfig.php";
require_once "./shared/PasswordManager.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["email"], $data["password"],$data["name"], $data["address"], $data["phone"])) {
    http_response_code(400);
    echo json_encode(["error" => "Dati mancanti"]);
    exit;
}

$dati = [
    "uuid" => uniqid(),
    "email" => $data["email"],
    "password" => hashPassword($data["password"]),
    "name" => $data["name"],
    "address" => $data["address"],
    "phone" => $data["phone"]
];

return sendData("users", $dati);
