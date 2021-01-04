<?php
    class UserController extends BaseController {
        public function showUserInfoPage () {
            echo $this->twig->render('/pages/users/userdetails.twig', [
                'user' => $this->getUserDetails(intval($_SESSION['user_id'])),
                'tickets' => $this->getTicketsInfo(intval($_SESSION['user_id'])),
                'countries' => $this->getCountries(),
                'firstname' => $_SESSION['firstName']
            ]);
        }
        public function updateData(){
            $this->setUserData(intval($_SESSION['user_id']));
            header('Location: /user/detail');
            exit();
        }


        private function getUserDetails (int $userID): User {
            $stmt = $this->db->prepare('SELECT * FROM users left JOIN user_data ON users.user_id = user_data.user_id WHERE users.user_id = ?');
            //$stmt->execute([2]);
            $stmt->execute([$userID]);
            $userData = $stmt->fetchAssociative();
            return $this->convertArrayToUserObj($userData);
        }

        private function convertArrayToUserObj (array $user): User {
            return new User($user['user_id'],
                $user['name'] != null ? $user['name'] : "",
                $user['last_name'] != null ? $user['last_name'] : "",
                $user['email'] != null ? $user['email'] : "",
                new Address($user['address'] != null ? $user['address'] : "",
                    $user['city'] != null ? $user['city'] : "",
                    $user['country'] != null ? $user['country'] : ""),
                $user['friends_invited'] != null ? $user['friends_invited'] : 0,
                $user['tickets_sold'] != null ? $user['tickets_sold'] : 0,
                $this->getSoldTickets(intval($user['user_id'])),
                $user['tickets_bought'] != null ? $user['tickets_bought'] : 0,
                $this->getBoughtTickets(intval($user['user_id']))
            );
        }

        private function getSoldTickets (int $userID): array {
            $stmt = $this->db->prepare('SELECT * FROM transactions WHERE seller_id = ?');
            $stmt->execute([$userID]);
            return $this->convertArrayToTransactions($stmt->fetchAllAssociative());
        }

        private function getBoughtTickets(int $userID) : array {
            $stmt = $this->db->prepare('SELECT * FROM transactions WHERE buyer_id = ?');
            $stmt->execute([$userID]);
            return $this->convertArrayToTransactions($stmt->fetchAllAssociative());
        }

        private function convertArrayToTransactions (array $transactionsArr): array {
            $transactions = [];
            foreach ($transactionsArr as $transaction) {
                $transactions[] = $this->convertToTransactionObj($transaction);
            }
            return $transactions;
        }

        private function convertToTransactionObj (array $transaction): Transaction {
            return new Transaction(
                $transaction['transaction_id'],
                $transaction['date_transaction'],
                $transaction['ticket_id'],
                $transaction['seller_id'],
                $transaction['buyer_id']
            );
        }

        private function getTicketsInfo (int $userID): array {
            $infoQuery = 'SELECT tickets.ticket_id as ticket_id, tickets.name as ticket_name, tickets.ticket_price as price, tickets.event_id as event_id, user_data.name as seller_name, user_data.last_name as seller_lastname, events.location as location, events.begin_time as start, transactions.date_transaction as buy_date FROM tickets 
INNER JOIN transactions on tickets.transaction_id = transactions.transaction_id 
INNER JOIN user_data on tickets.seller_id = user_data.user_id
INNER JOIN events on tickets.event_id = events.event_id
WHERE transactions.buyer_id = ?
ORDER BY transactions.date_transaction DESC LIMIT 3';
            $stmt = $this->db->prepare($infoQuery);
            $stmt->execute([$userID]);
            return $this->convertArrayToTicketInfo($stmt->fetchAllAssociative());
        }

        private function convertArrayToTicketInfo (array $ticketInfoArr): array {
            $ticketsInfo = [];
            foreach ($ticketInfoArr as $ticketInfo) {
                require_once $this->basePath . '../Models/TicketInfo.php';
                $ticketsInfo[] =  new TicketInfo(
                    $ticketInfo['ticket_id'],
                    $ticketInfo['ticket_name'],
                    $ticketInfo['price'],
                    $ticketInfo['event_id'],
                    $ticketInfo['seller_name'].' '.$ticketInfo['seller_lastname'],
                    $ticketInfo['location'],
                    $ticketInfo['start'],
                    $ticketInfo['buy_date']

                );
            }
            return $ticketsInfo;
        }

        private function getCountries(){
            $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
            return $countries;
        }

        private function setUserData (int $userID): void{
            $updateQuery = 'UPDATE user_data 
            SET name=?, last_name=?, address=?, city=?, country=?
            WHERE user_id=?';
            $updateUser = $this->db->prepare($updateQuery);
            $updateUser->execute(array($_POST['name'],$_POST['last_name'],$_POST['address'],$_POST['city'],$_POST['country'], $userID));

            $updateEmail = $this->db->prepare('UPDATE users SET email=? WHERE user_id=?');
            $updateEmail->execute(array($_POST['email'], $userID));
        }
    }