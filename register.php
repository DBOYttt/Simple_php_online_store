<?php
session_start();

// Pobieranie danych z formularza
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Sprawdzanie, czy wszystkie pola zostały wypełnione
if(empty($name) || empty($email) || empty($password)){
    $_SESSION['error'] = 'Wszystkie pola są wymagane.';
    header('Location: register_form.html');
    exit();
}

// Połączenie z bazą danych
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Create database and table if not exists
createDBandTable($conn, $dbname);

// Hashing the password
$password = password_hash($password, PASSWORD_DEFAULT);

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $password);

// Execute the statement
$stmt->execute();

$stmt->close();
$conn->close();

// Rejestracja zakończona pomyślnie
$_SESSION['message'] = 'Rejestracja zakończona pomyślnie. Możesz się teraz zalogować.';
header('Location: login_form.php');
exit();

// Function to create database and table if not exists
function createDBandTable($conn, $dbname) {
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql) === TRUE) {
        $conn->select_db($dbname);
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            name VARCHAR(30) NOT NULL,
            email VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL)";
        $conn->query($sql);
    } else {
        echo "Error creating database: " . $conn->error;
    }
}
?>
