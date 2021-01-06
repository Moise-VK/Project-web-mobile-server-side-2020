<?php
    require_once "BaseController.php";
    class IndexController extends BaseController {
        public function view(){
            echo $this->twig->render('/pages/index.twig',[
                'firstname' => isset($_SESSION['firstName']) ? $_SESSION['firstName'] : ''
            ]);
        }
    }
