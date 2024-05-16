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
            <h2>Autos</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>kenteken</th>
                    <th>bouwjaar</th>
                    <th>merk</th>
                </tr>
                <?php
                // Check if the form is submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (!empty($_POST["kenteken"])) {
                        // Get the kentken of the auto from the form
                        $kenteken = $_POST["kenteken"];
                        // Get the model of the auto from the form
                        $model = $_POST["model"];
                        // Get the bouwjaar of the auto from the form
                        $bouwjaar = $_POST["bouwjaar"];

                        // Insert the new auto into the database
                        $insertQuery = "INSERT INTO cars (license_plate, car_modal, car_buildyear) VALUES ('$kenteken', '$model', '$bouwjaar')";
                        // Check if the query was successful
                        if (mysqli_query($connection, $insertQuery)) {
                            header("Location: wagenpark.php");
                        } else {
                            echo "Error adding auto: " . mysqli_error($connection);
                        }
                    }
                }
                ?>
                <?php
                // Fetch all tennis courts from the database
                $autos = mysqli_query($connection, "SELECT * FROM cars");
                // Loop through the result and display the data in a table
                while ($row = mysqli_fetch_assoc($autos)) {
                    echo "<tr>";
                    echo "<td>" . $row['car_id'] . "</td>";
                    echo "<td>" . $row['license_plate'] . "</td>";
                    echo "<td>" . $row['car_buildyear'] . "</td>";
                    echo "<td>" . $row['car_modal'] . "</td>";
                    echo "<td><a href='edit_car.php?id=" . $row['car_id'] . "'>Edit</a> | <a href='delete.php?id=" . $row['car_id'] . "&func=2' onclick='return confirm(\"Are you sure you want to delete " . $row['license_plate'] . "?\")'>Delete</a></td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
        <div class="col-12">
            <h2>Add Auto</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <label for="kenteken">kenteken:</label><br>
                <input type="text" name="kenteken" id="kenteken" required><br>

                <label for="bouwjaar">bouwjaar:</label><br>
                <input type="text" name="bouwjaar" id="bouwjaar" required><br>

                <label for="model">model:</label><br>
                <input type="text" name="model" id="model" required><br>

                <input type="submit" value="Add">
            </form>
        </div>
    </div>
</div>