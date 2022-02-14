<?php

namespace App\Application\Controllers;

use App\Application\Models\RecordsModel;
use PDO;
use Psr\Log\LoggerInterface;

class RecordsController {
    // Access to model that contains DB queries
    private $model;
    private $log;

    // Get the containers classes you need by Dependency Injection (PDO, Logger, etc)
    public function __construct(PDO $pdo, LoggerInterface $logger) {
        // Instantiate a new model, passing DB conn
        $this->model = new RecordsModel($pdo);
        $this->log = $logger;
    }

    public function sendData($req, $res, $args) {
        $body = $req->getParsedBody();
        $date = $body['date'];
        $value = $body['value'];

        // Call the rigth method in the model
        $this->model->sendData($date, $value);
        //$this->log->info("Status: ". json_encode($status));

        // If INSERT fails, a PDOException will halt the program, so no need to check for OK because if we reach this point, it is ok
        return $res
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    }
}
