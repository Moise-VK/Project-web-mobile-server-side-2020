<?php

    class EventDataController extends BaseController {
        public function showAddScreen () {
            echo $this->twig->render('pages/createEventTicket.twig', [

            ]);
        }
    }