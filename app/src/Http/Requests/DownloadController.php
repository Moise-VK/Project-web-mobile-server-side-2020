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
                $this->downloadStatement($data['transaction_id']);
            }
        }

        private function downloadTicket(int $ticketID) {
            $this->download($this->basePath . '/../../storage/tickets/' . $ticketID . '.pdf', 'ticket.pdf', 'application/pdf');
        }

        private function downloadStatement(int $transactionID) {
            $this->download($this->basePath . '/../../storage/transactions/' . $transactionID . '.txt', 'legalStatement.txt', 'text/plain');
        }

        private function download(string $file, string $fileName, string $cType) {
            $f = fopen($file, 'r');
            fseek($f, 0);
            header('Content-Type: ' . $cType);
            header('Content-Disposition: attachment; filename="' . $fileName . '";');
            fpassthru($f);

        }
    }