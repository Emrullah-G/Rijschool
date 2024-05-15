<?php

session_start();

if(!empty($_SESSION['user_key'])){
    header('Location: index.php');
    exit;
}

require_once "assets/header.php";

?>

    <div class='container-xl py-2 mt-3'>
        <div class='row justify-content-center align-items-center' style='height: 80vh'>
            <div class='col-md-7 col-lg-5'>
                <div class='shadow-lg h-40vh wrap'>
                    <div class="img text-center" style="position: relative;">
                        <img style="opacity: 1; position: relative; z-index: 1; margin-top: 15px;width: 125px;height: 125px" src="assets/images/logo-drive.png" alt="zgt-logo">
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('assets/images/banner.png'); background-repeat: no-repeat; background-position: center; background-size: cover; opacity: 0.3; z-index: 0;"></div>
                    </div>
                    <div class='login-wrap p-5 p-md-5'>
                        <div class='d-flex'>
                            <div class='w-100'><h3 class='mt-0'>Account aanmaken</h3></div>
                        </div>
                        <form method='POST'>
                            <div class='form-group mt-1'>
                                <input type='email' id='create_email' placeholder='Emailadres' autocomplete="off" class='shadow form-control' required>
                            </div>
                            <div class='form-group mt-1'>
                                <input type='password' id='create_password' placeholder='Wachtwoord' class='shadow form-control' required>
                            </div>

                            <div class='form-group mt-3'>
                                <input type='text' id='create_firstname' placeholder='Voornaam' autocomplete="off" class='shadow form-control' required>
                            </div>
                            <div class='form-group mt-1'>
                                <input type='text'  id='create_lastname' placeholder='Achternaam' autocomplete="off" class='shadow form-control' required>
                            </div>
                            <div class='form-group mt-1'>
                                <input type='date'  id='create_geboortedatum' placeholder='Geboortedatum' autocomplete="off" class='shadow form-control' max="2010-01-01" required>
                            </div>
                            <div class='form-group mt-1'>
                                <input type='text'  id='create_telefoon' placeholder='Telefoon' autocomplete="off" class='shadow form-control' required>
                            </div>
                            <div class='form-group mt-3'>
                                <input type='text'  id='create_adres' placeholder='Adres' autocomplete="off" class='shadow form-control' required>
                            </div>
                            <div class='form-group mt-1'>
                                <input type='text'  id='create_postcode' placeholder='Postcode' autocomplete="off" class='shadow form-control' required>
                            </div>
                            <div class='form-group mt-1'>
                                <input type='text'  id='create_woonplaats' placeholder='Woonplaats' autocomplete="off" class='shadow form-control' required>
                            </div>
                            <div class='form-group mt-4'>
                                <button type='button' data-action="create_button" class='form-control btn btn-danger rounded submit px-3'>Account aanmaken</button>
                            </div>
                        </form>
                        <div class="form-group text-center mt-3">
                            <div class="row gy-1">
                                <button class="col-12" onclick="window.location.href = 'login.php'">Terug</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php require_once "assets/footer.php"; ?>