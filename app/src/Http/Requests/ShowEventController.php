<?php
    class ShowEventController extends BaseController {

        public function overview () {
            $events = $this->getEvents();
            echo $this->twig->render('/pages/events.twig', [
                'events' => $this->getEvents()
            ]);

        }
        public function detail () {
            echo $this->twig->render('/pages/detailEvent.twig', [
                'events' => $this->getEvents()
            ]);

        }
        private function getEvents() {
            if (isset($_GET['id'])){
                $id = $_GET['id'];
            }
            else{
                $id = '%';
            }
            $getEvents = $this->db->prepare('SELECT * FROM events WHERE event_id like ? ORDER BY begin_time ASC');
            $getEvents->execute(array($id));
            return $this->convertArrayToEventModels($getEvents->fetchAllAssociative());
        }
        private function convertArrayToEventModels(array $events) : array {
            $eventsAsModel= [];
            foreach ($events as $event) {
                $eventsAsModel[] = $this->convertArrayToModel($event);
            }
            return $eventsAsModel;
        }

        private function formatTime(string $data) : string {
            $dateTime = explode(' ', $data);
            $time = explode(':', $dateTime[1]);
            $date = join('/', array_reverse(explode('-', $dateTime[0])));
            $time = $time[0] . ':' . $time[1];

            return $date . ' ' . $time;
        }

        private function convertArrayToModel(array $event) : Event {
            require_once $this->basePath . '/../Models/Event.php';
            return new Event($event['event_id'], $event['name'], $event['ticketprice_standard'], $event['location'], $event['description'], $this->formatTime($event['begin_time']), $this->formatTime($event['end_time']));
        }
    }