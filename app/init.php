<?php

require_once __DIR__ . '/core/Constant.php';


function autoLoader() {
    spl_autoload_register(function($className) {
        $appDirs = ['controllers','core','models'];
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
    });
}
?>