<?php

namespace Models;

use Exception;
use PDO;

class User extends Database
{
    private $id;
    private $username;
    private $email;
    private $password_hash;

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($value)
    {
        if (empty($value)) {
            throw new Exception("Le nom d'utilisateur est requis");
        }

        $value = trim($value);

        if (strlen($value) < 3 || strlen($value) > 10) {
            throw new Exception(
                "Le nom d'utilisateur doit contenir entre 3 et 10 caractères",
            );
        }
        if (!preg_match('/^[a-zA-Z0-9]+$/', $value)) {
            throw new Exception(
                "Le nom d'utilisateur ne peut contenir que des lettres et des chiffres",
            );
        }

        $this->username = htmlspecialchars($value, ENT_QUOTES, "UTF-8");
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($value)
    {
        if (empty($value)) {
            throw new Exception("L'email est requis");
        }

        $value = trim($value);

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Adresse email invalide");
        }

        $this->email = htmlspecialchars($value, ENT_QUOTES, "UTF-8");
    }

    public function setPassword($value)
    {
        if (empty($value)) {
            throw new Exception("Le mot de passe est requis");
        }
        if (strlen($value) < 8) {
            throw new Exception(
                "Le mot de passe doit contenir au moins 8 caractères",
            );
        }

        $this->password_hash = password_hash($value, PASSWORD_DEFAULT);
    }

    public function getPassword()
    {
        return $this->password_hash;
    }

    public function getUserByEmail()
    {
        $query = $this->db->prepare(
            "SELECT * FROM users WHERE email = :email LIMIT 1",
        );
        $query->bindValue(":email", $this->email, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function register()
    {
        $checkEmail = $this->db->prepare(
            "SELECT id FROM users WHERE email = :email",
        );
        $checkEmail->bindValue(":email", $this->email, PDO::PARAM_STR);
        $checkEmail->execute();

        if ($checkEmail->fetch()) {
            throw new Exception("Cet email est déjà utilisé");
        }

        $queryExecute = $this->db->prepare(
            "INSERT INTO users(username, email, password_hash) VALUES (:username, :email, :password_hash)",
        );

        $queryExecute->bindValue(":username", $this->username, PDO::PARAM_STR);
        $queryExecute->bindValue(":email", $this->email, PDO::PARAM_STR);
        $queryExecute->bindValue(
            ":password_hash",
            $this->password_hash,
            PDO::PARAM_STR,
        );

        return $queryExecute->execute();
    }
}
