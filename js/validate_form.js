// Ajouter un écouteur d'événement pour intercepter la soumission du formulaire
document.getElementById("form").addEventListener("submit", function(event) {
    event.preventDefault() // Bloque l'envoi du formulaire
  
    // Réinitialiser les erreurs de tous les champs avant la validation
    clearAllFieldErrors()
  
    if (validateFormContact()) {
        this.submit() // Envoie le formulaire seulement si tout est valide
    } 
  })
  
  /**
   * Fonction qui vérifie la validité des champs du formulaire
   */
  function validateFormContact() {
      let isValid = true
  
      // Champs à valider
      const nom = document.getElementById('nom')
      const prenom = document.getElementById('prenom')
      const telephone = document.getElementById('telephone')
      const email = document.getElementById('email')
      const dateRdv = document.getElementById('datepicker')
      const horaire = document.getElementById('hiddenTime')
  
      // Vérification des champs obligatoires
      if (nom && nom.value.trim() === '') {
          fieldError(nom, "Vous devez renseigner votre nom")
          isValid = false
      }
  
      if (prenom && prenom.value.trim() === '') {
          fieldError(prenom, "Vous devez renseigner votre prénom")
          isValid = false
      }
  
      if (telephone && telephone.value.trim() === '') {
          fieldError(telephone, "Vous devez renseigner un numéro de téléphone")
          isValid = false
      }
  
      if (email && email.value.trim() === '') {
          fieldError(email, "Vous devez renseigner un email")
          isValid = false
      }
  
      if (dateRdv && dateRdv.value.trim() === '') {
          fieldError(dateRdv, "Vous devez choisir une date")
          isValid = false
      }
  
      // Vérifier que l'horaire est sélectionné avant d'envoyer
      if (horaire && horaire.value.trim() === '') {
          fieldError(horaire, "Veuillez sélectionner un horaire pour votre rendez-vous.")
          isValid = false
      }
  
      // Vérification du format email
      const emailRegExp = /^[a-z0-9._-]+@[a-z0-9.-]+\.[a-z]{2,4}$/i
      if (email && email.value.trim() !== '' && !emailRegExp.test(email.value.trim())) {
          fieldError(email, "Format email invalide")
          isValid = false
      }
  
      // Vérification du format téléphone
      const telephoneRegExp = /^\s*(?:\+?\d{1,3}[-.\s]?)?(0[1-9])(?:[-.\s]?\d{2}){4}\s*$/
      if (telephone && telephone.value.trim() !== '' && !telephoneRegExp.test(telephone.value.trim())) {
          fieldError(telephone, "Numéro de téléphone invalide")
          isValid = false
      }
  
      return isValid
  }
  
  /**
   * Fonction qui affiche l'erreur directement dans l'input (placeholder)
   * @param {HTMLElement} elem 
   * @param {string} message 
   */
  function fieldError(elem, message) {
      elem.classList.add('error') // Ajoute la classe d'erreur
      if (elem.hasAttribute("data-placeholder")) {
        elem.setAttribute("placeholder", message) // Ajoute le message d'erreur dans le placeholder
      } else {
        elem.setAttribute("data-placeholder", elem.getAttribute("placeholder"))
        elem.setAttribute("placeholder", message) // Ajoute le message d'erreur dans le placeholder
      }
  }
  
  /**
   * Fonction qui supprime l'erreur et restaure l'état normal du champ
   * @param {HTMLElement} elem 
   */
  function clearFieldError(elem) {
      elem.classList.remove('error') // Supprime la classe d'erreur
      elem.removeAttribute("placeholder") // Efface le message d'erreur
      elem.style.border = '' // Supprime la bordure rouge si la correction a été faite
      elem.style.backgroundColor = '' // Supprime l'arrière-plan rouge si la correction a été faite
  }
  
  /**
   * Fonction qui supprime les erreurs de tous les champs
   */
  function clearAllFieldErrors() {
      // Réinitialisation de tous les champs
      const fields = ['nom', 'prenom', 'telephone', 'email', 'datepicker', 'hiddenTime']
      fields.forEach(id => {
          const field = document.getElementById(id)
          if (field) {
              clearFieldError(field) // Supprimer les erreurs sur chaque champ
          }
      })
  }
  
  