function copierEmail() {
    let emailSpan = document.querySelector('[id^="emailACopier_"]') // Sélectionne le premier élément correspondant

    if (emailSpan) {
        let email = emailSpan.textContent.trim()
        
        if (email) {
            navigator.clipboard.writeText(email).then(() => {
                alert("L'email a été copié !")
                
                // Mettre l'email dans le champ hidden du formulaire
                document.getElementById("emailsInput").value = email

                // Soumettre le formulaire
                document.getElementById("emailForm").submit()

            }).catch(err => {
                console.error("Erreur lors de la copie de l'email : ", err)
            })
        } else {
            alert("Aucun email trouvé !")
        }
    } else {
        alert("Aucun email à copier !")
    }
}
