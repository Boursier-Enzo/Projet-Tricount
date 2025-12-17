<?php

namespace Models;

use Exception;
use PDO;

class expense extends Database
{
    private $id;
    private $group_id;
    private $paid_by;
    private $title;
    private $amount;

    public function gettitle()
    {
        return $this->title;
    }


    public function settitle($value)
    {
        if (empty($value)) {
            throw new Exception("Le nom du tricount est requis");
        }

        $value = trim($value);

        if (strlen($value) < 3 || strlen($value) > 50) {
            throw new Exception(
                "Le nom du tricount doit contenir entre 3 et 50 caractères"
            );
        }

        $this->title = htmlspecialchars($value, ENT_QUOTES, "UTF-8");
    }
    public function getamount()
    {
        return $this->amount;
    }


    public function setamount($value)
    {
        if (empty($value)) {
            throw new Exception("sa ne peut pas etre egal a 0 voyons ");
        }
        if ($value < 0) {
            throw new Exception("sa ne peut pas etre negative non plus ");
        }
        $this->amount = $value;
    }
    public function getpaid_by()
    {
        return $this->paid_by;
    }


    public function setpaid_by($value)
    {
        if (empty($value)) {
            throw new Exception("L'ID utilisateur est requis");
        }
        $this->paid_by = (int)$value;
    }
    public function getgroup_id()
    {
        return $this->group_id;
    }


    public function setgroup_id($value)
    {
        if (empty($value)) {
            throw new Exception("L'ID utilisateur est requis");
        }
        $this->group_id = (int)$value;
    }
    public function register()
    {


        $query = $this->db->prepare(
            "INSERT INTO `expenses` (title, group_id,paid_by,amount) VALUES (:title, :group_id, :paid_by, :amount)"
        );

        $query->bindValue(":title", $this->title, PDO::PARAM_STR);
        $query->bindValue(":group_id", $this->group_id, PDO::PARAM_INT);
        $query->bindValue(":paid_by", $this->paid_by, PDO::PARAM_INT);
        $query->bindValue(":amount", $this->amount, PDO::PARAM_INT);

        return $query->execute();
    }
    public function getbygroup_id($groupId)
    {
        $query = $this->db->prepare(
            "SELECT * FROM `expenses` WHERE group_id = :group_id"
        );
        $query->bindValue(":group_id", (int)$groupId, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public function delete($groupId)
    {
        $query = $this->db->prepare(
            "DELETE FROM `expenses` WHERE id = :id"
        );
        $query->bindValue(":id", (int)$groupId, PDO::PARAM_INT);

        return $query->execute();
    }
<<<<<<< HEAD
    public function solde($groupId)
=======
    public function solde($groupId, $tableau)
>>>>>>> 2a18edd83d174de18e8bdb4a1358a620b2e82302
    {
        $query = $this->db->prepare(
            "SELECT SUM(amount) as total FROM `expenses` WHERE group_id = :group_id"
        );
        $query->bindValue(":group_id", (int)$groupId, PDO::PARAM_INT);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);

        return $result;
    }
}
