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
	<a href="manage.php" title="Go to eoi management page" onclick="myFunction()">EOI Management</a>
    <p id="demo"></p>
	<a href="https://github.com/George-Salib-Uni/Project-Part-1---IT-WIZZ.git" target="_blank" rel="noopener noreferrer">Github Repository</a>
	<a href="https://ethangibbons.atlassian.net/jira/software/projects/PP1IW/boards/34" target="_blank" rel="noopener noreferrer">Jira Project</a>
	<a href="https://jigsaw.w3.org/css-validator/check/referer">
	<img style="border:0;width:88px;height:31px"
		src="https://jigsaw.w3.org/css-validator/images/vcss"
		alt="Valid CSS!" />
		</a>
	<a href="https://jigsaw.w3.org/css-validator/check/referer">
		<img style="border:0;width:88px;height:31px"
		src="https://jigsaw.w3.org/css-validator/images/vcss-blue"
		alt="Valid CSS!" />
		</a>
</nav>
<h5>Tech Shield Lt &copy;</h5>