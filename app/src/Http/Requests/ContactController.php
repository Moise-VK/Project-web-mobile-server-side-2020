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
                'filled' => $this->checkFilled(),
                'firstname' => isset($_SESSION['firstName']) ? $_SESSION : ''
            ]);

        }

        public function sendMail(){
            $this->view();
            if ($this->checkFilled() == 4){
                $this->mailer->sendMail([$this->getEmail()], $this->composeMailText($this->getName(), $this->getEmail(), $this->getSubject(), $this->getMessage()), '', 'Contactformulier website');
            }
        }

        private function composeMailText(string $name, string $email, string $subject, string $ogMessage) : string{
            $message = '<main>';
            $message .= '<h2>TicketSwap</h2>';
            $message .= '<p>Beste ' . $name . '</p>';
            $message .= '<p>Volgende gegevens zijn via het contactformulier aan ons verzonden.</p>';
            $message .= '<table><tr><td>Naam: </td> <td>' . $name . '</td></tr>';
            $message .= '<tr><td>Email: </td><td>' . $email . '</td></tr>';
            $message .= '<tr><td>Onderwerp: </td><td>' . $subject . '</td></tr>';
            $message .= '<tr><td>Bericht: </td><td>' . $ogMessage . '</td></tr></table>';
            $message .= '<p>Wij doen er alles aan om uw vraag zo spoedig mogelijk te beantwoorden.</p>';
            $message .= '<p>Met vriendelijke groet</p>';
            $message .= '<br><br><p>TicketSwap</p>';
            $message .= '</main>';

            return $message;
        }

        private function getName(){
            if (isset($_POST['name']) && $_POST['name'] !== ''){
                $name = $_POST['name'];
                $this->errors['name'] = '';
            }
            elseif (isset($_POST['name']) && $_POST['name'] == ''){
                $name = '';
                $this->errors['name'] = 'Gelieve uw naam in te vullen';
            }
            else{
                $name = '';
                $this->errors['name'] = '';
            }
            return $name;
        }

        private function getEmail(){
            if (isset($_POST['email']) && $_POST['email'] !== ''){
                $email = $_POST['email'];
                $this->errors['email'] = '';
            }
            elseif (isset($_POST['email']) && $_POST['email'] == ''){
                $email = '';
                $this->errors['email'] = 'Gelieve een mailadres in te vullen';
            }
            else{
                $email = '';
                $this->errors['email'] = '';
            }
            return $email;
        }

        private function getSubject(){
            if (isset($_POST['subject']) && $_POST['subject'] !== ''){
                $subject = $_POST['subject'];
                $this->errors['subject'] ='';
            }
            elseif (isset($_POST['subject']) && $_POST['subject'] == ''){
                $subject = '';
                $this->errors['subject'] = 'Gelieve een onderwerp in te geven';

            }
            else{
                $subject = '';
                $this->errors['subject'] ='';
            }
            return $subject;
        }

        private function getMessage(){
            if (isset($_POST['message']) && $_POST['message'] !== ''){
                $message = $_POST['message'];
                $this->errors['message'] = '';
            }
            elseif (isset($_POST['message']) && $_POST['message'] == ''){
                $message = '';
                $this->errors['message'] = 'Gelieve uw bericht in te vullen';
            }
            else{
                $message = '';
                $this->errors['message'] = '';
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
