<?php

header("Content-Type: application/json");

$api = $_GET["api"] ?? "";

switch ($api) {

    case "register":
        require_once "./auth/register.php";
        break;
    
    case "login":
        require_once "./auth/login.php";
        break;

    case "profile":
        require_once "./auth/profile.php";
        break;
    //http://localhost/SmicBackend?api=products&category=Gelati
    case "products":
        require_once "./Product/productsApi.php";
        break;

    default:
        echo json_encode([
            "error" => "Endpoint non valido"
        ]);
        break;
}