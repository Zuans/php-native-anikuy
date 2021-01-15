<?php

    class MangaComment_model {
        private $table = "manga_comments",
                $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function add($mangaId,$userId,$text) {
            $query = "INSERT INTO $this->table(manga_id,user_id,text) VALUE(:manga_id,:user_id,:text) ";
            $this->db->query($query);
            $this->db->bind(':manga_id',$mangaId);
            $this->db->bind(':user_id',$userId);
            $this->db->bind(':text',$text);
            $this->db->single(); 
            $newId = $this->db->lastId();
            $newComment = $this->getById($newId);
            $User =  new User_model;
            $newComment = $User->addUsername($newComment);
            return $newComment;
        }
        
        public function getById($commentId) {
            $query = "SELECT * FROM $this->table WHERE ID =:id";
            $this->db->query($query);
            $this->db->bind(':id',$commentId);
            $result = $this->db->single();
            return $result;
        }

        public function getByMangaId($mangaId,$limit = 5) {
            $query = "SELECT * FROM $this->table WHERE manga_id = :manga_id ORDER BY created_at DESC  LIMIT :limit" ;
            $this->db->query($query);
            $this->db->bind(':manga_id',$mangaId);
            $this->db->bind(':limit',$limit);
            $allComment = $this->db->resultSet();
            $totalData = $this->totalCount($mangaId);
            $User = new User_model;
            // Get username from user_model
            $allComment = $User->addUsernames($allComment);
            return [
                'allComment' => $allComment,
                'totalData' => $totalData,
            ];
        }

        public function getByUserId($userId) {
            $query = "SELECT * FROM  $this->table WHERE user_id = :user_id";
            $this->db->query($query);
            $this->db->bind(':user_id',$userId);
            $this->db->execute();
            return $this->db->rowCount();
        }

        public function totalCount($mangaId) {
            $query = "SELECT COUNT(ID) FROM $this->table WHERE manga_id = :manga_id";
            $this->db->query($query);
            $this->db->bind(':manga_id',$mangaId);
            $result = $this->db->single();
            $totalData = (int)$result['COUNT(ID)'];
            return $totalData;
        }
    }


?>