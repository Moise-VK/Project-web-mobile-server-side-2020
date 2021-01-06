<?php

    class DocGeneratorService {

        /** @var DOCTRINE\dbal\Connection */
        protected $db;

        protected $basePath = __DIR__ . '/';

        public function __construct(){

            $connectionParams = [
                'host' => DB_HOST,
                'dbname' => DB_NAME,
                'user' => DB_USER,
                'password' => DB_PASS,
                'driver' => 'pdo_mysql',
                'charset' => 'utf8mb4'
            ];


            $this->db = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
            $this->db->connect();
        }
        public function genDocument($transactionID){
            $file = __DIR__ . '/' . '/../../storage/transactions/' . $transactionID . '.txt';
            $document = new SplFileObject($file, "w");
            $document->fwrite($this->composeDoc($this->getDocData($transactionID)));
        }

        private function composeDoc(array $docData): string{
            $document = 'TicketSwap' . PHP_EOL . PHP_EOL;
            $document .= $docData['ticketName'] .PHP_EOL . PHP_EOL;
            $document .= 'Hierbij verklaard Ticketswap dat dit ticket legaal is gekocht van de originele koper' . PHP_EOL;
            $document .= 'Dit ticket is gekocht door '.$docData['buyerName'] . PHP_EOL;
            $document .= 'De originele koper van dit ticket verkocht dit ticket omdat:' .PHP_EOL . PHP_EOL;
            $document .=  $docData['reason'] . PHP_EOL . PHP_EOL;
            $document .= 'Via aftersales@ticketswap.be kan u ons altijd bereiken' . PHP_EOL;
            $document .= 'Of surf naar www.ticketswap.be/contact' . PHP_EOL;
            $document .= 'Met vele groet het Ticketswap team' .PHP_EOL;
            $document .= 'Ondertekend' . PHP_EOL . PHP_EOL;
            $document .= 'Jonathan De Mangelaere, CEO Ticketswap' . PHP_EOL;

            return $document;
        }

        private function getDocData($transactionID){
            $getDocDataQuery = 'SELECT tickets.name as ticketName, CONCAT(user_data.name," ",user_data.last_name) as buyerName, tickets.name as ticketName, tickets.sale_reason as reason
            FROM transactions INNER JOIN user_data ON transactions.buyer_id = user_data.user_id
            INNER JOIN tickets ON transactions.ticket_id = tickets.ticket_id
            WHERE transactions.transaction_id = ?';
            $getDocData = $this->db->prepare($getDocDataQuery);
            $getDocData->execute(array($transactionID));

            return $getDocData->fetchAssociative();

        }

    }