<?php
session_start();
require_once("settings.php");
$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
  error_log("Database connection failed: " . mysqli_connect_error());
  die("Database connection failed: " . mysqli_connect_error());
}

// Initialize login attempts and lockout time if not set
if (!isset($_SESSION['login_attempts'])) {
  $_SESSION['login_attempts'] = 0;
  $_SESSION['lockout_time'] = 0;
}

$lockout_duration = 300; // lockout for 5 minutes (in seconds)

// Check for lockout
if ($_SESSION['login_attempts'] >= 3) {
  if (time() < $_SESSION['lockout_time']) {
    die("Too many failed login attempts. Please try again later.");
  } else {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['lockout_time'] = 0;
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $input_username = trim($_POST["username"]);
  $input_password = trim($_POST["password"]);

  // Prepare SQL statement
  $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ?");
  if ($stmt) {
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
      if (password_verify($input_password, $user["password"])) {
        session_regenerate_id(true); // regenerate session id to prevent session fixation

        // Save the username in the session to know the user logged in
        $_SESSION["username"] = $user["username"];
        // Reset login attempts on successful login
        $_SESSION['login_attempts'] = 0;
        $_SESSION['lockout_time'] = 0;
        // Redirect to the jobs page
        header("Location: jobs.php");
        exit;
      } else {
        // Password incorrect
        $_SESSION['login_attempts'] += 1;
        if ($_SESSION['login_attempts'] >= 3) {
          $_SESSION['lockout_time'] = time() + $lockout_duration;
          die("Too many failed login attempts. Please try again in 5 minutes.");
        }
        $_SESSION['error'] = "Invalid username or password";
        header('Location: enhancements.php');
        exit;
      }
    } else {
      // Username not found
      $_SESSION['login_attempts'] += 1;
      if ($_SESSION['login_attempts'] >= 3) {
        $_SESSION['lockout_time'] = time() + $lockout_duration;
        die("Too many failed login attempts. Please try again in 5 minutes.");
      }
      $_SESSION['error'] = "Invalid username or password";
      header("Location: enhancements.php");
      exit();
    }
    $stmt->close();
  } else {
    error_log("Prepare failed: " . $conn->error);
    die("Database error.");
  }
}
?>

<!-- HTML Login Form -->
<form method="post" action="enhancements.php">
  <label>Username: <input type="text" name="username" required></label><br>
  <label>Password: <input type="password" name="password" required></label><br>
  <button type="submit">Login</button>
</form>
<?php
if (isset($_SESSION['error'])) {
  echo "<p style='color:red'>" . $_SESSION['error'] . "</p>";
  unset($_SESSION['error']);
}
?>
    

