<?php
require 'config.php';
// Start the session
session_start();
require_once "assets/header.php";

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

if(!isset($_SESSION['user_key'])){
    header("Location: index");
    exit;
}

if(!$_SESSION['user_role'] == 0){
    header("Location: index");
    exit;
}

// Set up MySQLi connection
$conn = new mysqli(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in and the session variable 'user_id' is set
if (isset($_SESSION['user_id'])) {
    // Query to retrieve user data
    $stmt = $conn->prepare("SELECT datum, resultaat FROM examen WHERE user_id = ?");
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();

    // Get user data
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Fetch data
        $exams = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $exams = [];
    }
    $stmt->close();
} else {
    die("User not logged in.");
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen Informatie</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Examen Informatie</h2>
    <table class="table table-bordered table-striped mt-4">
        <thead class="thead-dark">
        <tr>
            <th>Datum</th>
            <th>Uitslag</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($exams)): ?>
            <?php foreach ($exams as $exam): ?>
                <tr>
                    <td><?php echo htmlspecialchars($exam['datum']); ?></td>
                    <td>
                        <?php
                        if (is_null($exam['resultaat'])) {
                            echo 'Nog niet plaats gevonden';
                        } elseif ($exam['resultaat'] == 0) {
                            echo 'Gezakt';
                        } else {
                            echo 'Geslaagd';
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2" class="text-center">Geen gegevens gevonden</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen Informatie</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
</html>
