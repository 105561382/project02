<!DOCTYPE html>
<html lang="en">
    <head>
       <?php
        include 'header.inc';
        ?>
        <title>Position Description</title>
       <link rel="stylesheet" href="styles/styles.css">
    </head>

    <body id= left_align>
        <header>
            <!--Header with title and navigation links-->
       <?php
        include 'nav.inc';
        ?>
		<hr>
            <hr>
            <h1><strong> Jobs Positions</strong></h1>
            <br>
        </header>

        <!--Listing for Network Administrator--> 
        <?php
            require_once("settings.php");
            

            $query = "SELECT * FROM jobs";
            $result = mysqli_query($conn, $query);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $jobTitle = $row['jobTitle'];
                    $jobReference = $row['jobReference'];
                    $salary = $row['salary'];
                    $description = $row['description'];
                    $positionReportsTo = $row['positionReportsTo'];
                    $positionInvolves = $row['positionInvolves'];
                    $essentialSkills = $row['essentialSkills'];
                    $preferableSkills = $row['preferableSkills'];


                    $positionInvolves = explode(",", $positionInvolves);
                    $essentialSkills = explode(",", $essentialSkills);
                    $preferableSkills = explode(",", $preferableSkills);

                    echo "<section>";
                    echo "<h3>$jobTitle</h3>";
                    echo "<p>Job Reference: $jobReference</p>";
                    echo "<p>Salary: $$salary per year</p>";
                    echo "<p>$description</p>";
                    echo "<p>This position will report to the $positionReportsTo</p>";
                    echo "<h4>This position Involves</h4>";
                    
                    echo "<ol>";
                    foreach ($positionInvolves as $item) {
                        echo "<li>$item</li>";
                    }
                    echo "</ol>";

                    echo "<br>";
                    
                    echo "<section>";
                    echo "<h4>Essential Skills</h4>";
                    echo "<ul>";
                    foreach ($essentialSkills as $essenSkill) {
                        echo "<li>$essenSkill</li>";
                    }
                    echo "</ul>";
                    echo "</section>";

                    echo "<br>";

                    echo "<section>";
                    echo "<h4>Preferable Skills</h4>";
                    echo "<ul>";
                    foreach ($preferableSkills as $preferSkill) {
                        echo "<li>$preferSkill</li>";
                    }
                    echo "</ul>";
                    echo "</section>";
                    
                    echo "<br>";
                    
                    echo '<a href="apply.html" title="Go to application page"><strong>Apply Now!</strong></a>';
                    
                    echo "</section><br><br>";
                }
            }
        ?>

        <br>

        
        <footer>
           	<?php
        include 'footer.inc';
        ?>
		
        </footer>
    </body>
</html>
