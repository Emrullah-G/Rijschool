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

    th,
    td {
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
            <h2>Overzicht tijdblok</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Bezetting in %</th>
                </tr>
                <?php
                $id = $_GET['id'];

                // Get start and end time of the time block
                $tijdbloktime = mysqli_query($connection, "SELECT start, end FROM tijdblokken");
                $tijdbloktimeResult = mysqli_fetch_assoc($tijdbloktime);
                $start = strtotime($tijdbloktimeResult['start']);
                $end = strtotime($tijdbloktimeResult['end']);
                $diff = $end - $start;

                if ($diff != 0) {
                    // Calculate occupancy percentage
                    $tijdblokken = mysqli_query($connection, "SELECT id FROM appointments WHERE tijdblok = $id");
                    $numRows = mysqli_num_rows($tijdblokken);
                    $appointmenttime = 60; // 60 minutes per appointment
                    $totalappointmenttime = $numRows * $appointmenttime;
                    $bezetting = ($totalappointmenttime / ($diff / 60)) * 100;
                    $bezetting = round($bezetting, 2);
                } else {
                    $bezetting = 0;
                }

                echo "<tr><td>" . $id . "</td><td>" . $bezetting . "</td></tr>";
                ?>
            </table>
        </div>

        <div class="col-12">
            <h2>Afspraken in Timeblokk</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Leerling</th>
                    <th>Commentary</th>
                    <th>Goal</th>
                    <th>Lesson</th>
                    <th>Appointment Date</th>
                    <th>Status</th>
                </tr>
                <?php
                $id = $_GET['id'];

                // Get appointments for the time block
                $appointments = mysqli_query($connection, "SELECT id, apprentice, commentary, goal, lesson, appointment_date, status FROM appointments WHERE tijdblok = $id");
                while ($row = mysqli_fetch_assoc($appointments)) {
                    // Get student information
                    $student = mysqli_query($connection, "SELECT firstname, lastname FROM user WHERE id = " . $row['apprentice']);
                    $studentResult = mysqli_fetch_assoc($student);

                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $studentResult['firstname'] . " " . $studentResult['lastname'] . "</td>";
                    echo "<td>" . $row['commentary'] . "</td>";
                    echo "<td>" . $row['goal'] . "</td>";
                    echo "<td>" . $row['lesson'] . "</td>";
                    echo "<td>" . $row['appointment_date'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>

        <div class="col-12">
            <h2>Toegewezen auto/Instructeur</h2>
            <table>
                <tr>
                    <th>Auto</th>
                    <th>Instructeur</th>
                </tr>
                <?php
                $id = $_GET['id'];

                // Get assigned car and instructor for the time block
                $tijdblokinstrucauto = mysqli_query($connection, "SELECT car, instructeur FROM tijdblokken WHERE tijdblok_id = $id");
                $tijdblokinstrucautoResult = mysqli_fetch_assoc($tijdblokinstrucauto);
                // Get car information
                $car = mysqli_query($connection, "SELECT license_plate, car_modal FROM cars WHERE car_id = " . $tijdblokinstrucautoResult['car']);
                $carResult = mysqli_fetch_assoc($car);
                // Get instructor information
                $instructeur = mysqli_query($connection, "SELECT firstname, lastname FROM user WHERE id = " . $tijdblokinstrucautoResult['instructeur']);
                $instructeurResult = mysqli_fetch_assoc($instructeur);

                echo "<tr>";
                echo "<td>" . $carResult['license_plate'] . " " . $carResult['car_modal'] . "</td>";
                echo "<td>" . $instructeurResult['firstname'] . " " . $instructeurResult['lastname'] . "</td>";
                echo "</tr>";
                ?>
            </table>
        </div>
    </div>
</div>