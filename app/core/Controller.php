<?php


class Controller {

    public function view($view,$params = []) {
        if( !is_array($params)) {
            throw new Exception('You must send params with array type');
        }
        $filePath = __DIR__ . "/../views/$view.php";
        if(file_exists($filePath)) {
            extract($params);
            require_once $filePath;
        } else {
            throw new Exception($filePath);
        }
    }

    public function redirect($link) {
        $redirectTo = BASE_URL . 'index.php?url=' .$link;
        header('Location:' . $redirectTo );
        exit;
    }
}

class View extends Controller {

    public static $allCSS = [];
    public static $allJS = [];
    
    public static function build($viewPath) {
        self::view($viewPath);
    }

    public static function link($path) {
        echo $path;
    }

    public static function request($link) {
        return BASE_URL . $link;
    }




    public static function getCSS() {
        foreach( self::$allCSS as $css ) {
            echo $css;
        }
    }

    public static function getJS() {
        foreach( self::$allJS as $js ) {
            echo $js;
        } 
    }

    public function assets($pathFile) {
        return BASE_URL . 'assets/' . $pathFile;
    }


    public static function setCSS($pathFile) {
        $ext = '.css';
        $pathFile = $pathFile.$ext;
        $url = BASE_URL . 'assets/css/' . $pathFile;
        $cssTag = "<link rel='stylesheet' href='{$url}'>";
        self::$allCSS[] = $cssTag;
    }

    public static function setJS($pathFile) {
        $ext = '.js';
        $pathFile = $pathFile . $ext;
        $url = BASE_URL . 'js/' . $pathFile;
        $requirePath = BASE_URL . 'js/require' . $ext;
        $jsTag =  "<script data-main='{$url}' src='$requirePath' async></script>";
        self::$allJS[] = $jsTag;
    }


}

?>