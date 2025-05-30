<!DOCTYPE html>
<html lang="en">
<head>
   <?php
        require_once("settings.php");
        if(isset($_POST['username']) && isset($_POST['password'])) {
            session_start();
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $sql = "SELECT * FROM login WHERE username = '$username' AND password = '$password' LIMIT 1";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) === 1) {
                $_SESSION['is_manager'] = true;
            } else {
                echo "<script>alert('Invalid management username or password. Access denied.'); window.location.href='index.php';</script>";
                exit();
            }

        } else {header("Location: index.php");}
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