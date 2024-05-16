<?php

session_start();
require_once "assets/header.php";
require_once "config.php";

if(!['user_role'] >= 2){
    header("Location: index");
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
            // Verbinding maken met de database
            $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

            // Controleren op fouten
            if ($connection->connect_error) {
                die("Verbinding mislukt: " . $mysqli->connect_error);
            }

            if (isset($_GET['beginDate']) && isset($_GET['endDate'])) {
                $begin = new DateTime($_GET['beginDate']);
                $end = new DateTime($_GET['endDate']);
                // Bereken het verschil tussen de begin- en einddatum
                $diff = $begin->diff($end);

                // Bereken en update bezettingsgraad voor elke kamer
                $result = $connection->query("SELECT license_plate, car_id FROM cars");
                while ($row = $result->fetch_assoc()) {
                    $carId = $row["car_id"];
                    $license_plate = $row["license_plate"];
                    $totalDriveTime = 0;

                    // Haal alle afspraken van de huidige maand op voor deze kamer
                    $appointmentsResult = $connection->query("SELECT car FROM appointments WHERE car = $carId");
                    $numAppointments = $appointmentsResult->num_rows;

                    $appointmenttime = 60; // 60 minuten per afspraak
                    $totalDriveTime = $numAppointments * $appointmenttime;// totale rijtijd in minuten

                    $bezetting = $totalDriveTime / ($diff->days * 24 * 60) * 100; // Bezetting in procenten
                    $bezetting = round($bezetting, 2);

                    echo "<tr><td>" . $row["license_plate"] . "</td><td>" . $bezetting . "</td></tr>";
                }
            }

            // Sluit de verbinding
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
            // Verbinding maken met de database
            $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

            // Controleren op fouten
            if ($connection->connect_error) {
                die("Verbinding mislukt: " . $mysqli->connect_error);
            }

            if (isset($_GET['beginDate']) && isset($_GET['endDate'])) {
                $begin = new DateTime($_GET['beginDate']);
                $end = new DateTime($_GET['endDate']);

                // Bereken en update bezettingsgraad voor elke kamer
                $result = $connection->query("SELECT license_plate, car_id FROM cars");
                while ($row = $result->fetch_assoc()) {
                    $carId = $row["car_id"];
                    $license_plate = $row["license_plate"];

                    // Haal alle afspraken van de huidige maand op voor deze kamer
                    $appointmentsResult = $connection->query("SELECT car, appointment_date FROM appointments WHERE car = $carId");
                    while ($appointment = $appointmentsResult->fetch_assoc()) {
                        echo "<tr><td>" . $license_plate . "</td><td>" . $appointment["appointment_date"] . "</td></tr>";
                    }
                }
            }

            // Sluit de verbinding
            $connection->close();
            ?>
        </tbody>
    </table>
</body>
</html>