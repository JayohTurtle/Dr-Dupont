
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



