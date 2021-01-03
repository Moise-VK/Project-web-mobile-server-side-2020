<?php
    class MailService {

        protected $mailer;

        protected $basePath = __DIR__ . '/../';

        public function __construct (string $smtp, int $port, string $encryption, string $username, string $password) {
            $transport = (new Swift_SmtpTransport($smtp, $port, $encryption))
                ->setUsername($username)
                ->setPassword($password);

            $this->mailer = new Swift_Mailer($transport);
        }

        public function composeMailText() : string {
            $html = $this->composeMailHeader();
            $html .= $this->composeMailBody();

            return $html;
        }

        private function composeMailHeader() : string {
            $html = '<main>';
            return $html;
        }

        private function composeMailBody() : string {
            $html = '</main>';
            return '';

        }


        public function sendMail($to, $content, $attachments) {

            $message = (new Swift_Message('Contactformulier ticketswap'))
                ->setFrom(['jonathan@jon-it.be' => 'Ticketswap'])
                ->setTo($to)
                ->setBody($content)
                ->setContentType('text/html');

            $result = $this->mailer->send($message);
            var_dump($result);
        }
    }