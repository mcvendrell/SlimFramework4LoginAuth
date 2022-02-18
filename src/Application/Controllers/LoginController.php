<?php

namespace App\Application\Controllers;

use App\Application\Models\UsersModel;
use PDO;
use Psr\Log\LoggerInterface;

class LoginController {
    // Access to model that contains DB queries
    private $model;
    private $log;

    // Get the containers classes you need by Dependency Injection (PDO, Logger, etc)
    public function __construct(PDO $pdo, LoggerInterface $logger) {
        // Instantiate a new model, passing DB conn
        $this->model = new UsersModel($pdo);
        $this->log = $logger;
    }

    public function doLogin($req, $res, $args) {
        $body = $req->getParsedBody();
        $user = $body['user'];
        $pass = $body['pass'];

        //$this->log->info("user: ". $user . " pass: ". $pass);
        // Call the rigth method in the model to retrieve data
        $data = $this->model->getByLogin($user);
        //$this->log->info("Data: ". json_encode($data));
        
        // Check user pass
        if ($data) {
            if ($data['pass'] == $pass) {
                // Save session and continue process
                $_SESSION['user'] = $data['id'];
                
                $this->model->updateLastLogin($data['id']);

                return $res
                    ->withHeader('content-type', 'application/json')
                    ->withStatus(200);
            }
        }

        // Any other case, no valid session, send error
        unset($_SESSION["user"]);

        return $res
            ->withHeader('content-type', 'application/json')
            ->withStatus(403);
    }
}
