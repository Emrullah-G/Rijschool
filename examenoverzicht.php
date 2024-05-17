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

require 'assets/layouts/modals.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>examen slaging precentage</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>examen slaging precentage</h1>
    <form method="GET">
        <label for="beginDate">Begin Date:</label>
        <input type="datetime-local" id="beginDate" name="beginDate" required>
        <br>
        <label for="endDate">End Date:</label>
        <input type="datetime-local" id="endDate" name="endDate" required>
        <br>
        <input type="submit" value="Submit">
    </form>
    <table>
        <thead>
            <tr>
                <th>slaging in %</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Connect to the database
            $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

            // Check for connection errors
            if ($connection->connect_error) {
                die("Verbinding mislukt: " . $mysqli->connect_error);
            }

            if (isset($_GET['beginDate']) && isset($_GET['endDate'])) {
                $begin = new DateTime($_GET['beginDate']);
                $end = new DateTime($_GET['endDate']);
                $beginString = $begin->format('Y-m-d H:i:s');
                $endString = $end->format('Y-m-d H:i:s');
                $query = "SELECT * FROM examen WHERE datum BETWEEN '$beginString' AND '$endString'";
                $result = mysqli_query($connection, $query);
                $total = 0;
                $passed = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $total++;
                    if ($row['resultaat'] == 1) {
                        $passed++;
                    }
                }
                // Calculate the percentage of passed exams
                $percentage = ($passed / $total) * 100;
                echo "<tr><td>" . $percentage . "</td></tr>";   
            }

            // Close the connection
            $connection->close();
            ?>
        </tbody>
    </table><br>
</body>
</html>
