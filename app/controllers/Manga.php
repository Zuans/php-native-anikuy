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
        $detailManga = self::set($detailManga);
        if($userId) {
            $mangaLove = new MangaLove_model;
            $isLoved = $mangaLove->isLoved($userId,$id);
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
            echo Helper::setError('You must be login',500);
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
            echo Helper::setError('You must be login',500);
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
            echo Helper::setSuccess('Success remove manga from love',200);
            return;
        } else {
            echo Helper::setError('Error when remove manga from love',500);
            return;
        }
    }


    public static function popularManga() {
        $url =  BASE_API_URL . '/manga?sort=-userCount&page[limit]=5';
        $allManga = ApiRequest::httpRequest('GET',$url);
        $allManga = self::set($allManga);
        return $allManga;
    }

    public static function currentManga() {
        $url = BASE_API_URL . '/manga?filter[status]=current&sort=-averageRating';
        $currentManga = ApiRequest::httpRequest('GET',$url);
        $currentManga = self::set($currentManga);
        return $currentManga;
    }


    public static function set($allManga) {
        $allManga = json_decode($allManga)->data;
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
                    'aired' => $value->attributes->startDate?: '?' . ' ' . 'to' . $value->attributes->endDate?: '?',
                    'chapCount' =>$value->attributes->chapterCount ?: '?',
                    'mangaType' => $value->attributes->mangaType,
                    'serialization' => $value->attributes->serialization ?: '?',
                    'imgPoster' => $value->attributes->posterImage ? $value->attributes->posterImage->small : $baseImg,
                    'imgCover' => $value->attributes->posterImage ? $value->attributes->posterImage->original : $baseImg,
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
                    'aired' => $allManga[0]->attributes->startDate?: '?' . ' ' . 'to' . $allManga[0]->attributes->endDate?: '?',
                    'chapCount' =>$allManga[0]->attributes->chapterCount ?: '?',
                    'serialization' => $allManga[0]->attributes->serialization ?: '?',
                    'mangaType' => $allManga[0]->attributes->mangaType,
                    'imgPoster' => $allManga[0]->attributes->posterImage ? $allManga[0]->attributes->posterImage->small : $baseImg,
                    'imgCover' => $allManga[0]->attributes->posterImage ? $allManga[0]->attributes->posterImage->original : $baseImg,
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
}


?>