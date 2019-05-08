let form = document.getElementById('inscription');
let pseudoCheck = false;
let emailCheck = false;
let passwordCheck = false;
let confirmCheck = false;

form.elements.pseudo.addEventListener("blur", function() {
  let verification = pseudoVerify(form.elements.pseudo.value);
  pseudoCheck = verification[0];
  document.getElementById('pseudoadvice').textContent = verification[1];
  //console.log(verification);
});
form.elements.email.addEventListener("blur", function() {
  let verification = emailVerify(form.elements.email.value);
  emailCheck = verification[0];
  document.getElementById('emailadvice').textContent = verification[1];
  //console.log(verification);
});
form.elements.password.addEventListener("blur", function() {
  let verification = passwordVerify(form.elements.password.value);
  passwordCheck = verification[0];
  document.getElementById('passwordadvice').textContent = verification[1];
  //console.log(verification);
});
form.elements.confirm.addEventListener("blur", function() {
  let verification = confirmPasswordVerify(form.elements.password.value, form.elements.confirm.value);
  confirmCheck = verification[0];
  document.getElementById('confirmadvice').textContent = verification[1];
  //console.log(verification);
});

form.addEventListener("submit", function(e) {
  pseudoCheck = pseudoVerify(form.elements.pseudo.value, document.getElementById('pseudoadvice').textContent);
  emailCheck = emailVerify(form.elements.email.value, document.getElementById('emailadvice').textContent);
  passwordCheck = passwordVerify(form.elements.password.value, document.getElementById('passwordadvice').textContent);
  confirmCheck = confirmPasswordVerify(form.elements.password.value, form.elements.confirm.value, document.getElementById('confirmadvice').textContent);
  if (!pseudoCheck || !emailCheck || !passwordCheck || !confirmCheck) {
    e.preventDefault();
  }
});

document.getElementById('lalala').addEventListener("click", function(){
  console.log(pseudoCheck + ", " + emailCheck + ", " + passwordCheck + ", " + confirmCheck);
});
