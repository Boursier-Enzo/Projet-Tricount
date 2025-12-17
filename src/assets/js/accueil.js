
document.addEventListener("DOMContentLoaded", () => {
    const toggleButton = document.getElementById("fab-toggle");
    const fabMenu = document.getElementById("fab-menu");
    const modalOverlay = document.getElementById("modal-overlay");
    const modalClose = document.getElementById("modal-close");
    const formTricount = document.getElementById("form-tricount");

    // Toggle du menu FAB
    toggleButton.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        const isActive = fabMenu.classList.toggle("active");

        toggleButton.textContent = isActive ? "×" : "+";
        toggleButton.setAttribute("aria-expanded", isActive);
    });

    // Ouvrir la modal "Nouveau tricount" - écouteur sur tout le menu
    fabMenu.addEventListener("click", (e) => {
        // Vérifier si c'est le bouton "Nouveau tricount" qui a été cliqué
        if (e.target.textContent.includes("Nouveau tricount") ||
            e.target.closest("button")?.textContent.includes("Nouveau tricount")) {
            modalOverlay.classList.add("active");
            fabMenu.classList.remove("active");
            toggleButton.textContent = "+";
            toggleButton.setAttribute("aria-expanded", "false");
        }
    });

    // Fermer la modal avec le bouton X
    if (modalClose) {
        modalClose.addEventListener("click", () => {
            modalOverlay.classList.remove("active");
        });
    }

    // Fermer la modal en cliquant sur l'overlay
    modalOverlay.addEventListener("click", (e) => {
        if (e.target === modalOverlay) {
            modalOverlay.classList.remove("active");
        }
    });

    // Fermer avec la touche Échap
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            if (modalOverlay.classList.contains("active")) {
                modalOverlay.classList.remove("active");
            } else if (fabMenu.classList.contains("active")) {
                fabMenu.classList.remove("active");
                toggleButton.textContent = "+";
                toggleButton.setAttribute("aria-expanded", "false");
            }
        }
    });



    // Fermer le menu FAB en cliquant en dehors
    document.addEventListener("click", (e) => {
        if (!fabMenu.contains(e.target) && e.target !== toggleButton) {
            fabMenu.classList.remove("active");
            toggleButton.textContent = "+";
            toggleButton.setAttribute("aria-expanded", "false");
        }
    });
});