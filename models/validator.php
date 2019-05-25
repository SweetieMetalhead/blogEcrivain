<?php
require_once('../models/UserManager.php');

if (isset($_POST['email'])) {
  checkExistingUser(htmlspecialchars($_POST['email']));
  $loginEmail = $_POST['email'];
}
if (isset($_POST['pseudo'])) {
  checkExistingUser(htmlspecialchars($_POST['pseudo']));
}
if (isset($_POST['password'])) {
  echo $loginEmail;
  userLogIn($loginEmail, $_POST['password']);
}

function checkExistingUser($user) { //finds user by email or pseudo
  $userManager = new PaulOhl\Blog\Model\UserManager();

  if ($userManager->checkExistingUser($user)) {
    echo true;
  } else {
    echo false;
  }
}

function userLogIn($email, $password) {
  $userManager = new PaulOhl\Blog\Model\UserManager();
  $response = $userManager->getInfo($email);

  if (password_verify($password, $response['password'])) {
    echo true;
  } else {
    echo false;
  }
}
