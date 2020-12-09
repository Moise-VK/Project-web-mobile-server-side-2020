<?php
    class EventController extends BaseController {

        public function view () {
            echo $this->twig->render('/pages/events.twig', [
                'events' => $this->getEvents(),
                'locations' => $this->getAllLocations(),
                'minPrice' => $this->getMinPrice(),
                'maxPrice' => $this->getMaxPrice()
            ]);

        }

        public function search(){
            $term = isset($_GET['term']) ? $_GET['term'] : '';
            $location = isset($_GET['location']) ? $_GET['location'] : '';
            $price = isset($_GET['price']) ? intval($_GET['price']) : '';

            echo $this->twig->render('/pages/events.twig', [
                'events' => $this->filterEvents($term, $location, $price)
            ]);
        }

        public function detail (string $id) {
            echo $this->twig->render('/pages/detailEvent.twig', [
                'event' => $this->getDetailEvent($id)
            ]);

        }


        private function getMinPrice() : int {
            $getEvents = $this->db->prepare('SELECT * FROM events ORDER BY ticketprice_standard ASC LIMIT 1');
            $getEvents->execute();
            $data = $getEvents->fetchAllAssociative();

            return intval($data[0]['ticketprice_standard']);
        }

        private function getMaxPrice() : int {
            $getEvents = $this->db->prepare('SELECT * FROM events ORDER BY ticketprice_standard DESC LIMIT 1');
            $getEvents->execute();
            $data = $getEvents->fetchAllAssociative();

            return intval($data[0]['ticketprice_standard']);
        }

        private function getAllLocations()  {
            $getEvents = $this->db->prepare('SELECT DISTINCT location FROM events ORDER BY location ASC');
            $getEvents->execute();
            return $getEvents->fetchAllAssociative();

        }

        private function getEvents() : array{
            $events = $this->db->prepare('SELECT * FROM events ORDER BY begin_time ASC');
            $events->execute();
            return $this->convertArrayToEventModels($events->fetchAllAssociative());
        }

        private function getDetailEvent(string $id) {

            $getEvents = $this->db->prepare('SELECT * FROM events WHERE event_id = ?');
            $getEvents->execute(array($id));
            return $this->convertArrayToModel($getEvents->fetchAllAssociative()[0]);
        }

        private function composeQuery(string $term, string $location, int $price) : array {
            $baseQuery = 'SELECT * FROM events';
            $queryArgs = [];

            if($term || $location || $price) {
                $baseQuery .= ' WHERE ';
            }

            if($term){
                $baseQuery .= 'name LIKE ? ';
                $queryArgs[] = '%' . $term . '%';
            }

            if($location){
                $baseQuery .= $term? ' AND ' : '';
                $baseQuery .= 'location LIKE ?';
                $queryArgs[] = $location;
            }

            if($price){
                $baseQuery .= $term || $location ? ' AND ' : '';
                $baseQuery .= 'ticketprice_standard BETWEEN 0 AND ?';
                $queryArgs[] = intval($price);
            }
            return ['query' => $baseQuery, 'queryArgs' => $queryArgs];
        }

        private function filterEvents(string $term, string $location, int $price) : array {
            $composedQuery = $this->composeQuery($term, $location, $price);

            $getEvents = $this->db->prepare($composedQuery['query']);
            $getEvents->execute($composedQuery['queryArgs']);
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