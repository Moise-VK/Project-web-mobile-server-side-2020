<?php
    class Event {
        private int $id;
        private string $name;
        private float $price;
        private string $location;
        private string $description;
        private string $start_date;
        private string $end_date;

        public function __construct (int $id, string $name, float $price, string $location, string $description, string $start_date, string $end_date) {
            $this->id = $id;
            $this->name = $name;
            $this->price = $price;
            $this->location = $location;
            $this->description = $description;
            $this->start_date = $start_date;
            $this->end_date = $end_date;
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
         * @return string
         */
        public function getLocation (): string {
            return $this->location;
        }

        /**
         * @return string
         */
        public function getDescription (): string {
            return $this->description;
        }

        /**
         * @return string
         */
        public function getStartDate (): string {
            return $this->start_date;
        }

        /**
         * @return string
         */
        public function getEndDate (): string {
            return $this->end_date;
        }

        public function __toString() : string {
            return $this->id . ' ' . $this->name . ' ' . $this->price . ' ' . $this->location . ' ' . $this->description . ' ' . ' ' . $this->date . PHP_EOL;
        }

    }