<?php
// Verbinding maken met de database
require 'config.php'; // Inclusief databaseconfiguratie

// Ontvangen van gegevens van het formulier
$email = $_POST['personalinfo_email'];
$firstname = $_POST['personalinfo_firstname'];
$lastname = $_POST['personalinfo_lastname'];
$birthdate = $_POST['personalinfo_birthdate'];
$phone = $_POST['personalinfo_phone'];
$address = $_POST['personalinfo_address'];
$postcode = $_POST['personalinfo_postcode'];
$iduser = $_POST['iduser'];




// Set up MySQLi connection
$conn = new mysqli(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query om gegevens in de database bij te werken
$sql = "UPDATE user SET email=?, firstname=?, lastname=?, birthdate=?, phone=?, address=?, zipcode=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssi", $email, $firstname, $lastname, $birthdate, $phone, $address, $postcode, $iduser);

if ($stmt->execute()) {
    echo "Gegevens succesvol bijgewerkt";
    // Redirect to index.php
    header('Location: index.php');
    exit(); // Ensure that subsequent code is not executed after redirection
} else {
    echo "Fout bij het bijwerken van gegevens: " . $conn->error;
}

// Verbinding met de database sluiten
$stmt->close();
$conn->close();

?>
