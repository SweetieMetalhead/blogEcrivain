<?php
require_once('../models/UserManager.php');

if (isset($_POST['email'])) {
  checkExistingUser(htmlspecialchars($_POST['email']));
}
if (isset($_POST['pseudo'])) {
  checkExistingUser(htmlspecialchars($_POST['pseudo']));
}
if (isset($_POST['email']) && isset($_POST['password'])) {
  userLogIn(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password']));
}

function checkExistingUser($user) { //finds user by email or pseudo
  $userManager = new PaulOhl\Blog\Model\UserManager();

  if ($userManager->checkExistingUser($user)) {
    echo "Tout va bien <3";
  } else {
    if (filter_var($user, FILTER_VALIDATE_EMAIL)) {
      echo "Email déjà utilisé";
    } else {
      echo "Pseudo déjà utilisé";
    }
  }
}

function userLogIn($email, $password) {
  $userManager = new PaulOhl\Blog\Model\UserManager();
  $response = $userManager->getInfo($email);

  if (password_verify($password, $response['password'])) {
    echo "C'est le bon mot de passe";
  } else {
    echo $response['password'];
  }
}
