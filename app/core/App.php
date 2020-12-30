<?php



class App {
    protected $url,
              $controller,
              $method,
              $params = [],
              $baseController = 'Home',
              $baseMethod = 'index',
              $methodRequest = 'GET';

    public function __construct() {
        $url = $this->parseUrl();
        
        // return if access js or css for prevent the error
        // if($url[0] == 'js' || $url[0] == 'css' ) {
        //     return;
        // }

        // Set Controller 
        $this->controller = count($url) > 0 ? $this->setController($url[0]) : $this->setController($this->baseController);
        // Set Method
        $this->method = count($url) >= 1 ? $this->setMethod($url[1]) : $this->setMethod($this->baseMethod);
        // Get controller str for checking route
        $controllerStr =  array_key_exists(0,$url) ? $url[0] : $this->baseController;
        // Unset Array for easier check params
        
        $this->methodRequest = $_SERVER['REQUEST_METHOD'];
        // Verify method
        $verifyRoute =  $this->verify($controllerStr,$this->method);
    
        unset($url[0],$url[1]);
        if(count($url) > 0 ) {
            $this->params = $this->setParams($verifyRoute,$url);
        }
        
        call_user_func_array([$this->controller,$this->method],$this->params);
    }

    public function parseUrl() {
        if( isset($_GET['url'])) {
            $url = $_GET['url'];
            $url =  trim($url);
            $url = filter_var($url,FILTER_SANITIZE_URL);
            return explode('/',$url);
        } else {
            return [];
        }
    }


    public function setController($controller) {
        $pathDir = '/../controllers/';
        $ext = '.php';
        $pathFile = __DIR__ . $pathDir . $controller . $ext;
        if(file_exists($pathFile)) {
            require_once $pathFile;
            return new $controller;
        } else {
            throw new Exception('Controller Not Found');
        }
    }

    public function setMethod($method) {
        if(method_exists($this->controller,$method)) {  
            return $method;
        } else {
            throw new Exception('Method not found');
        }
    }

    public function verify($controller,$method) {
        $urlRequest = $controller . DIRECTORY_SEPARATOR .  $method;
        // Check Url and Method in Route Class
        $validRoute = Route::check($urlRequest,$this->methodRequest);
        return $validRoute;
    }

    public  function setParams($urlRequest,$params) {
        $params = Route::setParams($urlRequest,$params,$this->methodRequest);
        return $params;
        // Check method return controller/method if valid and return null if not not found
        // $params = Route::setParams($validRoute,$params);
    }



}


?>