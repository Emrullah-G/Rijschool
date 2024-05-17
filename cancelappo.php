<?php

// Verbinding maken met de database
require 'config.php'; // Inclusief databaseconfiguratie

// Controleren of de ID van de afspraak is verzonden via POST
if(isset($_POST['idappo'])) {
    $id = $_POST['idappo'];
    $status = 2; // De status instellen op 2 (geannuleerd)

    // Set up MySQLi connection
    $conn = new mysqli(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query om gegevens in de database bij te werken
    $sql = "UPDATE appointments SET status=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $status, $id); // ii staat voor integer (int) parameters

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
} else {
    echo "Geen ID voor afspraak ontvangen via POST.";
}
?>
