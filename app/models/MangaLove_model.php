<?php

    class MangaLove_model {
        private $table = 'manga_loves',
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
    

        public function add($userId,$mangaId) {
            $query = "INSERT INTO $this->table(user_id,manga_id) VALUE (:user_id,:manga_id)";
            $this->db->query($query);
            $this->db->bind(':user_id',$userId);
            $this->db->bind(':manga_id',$mangaId);
            $this->db->single();
            return $this->db->rowCount();
        }


        public function remove($userId,$mangaId) {
            $query = "DELETE FROM $this->table WHERE user_id = :user_id  AND manga_id = :manga_id";
            $this->db->query($query);
            $this->db->bind(':user_id',$userId);
            $this->db->bind(':manga_id',$mangaId);
            $this->db->single();
            return $this->db->rowCount();
        }

        public function isLoved($userId,$mangaId) {
            $query = "SELECT * FROM $this->table WHERE user_id = :user_id AND manga_id = :manga_id";
            $this->db->query($query);
            $this->db->bind(':user_id',$userId);
            $this->db->bind(':manga_id',$mangaId);
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