<?php
    class MailService {

        protected $mailer;

        protected $basePath = __DIR__ . '/';

        public function __construct (string $smtp, int $port, string $encryption, string $username, string $password) {
            $transport = (new Swift_SmtpTransport($smtp, $port, $encryption))
                ->setUsername($username)
                ->setPassword($password);

            $this->mailer = new Swift_Mailer($transport);
        }


        public function sendMail($to, $content, $attachments, $mailSubject) {

            $message = (new Swift_Message($mailSubject))
                ->setFrom(['jonathan@jon-it.be' => 'Ticketswap'])
                ->setTo($to)
                ->setBody($content)
                ->setContentType('text/html');

            $result = $this->mailer->send($message);
        }


        public function sendTicketMail($to, $content, $attachments, $mailSubject) {
            $message = (new Swift_Message($mailSubject))
                ->setFrom(['jonathan@jon-it.be' => 'Ticketswap'])
                ->setTo($to)
                ->setBody($content)
                ->setContentType('text/html')
                ->attach(Swift_Attachment::fromPath(__DIR__ . '/' . '/../../storage/tickets/' . $attachments['ticket']))
                ->attach(Swift_Attachment::fromPath(__DIR__ . '/' . '/../../storage/transactions/' . $attachments['transaction']));
            $result = $this->mailer->send($message);
        }
    }