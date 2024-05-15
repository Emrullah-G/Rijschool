<?php
session_start();
require_once "config.php";

//if (!$_SESSION['user_id'] == 2) {
//    header("Location: login.php");
//    exit;
//}

$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// Check if the connection was successful
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}
// Get the ID of the car to delete
$id = $_GET['id'];
$func = $_GET['func'];

if ($func == "2") {
    $deleteQuery = "DELETE FROM cars WHERE car_id=$id";
    mysqli_query($connection, $deleteQuery);
    header("Location: wagenpark.php");
}
elseif ($func == "1") {
    $deleteQuery = "DELETE FROM tijdblokken WHERE tijdblok_id=$id";
    mysqli_query($connection, $deleteQuery);
    header("Location: tijdblokken.php");
}


?>