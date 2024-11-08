<?php
//Check what server you are accessing
if (strstr($_SERVER['SERVER_NAME'], 'localhost')) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "petsvictoria";
} else {
    $servername = "talsprddb02.int.its.rmit.edu.au";
    $username = "s3991013";
    $password = "jac_Devesh123";
    $dbname = "s3991013";
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
