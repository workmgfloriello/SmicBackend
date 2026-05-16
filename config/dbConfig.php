<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "my_smiccafe";

$conn = mysqli_connect($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getConnection()
{
    global $conn;
    return $conn;
}

function sendData($table, $data, $filters = [])
{
    $conn = getConnection();

    // INSERT
    if (empty($filters)) {

        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $stmt = $conn->prepare($sql);

        $types = str_repeat("s", count($data));
        $values = array_values($data);

        $stmt->bind_param($types, ...$values);

    } else {

        // UPDATE
        $set = [];
        $values = [];
        $types = "";

        foreach ($data as $column => $value) {
            $set[] = "$column = ?";
            $values[] = $value;
            $types .= "s";
        }

        $conditions = [];

        foreach ($filters as $column => $value) {
            $conditions[] = "$column = ?";
            $values[] = $value;
            $types .= "s";
        }

        $sql = "UPDATE $table SET " . implode(", ", $set) .
               " WHERE " . implode(" AND ", $conditions);

        $stmt = $conn->prepare($sql);

        $stmt->bind_param($types, ...$values);
    }

    return $stmt->execute();
}

function getData($table, $filters = [], $parameter = "*")
{
    $conn = getConnection();

    $sql = "SELECT $parameter FROM $table";

    // 👉 SENZA FILTRI
    if (empty($filters)) {
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // 👉 CON FILTRI
    $conditions = [];
    $values = [];
    $types = "";

    foreach ($filters as $column => $value) {
        $conditions[] = "$column = ?";
        $values[] = $value;
        $types .= "s";
    }

    $sql .= " WHERE " . implode(" AND ", $conditions);

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$values);
    $stmt->execute();

    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}
