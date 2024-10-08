<?php
session_start();
$servername = "192.168.1.41";
$username = "database";
$password = "DataAdm1n*";
$dbname = "users";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        if (password_verify($pass, $hashed_password)) {
            $_SESSION['username'] = $user;
            echo json_encode(["success" => true]);
            exit();
        }
    }
    echo json_encode(["success" => false]);
}
$stmt->close();
$conn->close();
?>
