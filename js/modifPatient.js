/**
 * Affiche un message de succès temporaire à l'utilisateur.
 */
function afficherMessage(type, message) {
    if (type === "erreur") {
        console.error("❌ Erreur :", message)
        alert("❌ " + message)
        return
    }

    let messageBox = document.createElement("div")
    messageBox.textContent = message
    Object.assign(messageBox.style, {
        position: "fixed",
        top: "20px",
        right: "20px",
        backgroundColor: "#4CAF50",
        color: "white",
        padding: "10px 20px",
        borderRadius: "5px",
        zIndex: "1000",
    })
    document.body.appendChild(messageBox)

    setTimeout(() => messageBox.remove(), 3000)
}

function gererFormulaires(formClass, actionUrl) {
    document.querySelectorAll(formClass).forEach(form => {
    form.addEventListener("submit", function (e) {
        e.preventDefault()

        let formData = new FormData(this)
        let idPatient = formData.get("idPatient")
        let champ = formData.get("champ")

        fetch(actionUrl, { method: "POST", body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.status === "confirm_required") {
                    afficherPopupConfirmation(data.ancien, data.nouveau, idPatient, champ)
                } else if (data.status === "success") {
                    fermerPopup(`popupModif${champ.charAt(0).toUpperCase() + champ.slice(1)}`)
                    location.reload()
                }
            })
        })
    })
}

/**
 * Ferme une popup donnée par son ID.
 */
function fermerPopup(idPopup) {
    let popup = document.getElementById(idPopup)
    if (popup) popup.style.display = "none"
}

/**
 * Ouvre une popup donnée par son ID.
 */
function ouvrirPopup(idPopup) {
    let popup = document.getElementById(idPopup)
    if (popup) popup.style.display = "block"
}

/**
 * Affiche la popup de confirmation pour un champ spécifique.
 */
function afficherPopupConfirmation(ancien, nouveau, idPatient, champ) {
    let popup = document.querySelector("#popupConfirmation")

    document.getElementById("popupConfirmationInfoPatientContent").innerHTML = `
        <h3>Confirmer la modification</h3>
        <p>"${ancien}" → "${nouveau}"</p>
        <input type="hidden" id="popupIdPatient" value="${idPatient}">
        <input type="hidden" id="popupChamp" value="${champ}">
        <input type="hidden" id="popupValeur" value="${nouveau}">
        <input type="hidden" id="popupDateRdv" value="${ancien}">
        <div class="d-flex justify-content-center mt-3" style="gap: 20px">
            <button class="btn btn-info" onclick="confirmerModification()">Confirmer</button>
            <button class="btn btn-danger" onclick="fermerPopup('popupConfirmation')">Annuler</button>
        </div>
    `
    popup.style.display = "block"
}

/**
 * Envoie la confirmation au serveur.
 */
function confirmerModification() {
    let formData = new FormData()
    let idPatient = document.getElementById("popupIdPatient").value
    let champ = document.getElementById("popupChamp").value
    let valeur = document.getElementById("popupValeur").value

    formData.append("idPatient", idPatient)
    formData.append("champ", champ)
    formData.append("valeur", valeur)

    // Déterminer l'action en fonction du champ ou de l'ID de la popup
    let actionUrl = "index.php?action=confirmerModificationPatient"  // Valeur par défaut

    fetch(actionUrl, { method: "POST", body: formData })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            fermerPopup("popupConfirmation")
            location.reload()
        } else {
            console.error("⚠ Erreur serveur :", data.message)
        }
    })
}
/**
 * Initialise les gestionnaires d'événements après le chargement de la page.
 */
document.addEventListener("DOMContentLoaded", () => {
    gererFormulaires(".infoPatientForm", "index.php?action=ajoutInfoPatient")
})



