
<?php
require('sessions_handler.php');
?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Session store in Database</title>
</head>
<body>

<?php
// Store some dummy data in the session, if no data is present:
if (empty($_SESSION)) {

    $_SESSION['foo'] = 'hello';
    $_SESSION['bar'] = 'my test';

    // Print a message indicating what's going on:
    echo '<p>Session data stored.</p>';

} else { // Print the already-stored data:
    echo '<p>Session Data Exists:<pre>' . print_r($_SESSION, 1) . '</pre></p>';
}

// Log the user out, if applicable:
if (isset($_GET['logout'])) {

    session_destroy();
    echo '<p>Session destroyed.</p>';

} else { // Otherwise, print the "Log Out" link:
    echo '<a href="sessions.php?logout=true">Log Out</a>';
}

// Reprint the session data:
echo '<p>Session Data:<pre>' . print_r($_SESSION, 1) . '</pre></p>';

echo '</body>
</html>';

// Write and close the session:
session_write_close();