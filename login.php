<?php
// Connect to database
require_once('db_connect.php'); // assume this connects and assigns $conn

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Check if account is locked
    if ($user['lockout_until'] && strtotime($user['lockout_until']) > time()) {
        echo "Your account is locked. Try again later.";
        exit;
    }

    // Check password
    if (password_verify($password, $user['password_hash'])) {
        // Successful login
        echo "Login successful!";
        
        // Reset failed attempts
        $reset = $conn->prepare("UPDATE users SET failed_attempts = 0, lockout_until = NULL WHERE username = ?");
        $reset->bind_param("s", $username);
        $reset->execute();
    } else {
        // Failed login
        $failedAttempts = $user['failed_attempts'] + 1;
        $lockoutUntil = null;

        if ($failedAttempts >= 3) {
            $lockoutUntil = date("Y-m-d H:i:s", strtotime("+15 minutes")); // lockout for 15 min
        }

        $update = $conn->prepare("UPDATE users SET failed_attempts = ?, last_failed_login = NOW(), lockout_until = ? WHERE username = ?");
        $update->bind_param("iss", $failedAttempts, $lockoutUntil, $username);
        $update->execute();

        echo "Invalid credentials. " . ($lockoutUntil ? "Account locked for 15 minutes." : "");
    }
} else {
    echo "User not found.";
}
?>
