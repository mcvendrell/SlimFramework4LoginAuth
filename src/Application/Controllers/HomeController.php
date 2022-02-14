<?php

namespace App\Application\Controllers;

use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

class HomeController {
    // Access to model that contains DB queries
    private $view;
    private $log;

    // Get the containers classes you need by Dependency Injection (PDO, Logger, etc)
    public function __construct(PhpRenderer $view, LoggerInterface $logger) {
        $this->view = $view;
        $this->log = $logger;
    }

    // Each menu must have:
    // page => the calling HTML page corresponding to that menu
    public function index($req, $res) {
        return $this->view->render($res, 'main.php', [
            "page" => "login.html"
        ]);
    }

    public function addData($req, $res) {
        return $this->view->render($res, 'main.php', [
            "page" => "addData.html"
        ]);
    }

}
