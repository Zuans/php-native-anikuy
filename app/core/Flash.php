<?php


class Flash {

    public static function setFlash($type,$msg) {
        $_SESSION['flash'] = [
            'type' => $type,
            'msg' => $msg,
        ];
    }

    public static function showFlash() {
        if(isset($_SESSION['flash'])) {
            echo '<div class="alert-'. $_SESSION['flash']['type'] . ' ">
                    <h3>' . $_SESSION['flash']['msg'] . '</h3>
                  </div>';
            unset($_SESSION['flash']);
        }

    }
}

?>

