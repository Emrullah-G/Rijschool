<?php
session_start();
require_once "config.php";

// Check if the user has the required role
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

if(!isset($_SESSION['user_key'])){
    header("Location: login.php");
    exit;
}

if(!$_SESSION['user_role'] >= 2){
    header("Location: index.php");
    exit;
}

// Establish database connection
$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check if the connection was successful
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get the ID of the car to delete
$id = $_GET['id'];
$func = $_GET['func'];

if ($func == "2") {
    // Delete car from the database
    $deleteQuery = "DELETE FROM cars WHERE car_id=$id";
    mysqli_query($connection, $deleteQuery);
    header("Location: wagenpark.php");
} elseif ($func == "1") {
    // Delete time block from the database
    $deleteQuery = "DELETE FROM tijdblokken WHERE tijdblok_id=$id";
    mysqli_query($connection, $deleteQuery);
    header("Location: tijdblokken.php");
}

?>