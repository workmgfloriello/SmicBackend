<?php
require_once "./config/dbConfig.php";
header("Content-Type: application/json");

$method = $_SERVER["REQUEST_METHOD"];
$category = $_GET["category"] ?? null;


if ($method === "GET") {
    echo json_encode(getData("products", $category ? ["category" => $category] : []));
}else if ($method === "POST") {

    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["name"], $data["price"], $data["available"], $data["category"])) {
    http_response_code(400);
    echo json_encode(["error" => "Dati mancanti"]);
    exit;
}

    $result = sendData(
        "products",
        [
            "name" => $data["name"],
            "price" => $data["price"],
            "available" => $data["available"] ? 1 : 0,
            "category" => $data["category"],
        ]
    );

    echo json_encode(["success" => $result]);
}else {
    http_response_code(405);
    echo json_encode(["error" => "Metodo non consentito"]);
}
