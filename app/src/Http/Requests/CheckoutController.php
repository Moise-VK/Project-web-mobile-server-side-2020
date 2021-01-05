<?php

    class CheckoutController extends BaseController {
        public function showCheckout() {
            echo $this->twig->render('pages/checkout.twig' , [
                'firstname' => $_SESSION['firstName'],

                'fName' => isset($_POST['fName']) ? $_POST['fName'] : '',
                'lastName' => isset($_POST['lastName']) ? $_POST['lastName'] : '',
                'email' => $_SESSION['user'],
                'address' => isset($_POST['address']) ? $_POST['address'] : '',
                'number' => isset($_POST['number']) ? $_POST['number'] : '',
                'appNumber' => isset($_POST['appNumber']) ? $_POST['appNumber'] : '',
                'city' => isset($_POST['city']) ? $_POST['city'] : '',
                'postal' => isset($_POST['postal']) ? $_POST['postal'] : '',
                'country' => isset($_POST['country']) ? $_POST['country'] : '',

                'countries' => $this->getCountries(),

                'personalDetails' => $this->persData,
                'paymentDetails' => $this->finData,

                'paymentMethod' => ''
            ]);
        }

        private $persData = false;
        private $finData = false;

        private $fName  = '';
        private $lastName = '';
        private $email = '';
        private $address = '';
        private $number = '';
        private $appNumber = '';
        private $city = '';
        private $postal = '';
        private $country = '';
        private $tickets = '';

        public function processPersonalInformation() {
            $this->fName = isset($_POST['fName']) ? $_POST['fName'] : '';
            $this->lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
            $this->email = isset($_POST['email']) ? $_POST['email'] : '';
            $this->address = isset($_POST['address']) ? $_POST['address'] : '';
            $this->number = isset($_POST['number']) ? $_POST['number'] : '';
            $this->appNumber = isset($_POST['appNumber']) ? $_POST['appNumber'] : '';
            $this->city = isset($_POST['city']) ? $_POST['city'] : '';
            $this->postal = isset($_POST['postal']) ? $_POST['postal'] : '';
            $this->country = isset($_POST['country']) ? $_POST['country'] : '';
            //1,2,3 ( naar arr converteren) [1,2,3]
            $this->tickets = isset($_POST['tickets']) ? $_POST['tickets'] : '';

            if($this->fName && $this->lastName && $this->email && $this->address && $this->number && $this->city && $this->postal && $this->country){
                $this->persData = true;
                $this->mailer->sendMail([$_SESSION['user']],
                                        $this->mailer->composeSaleMail(),
                             'Ticket sold',
                                        $this->docGenerator->generateSaleDocument());
            } else {
                $this->persData = false;
            }
            $this->showCheckout();
        }

        public function processFinancial () {
            $this->finData = true;
            $this->showCheckout();
        }


    }