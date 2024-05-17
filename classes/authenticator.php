<?php

namespace classes;

use PDO;
use PDOException;

class authenticator
{
    private $usertable = "user";

    private PDO $conn;

    private function databaseConnection(): void{
        require_once "config.php";

        try {
            $this->conn = new PDO('mysql:host=' . DB_LOCALHOST . ';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "404!";
            exit;
        }
    }

    private function validate( $data ){
        $data = preg_replace('/\s+/', '', $data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    private function credentialsAccount( $userid, $userrole ){
        if (!isset($_SESSION)) {
            session_start();
        }

        $_SESSION['user_key'] = bin2hex(random_bytes(16));
        $_SESSION['user_id'] = $userid;
        $_SESSION['user_role'] = $userrole;

    }

    /**
     * Verifieert de inloggegevens van een gebruiker.
     *
     * @param string $email Het e-mailadres van de gebruiker.
     * @param string $password Het wachtwoord van de gebruiker.
     * @return void
     */
    public function verifyAccount($email, $password) {
        // Controleer of zowel e-mailadres als wachtwoord zijn ingevuld
        if(empty($email) || empty($password)) {
            // Geef een foutmelding terug als e-mailadres of wachtwoord ontbreekt
            echo json_encode(['message' => 'E-mail en wachtwoord zijn verplicht']);
            return;
        }

        // Maak verbinding met de database
        $this->databaseConnection();

        // Zoek naar de gebruiker in de database op basis van het e-mailadres
        $stmt = $this->conn->prepare("SELECT id, role, password, salt FROM ". $this->usertable ." WHERE email = ?");
        $stmt->execute([$this->validate($email)]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt->rowCount() == 1) {
            // Als de gebruiker wordt gevonden, controleer dan het wachtwoord
            if(password_verify($user['salt'].$this->validate($password), $user['password'])){
                // Als het wachtwoord overeenkomt, log de gebruiker in en geef een succesbericht terug
                $this->credentialsAccount($user['id'], $user['role']);

                $expiretime = time() + (1 * 60 * 60);
                setcookie('userRoleForCookie', $user['role'] , $expiretime);

                header('Content-Type: application/json');
                echo json_encode(['message' => 'Ingelogd', 'success' => true]);
                exit;
            }
            else{
                // Als het wachtwoord niet overeenkomt, geef een foutmelding terug
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Verkeerd wachtwoord', 'success' => false]);
                exit;
            }
        }
        else{
            // Als het e-mailadres niet wordt gevonden, geef een foutmelding terug
            header('Content-Type: application/json');
            echo json_encode(['message' => 'E-mailadres bestaat niet', 'success' => false]);
            exit;
        }
    }

    /**
     * Maakt een nieuw gebruikersaccount aan met de opgegeven gegevens.
     *
     * @param string $email Het e-mailadres van de nieuwe gebruiker.
     * @param string $password Het wachtwoord van de nieuwe gebruiker.
     * @param string $firstname De voornaam van de nieuwe gebruiker.
     * @param string $lastname De achternaam van de nieuwe gebruiker.
     * @param string $gender Het geslacht van de nieuwe gebruiker.
     * @param string $address Het adres van de nieuwe gebruiker.
     * @param string $zipcode De postcode van de nieuwe gebruiker.
     * @param string $number Het huisnummer van de nieuwe gebruiker.
     * @param string $birthdate De geboortedatum van de nieuwe gebruiker.
     * @param string $phone Het telefoonnummer van de nieuwe gebruiker.
     * @return void
     */
    public function createAccount(
        $email, $password, $firstname, $lastname, $gender, $address, $zipcode, $number, $birthdate, $phone
    ) {
        // Controleer of de verplichte velden zijn ingevuld
        if(empty($email) || empty($password) || empty($firstname) || empty($lastname) || empty($address) || empty($zipcode) || empty($number) || empty($birthdate) || empty($phone)) {
            // Geef een foutmelding terug als niet alle verplichte velden zijn ingevuld
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Velden mogen niet leeg zijn', 'success' => false]);
            return;
        }

        // Maak verbinding met de database
        $this->databaseConnection();

        // Controleer of het opgegeven e-mailadres al bestaat
        $stmt = $this->conn->prepare("SELECT * FROM ". $this->usertable ." WHERE email = ?");
        $stmt->execute([$this->validate($email)]);

        if($stmt->rowCount() == 0) {
            // Als het e-mailadres nog niet bestaat, voeg dan een nieuw account toe aan de database

            // Bepaal het geslacht van de gebruiker (0 voor vrouw, 1 voor man)
            $gender = ($gender == "Man") ? 1 : 0;

            // Genereer een zout voor het wachtwoord en hash het wachtwoord
            $salt = bin2hex(random_bytes(16));
            $newpassword = password_hash($salt.$this->validate($password), PASSWORD_BCRYPT);

            // Combineer adres en huisnummer
            $adres = $this->validate($address).' '.$this->validate($number);

            // Voeg het nieuwe account toe aan de database
            $stmt = $this->conn->prepare('INSERT INTO '. $this->usertable .' ( email, password, salt, role, firstname, lastname, gender, address, zipcode, birthdate, phone, lesson_credit ) VALUES ( :email, :password, :salt, :role, :firstname, :lastname, :gender, :address, :zipcode, :birthdate, :phone, :lesson_credit)');
            $stmt->execute(array(
                ':email' => $this->validate($email),
                ':password' => $newpassword,
                ':salt' => $salt,
                ':role' => 0, // 0 voor standaard gebruiker
                ':firstname' => $this->validate($firstname),
                ':lastname' => $this->validate($lastname),
                ':gender' => $gender,
                ':address' => $adres,
                ':zipcode' => $this->validate($zipcode),
                ':birthdate' => $this->validate($birthdate),
                ':phone' => $this->validate($phone),
                ':lesson_credit' => 0, // Begin met nul leskrediet
            ));

            // Haal de ID van het nieuwe gebruikersaccount op
            $user_id = $this->conn->lastInsertId();

            // Maak standaardrechten voor het account
            $this->credentialsAccount($user_id, 0);

            $expiretime = time() + (1 * 60 * 60);
            setcookie('userRoleForCookie', 0 , $expiretime);

            // Geef een succesbericht terug in JSON-indeling
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Account succesvol aangemaakt', 'success' => true]);
            return;
        } else {
            // Als het e-mailadres al bestaat, geef dan een foutmelding terug
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Account bestaat al', 'success' => false]);
            return;
        }
    }


    /**
     * Verwijdert een afspraak uit de database op basis van de opgegeven afspraak-ID.
     *
     * @param int $id De ID van de afspraak die moet worden verwijderd.
     * @return void
     */
    public function removeAppointment($id){
        // Maak verbinding met de database
        $this->databaseConnection();

        // Bereid de SQL-query voor om de afspraak te verwijderen
        $stmt = $this->conn->prepare("DELETE FROM appointments WHERE id = ?");

        // Voer de query uit met de opgegeven afspraak-ID
        $stmt->execute([$id]);

        // Geef een succesbericht terug in JSON-indeling
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Afspraak succesvol verwijderd', 'success' => true]);
        return;
    }

    /**
     * Verzamelt afspraken op basis van de rol van de gebruiker.
     *
     * @param int $id De ID van de gebruiker voor wie afspraken moeten worden verzameld.
     * @param int|null $role De rol van de gebruiker (optioneel). Standaard ingesteld op null.
     * @return array Een array van afspraken voor de gebruiker.
     */
    public function collectAppointments($id, $role = null){
        // Maak verbinding met de database
        $this->databaseConnection();

        // Controleer de rol van de gebruiker en stel de query dienovereenkomstig in
        if($role == 1) {
            // Als de gebruiker een instructeur is, selecteer afspraken waarvoor hij/zij instructeur is en die nog moeten plaatsvinden
            $stmt = $this->conn->prepare(
                'SELECT a.*, c.*, u.firstname, u.lastname, u.address, u.zipcode, u.lesson_credit 
            FROM appointments as a 
            LEFT JOIN user as u ON u.id = a.apprentice 
            LEFT JOIN cars as c ON c.car_id = a.car 
            WHERE instructor = :id
            ORDER BY appointment_date ASC'
            );

            // Roep de functie aan om afspraken te controleren die binnen 15 minuten moeten plaatsvinden
            $this->instructorChecker();
        }
        else {
            // Als de gebruiker geen instructeur is, selecteer afspraken waarvoor hij/zij leerling is
            // Berkay
            $stmt = $this->conn->prepare(
                'SELECT a.*, c.*, u.firstname, u.lastname, u.address, u.zipcode, u.lesson_credit  FROM appointments as a LEFT JOIN user as u ON u.id = a.instructor LEFT JOIN cars as c ON c.car_id = a.car WHERE apprentice = :id ORDER BY lesson ASC'
            );


        }

        // Voer de query uit met de gegeven gebruikers-ID
        $stmt->execute(array(
            ':id' => $id,
        ));



        // Haal de resultaten op en retourneer ze als een array van associatieve arrays
        $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);


        return $appointments;
    }

    /**
     * Zoekt naar gebruikersaccounts in de database op basis van de opgegeven zoekwaarde.
     *
     * @param string $value De zoekwaarde om te zoeken naar voornaam of achternaam van gebruikers.
     * @return void
     */
    public function searchAccount($value) {
        // Maak verbinding met de database
        $this->databaseConnection();

        // Bereid de SQL-query voor om gebruikers te zoeken op voornaam of achternaam
        $stmt = $this->conn->prepare(
            'SELECT * FROM user WHERE (role = 0) AND (firstname LIKE :value OR lastname LIKE :value)'
        );

        // Voer de query uit met de ingevoerde zoekwaarde
        $stmt->execute(array(
            ':value' => '%' . $this->validate($value) . '%',
        ));

        // Haal de resultaten op
        $user = $stmt->fetchAll();

        // Controleer of er resultaten zijn gevonden
        if(empty($user)){
            // Geef een foutmelding terug als er geen resultaten zijn gevonden
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Geen resultaten gevonden', 'success' => false]);
            return;
        }

        // Geef de gevonden gebruikersinformatie terug als JSON-respons
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Zoeken gelukt', 'success' => true, 'data' => $user]);
        return;
    }


    /**
     * Controleert en verwerkt afspraken die binnen 15 minuten moeten plaatsvinden.
     * Vermindert het leskrediet van de leerling en markeert de afspraak als voltooid.
     *
     * @return void
     */
    private function instructorChecker() {
        // Bepaal de tijd 15 minuten vanaf nu
        $time = new \DateTime('+15 minutes');
        $time = $time->format('Y-m-d H:i:s');

        // Selecteer afspraken die binnen 15 minuten of eerder gepland staan en nog niet zijn voltooid
        $stmt = $this->conn->prepare(
            'SELECT * FROM appointments WHERE status = 0 AND appointment_date <= :appointment'
        );
        $stmt->execute([
            ':appointment' => $time
        ]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Loop door elke afspraak die binnen 15 minuten of eerder gepland staat
        foreach ($data as $appointment) {
            // Haal de gegevens van de leerling op
            $stmt = $this->conn->prepare(
                'SELECT * FROM user WHERE id = :apprentice'
            );
            $stmt->execute([
                ':apprentice' => $appointment['apprentice']
            ]);
            $apprentice = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verminder het leskrediet van de leerling met 1
            $updateStmt = $this->conn->prepare(
                'UPDATE user SET lesson_credit = lesson_credit - 1 WHERE id = :apprentice'
            );
            $updateStmt->execute([
                ':apprentice' => $appointment['apprentice']
            ]);

            // Markeer de afspraak als voltooid (status 99)
            $updateStmt = $this->conn->prepare(
                'UPDATE appointments SET status = 99 WHERE id = :id'
            );
            $updateStmt->execute([
                ':id' => $appointment['id']
            ]);
        }
    }


    /**
     * Bijwerken van het leskrediet van een gebruiker.
     *
     * @param int $id De ID van de gebruiker wiens leskrediet moet worden bijgewerkt.
     * @param int $credit Het nieuwe leskrediet dat aan de gebruiker moet worden toegewezen.
     * @return void
     */
    public function lessonCredit($id, $credit){
        // Maak verbinding met de database
        $this->databaseConnection();

        // Bereid de SQL-query voor om het leskrediet van de gebruiker bij te werken
        $stmt = $this->conn->prepare(
            'UPDATE user SET lesson_credit = :credit WHERE id = :id'
        );

        // Voer de query uit met de gevalideerde gebruikers-ID en leskrediet
        $stmt->execute(array(
            ':id' => $this->validate($id),
            ':credit' => $this->validate($credit),
        ));

        // Geef een succesbericht terug in JSON-indeling
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Leskrediet succesvol bijgewerkt', 'success' => true]);
        return;
    }

    /**
     * Instellingen voor het bijwerken van tekstcommentaar voor een afspraak.
     *
     * @param int $id De ID van de afspraak waarvoor het tekstcommentaar moet worden bijgewerkt.
     * @param string $text Het nieuwe tekstcommentaar dat aan de afspraak moet worden toegewezen.
     * @return void
     */
    public function textAreasettings($id, $text){
        // Maak verbinding met de database
        $this->databaseConnection();

        // Bereid de SQL-query voor om het tekstcommentaar van de afspraak bij te werken
        $stmt = $this->conn->prepare(
            'UPDATE appointments SET commentary = :text WHERE id = :id'
        );

        // Voer de query uit met de gevalideerde afspraak-ID en tekstcommentaar
        $stmt->execute(array(
            ':id' => $this->validate($id),
            ':text' => $this->validate($text),
        ));

        // Geef een succesbericht terug in JSON-indeling
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Tekstcommentaar succesvol bijgewerkt', 'success' => true]);
        return;
    }


    public function meldjeZiek( $id ){
        $this->databaseConnection();

        $time = new \DateTime();
        $date = $time->format('Y-m-d ');

        $stmt = $this->conn->prepare(
            'SELECT * FROM appointments 
             WHERE instructor = :id 
             AND status = 0 
             AND appointment_date LIKE :date'
        );
        $stmt->execute([
            ':date' => $date."%",
            ':id' => $id
        ]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $appointment) {
            // Markeer de afspraak als voltooid (status 99)
            $updateStmt = $this->conn->prepare(
                'UPDATE appointments SET status = 1 WHERE id = :id'
            );
            $updateStmt->execute([
                ':id' => $appointment['id']
            ]);

            $updateStmt = $this->conn->prepare(
                'UPDATE tijdblokken SET status = 1 WHERE tijdblok_id = :id'
            );
            $updateStmt->execute([
                ':id' => $appointment['tijdblok']
            ]);
        }

        // Geef een succesbericht terug in JSON-indeling
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Je hebt je zelf ziekgemeld', 'success' => true]);
        return;
    }


    public function collectAdminusers(){
        // Maak verbinding met de database
        $this->databaseConnection();

        // Bereid de SQL-query voor om het leskrediet van de gebruiker bij te werken
        $stmt = $this->conn->prepare(
            'SELECT id, firstname, lastname FROM user WHERE role = 1'
        );
        $stmt->execute([]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Geef een succesbericht terug in JSON-indeling
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Je hebt je zelf ziekgemeld', 'success' => true, 'data' => $data]);
        return;
    }

    public function collectAdminusersleerling(){
        // Maak verbinding met de database
        $this->databaseConnection();

        // Bereid de SQL-query voor om het leskrediet van de gebruiker bij te werken
        $stmt = $this->conn->prepare(
            'SELECT id, firstname, lastname FROM user WHERE role = 0'
        );
        $stmt->execute([]);
        $data2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Bereid de SQL-query voor om het leskrediet van de gebruiker bij te werken
        $stmt = $this->conn->prepare(
            'SELECT id, firstname, lastname FROM user WHERE role = 1'
        );
        $stmt->execute([]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Geef een succesbericht terug in JSON-indeling
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Je hebt je zelf ziekgemeld', 'success' => true, 'instructor' => $data, 'leerling' => $data2]);
        return;
    }

    public function collectDates( $id ){
        // Maak verbinding met de database
        $this->databaseConnection();

        // Bereid de SQL-query voor om het leskrediet van de gebruiker bij te werken
        $stmt = $this->conn->prepare(
            'SELECT start FROM tijdblokken WHERE instructeur = :id AND status = 0'
        );
        $stmt->execute([
            ':id' => $id,
        ]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = array_map(function($item) {
            $item['start'] = date('Y-m-d', strtotime($item['start']));
            return $item;
        }, $data);

        // Geef een succesbericht terug in JSON-indeling
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Je hebt je zelf ziekgemeld', 'success' => true, 'data' => $result]);
        return;
    }

    public function collectTimes( $date, $user ){
        // Maak verbinding met de database
        $this->databaseConnection();

        $stmt = $this->conn->prepare('SELECT appointment_date FROM appointments WHERE instructor = :id and appointment_date like :date');
        $stmt->execute([
            ':id' => $user,
            ':date' => $date."%"
            ]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $bookedTimes = array_map(function($item) {
            $item['appointment_date'] = date('H:i', strtotime($item['appointment_date']));
            return $item['appointment_date'];
        }, $data);

        $stmt = $this->conn->prepare(
            'SELECT start, end, car FROM tijdblokken WHERE instructeur = :id and start like :date and status = 0 LIMIT 1'
        );
        $stmt->execute([
            ':id' => $user,
            ':date' => $date."%"
        ]);
        $data2 = $stmt->fetch(PDO::FETCH_ASSOC);

        $availableTimes = array();
        $start_time = strtotime($data2['start']);
        $end_time = strtotime($data2['end']);
        $step = 60 * 60;
;

        for ($i = $start_time; $i <= $end_time; $i += $step) {
            $availableTimes[] = date('H:i', $i);
        }



        // Get the available times by removing the booked times from the available times
        $filteredTimes = array_diff($availableTimes, $bookedTimes);






//         Geef een succesbericht terug in JSON-indeling
        header('Content-Type: application/json');
        echo json_encode(['data' => $filteredTimes]);
        return;
    }

    public function createAfspraak( $date, $instructor, $einddatum, $student_id){
        // Maak verbinding met de database
        $this->databaseConnection();

        $stmt = $this->conn->prepare('SELECT lesson_credit FROM user WHERE id = :student');
        $stmt->execute([
            ':student' => $student_id,
        ]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if($data['lesson_credit'] == 0){
            header('Content-Type: application/json');
            echo json_encode(['message' => 'U heeft geen credits', 'success' => false]);
            return;
        }


        $stmt = $this->conn->prepare('SELECT appointment_date FROM appointments WHERE apprentice = :id AND appointment_date = :date');
        $stmt->execute([
            ':id' => $student_id,
            ':date' => $einddatum
        ]);
        $datatest = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($datatest) != 0) {
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Je hebt al een afspraak op dit datum en tijdstip', 'success' => false]);
            return;
        }



        $stmt = $this->conn->prepare('SELECT lesson FROM appointments WHERE apprentice = :id  ORDER BY lesson DESC LIMIT 1');
        $stmt->execute([
            ':id' => $student_id,
        ]);
        $dataless = $stmt->fetch(PDO::FETCH_ASSOC);


        if($dataless){
            $lessononeup = $dataless['lesson'] + 1;
        }
        else{
            $lessononeup = 1;
        }



        $stmt = $this->conn->prepare(
            'SELECT tijdblok_id, car FROM tijdblokken WHERE instructeur = :id AND status = 0 and start like :date LIMIT 1'
        );
        $stmt->execute([
            ':id' => $instructor,
            ':date' => $date."%"
        ]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $car = $data['car'];
        $tijdblok = $data['tijdblok_id'];

        $stmt = $this->conn->prepare(
            'INSERT INTO appointments (instructor, apprentice, car, commentary, lesson, appointment_date, status, tijdblok) 
        VALUES (:instructor, :student_id, :car, null, :lesson, :date, 0, :tijdblok); '
        );
        $stmt->execute([
            ':instructor' => $instructor,
            ':student_id' => $student_id,
            ':car' => $car,
            ':lesson' => $lessononeup,
            ':date' => $einddatum,
            ':tijdblok' => $tijdblok,
        ]);

        // Geef een succesbericht terug in JSON-indeling
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Message', 'success' => true]);
        return;
    }


}


