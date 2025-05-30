<!DOCTYPE html>
<html lang="en">
<head>
   <?php
    require_once("settings.php");
    session_start();

    if (!$conn) {
        echo "<script>alert('Database connection failed!'); window.location.href='index.php';</script>";
        exit();
    }

    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
        echo "<script>alert('Please log in first!'); window.location.href='login.php';</script>";
        exit();
    }
    ?>

  <link rel="stylesheet" href="styles/styles.css">
  <title>EOI Management</title>
</head>
<body>
    <?php
        include 'nav.inc';
    ?>
    <hr>
    <hr>
    <h1>EOI Management Page</h1>
    <nav>
        <form method="POST" action="retrieve_eoi.php">
            <button type="submit" value="True" name="ListAllEOIs">List EOIs</button>
            <button type="submit" value="True" name="ListPositionEOIs">List EOIs of a position</button>
            <button type="submit" value="True" name="ListApplicantEOIs">List EOI of an applicant</button>
            <button type="submit" value="True" name="DeletePositionEOIs">Delete EOIs</button>
            <button type="submit" value="True" name="ChangeEOIStatus">Change EOI Status</button>
        </form>
    </nav>
    <hr>
  
    <?php
        if (isset($_GET['output'])) {
        echo urldecode($_GET['output']);
        }
    ?>

</body>
</html>