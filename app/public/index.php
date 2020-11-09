<?php

    // General variables
    $basePath = __DIR__ . '/../';

    require_once __DIR__ . '/../vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../resources/templates');
    $twig = new \Twig\Environment($loader);


    // Data


    // View
    $tpl = $twig->load('/pages/index.twig');
    echo $tpl->render();
