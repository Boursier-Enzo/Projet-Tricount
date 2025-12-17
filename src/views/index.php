<?php ob_start(); ?>

<div class="container min-vh-100 d-flex justify-content-center align-items-center">
  <div class="col-12 col-md-6 col-lg-4">

    <h1 class="mb-5 fw-bold text-center">Connexion</h1>

    <form method="post" novalidate>

      <!-- EMAIL -->
      <div class="mb-4">
        <label class="form-label fw-bold">Email</label>
        <input
          type="email"
          name="email"
          class="form-control <?= !empty($error["email"])
            ? "is-invalid"
            : "" ?>"
          value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"
        >
        <?php if (!empty($error["email"])): ?>
          <div class="invalid-feedback">
            <?= $error["email"] ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- PASSWORD -->
      <div class="mb-5">
        <label class="form-label fw-bold">Mot de passe</label>
        <input
          type="password"
          name="password"
          class="form-control <?= !empty($error["password"])
            ? "is-invalid"
            : "" ?>"
        >
        <?php if (!empty($error["password"])): ?>
          <div class="invalid-feedback">
            <?= $error["password"] ?>
          </div>
        <?php endif; ?>
      </div>

      <button name="login" class="fw-bold btn btn-login w-100">
        Se connecter
      </button>

    </form>

    <p class="text-center mt-4">
      Vous n’avez pas encore de compte ?
      <a href="/creation_account" class="fw-bold text-primary-custom">
        Créer un compte
      </a>
    </p>

  </div>
</div>

<?php render("default", true, [
  "title" => "Connexion",
  "css" => "index",
  "content" => ob_get_clean(),
]); ?>
