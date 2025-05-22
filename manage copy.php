<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="EOI Management">
  <meta name="keywords" content="HTML, Doctype, Head, Body, Meta, Paragraph, Headings, Strong, Emphasis">
  <meta name="author" content= "Ethan Gibbons">
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
    <!--List all EOIs.
    List all EOIs for a particular position (given a job reference number).
    List all EOIs for a particular applicant given their first name, last name or both.
    Delete all EOIs with a specified job reference number
    Change the Status of an EOI.-->

    <!--This is where the output from retrieve_eoi.php will be displayed-->
    <?php
        if (isset($_GET['output'])) {
        echo urldecode($_GET['output']);
        }
    ?>

</body>