<?php
session_start();

// Pobieranie danych z formularza
$email = $_POST['email'];
$password = $_POST['password'];

// Sprawdzanie, czy wszystkie pola zostały wypełnione
if(empty($email) || empty($password)){
    $_SESSION['error'] = 'Wszystkie pola są wymagane.';
    header('Location: login_form.php');
    exit();
}

// Połączenie z bazą danych
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Prepare and bind
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);

// Execute the statement
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows === 0){
    $_SESSION['error'] = 'Nie ma takiego konta.';
    header('Location: login.php');
    exit();
}

$user = $result->fetch_assoc();

if(password_verify($password, $user['password'])){
    $_SESSION['user'] = $user;
    header('Location: shop_form.php');
    exit();
}
else {
    $_SESSION['error'] = 'Hasło jest niepoprawne.';
    header('Location: login.html');
    exit();
}

$stmt->close();
$conn->close();
?>
