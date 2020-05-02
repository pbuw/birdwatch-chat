<?php


class Handler {
    private $database;

    public function __construct() {
        require "Database.php";
        $this->$database = new Database();
    }

    public function add($post) {
        if (isset($post["message"]) && !empty($post["message"])) {
            $this->$database->add($this->badWordsFilter($post["message"]));
        }

    }

    public function get() {
        $result = $this->$database->get();
        $json = $this->convertToJson($result);
        header('Content-Type: application/json');
        echo $json;
    }

    private function convertToJson($data) {
        $array = [];
        while ($row = mysqli_fetch_assoc($data)) {
            $array[] = $row;
        }
        return json_encode($array);
    }

    private function badWordsFilter($message) {
        $bad_words = array(
            
        );

        return preg_replace('/(^|\b|\s)(' . implode('|', $bad_words) . ')(\b|\s|$)/i', "Vögeli", $message);
    }

}