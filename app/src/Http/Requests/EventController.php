<?php
    class EventController extends BaseController {

        public function view () {
            echo $this->twig->render('/pages/events.twig', [
                'events' => $this->getEvents(),
                'locations' => $this->getAllLocations(),
                'minPrice' => $this->getMinPrice(),
                'maxPrice' => $this->getMaxPrice(),
                'firstname' => $_SESSION['firstName']
            ]);

        }

        public function search(){
            $term = isset($_GET['term']) ? $_GET['term'] : '';
            $location = isset($_GET['location']) ? $_GET['location'] : '';
            $price = isset($_GET['price']) ? intval($_GET['price']) : '';

            echo $this->twig->render('/pages/events.twig', [
                'events' => $this->filterEvents($term, $location, $price),
                'firstname' => $_SESSION['firstName']
            ]);
        }

        public function detail (string $id) {
            echo $this->twig->render('/pages/detailEvent.twig', [
                'event' => $this->getDetailEvent($id),
                'tickets' => $this->getTickets($id),
                'firstname' => $_SESSION['firstName']
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

        private function getTickets (int $eventID): array{
            $getTicketQuery= 'SELECT tickets.ticket_id as ticket_id, tickets.name as ticket_name, tickets.ticket_price as ticket_price, tickets.amount as amount, tickets.sale_reason as sale_reason, tickets.event_id as event_id, tickets.seller_id as seller_id, user_data.name as sellerName, user_data.last_name as sellerLastname, tickets.ticket_type as ticket_type FROM tickets 
            INNER JOIN user_data on tickets.seller_id = user_data.user_id 
            WHERE event_id = ? AND tickets.transaction_id IS NULL';
            $getTickets = $this->db->prepare($getTicketQuery);
            $getTickets->execute(array($eventID));
            $ticketsArr = $getTickets->fetchAllAssociative();

            return $this->convertArrayToTicket($ticketsArr);
        }

        private function convertArrayToTicket (array $ticketsArr): array{
            $tickets = [];
            foreach ($ticketsArr as $ticket){
                $tickets[] = new Ticket(
                    $ticket['ticket_id'],
                    $ticket['ticket_name'],
                    $ticket['ticket_price'],
                    $ticket['amount'],
                    $ticket['sale_reason'],
                    $ticket['event_id'],
                    $ticket['seller_id'],
                    $ticket['sellerName'].' '.$ticket['sellerLastname'],
                    $ticket['ticket_type']
                );
            }
            return $tickets;
        }
    }