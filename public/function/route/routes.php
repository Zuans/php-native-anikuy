<?php
    $router = new Router;

    $router->get('/some/route',function($request) { 
        // <!--  The $request argument of the callback -->
        // <!-- Will contain -->
        return $request;
    });

    $router->post('/some/wadwad',function($request) {
        // How to get data from request data
        $body = $request->getBody();
    });
    

?>


