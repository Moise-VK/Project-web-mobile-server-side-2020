<?php

    class Ticket {
        private int $id;
        private string $name;
        private float $price;
        private int $amount;
        private string $reason;
        private int $eventID;
        private int $sellerID;

        /**
         * Ticket constructor.
         * @param int $id
         * @param string $name
         * @param float $price
         * @param int $amount
         * @param string $reason
         * @param int $eventID
         * @param int $sellerID
         */
        public function __construct (int $id, string $name, float $price, int $amount, string $reason, int $eventID, int $sellerID) {
            $this->id = $id;
            $this->name = $name;
            $this->price = $price;
            $this->amount = $amount;
            $this->reason = $reason;
            $this->eventID = $eventID;
            $this->sellerID = $sellerID;
        }

        /**
         * @return int
         */
        public function getId (): int {
            return $this->id;
        }

        /**
         * @return string
         */
        public function getName (): string {
            return $this->name;
        }

        /**
         * @return float
         */
        public function getPrice (): float {
            return $this->price;
        }

        /**
         * @return int
         */
        public function getAmount (): int {
            return $this->amount;
        }

        /**
         * @return string
         */
        public function getReason (): string {
            return $this->reason;
        }

        /**
         * @return int
         */
        public function getEventID (): int {
            return $this->eventID;
        }

        /**
         * @return int
         */
        public function getSellerID (): int {
            return $this->sellerID;
        }

        public function __toString() : string {
            return $this->id . ' ' . $this->name . ' ' . $this->price . ' ' . $this->amount . ' ' . $this->reason . ' ' . $this->eventID . ' ' . $this->sellerID;
        }


    }