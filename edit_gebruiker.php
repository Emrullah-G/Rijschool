<?php
session_start(); // Start the session to manage user data
require_once "assets/header.php"; // Include the header file
require_once "config.php"; // Include the database configuration file

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

// Get the ID of the user to edit from the URL parameters
$id = $_GET['id'];

// Fetch the current data of the user from the database
$result = mysqli_query($connection, "SELECT id, email, firstname, lastname, address, zipcode, birthdate, phone FROM user WHERE id=$id");
$row = mysqli_fetch_assoc($result);

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security to prevent SQL injection
    $newemail = mysqli_real_escape_string($connection, $_POST['email']);
    $newfirstname = mysqli_real_escape_string($connection, $_POST['firstname']);
    $newlastname = mysqli_real_escape_string($connection, $_POST['lastname']);
    $newaddress = mysqli_real_escape_string($connection, $_POST['address']);
    $newzipcode = mysqli_real_escape_string($connection, $_POST['zipcode']);
    $newbirthdate = mysqli_real_escape_string($connection, $_POST['birthdate']);
    $newphone = mysqli_real_escape_string($connection, $_POST['phone']);

    // Construct the SQL update query
    $updateQuery = "UPDATE user SET email='$newemail', firstname='$newfirstname', lastname='$newlastname', address='$newaddress', zipcode='$newzipcode', birthdate='$newbirthdate', phone='$newphone' WHERE id=$id";

    // Execute the update query
    if (mysqli_query($connection, $updateQuery)) {
        // If the query was successful, display a success message
        echo "User updated successfully.";
        // Optionally redirect to a success page
        header("Location: gebruikers.php");
        exit(); // Ensure no further code is executed after the redirection
    } else {
        // If the query failed, display an error message
        echo "Error updating user: " . mysqli_error($connection);
    }
}

// Get the current URL for the form action
$currentURL = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit user</title>
</head>
<body>
    <h2>Edit user</h2>
    <!-- The form for editing user information -->
    <form action="<?php echo htmlspecialchars($currentURL); ?>" method="post">
        <!-- Hidden input to store the user ID -->
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <!-- Input fields for user information -->
        <label for="email">Email:</label><br>
        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>"><br>
        <label for="firstname">Voornaam:</label><br>
        <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($row['firstname']); ?>"><br>
        <label for="lastname">Achternaam:</label><br>
        <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($row['lastname']); ?>"><br>
        <label for="address">Adres:</label><br>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($row['address']); ?>"><br>
        <label for="zipcode">Postcode:</label><br>
        <input type="text" id="zipcode" name="zipcode" value="<?php echo htmlspecialchars($row['zipcode']); ?>"><br>
        <label for="birthdate">Geboortedatum:</label><br>
        <input type="text" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($row['birthdate']); ?>"><br>
        <label for="phone">Telefoonnummer:</label><br>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>"><br>
        <!-- Submit button to update user information -->
        <input type="submit" value="Update">
    </form>
</body>
</html>

<?php
// Close the database connection
mysqli_close($connection);
?>
