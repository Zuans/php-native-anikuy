<?php 

class Profile extends Controller {

    public function info() {
        return $this->view('profile/info');
    }

    public function loveList() {
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false;
        $loveAnime = [];
        if($userId) {
            // Get Anime Love
            $AnimeLove = new AnimeLove_model;
            $animeResult = $AnimeLove->getByUserId($userId);
            $animesLove  = [];
            if(empty($animeResult)) {
                $animesLove =  null;
            } else {
                $animesLove = Anime::setAnimeLove($animeResult);
            }
            // Get Manga Love
            $MangaLove = new MangaLove_model;
            $mangaResult = $MangaLove->getByUserId($userId);
            $mangasLove = [];
            if(empty($mangaResult)) {
                $mangasLove =  null;
            } else {
                $mangasLove = Manga::setMangaLove($mangaResult);;
            }
            return $this->view('profile/love_list',[
                'animesLove' => $animesLove,
                'mangasLove' => $mangasLove,
                ]
            );
        } else {
            return $this->redirect('Auth/indexLogin');
        }

    }
}


?>