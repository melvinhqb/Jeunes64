document.getElementById("monFormulaire").addEventListener("submit", function(e) {
    e.preventDefault();

    let nom = document.getElementById("nom").value;
    let prenom = document.getElementById("prenom").value;

    let formData = new FormData();
    formData.append("nom", nom);
    formData.append("prenom", prenom);

    fetch("enregistrer.php", {
        method: "POST",
        body: formData
    }).then(response => {
        if (response.ok) {
            alert("Données enregistrées avec succès !");
        } else {
            alert("Erreur lors de l'enregistrement des données.");
        }
    }).catch(error => {
        console.error("Erreur Fetch:", error);
    });
});
