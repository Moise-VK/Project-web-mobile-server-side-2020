<?php

    // General variables
    $basePath = __DIR__ . '/../';

    // Data

    require_once $basePath . 'vendor/autoload.php';

    //Twig dependencies
    $loader = new \Twig\Loader\FilesystemLoader($basePath . '/resources/templates');
    $twig = new \Twig\Environment($loader);

    // Create Router instance
    $router = new \Bramus\Router\Router();

    $router->before('GET|POST', '/.*', function () {
        session_start();
    });

    // Define routes
    $router->get('', 'IndexController@view');
    $router->get('home', 'IndexController@view');
    $router->get('contact', 'ContactController@view');
    $router->post('contact', 'ContactController@sendMail');
    $router->get('event/(\w+)', 'EventController@detail');

    //Event routes
    $router->mount('/events', function () use ($router){
        $router->get('', 'EventController@view');
        $router->get('search', 'EventController@search');
    });

    /*
    $router->mount('/event', function () use ($router){
        $router->get('/(\w+)', 'EventController@detail');
    });*/
    //$router->get('events', 'EventController@view');

    //Login routes
    $router->get('login', 'AuthController@showLoginRegister');
    $router->post('login', 'AuthController@login');
    ///Register routes
    $router->get('register', 'AuthController@showLoginRegister');
    $router->post('register', 'AuthController@register');
    //Logout routes
    $router->get('logout', 'AuthController@logout');
    /* Voorbeeld om routes te beveiligen
    $router->mount('/dashboard', function () use ($router){
        $router->before('GET|POST', '/.*', function () {
            if(!isset($_SESSION['user'])){
                header('Location: /login');
                exit();
            }
        });
        //ALL ROUTES FOR USERACTIONS/ TRANSACTIONS/ ...
    }); */

    $router->set404('IndexController@view');

    // Run it!
    $router->run();
