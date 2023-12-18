<?php
session_start();

class PersonRepository{

    private $people = [];
    private $currentId = 1;
    private $dbconn;

    private $attributes = [
        'firstname' => '|required|',
        'lastname'  => '|required|',
        'email'     => '|required|',
        'password'  => '|required|'
    ];

    private $attributes_labels = [
        'firstname' => 'Prénom',
        'lastname'  => 'Nom',
        'email'     => 'Email',
        'password'  => 'Mot de passe'
    ];

    public function __construct(){
        $this->connectToDatabase();
    }

    private function connectToDatabase()
    {
        $host = 'localhost';
        $port = 5432;
        $dbname = 'classe';
        $user = 'postgres';
        $password = 'Pa$$w0rd';
    
        $connectionString = "host='$host' port='$port' dbname='$dbname' user='$user' password='$password'";

        $dbconn = pg_connect($connectionString);

        $this->dbconn = $dbconn;

    }
    
    
    private function makeRequest($request)
    {
        $response = pg_query($this->dbconn, $request);

        return $response;
    }    
    
    private function requestWhere($whereRequest)
    {
        $response = $this->makeRequest("SELECT * FROM compte WHERE $whereRequest");

        return $response;
    }
    
    public function validateData($data) : Response
    {
        $response = new Response(true, 'Les données sont valides');
        
        foreach($this->attributes as $attribute => $rule){
            if (str_contains($rule, 'required')) {
                if(!isset($data[$attribute])){ // Check si la donnée est remplie
                    $response->setSuccess(false);
                    $response->setMessage( "1. L'attribute " . $this->attributes_labels[$attribute] . ' est obligatoire');
                    break;
                }
                if(isset($data[$attribute]) && trim($data[$attribute]) === ''){ // Check si elle est différente d'un string vide
                    $response->setSuccess(false);
                    $response->setMessage( "2. L'attribute " . $this->attributes_labels[$attribute] . ' est obligatoire');
                    break;
                }
            }
            if (str_contains($rule, 'taille:')) {
                $partie_apres_mot_cle = strstr($rule, 'taille:');
                $partie_apres_mot_cle = substr($partie_apres_mot_cle, strlen($mot_cle));
                
                $partie_avant_mot_cle = strstr($partie_apres_mot_cle, '|', true);
                if (strlen($data[$attribute]) > $partie_avant_mot_cle) {
                    $response->setSuccess(false);
                    $response->setMessage( "3. L'attribute ". $this->attributes_labels[$attribute].' doit faire max. '. $partie_avant_mot_cle.' caractères');
                    break;
                }
            }
        }
        
        return $response;
    }
    
    public function saveData($personData) : Response
    {
        var_dump($personData);
        $firstname = $personData['firstname'];
        $name = $personData['lastname'];
        $email = $personData['email'];
        $password = $personData['password'];
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $this->makeRequest("INSERT INTO compte (localite_id, prenom, nom, email, password) VALUES (1, '$firstname', '$name', '$email', '$password_hash')");
        return new Response(true, 'Les données ont été enregistrées');
    }
    
    public function getPeople()
    {
        $this->loadData();
        return $this->people;
    }

    public function getPersonById($id)
    {
        $result = $this->makeRequest("SELECT * FROM compte WHERE id = $id");
        $person = pg_fetch_assoc($result);
        return $person;
    }
    
    public function deletePerson($id)
    {
        $this->makeRequest("DELETE FROM compte WHERE id = $id");
        $this->loadData();
        return new Response(true, 'La personne a été supprimée');
    }
    
    public function editPerson($personData)
    {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $this->makeRequest("UPDATE compte SET prenom = '{$personData['firstname']}', nom = '{$personData['lastname']}', email = '{$personData['email']}', password = '{$password_hash}' WHERE id = {$personData['id']};");
        $this->loadData();
        return new Response(true, 'La personne a été modifiée');
    }
    
    public function loadData()
    {
        $result = $this->makeRequest("SELECT * FROM compte");
        while($row = pg_fetch_assoc($result))
        {
            $this->people[] = $row;
        }
    }
}