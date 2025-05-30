<?php
    require_once("settings.php");

    // Prevent direct access to this page without POST data
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: index.php");
        exit();
    }

    // Recallable functions to display input forms
    function JobReferenceInput()
    {
        echo '<link rel="stylesheet" href="styles/styles.css">';
        echo '<section><form method="POST" action="retrieve_eoi.php">
            <label for="jobReference">Enter Job Reference Number:</label>
            <select name="number" id="jobreference" required>
                <option value="">select</option>
                <option value="Network Administrato">Network Administrator-101</option>
                <option value="Cybersecurity Specia">Cybersecurity Specialist-102</option>
            </select>
            <br>
            <br>
            <button type="submit">Search</button>
            </form></section>';
    }
    
    function DeleteInput()
    {
        echo '<link rel="stylesheet" href="styles/styles.css">';
        echo '<section><form method="POST" action="retrieve_eoi.php">
            <label for="jobReference">Enter Job Reference Number:</label>
            <select name="DeleteNumber" id="jobreference" required>
                <option value="">select</option>
                <option value="Network Administrato">Network Administrator-101</option>
                <option value="Cybersecurity Specia">Cybersecurity Specialist-102</option>
            </select>
            <br>
            <br>
            <button type="submit">Search</button>
            </form></section>';
    }

    function FirstLastNameInput()
    {
        echo '<link rel="stylesheet" href="styles/styles.css">';
        echo '<section><form method="POST" action="retrieve_eoi.php">
            <label for="FirstName">Enter First Name:</label>
            <input type="text" name="FirstName" id="FirstName">
            <br>
            <label for="LastName">Enter Last Name:</label>
            <input type="text" name="LastName" id="LastName">
            <br>
            <br>
            <button type="submit">Search</button>
            </form></section>';
    }

    function EOINumberInput()
    {
        echo '<link rel="stylesheet" href="styles/styles.css">';
        echo '<section><form method="POST" action="retrieve_eoi.php">
            <label for="EOInumber">Enter EOI Number:</label>
            <input type="text" name="EOInumber" id="EOInumber">
            <br>
            <br>
            <button type="submit">Search</button>
            </form></section>';
    }

    // Start output buffering
    ob_start();

    // Qeuries the database for all EOIs and displays then in a table format
    if(isset($_POST['ListAllEOIs'])) {
        $query = "SELECT * FROM eoi";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo '<link rel="stylesheet" href="styles/styles.css">';
            echo "<section><h1>All EOIs</h1><div id='EOISection'><div id='EOISection'><table id='EOITable'>";
            echo "<tr><th>EOI Number</th><th>Status</th><th>Job Reference</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th>
                <th>Street Address</th><th>Suburb</th><th>State</th><th>Postcode</th><th>Email</th><th>PhoneNumber</th><th>Skills</th>
                <th>Other Skills</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['EOInumber'] . "</td>";
                echo "<td>" . $row['STATUS'] . "</td>";
                echo "<td>" . $row['jobReferenceNumber'] . "</td>";
                echo "<td>" . $row['firstName'] . "</td>";
                echo "<td>" . $row['lastName'] . "</td>";
                echo "<td>" . $row['dateOfBirth'] . "</td>";
                echo "<td>" . $row['streetAddress'] . "</td>";
                echo "<td>" . $row['suburbTown'] . "</td>";
                echo "<td>" . $row['state'] . "</td>";
                echo "<td>" . $row['postcode'] . "</td>";
                echo "<td>" . $row['emailAddress'] . "</td>";
                echo "<td>" . $row['phoneNumber'] . "</td>";
                echo "<td><ul>";
                for ($i = 1; $i <= 5; $i++) {
                    if (!empty($row["skill$i"])) {
                        echo "<li>" . $row["skill$i"] . "</li>";
                    }
                }
                echo "</ul></td>";
                echo "<td>" . $row['otherSkills'] . "</td>";

                echo "</tr>";
            }
            echo "</table></div></section>";
        } else {
            echo "<p>Error retrieving EOIs: " . mysqli_error($conn) . "</p>";
        }

    // If the user has selected to list EOIs send to the JobReferenceInput function
    } elseif (isset($_POST['ListPositionEOIs'])) {
        JobReferenceInput();
    
    // Once the user has chosen a position number, display the EOIs that match
    } elseif (isset($_POST['number'])) {
        $number = mysqli_real_escape_string($conn, $_POST['number']);
        $sql = "SELECT * FROM eoi WHERE jobReferenceNumber = '$number'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            echo '<link rel="stylesheet" href="styles/styles.css">';
            echo "<section><h1>All " . $number . " EOIs.</h1><div id='EOISection'><table id='EOITable'>";
            echo "<tr><th>EOI Number</th><th>Status</th><th>Job Reference</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th>
                <th>Street Address</th><th>Suburb</th><th>State</th><th>Postcode</th><th>Email</th><th>PhoneNumber</th><th>Skills</th>
                <th>Other Skills</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['EOInumber'] . "</td>";
                echo "<td>" . $row['STATUS'] . "</td>";
                echo "<td>" . $row['jobReferenceNumber'] . "</td>";
                echo "<td>" . $row['firstName'] . "</td>";
                echo "<td>" . $row['lastName'] . "</td>";
                echo "<td>" . $row['dateOfBirth'] . "</td>";
                echo "<td>" . $row['streetAddress'] . "</td>";
                echo "<td>" . $row['suburbTown'] . "</td>";
                echo "<td>" . $row['state'] . "</td>";
                echo "<td>" . $row['postcode'] . "</td>";
                echo "<td>" . $row['emailAddress'] . "</td>";
                echo "<td>" . $row['phoneNumber'] . "</td>";
                echo "<td><ul>";
                for ($i = 1; $i <= 5; $i++) {
                    if (!empty($row["skill$i"])) {
                        echo "<li>" . $row["skill$i"] . "</li>";
                    }
                }
                echo "</ul></td>";
                echo "<td>" . $row['otherSkills'] . "</td>";
                echo "</tr>";
            }
            echo "</table></div></section>";

            if (isset($_POST['delete'])){
                echo "<form method='POST' action='retrieve_eoi.php'>
                    <label for='JobReference'>Delete EOIs with Job Reference:</label>
                    <input type='text' name='JobReference' id='JobReference' value='$number'>
                    <input type='hidden' name='delete' value='true'>
                    <button type='submit'>Delete</button></form>";
            }
    
        } else {
            JobReferenceInput();
            echo "🚫 No EOIs of that number.";
        }
    // If the user has selected to list EOIs by first and/or last name, send to the FirstLastNameInput function
    } elseif (isset($_POST['ListApplicantEOIs'])) {
        FirstLastNameInput();
        
    // Once the user has chosen a first and/or last name, display the EOIs that match either or both
    } elseif (isset($_POST['FirstName']) || isset($_POST['LastName'])) {
        $firstName = mysqli_real_escape_string($conn, $_POST['FirstName']);
        $lastName = mysqli_real_escape_string($conn, $_POST['LastName']);

        $firstName = trim($firstName);
        $lastName = trim($lastName);

        if (empty($firstName) && isset($lastName)) {
            $sql = "SELECT * FROM eoi WHERE LastName = '$lastName'";

        } elseif (isset($firstName) && empty($lastName)) {
            $sql = "SELECT * FROM eoi WHERE FirstName = '$firstName'";

        } elseif (isset($firstName) && isset($lastName)) {
            $sql = "SELECT * FROM eoi WHERE FirstName = '$firstName' AND LastName = '$lastName'";
        } else {
            $sql = "SELECT * FROM eoi";
        }

        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            echo '<link rel="stylesheet" href="styles/styles.css">';
            echo "<section><h1>All EOIs for " . $firstName . " " . $lastName . "</h1><div id='EOISection'><table id='EOITable'>";
            echo "<tr><th>EOI Number</th><th>Status</th><th>Job Reference</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th>
                <th>Street Address</th><th>Suburb</th><th>State</th><th>Postcode</th><th>Email</th><th>PhoneNumber</th><th>Skills</th>
                <th>Other Skills</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['EOInumber'] . "</td>";
                echo "<td>" . $row['STATUS'] . "</td>";
                echo "<td>" . $row['jobReferenceNumber'] . "</td>";
                echo "<td>" . $row['firstName'] . "</td>";
                echo "<td>" . $row['lastName'] . "</td>";
                echo "<td>" . $row['dateOfBirth'] . "</td>";
                echo "<td>" . $row['streetAddress'] . "</td>";
                echo "<td>" . $row['suburbTown'] . "</td>";
                echo "<td>" . $row['state'] . "</td>";
                echo "<td>" . $row['postcode'] . "</td>";
                echo "<td>" . $row['emailAddress'] . "</td>";
                echo "<td>" . $row['phoneNumber'] . "</td>";
                echo "<td><ul>";
                for ($i = 1; $i <= 5; $i++) {
                    if (!empty($row["skill$i"])) {
                        echo "<li>" . $row["skill$i"] . "</li>";
                    }
                }
                echo "</ul></td>";

                echo "<td>" . $row['otherSkills'] . "</td>";
                echo "</tr>";
            }
            echo "</table></div></section>";
    
        } else {
            FirstLastNameInput();
            echo "🚫 No EOIs for this applicant exist.";
        }
    
    // If the user has selected to delete EOIs, send to the DeleteInput function
    } elseif (isset($_POST['DeletePositionEOIs'])) {
        DeleteInput();

    // If the user has selected to change the status of an EOI, send to the EOINumberInput function
    } elseif (isset($_POST['ChangeEOIStatus'])) {
        EOINumberInput();
    
    // Once the user has chosen an EOI number, display the EOIs that match
    } elseif (isset($_POST['EOInumber'])) {

        $EOInumber = mysqli_real_escape_string($conn, $_POST['EOInumber']);
        $sql = "SELECT * FROM eoi WHERE EOInumber = '$EOInumber'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            echo '<link rel="stylesheet" href="styles/styles.css">';
            echo "<section><h1>All EOIs for EOI number " . $EOInumber . ".</h1><div id='EOISection'><table id='EOITable'>";
            echo "<tr><th>EOI Number</th><th>Status</th><th>Job Reference</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th>
                <th>Street Address</th><th>Suburb</th><th>State</th><th>Postcode</th><th>Email</th><th>PhoneNumber</th><th>Skills</th>
                <th>Other Skills</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['EOInumber'] . "</td>";
                echo "<td>" . $row['STATUS'] . "</td>";
                echo "<td>" . $row['jobReferenceNumber'] . "</td>";
                echo "<td>" . $row['firstName'] . "</td>";
                echo "<td>" . $row['lastName'] . "</td>";
                echo "<td>" . $row['dateOfBirth'] . "</td>";
                echo "<td>" . $row['streetAddress'] . "</td>";
                echo "<td>" . $row['suburbTown'] . "</td>";
                echo "<td>" . $row['state'] . "</td>";
                echo "<td>" . $row['postcode'] . "</td>";
                echo "<td>" . $row['emailAddress'] . "</td>";
                echo "<td>" . $row['phoneNumber'] . "</td>";
                echo "<td><ul>";
                for ($i = 1; $i <= 5; $i++) {
                    if (!empty($row["skill$i"])) {
                        echo "<li>" . $row["skill$i"] . "</li>";
                    }
                }
                echo "</ul></td>";
                echo "<td>" . $row['otherSkills'] . "</td>";
                echo "</tr>";
            }
            echo "</table></div></section>";
            
            echo "<form method='POST' action='retrieve_eoi.php'>
                    <label for='status'>Change Status:</label>
                    <select name='status' id='status'>
                        <option value='New'>New</option>
                        <option value='Current'>Current</option>
                        <option value='Final'>Final</option>
                    </select>
                    <input type='hidden' name='SelectedEOInumber' value='$EOInumber'>
                    <button type='submit'>Update Status</button></form>";
        } else {
            EOINumberInput();
            echo "🚫 No EOIs for this EOI number exist.";
        }
    
    // If the user has selected to change the status of an EOI, update the status in the database
    } elseif(isset($_POST['status']) && isset($_POST['SelectedEOInumber'])) {
        $Status = mysqli_real_escape_string($conn, $_POST['status']);
        $EOInumber = mysqli_real_escape_string($conn,$_POST['SelectedEOInumber']);
        $sql = "UPDATE eoi SET Status = '$Status' WHERE EOInumber = '$EOInumber'";
        if (mysqli_query($conn, $sql)) {
            echo "<p>Status updated successfully.</p>";
        } else {
            echo "<p>Error updating status: " . mysqli_error($conn) . "</p>";
        }
    
    // If the user has selected to delete EOIs, delete the EOIs with the specified job reference number
    } elseif (isset($_POST['delete']) && isset($_POST['JobReference'])) {
        $number = mysqli_real_escape_string($conn, $_POST['JobReference']);
        $sql = "DELETE FROM eoi WHERE jobReferenceNumber = '$number'";
        if (mysqli_query($conn, $sql)) {
            echo "<p>EOIs deleted successfully.</p>";
        } else {
            echo "<p>Error deleting EOIs: " . mysqli_error($conn) . "</p>";
        }

    // If the user has selected to delete EOIs by number, display the EOIs that match
    }  elseif (isset($_POST['DeleteNumber'])) {
        $number = mysqli_real_escape_string($conn, $_POST['DeleteNumber']);
        $sql = "SELECT * FROM eoi WHERE jobReferenceNumber = '$number'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            echo '<link rel="stylesheet" href="styles/styles.css">';
            echo "<section><h1>All " . $number . " EOIs.</h1><div id='EOISection'><table id='EOITable'>";
            echo "<tr><th>EOI Number</th><th>Status</th><th>Job Reference</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th>
                <th>Street Address</th><th>Suburb</th><th>State</th><th>Postcode</th><th>Email</th><th>PhoneNumber</th><th>Skills</th>
                <th>Other Skills</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['EOInumber'] . "</td>";
                echo "<td>" . $row['STATUS'] . "</td>";
                echo "<td>" . $row['jobReferenceNumber'] . "</td>";
                echo "<td>" . $row['firstName'] . "</td>";
                echo "<td>" . $row['lastName'] . "</td>";
                echo "<td>" . $row['dateOfBirth'] . "</td>";
                echo "<td>" . $row['streetAddress'] . "</td>";
                echo "<td>" . $row['suburbTown'] . "</td>";
                echo "<td>" . $row['state'] . "</td>";
                echo "<td>" . $row['postcode'] . "</td>";
                echo "<td>" . $row['emailAddress'] . "</td>";
                echo "<td>" . $row['phoneNumber'] . "</td>";
                echo "<td><ul>";
                for ($i = 1; $i <= 5; $i++) {
                    if (!empty($row["skill$i"])) {
                        echo "<li>" . $row["skill$i"] . "</li>";
                    }
                }
                echo "</ul></td>";
                echo "<td>" . $row['otherSkills'] . "</td>";
                echo "</tr>";
            }
            echo "</table></div></section>";


            echo "<form method='POST' action='retrieve_eoi.php'>
                <label for='JobReference'>Delete EOIs with Job Reference:</label>
                <input type='text' name='JobReference' id='JobReference' value='$number'>
                <input type='hidden' name='delete' value='true'>
                <button type='submit'>Delete</button></form>";

        } else {
            JobReferenceInput();
            echo "🚫 No EOIs of that number.";
        }
    } else {
        echo "<p>Invalid request.</p>";
    }
    // Capture the output and store it in a variable
    $output = ob_get_clean();

    // Redirect to manage.php and pass the output
    header("Location: manage.php?output=" . urlencode($output));
    exit();

     







?>