<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function(ContainerInterface $c) {
            $loggerSettings = $c->get('settings')['logger'];
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        }
    ]);

    $containerBuilder->addDefinitions([
        PDO::class => function(ContainerInterface $c) {
            $dbSettings = $c->get('settings')['db'];

            $host = $dbSettings['host'];
            $dbname = $dbSettings['database'];
            $username = $dbSettings['username'];
            $password = $dbSettings['password'];
            $charset = $dbSettings['charset'];
            $flags = $dbSettings['flags'];
            $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

            try {
                $pdo = new PDO($dsn, $username, $password);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Error in DB conn: ". $e->getMessage();
            }

            return $pdo;
        }
    ]);

    $containerBuilder->addDefinitions([
        PhpRenderer::class => function(ContainerInterface $c) {
            $viewSettings = $c->get('settings')['view'];

            return new PhpRenderer($viewSettings['path_templates']);
        }
    ]);
};
