<?php
    require_once("settings.php");


    function JobReferenceInput()
    {
        echo '<link rel="stylesheet" href="styles/styles.css">';
        echo '<section><form method="GET" action="retrieve_eoi.php">
            <label for="jobReference">Enter Job Reference Number:</label>
            <select name="number" id="jobreference" required>
                <option value="">select</option>
                <option value="Network Administrator 101">Network Administrator-101</option>
                <option value="Cybersecurity Specialist 102">Cybersecurity Specialist-102</option>
            </select>
            <br>
            <br>
            <button type="submit">Search</button>
            </form></section>';
    }
    
    function DeleteInput()
    {
        echo '<link rel="stylesheet" href="styles/styles.css">';
        echo '<section><form method="GET" action="retrieve_eoi.php">
            <label for="jobReference">Enter Job Reference Number:</label>
            <select name="DeleteNumber" id="jobreference" required>
                <option value="">select</option>
                <option value="Network Administrator 101">Network Administrator-101</option>
                <option value="Cybersecurity Specialist 102">Cybersecurity Specialist-102</option>
            </select>
            <br>
            <br>
            <button type="submit">Search</button>
            </form></section>';
    }

    function FirstLastNameInput()
    {
        echo '<link rel="stylesheet" href="styles/styles.css">';
        echo '<section><form method="GET" action="retrieve_eoi.php">
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
        echo '<section><form method="GET" action="retrieve_eoi.php">
            <label for="EOInumber">Enter EOI Number:</label>
            <input type="text" name="EOInumber" id="EOInumber">
            <br>
            <br>
            <button type="submit">Search</button>
            </form></section>';
    }

    // Start output buffering
    ob_start();

    if(isset($_GET['ListAllEOIs'])) {
        $query = "SELECT * FROM eoi";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo '<link rel="stylesheet" href="styles/styles.css">';
            echo "<section><h1>All EOIs</h1><table id='EOITable'>";
            echo "<tr><th>EOI Number</th><th>Status</th><th>Job Reference</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th>
                <th>Street Address</th><th>Suburb</th><th>State</th><th>Postcode</th><th>Email</th><th>PhoneNumber</th><th>Skills</th>
                <th>Other Skills</th><th>Date Submitted</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['EOInumber'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>" . $row['JobReference'] . "</td>";
                echo "<td>" . $row['FirstName'] . "</td>";
                echo "<td>" . $row['LastName'] . "</td>";
                echo "<td>" . $row['DateOfBirth'] . "</td>";
                echo "<td>" . $row['StreetAddress'] . "</td>";
                echo "<td>" . $row['Suburb'] . "</td>";
                echo "<td>" . $row['State'] . "</td>";
                echo "<td>" . $row['Postcode'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['PhoneNumber'] . "</td>";
                echo "<td>" . $row['Skills'] . "</td>";
                echo "<td>" . $row['OtherSkills'] . "</td>";
                echo "<td>" . $row['DateSubmitted'] . "</td>";
                echo "</tr>";
            }
            echo "</table></section>";
        } else {
            echo "<p>Error retrieving EOIs: " . mysqli_error($conn) . "</p>";
        }
    } elseif (isset($_GET['ListPositionEOIs'])) {
        JobReferenceInput();
    
    } elseif (isset($_GET['number'])) {
        $number = mysqli_real_escape_string($conn, $_GET['number']);
        $sql = "SELECT * FROM eoi WHERE JobReference = '$number'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            echo '<link rel="stylesheet" href="styles/styles.css">';
            echo "<section><h1>All " . $number . " EOIs.</h1><table id='EOITable'>";
            echo "<tr><th>EOI Number</th><th>Status</th><th>Job Reference</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th>
                <th>Street Address</th><th>Suburb</th><th>State</th><th>Postcode</th><th>Email</th><th>PhoneNumber</th><th>Skills</th>
                <th>Other Skills</th><th>Date Submitted</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['EOInumber'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>" . $row['JobReference'] . "</td>";
                echo "<td>" . $row['FirstName'] . "</td>";
                echo "<td>" . $row['LastName'] . "</td>";
                echo "<td>" . $row['DateOfBirth'] . "</td>";
                echo "<td>" . $row['StreetAddress'] . "</td>";
                echo "<td>" . $row['Suburb'] . "</td>";
                echo "<td>" . $row['State'] . "</td>";
                echo "<td>" . $row['Postcode'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['PhoneNumber'] . "</td>";
                echo "<td>" . $row['Skills'] . "</td>";
                echo "<td>" . $row['OtherSkills'] . "</td>";
                echo "<td>" . $row['DateSubmitted'] . "</td>";
                echo "</tr>";
            }
            echo "</table></section>";

            if (isset($_GET['delete'])){
                echo "<form method='GET' action='retrieve_eoi.php'>
                    <label for='JobReference'>Delete EOIs with Job Reference:</label>
                    <input type='text' name='JobReference' id='JobReference' value='$number'>
                    <button type='submit'>Delete</button></form>";
            }
    
        } else {
            JobReferenceInput();
            echo "🚫 No EOIs of that number.";
        }
    } elseif (isset($_GET['ListApplicantEOIs'])) {
        FirstLastNameInput();
        
    } elseif (isset($_GET['FirstName']) || isset($_GET['LastName'])) {
        $firstName = mysqli_real_escape_string($conn, $_GET['FirstName']);
        $lastName = mysqli_real_escape_string($conn, $_GET['LastName']);

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
            echo "<section><h1>All EOIs for " . $firstName . " " . $lastName . ".</h1><table id='EOITable'>";
            echo "<tr><th>EOI Number</th><th>Status</th><th>Job Reference</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th>
                <th>Street Address</th><th>Suburb</th><th>State</th><th>Postcode</th><th>Email</th><th>PhoneNumber</th><th>Skills</th>
                <th>Other Skills</th><th>Date Submitted</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['EOInumber'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>" . $row['JobReference'] . "</td>";
                echo "<td>" . $row['FirstName'] . "</td>";
                echo "<td>" . $row['LastName'] . "</td>";
                echo "<td>" . $row['DateOfBirth'] . "</td>";
                echo "<td>" . $row['StreetAddress'] . "</td>";
                echo "<td>" . $row['Suburb'] . "</td>";
                echo "<td>" . $row['State'] . "</td>";
                echo "<td>" . $row['Postcode'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['PhoneNumber'] . "</td>";
                echo "<td>" . $row['Skills'] . "</td>";
                echo "<td>" . $row['OtherSkills'] . "</td>";
                echo "<td>" . $row['DateSubmitted'] . "</td>";
                echo "</tr>";
            }
            echo "</table></section>";
    
        } else {
            FirstLastNameInput();
            echo "🚫 No EOIs for this applicant exist.";
        }
    } elseif (isset($_GET['DeletePositionEOIs'])) {
        DeleteInput();
    } elseif (isset($_GET['ChangeEOIStatus'])) {
        EOINumberInput();

    } elseif (isset($_GET['EOInumber'])) {
        $Mode = mysqli_real_escape_string($conn, $_GET['Mode']);
        $EOInumber = mysqli_real_escape_string($conn, $_GET['EOInumber']);
        $sql = "SELECT * FROM eoi WHERE EOInumber = '$EOInumber'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            echo '<link rel="stylesheet" href="styles/styles.css">';
            echo "<section><h1>All EOIs for EOI number " . $EOInumber . ".</h1><table id='EOITable'>";
            echo "<tr><th>EOI Number</th><th>Status</th><th>Job Reference</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th>
                <th>Street Address</th><th>Suburb</th><th>State</th><th>Postcode</th><th>Email</th><th>PhoneNumber</th><th>Skills</th>
                <th>Other Skills</th><th>Date Submitted</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['EOInumber'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>" . $row['JobReference'] . "</td>";
                echo "<td>" . $row['FirstName'] . "</td>";
                echo "<td>" . $row['LastName'] . "</td>";
                echo "<td>" . $row['DateOfBirth'] . "</td>";
                echo "<td>" . $row['StreetAddress'] . "</td>";
                echo "<td>" . $row['Suburb'] . "</td>";
                echo "<td>" . $row['State'] . "</td>";
                echo "<td>" . $row['Postcode'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['PhoneNumber'] . "</td>";
                echo "<td>" . $row['Skills'] . "</td>";
                echo "<td>" . $row['OtherSkills'] . "</td>";
                echo "<td>" . $row['DateSubmitted'] . "</td>";
                echo "</tr>";
            }
            echo "</table></section>";
            
            echo "<form method='GET' action='retrieve_eoi.php'>
                    <label for='status'>Change Status:</label>
                    <select name='status' id='status'>
                        <option value='New'>New</option>
                        <option value='Current'>Current</option>
                        <option value='Final'>Final</option>
                    </select>
                    <input type='hidden' name='EOInumber' value='$EOInumber'>
                    <button type='submit'>Update Status</button></form>";
        } else {
            EOINumberInput();
            echo "🚫 No EOIs for this EOI number exist.";
        }

    } elseif(isset($_GET['status']) && isset($_GET['EOInumber'])) {
        $Status = mysqli_real_escape_string($conn, $_GET['status']);
        $EOInumber = mysqli_real_escape_string($conn,$_GET['EOInumber']);
        $sql = "UPDATE eoi SET Status = '$Status' WHERE EOInumber = '$EOInumber'";
        if (mysqli_query($conn, $sql)) {
            echo "<p>Status updated successfully.</p>";
        } else {
            echo "<p>Error updating status: " . mysqli_error($conn) . "</p>";
        }
    
    } elseif (isset($_GET['delete']) && isset($_GET['number'])) {
        $number = mysqli_real_escape_string($conn, $_GET['number']);
        $sql = "DELETE FROM eoi WHERE JobReference = '$number'";
        if (mysqli_query($conn, $sql)) {
            echo "<p>EOIs deleted successfully.</p>";
        } else {
            echo "<p>Error deleting EOIs: " . mysqli_error($conn) . "</p>";
        }

    }  elseif (isset($_GET['DeleteNumber'])) {
        $number = mysqli_real_escape_string($conn, $_GET['DeleteNumber']);
        $sql = "SELECT * FROM eoi WHERE JobReference = '$number'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            echo '<link rel="stylesheet" href="styles/styles.css">';
            echo "<section><h1>All " . $number . " EOIs.</h1><table id='EOITable'>";
            echo "<tr><th>EOI Number</th><th>Status</th><th>Job Reference</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th>
                <th>Street Address</th><th>Suburb</th><th>State</th><th>Postcode</th><th>Email</th><th>PhoneNumber</th><th>Skills</th>
                <th>Other Skills</th><th>Date Submitted</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['EOInumber'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>" . $row['JobReference'] . "</td>";
                echo "<td>" . $row['FirstName'] . "</td>";
                echo "<td>" . $row['LastName'] . "</td>";
                echo "<td>" . $row['DateOfBirth'] . "</td>";
                echo "<td>" . $row['StreetAddress'] . "</td>";
                echo "<td>" . $row['Suburb'] . "</td>";
                echo "<td>" . $row['State'] . "</td>";
                echo "<td>" . $row['Postcode'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['PhoneNumber'] . "</td>";
                echo "<td>" . $row['Skills'] . "</td>";
                echo "<td>" . $row['OtherSkills'] . "</td>";
                echo "<td>" . $row['DateSubmitted'] . "</td>";
                echo "</tr>";
            }
            echo "</table></section>";


            echo "<form method='GET' action='retrieve_eoi.php'>
                <label for='JobReference'>Delete EOIs with Job Reference:</label>
                <input type='text' name='JobReference' id='JobReference' value='$number'>
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
<?php
    require_once("settings.php");


    function JobReferenceInput()
    {
        echo '<link rel="stylesheet" href="styles/styles.css">';
        echo '<section><form method="GET" action="retrieve_eoi.php">
            <label for="jobReference">Enter Job Reference Number:</label>
            <select name="number" id="jobreference" required>
                <option value="">select</option>
                <option value="Network Administrator 101">Network Administrator-101</option>
                <option value="Cybersecurity Specialist 102">Cybersecurity Specialist-102</option>
            </select>
            <br>
            <br>
            <button type="submit">Search</button>
            </form></section>';
    }
    
    function DeleteInput()
    {
        echo '<link rel="stylesheet" href="styles/styles.css">';
        echo '<section><form method="GET" action="retrieve_eoi.php">
            <label for="jobReference">Enter Job Reference Number:</label>
            <select name="DeleteNumber" id="jobreference" required>
                <option value="">select</option>
                <option value="Network Administrator 101">Network Administrator-101</option>
                <option value="Cybersecurity Specialist 102">Cybersecurity Specialist-102</option>
            </select>
            <br>
            <br>
            <button type="submit">Search</button>
            </form></section>';
    }

    function FirstLastNameInput()
    {
        echo '<link rel="stylesheet" href="styles/styles.css">';
        echo '<section><form method="GET" action="retrieve_eoi.php">
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
        echo '<section><form method="GET" action="retrieve_eoi.php">
            <label for="EOInumber">Enter EOI Number:</label>
            <input type="text" name="EOInumber" id="EOInumber">
            <br>
            <br>
            <button type="submit">Search</button>
            </form></section>';
    }

    // Start output buffering
    ob_start();

    if(isset($_GET['ListAllEOIs'])) {
        $query = "SELECT * FROM eoi";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo '<link rel="stylesheet" href="styles/styles.css">';
            echo "<section><h1>All EOIs</h1><table id='EOITable'>";
            echo "<tr><th>EOI Number</th><th>Status</th><th>Job Reference</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th>
                <th>Street Address</th><th>Suburb</th><th>State</th><th>Postcode</th><th>Email</th><th>PhoneNumber</th><th>Skills</th>
                <th>Other Skills</th><th>Date Submitted</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['EOInumber'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>" . $row['JobReference'] . "</td>";
                echo "<td>" . $row['FirstName'] . "</td>";
                echo "<td>" . $row['LastName'] . "</td>";
                echo "<td>" . $row['DateOfBirth'] . "</td>";
                echo "<td>" . $row['StreetAddress'] . "</td>";
                echo "<td>" . $row['Suburb'] . "</td>";
                echo "<td>" . $row['State'] . "</td>";
                echo "<td>" . $row['Postcode'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['PhoneNumber'] . "</td>";
                echo "<td>" . $row['Skills'] . "</td>";
                echo "<td>" . $row['OtherSkills'] . "</td>";
                echo "<td>" . $row['DateSubmitted'] . "</td>";
                echo "</tr>";
            }
            echo "</table></section>";
        } else {
            echo "<p>Error retrieving EOIs: " . mysqli_error($conn) . "</p>";
        }
    } elseif (isset($_GET['ListPositionEOIs'])) {
        JobReferenceInput();
    
    } elseif (isset($_GET['number'])) {
        $number = mysqli_real_escape_string($conn, $_GET['number']);
        $sql = "SELECT * FROM eoi WHERE JobReference = '$number'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            echo '<link rel="stylesheet" href="styles/styles.css">';
            echo "<section><h1>All " . $number . " EOIs.</h1><table id='EOITable'>";
            echo "<tr><th>EOI Number</th><th>Status</th><th>Job Reference</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th>
                <th>Street Address</th><th>Suburb</th><th>State</th><th>Postcode</th><th>Email</th><th>PhoneNumber</th><th>Skills</th>
                <th>Other Skills</th><th>Date Submitted</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['EOInumber'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>" . $row['JobReference'] . "</td>";
                echo "<td>" . $row['FirstName'] . "</td>";
                echo "<td>" . $row['LastName'] . "</td>";
                echo "<td>" . $row['DateOfBirth'] . "</td>";
                echo "<td>" . $row['StreetAddress'] . "</td>";
                echo "<td>" . $row['Suburb'] . "</td>";
                echo "<td>" . $row['State'] . "</td>";
                echo "<td>" . $row['Postcode'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['PhoneNumber'] . "</td>";
                echo "<td>" . $row['Skills'] . "</td>";
                echo "<td>" . $row['OtherSkills'] . "</td>";
                echo "<td>" . $row['DateSubmitted'] . "</td>";
                echo "</tr>";
            }
            echo "</table></section>";

            if (isset($_GET['delete'])){
                echo "<form method='GET' action='retrieve_eoi.php'>
                    <label for='JobReference'>Delete EOIs with Job Reference:</label>
                    <input type='text' name='JobReference' id='JobReference' value='$number'>
                    <button type='submit'>Delete</button></form>";
            }
    
        } else {
            JobReferenceInput();
            echo "🚫 No EOIs of that number.";
        }
    } elseif (isset($_GET['ListApplicantEOIs'])) {
        FirstLastNameInput();
        
    } elseif (isset($_GET['FirstName']) || isset($_GET['LastName'])) {
        $firstName = mysqli_real_escape_string($conn, $_GET['FirstName']);
        $lastName = mysqli_real_escape_string($conn, $_GET['LastName']);

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
            echo "<section><h1>All EOIs for " . $firstName . " " . $lastName . ".</h1><table id='EOITable'>";
            echo "<tr><th>EOI Number</th><th>Status</th><th>Job Reference</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th>
                <th>Street Address</th><th>Suburb</th><th>State</th><th>Postcode</th><th>Email</th><th>PhoneNumber</th><th>Skills</th>
                <th>Other Skills</th><th>Date Submitted</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['EOInumber'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>" . $row['JobReference'] . "</td>";
                echo "<td>" . $row['FirstName'] . "</td>";
                echo "<td>" . $row['LastName'] . "</td>";
                echo "<td>" . $row['DateOfBirth'] . "</td>";
                echo "<td>" . $row['StreetAddress'] . "</td>";
                echo "<td>" . $row['Suburb'] . "</td>";
                echo "<td>" . $row['State'] . "</td>";
                echo "<td>" . $row['Postcode'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['PhoneNumber'] . "</td>";
                echo "<td>" . $row['Skills'] . "</td>";
                echo "<td>" . $row['OtherSkills'] . "</td>";
                echo "<td>" . $row['DateSubmitted'] . "</td>";
                echo "</tr>";
            }
            echo "</table></section>";
    
        } else {
            FirstLastNameInput();
            echo "🚫 No EOIs for this applicant exist.";
        }
    } elseif (isset($_GET['DeletePositionEOIs'])) {
        DeleteInput();
    } elseif (isset($_GET['ChangeEOIStatus'])) {
        EOINumberInput();

    } elseif (isset($_GET['EOInumber'])) {
        $Mode = mysqli_real_escape_string($conn, $_GET['Mode']);
        $EOInumber = mysqli_real_escape_string($conn, $_GET['EOInumber']);
        $sql = "SELECT * FROM eoi WHERE EOInumber = '$EOInumber'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            echo '<link rel="stylesheet" href="styles/styles.css">';
            echo "<section><h1>All EOIs for EOI number " . $EOInumber . ".</h1><table id='EOITable'>";
            echo "<tr><th>EOI Number</th><th>Status</th><th>Job Reference</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th>
                <th>Street Address</th><th>Suburb</th><th>State</th><th>Postcode</th><th>Email</th><th>PhoneNumber</th><th>Skills</th>
                <th>Other Skills</th><th>Date Submitted</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['EOInumber'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>" . $row['JobReference'] . "</td>";
                echo "<td>" . $row['FirstName'] . "</td>";
                echo "<td>" . $row['LastName'] . "</td>";
                echo "<td>" . $row['DateOfBirth'] . "</td>";
                echo "<td>" . $row['StreetAddress'] . "</td>";
                echo "<td>" . $row['Suburb'] . "</td>";
                echo "<td>" . $row['State'] . "</td>";
                echo "<td>" . $row['Postcode'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['PhoneNumber'] . "</td>";
                echo "<td>" . $row['Skills'] . "</td>";
                echo "<td>" . $row['OtherSkills'] . "</td>";
                echo "<td>" . $row['DateSubmitted'] . "</td>";
                echo "</tr>";
            }
            echo "</table></section>";
            
            echo "<form method='GET' action='retrieve_eoi.php'>
                    <label for='status'>Change Status:</label>
                    <select name='status' id='status'>
                        <option value='New'>New</option>
                        <option value='Current'>Current</option>
                        <option value='Final'>Final</option>
                    </select>
                    <input type='hidden' name='EOInumber' value='$EOInumber'>
                    <button type='submit'>Update Status</button></form>";
        } else {
            EOINumberInput();
            echo "🚫 No EOIs for this EOI number exist.";
        }

    } elseif(isset($_GET['status']) && isset($_GET['EOInumber'])) {
        $Status = mysqli_real_escape_string($conn, $_GET['status']);
        $EOInumber = mysqli_real_escape_string($conn,$_GET['EOInumber']);
        $sql = "UPDATE eoi SET Status = '$Status' WHERE EOInumber = '$EOInumber'";
        if (mysqli_query($conn, $sql)) {
            echo "<p>Status updated successfully.</p>";
        } else {
            echo "<p>Error updating status: " . mysqli_error($conn) . "</p>";
        }
    
    } elseif (isset($_GET['delete']) && isset($_GET['number'])) {
        $number = mysqli_real_escape_string($conn, $_GET['number']);
        $sql = "DELETE FROM eoi WHERE JobReference = '$number'";
        if (mysqli_query($conn, $sql)) {
            echo "<p>EOIs deleted successfully.</p>";
        } else {
            echo "<p>Error deleting EOIs: " . mysqli_error($conn) . "</p>";
        }

    }  elseif (isset($_GET['DeleteNumber'])) {
        $number = mysqli_real_escape_string($conn, $_GET['DeleteNumber']);
        $sql = "SELECT * FROM eoi WHERE JobReference = '$number'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            echo '<link rel="stylesheet" href="styles/styles.css">';
            echo "<section><h1>All " . $number . " EOIs.</h1><table id='EOITable'>";
            echo "<tr><th>EOI Number</th><th>Status</th><th>Job Reference</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th>
                <th>Street Address</th><th>Suburb</th><th>State</th><th>Postcode</th><th>Email</th><th>PhoneNumber</th><th>Skills</th>
                <th>Other Skills</th><th>Date Submitted</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['EOInumber'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>" . $row['JobReference'] . "</td>";
                echo "<td>" . $row['FirstName'] . "</td>";
                echo "<td>" . $row['LastName'] . "</td>";
                echo "<td>" . $row['DateOfBirth'] . "</td>";
                echo "<td>" . $row['StreetAddress'] . "</td>";
                echo "<td>" . $row['Suburb'] . "</td>";
                echo "<td>" . $row['State'] . "</td>";
                echo "<td>" . $row['Postcode'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['PhoneNumber'] . "</td>";
                echo "<td>" . $row['Skills'] . "</td>";
                echo "<td>" . $row['OtherSkills'] . "</td>";
                echo "<td>" . $row['DateSubmitted'] . "</td>";
                echo "</tr>";
            }
            echo "</table></section>";


            echo "<form method='GET' action='retrieve_eoi.php'>
                <label for='JobReference'>Delete EOIs with Job Reference:</label>
                <input type='text' name='JobReference' id='JobReference' value='$number'>
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