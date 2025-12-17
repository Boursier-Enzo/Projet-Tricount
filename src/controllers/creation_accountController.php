<?php
if (!empty($_SESSION["id"])) {
  header("Location: accueil");
  exit();
}

$error = [];

if (!empty($_POST)) {
  $user = new Models\User();

  try {
    $user->setUsername($_POST["username"]);
  } catch (\Exception $e) {
    $error["username"] = $e->getMessage();
  }

  try {
    $user->setEmail($_POST["email"]);
  } catch (\Exception $e) {
    $error["email"] = $e->getMessage();
  }

  if ($_POST["password"] == $_POST["password_confirm"]) {
    try {
      $user->setPassword($_POST["password"]);
    } catch (\Exception $e) {
      $error["password"] = $e->getMessage();
      $error["password_confirm"] = $e->getMessage();
    }
  }

  if (empty($error)) {
    try {
      if ($user->register()) {
        redirectTo("/");
      } else {
        $error["global"] = 'Échec de l\'enregistrement';
      }
    } catch (\Exception $e) {
      $error["global"] = $e->getMessage();
    }
  }
}

render("creation_account", false, [
  "error" => $error,
]);
