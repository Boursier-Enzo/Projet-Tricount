<?php ob_start(); ?>

<div class="container my-5">

    <!-- En-tête avec nom du tricount -->
    <div class="container my-5">
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="fw-bold mb-2">
                        <?= htmlspecialchars($tricount->name ?? "Nom du tricount") ?>
                    </h1>
                    <p class="text-muted mb-0">
                        <?= count($participants ?? []) ?> participant(s)
                    </p>
                </div>
                <button type="button" class="btn btn-primary" onclick="afficherFormulaire()">
                    Ajouter des dépenses
                </button>
            </div>
        </div>
    </div>

    <!-- Formulaire d'ajout de dépense (caché par défaut) -->
    <div class="card mb-4" id="formulaireDepense" style="display: none;">
        <div class="card-body">
            <h5 class="card-title mb-3">Nouvelle dépense</h5>
            <form method="post">
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre de la dépense</label>
                    <input type="text" class="form-control" id="titre" name="titre" required placeholder="Ex: Restaurant">
                </div>

                <div class="mb-3">
                    <label for="montant" class="form-label">Montant (€)</label>
                    <input type="number" class="form-control" id="montant" name="montant" step="0.01" required placeholder="0.00">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success" name="valider_depense">
                        Valider
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="masquerFormulaire()">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">

        <!-- COLONNE GAUCHE : Dépenses -->
        <div class="col-lg-8">
            <div class="card-custom">
                <div class="card-header-custom">
                    <h5 class="fw-bold mb-0">Dépenses récentes</h5>
                </div>
                <div class="card-body-custom">
                    <?php if (!empty($expenses) && is_array($expenses)): ?>
                        <div class="list-group">
                            <?php foreach ($expenses as $expense): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h6 class="mb-1 fw-bold">
                                            <?= htmlspecialchars($expense->title) ?>
                                        </h6>
                                        <small class="text-muted">
                                            Payé par : Utilisateur #<?= $expense->paid_by ?>
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-primary fs-6">
                                            <?= number_format($expense->amount, 2, ',', ' ') ?> €
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1"></i>
                            <p class="mt-3">Aucune dépense enregistrée</p>
                            <small>Commencez par ajouter votre première dépense !</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- COLONNE DROITE : Soldes et Statistiques -->
        <div class="col-lg-4">

            <!-- Carte Statistiques -->
            <div class="card-stats mb-4">
                <h6 class="stats-label">Total des dépenses</h6>
                <h2 class="stats-amount">
                    <?php
                    $total = $balances->total ?? 0;
                    echo number_format($total, 2, ',', ' ');
                    ?> €
                </h2>
                <small class="stats-info">
                    <?= count($expenses ?? []) ?> dépense(s) enregistrée(s)
                </small>
            </div>

            <!-- Carte Soldes -->
            <div class="card-custom">
                <div class="card-header-custom">
                    <h5 class="fw-bold mb-0">Soldes</h5>
                </div>
                <div class="card-body-custom">
                    <?php if (!empty($participants) && is_array($participants)): ?>
                        <div class="list-group">
                            <?php
                            $totalDepenses = $balances->total ?? 0;
                            $nbParticipants = count($participants);
                            $partParPersonne = $nbParticipants > 0 ? $totalDepenses / $nbParticipants : 0;

                            foreach ($participants as $participant):
                                // Calculer ce que cette personne a payé
                                $totalPaye = 0;
                                if (!empty($expenses)) {
                                    foreach ($expenses as $expense) {
                                        if ($expense->paid_by == $participant->user_id) {
                                            $totalPaye += $expense->amount;
                                        }
                                    }
                                }

                                // Calculer le solde (ce qu'il a payé - sa part)
                                $solde = $totalPaye - $partParPersonne;
                            ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Participant #<?= $participant->user_id ?></strong>
                                        <br>
                                        <small class="text-muted">
                                            A payé: <?= number_format($totalPaye, 2, ',', ' ') ?> €
                                        </small>
                                    </div>
                                    <div>
                                        <?php if ($solde > 0): ?>
                                            <span class="badge bg-success">
                                                + <?= number_format($solde, 2, ',', ' ') ?> €
                                            </span>
                                        <?php elseif ($solde < 0): ?>
                                            <span class="badge bg-danger">
                                                <?= number_format($solde, 2, ',', ' ') ?> €
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">
                                                0,00 €
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-4">
                            <p>Aucun participant</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    </div>

</div>

<?php render("default", true, [
    "title" => "Détails du Tricount",
    "css" => "tricount_details",
    "js" => "tricount_details",
    "content" => ob_get_clean(),
]);
?>