<?php


class Database {

    private function getConnection() {
    }

    public function get() {
        $connection = $this->getConnection();
        return $connection->query("SELECT * FROM chat ORDER BY id ");
    }

    public function add($message) {

        $connection = $this->getConnection();
        $this->checkSpam();
        $connection->query("INSERT INTO `chat`(`message`, `ip`) VALUES ('" . trim(htmlspecialchars($message)) . "', '" . $_SERVER['REMOTE_ADDR'] . "')");
    }

    private function checkSpam() {
        $date1 = new DateTime();
        $date2 = new DateTime();
        $minutes = 2;
        $interval = new DateInterval("PT15M");
        $interval->invert = 2;
        $date1->add(new DateInterval('PT' . $minutes . 'H'));
        $date1->add($interval);
        $date2->add(new DateInterval('PT' . $minutes . 'H'));
        $connection = $this->getConnection();
        $query = "SELECT * FROM chat WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "' AND datetime_created BETWEEN '" . $date1->format('Y-m-d H:i:s') . "' AND '" . $date2->format('Y-m-d H:i:s') . "'";
        $data = $connection->query($query);
        $array = [];
        while ($row = mysqli_fetch_assoc($data)) {
            $array[] = $row;
        }
        if (count($array) >= 10) {
            echo "SPAM RECOGNIZED";
            die();
        }
    }
}