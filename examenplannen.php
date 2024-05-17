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

// Create a database connection
$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check if the connection was successful
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

require 'assets/layouts/modals.php';
?>
<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Datum = date('Y-m-d H:i:s', strtotime($_POST['Datum']));
    $Leerling = $_POST['leerling'];

    $sql = "INSERT INTO examen (user_id, datum) VALUES ('$Leerling', '$Datum')";

    if (mysqli_query($connection, $sql)) {
        echo "<div class='alert alert-success'>Examen is toegevoegd</div>";
    } else {
        echo "<div class='alert alert-danger'>Er is iets misgegaan</div>";
    }
    
}
?>

<style>
    h2 {
        margin-top: 0;
        margin-bottom: 20px;
        color: #333;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
        font-weight: bold;
        color: #555;
    }
    td a {
        text-decoration: none;
        color: #007bff;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="date"],
    input[type="submit"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }
    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #0056b3;
    }
    .error {
        color: red;
    }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Examen</title>
</head>
<body>
<div id="container_now" class="container mt-5 bg-light p-2 border d-flex justify-content-center align-items-center">
    <div class="row">
        <div class="col-12">
            <h2>Add Examen</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                <label for="Datum">Datum examen:</label><br>
                <input type="datetime-local" name="Datum" id="Datum" min="<?php echo date('Y-m-d\TH:i'); ?>" required><br>

                <!-- Select leerling from the database -->
                <label for="leerling">Leerling:</label><br>
                <select id="leerling" name="leerling">
                    <?php
                    $sql = "SELECT id, CONCAT(firstname, ' ', lastname) AS name FROM user WHERE role = 0";
                    $result = mysqli_query($connection, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }

                    ?>
                </select><br>
                <input type="submit" value="Add" class="btn btn-primary mt-3">
            </form>
        </div>
    </div>
</div>
</body>
</html>
