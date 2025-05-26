<!DOCTYPE html>
<html lang="en">
	<!--
	Meta tags + Link to style sheet + Title of Page.
	-->
<head>
	<?php
        include 'header.inc';
        ?>
	<title>About</title>
    <link rel="stylesheet" href="styles/styles.css">
	
	<body id= "left_align">
	<!--
	Nav Menu Below that connects to all the pages and has an email link to fake email for company
	-->
  <?php
        include 'nav.inc';
        ?>
		<hr>
	<hr>
    <h1>ABOUT THE TEAM</h1>
	<!--
	In this first unordered list we have the team name, class time and day , student IDS , tutors name
	In the second contains each team member and their contributions to the project.
	in the table it contains the team member names and their interests.
	-->
	<section>
		<ul>
			<li>Group Name:</li>
			<ul>
				<li>IT WIZZ</li>
			</ul>
			<li>Class Time:</li>
			<ul>
				<li>Friday 8:30am</li>
			</ul>
			<li>Tutor:</li>
			<ul>
				<li>Razeen Hashmi</li>
			</ul>
		</ul>
		<div class="student-id">
		<ul>
			<li>Student IDs</li>
			<ul>
			<li>101613603</li>
			<li>105925483</li>
			<li>105561382</li>
			</ul>
		</ul>
		</div>
		<figure>
			<img src="styles/images/groupphoto2.jpg" alt="Photo of students In Group 2">
			<figcaption>This is Team 2 Group Members</figcaption>
		</figure>
		<h3>Team Interests</h3>
		<table>
			<tr>
			<th>George Salib</th>
			<th>Kevin Varghese</th>
			<th>Ethan Gibbons</th>
		</tr>
		<tr>
			<td>Debugging code at 2 AM with lo-fi beats and coffee</td>
			<td>Creating video games where cats run tech startups</td>
			<td>Hacking old calculators to play Tetris</td>
		</tr>
		<tr>
			<td>Training AI to write poetry about pizza</td>
			<td>Designing websites that roast your typing speed in real-time</td>
			<td>Collecting memes about semicolon errors and turning them into art</td>
		</tr>
		</table>
	</section>

        <h2>Individual Contribution</h2>
		<section>
			<dl>
				<dt>George Salib</dt>
				<dd>Created the about page and home page, worked on the CSS for the about page and layout,Modified the form validation  using php, Responsible for Submission.</dd>
				<dt>Kevin Varghese</dt>
				<dd>Created the application page and the css for it, Created a database, settings.php, include files.</dd>
				<dt>Ethan Gibbons</dt>
				<dd>Created the jobs page and css for it, also did home page css file, created Jobs table and manager.php file, Jira Management.</dd>
			</dl>
		</section>
	</body>