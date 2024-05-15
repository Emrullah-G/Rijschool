<?php
session_start();
require_once "assets/header.php";
require_once "config.php";

// Check if the user is logged in
// If not, redirect to the login page
// Uncomment the following lines to enable this check
// if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 2) {
//     header("Location: login.php");
//     exit;
// }

// Establish a database connection
$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check if the connection was successful
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get the ID of the car to edit
$id = $_GET['id'];

// Fetch the current data of the car
$result = mysqli_query($connection, "SELECT * FROM cars WHERE car_id=$id");
$row = mysqli_fetch_assoc($result);

// Update the car information in the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newKenteken = $_POST['kenteken'];
    $newModel = $_POST['model'];
    $newBouwjaar = $_POST['bouwjaar'];
    $updateQuery = "UPDATE cars SET license_plate='$newKenteken', car_modal='$newModel', car_buildyear='$newBouwjaar' WHERE car_id=$id";
    mysqli_query($connection, $updateQuery);
    header("location: wagenpark.php");
}
// Get the current URL
$currentURL = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit auto</title>
</head>
<body>
    <h2>Edit auto</h2>
    <form action="<?php echo $currentURL; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $row['car_id']; ?>">
        <label for="name">Kenteken:</label><br>
        <input type="text" id="Kenteken" name="kenteken" value="<?php echo $row['license_plate']; ?>"><br>
        <label for="model">Model:</label><br>
        <input type="text" id="model" name="model" value="<?php echo $row['car_modal']; ?>"><br>
        <label for="bouwjaar">Bouwjaar:</label><br>
        <input type="text" id="bouwjaar" name="bouwjaar" value="<?php echo $row['car_buildyear']; ?>"><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>