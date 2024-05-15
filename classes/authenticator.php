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

    public function verifyAccount( $email, $password ) {
        if(empty($email) || empty($password)) {
            echo json_encode(['message' => 'Email en wachtwoord zijn verplicht']);
            return;
        }

        $this->databaseConnection();

        $stmt = $this->conn->prepare("SELECT id, role, password, salt FROM ". $this->usertable ." WHERE email = ?");
        $stmt->execute([$this->validate($email)]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt->rowCount() == 1) {
            if(password_verify($user['salt'].$this->validate($password), $user['password'])){
                $this->credentialsAccount( $user['id'], $user['role']);

                header('Content-Type: application/json');
                echo json_encode(['message' => 'Ingelogd', 'success' => true]);
                exit;
            }
            else{
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Verkeerde wachtwoord', 'success' => false]);
                exit;
            }
        }
        else{
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Email bestaat niet', 'success' => false]);
            exit;
        }
    }

    public function createAccount( $email, $password, $firstname, $lastname, $address, $zipcode, $residence, $birthdate, $phone) {
        if(empty($email) || empty($password) || empty($firstname) || empty($lastname) || empty($address) || empty($zipcode) || empty($residence)  || empty($birthdate) || empty($phone)) {
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Velden mogen niet leeg zijn', 'success' => false]);
            return;
        }

        $this->databaseConnection();

        $stmt = $this->conn->prepare("SELECT * FROM ". $this->usertable ." WHERE email = ?");
        $stmt->execute([$this->validate($email)]);

        if($stmt->rowCount() == 0) {


            $salt = bin2hex(random_bytes(16));
            $newpassword = password_hash($salt.$this->validate($password), PASSWORD_BCRYPT);

            $stmt = $this->conn->prepare('INSERT INTO '. $this->usertable .' ( email, password, salt, role, firstname, lastname, address, zipcode, residence, birthdate, phone ) VALUES ( :email, :password, :salt, :role, :firstname, :lastname, :address, :zipcode, :residence, :birthdate, :phone)');
            $stmt->execute(array(
                ':email' => $this->validate($email),
                ':password' => $newpassword,
                ':salt' => $salt,
                ':role' => 0,
                ':firstname' => $this->validate($firstname),
                ':lastname' => $this->validate($lastname),
                ':address' => $this->validate($address),
                ':zipcode' => $this->validate($zipcode),
                ':residence' => $this->validate($residence),
                ':birthdate' => $this->validate($birthdate),
                ':phone' => $this->validate($phone),
            ));

            $user_id = $this->conn->lastInsertId();
            $this->credentialsAccount( $user_id, 0);

            header('Content-Type: application/json');
            echo json_encode(['message' => 'Ingelogd', 'success' => true]);
            return;
        }
        else{
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Account bestaat al', 'success' => false]);
            return;
        }

    }

    public function removeAppointment( $id ){
        $this->databaseConnection();

        $stmt = $this->conn->prepare("DELETE FROM appointments WHERE id = ?");
        $stmt->execute([$id]);

        header('Content-Type: application/json');
        echo json_encode(['message' => 'Gelukt', 'success' => true]);
        return;
    }

    public function changePassworduser($id, $password){
        $this->databaseConnection();

        $salt = bin2hex(random_bytes(16));
        $newpassword = password_hash($salt.$this->validate($password), PASSWORD_BCRYPT);

        $stmt = $this->conn->prepare("UPDATE user SET password = ?, salt = ? WHERE id = ?");
        $stmt->execute([
            $this->validate($newpassword),
            $this->validate($salt),
            $this->validate($id),
        ]);

        header('Content-Type: application/json');
        echo json_encode(['message' => 'Wachtwoord aangepast', 'success' => true]);
        return;
    }
}


