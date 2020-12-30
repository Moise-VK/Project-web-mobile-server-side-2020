<?php

    class Transaction {
        private int $transaction_id;
        private string $date;
        private int $ticket_id;
        private int $seller_id;
        private int $buyer_id;

        public function __construct (int $transaction_id, string $date, int $ticket_id, int $seller_id, int $buyer_id) {
            $this->transaction_id = $transaction_id;
            $this->date = $date;
            $this->ticket_id = $ticket_id;
            $this->seller_id = $seller_id;
            $this->buyer_id = $buyer_id;
        }

        /**
         * @return int
         */
        public function getTransactionId (): int {
            return $this->transaction_id;
        }

        /**
         * @return string
         */
        public function getDate (): string {
            return $this->date;
        }

        /**
         * @return int
         */
        public function getTicketId (): int {
            return $this->ticket_id;
        }

        /**
         * @return int
         */
        public function getSellerId (): int {
            return $this->seller_id;
        }

        /**
         * @return int
         */
        public function getBuyerId (): int {
            return $this->buyer_id;
        }



    }