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


    //Event routes
    $router->mount('/events', function () use ($router){
        $router->get('', 'EventController@view');
        $router->get('search', 'EventController@search');
    });

    $router->mount('/event', function () use ($router){
        $router->get('(\w+)', 'EventController@detail');
    });

    $router->mount('/create', function () use ($router) {
        $router->before('GET|POST', '/.*', function () {
            if(!isset($_SESSION['user'])){
                header('Location: /login');
                exit();
            }
        });
       $router->get('event', 'EventDataController@showAddScreen');
       $router->post('event', 'EventDataController@addNewEventAndTicket');

       $router->post('ticket', 'EventDataController@createTicket');

       $router->post('event/search', 'EventDataController@showAddScreen');
    });

    $router->mount('/user', function () use ($router) {
        $router->before('GET|POST', '/.*', function () {
            if(!isset($_SESSION['user'])){
                header('Location: /login');
                exit();
            }
        });
        $router->get('/detail', 'UserController@showUserInfoPage');
        $router->post('/detail/updateData', 'UserController@updateData');
        $router->post('/detail/inviteFriend', 'UserController@sendMailFriend');

    });

    //Login routes
    $router->get('login', 'AuthController@showLoginRegister');
    $router->post('login', 'AuthController@login');
    ///Register routes
    $router->get('register', 'AuthController@showLoginRegister');
    $router->post('register', 'AuthController@register');
    //Logout routes
    $router->get('logout', 'AuthController@logout');


    $router->set404( 'IndexController@view');

    // Run it!
    $router->run();
