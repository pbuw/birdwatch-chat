<?php
header("Access-Control-Allow-Origin: *");
if (!empty($_GET)) {
    require "Handler.php";
    $handler = new Handler();
    $action = "die";
    if (isset($_GET["action"]) && !empty($_GET["action"])) {
        $action = $_GET["action"];
    }
    switch ($action) {
        case "add":
            $handler->add($_POST);
            break;
        case "get":
            $handler->get();
            break;
        default:
            die();

    }
} else {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Not Found</h1>";
    echo "The page that you have requested could not be found.";
    exit();
}