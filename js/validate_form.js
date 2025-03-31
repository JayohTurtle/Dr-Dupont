// Ajouter un écouteur d'événement pour intercepter la soumission du formulaire
document.getElementById("form").addEventListener("submit", function(event) {
  event.preventDefault() // Bloque l'envoi du formulaire

  if (validateFormContact()) {
      this.submit() // Envoie le formulaire seulement si tout est valide
  } 
})

/**
* Fonction qui vérifie la validité des champs du formulaire
*/
function validateFormContact() {
  let isValid = true

  // Sélection des champs
  const nom = document.getElementById('nom')
  const prenom = document.getElementById('prenom')
  const telephone = document.getElementById('telephone')
  const email = document.getElementById('email')

  let nomValue = nom.value.trim()
  let prenomValue = prenom.value.trim()
  let emailValue = email.value.trim()
  let telephoneValue = telephone.value.trim()

  // Effacer les erreurs précédentes
  clearFieldError(nom)
  clearFieldError(prenom)
  clearFieldError(email)
  clearFieldError(telephone)

  if(nomValue === ''){
      fieldError(nom, "Vous devez renseigner votre nom")
      isValid = false
  }

  if(prenomValue === ''){
      fieldError(prenom, "Vous devez renseigner votre prénom")
      isValid = false
  }

  if(emailValue === ''){
      fieldError(email, "Vous devez renseigner un email")
      isValid = false
  }

  if(telephoneValue === ''){
      fieldError(telephone, "Vous devez renseigner un numéro de téléphone")
      isValid = false
  }

  // Vérification de l'email
  if (emailValue !== "") {
      let emailRegExp = /^[a-z0-9._-]+@[a-z0-9.-]+\.[a-z]{2,4}$/i
      if (!emailRegExp.test(emailValue)) {
          fieldError(email, "Format email invalide")
          isValid = false
      } else {
          clearFieldError(email)
      }
  }

  // Vérification du téléphone
  if (telephoneValue !== "") {
      let telephoneRegExp = /^\s*(?:\+?\d{1,3}[-.\s]?)?(0[1-9])(?:[-.\s]?\d{2}){4}\s*$/
      if (!telephoneRegExp.test(telephoneValue)) {
          fieldError(telephone, "Numéro de téléphone invalide")
          isValid = false
      } else {
          clearFieldError(telephone)
      }
  }

  return isValid
}

/**
 * Fonction qui affiche l'erreur directement dans l'input (placeholder)
 * @param {HTMLElement} elem 
 * @param {string} message 
 */
function fieldError(elem, message) {
  elem.classList.add('error') // Ajoute la bordure rouge
  elem.setAttribute("placeholder", message) // Affiche le message dans l'input
  elem.value = "" // Efface la valeur incorrecte
}

/**
* Fonction qui supprime l'erreur et restaure l'état normal du champ
* @param {HTMLElement} elem 
*/
function clearFieldError(elem) {
  elem.classList.remove('error') // Supprime la bordure rouge
  elem.removeAttribute("placeholder") // Efface le message d'erreur
}
