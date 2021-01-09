<?php


class Manga extends Controller {


    public function index() {
        $popularManga = self::popularManga();
        $currentManga = self::currentManga();
        $this->view('home',[
            'popularManga' => $popularManga,
            'allManga' => $currentManga,
        ]);
    }

    public function search() {
        $url = ApiRequest::setUrlApi($_POST,'manga');
        $popularManga = self::popularManga();
        $resultManga = ApiRequest::httpRequest('GET',$url);
        $resultManga = json_decode($resultManga)->data;
        $resultManga = self::set($resultManga);
        $this->view('home',[
            'popularManga' => $popularManga,
            'allManga' => $resultManga,
        ]);
    }

    public function show($id) {
        $params = [
            'id' => $id,
        ];
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $url = ApiRequest::setUrlApi($params,'manga');
        $detailManga = ApiRequest::httpRequest('GET',$url);
        $allManga = json_decode($detailManga)->data;
        $detailManga = self::set($allManga);
        if($userId) {
            $mangaLove = new MangaLove_model;
            $isLoved = $mangaLove->isLoved($userId,$id);
            $User = new User_model;
            $User->incView($userId);
            $this->view('detail',[
                'mangaDetail' => $detailManga,
                'isLoved' => $isLoved,
            ]);
        } else {
            $this->view('detail',[
                'mangaDetail' => $detailManga,
                'isLoved' => false,
            ]);
            return;
        }

    }


    public function addLove() {
        // Check user login
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        if(!$userId) {
            echo Helper::setError('You must be login',401);
            return;
        }

        // Get POST data
        $post = Helper::postData();
        if(!$post) {
            echo Helper::setError('Failed when parsing data body',500);
            return;
        }
  
        // Call the model
        $mangaLove = new MangaLove_model;
        $add = $mangaLove->add($userId,$post['mangaId']);
        if($add) {
            echo Helper::setSuccess('Success added love manga',200);
        }else {
            echo Helper::setError();
            return;
        }
    }

    public function removeLove() {
        // Check user login
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        if(!$userId) {
            echo Helper::setError('You must be login',401);
            return;
        }

        // Get POST data 
        $post = Helper::postData();
        if(!$post) {
            echo Helper::setError('Error when parsing data',500);
            return;
        }

        // Call the mode;
        $mangaLove = new MangaLove_model;
        $remove = $mangaLove->remove($userId,$post['mangaId']);
        if($remove) {
            $loveManga = $mangaLove->getByUserId($userId);
            echo Helper::setSuccess('Success remove manga from love',$loveManga,200);
            return;
        } else {
            echo Helper::setError('Error when remove manga from love',500);
            return;
        }
    }


    public static function popularManga() {
        $url =  BASE_API_URL . '/manga?sort=-userCount&page[limit]=5';
        $allManga = ApiRequest::httpRequest('GET',$url);
        $allManga = json_decode($allManga)->data;
        $allManga = self::set($allManga);
        return $allManga;
    }

    public static function currentManga() {
        $url = BASE_API_URL . '/manga?filter[status]=current&sort=-averageRating';
        $currentManga = ApiRequest::httpRequest('GET',$url);
        $currentManga = json_decode($currentManga)->data;
        $currentManga = self::set($currentManga);
        return $currentManga;
    }


    public static function setMangaLove($allId) {
        $allManga  = [];
        foreach($allId as $key => $manga ) {
            $param = [
                'id' => $manga['manga_id'],
            ];
            $url = ApiRequest::setUrlApi($param,'manga');
            try {
                $response = ApiRequest::httpRequest('GET',$url);
                property_exists($response,'data');
                $response = json_decode($response)->data;
            } catch(Exception $e) {
                $err = Helper::setError($e->getMessage(),400);
                var_dump($err);
                return err;
            }
            $manga = Manga::set($response);
            $allManga[] = $manga;
        }
        $result = self::splitManga($allManga);
        return $result;
    }

