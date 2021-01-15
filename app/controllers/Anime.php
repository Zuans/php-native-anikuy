<?php

// namespace controller\Anime;



class Anime extends Controller {
    public $allMonth = [
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'June',
        'July',
        'Aug',
        'Sept',
        'Oct',
        'Nov',
        'Dec',
    ];



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
            'typeSearch' => 'Anime Search Result',
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
        // Get all comment by anime id
        $AnimeComment = new AnimeComment_model;
        $comments = $AnimeComment->getByAnimeId($id);
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false ;
        if($userId) {
            $animeLove = new AnimeLove_model;
            $isLoved = $animeLove->isLoved($userId,$id);
            // Add View
            $User = new User_model;
            $User->incView($userId);
            return $this->view('detail',[
                'animeDetail' => $animeDetail,
                'isLoved' => $isLoved,
                'allComment' => $comments['allComment'],
                'totalData' => $comments['totalData'],
            ]);
        } else {
            $this->view('detail',[
                'animeDetail' => $animeDetail,
                'isLoved' => false,
                'allComment' => $comments['allComment'],
                'totalData' => $comments['totalData'],
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
            echo Helper::setSuccess('Love has been added');
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

        $post = Helper::postData();
        if(!$post) {
        echo Helper::setError('Error when parsing body data');
        }

        $AnimeLove = new AnimeLove_model;
        $remove = $AnimeLove->remove('24',$post['animeId']);
        if($remove) {
            $loveAnime = $AnimeLove->getByUserId($userId);
            echo Helper::setSuccess('Love has been remmoved',$loveAnime);
        }else {
            echo Helper::setError('Error something went wrong');
        }
    }

    public static function setAnimeLove($allId = []) {
        $allAnime = [];
        foreach( $allId as $key=>$value ) {
            $param = [
                'id' => $value['anime_id'],
            ];
            $url = ApiRequest::setUrlApi($param,'anime');
            try {
                $result = ApiRequest::httpRequest('GET',$url);
                property_exists($result,'data');
                $result = json_decode($result)->data;
            }catch(Exception $e) {
                $err = Helper::setError($e->getMessage(),400);
                var_dump($err);
                return $err;
            }
            $anime = self::set($result);
            $allAnime[] = $anime;
        }
        $result = self::splitAnimeLove($allAnime);
        return $result;
    }

    public function splitAnimeLove($allAnime) {
        $result = [];
        if(count($allAnime) > 3 ) {
            $splitAnime = [];
            foreach( $allAnime as $key => $anime ) {
                // echo count($allAnime) == ($key + 1) ? 'Betul' : 'salah';
                if($key % 3 == 0 && $key != 0 ) {
                    // Push splitanime first then push anime to splitAnime 
                    $result[] = $splitAnime;
                    $splitAnime = [];
                    $splitAnime[] = $anime;
                    // If last index is factorial 3
                    count($allAnime) == ($key + 1) ? $result[] = $splitAnime : null;
                } else if(count($allAnime) == ($key + 1) ) {
                    $splitAnime[] = $anime;
                    $result[] = $splitAnime;
                } else {
                    $splitAnime[] = $anime;
                }
            } 
        } else {
            $result[] = $allAnime;
        }
        return $result;
    }

    public static function addComment() {
        // Instance class
        $AnimeComment = new AnimeComment_model;

        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        if(!$userId) {
            echo Helper::setError('Unauthorized',401);
            return;
        }

        $post = Helper::postData();
        if(!$post) {
            echo Helper::setError('Error when parsing body data');
            return;
        }

        $newComment = $AnimeComment->add($post['animeId'],$userId,$post['text']);
        if(!$newComment) {
            echo Helper::setError('Error when add anime please try again!');
            return;
        }

        echo Helper::setSuccess('Success add comment',$newComment);
        return;
    }

    public static function set($animes) {
        $baseImg = BASE_URL . 'assets/img/card-1.png';
        if(count($animes) > 1 ) {
            $allAnime =  [];
            $i = 0;
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
                    'aired' => self::setAired($value->attributes->startDate,$value->attributes->endDate),
                    'epsCount' => $value->attributes->episodeCount ?: '?',
                    'epsLength' => $value->attributes->episodeLength != null ? self::setEpsLen($value->attributes->showType,$value->attributes->episodeLength) : '???' ,
                    'ytVideoId' => $value->attributes->youtubeVideoId,
                    'imgPoster' => $value->attributes->posterImage ? $value->attributes->posterImage->small  : $baseImg,
                    'imgPosterFl' => $value->attributes->posterImage ? $value->attributes->posterImage->large  : $baseImg,
                    'imgCover' => $value->attributes->coverImage ? $value->attributes->coverImage->original : $baseImg,
                ];
                $allAnime[$i] = $anime;
                $i++;
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
                'aired' => self::setAired($animes[0]->attributes->startDate,$animes[0]->attributes->endDate),
                'epsCount' => $animes[0]->attributes->episodeCount ?: '?' ,
                'epsLength' => $animes[0]->attributes->episodeLength ? self::setEpsLen($animes[0]->attributes->showType,$animes[0]->attributes->episodeLength) : '???',
                'ytVideoId' => $animes[0]->attributes->youtubeVideoId,
                'imgPoster' => $animes[0]->attributes->posterImage ? $animes[0]->attributes->posterImage->small  : $baseImg,
                'imgPosterFl' => $animes[0]->attributes->posterImage ? $animes[0]->attributes->posterImage->large  : $baseImg,
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


    public static function setEpsLen($type,$length = 0 ) {
        $duration;
        if($length > 60 ) {
            $hours = floor($length / 60);
            $minutes =  $length - ($hours * 60);
            $duration = "$hours hour $minutes minutes";
        }else {
            $duration = $length;
        }
        $type != 'movie' ? $duration .= ' ' . 'min per eps' : null;
        return $duration;
    }

    public  static function setLang($lang) {
        $resultLang = isset($lang->en_jp) ? $lang->en_jp:
                        (isset($lang->en) ? $lang->en:
                            (isset($lang->en_us) ? $lang->en_us : 
                                ( isset($lang->jp) ? $lang->$jp : 
                                    ( isset($lang->en_cn) ? $lang->en_cn : $lang->cn))));
        return $resultLang;
    }

    public static function setAired($strt = '?',$end = '?') {
        if($end == null ) $end = '???';
        return $strt . ' ' . 'to' . ' ' . $end;
    }





}


?>