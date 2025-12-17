<?php ob_start(); ?>

<div class="top-bar d-flex justify-content-between align-items-center">
    <div>Bonjour, <?= htmlspecialchars($_SESSION["username"])  ?></div>
    <div class="bg-white rounded-circle p-2" role="img" aria-label="Profil utilisateur">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#0d1fbf" class="bi bi-person-fill" viewBox="0 0 16 16" aria-hidden="true">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3z" />
            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
        </svg>
    </div>
</div>

<div class="container text-center mt-5">
    <button class="btn btn-main mb-4">Tricount</button>
    <div class="my-4"><!-- placeholder --></div>
</div>

<!-- Menu flottant (initialement caché) -->
<div id="fab-menu" class="fab-menu " role="menu" aria-label="Menu d'actions">
    <button class="btn btn-primary mb-2 w-100" role="menuitem">Nouveau tricount</button>
    <button class="btn btn-secondary w-100" role="menuitem">Rejoindre</button>
</div>
<div id="les-tricount">
    <?php if (empty($tricounts)): ?>
        <p class="text-center text-muted">Aucun tricount pour le moment. Créez-en un !</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($tricounts as $tricount): ?>
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($tricount->name) ?></h5>

                            <a href="/tricount/<?= $tricount->id ?>" class="btn btn-primary btn-sm">Voir</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>


</div>

<!-- Bouton + flottant -->
<div class="fab-wrapper">
    <a href="javascript:void(0)"
        class="fab"
        id="fab-toggle"
        role="button"
        aria-label="Ouvrir le menu d'actions"
        aria-expanded="false"
        aria-controls="fab-menu">+</a>
</div>
<!-- Modal pour créer un tricount -->
<div id="modal-overlay" class="modal-overlay">
    <div class="modal-content">
        <button class="modal-close" id="modal-close">&times;</button>
        <h2 class="mb-4">Nouveau Tricount</h2>
        <form id="form-tricount" method="post">
            <div class="mb-3">
                <label for="tricount-name" class="form-label">Nom du Tricount</label>
                <input type="text" class="form-control" id="tricount-name" placeholder="Ex: Voyage à Paris" name="username" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Créer le Tricount</button>
        </form>
    </div>
</div>


<?php render("default", true, [
    "title" => "accueil",
    "css" => "accueil",
    "js" => "accueil",
    "content" => ob_get_clean(),
]); ?>