// Attendre que le DOM soit complètement chargé
window.onload = function() {
    // Cacher le message de succès quand on clique n'importe où sur la page
    document.addEventListener('click', function(event) {
        // Vérifier si l'élément cliqué n'est pas le message lui-même
        var successMessage = document.getElementById('success-message')
        if (successMessage && !successMessage.contains(event.target)) {
            successMessage.style.display = 'none'  // Cacher le message
            }
        })
    }
    
    // Fonction générique pour gérer l'affichage des inputs selon la sélection
    function updateVisibleInput(category) {
        const radioButtons = document.querySelectorAll(`input[name="${category}Research"]`)
        const inputGroups = {
            patient: {
                nom: "inputNom",
                telephone: "inputTelephone",
                email: "inputEmail",
            },
            actualite: {
                ajouterActualite: "inputAjouterActualite",
                modifierActualite: "inputModifierActualite",
                supprimerActualite: "inputSupprimerActualite"
            },
            soin: {
                ajouterSoin: "inputAjouterSoin",
                modifierSoin: "inputModifierSoin",
                supprimerSoin: "inputSupprimerSoin"
            },
            service: {
                ajouterService: "inputAjouterService",
                modifierService: "inputModifierService",
                supprimerService: "inputSupprimerService"
            }
        }
    
        function handleInputChange() {
            const selectedValue = document.querySelector(`input[name="${category}Research"]:checked`).value
    
            // Cacher tous les blocs
            Object.values(inputGroups[category]).forEach(id => {
                const group = document.getElementById(id)
                if (group) group.classList.add('d-none')
            })
    
            // Vider tous les champs de saisie (input + textarea)
            document.querySelectorAll(`.${category}-input`).forEach(field => {
                const editor = tinymce.get(field.id)
                if (editor) {
                    editor.setContent('')
                } else {
                    field.value = ''
                }
            })
    
            // Afficher le bloc sélectionné
            const visibleGroupId = inputGroups[category][selectedValue]
            const visibleGroup = document.getElementById(visibleGroupId)
            if (visibleGroup) visibleGroup.classList.remove('d-none')
        }
    
        radioButtons.forEach(radio => radio.addEventListener("change", handleInputChange))
        handleInputChange() // Exécuter dès le départ
    }
    
    // Initialisation pour chaque catégorie
    ["patient","actualite", "soin", "service"].forEach(updateVisibleInput)
    
    document.addEventListener("DOMContentLoaded", function () {
        function updateFields(inputId, dataListId, contentId, hiddenId) {
            let input = document.getElementById(inputId)
            let dataList = document.getElementById(dataListId)
            let contentField = document.getElementById(contentId)
            let hiddenField = document.getElementById(hiddenId)
        
            input.addEventListener("input", function () {
                let selectedOption = Array.from(dataList.options).find(option => option.value === input.value)
                if (selectedOption) {
                    hiddenField.value = selectedOption.getAttribute("data-id")
        
                    const contenu = selectedOption.getAttribute("data-contenu") || ""
        
                    // Si TinyMCE est activé sur ce champ
                    const editor = tinymce.get(contentId)
                    if (editor) {
                        editor.setContent(contenu)
                    } else {
                        contentField.value = contenu
                    }
                }
            })
        }
    
        updateFields("titreModif", "getActualitesModif", "contenuModif", "idActualiteModif")
        updateFields("titreSupprim", "getActualitesSupprim", "contenuSupprim", "idActualiteSupprim")
        updateFields("serviceModif", "getServicesModif", "descriptionModif",  "idServiceModif")
        updateFields("serviceSupprim", "getServicesSupprim", "descriptionSupprim", "idServiceSupprim")
    
    })
    
    document.addEventListener("DOMContentLoaded", function () {
        function updateSoinFields(inputId, dataListId, hiddenId) {
            let input = document.getElementById(inputId)
            let dataList = document.getElementById(dataListId)
            let hiddenField = document.getElementById(hiddenId)
    
            input.addEventListener("input", function () {
                let selectedOption = Array.from(dataList.options).find(option => option.value === input.value)
                if (selectedOption) {
                    hiddenField.value = selectedOption.getAttribute("data-id")
                }
            })
        }

        updateSoinFields("soinModif", "getSoinsModif", "idSoinModif")
        updateSoinFields("soinSupprim", "getSoinsSupprim", "idSoinSupprim")
    })
    
    



 
