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
    $filled = true;

    function composeMailText(string $name, string $email, string $subject, string $message) : string{
        $message = "Contactform entry" . PHP_EOL . PHP_EOL;
        $message .= "Name: " . $name . PHP_EOL . PHP_EOL;
        $message .= "Email: " . $email . PHP_EOL . PHP_EOL;
        $message .= "Subject: " . $subject . PHP_EOL . PHP_EOL;
        $message .= "Message: " . $message . PHP_EOL . PHP_EOL;
        return $message;
    }

    function sendMessage(string $name, string $email, string $subject, string $message) : bool{
        if($name && $email && $subject && $message){
            mail("jonathan@jon-it.be", 'contact-form' , composeMailText($name, $email, $subject, $message));
            mail($email, 'contact-form details' , composeMailText($name, $email, $subject, $message));
            return true;
        } else {
            return false;
        }
    }


    if (isset($_POST['name']) && $_POST['name'] !== ''){
        $name = $_POST['name'];
        $checkFilled++;
    }
    elseif (isset($_POST['name']) && $_POST['name'] == ''){
        $errName = true;
        $filled = false;
    }

    if (isset($_POST['email']) && $_POST['email'] !== ''){
        $email = $_POST['email'];
        $checkFilled++;
    }
    elseif (isset($_POST['email']) && $_POST['email'] == ''){
        $errEmail = true;
        $filled = false;
    }

    if (isset($_POST['subject']) && $_POST['subject'] !== ''){
        $subject = $_POST['subject'];
        $checkFilled++;
    }
    elseif (isset($_POST['subject']) && $_POST['subject'] == ''){
        $errSubject = true;
        $filled = false;
    }

    if (isset($_POST['message']) && $_POST['message'] !== ''){
        $message = $_POST['message'];
        $checkFilled++;
    }
    elseif (isset($_POST['message']) && $_POST['message'] == ''){
        $errMessage = true;
        $filled = false;
    }
    if ($checkFilled == 4){
        if(sendMessage($name, $email, $subject, $message) == true){
            $filled = true;
        }
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
        'filled' => $filled,
        'checkFilled' => $checkFilled
    ]);

