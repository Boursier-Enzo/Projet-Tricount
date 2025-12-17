<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$error = [];
$tricounts = [];


$error = [];
if (!empty($_POST)) {
    $user = new Models\groups();

    try {
        $user->setName($_POST["username"]);
    } catch (\Exception $e) {
        $error["username"] = $e->getMessage();
    }
    try {
        $user->setCreatedBy($_SESSION["id"]);
    } catch (\Exception $e) {
        $error["username"] = $e->getMessage();
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
    $user = $user->getCreatedBy($_SESSION["id"]);
}
if (isset($_SESSION["id"])) {
    $group = new Models\groups();
    $tricounts = $group->getGroupsByUserId($_SESSION["id"]);
}



render("accueil", false, [
    "error" => $error,
    "tricounts" => $tricounts,
]);
