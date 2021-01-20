<?php

    class AnimeLove_model {
        private $table = 'anime_loves',
                $db;


        public function __construct() {
            $this->db = new Database;
        }

        public function count($userId) {
            $query = "SELECT * FROM $this->table WHERE user_id = :user_id";
            $this->db->query($query);
            $this->db->bind(':user_id',$userId);
            $this->db->execute();
            return $this->db->rowCount();
        }

        public function add($userId,$animeId) {
            $query = "INSERT INTO $this->table(anime_id,user_id) VALUE(:anime_id,:user_id)";
            $this->db->query($query);
            $this->db->bind(':user_id',$userId);
            $this->db->bind(':anime_id',$animeId);
            $this->db->single();
            return $this->db->rowCount();
        }

        public function remove($userId,$animeId) {
            $query = "DELETE FROM $this->table WHERE user_id = :user_id AND anime_id = :anime_id";
            $this->db->query($query);
            $this->db->bind(':user_id',$userId);
            $this->db->bind(':anime_id',$animeId);
            $this->db->single();
            return $this->db->rowCount();
        }

        public function isLoved($userId,$animeId) {
            $query = "SELECT * FROM $this->table WHERE user_id = :user_id AND anime_id = :anime_id";
            $this->db->query($query);
            $this->db->bind(':user_id',$userId);
            $this->db->bind(':anime_id',$animeId);
            $this->db->single();
            return $this->db->rowCount();
        }

        public function getByUserId($userId) {
            $query = "SELECT * FROM $this->table WHERE user_id = :user_id";
            $this->db->query($query);
            $this->db->bind(':user_id',$userId);
            return $this->db->resultSet();
        }
    }

?>