<?php

    class TicketInfo {
        private int $id;
        private string $name;
        private float $price;
        private int $eventID;
        private string $sellerName;
        private string $location;
        private string $start;
        private string $buyDate;

        /**
         * TicketInfo constructor.
         * @param int $id
         * @param string $name
         * @param float $price
         * @param int $eventID
         * @param string $sellerName
         * @param string $location
         * @param string $start
         * @param string $buyDate
         */
        public function __construct (int $id, string $name, float $price, int $eventID, string $sellerName, string $location, string $start, string $buyDate) {
            $this->id = $id;
            $this->name = $name;
            $this->price = $price;
            $this->eventID = $eventID;
            $this->sellerName = $sellerName;
            $this->location = $location;
            $this->start = $start;
            $this->buyDate = $buyDate;
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
        public function getEventID (): int {
            return $this->eventID;
        }

        /**
         * @return string
         */
        public function getSellerName (): string {
            return $this->sellerName;
        }

        /**
         * @return string
         */
        public function getLocation (): string {
            return $this->location;
        }

        /**
         * @return string
         */
        public function getStart (): string {
            return $this->start;
        }

        /**
         * @return string
         */
        public function getBuyDate (): string {
            $time = strtotime($this->buyDate);
            $format = new DateTime($this->buyDate);
            $today = new DateTime("now");

            $interval = date_diff($format, $today);
            return $interval->format('bought %R%a days ago');
        }

    }