    public static function splitManga($allManga) {
        $result = [];
        if(count($allManga) > 3 ){
            $splitManga = [];
            foreach($allManga as $key => $manga ) {
                // each factorial of three push split manga
                if( $key % 3 == 0 && $key != 0 ) {
                    // Push to result and clear
                    $result[] = $splitManga;
                    $splitManga = [];
                    $splitManga[] = $manga;
                    // If last index is factorial of 3
                    count($allManga) == ( $key + 1 ) ? $result[] = $splitManga : null;
                } else if(count($allManga) == ( $key + 1 )) {
                    $splitManga[] = $manga;
                    $result[] = $splitManga;
                } else {
                    $splitManga[] = $manga;
                }
            }
        }else {
            $result[] = $allManga;
        }
        return $result;
    }

    public static function set($allManga) {
        $baseImg = BASE_URL . 'assets/img/card-1.png';
        if(count($allManga) > 1 ) {
            $resultManga = [];
            foreach( $allManga as $value ) {
                $manga = [
                    'id' => $value->id,
                    'title' => self::setLang($value->attributes->titles),
                    'synopsis' => self::sliceSynps($value->attributes->synopsis),
                    'fullSynopsis' => $value->attributes->synopsis,
                    'rating' => $value->attributes->averageRating ?: '-',
                    'ratingRank' => $value->attributes->ratingRank,
                    'ageRating' => $value->attributes->ageRating,
                    'user' => $value->attributes->userCount,
                    'status' => $value->attributes->status,
                    'aired' => self::setAired($value->attributes->startDate,$value->attributes->endDate),
                    'chapCount' =>$value->attributes->chapterCount ?: '?',
                    'mangaType' => $value->attributes->mangaType,
                    'serialization' => $value->attributes->serialization ?: '?',
                    'imgPoster' => $value->attributes->posterImage ? $value->attributes->posterImage->small : $baseImg,
                    'imgPosterFl' => $value->attributes->posterImage ? $value->attributes->posterImage->large : $baseImg,
                    'imgCover' => $value->attributes->coverImage ? $value->attributes->coverImage->original : $baseImg,
                ];
                $resultManga[] = $manga;
            }
            return $resultManga;
        }else {
            $detailManga = [
                'id' => $allManga[0]->id,
                    'title' => self::setLang($allManga[0]->attributes->titles),
                    'synopsis' => self::sliceSynps($allManga[0]->attributes->synopsis),
                    'fullSynopsis' => $allManga[0]->attributes->synopsis,
                    'rating' => $allManga[0]->attributes->averageRating ?: '-',
                    'ratingRank' => $allManga[0]->attributes->ratingRank,
                    'ageRating' => $allManga[0]->attributes->ageRating,
                    'user' => $allManga[0]->attributes->userCount,
                    'status' => $allManga[0]->attributes->status,
                    'aired' => self::setAired($allManga[0]->attributes->startDate,$allManga[0]->attributes->endDate),
                    'chapCount' =>$allManga[0]->attributes->chapterCount ?: '?',
                    'serialization' => $allManga[0]->attributes->serialization ?: '?',
                    'mangaType' => $allManga[0]->attributes->mangaType,
                    'imgPoster' => $allManga[0]->attributes->posterImage ? $allManga[0]->attributes->posterImage->small : $baseImg,
                    'imgPosterFl' => $allManga[0]->attributes->posterImage ? $allManga[0]->attributes->posterImage->large : $baseImg,
                    'imgCover' => $allManga[0]->attributes->coverImage ? $allManga[0]->attributes->coverImage->original : $baseImg,
            ];
            return $detailManga;
        }
    }

    public static function setLang($lang) {
        $resultLang = isset($lang->en_jp) ? $lang->en_jp:
                        (isset($lang->jp) ? $lang->jp:
                            (isset($lang->en_us) ? $lang->en_us:
                                ( isset($lang->en_cn) ? $lang->en_cn: $lang->en_kr )));
        return $resultLang;
    }

    public static function sliceSynps($synopsis) {
        $slice = explode(' ',$synopsis);
        if(count($slice) > 50 ) {
            $resultSynps = array_slice($slice,0,50);
            $resultSynps = implode(" ",$resultSynps) . '. . .';
            return $resultSynps;
        } else {
            return $synopsis;
        }
    }

    public static function setAired($strt,$end) {
        if($end == null ) $end = '???';
        return $strt . ' ' . 'to' . ' ' . $end;
    }
}


?>