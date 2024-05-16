<?php
    $root_path = $_SERVER['DOCUMENT_ROOT'] . '/rijschool';
    require_once $root_path . '/classes/authenticator.php';
    use classes\authenticator;

    $authenticator = new authenticator();

    if($_POST['action'] == "login_account"){
        $authenticator->verifyAccount(
            $_POST['email'],
            $_POST['password']
        );
    }

    if($_POST['action'] == "searchgebruikers"){
        $authenticator->searchAccount(
            $_POST['value']
        );
    }

    if($_POST['action'] == "lessoncredit_aanpassen"){
        $authenticator->lessonCredit(
            $_POST['id'],
            $_POST['textarea']
        );
    }


    if($_POST['action'] == "textarea_settings"){
        $authenticator->textAreasettings(
            $_POST['id'],
            $_POST['textarea']
        );
    }



    if($_POST['action'] == "create_account"){
        $authenticator->createAccount(
            $_POST['email'],
            $_POST['password'],
            $_POST['firstname'],
            $_POST['lastname'],
            $_POST['gender'],
            $_POST['adres'],
            $_POST['postcode'],
            $_POST['number'],
            $_POST['geboortedatum'],
            $_POST['telefoon']
        );
    }

    if($_POST['action'] == "remove_appointment"){
        $authenticator->removeAppointment(
            $_POST['id']
        );
    }

    if($_POST['action'] == "leraarziekmelden"){
        $authenticator->meldjeZiek(
            $_POST['id']
        );
    }

    if($_POST['action'] == "collectadminusers"){
        $authenticator->collectAdminusers();
    }

    if($_POST['action'] == "collectdatesselect"){
        $authenticator->collectDates(
            $_POST['valueselected'],
        );
    }

    if($_POST['action'] == "collecttimesselect"){
        $authenticator->collectTimes(
            $_POST['valueselected'],
            $_POST['selectedUser']
        );
    }


    if($_POST['action'] == "createAfspraak"){
        $authenticator->createAfspraak(
            $_POST['date'],
            $_POST['instructor'],
            $_POST['einddatum'],
            $_POST['student_id'],
        );
    }



    if($_POST['action'] == "changepassword"){
        $authenticator->changePassworduser(
            $_POST['iduser'],
            $_POST['password']
        );
    }

if($_POST['action'] == "removeAppo"){
    include "config.php";

    $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $updateQuery = "DELETE FROM appointments WHERE id = ".$_POST['appoid'] ;
    mysqli_query($connection, $updateQuery);


    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    return;
}

?>