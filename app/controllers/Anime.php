<?php

// namespace controller\Anime;



class Anime extends Controller {
    public function index() {
        $this->view('home');
    }

    public function search() {
        $popularAnime = Anime::popularAnime();
        $url = ApiRequest::setUrlApi($_POST,'anime');
        $resultAnime = ApiRequest::httpRequest('GET',$url);
        $resultAnime = json_decode($resultAnime)->data;
        $resultAnime = Anime::set($resultAnime);
        $this->view('home',[
            'popularAnime' => $popularAnime,
            'allAnime' => $resultAnime,
        ]);
    }

    public function show($id = null) {
        $params = [
            'id' => $id,
        ];
        $url = ApiRequest::setUrlApi($params,'anime');
        $animeResult = ApiRequest::httpRequest('GET',$url);
        $animeResult =  json_decode($animeResult)->data;
        $animeDetail = Anime::set($animeResult);
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false ;
        if($userId) {
            $animeLove = new AnimeLove_model;
            $isLoved = $animeLove->isLoved($userId,$id);
            $this->view('detail',[
                'animeDetail' => $animeDetail,
                'isLoved' => $isLoved,
            ]);
        } else {
            $this->view('detail',[
                'animeDetail' => $animeDetail,
                'isLoved' => false,
            ]);
            return;
        }

    }



    public function addLove() {
        // Check if visitor has login
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        if(!$userId) {
            echo Helper::setError('You must login',500);
            return;
        };

        // Get POST data
        $post = Helper::postData();
        if(!$post) {
            // Err when parsing data
            echo Helper::setError('Error Parsing Data',500);
        };
        // Init Anime like model
        $animeLove = new AnimeLove_model;
        $add = $animeLove->add($userId,$post['animeId']);
        if($add) {
            echo Helper::setSuccess('Like has been added');
            return; 
        } else {
            echo Helper::setError();
            return;
        }
    }

    public function removeLove() {
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        if(!$userId) {
            echo Helper::setError('You must login',500);
            return;
        };

        // Get POST data
        $post = Helper::postData();
        if(!$post) {
            // Err when parsing data
            echo Helper::setError('Error Parsing Data',500);
        };

        $animeLove = new AnimeLove_model;
        $remove = $animeLove->remove($userId,$post['animeId']);
        if($remove) {
            echo Helper::setSuccess('Removed Success',200);
            return;
        }else {
            echo Helper::setError();
            return;
        }
    }

    public static function set($animes) {
        $baseImg = BASE_URL . 'assets/img/card-1.png';
        if(count($animes) > 1 ) {
            $allAnime =  array();
            foreach ( $animes as $key => $value ) {
                $anime = [
                    'id' => $value->id,
                    'showType' => $value->attributes->showType,
                    'synopsis' => $value->attributes->synopsis ? self::sliceDesc($value->attributes->synopsis) : "This anime doesn't have synopsis",
                    'fullSynopsis' => $value->attributes->synopsis ? $value->attributes->synopsis : "This Series doesn't have synopsis",
                    'title' => self::setLang($value->attributes->titles),
                    'rating' => $value->attributes->averageRating ?: '-',
                    'ratingRank' => $value->attributes->ratingRank ?: '-',
                    'ageRating' => $value->attributes->ageRating ?: '-',
                    'user' => $value->attributes->userCount,
                    'status' => $value->attributes->status,
                    'aired' => $value->attributes->startDate?: '?' . 'to' . $value->attributes->endDate?: '?',
                    'epsCount' => $value->attributes->episodeCount ?: '?',
                    'imgPoster' => $value->attributes->posterImage ? $value->attributes->posterImage->small  : $baseImg,
                    'imgCover' => $value->attributes->coverImage ? $value->attributes->coverImage->original : $baseImg,
                ];
                array_push($allAnime,$anime);
            }
            return $allAnime;
        }  else {
            $anime = [
                'id' => $animes[0]->id,
                'showType' => $animes[0]->attributes->showType,
                'synopsis' => $animes[0]->attributes->synopsis ? self::sliceDesc($animes[0]->attributes->synopsis) : "This anime doesn't have synopsis",
                'fullSynopsis' => $animes[0]->attributes->synopsis ? $animes[0]->attributes->synopsis : "This Series doesn't have synopsis",
                'title' => self::setLang($animes[0]->attributes->titles),
                'rating' => $animes[0]->attributes->averageRating ?: '-',
                'ratingRank' => $animes[0]->attributes->ratingRank ?: '-',
                'ageRating' => $animes[0]->attributes->ageRating ?: '-',
                'user' => $animes[0]->attributes->userCount,
                'status' => $animes[0]->attributes->status,
                'aired' => $animes[0]->attributes->startDate . " ". 'to' . " " . $animes[0]->attributes->endDate?: '?',
                'epsCount' => $animes[0]->attributes->episodeCount ?: '?' ,
                'imgPoster' => $animes[0]->attributes->posterImage ? $animes[0]->attributes->posterImage->small  : $baseImg,
                'imgCover' => $animes[0]->attributes->coverImage ? $animes[0]->attributes->coverImage->original :  $baseImg,
            ];
            return $anime;
        }
    }

    public static function popularAnime() {
        $url = 'https://kitsu.io/api/edge/anime?sort=-userCount&page[limit]=5';
        $popularAnime = ApiRequest::httpRequest('GET',$url,null);
        $popularAnime = json_decode($popularAnime)->data;
        $popularAnime = self::set($popularAnime);
        return $popularAnime;
    }

    public static function sliceDesc($desc) {
        $splitDesc = explode(" ",$desc);
        if( count($splitDesc) > 50 ) {
            $resultDesc = array_slice($splitDesc,0,30);
            return implode(" ",$resultDesc) . '...';
        }else {
            return implode(" ",$splitDesc);
        }
    }



    public  static function setLang($lang) {
        $resultLang = isset($lang->en_jp) ? $lang->en_jp:
                        (isset($lang->en) ? $lang->en:
                            (isset($lang->en_us) ? $lang->en_us : 
                                ( isset($lang->jp) ? $lang->$jp : 
                                    ( isset($lang->en_cn) ? $lang->en_cn : $lang->cn))));
        return $resultLang;
    }





}


?>