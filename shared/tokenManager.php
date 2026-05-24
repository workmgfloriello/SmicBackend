<?php
require_once "./config/dbConfig.php";

function createToken(){
    $token = bin2hex(random_bytes(16)); // Genera un token casuale
    return $token;
}

function saveCookieToken($token, $uuid)
{
    $cookieString = "$token|$uuid";
    setcookie(
        "auth_token",
        $cookieString,
        time() + 8400,
        "/"
    );
}

function verifyToken() {
    $cookieToken = $_COOKIE["auth_token"] ?? null;
    if (!$cookieToken) {
        return false;
    }

    list($storedToken, $uuid) = explode("|", $cookieToken);

    $result = getData("users", ["token" => hash('sha256', $storedToken)], "uuid");

    if(!$result || count($result) == 0) {
        return false;
    }else{
        return json_encode([
        "success" => true,
        "message" => "Token valido",
        "uuid" => $uuid
    ]); 
    }
}