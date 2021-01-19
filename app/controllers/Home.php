<?php

// namespace controller\Home;



class Home extends Controller {
    

    public function index() {
        try {
            $popularAnime = Anime::popularAnime();
            $url = 'https://kitsu.io/api/edge/anime?filter[status]=current&sort=-averageRating';
            $response = ApiRequest::httpRequest('GET',$url);
            $allAnime = json_decode($response)->data;
            // If not get the data req again
            if(property_exists($response,'data')) {
                $response = ApiRequest::httpRequest('GET',$url);
                $allAnime = json_decode($response)->data;
            }
            $allAnime = Anime::set($allAnime);
            $this->view('home',[
                'allAnime' => $allAnime,
                'popularAnime' => $popularAnime,
                'typeSearch' => 'Top Airing Anime',
            ]);
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        } 
    }

}



?>