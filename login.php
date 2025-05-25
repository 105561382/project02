<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Replace these with your actual DB credentials
    $db_user = 'your_db_username';
    $db_pass = 'your_db_password';
    $db_name = 'it_rizz';

    $conn = mysqli_connect('localhost', $db_user, $db_pass, $db_name);

    if (!$conn) {
        $_SESSION['error'] = 'Database connection failed.';
        header('Location: login.php');
        exit();
    }

    // Example authentication logic (replace with your own)
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['username'] = $username;
        header('Location: enhancements.php');
        exit();
    } else {
        $_SESSION['error'] = 'Invalid username or password.';
        header('Location: login.php');
        exit();
    }
}
?>