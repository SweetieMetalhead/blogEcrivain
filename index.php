<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require('controllers/controller.php');

try {
  if (isset($_GET['action'])) {
    switch ($_GET['action']) {
      case 'home':
        home();
        break;
      case 'article':
        if (isset($_GET['article']) && $_GET['article'] > 0) {
          article();
        } else {
          throw new Exception("Erreur : Article invalide");
        }
        break;
      case 'addComment':
        if (isset($_GET['id']) && $_GET['id'] > 0) {
          if (!empty($_POST['comment'])) {
            addComment($_GET['id'], $_SESSION['id'], $_POST['comment']); //il faudra mettre l'utilisateur actif à la place du 1
          } else {
            throw new Exception('Tous les champs ne sont pas remplis');
          }
        } else {
          throw new Exception("Aucun identifiant de billet envoyé");
        }
        break;
      case 'signin':
        userSignIn(htmlspecialchars($_POST['pseudo']), htmlspecialchars($_POST['password']), htmlspecialchars($_POST['email']));
        break;
      case 'signin-page':
        displaySignInPage();
        break;
      case 'login':
        userLogIn(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password']));
        break;
      case 'login-page':
        displayLogInPage();
        break;
      case 'logout':
        userLogout();
        break;
      case 'manage':
        if (isset($_SESSION['pseudo'])) {
          userManage();
        }
        break;
      case 'changepseudo':
        if (isset($_SESSION['pseudo'])) {
          userChangeInfo($_SESSION['id'], 'pseudo', htmlspecialchars($_POST['newPseudo']));
        }
        break;
      case 'changeemail':
        if (isset($_SESSION['pseudo'])) {
          userChangeInfo($_SESSION['id'], 'email', htmlspecialchars($_POST['newEmail']));
        }
        break;
      case 'changepassword':
          if (isset($_SESSION['pseudo'])) {
            userChangePassword($_SESSION['id'], $_SESSION['email'], 'password', htmlspecialchars($_POST['oldpassword']), htmlspecialchars($_POST['newpassword']), htmlspecialchars($_POST['passwordconfirm']));
          }
        break;
      case 'deleteaccount':
        if(isset($_SESSION['pseudo'])) {
          userDeleteAccount($_SESSION['id']);
        }
        break;
      case 'writearticle':
        if ($_SESSION['auth'] == "admin") {
          displayWritePostPage();
        }
        break;
      case 'addarticle':
        addPost($_SESSION['id'], htmlspecialchars($_POST['title']), htmlspecialchars($_POST['content']));
      default:
        home();
        break;
    }
  }
  else {
    home();
  }
} catch (Exception $e) {
  echo "Erreur : " . $e->getMessage();
}
