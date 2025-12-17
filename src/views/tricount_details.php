<?php ob_start(); ?>

<div class="container my-5">

    <!-- En-tête avec nom du tricount -->
    <div class="container my-5">
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="fw-bold mb-2">
                        <?= htmlspecialchars(
                          $tricount->name ?? "Nom du tricount",
                        ) ?>
                    </h1>
                    <p class="text-muted mb-0">
                        <?= "0" ?> participants
                    </p>
                </div>
                <a href="/add_expense?tricount_id=<?= $tricount->id ?? "" ?>"
                   class="btn btn-primary-custom">
                    + Nouvelle dépense
                </a>
            </div>
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

                    <?php if (!empty($expenses)): ?>
                        <?php foreach ($expenses as $expense): ?>
                            <div class="expense-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold">
                                            <?= htmlspecialchars(
                                              $expense["description"],
                                            ) ?>
                                        </h6>
                                        <small class="text-muted">
                                            Payé par <strong><?= htmlspecialchars(
                                              $expense["payer"],
                                            ) ?></strong>
                                            <span class="mx-2">•</span>
                                            <?= date(
                                              "d/m/Y",
                                              strtotime(
                                                $expense["created_at"] ?? "now",
                                              ),
                                            ) ?>
                                        </small>
                                    </div>
                                    <div class="text-end ms-3">
                                        <div class="expense-amount">
                                            <?= number_format(
                                              $expense["amount"],
                                              2,
                                              ",",
                                              " ",
                                            ) ?> €
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <p class="text-muted mb-0">
                                Aucune dépense pour le moment
                            </p>
                            <p class="text-muted small">
                                Commencez par ajouter votre première dépense
                            </p>
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
                    $total = array_sum(array_column($expenses ?? [], "amount"));
                    echo number_format($total, 2, ",", " ");
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

                    <?php if (!empty($balances)): ?>
                        <?php foreach ($balances as $balance): ?>
                            <div class="balance-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar">
                                            <?= strtoupper(
                                              substr(
                                                $balance["user_name"],
                                                0,
                                                1,
                                              ),
                                            ) ?>
                                        </div>
                                        <span class="fw-semibold">
                                            <?= htmlspecialchars(
                                              $balance["user_name"],
                                            ) ?>
                                        </span>
                                    </div>

                                    <?php if ($balance["amount"] > 0): ?>
                                        <span class="balance-badge balance-positive">
                                            +<?= number_format(
                                              $balance["amount"],
                                              2,
                                              ",",
                                              " ",
                                            ) ?> €
                                        </span>
                                    <?php elseif ($balance["amount"] < 0): ?>
                                        <span class="balance-badge balance-negative">
                                            <?= number_format(
                                              $balance["amount"],
                                              2,
                                              ",",
                                              " ",
                                            ) ?> €
                                        </span>
                                    <?php else: ?>
                                        <span class="balance-badge balance-neutral">
                                            0,00 €
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state-small">
                            <p class="text-muted mb-0 small">
                                Aucun solde à afficher
                            </p>
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
