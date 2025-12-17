<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!empty($_SESSION["id"])) {
  header("Location: accueil");
  exit();
}

$error = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login"])) {
  $user = new Models\User();

  // EMAIL
  if (empty($_POST["email"])) {
    $error["email"] = "L'email est requis";
  } else {
    try {
      $user->setEmail($_POST["email"]);
    } catch (Exception $e) {
      $error["email"] = $e->getMessage();
    }
  }

  // PASSWORD
  if (empty($_POST["password"])) {
    $error["password"] = "Le mot de passe est requis";
  }

  // Si aucune erreur → vérification BDD
  if (empty($error)) {
    $userData = $user->getUserByEmail();

    if (!$userData) {
      $error["email"] = "Email ou mot de passe incorrect";
    } elseif (!password_verify($_POST["password"], $userData->password_hash)) {
      $error["password"] = "Email ou mot de passe incorrect";
    } else {
      $_SESSION["id"] = $userData->id;
      $_SESSION["username"] = $userData->username;
      $_SESSION["email"] = $userData->email;

      session_regenerate_id(true);
      header("Location: accueil");
      exit();
    }
  }
}

render("index", false, [
  "error" => $error,
]);
