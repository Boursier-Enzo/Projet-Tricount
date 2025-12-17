function afficherFormulaire() {
    document.getElementById('formulaireDepense').style.display = 'block';
    document.getElementById('formulaireDepense').scrollIntoView({
        behavior: 'smooth'
    });
}

function masquerFormulaire() {
    document.getElementById('formulaireDepense').style.display = 'none';
}