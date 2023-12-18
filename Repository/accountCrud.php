<?php
session_start();

class accountCRUD 
{
    private $dbconn;

    public function __construct()
    {
    $this->connectToDatabase('127.0.0.1', 'root', 'Pa$$w0rd', 'dnd_library',3306);
    }

    private function connectToDatabase($host, $user, $password, $dbname, $port)
    {        
        $conn = new mysqli($host, $user, $password, $dbname, $port);

        $this->dbconn = $conn;
    }

    private function makeRequest($request)
    {
        $response = $this->dbconn->query($request);

        // if ($response)
        // {
        //     echo 'ok';
        // } else {
        //     echo 'not ok';
        // }

        return $response;
    }

    public function saveData($accountData)
    {
        $firstname = $accountData['firstname'];
        $name = $accountData['lastname'];
        $email = $accountData['email'];
        $password = $accountData['password'];
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $is_admin = $accountData['is_admin'];

        $this->makeRequest("INSERT INTO account (prenom, nom, mail, password, is_admin) VALUES ('$firstname', '$name', '$email', '$password_hash', $is_admin)");
    }

    public function getData()
    {
        $result = $this->makeRequest("SELECT * FROM account");
        $rows = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($rows, $row);
            }
        }
        return $rows;
    }

    public function getMail()
    {
        $rows = $this->getData();

        $mails = array();

        foreach ($rows as $row)
        {
            array_push($mails, $row['mail']);
        }
        return $mails;
    }

    public function login($email, $password)
    {
        $stmt = $this->dbconn->prepare("SELECT password FROM account WHERE mail = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                return true;
            }
        }
        return false;
    }


    public function getName($email)
    {
        // Préparation de la requête pour éviter les injections SQL
        $stmt = $this->dbconn->prepare("SELECT prenom FROM account WHERE mail = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row['prenom'];
        } else {
            return null;
        }
    }
}
?>