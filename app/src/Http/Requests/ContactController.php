<?php
    class ContactController extends BaseController {
        private $errors = array();
        public function view(){
            echo $this->twig->render('/pages/contact.twig',[
                'name' => $this->getName(),
                'email' => $this->getEmail(),
                'subject' => $this->getSubject(),
                'message' => $this->getMessage(),
                'errors' => $this->errors,
                'filled' => $this->checkFilled()
            ]);

        }
        public function sendMail(){
            $this->view();
            if ($this->checkFilled() == 4){
                $this->sendMessage($this->getName(), $this->getEmail(), $this->getSubject(), $this->getMessage());
            }
        }
        private function composeMailText(string $name, string $email, string $subject, string $ogMessage) : string{
            $message = "Contactform entry" . PHP_EOL . PHP_EOL;
            $message .= "Name: " . $name . PHP_EOL . PHP_EOL;
            $message .= "Email: " . $email . PHP_EOL . PHP_EOL;
            $message .= "Subject: " . $subject . PHP_EOL . PHP_EOL;
            $message .= "Message: " . $ogMessage . PHP_EOL . PHP_EOL;
            return $message;
        }

        private function sendMessage(string $name, string $email, string $subject, string $message) : bool{
            if($name && $email && $subject && $message){
                mail("jonathan@jon-it.be", 'contact-form' , $this->composeMailText($name, $email, $subject, $message));
                mail($email, 'contact-form details' , $this->composeMailText($name, $email, $subject, $message));
                return true;
            } else {
                return false;
            }
        }

        /*If no name is filled in $name stays empty and an error wil be added to errors[]
        if a name is filled in $name will be set $name will be set and errors['name'] will be empties
        before the page gets posted $name is empty and errors[] is empty*/

        private function getName(){
            if (isset($_POST['name']) && $_POST['name'] !== ''){
                $name = $_POST['name'];
                $errors['name'] = '';
            }
            elseif (isset($_POST['name']) && $_POST['name'] == ''){
                $name = '';
                $errors['name'] = 'Please give your name';
            }
            else{
                $name = '';
                $errors['name'] = '';
            }
            return $name;
        }
        private function getEmail(){
            if (isset($_POST['email']) && $_POST['email'] !== ''){
                $email = $_POST['email'];
                $errors['email'] = '';
            }
            elseif (isset($_POST['email']) && $_POST['email'] == ''){
                $email = '';
                $errors['email'] = 'Please give your email-address';
            }
            else{
                $email = '';
                $errors['email'] = '';
            }
            return $email;
        }
        private function getSubject(){
            if (isset($_POST['subject']) && $_POST['subject'] !== ''){
                $subject = $_POST['subject'];
                $errors['subject'] ='';
            }
            elseif (isset($_POST['subject']) && $_POST['subject'] == ''){
                $subject = '';
                $errors['subject'] = 'Please give a subject';

            }
            else{
                $subject = '';
                $errors['subject'] ='';
            }
            return $subject;
        }
        private function getMessage(){
            if (isset($_POST['message']) && $_POST['message'] !== ''){
                $message = $_POST['message'];
                $errors['message'] = '';
            }
            elseif (isset($_POST['message']) && $_POST['message'] == ''){
                $message = '';
                $errors['message'] = 'Please fill in your message';
            }
            else{
                $message = '';
                $errors['message'] = '';
            }
            return $message;
        }
        private function checkFilled(){
            $filled = 0;
            if (!empty($this->getName())){
                $filled++;
            }
            if (!empty($this->getEmail())){
                $filled++;
            }
            if (!empty($this->getSubject())){
                $filled++;
            }
            if (!empty($this->getMessage())){
                $filled++;
            }
            return $filled;
        }

    }
