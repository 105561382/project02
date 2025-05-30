<?php
require_once("settings.php");
session_start();

if (!$conn) {
    die("<script>alert('Login database not installed in database! e.i. Get it from Ethan'); window.location.href='index.php';</script>");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    $sql = "SELECT * FROM login WHERE username = '$username' AND password = '$password' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) === 1) {
        $_SESSION['is_manager'] = true;
        header("Location: manage.php");
        exit();
    } else {
        echo "<script>alert('Invalid management username or password. Access denied.'); window.location.href='index.php';</script>";
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
