<?php

// namespace controller\Home;



class Home extends Controller {
    

    public function index() {
        $popularAnime = Anime::popularAnime();
        $url = 'https://kitsu.io/api/edge/anime?filter[status]=current&sort=-averageRating';
        $allAnime = ApiRequest::httpRequest('GET',$url);
        $allAnime = json_decode($allAnime)->data;
        $allAnime = Anime::set($allAnime);
        $this->view('home',[
            'allAnime' => $allAnime,
            'popularAnime' => $popularAnime,
            'typeSearch' => 'Top Airing Anime',
        ]); 
    }




    public function show($id) {
        echo $id;
    }
}



?>