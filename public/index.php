<?php

session_start();
// Session lifetime in seconds
$inactividad = 300;
if (isset($_SESSION["timeout"])){
    $sessionTTL = time() - $_SESSION["timeout"];
    if ($sessionTTL > $inactividad) {
        session_destroy();
        header("Location: /");
    }
}
// Start timeout for later check
$_SESSION["timeout"] = time();

// Start the backend
require __DIR__ . "/../src/Application/app.php";
