<?php

    class DownloadController extends BaseController {
        public function downloadTickets(int $transactionID) {
            $stmt = $this->db->prepare('SELECT * FROM transactions WHERE buyer_id = ? AND ticket_id = ?');
            $stmt->execute([
                $_SESSION['user_id'],
                $transactionID
            ]);

            $data = $stmt->fetchAssociative();

            if(count($data) != 0){
                $this->downloadTicket($data['ticket_id']);
                //$this->downloadStatement($data['transaction_id']);
            }
        }

        private function downloadTicket(int $ticketID) {
            $this->download($this->basePath . '/storage/tickets/' . $ticketID . '.pdf', 'ticket.pdf');
        }

        private function downloadStatement(int $transactionID) {
            $this->download($this->basePath . '/storage/transactions/' . $transactionID . '.txt', 'legalStatement.txt');
        }

        private function download(string $file, string $fileName) {
            $f = fopen($file, 'w');
            fseek($f, 0);
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Content-Transfer-Encoding: binary');
            header('Connection: Keep-Alive');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            fpassthru($f);
        }
    }