<?php

namespace App\Application\Models;

class UsersModel {
    private $table = "users";
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getById($id) {
        $sql = $this->db->prepare("select * from $this->table where id = :id");
        $sql->bindParam(':id', $id);
        $sql->execute();

        return $sql->fetch();
    }

    public function getByLogin($login) {
        $sql = $this->db->prepare("select * from $this->table where lower(login) = lower(:login)");
        $sql->bindValue(':login', $login);
        $sql->execute();

        return $sql->fetch();
    }

    public function updateLastLogin($id) {
        $sql = $this->db->prepare("update $this->table set last = NOW() where id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }
}