<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: apply.php");
    exit();
}

function sanitise_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$JobReferenceNumber = sanitise_input($_POST["number"]);
$FirstName = sanitise_input($_POST["Firstname"]);
$LastName = sanitise_input($_POST["Lastname"]);
$dateOfBirth = sanitise_input($_POST["dob"]);
$StreetAddress = sanitise_input($_POST["streetaddress"]);
$SuburbTown = sanitise_input($_POST["suburb"]);
$State = sanitise_input($_POST["state"]);
$Postcode = sanitise_input($_POST["postcode"]);
$EmailAddress = sanitise_input($_POST["email"]);
$PhoneNumber = sanitise_input($_POST["phonenumber"]);
$OtherSkills = sanitise_input($_POST["description"]);

$skillsList = [
    "NetworkingProtocols",
    "HardwareKnowledge",
    "OperatingSystems",
    "NetworkConfiguration&Troubleshooting",
    "CloudNetworking",
    "SecurityFundamentals"
];

$requiredSkillsArr = [];
foreach ($skillsList as $skill) {
    if (isset($_POST[$skill])) {
        $requiredSkillsArr[] = $skill;
    }
}

$errors = [];

if (empty($JobReferenceNumber)) $errors[] = "Job reference is required.";

if (empty($FirstName) || !preg_match("/^[a-zA-Z]{1,20}$/", $FirstName)) {
    $errors[] = "First name is required, max 20 alpha characters.";
}

if (empty($LastName) || !preg_match("/^[a-zA-Z]{1,20}$/", $LastName)) {
    $errors[] = "Last name is required, max 20 alpha characters.";
}

if (empty($dateOfBirth) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $dateOfBirth)) {
    $errors[] = "Date of birth is required and must be valid (DD-MM-YYYY).";
}

if (empty($StreetAddress) || strlen($StreetAddress) > 40) {
    $errors[] = "Street address is required, max 40 characters.";
}

if (empty($SuburbTown) || strlen($SuburbTown) > 40) {
    $errors[] = "Suburb/town is required, max 40 characters.";
}

$validStates = ["ACT", "NSW", "NT", "QLD", "SA", "TAS", "VIC", "WA"];
if (empty($State) || !in_array($State, $validStates)) {
    $errors[] = "State is required and must be a valid state.";
}

if (!preg_match("/^\d{4}$/", $Postcode)) {
    $errors[] = "Postcode must be exactly 4 digits.";
} else {
    $statePostcodePatterns = [
        "VIC" => "/^(3|8)\d{3}$/",
        "NSW" => "/^(1|2)\d{3}$/",
        "QLD" => "/^(4|9)\d{3}$/",
        "NT" => "/^0\d{3}$/",
        "WA" => "/^6\d{3}$/",
        "SA" => "/^5\d{3}$/",
        "TAS" => "/^7\d{3}$/",
        "ACT" => "/^0[2-9]\d{3}$/"
    ];

    if (isset($statePostcodePatterns[$State])) {
        if (!preg_match($statePostcodePatterns[$State], $Postcode)) {
            $errors[] = "Postcode does not match the selected state.";
        }
    } else {
        $errors[] = "Invalid state selected for postcode validation.";
    }
}

if (!filter_var($EmailAddress, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Valid email is required.";
}

if (!preg_match("/^[0-9\s]{8,12}$/", $PhoneNumber)) {
    $errors[] = "Phone number must be 8 to 12 digits or spaces.";
}

if (count($requiredSkillsArr) == 0) {
    $errors[] = "At least one required skill must be selected.";
}

if (count($errors) > 0) {
    echo "<h2>Validation Errors:</h2><ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul><p><a href='apply.php'>Go Back</a></p>";
    exit();
}



$host = 'localhost';
$dbname = 'it_rizz';
$username = 'root';
$password = '';


$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sqlCreateTable = "CREATE TABLE IF NOT EXISTS EOI (
    EOInumber INT AUTO_INCREMENT PRIMARY KEY,
    JobReferenceNumber VARCHAR(50) NOT NULL,
    FirstName VARCHAR(20) NOT NULL,
    LastName VARCHAR(20) NOT NULL,
    DateOfBirth DATE NOT NULL,
    StreetAddress VARCHAR(40) NOT NULL,
    SuburbTown VARCHAR(40) NOT NULL,
    State VARCHAR(5) NOT NULL,
    Postcode VARCHAR(4) NOT NULL,
    EmailAddress VARCHAR(255) NOT NULL,
    PhoneNumber VARCHAR(20) NOT NULL,
    Skill1 VARCHAR(50),
    Skill2 VARCHAR(50),
    Skill3 VARCHAR(50),
    Skill4 VARCHAR(50),
    Skill5 VARCHAR(50),
    OtherSkills TEXT,
    DateSubmitted TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (!$conn->query($sqlCreateTable)) { 
    die("Error creating table: " . $conn->error);
}

$skillVars = array_pad($requiredSkillsArr, 5, null);
list($skill1, $skill2, $skill3, $skill4, $skill5) = $skillVars;

$stmt = $conn->prepare("INSERT INTO eoi (JobReferenceNumber, FirstName, LastName, DateOfBirth, StreetAddress, SuburbTown, State, Postcode, EmailAddress, PhoneNumber, Skill1, Skill2, Skill3, Skill4, Skill5, OtherSkills) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssssssss", $JobReferenceNumber, $FirstName, $LastName, $dateOfBirth, $StreetAddress, $SuburbTown, $State, $Postcode, $EmailAddress, $PhoneNumber, $skill1, $skill2, $skill3, $skill4, $skill5, $OtherSkills);

if ($stmt->execute()) {
    $insertedId = $conn->insert_id;
    echo "<h2>Thank you for your application!</h2>";
    echo "<p>Your Expression of Interest has been recorded. Your EOInumber is <strong>" . $insertedId . "</strong>.</p>";
} else {
    echo "Error: " . htmlspecialchars($stmt->error);
}

$stmt->close();
$conn->close();
?>
