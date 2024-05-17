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

if(!isset($_SESSION['user_key'])){
    header("Location: index");
    exit;
}

if(!$_SESSION['user_role'] >= 1){
    header("Location: index");
    exit;
}


require 'config.php';
require 'assets/layouts/modals.php';


?>
<div class="container">
    <div class="container-fluid p-0">
        <div class="row mt-5 d-flex justify-content-center">
            <div class="col-12 col-sm-6 rounded bg-light border p-5">
                <div class="mb-2"><strong>Zoek leerling</strong></div>
                <input class="form-control mb-2" type="text" id="student_information_credits" data-action="search_input" placeholder="Zoek leerling op naam">
                <div class="bg-light" style="height: 200px; overflow-y: auto;">
                    <table id="table_search" class="table border table-striped">
                    </table>
                </div>
<!--                <input class="form-control mb-2" type="number" id="student_information_credits" placeholder="Credits">-->
<!--                <input class="form-control mb-2" type="hidden" id="student_information_id" name="personalinfo_email">-->
<!--                <button type="button" class="btn btn-primary">Opslaan</button>-->
            </div>
        </div>
    </div>
</div>
