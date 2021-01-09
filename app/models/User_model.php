<?php


class User_model {

    private $table = 'users',
            $db;


    public function __construct() {
        $this->db = new Database;
    }


    public function validate($userId,$oldPass) {
        $query = "SELECT * FROM $this->table WHERE ID = :id ";
        $this->db->query($query);
        $this->db->bind(':id',$userId);
        $user = $this->db->single();
        // Chekcing user
        if(!$user){
            return [
                'error' => 'User not found',
            ];
        }
        // Check password
        $valdtPassword = password_verify($oldPass,$user['password']);
        if(!$valdtPassword) {
            return [
                'error' => 'Incorrect Password please try again',
            ];
        }
        return $user;
    }

    public function update($userId,$data) {
        $query = "UPDATE $this->table SET username = :username, email = :email  WHERE ID = :user_id ";
        $this->db->query($query);
        $this->db->bind(':user_id',$userId);
        $this->db->bind(':username',$data['username']);
        $this->db->bind(':email',$data['email']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updatePass($userId,$data) {
       $hashPassword = password_hash($data['new-password'],PASSWORD_DEFAULT);
       $query = "UPDATE $this->table SET username = :username, email = :email, password = :password  WHERE ID = :user_id ";
       $this->db->query($query);
       $this->db->bind(':user_id',$userId);
       $this->db->bind(':username',$data['username']);
       $this->db->bind(':email',$data['email']);
       $this->db->bind(':password',$hashPassword);
       $this->db->execute();
       return $this->db->rowCount();
    }

    public function loveCount($userId) {
        $AnimeLove = new AnimeLove_model;
        $animeCount = $AnimeLove->count($userId);
        $MangaLove = new MangaLove_model;
        $mangaCount = $MangaLove->count($userId);
        $total = $animeCount + $mangaCount;
        return $total;
    }


    public function addUser($data) {
        // Hashing password first
        $passwordHash = password_hash($data['password'],PASSWORD_DEFAULT);
        $query =  "INSERT INTO users(username,email,password) VALUES (:username,:email,:password)";
        $this->db->query($query);
        $this->db->bind(':username',$data['username']);
        $this->db->bind(':email',$data['email']);
        $this->db->bind(':password',$passwordHash);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getUserById($userId) {
        $query = "SELECT * FROM $this->table WHERE ID = :id";
        $this->db->query($query);
        $this->db->bind(':id',$userId);
        return $this->db->single();
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
    }
}



?>