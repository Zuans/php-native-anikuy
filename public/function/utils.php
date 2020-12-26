<?php


    function setUrlApi($filter,$type) {
        global $baseUrl;
        $i = 0;
        $url  = "$baseUrl/$type?";
        foreach( $filter as $key => $value ) {
            $value =  rawurlencode($value);
            $i += 1;
            if(empty($value)) {
                continue;
            }
            if($i == count($filter)) {
                $url .= "filter[$key]=$value".urlencode($value);
                continue;
            }
            $url .= "filter[$key]=$value&";
        }

        return $url;
    };

    function setAnime($data) {
        $allAnime =  array();
        foreach ( $data as $key => $value ) {
            $anime = [
                'synopsis' => $value->attributes->synopsis ? sliceDesc($value->attributes->synopsis) : "This anime doesn't have synopsis",
                'title' => setAnimeLang($value->attributes->titles),
                'rating' => $value->attributes->averageRating ?: '-',
                'user' => $value->attributes->userCount,
                'status' => $value->attributes->status,
                'img' => $value->attributes->coverImage? $value->attributes->coverImage->original  :'assets/img/card-1.png',
            ];
            array_push($allAnime,$anime);
        }
        return $allAnime;
    }

    function sliceDesc($desc) {
        $splitDesc = explode(" ",$desc);
        if( count($splitDesc) > 50 ) {
            $resultDesc = array_slice($splitDesc,0,50);
            return implode(" ",$resultDesc);
        }else {
            return implode(" ",$splitDesc);
        }
    }

    function setAnimeLang($lang) {
        $resultLang = isset($lang->en_jp)?$lang->en_jp:
                        (isset($lang->en)?$lang->en:
                            (isset($lang->en_us)?$lang->en_us:
                                (isset($lang->jp)?$lang->jp:'Unknown')));
        return $resultLang;
    }


    function httpRequest($method,$url,$data) {
        $ch = curl_init();
        switch($method)
        {
            case('POST'):
                curl_setopt($ch,CURLOPT_POST,1);
                if($data) {
                    curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
                }
                break;
            case('PUT'):
                curl_setopt($ch,CURLOPT_PUT,1);
                break;
        }
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        $result = curl_exec($ch);
        return $result;
    }


    function getPopularAnime() {
        $url = 'https://kitsu.io/api/edge/anime?sort=-userCount';
        $popularAnime = httpRequest('GET',$url,null);
        $popularAnime = json_decode($popularAnime)->data;
        $popularAnime = setAnime($popularAnime);
        return $popularAnime;
    }
?>
