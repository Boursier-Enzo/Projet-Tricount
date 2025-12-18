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

if (isset($_POST["valider_depense"])) {
  $depense = new Models\Expense();
  try {
    $depense->settitle($_POST["titre"]);
  } catch (\Exception $e) {
    $error["titre"] = $e->getMessage();
  }
  try {
    $depense->setamount($_POST["montant"]);
  } catch (\Exception $e) {
    $error["montant"] = $e->getMessage();
  }
  try {
    $depense->setgroup_id($_SESSION["group_id"]);
  } catch (\Exception $e) {
    $error["group_id"] = $e->getMessage();
  }
  try {
    $depense->setpaid_by($_SESSION["id"]);
  } catch (\Exception $e) {
    $error["id"] = $e->getMessage();
  }
  if (empty($error)) {
    try {
      if ($depense->register()) {
        redirectTo($_SERVER["REQUEST_URI"]);
        exit();
      } else {
        $error["global"] = 'Échec de l\'enregistrement';
      }
    } catch (\Exception $e) {
      $error["global"] = $e->getMessage();
    }
  }
}

if (isset($_POST["btnDelete"]) && isset($_POST["expense_id"])) {
  $expnsedlt = new Models\Expense();
  $expnsedlt->delete($_POST["expense_id"]);
}

if (isset($_SESSION["id"])) {
  $expnse = new Models\Expense();
  $lesexpense = $expnse->getbygroup_id($_SESSION["group_id"]);
  $la = $expnse->solde($_SESSION["group_id"]);
}

render("tricount_details", false, [
  "tricount" => $tricount,
  "participants" => $participants,
  "expenses" => $lesexpense,
  "balances" => $la,
]);
