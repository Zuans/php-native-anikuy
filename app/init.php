<?php

require_once __DIR__ . '/core/Constant.php';


function autoLoader() {
    spl_autoload_register(function($className) {
        $appDirs = ['core','controllers','models'];
        $dirPath = __DIR__ . '/../app/';
        $className = str_replace('\\',DIRECTORY_SEPARATOR,$className);
        $ext = '.php';
        foreach ( $appDirs  as $appDir ) {
            $fullPath = $dirPath . $appDir . DIRECTORY_SEPARATOR . $className .  $ext;
            if(file_exists($fullPath)) {
                require_once $fullPath;
            } else {
                
            }
        }
        // echo __DIR__ .  '/../app/core/' . $className . '.php' . '<br>';
        // if(file_exists(__DIR__ .  '/../app/core/' . $className . '.php')) {
        //     echo 'ada';
        // }
        // require_once __DIR__ .  '/../app/core/' . $className . '.php';
    });
}
?>