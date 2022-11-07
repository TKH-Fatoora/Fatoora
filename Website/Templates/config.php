<?php

// MYSQLI Server Connection Variables
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "Fatoora";

// Connection Statment to mysqli Server
$dbc = mysqli_connect($hostname, $username, $password, $dbname) OR die("Couldnt connect to DB" . mysqli_connect_error());
// Setting the Charchter Set
mysqli_set_charset($dbc,"utf8");

// The Path to the Images Folder
$imagesPath = "../images/";
