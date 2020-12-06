<?php
    class ShowEventController extends BaseController {

        public function view () {
            $events = $this->getEvents();
            echo $this->twig->render('/pages/events.twig', [
                'events' => $this->getEvents()
            ]);

        }
        private function getEvents() {
            $getEvents = $this->db->prepare('SELECT * FROM events ORDER BY begin_time ASC');
            $getEvents->execute();
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
            return new Event($event['event_id'], $event['name'], $event['ticketprice_standard'], $event['location'], $event['description'], $this->formatTime($event['begin_time']), $this->formatTime($event['end_time']));
        }
    }