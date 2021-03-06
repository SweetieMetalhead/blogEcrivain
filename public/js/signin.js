let form = document.getElementById('signin-form');
let pseudoCheck = false;
let emailCheck = false;
let passwordCheck = false;
let confirmCheck = false;
let pseudoDoublesCheck = false;
let emailDoublesCheck = false;

form.elements.signinpseudo.addEventListener("blur", function() {
  let verification = pseudoVerify(form.elements.signinpseudo.value);
  pseudoCheck = verification[0];
  document.getElementById('pseudoadvice').textContent = verification[1];
  //console.log(verification);
});
form.elements.signinemail.addEventListener("blur", function() {
  let verification = emailVerify(form.elements.signinemail.value);
  emailCheck = verification[0];
  document.getElementById('emailadvice').textContent = verification[1];
  //console.log(verification);
});
form.elements.signinpassword.addEventListener("blur", function() {
  let verification = passwordVerify(form.elements.signinpassword.value);
  passwordCheck = verification[0];
  document.getElementById('passwordadvice').textContent = verification[1];
  //console.log(verification);
});
form.elements.signinconfirm.addEventListener("blur", function() {
  let verification = confirmPasswordVerify(form.elements.signinpassword.value, form.elements.signinconfirm.value);
  confirmCheck = verification[0];
  document.getElementById('confirmadvice').textContent = verification[1];
  //console.log(verification);
});

form.addEventListener("submit", function(e) {
  pseudoCheck = pseudoVerify(form.elements.signinpseudo.value, document.getElementById('pseudoadvice').textContent)[0];
  emailCheck = emailVerify(form.elements.signinemail.value, document.getElementById('emailadvice').textContent)[0];
  passwordCheck = passwordVerify(form.elements.signinpassword.value, document.getElementById('passwordadvice').textContent)[0];
  confirmCheck = confirmPasswordVerify(form.elements.signinpassword.value, form.elements.signinconfirm.value, document.getElementById('confirmadvice').textContent)[0];
  if (!pseudoCheck || !emailCheck || !passwordCheck || !confirmCheck || !pseudoDoublesCheck || !emailDoublesCheck) {
    e.preventDefault();
  }
});

document.getElementById('lalala').addEventListener("click", function(){
  console.log(pseudoCheck + ", " + emailCheck + ", " + passwordCheck + ", " + confirmCheck + ", " + pseudoDoublesCheck + ", " + emailDoublesCheck);
});
