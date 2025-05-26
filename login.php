
<?php
    session_start();
    ini_set('display_errors', 1);

    // Set lockout parameters
    $max_attempts = 3;
    $lockout_time = 300; // seconds (5 minutes)

    // Initialize session variables if not set
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }
    if (!isset($_SESSION['lockout_until'])) {
        $_SESSION['lockout_until'] = 0;
    }

    // Check if user is locked out
    if (time() < $_SESSION['lockout_until']) {
        $remaining = $_SESSION['lockout_until'] - time();
        echo "⏳ Too many failed login attempts. Please try again in " . ceil($remaining/60) . " minute(s).";
        exit();
    }
?>

<form method="post" action="">
    <label for="username">Username:</label>
    <input type="text" name="username" required>

    <br>

    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <br>

    <input type="submit" name="Login">
</form>

<?php
    require_once("settings.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$conn) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        // Use prepared statements to prevent SQL injection
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ? AND password = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $username, $password);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $users = mysqli_fetch_assoc($result);

            if ($users) {
                $_SESSION['username'] = $username;
                $_SESSION['login_attempts'] = 0; // reset attempts on success
                $_SESSION['lockout_until'] = 0;
                header("Location: profile.php");
                exit();
            } else {
                $_SESSION['login_attempts'] += 1;
                if ($_SESSION['login_attempts'] >= $max_attempts) {
                    $_SESSION['lockout_until'] = time() + $lockout_time;
                    echo "⏳ Too many failed login attempts. Please try again later.";
                } else {
                    echo "❌ Incorrect username or password.";
                    echo "<br>";
                    echo "<a href='login.php'>Try again</a>";
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Database query error: " . mysqli_error($conn);
        }
    }
?>
