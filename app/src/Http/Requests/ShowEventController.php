<?php
    class ShowEventController extends BaseController {

        public function view () {
            echo $this->twig->render('/pages/events.twig', [
                'events'=>$this->fillModelEvents()
            ]);

        }
        private function getEvents() {
            $queryEvents = 'SELECT * FROM events';

            $getEvents = $this->db->prepare($queryEvents);
            $getEvents->execute(array());
            $events = $getEvents->fetchAllAssociative();

            return $events;
        }
        private function fillModelEvents() {
            require_once $this->basePath . '/../Models/events.php';

            $eventsAsModel= [];
            foreach ($this->getEvents() as $event) {
                $eventsAsModel[] = new Event(
                    $event['event_id'],
                    $event['name'],
                    $event['ticketprice_standard'],
                    $event['location'],
                    $event['description'],
                    $event['link'],
                    $event['begin_time']
                );
            }
            return $eventsAsModel;
        }
    }