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
            <div class="modal-body">
                <input type="password" id="wachtwoord1" class="form-control" placeholder="Nieuw wachtwoord">
                <input type="password" id="wachtwoord2" class="mt-2 form-control" placeholder="Herhaal wachtwoord">
                <input type="hidden" id="iduser" value="<?php echo $_SESSION['user_id']; ?>">
            </div>
            <div class="modal-footer">
                <button type="button" data-action="closesettings_personal" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
                <button type="button" data-action="confirmchanges_personal" class="btn btn-primary">Opslaan</button>
            </div>
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