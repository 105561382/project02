<?php
// enhancements.php

include 'nav.inc';

$enhancements = [
    "Management Login Page",
    "Secure Form Validation to prevent MySQL injection",
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/styles.css">
    <title>Enhancements List</title>
</head>
<body>

<h1>Project Enhancements</h1>
<ul>
    <?php foreach ($enhancements as $point): ?>
        <li><?= htmlspecialchars($point) ?></li>
    <?php endforeach; ?>
</ul>

</body>
</html>