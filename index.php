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
require 'assets/layouts/modals.php';
?>

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
