<?php 

    class AnimeComment_model {
        private $table = "anime_comments",
                $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function add($animeId,$userId,$text) {
            $query = "INSERT INTO $this->table(anime_id,user_id,text) VALUE(:anime_id,:user_id,:text)";
            $this->db->query($query);
            $this->db->bind(':anime_id',$animeId);
            $this->db->bind(':user_id',$userId);
            $this->db->bind(':text',$text);
            $this->db->execute();
            $newId = $this->db->lastId();
            $newComment = $this->getById($newId);
            $User = new User_model;
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

        public function getByAnimeId($animeId,$limit = 5) {
            $query = "SELECT * FROM $this->table WHERE anime_id =:anime_id ORDER BY created_at DESC LIMIT :limit ";
            $this->db->query($query);
            $this->db->bind(':anime_id',$animeId);
            $this->db->bind(':limit',$limit);
            $allComment =$this->db->resultSet();
            $totalData = $this->totalCount($animeId);
            // Call User method to get username
            $User = new User_model;
            $allComment = $User->addUsernames($allComment);
            return [
                'allComment' => $allComment,
                'totalData' => $totalData,
            ];
        }


        public function getByUserId($userId) {
            $query = "SELECT * FROM $this->table WHERE user_id = :user_id";
            $this->db->query($query);
            $this->db->bind(':user_id',$userId);
            $this->db->execute();
            return $this->db->rowCount();
        }

        public function totalCount($animeId) {
            $query = "SELECT COUNT(ID) FROM $this->table WHERE anime_id =:anime_id";
            $this->db->query($query);
            $this->db->bind(':anime_id',$animeId);
            $result = $this->db->single();
            $totalData = (int)$result['COUNT(ID)'];
            return $totalData;
        }


    }


?>