<?php ob_start(); ?>

<div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="col-12 col-md-6 col-lg-4">
      <h1 class="mb-5 fw-bold text-center">Connexion</h1>

      <!-- Erreur globale -->
      <?php if (!empty($error["global"])): ?>
        <div class="alert alert-danger text-center">
          <?= htmlspecialchars($error["global"]) ?>
        </div>
      <?php endif; ?>

      <!-- Formulaire -->
      <form method="post">

        <div class="mb-4">
          <label for="email" class="form-label fw-bold">Email :</label>
          <input id="email" name="email" type="text" class="form-control">
        </div>

        <div class="mb-5">
          <label for="password" class="form-label fw-bold">Mot de passe :</label>
          <input id="password" name="password" type="password" class="form-control" required>
        </div>

        <div class="text-center">
          <button name="login" type="submit" class="fw-bold btn  btn-login">Se connecter</button>
        </div>

        <p class="text-center mt-4">
          Vous n’avez pas encore de compte ?
          <a href="/creation_account" class="fw-bold text-primary-custom">
            Créer un compte
          </a>
        </p>


      </form>
  </div>
</div>

<?php render("default", true, [
  "title" => "Connection",
  "css" => "index",
  "content" => ob_get_clean(),
]);
?>
