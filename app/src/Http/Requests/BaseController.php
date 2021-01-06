<?php
class BaseController
{

    /** @var DOCTRINE\dbal\Connection */
    protected $db;

    /** @var \Twig\Environment */
    protected $twig;

    protected $basePath = __DIR__ . '/../';
    public function __construct () {


        //connection with DB
        $connectionParams = [
            'host' => DB_HOST,
            'dbname' => DB_NAME,
            'user' => DB_USER,
            'password' => DB_PASS,
            'driver' => 'pdo_mysql',
            'charset' => 'utf8mb4'
        ];

        $this->db = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
        $this->db->connect();

        //Twig dependencies
        $loader = new \Twig\Loader\FilesystemLoader($this->basePath . '/../../resources/templates');
        $this->twig = new \Twig\Environment($loader);

        $this->mailer = new MailService(MAIL_SMTP, MAIL_PORT, MAIL_ENCRYPTION, MAIL_USERNAME, MAIL_PASSWORD);

        //$this->docGenerator = new DocGeneratorService();

    }

    protected function returnToOverview(string $overview){
        header("Location: /" . $overview);
        exit();
    }

    protected function convertArrayToEventModels(array $events) : array {
        $eventsAsModel= [];
        foreach ($events as $event) {
            $eventsAsModel[] = $this->convertArrayToModel($event);
        }
        return $eventsAsModel;
    }

    protected function convertArrayToModel(array $event) : Event {
        return new Event($event['event_id'], $event['name'], $event['ticketprice_standard'], $event['location'], $event['description'], $this->formatTime($event['begin_time']), $this->formatTime($event['end_time']));
    }

    protected function formatTime(string $data) : string {
        $dateTime = explode(' ', $data);
        $time = explode(':', $dateTime[1]);
        $date = join('/', array_reverse(explode('-', $dateTime[0])));
        $time = $time[0] . ':' . $time[1];

        return $date . ' ' . $time;
    }

    protected function getCountries(){
        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
        return $countries;
    }

    protected function getTickets (int $eventID): array{
        $getTicketQuery= 'SELECT tickets.ticket_id as ticket_id, tickets.name as ticket_name, tickets.ticket_price as ticket_price, tickets.amount as amount, tickets.sale_reason as sale_reason, tickets.event_id as event_id, tickets.seller_id as seller_id, user_data.name as sellerName, user_data.last_name as sellerLastname, tickets.ticket_type as ticket_type FROM tickets 
            INNER JOIN user_data on tickets.seller_id = user_data.user_id 
            WHERE event_id = ? AND tickets.transaction_id IS NULL';
        $getTickets = $this->db->prepare($getTicketQuery);
        $getTickets->execute(array($eventID));
        $ticketsArr = $getTickets->fetchAllAssociative();

        return $this->convertArrayToTicket($ticketsArr);
    }

    protected function convertArrayToTicket (array $ticketsArr): array{
        $tickets = [];
        foreach ($ticketsArr as $ticket){
            $tickets[] = new Ticket(
                $ticket['ticket_id'],
                $ticket['ticket_name'],
                $ticket['ticket_price'],
                $ticket['amount'],
                $ticket['sale_reason'],
                $ticket['event_id'],
                $ticket['seller_id'],
                $ticket['sellerName'] . ' ' . $ticket['sellerLastname'],
                $ticket['ticket_type'] != null ? $ticket['ticket_type'] : ''
            );
        }
        return $tickets;
    }
}