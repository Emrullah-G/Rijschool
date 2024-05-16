<?php
session_start();
require_once "assets/header.php";
require_once "config.php";

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

// Establish a database connection
$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check if the connection was successful
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get the ID of the car to edit
$id = $_GET['id'];

// Fetch the current data of the car
$result = mysqli_query($connection, "SELECT * FROM tijdblokken WHERE tijdblok_id=$id");
$row = mysqli_fetch_assoc($result);

// Update the car information in the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newinstructeur = $_POST['instructeur'];
    $newcar = $_POST['car'];
    $newstatus = $_POST['status'];
    $updateQuery = "UPDATE tijdblokken SET instructeur='$newinstructeur', car='$newcar', status='$newstatus' WHERE tijdblok_id=$id";
    mysqli_query($connection, $updateQuery);
    header("location: tijdblokken.php");
}
// Get the current URL
$currentURL = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit tijdblok</title>
</head>
<body>
    <h2>Edit tijdblok</h2>
    <form action="<?php echo $currentURL; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $row['tijdblok_id']; ?>">
        <label for="car">car:</label><br>
        <select id="car" name="car">
        <?php
        // Fetch all cars from the cars table
        $carQuery = "SELECT * FROM cars";
        $carResult = mysqli_query($connection, $carQuery);

        // Loop through the cars and create an option for each one
        while ($carrow = mysqli_fetch_assoc($carResult)) {
            echo "<option value='" . $carrow['car_id'] . "'>" . $carrow['license_plate'] . " " . $carrow['car_modal'] . "</option>";
        }
        ?>
        </select><br>
        <label for="instructeur">instructeur:</label><br>
        <select id="instructeur" name="instructeur">
        <?php
        // Fetch all users with role 1 from the users table
        $userQuery = "SELECT * FROM user WHERE role = 1";
        $userResult = mysqli_query($connection, $userQuery);
        
        // Loop through the users and create an option for each one
        while ($userRow = mysqli_fetch_assoc($userResult)) {
            echo "<option value='" . $userRow['id'] . "'>" . $userRow['firstname'] . " " . $userRow['lastname'] . "</option>";
        }
        ?>
        </select><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>