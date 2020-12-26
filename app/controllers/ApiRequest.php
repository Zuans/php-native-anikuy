<?php

// namespace controller\ApiRequest;


class ApiRequest {
    public static function setUrlApi($filter,$type) {
        $i = 0;
        $url  = BASE_API_URL . "/$type?";
        foreach( $filter as $key => $value ) {
            $value =  rawurlencode($value);
            $i += 1;
            if(empty($value)) {
                continue;
            }
            if($i == count($filter)) {
                $url .= "filter[$key]=$value";
                continue;
            }
            $url .= "filter[$key]=$value&";
        }

        return $url;
    }


    public static function httpRequest($method,$url,$data = []) {
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
}



?>