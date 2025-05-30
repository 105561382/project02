<script>
    function myFunction() {
        document.getElementById('loginModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('loginModal').style.display = 'none';
    }
</script>

<!-- Modal Login Form -->
<div id="loginModal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5);">
  <div style="background:#fff; margin:10% auto; padding:20px; border-radius:8px; width:300px; position:relative;">
    <form method="POST" action="login.php">
      <h3>Management Login</h3>
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required><br><br>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required><br><br>
      <button type="submit">Login</button>
      <button type="button" onclick="closeModal()">Cancel</button>
    </form>
  </div>
</div>

<nav>
    <a href="index.php" title="Go to home page"><strong>HOME</strong></a>
    <a href="about.php" title="Go to about page"><strong>ABOUT</strong></a>
    <a href="jobs.php" title="Go to position description page">POSITIONS</a>
    <a href="apply.php" title="Go to application page"><strong>APPLICATIONS</strong></a>
    <a href="#" title="Login to eoi management page" onclick="myFunction();return false;">LOGIN</a>
    <p id="demo"></p>
    <a href="mailto:info@TechShield.com.au" title="Email Us">EMAIL</a>
</nav>