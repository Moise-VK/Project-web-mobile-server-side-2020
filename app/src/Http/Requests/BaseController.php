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
}