<?php
require_once("settings.php");
session_start();

if (!$conn) {
    echo "<script>alert('Login database not installed!'); window.location.href='index.php';</script>";
    exit();
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM login WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['password'] = $user['password'];
        header("Location: manage.php");
        exit();
    } else {
        echo "<script>alert('Invalid username or password'); window.location.href='index.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Please enter username and password'); window.location.href='index.php';</script>";
    exit();
}
?>
