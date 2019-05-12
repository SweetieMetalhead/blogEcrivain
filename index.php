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
      case 'chapter':
        if (isset($_GET['chapterid']) && $_GET['chapterid'] > 0) {
          chapter(htmlspecialchars($_GET['chapterid']));
        } else {
          throw new Exception("Erreur : Numéro de chapitre invalide");
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
        userSignIn(htmlspecialchars($_POST['signinpseudo']), htmlspecialchars($_POST['signinpassword']), htmlspecialchars($_POST['signinemail']));
        break;
      case 'login':
        userLogIn(htmlspecialchars($_POST['loginemail']), htmlspecialchars($_POST['loginpassword']));
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
        // if ($_SESSION['auth'] == "admin") {
          displayWriteChapterPage();
        // }
        break;
      case 'addarticle':
        addPost(htmlspecialchars($_POST['title']), htmlspecialchars($_POST['content']));
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
