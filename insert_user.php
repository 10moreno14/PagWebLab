<?php
$servername = "192.168.1.41"; 
$username = "database";
$password = "DataAdm1n*";
$dbname = "users";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Datos del nuevo usuario
$new_username = 'smoreno';
$new_password = 'Octubre14.';
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Preparar y ejecutar la inserción
$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $new_username, $hashed_password);

if ($stmt->execute()) {
    echo "Usuario creado exitosamente.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
