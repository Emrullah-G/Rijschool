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

    if($_POST['action'] == "changepassword"){
        $authenticator->changePassworduser(
            $_POST['iduser'],
            $_POST['password']
        );
    }

?>