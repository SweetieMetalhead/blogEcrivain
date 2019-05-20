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
          throw new Exception("Numéro de chapitre invalide");
        }
        break;
      case 'addComment':
        if (isset($_GET['id']) && $_GET['id'] > 0) {
          if (!empty($_POST['comment'])) {
            addComment($_GET['id'], $_SESSION['pseudo'], $_POST['comment']);
          } else {
            throw new Exception('Tous les champs ne sont pas remplis');
          }
        } else {
          throw new Exception("Aucun identifiant de chapitre envoyé");
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
        if (isset($_GET['pseudo'])) {
          userManage(htmlspecialchars($_GET['pseudo']));
        }
        break;
      case 'changepseudo':
        if (isset($_SESSION['pseudo'])) {
          userChangeInfo($_SESSION['pseudo'], 'pseudo', htmlspecialchars($_POST['newpseudo']));
        }
        break;
      case 'changeemail':
        if (isset($_SESSION['pseudo'])) {
          userChangeInfo($_SESSION['pseudo'], 'email', htmlspecialchars($_POST['newemail']));
        }
        break;
      case 'changepassword':
          if (isset($_SESSION['pseudo'])) {
            userChangePassword($_SESSION['pseudo'], htmlspecialchars($_POST['oldpassword']), htmlspecialchars($_POST['newpassword']), htmlspecialchars($_POST['passwordconfirm']));
          }
        break;
      case 'deleteaccount':
        if(isset($_SESSION['pseudo'])) {
          userDeleteAccount($_SESSION['pseudo']);
        }
        break;
      case 'writechapter':
        displayWriteChapterPage();
        break;
      case 'addchapter':
        if (isset($_POST['publishlaterbool'])) {
          $dateTime = htmlspecialchars($_POST['date']) . " " . htmlspecialchars($_POST['time']);
        } else {
          $dateTime = "NOW()";
        }

        addChapter($_POST['chapternumber'], htmlspecialchars($_POST['title']), htmlspecialchars($_POST['content']), $dateTime);
        break;
      case 'deletecomment':
        deleteComment($_GET['comment'], $_SESSION['pseudo']);
        break;
      case 'flag':
        flagComment($_GET['comment'], $_SESSION['pseudo']);
        break;
      case 'deleteflags':
        deleteFlags($_GET['flaggedcomment']);
        break;
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
