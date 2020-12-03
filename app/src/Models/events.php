<?php
    class Event {
        private int $id;
        private string $name;
        private float $price;
        private string $location;
        private string $description;
        private string $link;
        private string $date;

        public function __construct (int $id, string $name, float $price, string $location, string $description, string $link, string $date) {
            $this->id = $id;
            $this->name = $name;
            $this->price = $price;
            $this->location = $location;
            $this->description = $description;
            $this->link = $link;
            $this->date = $date;
        }

        public function getId (): string {
            return $this->id;
        }

        public function getName (): string {
            return $this->name;
        }

        public function getPrice (): float {
            return $this->price;
        }

        public function getLocation (): string {
            return $this->location;
        }

        public function getDescr (): string {
            return $this->description;
        }

        public function getLink (): string {
            return $this->link;
        }

        public function getDate (): string {
            return $this->date;
        }

    }