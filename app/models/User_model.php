<?php


class User_model {

    private $table = 'users',
            $db;


    public function __construct() {
        $this->db = new Database;
    }


    public function addUser($data) {
        $query =  "INSERT INTO users(username,email,password) VALUES (:username,:email,:password)";
        // Hashing password first
        $passwordHash = password_hash($data['password'],PASSWORD_DEFAULT);
        $this->db->query($query);
        $this->db->bind(':username',$data['username']);
        $this->db->bind(':email',$data['email']);
        $this->db->bind(':password',$passwordHash);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getUserByEmail($email = "") {
        $query  = "SELECT * FROM $this->table WHERE email = :email";
        $this->db->query($query);
        $this->db->bind(':email',$email);
        return $this->db->single();
    }

    public function getAllUser() {
        $this->db->query("SELECT * FROM $this->table");
        $result = $this->db->resultSet();
        var_dump($result);
    }
}



?>