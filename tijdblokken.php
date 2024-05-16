<?php

session_start();
require_once "assets/header.php";
require_once "config.php";

if(!['user_role'] >= 2){
    header("Location: index");
    exit;
}
// Create a database connection
$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check if the connection was successful
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>

<?php
// Retrieve tijdblokken data from the database
$tijdbloktime = mysqli_query($connection, "SELECT tijdblok_id, start, end FROM tijdblokken");

while ($tijdbloktimeResult = mysqli_fetch_assoc($tijdbloktime)) {
    $id = $tijdbloktimeResult['tijdblok_id'];
    $start = strtotime($tijdbloktimeResult['start']);
    $end = strtotime($tijdbloktimeResult['end']);
    $diff = $end - $start;

    if ($diff != 0) {
        // Calculate the bezetting (occupancy) percentage
        $tijdblokken = mysqli_query($connection, "SELECT id FROM appointments WHERE tijdblok = $id");
        $numRows = mysqli_num_rows($tijdblokken);
        $appointmenttime = 60; // 60 minutes per appointment
        $totalappointmenttime = $numRows * $appointmenttime;
        $bezetting = ($totalappointmenttime / ($diff / 60)) * 100;
        $bezetting = round($bezetting, 2);
    } else {
        $bezetting = 0;
    }

    if ($bezetting == 100) {
        // Update the status of the tijdblokken to 'bezet'
        $updateqeury = "UPDATE tijdblokken SET status = 'bezet' WHERE tijdblok_id = $id";
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

<div id="container_now" class="container mt-5 bg-light p-2 border d-flex justify-content-center align-items-center">
    <div class="row">
        <div class="col-12">
            <h2>Overzicht tijdblokken</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>start</th>
                    <th>end</th>
                    <th>car</th>
                    <th>instructeur</th>
                    <th>status</th>
                </tr>
                <?php
                // Check if the form is submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (!empty($_POST["start"])) {
                        // Get the start and end times from the form
                        $start = $_POST["start"];
                        $end = $_POST["end"];

                        // Insert the new tijdblokken into the database
                        $insertQuery = "INSERT INTO tijdblokken (start, end) VALUES ('$start', '$end')";

                        // Check if the query was successful
                        if (mysqli_query($connection, $insertQuery)) {
                            header("Location: tijdblokken.php");
                        } else {
                            echo "Error adding tijdblokken: " . mysqli_error($connection);
                        }
                    }
                }
                ?>
                <?php
                // Fetch all tijdblokken from the database
                $tijdblokken = mysqli_query($connection, "SELECT * FROM tijdblokken");

                // Loop through the result and display the data in a table
                while ($row = mysqli_fetch_assoc($tijdblokken)) {
                    echo "<tr>";
                    echo "<td>" . $row['tijdblok_id'] . "</td>";
                    echo "<td>" . $row['start'] . "</td>";
                    echo "<td>" . $row['end'] . "</td>";
                    echo "<td>" . $row['car'] . "</td>";
                    echo "<td>" . $row['instructeur'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td><a href='tijdblok_edit.php?id=" . $row['tijdblok_id'] . "'>Edit</a> | <a href='delete.php?id=" . $row['tijdblok_id'] . "&func=1' onclick='return confirm(\"Are you sure you want to delete " . $row['tijdblok_id'] . "?\")'>Delete</a> | <a href='tijdblokinzicht.php?id=" . $row['tijdblok_id'] . "'>Info</a></td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
        <div class="col-12">
            <h2>Add Timeblokk</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <label for="start">Start:</label><br>
                <input type="datetime-local" name="start" id="start" required class="datetimepicker" min="<?php echo date('Y-m-d\TH:i'); ?>"><br>

                <label for="end">End:</label><br>
                <input type="datetime-local" name="end" id="end" required class="datetimepicker" min="<?php echo date('Y-m-d\H:i'); ?>"><br>

                <input type="submit" value="Add">
            </form>
        </div>
    </div>
</div>