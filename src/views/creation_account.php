<?php ob_start(); ?>

<div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="col-12 col-md-6 col-lg-4">

        <h1 class="text-center mb-5 fw-bold">Créer un compte</h1>

        <?php if (!empty($error["global"])): ?>
            <div class="alert alert-danger" role="alert">
                <?= $error["global"] ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-4">
                <label class="form-label fw-bold">Identifiant</label>
                <input type="text" class="form-control <?= !empty(
                  $error["username"]
                )
                  ? "is-invalid"
                  : "" ?>"
                    placeholder="Votre identifiant" name="username"
                    value="<?= htmlspecialchars($_POST["username"] ?? "") ?>">
                <?php if (!empty($error["username"])): ?>
                    <div class="invalid-feedback"><?= $error[
                      "username"
                    ] ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Email</label>
                <input type="email" class="form-control <?= !empty(
                  $error["email"]
                )
                  ? "is-invalid"
                  : "" ?>"
                    placeholder="exemple@email.com" name="email"
                    value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
                <?php if (!empty($error["email"])): ?>
                    <div class="invalid-feedback"><?= $error["email"] ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Mot de passe</label>
                <input type="password" class="form-control <?= !empty(
                  $error["password"]
                )
                  ? "is-invalid"
                  : "" ?>"
                    placeholder="********" name="password">
                <?php if (!empty($error["password"])): ?>
                    <div class="invalid-feedback"><?= $error[
                      "password"
                    ] ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-5">
                <label class="form-label fw-bold">Vérifier mot de passe</label>
                <input type="password" class="form-control <?= !empty(
                  $error["password_confirm"]
                )
                  ? "is-invalid"
                  : "" ?>"
                    placeholder="********" name="password_confirm">
                <?php if (!empty($error["password_confirm"])): ?>
                    <div class="invalid-feedback"><?= $error[
                      "password_confirm"
                    ] ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="fw-bold btn btn-primary w-100">
                Créer un compte
            </button>
        </form>

        <p class="text-center mt-4">
          Vous avez déjà un compte ?
          <a href="/index" class="fw-bold text-primary-custom">
            Se connecter
          </a>
        </p>

    </div>
</div>

<script src="../assets/js/index.js"></script>

<?php render("default", true, [
  "title" => "Créer un compte",
  "css" => "creation_account",
  "content" => ob_get_clean(),
]);
?>
