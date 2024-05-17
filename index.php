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

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welkom</title>
    <style>
        .cookie-banner {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #fff;
            padding: 10px;
            box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
        }
        .cookie-settings {
            position: fixed;
            bottom: 50px;
            right: 20px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1001;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    if (isset($_SESSION['user_key'])) {
        if ($_SESSION['user_role'] == 2) {
            echo "Hallo, welkom op de admin pagina!";
        } else {
            require_once "assets/layouts/agenda.php";
        }
    } else {
        require_once "assets/layouts/home.php";
    }
    ?>
</div>

<div id="cookie-banner" class="cookie-banner">
    <p>We gebruiken cookies om uw browserervaring te verbeteren. <a href="#" id="cookie-settings-link">Instellingen aanpassen</a>.</p>
    <button id="accept-cookies">Accepteer</button>
</div>

<div id="cookie-settings" class="cookie-settings hidden">
    <h2>Cookie-instellingen</h2>
    <label>
        <input type="checkbox" id="necessary-cookies" checked disabled> Noodzakelijke cookies
    </label>
    <label>
        <input type="checkbox" id="analytics-cookies"> Analytics cookies
    </label>
    <label>
        <input type="checkbox" id="marketing-cookies"> Marketing cookies
    </label>
    <button id="save-settings">Opslaan</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const cookieBanner = document.getElementById('cookie-banner');
    const cookieSettings = document.getElementById('cookie-settings');
    const acceptCookiesButton = document.getElementById('accept-cookies');
    const settingsLink = document.getElementById('cookie-settings-link');
    const saveSettingsButton = document.getElementById('save-settings');

    // Check if cookies are already set
    if (!getCookie('cookiesAccepted')) {
        cookieBanner.style.display = 'block';
    } else {
        // Read the preferences from cookies and set the checkboxes accordingly
        document.getElementById('analytics-cookies').checked = getCookie('analyticsCookies') === 'true';
        document.getElementById('marketing-cookies').checked = getCookie('marketingCookies') === 'true';

        cookieBanner.style.display = 'none';
    }

    acceptCookiesButton.addEventListener('click', () => {
        setCookie('cookiesAccepted', true, 365);
        cookieBanner.style.display = 'none';
    });

    settingsLink.addEventListener('click', (e) => {
        e.preventDefault();
        cookieSettings.classList.toggle('hidden');
    });

    saveSettingsButton.addEventListener('click', () => {
        const analyticsCookies = document.getElementById('analytics-cookies').checked;
        const marketingCookies = document.getElementById('marketing-cookies').checked;

        setCookie('analyticsCookies', analyticsCookies, 365);
        setCookie('marketingCookies', marketingCookies, 365);
        setCookie('cookiesAccepted', true, 365);  // Ensure cookiesAccepted is also set

        cookieSettings.classList.add('hidden');
        cookieBanner.style.display = 'none';
    });

    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    function getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }
});
</script>

</body>
</html>
