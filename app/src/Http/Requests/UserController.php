<?php
    class UserController extends BaseController {
        public function showUserInfoPage () {
            echo $this->twig->render('/pages/users/userdetails.twig', [
                'user' => $this->getUserDetails(intval($_SESSION['user_id'])),
                'tickets' => $this->getTicketsInfo(intval($_SESSION['user_id'])),
                'countries' => $this->getCountries(),
                'firstname' => $_SESSION['firstName']
            ]);
        }
        public function updateData(){
            $this->setUserData(intval($_SESSION['user_id']));
            header('Location: /user/detail');
            exit();
        }


        private function getUserDetails (int $userID): User {
            $stmt = $this->db->prepare('SELECT * FROM users left JOIN user_data ON users.user_id = user_data.user_id WHERE users.user_id = ?');
            //$stmt->execute([2]);
            $stmt->execute([$userID]);
            $userData = $stmt->fetchAssociative();
            return $this->convertArrayToUserObj($userData);
        }

        private function convertArrayToUserObj (array $user): User {
            return new User($user['user_id'],
                $user['name'] != null ? $user['name'] : "",
                $user['last_name'] != null ? $user['last_name'] : "",
                $user['email'] != null ? $user['email'] : "",
                new Address($user['address'] != null ? $user['address'] : "",
                    $user['city'] != null ? $user['city'] : "",
                    $user['country'] != null ? $user['country'] : ""),
                $user['friends_invited'] != null ? $user['friends_invited'] : 0,
                $user['tickets_sold'] != null ? $user['tickets_sold'] : 0,
                $this->getSoldTickets(intval($user['user_id'])),
                $user['tickets_bought'] != null ? $user['tickets_bought'] : 0,
                $this->getBoughtTickets(intval($user['user_id']))
            );
        }

        private function getSoldTickets (int $userID): array {
            $stmt = $this->db->prepare('SELECT * FROM transactions WHERE seller_id = ?');
            $stmt->execute([$userID]);
            return $this->convertArrayToTransactions($stmt->fetchAllAssociative());
        }

        private function getBoughtTickets(int $userID) : array {
            $stmt = $this->db->prepare('SELECT * FROM transactions WHERE buyer_id = ?');
            $stmt->execute([$userID]);
            return $this->convertArrayToTransactions($stmt->fetchAllAssociative());
        }

        private function convertArrayToTransactions (array $transactionsArr): array {
            $transactions = [];
            foreach ($transactionsArr as $transaction) {
                $transactions[] = $this->convertToTransactionObj($transaction);
            }
            return $transactions;
        }

        private function convertToTransactionObj (array $transaction): Transaction {
            return new Transaction(
                $transaction['transaction_id'],
                $transaction['date_transaction'],
                $transaction['ticket_id'],
                $transaction['seller_id'],
                $transaction['buyer_id']
            );
        }

        private function getTicketsInfo (int $userID): array {
            $infoQuery = 'SELECT tickets.ticket_id as ticket_id, tickets.name as ticket_name, tickets.ticket_price as price, tickets.event_id as event_id, user_data.name as seller_name, user_data.last_name as seller_lastname, events.location as location, events.begin_time as start, transactions.date_transaction as buy_date FROM tickets 
INNER JOIN transactions on tickets.transaction_id = transactions.transaction_id 
INNER JOIN user_data on tickets.seller_id = user_data.user_id
INNER JOIN events on tickets.event_id = events.event_id
WHERE transactions.buyer_id = ?
ORDER BY transactions.date_transaction DESC LIMIT 3';
            $stmt = $this->db->prepare($infoQuery);
            $stmt->execute([$userID]);
            return $this->convertArrayToTicketInfo($stmt->fetchAllAssociative());
        }

        private function convertArrayToTicketInfo (array $ticketInfoArr): array {
            $ticketsInfo = [];
            foreach ($ticketInfoArr as $ticketInfo) {
                require_once $this->basePath . '../Models/TicketInfo.php';
                $ticketsInfo[] =  new TicketInfo(
                    $ticketInfo['ticket_id'],
                    $ticketInfo['ticket_name'],
                    $ticketInfo['price'],
                    $ticketInfo['event_id'],
                    $ticketInfo['seller_name'].' '.$ticketInfo['seller_lastname'],
                    $ticketInfo['location'],
                    $ticketInfo['start'],
                    $ticketInfo['buy_date']

                );
            }
            return $ticketsInfo;
        }

        private function setUserData (int $userID): void{
            $updateQuery = 'UPDATE user_data 
            SET name=?, last_name=?, address=?, city=?, country=?
            WHERE user_id=?';
            $updateUser = $this->db->prepare($updateQuery);
            $updateUser->execute(array($_POST['name'],$_POST['last_name'],$_POST['address'],$_POST['city'],$_POST['country'], $userID));

            $updateEmail = $this->db->prepare('UPDATE users SET email=? WHERE user_id=?');
            $updateEmail->execute(array($_POST['email'], $userID));
        }
    }