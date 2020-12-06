<?php

    class AuthController extends BaseController {

        public function showLoginRegister(){
            $email = '';

            if(isset($_SESSION['user'])){
                $this->returnToOverview('home');
            }

            if(isset($_COOKIE['email'])){
                $email = $_COOKIE['email'];
            }
            if(isset($_GET['email'])){
                $email = $_GET['email'];
            }

            echo $this->twig->render('/pages/login.twig', [
                'error' => isset($_GET['error']),
                'email' => $email
            ]);
        }

        private function checkIfUserExists(string $email) : bool{
            $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $userData = $stmt->fetchAssociative();

            if(count($userData) > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function login() {
            $email = isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'login')) {
                if(count($userData) > 0 && password_verify($password, $userData['password']) == true){
                    $_SESSION['user'] = $email;

                    if (isset($_POST['remember'])) {
                        setcookie('email', $email, time() + 60 * 60 * 24 * 30);
                    }
                    $this->returnToOverview('home');
                } else {
                    $this->returnToOverview('login?error=true&email=' . $email);
                }

            }
        }

        private function equalPasswords(string $password, string $repeatPassword) : bool {
            if($password == $repeatPassword){
                return true;
            } else {
                return false;
            }
        }

        public function register(){
            $email = isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $repeatPassword = isset($_POST['repeatPassword']) ? trim($_POST['repeatPassword']) : '';

            if($email && $password && $this->equalPasswords($password, $repeatPassword) == true && isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'register')){
                if(!$this->checkIfUserExists($email)){
                    $stmt = $this->db->prepare('INSERT INTO users(email, password) VALUES(?,?)');
                    $stmt->execute([$email, password_hash($password, PASSWORD_DEFAULT)]);

                    //autoLogin after register
                    $_SESSION['user'] = $email;
                    $this->returnToOverview('home');
                } else {
                    var_dump('Dit is een test'); die();
                }
            } else {
                $this->returnToOverview('register?error=true&email=' . $email);
            }
        }

        public function logout(){
            session_destroy();
            $this->returnToOverview('home');
        }
    }