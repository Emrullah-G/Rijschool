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
            <h2>gebruikers</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <label for="naaam">naam:</label>
                <input type="text" name="naam" id="naam" required>
                <input type="submit" value="Search">
            </form>    
            <table>
                <tr>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Postal Code</th>
                    <th>Birthday</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                </tr>
                <?php
                // Get the current date and time
                $currentdatetime = date('Y-m-d H:i:s');

                // Check if the form is submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $naam = $_POST['naam'];

                    // Escape the input to prevent SQL injection
                    $naam = mysqli_real_escape_string($connection, $naam);

                    // Fetch the combined name (firstname and lastname) and other columns from the user table
                    $query = "SELECT id, CONCAT(firstname, ' ', lastname) AS name, email, address, zipcode, birthdate, phone, role 
                              FROM user 
                              WHERE CONCAT(firstname, ' ', lastname) LIKE '%$naam%'";

                    $result = mysqli_query($connection, $query);

                    // Check if the query was successful
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Map role integers to role names
                            switch ($row['role']) {
                                case 0:
                                    $row['role'] = "User";
                                    break;
                                case 1:
                                    $row['role'] = "Instructor";
                                    break;
                                case 2:
                                    $row['role'] = "Admin";
                                    break;
                                default:
                                    $row['role'] = "Unknown";
                                    break;
                            }

                            // Check if the user had an appointment in the last month
                            $lastMonth = date('Y-m-d', strtotime('-1 month'));
                            $query = "SELECT * FROM appointments WHERE apprentice = {$row['id']} AND appointment_date >= '{$lastMonth}'";
                            $appointmentResult = mysqli_query($connection, $query);

                            // Check if the query was successful
                            if ($appointmentResult && mysqli_num_rows($appointmentResult) > 0 && $row['role'] == "User") {
                                $status = "Active";
                            } elseif ($row['role'] == "Instructor") {
                                $status = "Instructor";
                            } elseif ($row['role'] == "Admin") {
                                $status = "Admin";
                            } else {
                                $status = "Inactive";
                            }

                            echo "<tr>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['address'] . "</td>";
                            echo "<td>" . $row['zipcode'] . "</td>";
                            echo "<td>" . $row['birthdate'] . "</td>";
                            echo "<td>" . $row['phone'] . "</td>";
                            echo "<td>" . $row['role'] . "</td>";
                            echo "<td>" . $status . "</td>";
                            echo "<td><a href='edit_gebruiker.php?id=" . $row['id'] . "'>Edit</a> | <a href='delete.php?id=" . $row['id'] . "&func=3' onclick='return confirm(\"Are you sure you want to delete " . $row['name'] . "?\")'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        // Handle query error or no results found
                        echo "No users found or error in fetching users: " . mysqli_error($connection);
                    }
                }

                // Close the connection
                mysqli_close($connection);
                ?>
            </table>
        </div>
    </div>
</div>
