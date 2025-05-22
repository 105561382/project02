<?php
session_start();
require_once("settings.php");
$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
  error_log("Database connection failed: " . mysqli_connect_error());
    die("Database connection failed: ". mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $input_username = trim($_POST["username"]);
     $input_password = trim($_POST["password"]);
     
      // Sql for query to check if username and password are matching with the database
     $stmt->$conn ("SELECT users, password FROM users WHERE username = ?");
     $stmt->bind_param("s", $input_username);
     $stmt->execute();
     $result = $stmt->get_result();

     // if the username and password found

      if ($user = $result ->fetch_assoc()) {
          if (password_verify($input_password, $user["password"])) {
              session_regenerate_id(true); // regenerate session id to prevent session fixation

              
            // save the username and password in the session to know the user logged in
          $_SESSION["username"] = $user["username"];
          $_SESSION["password"] = $user["password"];
          // redirect to the jobs page
          header("Location: jobs.php");
          exit;
      } else {
          header ('Location: about.php');
          exit;
      }
    }
  }else {
    // if the username and password not found

    $_SESSION['error'] = "Invalid username or password" ;
    header("Location: login.php");
    exit();
  }
    ?>

