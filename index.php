<?php

session_start();
require_once "assets/header.php";

$root_path = $_SERVER['DOCUMENT_ROOT'] . '/rijschool';
require_once $root_path . '/classes/authenticator.php';
use classes\authenticator;

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

require 'config.php';

// Set up MySQLi connection
$conn = new mysqli(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in and the session variable 'user_id' is set
if (isset($_SESSION['user_id'])) {
    // Query to retrieve user data
    $stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();

    // Get user data
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Fetch user data
        $email = $user['email'];
        $firstname = $user['firstname'];
        $lastname = $user['lastname'];
        $birthdate = $user['birthdate'];
        $phone = $user['phone'];
        $address = $user['address'];
        $postcode = $user['zipcode'];

        // Now you can use $email, $firstname, $lastname, etc.
    } else {
        echo "User not found.";
    }
} else {
    echo "User is not logged in.";
}

// Close the connection
$stmt->close();
$conn->close();

?>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Wachtwoord aanpassen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="save_changes_personalinfo.php" method="post">
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col">
                        <input class="form-control" type="email" placeholder="Emailadres" value="<?php echo $email; ?>" name="personalinfo_email" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <input class="form-control" type="text" placeholder="Firstname" value="<?php echo $firstname; ?>" name="personalinfo_firstname" required>
                    </div>
                    <div class="col">
                        <input class="form-control" type="text" placeholder="Lastname" value="<?php echo $lastname; ?>" name="personalinfo_lastname" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <input class="form-control" type="date" placeholder="Geboortedatum" value="<?php echo $birthdate; ?>" name="personalinfo_birthdate" required>
                    </div>
                    <div class="col">
                        <input class="form-control" type="text" placeholder="Telefoonnummer" value="<?php echo $phone; ?>"  name="personalinfo_phone" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <input class="form-control" type="text" placeholder="Adres" value="<?php echo $address; ?>"  name="personalinfo_address" required>
                    </div>
                    <div class="col">
                        <input class="form-control" type="text" placeholder="Postcode" value="<?php echo $postcode; ?>"  name="personalinfo_postcode" required>
                    </div>
                </div>
                <input type="hidden" id="iduser" name="iduser" value="<?php echo $_SESSION['user_id']; ?>">
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
                <button type="submit" class="btn btn-primary">Opslaan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <?php

    if(isset($_SESSION['user_key'])){
        if($_SESSION['user_role'] == 2){
            echo "Hier moet bram wat coderen";
        }
        else{
            require_once "assets/layouts/agenda.php";
        }
    }
    else{
        require_once "assets/layouts/home.php";
    }

    ?>
</div>
