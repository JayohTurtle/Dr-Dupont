// Ajoutez un écouteur d'événement pour intercepter la soumission du formulaire
document.getElementById("form").addEventListener("submit", function(event) {
    // Empêcher la soumission par défaut du formulaire
    event.preventDefault();
  
    // Appeler la fonction de validation
    if (validateForm()) {
      // Si la validation est réussie, soumettre le formulaire manuellement
      this.submit();
      
    }
  });
  
  /**
  * fonction qui vérifie la validité des champs quand on clique sur le submit
  */
  function validateForm(){
    //on vérifie que les input ne sont pas vides
    //on sélectionne tous les input
    const nom = document.getElementById('nom')
    const prenom = document.getElementById('prenom')
    const telephone = document.getElementById('telephone')
    const email = document.getElementById('email')
  
    let nomValue = nom.value.trim()
    let prenomtValue = prenom.value.trim()
  
    const input = document.querySelectorAll('input')
      for(let i = 0; i < input.length; i++){
          let inputId = input[i].id//on récupère les id
          let inputElement = document.getElementById(inputId)//on se place dans le DOM
          let inputValue = inputElement.value.trim()//on récupère la valeur du champ et on supprme les éventuels espaces au début et à la fin
          if( inputValue === ""){
              let message = "Ce champ ne peut être vide"//message d'erreur
              fieldError(inputElement, message)//on appelle la fonction qui gère les erreurs sur les champs
          }else{
              drFieldGood(inputElement)
          }
      }
      //on vérifie la validité de l'email
      let emailValue = email.value.trim()
      let emailRegExp = new RegExp("[a-z0-9_.-]+@[a-z0-9_.-]+\\.[a-z0-9_.-]+")
      if (!emailRegExp.test(emailValue)){
          let message = "Le format d'email renseigné n'est pas valide"
          fieldError(email, message)
      }else{
        drFieldGood(email)
      }
      //on vérifie la validité du numéro de téléphone
      let telephoneValue = telephone.value.trim()
      let telephoneRegExp = new RegExp("[+0-9]")
      if (!telephoneRegExp.test(telephoneValue)){
          let message = "Le numéro de téléphone renseigné n'est pas valide"
          fieldError(telephone, message)
      }else{
        drFieldGood(telephone)
      }
  }
  
  /**
  * fonction qui renvoie le message d'erreur
  * @param {string} elem 
  * @param {string} message 
  */
  function fieldError (elem, message){
  let formGroup = elem.parentElement
  let small = formGroup.querySelector('small')
  
  //on ajoute le message d'erreur
  small.innerText = message
  
  //on ajoute la classe error
  formGroup.classList.add('error')
  }
  /**
  /* fonction qui retire le message d'erreur
  * @param {string} elem 
  */
  function drFieldGood (elem){
  let formGroup = elem.parentElement
  formGroup.classList.remove('error')
  }