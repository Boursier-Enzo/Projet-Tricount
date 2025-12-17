<?php

namespace Models;

use Exception;
use PDO;

class Group_members extends Database
{
  public function getMembersByGroupId($groupId)
  {
    $query = $this->db->prepare(
      "SELECT u.id, u.username, u.email
       FROM users u
       INNER JOIN group_members gm ON u.id = gm.user_id
       WHERE gm.group_id = :group_id
       ORDER BY u.username ASC",
    );
    $query->bindValue(":group_id", $groupId, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_OBJ);
  }

  public function addMember($groupId, $userId)
  {
    // Vérifier si le membre existe déjà
    if ($this->isMember($groupId, $userId)) {
      throw new Exception("Ce membre fait déjà partie du groupe");
    }

    $query = $this->db->prepare(
      "INSERT INTO group_members(group_id, user_id) VALUES (:group_id, :user_id)",
    );
    $query->bindValue(":group_id", $groupId, PDO::PARAM_INT);
    $query->bindValue(":user_id", $userId, PDO::PARAM_INT);
    return $query->execute();
  }

  public function removeMember($groupId, $userId)
  {
    $query = $this->db->prepare(
      "DELETE FROM group_members WHERE group_id = :group_id AND user_id = :user_id",
    );
    $query->bindValue(":group_id", $groupId, PDO::PARAM_INT);
    $query->bindValue(":user_id", $userId, PDO::PARAM_INT);
    return $query->execute();
  }

  public function isMember($groupId, $userId)
  {
    $query = $this->db->prepare(
      "SELECT id FROM group_members WHERE group_id = :group_id AND user_id = :user_id",
    );
    $query->bindValue(":group_id", $groupId, PDO::PARAM_INT);
    $query->bindValue(":user_id", $userId, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch() !== false;
  }

  public function countMembers($groupId)
  {
    $query = $this->db->prepare(
      "SELECT COUNT(*) as count FROM group_members WHERE group_id = :group_id",
    );
    $query->bindValue(":group_id", $groupId, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    return $result->count ?? 0;
  }
}
