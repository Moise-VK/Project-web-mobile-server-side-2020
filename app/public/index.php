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

    // Define routes
    $router->get('/', 'IndexController@view');
    $router->get('home', 'IndexController@view');
    $router->get('contact', 'ContactController@view');
    $router->post('contact', 'ContactController@sendMail');
    $router->get('events', 'ShowEventController@view');

    // Run it!
    $router->run();
