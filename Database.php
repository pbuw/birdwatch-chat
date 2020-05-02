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
        echo $_SERVER['REMOTE_ADDR'];
        echo $connection->query("INSERT INTO `chat`(`message`, `ip`) VALUES ('" . trim(htmlspecialchars($message)) . "', '" . $_SERVER['REMOTE_ADDR'] . "')");
    }
}