<?php
// Import database connection settings
require_once("settings.php");

// Prevent direct access to this page without POST data
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: apply.php");
    exit();
}

// Sanitisation function
function sanitise_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Sanitize inputs
//$jobReferenceNumber = sanitise_input($_POST["number"] ?? '');  - test version works even if no input
$jobReferenceNumber = sanitise_input($_POST["number"]);
$firstName = sanitise_input($_POST["Firstname"]);
$lastName = sanitise_input($_POST["Lastname"]);
$dateOfBirth = sanitise_input($_POST["dob"]);
$streetAddress = sanitise_input($_POST["streetaddress"]);
$Suburb = sanitise_input($_POST["suburb"]);
$State = sanitise_input($_POST["state"]);
$postCode = sanitise_input($_POST["postcode"]);
$Email = sanitise_input($_POST["email"]);
$phoneNumber = sanitise_input($_POST["phonenumber"]);
$otherSkills = sanitise_input($_POST["description"]);

// Collect skills from individual checkbox inputs
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

// Validation errors array
$errors = [];

// Validate required fields
if (empty($jobReferenceNumber)) $errors[] = "Job reference is required."; //error for jobreference still working it out

if (empty($firstName) || !preg_match("/^[a-zA-Z]{1,20}$/", $firstName)) {
    $errors[] = "First name is required, max 20 alpha characters.";
}

if (empty($lastName) || !preg_match("/^[a-zA-Z]{1,20}$/", $lastName)) {
    $errors[] = "Last name is required, max 20 alpha characters.";
}

if (empty($dateOfBirth) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $dateOfBirth)) {
    $errors[] = "Date of birth is required and must be valid (YYYY-MM-DD).";
}

if (empty($streetAddress) || strlen($streetAddress) > 40) {
    $errors[] = "Street address is required, max 40 characters.";
}

if (empty($Suburb) || strlen($Suburb) > 40) {
    $errors[] = "Suburb/town is required, max 40 characters.";
}

$validStates = ["ACT", "NSW", "NT", "QLD", "SA", "TAS", "VIC", "WA"];
if (empty($State) || !in_array($State, $validStates)) {
    $errors[] = "State is required and must be a valid state.";
}

if (!preg_match("/^\d{4}$/", $postCode)) {
    $errors[] = "Postcode must be exactly 4 digits.";
} else {
    // Postcode matching state logic  Chatgpt generated this but doesn't work - THIS ISNT WORKING ASK FOR HELP FROM TUTOR
    $statePostcodePatterns = [
        "VIC" => "/^(3|8)\d{2}$/",
        "NSW" => "/^(1|2)\d{2}$/",
        "QLD" => "/^(4|9)\d{2}$/",
        "NT" => "/^0\d{3}$/",
        "WA" => "/^6\d{3}$/",
        "SA" => "/^5\d{3}$/",
        "TAS" => "/^7\d{3}$/",
        "ACT" => "/^0[2-9]\d{2}$/"
    ];

    if (isset($statePostcodePatterns[$State])) {
        if (!preg_match($statePostcodePatterns[$State], $postCode)) {
            #$errors[] = "Postcode does not match the selected state.";
        }
    } else {
        $errors[] = "Invalid state selected for postcode validation.";
    }
}

if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Valid email is required.";
}

if (!preg_match("/^[0-9\s]{8,12}$/", $phoneNumber)) {
    $errors[] = "Phone number must be 8 to 12 digits or spaces.";
}

if (count($requiredSkillsArr) == 0) {
    $errors[] = "At least one required skill must be selected.";
}


// If there are validation errors, display them and stop execution 
if (count($errors) > 0) {
    echo "<h2>Validation Errors:</h2><ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul><p><a href='apply.php'>Go Back</a></p>";
    exit();
}

// Create EOI table if it doesn't exist - chatgpt helped with this
$sqlCreateTable = "CREATE TABLE IF NOT EXISTS EOI (
    EOInumber INT AUTO_INCREMENT PRIMARY KEY,
    Status ENUM('New', 'Current', 'Final') DEFAULT 'New',
    JobReference VARCHAR(50) NOT NULL,
    FirstName VARCHAR(20) NOT NULL,
    LastName VARCHAR(20) NOT NULL,
    DateOfBirth DATE NOT NULL,
    StreetAddress VARCHAR(40) NOT NULL,
    Suburb VARCHAR(40) NOT NULL,
    State VARCHAR(5) NOT NULL,
    Postcode VARCHAR(4) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    PhoneNumber VARCHAR(20) NOT NULL,
    Skills TEXT,
    OtherSkills TEXT,
    DateSubmitted TIMESTAMP DEFAULT CURRENT_TIMESTAMP

)";
if (!$conn->query($sqlCreateTable)) { 
    die("Error creating table: " . $conn->error);
}

// Prepare comma separated skills string
$skillsForDB = implode(", ", $requiredSkillsArr);

// Prepare insert statement
$stmt = $conn->prepare("INSERT INTO EOI (Status,JobReference, FirstName, LastName, DateOfBirth, StreetAddress, Suburb, State, Postcode, Email, PhoneNumber, Skills, OtherSkills) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$Status = "New"; // Default status
$stmt->bind_param("sssssssssssss", $Status, $jobReferenceNumber, $firstName, $lastName, $dateOfBirth, $streetAddress, $Suburb, $State, $postCode, $Email, $phoneNumber, $skillsForDB, $otherSkills);

if ($stmt->execute()) {
    // Get the unique EOInumber (auto-increment ID) - UNSURE IF THIS WORKS - chatgpt helped with this
    $insertedId = $conn->insert_id;
    echo "<h2>Thank you for your application!</h2>";
    echo "<p>Your Expression of Interest has been recorded. Your EOInumber is <strong>" . $insertedId . "</strong>.</p>";
    echo "<p><a href='apply.php'>Go Back</a></p>";
} else {
    echo "Error: " . htmlspecialchars($stmt->error);
}   

// Close connections
$stmt->close();
$conn->close();
?>