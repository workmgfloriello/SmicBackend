<?php
require_once "./config/dbConfig.php";

$method = $_SERVER["REQUEST_METHOD"];
$category = $_GET["category"] ?? null;


if ($method === "GET") {
    echo json_encode(getData("products", $category ? ["category" => $category] : []));
}

if ($method === "POST") {

    $data = json_decode(file_get_contents("php://input"), true);

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
}
