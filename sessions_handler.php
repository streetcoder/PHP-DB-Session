<?php

// Global variable used for the database
$con = NULL;

/*
 * Define the open_session() function:
 * This function takes no arguments.
 * This function should open the database connection.
 * This function should return true.*/
function open_session() {
    global $con;

    // Connect to the database:
    $con = mysqli_connect ('localhost', 'username', 'password', 'your_db');

    return true;
}

/* Define the close_session() function:
 * This function takes no arguments.
 * This function closes the database connection.
 * This function returns the closed status.
 * */

function close_session() {
    global $con;

    return mysqli_close($con);
}

/* Define the read_session() function:
* This function takes one argument: the session ID.
* This function retrieves the session data.
* This function returns the session data as a string.
 * */
function read_session($sid) {
    global $con;

    // Query the database:
    $q = sprintf('SELECT data FROM sessions WHERE id="%s"', mysqli_real_escape_string($con, $sid));
    $r = mysqli_query($con, $q);

    // Retrieve the results:
    if (mysqli_num_rows($r) == 1) {
        list($data) = mysqli_fetch_array($r, MYSQLI_NUM);

        // Return the data:
        return $data;

    } else { // Return an empty string.
        return '';
    }
}

/*
 * Define the write_session() function:
 * This function takes two arguments:
 * the session ID and the session data.
  */
function write_session($sid, $data) {
    global $con;

    // Store in the database:
    $q = sprintf('REPLACE INTO sessions (id, data) VALUES ("%s", "%s")', mysqli_real_escape_string($con, $sid), mysqli_real_escape_string($con, $data));
    $r = mysqli_query($con, $q);

    return true;
}

/*
 * Define the destroy_session() function:
 * This function takes one argument: the session ID.
 * */


function destroy_session($sid) {
    global $con;

    // Delete from the database:
    $q = sprintf('DELETE FROM sessions WHERE id="%s"', mysqli_real_escape_string($con, $sid));
    $r = mysqli_query($con, $q);

    // Clear the $_SESSION array:
    $_SESSION = array();

    return true;
} // End of destroy_session() function.


/*
 * Define the clean_session() function:
 * This function takes one argument: a value in seconds.
 * */


function clean_session($expire) {
    global $con;

    // Delete old sessions:
    $q = sprintf('DELETE FROM sessions WHERE DATE_ADD(last_accessed, INTERVAL %d SECOND) < NOW()', (int) $expire);
    $r = mysqli_query($con, $q);

    return true;
}


// Declare the functions to use:
session_set_save_handler('open_session', 'close_session', 'read_session', 'write_session', 'destroy_session', 'clean_session');



// Start the session:
session_start();