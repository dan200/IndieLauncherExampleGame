<?php
// Get the arguments
$username = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];
$file = $_GET["file"];

// Check if the requested file exists.
// It's good practice to do this before checking for credentials so we don't
// waste user time entering login details for something that doesn't exist.
if( !(isset($file) && file_exists('Downloads/' . $file)) )
{
    header("HTTP/1.0 404 Not Found");
    echo 'File not Found';
    return;
}

// Check user credentials. Do your database access here if you want something more complex than one hardcoded user.
if( strcmp( $username, "guest" ) == 0 &&
    strcmp( $password, "example" ) == 0 )
{
    // Make sure your Downloads folder isn't publicly readable, or people can bypass this script.
    $path = 'Downloads/' . $file;
    header('Content-Type: application/zip');
    header('Content-Length: ' . filesize($path) );
    readfile($path);
}
else
{
    // The credentials were wrong, so return Unauthorized to the launcher so they're prompted to enter them.
    // If you want to deny access without prompting the user for details, return 403 Forbidden.
    header('WWW-Authenticate: Basic realm="IndieLauncher"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Access Denied';
}
?>