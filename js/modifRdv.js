/**
* Fonction pour afficher un message de succès à l'utilisateur.
*/
function afficherMessageSucces(message) {
    let messageBox = document.createElement("div")
    messageBox.textContent = message
    messageBox.style.position = "fixed"
    messageBox.style.top = "20px"
    messageBox.style.right = "20px"
    messageBox.style.backgroundColor = "#4CAF50"
    messageBox.style.color = "white"
    messageBox.style.padding = "10px 20px"
    messageBox.style.borderRadius = "5px"
    messageBox.style.zIndex = "1000"
    document.body.appendChild(messageBox)
    
    setTimeout(() => {
        messageBox.remove()
    }, 3000)
}

function afficherMessageErreur(message) {
    console.error("Erreur : " + message)
    alert("❌ Erreur : " + message)
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

document.addEventListener("DOMContentLoaded", () => {
    const calendar = flatpickr("#datepicker", {
        locale: "fr",
        dateFormat: "Y-m-d",
        minDate: "today",
        disable: [],
        onChange: (selectedDates, dateStr) => {
            ouvrirPopup("popupChoixHoraires")
            document.getElementById("hiddenDate").value = dateStr
            fetchHorairesDisponibles(dateStr)
        },
        onMonthChange: (selectedDates, dateStr, instance) => {
            instance.set("disable", [])
            loadAvailableDays(instance)
        }
    })

    const loadAvailableDays = (instance) => {
    fetch("index.php?action=getJoursOuvert")
        .then(response => response.json())
        .then(data => {
            const validDates = new Set(data.map(date => new Date(date).toISOString().split("T")[0]))
            instance.set("disable", [(date) => !validDates.has(date.toISOString().split("T")[0])])
        })
        .catch(console.error)
    }

    const ouvrirPopup = (id) => document.getElementById(id).style.display = "block"
    window.fermerPopup = (id) => document.getElementById(id).style.display = "none"

    const fetchHorairesDisponibles = (dateRdv) => {
        fetch("index.php?action=getCreneaux", {
            method: "POST",
            body: new URLSearchParams({ hiddenDate: dateRdv })
        })
        .then(response => response.json())
        .then(data => {
            const horairesDisponibles = document.getElementById("horairesDisponibles")
            horairesDisponibles.innerHTML = ""
            horairesDisponibles.style.display = "flex"
            horairesDisponibles.style.flexWrap = "wrap"
            horairesDisponibles.style.gap = "10px"
            
            data.forEach((creneau, index) => {
                const label = document.createElement("label")
                label.style.cssText = "flex: 1 1 calc(33.33% - 10px); min-width: 100px; text-align: center; padding: 10px; border: 1px solid #ccc; border-radius: 5px; cursor: pointer; background-color: #252525"
                
                const input = document.createElement("input")
                input.type = "radio"
                input.name = "horaire"
                input.value = creneau
                input.id = `horaire_${index}`
                
                label.appendChild(input)
                label.appendChild(document.createTextNode(creneau))
                horairesDisponibles.appendChild(label)
            })
        })
        .catch(console.error)
    }

    loadAvailableDays(calendar)

    document.getElementById("ajoutHoraire").addEventListener("click", (event) => {
        event.preventDefault()
        const horaireSelectionne = document.querySelector("input[name='horaire']:checked")
        if (horaireSelectionne) {
            document.getElementById("hiddenTime").value = horaireSelectionne.value
            fermerPopup("popupChoixHoraires")
        }
    })

})
// 🔹 Événement sur le bouton d'ouverture du popup ajoutInteretCreche
function modifRdvFormulaire() {
    
    //fermeture de la popup et envoi des données
    const formModifRdv = document.getElementById("modifRdvForm")
    
    if (formModifRdv) {
        formModifRdv.addEventListener("submit", function (e) {
            e.preventDefault() // Empêcher le rechargement de la page par défaut
        
            // Récupérer les données du formulaire
            let formData = new FormData(this)
            console.log(formData)
        
            fetch("index.php?action=modifRendezVous", {
                method: "POST",
                body: formData
            })
            .then(response => {
                console.log("Réponse brute :", response)
            
                if (!response.ok) {
                    throw new Error(`Erreur HTTP : ${response.status}`)
                }
                return response.text()  // 🔥 Récupérer la réponse brute
            })
            .then(text => {
                console.log("Texte brut reçu :", text)
            
                try {
                    let jsonData = JSON.parse(text)
                    console.log("JSON parsé :", jsonData)
                    return jsonData
                } catch (error) {
                    console.error("❌ Erreur de parsing JSON :", error)
                    throw new Error("La réponse du serveur n'est pas un JSON valide : " + text)
                }
            })
            .then(data => {
                console.log("🟢 Réponse du serveur :", data) // Debug
                if (data.status === "success") {
                    fermerPopup("popupModifRendezVous")
                    afficherMessageSucces("Rendez-vous modifié")
                    window.location.reload(false)  // Rafraîchir la page
                } else {
                    console.error("❌ Erreur serveur :", data.message)
                    afficherMessageErreur(data.message)
                }
            })
            .catch(error => {
                console.error("❌ Problème avec la requête fetch :", error)
                afficherMessageErreur("Une erreur est survenue. Veuillez réessayer.")
            })
        })
    }
}

modifRdvFormulaire()
