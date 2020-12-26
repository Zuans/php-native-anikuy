<?php 

include_once 'irequest.php';


class Router {

    public function __construct() {
        $this->bootstrapSelf();
    }


    public function bootstrapSelf() {
        // foreach( $_SERVER as $key => $value ) {
        //     $this->{$this->toCamelCase($key)} = $this->value;
        // }
        $this->server = $_SERVER;
        foreach( $_SERVER as $key => $value ) {
            $this->{$this->toCamelCase($key)} =$value;
        }
    }

    private function toCamelCase($string) {
        $result = strtolower($string);
        $pattern = "/_[a-z]/";
        preg_match_all($pattern,$string,$matches);
        echo $result . "<br>";
        var_dump($matches);
        foreach ( $matches[0] as $match) {
            $c = str_replace("_",' ',strtoupper($match));
            echo $c;
            $result = str_replace($match,$c,$result);
        }

        // $pattern = "/_[a-z]/g";
        // preg_match_all($pattern,$string,$matches);

        // foreach( $matches[0] as $match ) {
        //     $c = str_replace('_','',strtoupper($match));
        //     $result = str_replace($match,$c,$result);
        // }

        // return $result;
    }


    public function getBody() {
        if($this->requestMethod === 'GET') {
            return;
        }
    
        if($this->reqeustMethod === 'POST') {
            $body = array();
            foreach($_POST as $key => $value ) {
                $body[$value] = filter_input(INPUT_POST,);
            }
        }
    
    }

}


$test = new Router();
var_dump($test->bootstrapSelf());



?>