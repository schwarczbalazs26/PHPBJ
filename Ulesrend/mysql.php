<?php

$servername = "localhost";
$username = "phpteszt";
$password = "N=)%A9E*g;@NY]4";
$db = "ulesrend";

$conn = new mysqli($servername, $username, $password, $db);

$conn->set_charset("utf8");

if ($conn->connect_error){
    die("Connection failed: " .$conn->connect_error);
}

?>