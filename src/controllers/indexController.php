<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!empty($_SESSION["id"])) {
  header("Location: accueil");
  exit();
}

$error = [];

if (!empty($_POST) && isset($_POST["login"])) {
  try {
    $user = new Models\User();

    if (empty($_POST["email"])) {
      throw new \Exception("L'email est requis");
    }

    if (empty($_POST["password"])) {
      throw new \Exception("Le mot de passe est requis");
    }

    $user->setEmail($_POST["email"]);

    $userData = $user->getUserByEmail();

    if ($userData) {
      $passwordMatch = password_verify(
        $_POST["password"],
        $userData->password_hash,
      );
      if ($passwordMatch) {
        $_SESSION["id"] = $userData->id;
        $_SESSION["username"] = $userData->username;
        $_SESSION["email"] = $userData->email;

        session_regenerate_id(true);

        header("Location: accueil");
        exit();
      } else {
        $error["global"] = "Email ou mot de passe incorrect";
      }
    } else {
      $error["global"] = "Email ou mot de passe incorrect";
    }
  } catch (\Exception $e) {
    $error["global"] = $e->getMessage();
  }
}

render("index", false, [
  "error" => $error,
]);
