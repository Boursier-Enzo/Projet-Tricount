<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// 1. Récupération de l'ID (soit par POST direct, soit par SESSION)
if (isset($_POST["id_group"])) {
  $_SESSION["group_id"] = (int) $_POST["id_group"];
}

$groupId = $_SESSION["group_id"] ?? null;

if (!$groupId) {
  header("Location: /");
  exit();
}

// 2. Récupération des données du Tricount
$groupModel = new Models\Group();
$tricount = $groupModel->getGroupById($groupId);

// 3. Récupération des participants (via GroupMember)
$memberModel = new Models\Group_members();
$participants = $memberModel->getMembersByGroupId($groupId);

// On prépare les variables pour la vue
// (Les variables $expenses et $balances devront être calculées plus tard)
$expenses = [];
$balances = [];

render("tricount_details", false, [
  "tricount" => $tricount,
  "participants" => $participants,
  "expenses" => $expenses,
  "balances" => $balances,
]);
