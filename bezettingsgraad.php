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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bezetting auto's</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Bezetting auto's</h1>
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
                <th>kenteken</th>
                <th>Bezettingsgraad in %</th>
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
                // Calculate the difference between the start and end date
                $diff = $begin->diff($end);

                // Calculate and update occupancy rate for each car
                $result = $connection->query("SELECT license_plate, car_id FROM cars");
                while ($row = $result->fetch_assoc()) {
                    $carId = $row["car_id"];
                    $license_plate = $row["license_plate"];
                    $totalDriveTime = 0;

                    // Get all appointments for this car
                    $appointmentsResult = $connection->query("SELECT car FROM appointments WHERE car = $carId");
                    $numAppointments = $appointmentsResult->num_rows;

                    $appointmenttime = 60; // 60 minutes per appointment
                    $totalDriveTime = $numAppointments * $appointmenttime; // total drive time in minutes

                    $bezetting = $totalDriveTime / ($diff->days * 24 * 60) * 100; // Occupancy rate in percentage
                    $bezetting = round($bezetting, 2);

                    echo "<tr><td>" . $row["license_plate"] . "</td><td>" . $bezetting . "</td></tr>";
                }
            }

            // Close the connection
            $connection->close();
            ?>
        </tbody>
    </table><br>
    <table>
        <thead>
            <tr>
                <th>kenteken</th>
                <th>datum afspraak</th>
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

                // Get all appointments for each car
                $result = $connection->query("SELECT license_plate, car_id FROM cars");
                while ($row = $result->fetch_assoc()) {
                    $carId = $row["car_id"];
                    $license_plate = $row["license_plate"];

                    // Get all appointments for this car
                    $appointmentsResult = $connection->query("SELECT car, appointment_date FROM appointments WHERE car = $carId");
                    while ($appointment = $appointmentsResult->fetch_assoc()) {
                        echo "<tr><td>" . $license_plate . "</td><td>" . $appointment["appointment_date"] . "</td></tr>";
                    }
                }
            }

            // Close the connection
            $connection->close();
            ?>
        </tbody>
    </table>

    <script>
        function setMinutesToZero(input) {
            input.addEventListener('input', function (e) {
                let value = e.target.value;
                if (value) {
                    let date = new Date(value);
                    date.setMinutes(0);
                    date.setSeconds(0);
                    date.setMilliseconds(0);

                    // Format date to YYYY-MM-DDTHH:00 in local time
                    let year = date.getFullYear();
                    let month = ('0' + (date.getMonth() + 1)).slice(-2);
                    let day = ('0' + date.getDate()).slice(-2);
                    let hours = ('0' + date.getHours()).slice(-2);
                    let formattedDate = `${year}-${month}-${day}T${hours}:00`;

                    e.target.value = formattedDate;
                }
            });
        }

        // Apply to both beginDate and endDate inputs
        setMinutesToZero(document.getElementById('beginDate'));
        setMinutesToZero(document.getElementById('endDate'));
    </script>
</body>
</html>
