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


    if (isset($_POST['name']) && $_POST['name'] !== ''){
        $name = $_POST['name'];
        $checkFilled++;
    }
    elseif (isset($_POST['name']) && $_POST['name'] == ''){
        $errName = true;
    }

    if (isset($_POST['email']) && $_POST['email'] !== ''){
        $email = $_POST['email'];
        $checkFilled++;
    }
    elseif (isset($_POST['email']) && $_POST['email'] == ''){
        $errEmail = true;
    }

    if (isset($_POST['subject']) && $_POST['subject'] !== ''){
        $subject = $_POST['subject'];
        $checkFilled++;
    }
    elseif (isset($_POST['subject']) && $_POST['subject'] == ''){
        $errSubject = true;
    }

    if (isset($_POST['message']) && $_POST['message'] !== ''){
        $message = $_POST['message'];
        $checkFilled++;
    }
    elseif (isset($_POST['message']) && $_POST['message'] == ''){
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

