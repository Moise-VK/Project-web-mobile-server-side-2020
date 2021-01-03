<?php

    class EventDataController extends BaseController {
        public function showAddScreen () {
            echo $this->twig->render('pages/createEventTicket.twig', [
                'firstname' => $_SESSION['firstName'],
                //EXISTING EVENT
                'exEventName' => isset($_POST['exEventName']) ? $_POST['exEventName'] : '',
                //NEW OR EXISTING
                'nox' => isset($_POST['typeEvent']) == 'new' ? 'new' : 'existing',
                //NEW EVENT
                'eventName' => isset($_POST['eventName']) ? $_POST['eventName'] : '',
                'eventLocation' => isset($_POST['eventLocation']) ? $_POST['eventLocation'] : '',
                'eventStartDate' => isset($_POST['eventStartDate']) ? $_POST['eventStartDate'] : '',
                'eventStartHour' => isset($_POST['eventStartHour']) ? $_POST['eventStartHour'] : '',
                'eventStartMinute' => isset($_POST['eventStartMinute']) ? $_POST['eventStartMinute'] : '',
                'eventEndDate' => isset($_POST['eventEndDate']) ? $_POST['eventEndDate'] : '',
                'eventEndHour' => isset($_POST['eventEndHour']) ? $_POST['eventEndHour'] : '',
                'eventEndMinute' => isset($_POST['eventEndMinute']) ? $_POST['eventEndMinute'] : '',
                'eventDescription' => isset($_POST['eventDescription']) ? $_POST['eventDescription'] : '',
                //NEW TICKET DATA
                'ticketName' => isset($_POST['ticketName']) ? $_POST['ticketName'] : '',
                'ticketPrice' => isset($_POST['ticketPrice']) ? $_POST['ticketPrice'] : '',
                'ticketAmount' => isset($_POST['ticketAmount']) ? $_POST['ticketAmount'] : '',
                'ticketReason' => isset($_POST['ticketReason']) ? $_POST['ticketReason'] : '',
                //EXISTING EVENT SEARCH
                'events' => isset($_POST['term']) ? $this->filterEvents($_POST['term']) : '',
                'term' => isset($_POST['term']) ? $_POST['term'] : ''
            ]);
        }

        private function checkInput($input) {
            return isset($input) ? $input : '';
        }

        public function createTicket() {
            $ticketName = isset($_POST['ticketName']) ? $_POST['ticketName'] : '';
            $ticketPrice = isset($_POST['ticketPrice']) ? $_POST['ticketPrice'] : '';
            $ticketAmount = isset($_POST['ticketAmount']) ? $_POST['ticketAmount'] : '';
            $ticketReason = isset($_POST['ticketReason']) ? $_POST['ticketReason'] : '';
            $exEventId = isset($_POST['exEventId']) ? $_POST['exEventId'] : '';

            $eventName = isset($_POST['eventName']) ? $_POST['eventName'] : '';
            $eventLocation = isset($_POST['eventLocation']) ? $_POST['eventLocation'] : '';
            $eventStartDate = isset($_POST['eventStartDate']) ? $_POST['eventStartDate'] : '';
            $eventStartHour = isset($_POST['eventStartHour']) ? $_POST['eventStartHour'] : '';
            $eventStartMinute = isset($_POST['eventStartMinute']) ? $_POST['eventStartMinute'] : '';
            $eventEndDate =  isset($_POST['eventEndDate']) ? $_POST['eventEndDate'] : '';
            $eventEndHour = isset($_POST['eventEndHour']) ? $_POST['eventEndHour'] : '';
            $eventEndMinute = isset($_POST['eventEndMinute']) ? $_POST['eventEndMinute'] : '';
            $eventDescription = isset($_POST['eventDescription']) ? $_POST['eventDescription'] : '';
            if(isset($_POST['typeEvent']) && $_POST['typeEvent'] == 'existing' && $_POST['moduleAction'] == 'createTicket'){
                $this->createNewTicket($exEventId, $ticketName, $ticketAmount, $ticketReason, $ticketPrice); // PRODUCTION
                $this->returnToOverview('/home');
            } else {
                $eventID = $this->createNewEvent($eventName, $eventLocation, $eventStartDate, $eventStartHour, $eventStartMinute, $eventEndDate, $eventEndHour, $eventEndMinute, $eventDescription, $ticketPrice);
                $this->createNewTicket($eventID, $ticketName, $ticketAmount, $ticketReason, $ticketPrice);
                $this->returnToOverview('/home');
            }
        }

        private function createNewEvent(string $eventName, string $eventLocation, string $eventStartDate, string $eventStartHour, string $eventStartMinute, string $eventEndDate, string $eventEndHour, string $eventEndMinute, string $eventDescription, string $ticketPrice) : int {
            if($eventName && $eventLocation && $eventStartDate && $eventStartHour && $eventStartMinute && $eventEndDate && $eventEndHour && $eventEndMinute && $eventDescription && $ticketPrice){
                $data = [
                    $eventName,
                    $ticketPrice,
                    $this->composeDateTimeString($eventStartDate, $eventStartHour, $eventStartMinute),
                    $this->composeDateTimeString($eventEndDate, $eventEndHour, $eventEndMinute),
                    $eventLocation,
                    $eventDescription
                ];
                return intval($this->createEventInDB($data));
            } else {
                $this->showAddScreen();
                return 0;
            }
        }

        private function composeDateTimeString(string $date, string $hour, string $minute) : string {
            return $date . ' ' . $hour . ':' . $minute;
        }

        private function createNewTicket($eventID, $name, $amount, $reason, $price) {
            if($name && $eventID && $amount && $reason && $price) {
                $data = [
                    $name,
                    $price,
                    $amount,
                    $reason,
                    $eventID,
                    $_SESSION['user_id']
                ];
                $this->createTicketInDB($data);
            } else {
                $this->showAddScreen();
            }
        }

        private function createEventInDB(array $data) : int{
            $stmt = $this->db->prepare('INSERT INTO events(name, ticketprice_standard, begin_time, end_time, location, description) VALUES (?,?,?,?,?,?)');
            $stmt->execute($data);
            return $this->db->lastInsertId();
        }

        private function createTicketInDB(array $data) {
            $stmt = $this->db->prepare('INSERT INTO tickets(name, ticket_price, amount, sale_reason, event_id, seller_id) VALUES (?,?,?,?,?,?)');
            $stmt->execute($data);
            $this->returnToOverview('home');
        }

        private function filterEvents(string $term) : array {
            $stmt = $this->db->prepare('SELECT * FROM events WHERE name LIKE ?');
            $stmt->execute(['%' . $term . '%']);
            return $this->convertArrayToEventModels($stmt->fetchAllAssociative());
        }
    }