<?php

session_start();

$title = "Witch Hunt";

// Set minimum number of players
$numplayers = 5;
$maxplayers = 9;

// Setup a connection to the database
$sqlcon = new mysqli("localhost", "CEN4010_S2018g04", "cen4010_s2018", "CEN4010_S2018g04");

// Check SQL connection
if($sqlcon === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}



































?>