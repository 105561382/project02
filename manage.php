<!DOCTYPE html>
<html lang="en">
<head>
   <?php
        include 'header.inc';
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
        <form method="GET" action="retrieve_eoi.php">
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