<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rijschool</title>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="/rijschool/assets/javascript.js"></script>
    <link rel="stylesheet" href="/rijschool/assets/style.css">

    <script src="https://kit.fontawesome.com/47656a0d83.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>

<div class="container-fluid">
    <style>
        .menu-items a{
            text-decoration: none;
            color: black;
            font-weight: 400;
        }

        .menu-items a:hover{
            text-decoration: underline;
        }
    </style>


    <script>

        jQuery(document).ready(function ($) {
            $('body').on('click', 'mobile_menu_opener_change', function (e) {
                $('#mobile_menu').modal('show'); // Close the modal
                console.log('test');
            });
        });

    </script>

    <?php


    if(@empty($_SESSION['user_key'])){
        echo "<div class='bg-light border row px-3'>
        <div class='col-6 col-lg-3'><a href='index.php'><img src='assets/images/logo-drive.png' class='img-fluid' style='width: 100px;height: 100px;' alt='Logo Tandarts'></a></div>
        <div class='col-6 d-none d-lg-flex justify-content-center align-items-center'>
            <div class='menu-items d-flex flex-row gap-4'>
                <a href='index.php#container-visie'>Visie</a>
            <a href='index.php#container-teams'>Team van professionals</a>
                <a href='index.php#container-behandelingen'>Locatie & Over ons</a>
            </div>
        </div>
        <div class='col-6 col-lg-3 d-flex justify-content-end align-items-center'>
            <div class='d-flex d-lg-none'>
                <button type='button' class='mx-2' style='margin-bottom: -5px;' data-action='openmenu_mobile'>
                    <i style='font-size: 24px' class='text-danger fa-solid fa-bars'></i>
                </button>
            </div>
            <button onclick='window.location.href = `login.php`' class='btn btn-danger'>Inloggen</button>
        </div>
    </div>";
    }else{
        echo "<div class='bg-light border row px-3'>
            <div class='col-6 col-lg-3'><a href='index.php'><img src='assets/images/logo-drive.png' class='img-fluid' style='width: 100px;height: 100px;' alt='Logo Tandarts'></a></div>
            <div class='col-6 d-none d-lg-flex justify-content-center align-items-center'>
                <div class='menu-items d-flex flex-row gap-4'>";


            if($_SESSION['user_role'] >= 1){
                echo "<div class='d-none d-lg-block'>
                        <a class=' mx-4' href='lespakket.php'>Strippenkaart & Lespakket</a>";

                if($_SESSION['user_role'] >= 2) {
                    echo "<a href='wagenpark.php'>Wagen park</a>
                        <a class=' mx-2' href='tijdblokken.php'>Tijdblokken</a> 
                        <a class=' mx-2' href='bezettingsgraad.php'>Auto gebruik</a> 
                        <a class=' mx-2' href='gebruikers.php'>Gebruikers info</a>";
                }

                    echo "</div>";
            }

                echo "</div>
            </div>
            <div class='col-6 col-lg-3 d-flex justify-content-end align-items-center'>
                <div class='mx-3 d-none d-lg-block'><button type='button' data-action='settings_personal'>Profiel Aanpassen</button></div>
                <div class='d-flex d-lg-none'>
                    <button type='button' class='mx-2' style='margin-bottom: -5px;' data-action='openmenu_mobile'>
                        <i style='font-size: 24px' class='text-danger fa-solid fa-bars'></i>
                    </button>
                </div>";

                echo '<form method="GET" action="index.php">
                    <input type="hidden" name="logout" value="true">
                    <button class="btn btn-danger text-xxs font-weight-bolder opacity-7" type="submit">
                        <b>Uitloggen</b>
                    </button>
                </form>
            </div>
        </div>';

    }
    ?>
    

