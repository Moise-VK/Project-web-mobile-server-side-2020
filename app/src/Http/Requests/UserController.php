<?php

    class UserController extends BaseController {
        public function showUserInfoPage () {
            echo $this->twig->render('/pages/users/userdetails.twig', [
                'user' => $this->getUserDetails($_SESSION['user'])
            ]);
        }

        private function getUserDetails(string $userID) : User {
            $stmt = $this->db->prepare('SELECT * FROM users LEFT JOIN user_data ON users.user_id = user_data.user_id WHERE users.user_id = ?');
            $stmt->execute([intval($userID)]);
            return $this->convertArrayToUserObj($stmt->fetchAssociative());
        }

        private function convertArrayToUserObj(array $user) : User {                                        //int $tickets_sold, array $sold_tickets, int $tickets_bought, array $bought_tickets
            return new User($user['user_data.user_id'],
                $user['name'] != Null ? $user['name'] : "",
                $user['last_name'] != Null ? $user['last_name'] : "",
                $user['email'] != Null ? $user['email'] : "",
                new Address($user['address'], $user['city'], $user['country']),
                $user['friends_invited'] != Null ? $user['friends_invited'] : "",
                $user['tickets_sold'] != Null ? $user['tickets_sold'] : "",
                $this->getSoldTickets(intval($user['user_id'])),
                $user['tickets_bought'] != Null ? $user['tickets_bought'] : "",
                $this->getBoughtTickets(intval($user['user_id']))
            );
        }

        private function getSoldTickets(int $userID) : array {
            $stmt = $this->db->prepare('SELECT * FROM transactions WHERE seller_id = ?');
            $stmt->execute([$userID]);
            return $this->convertArrayToTransactions($stmt->fetchAllAssociative());
        }

        private function getBoughtTickets(int $userID) : array {
            $stmt = $this->db->prepare('SELECT * FROM transactions WHERE buyer_id = ?');
            $stmt->execute([$userID]);
            return $this->convertArrayToTransactions($stmt->fetchAllAssociative());
        }

        private function convertArrayToTransactions(array $transactionsArr) : array {
            $transactions = [];
            foreach ($transactionsArr as $transaction){
                $transactions[] = $this->convertToTransactionObj($transaction);
            }
            return $transactions;
        }

        private function convertToTransactionObj(array $transaction) : Transaction {
            return new Transaction(
                $transaction['transaction_id'],
                $transaction['date_transaction'],
                $transaction['ticket_id'],
                $transaction['seller_id'],
                $transaction['buyer_id']
            );
        }
    }