<?php


class Helper {

    public static function postData() {
        $contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';
        $result;
        if($contentType == 'application/json') {
            $content = file_get_contents('php://input');
            $decoded = json_decode($content,true);
            if(is_array($decoded)) {
                $result = $decoded;
                return $result;
            } else {
                return false;
            }
        }
    }

    public static function setError($msg = '',$code = 500) {
        $err = [
            'status' => 'error',
            'code' => $code,
            'msg' => $msg,
        ];
        return json_encode($err) ;
    }

    public static function setSuccess($msg = '',$data = null, $code = 200) {
        $success = [
            'status' => 'success',
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
        return json_encode($success) ;
    }
}


?>