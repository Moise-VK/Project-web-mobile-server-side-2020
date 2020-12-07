<?php
    class TestController extends BaseController {
        public function search(){
            $term = isset($_GET['term']) ? $_GET['term'] : '';
            $location = isset($_GET['location']) ? $_GET['location'] : '';
            $price = isset($_GET['price']) ? intval($_GET['price']) : '';

            echo $this->twig->render('/pages/events.twig', [
                'events' => $this->filterEvents($term, $location, $price)
            ]);
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