<?php ob_start(); ?>

<!-- Top bar originale -->
<div class="top-bar d-flex justify-content-between align-items-center">
    <div class="user-greeting">Bonjour, <?= htmlspecialchars(
      $_SESSION["username"],
    ) ?></div>
    <div class="bg-white rounded-circle p-2" role="img" aria-label="Profil utilisateur">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#047857" class="bi bi-person-fill" viewBox="0 0 16 16" aria-hidden="true">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3z" />
            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
        </svg>
    </div>
</div>

<!-- Contenu principal -->
<div class="container mt-5">
    <div class="page-title">
        <h1>Mes Tricounts</h1>
        <p>Gérez vos dépenses partagées simplement</p>
    </div>

    <!-- Liste des tricounts -->
    <div id="les-tricount">
        <?php if (empty($tricounts)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                </div>
                <h3>Aucun tricount</h3>
                <p>Créez votre premier tricount pour commencer à partager vos dépenses</p>
                <button class="btn" onclick="document.getElementById('modal-overlay').classList.add('active')">
                    Créer un tricount
                </button>
            </div>
        <?php else: ?>
            <div class="tricount-grid">
                <?php foreach ($tricounts as $tricount): ?>
                    <div class="tricount-card">
                        <div class="tricount-card-header">
                            <h5><?= htmlspecialchars($tricount->name) ?></h5>
                        </div>
                        <div class="tricount-card-body">
                            <form action="/tricount_details" method="POST">
                                <input type="hidden" name="id_group" value="<?= $tricount->id ?>">
                                <button type="submit" class="btn">Ouvrir le tricount</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Menu flottant -->
<div id="fab-menu" class="fab-menu" role="menu" aria-label="Menu d'actions">
    <button role="menuitem">📊 Nouveau tricount</button>
    <button role="menuitem">🔗 Rejoindre</button>
</div>

<!-- Bouton flottant -->
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
        <h2>Nouveau Tricount</h2>
        <form id="form-tricount" method="post">
            <div class="mb-3">
                <label for="tricount-name" class="form-label">Nom du Tricount</label>
                <input type="text"
                       class="form-control"
                       id="tricount-name"
                       placeholder="Ex: Voyage à Paris"
                       name="username"
                       required>
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
