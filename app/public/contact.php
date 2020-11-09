<?php

    // General variables
    $basePath = __DIR__ . '/../';

    require_once __DIR__ . '/../vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../resources/templates');
    $twig = new \Twig\Environment($loader);


    // Data
    $name = '';
    $email = '';
    $subject = '';
    $message = '';

    $errName = false;
    $errEmail = false;
    $errSubject = false;
    $errMessage = false;

    $checkFilled = 0;


    if (isset($_GET['name']) && $_GET['name'] != ''){
        $name = $_GET['name'];
        $checkFilled++;
    }
    elseif (isset($_GET['name']) && $_GET['name'] == ''){
        $errName = true;
    }

    if (isset($_GET['email']) && $_GET['email'] != ''){
        $email = $_GET['email'];
        $checkFilled++;
    }
    elseif (isset($_GET['email']) && $_GET['email'] == ''){
        $errEmail = true;
    }

    if (isset($_GET['subject']) && $_GET['subject'] != ''){
        $subject = $_GET['subject'];
        $checkFilled++;
    }
    elseif (isset($_GET['subject']) && $_GET['subject'] == ''){
        $errSubject = true;
    }

    if (isset($_GET['message']) && $_GET['message'] != ''){
        $message = $_GET['message'];
        $checkFilled++;
    }
    elseif (isset($_GET['message']) && $_GET['message'] == ''){
        $errMessage = true;
    }

    // View
    $tpl = $twig->load('/pages/contact.twig');
    echo $tpl->render([
        'name' => $name,
        'email' => $email,
        'subject' => $subject,
        'message' => $message,
        'errName' => $errName,
        'errEmail' => $errEmail,
        'errSubject' => $errSubject,
        'errMessage' => $errMessage,
        'filled' => $checkFilled
    ]);

