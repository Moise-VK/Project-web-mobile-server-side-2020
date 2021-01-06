<?php

    class DocGeneratorService {

        /**
         * @var \Doctrine\DBAL\Connection
         */
        protected \Doctrine\DBAL\Connection $db;


        public function __construct(){
            require_once '/../functions.php';
            $this->db = getDBConnection();

        }
        public function genDocument($transactionID){
            $file = '/../../storage/transaction/'.$transactionID.'.html';
            $document = new SplFileObject($file, "w");
            $document->fwrite($this->composeDoc($this->getDocData($transactionID)));
        }

        private function composeDoc(array $docData): string{

            $document = '<main>';
            $document .= '<h2>TicketSwap</h2>';
            $document .= '<h3>'. $docData['ticketName'] .'</h3>';
            $document .= '<p>Hierbij verklaard Ticketswap dat dit ticket legaal is gekocht van de originele koper</p>';
            $document .= '<p>Dit ticket is gekocht door '.$docData['buyerName'].'</p>';
            $document .= '<p>De originele koper van dit ticket verkocht dit ticket omdat:</p>';
            $document .= '<p><i>'. $docData['reason'] .'</i></p>';
            $document .= '<p><a href="http://localhost:8080/contact">Klik hier</a> om contact op te nemen met ons</p>';
            $document .= '<p>Of surf naar www.ticketswap.be/contact</p>';
            $document .= '<p>Met vele groet het Ticketswap team</p>';
            $document .= '<br><br><p>Ondertekend</p>';
            $document .= '<p>Jonathan De Mangelaere, CEO Ticketswap</p>';
            $document .= '</main>';

            return $document;
        }

        private function getDocData($transactionID){
            $getDocDataQuery = 'SELECT tickets.name as ticketName, CONCAT(user_data.name," ",user_data.last_name) as buyerName, tickets.name as ticketName, tickets.sale_reason as reason
            FROM transactions INNER JOIN user_data ON transactions.buyer_id = user_data.buyer_id
            INNER JOIN tickets ON transactions.ticket_id = tickets.ticket_id
            WHERE transactions.transaction_id = ?';
            $getDocData = $this->db->prepare($getDocDataQuery);
            $getDocData->execute(array($transactionID));

            return $getDocData->fetchAssociative();

        }

    }