<form method="post" action="enhancements.php">
  <label>Username: <input type="text" name="username" required></label><br>
  <label>Password: <input type="password" name="password" required></label><br>
  <button type="submit">Login</button>
</form>
<?php
session_start();
if (isset($_SESSION['error'])) {
  echo "<p style='color:red'>" . $_SESSION['error'] . "</p>";
  unset($_SESSION['error']);
}
?>