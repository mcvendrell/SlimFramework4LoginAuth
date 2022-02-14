<?php

namespace App\Application\Models;

class RecordsModel {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function sendData($date, $value) {
        $sql = $this->db->prepare("INSERT INTO records (user, date, value) VALUES (:user, :date, :value)");
        $user = $_SESSION['user'];
        $sql->bindParam(':user', $user);
        $sql->bindParam(':date', $date);
        $sql->bindParam(':value', $value);
        $sql->execute();
    }
}