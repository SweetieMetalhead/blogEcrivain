function pseudoVerify(pseudo) {
  let advice;
  let regexPattern = new RegExp("^([a-zA-Z0-9-_]{3,36})$");
  if (!regexPattern.test(pseudo)) {
    advice = "Votre nom de compte doit faire entre 3 et 36 caractères et ne comporter aucun signe spécial sauf '-' et '_'.";
    return [false, advice];
  } else {
    advice = "";
    return [true, advice];
  }
}

function emailVerify(email) {
  let advice;
  let regexPattern = new RegExp("^[\\w-\\.]+@([\\w-]+\\.)+[\\w-]{2,4}$");
  if (!regexPattern.test(email)) {
    advice = "Votre email n'est pas valide !";
    return [false, advice];
  } else {
    advice = "";
    return [true, advice];
  }
}

function passwordVerify(password) {
  let advice;
  let passwordLength = password.length;
  if (passwordLength < 5 || passwordLength > 64) {
    advice = "Votre mot de passe doit contenir entre 5 et 64 caractères.";
    return [false, advice];
  } else {
    advice = "";
    return [true, advice];
  }
}

function confirmPasswordVerify(password, confirmation) {
  let advice;
  if (password != confirmation) {
    advice = "Le mot de passe et la confirmation doivent correspondre !";
    return [false, advice];
  } else {
    advice = "";
    return [true, advice];
  }
}
