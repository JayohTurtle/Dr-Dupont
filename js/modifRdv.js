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
function ouvrirPopup(idPopup, id = null, nom = '', prenom = '', dateRdv = '', soin = '') {
    const popup = document.getElementById(idPopup)
    if (!popup) return

    popup.style.display = "block"

    if (idPopup === "popupModifRendezVous" && id !== null) {
        const form = document.getElementById("modifRdvForm")
        form.querySelector('input[name="idRendezVous"]').value = id
        form.querySelector('input[name="nom"]').value = nom
        form.querySelector('input[name="prenom"]').value = prenom
        form.querySelector('input[name="dateRdv"]').value = dateRdv

        const select = form.querySelector('select[name="soin"]')
        Array.from(select.options).forEach(opt => {
            opt.selected = opt.value === soin
        })
    }

    if (idPopup === "popupSupprimRendezVous" && id !== null) {
        const form = document.getElementById("supprimRdvForm")
        form.querySelector('input[name="idRendezVous"]').value = id

        // Mise à jour du texte affiché dans la popup (nom, prénom, date, heure)
        const patientInfo = form.querySelector("h6")
        if (patientInfo) patientInfo.textContent = `${prenom} ${nom}`

        const dateInfo = form.querySelector("p")
        if (dateInfo) dateInfo.textContent = `Le ${formatDateFr(dateRdv)}`
    }
}

// Fonctions utilitaires
function formatDateFr(dateStr) {
    const d = new Date(dateStr)
    return d.toLocaleDateString("fr-FR")
}

function getHeureFromDate(dateStr) {
    const d = new Date(dateStr)
    return d.toLocaleTimeString("fr-FR", { hour: '2-digit', minute: '2-digit' })
}

document.addEventListener("DOMContentLoaded", () => {
    // Fonction 1 : ouvrir popup
    const ouvrirPopup = (id) => document.getElementById(id).style.display = "block"
    window.fermerPopup = (id) => document.getElementById(id).style.display = "none"

    // Fonction 2 : charger les jours disponibles
    const loadAvailableDays = (instance) => {
        fetch("index.php?action=getJoursOuvert")
            .then(response => response.json())
            .then(data => {
                const validDates = new Set(data.map(date => new Date(date).toISOString().split("T")[0]))
                instance.set("disable", [(date) => !validDates.has(`${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`)])
            })
            .catch(console.error)
    }

    // Fonction 3 : récupérer les horaires disponibles
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

    // Fonction 4 : initialisation des calendriers
    const initFlatpickr = (selector) => {
        return flatpickr(selector, {
            locale: "fr",
            dateFormat: "Y-m-d",
            minDate: "today",
            disable: [],
            onChange: (selectedDates, dateStr, instance) => {
            document.getElementById("sourceContext").value = 
                instance.input.id === "datepicker" ? "modif" : "ajout"
        
            ouvrirPopup("popupChoixHoraires")
            document.getElementById("hiddenDate").value = dateStr
            fetchHorairesDisponibles(dateStr)
            },
            
            onMonthChange: (selectedDates, dateStr, instance) => {
                instance.set("disable", [])
                loadAvailableDays(instance)
            }
        });
    }

    // Initialisation des deux calendriers
    const calendar1 = initFlatpickr("#datepicker");
    const calendar2 = initFlatpickr("#newDatepicker");

    if (calendar1 && typeof calendar1.set === "function") {
        loadAvailableDays(calendar1);
    }

    if (calendar2 && typeof calendar2.set === "function") {
        loadAvailableDays(calendar2);
    }

    // Bouton "ajouter horaire"
    document.getElementById("ajoutHoraire").addEventListener("click", (event) => {
        event.preventDefault()
        const horaireSelectionne = document.querySelector("input[name='horaire']:checked")
        const source = document.getElementById("sourceContext").value
    
        if (horaireSelectionne) {
            const timeInput =
                source === "ajout"
                    ? document.querySelector("#popupAjoutRendezVous #hiddenTime")
                    : document.querySelector("#popupModifRendezVous #hiddenTime")
    
            if (timeInput) {
                timeInput.value = horaireSelectionne.value
            }
    
            fermerPopup("popupChoixHoraires")
        }
    })
})


function handleFormSubmission(formId, popupId, successMessage, actionUrl) {
    const form = document.getElementById(formId)
    if (!form) return

    form.addEventListener("submit", async function (e) {
        e.preventDefault() // Empêcher le rechargement

        const formData = new FormData(this)
        try {
            const response = await fetch(actionUrl, {
                method: "POST",
                body: formData
            })

            const text = await response.text()
            const data = JSON.parse(text)

            if (!response.ok || data.status !== "success") {
                throw new Error(data.message || `Erreur HTTP : ${response.status}`)
            }

            fermerPopup(popupId)
            afficherMessageSucces(successMessage)
            window.location.reload(false)
        } catch (error) {
            afficherMessageErreur(error.message || "Une erreur est survenue. Veuillez réessayer.")
        }
    })
}

document.addEventListener("DOMContentLoaded", () => {
    handleFormSubmission("modifRdvForm", "popupModifRendezVous", "Rendez-vous modifié", "index.php?action=modifRendezVous")
    handleFormSubmission("supprimRdvForm", "popupSupprimRendezVous", "Rendez-vous supprimé", "index.php?action=supprimRendezVous")
    handleFormSubmission("ajoutRdvForm", "popupAjoutRendezVous", "Rendez-vous ajouté", "index.php?action=ajoutRendezVous")
})
