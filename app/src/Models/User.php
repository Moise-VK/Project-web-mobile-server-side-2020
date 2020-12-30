<?php

    class User {
        private int $userID;
        private string $firstname;
        private string $lastname;
        private string $email;
        private Address $address;
        private int $friends_invited;
        private int $tickets_sold;
        private array $sold_tickets;
        private int $tickets_bought;
        private array $bought_tickets;

        public function __construct (int $userID, string $firstname, string $lastname, string $email, Address $address, int $friends_invited, int $tickets_sold, array $sold_tickets, int $tickets_bought, array $bought_tickets) {
            $this->userID = $userID;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            $this->email = $email;
            $this->address = $address;
            $this->friends_invited = $friends_invited;
            $this->tickets_sold = $tickets_sold;
            $this->sold_tickets = $sold_tickets;
            $this->tickets_bought = $tickets_bought;
            $this->bought_tickets = $bought_tickets;
        }

        /**
         * @return int
         */
        public function getUserID (): int {
            return $this->userID;
        }

        /**
         * @return string
         */
        public function getFirstname (): string {
            return $this->firstname;
        }

        /**
         * @return string
         */
        public function getLastname (): string {
            return $this->lastname;
        }

        /**
         * @return string
         */
        public function getEmail (): string {
            return $this->email;
        }

        /**
         * @return Address
         */
        public function getAddress (): Address {
            return $this->address;
        }

        /**
         * @return int
         */
        public function getFriendsInvited (): int {
            return $this->friends_invited;
        }

        /**
         * @return int
         */
        public function getTicketsSold (): int {
            return $this->tickets_sold;
        }

        /**
         * @return array
         */
        public function getSoldTickets (): array {
            return $this->sold_tickets;
        }

        /**
         * @return int
         */
        public function getTicketsBought (): int {
            return $this->tickets_bought;
        }

        /**
         * @return array
         */
        public function getBoughtTickets (): array {
            return $this->bought_tickets;
        }

        public function __toString() : string {
            return $this->userID . ' ' . $this->firstname . ' ' . $this->lastname . ' ' . $this->email . ' ' . $this->address . ' ' . $this->friends_invited . ' ' . $this->tickets_sold . ' ' . $this->tickets_bought . ' ' . $this->bought_tickets;
        }
    }