<script>
    function myFunction() {
        var managementId = prompt("Please enter your management ID:", "#5245");
        var validId = "#5245";

        if (managementId === validId) {

            window.location.href = "manage.php";
        } else if (managementId !== null) {

            alert("Invalid management ID. Access denied.");
        }
    }
</script>

<nav>
    <a href="index.php" title="Go to home page"><strong>HOME</strong></a>
    <a href="about.php" title="Go to about page"><strong>ABOUT</strong></a>
    <a href="jobs.php" title="Go to position description page">POSITIONS</a>
    <a href="apply.php" title="Go to application page"><strong>APPLICATIONS</strong></a>
    <a href="manage.php" title="Go to eoi management page" onclick="myFunction()">MANAGEMENT</a>
    <p id="demo"></p>
    <a href="mailto:info@TechShield.com.au" title="Email Us">EMAIL</a>
</nav>