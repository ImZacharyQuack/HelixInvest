<?php

$host = "fdb1032.awardspace.net";
$dbname = "4368459_helixdatabase";
$username = "4368459_helixdatabase";
$password = "a6x@6j9@qsq77GP";

$mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;