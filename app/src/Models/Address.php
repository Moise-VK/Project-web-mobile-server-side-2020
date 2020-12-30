<?php

    class Address {
        private string $address;
        private string $city;
        private string $country;

        public function __construct (string $address, string $city, string $country) {
            $this->address = $address;
            $this->city = $city;
            $this->country = $country;
        }

        /**
         * @return string
         */
        public function getAddress (): string {
            return $this->address;
        }

        /**
         * @return string
         */
        public function getCity (): string {
            return $this->city;
        }

        /**
         * @return string
         */
        public function getCountry (): string {
            return $this->country;
        }

        public function __toString() : string {
            return $this->getAddress() . ' ' . $this->getCity() . ' ' . $this->getCountry();
        }
    }