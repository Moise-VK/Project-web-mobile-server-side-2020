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


    }
}