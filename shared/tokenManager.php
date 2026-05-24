<?php
require_once "./config/dbConfig.php";

function createToken(){
    $token = bin2hex(random_bytes(16)); // Genera un token casuale
    return $token;
}

function saveCookieToken($token, $uuid)
{
    $cookieString = "$token|$uuid";
echo "Saving token: $cookieString\n";
    setcookie(
        "auth_token",
        $cookieString,
        time() + 8400,
        "/"
    );
    echo $_COOKIE["auth_token"] ?? "Cookie not set yet\n";
}

function verifyToken() {
    $cookieToken = $_COOKIE["auth_token"] ?? null;
    if (!$cookieToken) {
        return false;
    }

    list($storedToken, $uuid) = explode("|", $cookieToken);

    $result = getData("users", ["token" => $storedToken], "uuid");

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