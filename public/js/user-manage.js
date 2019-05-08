let changePseudo = document.getElementById('changepseudo');
let changeEmail = document.getElementById('changeemail');
let changePassword = document.getElementById('changepassword');

changePseudo.addEventListener("submit", function(e) {
  let verification = pseudoVerify(changePseudo.elements.newPseudo.value);
  document.getElementById('pseudoadvice').textContent = verification[1];
  if (!verification[0]) {
    e.preventDefault();
  }
});

changeEmail.addEventListener("submit", function(e) {
  let verification = emailVerify(changeEmail.elements.newEmail.value);
  document.getElementById('emailadvice').textContent = verification[1];
  if (!verification[0]) {
    e.preventDefault();
  }
});

let passwordCheck = false;
let confirmCheck = false;

changePassword.elements.newpassword.addEventListener("blur", function() {
  let verification = passwordVerify(changePassword.elements.newpassword.value);
  passwordCheck = verification[0];
  document.getElementById('newpasswordadvice').textContent = verification[1];
});

changePassword.elements.passwordconfirm.addEventListener("blur", function() {
  let verification = confirmPasswordVerify(changePassword.elements.newpassword.value, changePassword.elements.passwordconfirm.value);
  confirmCheck = verification[0];
  document.getElementById('confirmationadvice').textContent = verification[1];
});


document.getElementById('accountdelete').addEventListener("click", function(e) {
  e.preventDefault();
  if(confirm("Êtes vous sûr de vouloir supprimer votre compte ? Cette action est définitive.")) {
    window.location.href = "index.php?action=deleteaccount";
  }
});
