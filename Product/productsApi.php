<?php
require_once "./config/dbConfig.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$method = $_SERVER["REQUEST_METHOD"];
$category = $_GET["category"] ?? null;


// ====================== GET ======================
if ($method === "GET") {

    $products = getData(
        "products",
        $category ? ["category" => $category] : []
    );

    // prendo varianti
    $variants = getData("product_variants");

    // organizzo varianti per product_id
    $groupedVariants = [];

    foreach ($variants as $v) {
        $groupedVariants[$v["product_id"]][] = [
            "nome" => $v["nome"],
            "prezzo" => (float)$v["prezzo"],
            "type" => $v["type"]
        ];
    }

    // attacco varianti ai prodotti
    $final = [];

    foreach ($products as $p) {
        $id = $p["id"];

        $final[] = [
            "id" => $id,
            "name" => $p["name"],
            "price" => (float)$p["price"],
            "category" => $p["category"],
            "available" => (int)$p["available"],
            "variante" => $groupedVariants[$id] ?? []
        ];
    }

    echo json_encode($final);
}


// ====================== POST ======================
else if ($method === "POST") {

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
}


// ====================== ERROR ======================
else {
    http_response_code(405);
    echo json_encode(["error" => "Metodo non consentito"]);
}