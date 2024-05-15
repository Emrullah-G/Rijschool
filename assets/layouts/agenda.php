<?php
    use classes\authenticator;



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


<?php

    if($_SESSION['user_role'] == 1){
        ?>

        <div class="container-fluid p-0 mt-5">
            <table class="table table-light align-items-center table-striped">
                <colgroup>
                    <col width='120'>
                    <col width='120'>
                    <col width='120'>
                    <col width='160'>
                    <col width='160'>
                    <col width='120'>
                    <col width='30'>
                </colgroup>
                <thead>
                <tr>
                    <th>Lesnummer</th>
                    <th>Leerling</th>
                    <th>Auto</th>
                    <th>Tijd</th>
                    <th>Ophaaladres</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <?php

                $authenticator = new authenticator();
                $appointments = $authenticator->collectAppointments( $_SESSION['user_id'], $_SESSION['user_role'] );

                if(!$appointments){
                    echo "<tr><td colspan='7'>Er zijn geen actieve afspraken</td></tr>";
                }

                // Loop door de afspraken en toon ze in de tabel
                foreach ($appointments as $appointment) {

                    if($appointment['status'] == 1){
                        $appointment['status'] = 'Gecanceld';
                    }
                    else{
                        $appointment['status'] = 'Actief';
                    }

                    echo "
                <tr>
                    <td>{$appointment['lesson']}</td>
                    <td>{$appointment['firstname']} {$appointment['lastname']} <button data-action='{$appointment['id']}' style='padding: 0px;margin-top:-5px;' type='button'><i class='text-danger fa-solid fa-circle-info'></i></button></td>
                    <td>{$appointment['license_plate']}</td>
                    <td>{$appointment['appointment_date']}</td>
                    <td>{$appointment['address']}, {$appointment['zipcode']}</td>
                    <td>{$appointment['status']}</td>
                    <td><button style='padding: 0px;' data-action='{$appointment['id']}' type='button'><i class='fa-regular fa-note-sticky'></i></button></td>
                </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>


        <?php
    }
    else{
        ?>

        <div class="container-fluid p-0 mt-5">
            <!--    <div class="row mt-5">-->
            <!--        <div class="col-6"><h2>Afspraken</h2></div>-->
            <!--        <div class="col-6 d-flex align-items-center justify-content-end"><a class="btn btn-success" href="resevering.php">Reserveren</a></div>-->
            <!--    </div>-->

            <table class="table table-light align-items-center table-striped">
                <colgroup>
                    <col width='120'>
                    <col width='120'>
                    <col width='120'>
                    <col width='160'>
                    <col width='160'>
                    <col width='120'>
                    <col width='30'>
                </colgroup>
                <thead>
                <tr>
                    <th>Lesnummer</th>
                    <th>Leerling</th>
                    <th>Auto</th>
                    <th>Tijd</th>
                    <th>Ophaaladres</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <?php

                $authenticator = new authenticator();
                $appointments = $authenticator->collectAppointments( $_SESSION['user_id'], $_SESSION['user_role'] );

                if(!$appointments){
                    echo "<tr><td colspan='7'>Er zijn geen actieve afspraken</td></tr>";
                }

                // Loop door de afspraken en toon ze in de tabel
                foreach ($appointments as $appointment) {

                    if($appointment['status'] == 1){
                        $appointment['status'] = 'Gecanceld';
                    }
                    else{
                        $appointment['status'] = 'Actief';
                    }

                    echo "
                <tr>
                    <td>{$appointment['lesson']}</td>
                    <td>{$appointment['firstname']} {$appointment['lastname']} <button style='padding: 0px;margin-top:-5px;' type='button'><i class='text-danger fa-solid fa-circle-info'></i></button></td>
                    <td>{$appointment['license_plate']}</td>
                    <td>{$appointment['appointment_date']}</td>
                    <td>{$appointment['address']}, {$appointment['zipcode']}</td>
                    <td>{$appointment['status']}</td>
                    <td><button style='padding: 0px;' type='button'><i class='fa-regular fa-note-sticky'></i></button></td>
                </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>



        <?php
    }
?>

