<?php

    class UserController extends BaseController {
        public function showUserInfoPage () {
            echo $this->twig->render('/pages/users/userdetails.twig', [
                'user' => $this->getUserDetails(intval($_SESSION['user_id'])),
                'firstname' => $_SESSION['firstName']
            ]);
        }

        private function getUserDetails(int $userID) : User {
            $stmt = $this->db->prepare('SELECT * FROM users left JOIN user_data ON users.user_id = user_data.user_id WHERE users.user_id = ?');
            //$stmt->execute([2]);
            $stmt->execute([$userID]);
            $userData = $stmt->fetchAssociative();
            return $this->convertArrayToUserObj($userData);
        }

        private function convertArrayToUserObj(array $user) : User {
            return new User($user['user_id'],
                $user['name'] != Null ? $user['name'] : "",
                $user['last_name'] != Null ? $user['last_name'] : "",
                $user['email'] != Null ? $user['email'] : "",

                 new Address($user['address'] != Null ? $user['address'] : "",
                                $user['city'] != Null ? $user['city'] : "",
                             $user['country'] != Null ? $user['country'] : ""),

                $user['friends_invited'] != Null ? $user['friends_invited'] : 0,
                $user['tickets_sold'] != Null ? $user['tickets_sold'] : 0,
                $this->getSoldTickets(intval($user['user_id'])),
                $user['tickets_bought'] != Null ? $user['tickets_bought'] : 0,
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