<?php 



// Home and search result
Route::get('Home/index',['index','id']);

// ANIME ROUTE
Route::post('Anime/search');
Route::get('Anime/show',['id']);
Route::post('Anime/addLove');
Route::post('Anime/removeLove');

// MANGA ROUTE
Route::get('Manga/index');
Route::post('Manga/search');
Route::get('Manga/show',['id']);
Route::post('Manga/addLove');
Route::post('Manga/removeLove');

//  AUTH ROUTE
Route::get('Auth/indexLogin');
Route::post('Auth/login',['status']);
Route::get('Auth/indexRegister');
Route::post('Auth/register');
Route::get('Auth/logout');

// PROFILE ROUTE
Route::get('Profile/info');
Route::post('Profile/edit');
Route::get('Profile/loveList');

class Route {

    protected static $allGetLink = [],
              $allPostLink = [];


    public static function get($request,$params = []) {
        self::set($request,'GET',$params);
    }

    public static function post($request,$params = []) {
        self::set($request,'POST',$params);
    }

    public static function set($request,$method = 'GET' , $key = []) {
        if( $method == "GET") {
            self::$allGetLink["$request"] = $key;
        } else {
            self::$allPostLink["$request"] = $key;
        }
    }


    public static function check($urlRequest = null,$methodRequest = 'GET') {
        // Check url in allGetLink and allPostLink
        $urlExist = array_key_exists($urlRequest,self::$allGetLink) ?: array_key_exists($urlRequest,self::$allPostLink);
        if($urlExist) {
            // after that check the method request
            $validMethodReq = self::checkMethod($urlRequest,$methodRequest);
            if($validMethodReq) {
                return $urlRequest;
            } else {
                throw new Exception('Request Denied : Method Request Wrong !');
            }
        } else {
            throw new Exception('{{ WARNING : URL NOT FOUND : Please check your Route File Again ! }}');
        }
    }
    
    public static function checkMethod($urlRequest,$methodRequest = 'GET') {
        if( $methodRequest == 'GET') {
            $validRoute = array_key_exists($urlRequest,self::$allGetLink) ? true : false;
            return $validRoute;
        } else {
            $validRoute = array_key_exists($urlRequest,self::$allPostLink) ? true : false;
            return $validRoute;
        }
    }


    public static function setParams($index,$valueParams,$method = 'GET') {
        $keyParams = $method == 'GET' ? self::$allGetLink[$index] : self::$allPostLink[$index];
        $params = [];
        $i = 0;
        foreach ( $valueParams as $value  ) {
            if( count($keyParams) > $i ) {
                $params[$keyParams[$i]] = $value;
            } else {
                // throw new Exception('Attention : the number of params given exceeds the avaible');
                break;
            }
            $i++;
        }
        return $params;
    }
}




?>


