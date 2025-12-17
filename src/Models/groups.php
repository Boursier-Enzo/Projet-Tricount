<?php

namespace Models;

use Exception;
use PDO;

class groups extends Database
{
    private $id;
    private $name;
    private $created_by;


    public function getName()
    {
        return $this->name;
    }


    public function setName($value)
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

        $this->name = htmlspecialchars($value, ENT_QUOTES, "UTF-8");
    }


    public function getCreatedBy()
    {
        return $this->created_by;
    }


    public function setCreatedBy($value)
    {
        if (empty($value)) {
            throw new Exception("L'ID utilisateur est requis");
        }
        $this->created_by = (int)$value;
    }

    public function getGroupsByUserId($userId)
    {
        if (empty($userId)) {
            return [];
        }

        $query = $this->db->prepare(
            "SELECT * FROM `groups` WHERE created_by = :user_id ORDER BY id DESC"
        );
        $query->bindValue(":user_id", (int)$userId, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }


    public function getGroupById($groupId)
    {
        $query = $this->db->prepare(
            "SELECT * FROM `groups` WHERE id = :id"
        );
        $query->bindValue(":id", (int)$groupId, PDO::PARAM_INT);
        $query->execute();

        return $query->fetch(PDO::FETCH_OBJ);
    }


    public function isOwner($groupId, $userId)
    {
        $query = $this->db->prepare(
            "SELECT COUNT(*) as count FROM `groups` WHERE id = :group_id AND created_by = :user_id"
        );
        $query->bindValue(":group_id", (int)$groupId, PDO::PARAM_INT);
        $query->bindValue(":user_id", (int)$userId, PDO::PARAM_INT);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result->count > 0;
    }


    public function register()
    {
        if (empty($this->name) || empty($this->created_by)) {
            throw new Exception("Le nom et l'ID du créateur sont requis");
        }

        $query = $this->db->prepare(
            "INSERT INTO `groups` (name, created_by) VALUES (:name, :created_by)"
        );

        $query->bindValue(":name", $this->name, PDO::PARAM_STR);
        $query->bindValue(":created_by", $this->created_by, PDO::PARAM_INT);

        return $query->execute();
    }


    public function updateName($groupId)
    {
        if (empty($this->name)) {
            throw new Exception("Le nom du tricount est requis");
        }

        $query = $this->db->prepare(
            "UPDATE `groups` SET name = :name WHERE id = :id"
        );

        $query->bindValue(":name", $this->name, PDO::PARAM_STR);
        $query->bindValue(":id", (int)$groupId, PDO::PARAM_INT);

        return $query->execute();
    }


    public function delete($groupId)
    {
        $query = $this->db->prepare(
            "DELETE FROM `groups` WHERE id = :id"
        );
        $query->bindValue(":id", (int)$groupId, PDO::PARAM_INT);

        return $query->execute();
    }
}
