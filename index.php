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
        } elseif (isset($_GET['chapternumber']) && $_GET['chapternumber'] > 0) {
          convertNumberToID(htmlspecialchars($_GET['chapternumber']));
        }
        else {
          throw new Exception("Numéro de chapitre invalide");
        }
        break;
      case 'allchapters':
        if (isset($_GET['page']) && (int) $_GET['page'] > 0) {
          displayAllChapters($_GET['page']);
        } else {
          displayAllChapters();
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
      case 'loginpage':
        displayLogInPage();
        break;
      case 'logout':
        userLogout();
        break;
      case 'manage':
        if (isset($_GET['pseudo'])) {
          userManage(htmlspecialchars($_GET['pseudo']));
        } else {
          userManage(htmlspecialchars($_SESSION['pseudo']));
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
        if (isset($_GET['edit'])) {
          displayWriteChapterPage($_GET['edit']);
        } else {
          displayWriteChapterPage();
        }
        break;
      case 'addchapter':
        if ($_POST['chapterID'] !== "") { // If the chapter already exists
          if ($_POST['saveindraft'] !== null) {
            //Option to save in draft
            updateChapter($_POST['chapterID'], $_POST['chapternumber'], htmlspecialchars($_POST['title']), htmlspecialchars($_POST['content']), "NOW()", 1);
          } else {
            //Option not to save in draft
            if (isset($_POST['publishlaterbool'])) {
              updateChapter($_POST['chapterID'], $_POST['chapternumber'], htmlspecialchars($_POST['title']), htmlspecialchars($_POST['content']), htmlspecialchars($_POST['date']) . " " . htmlspecialchars($_POST['time']), 0);
            } else {
              updateChapter($_POST['chapterID'], $_POST['chapternumber'], htmlspecialchars($_POST['title']), htmlspecialchars($_POST['content']), "NOW()", 0);
            }
          }
        } elseif ($_POST['saveindraft'] !== null) {
          saveInDraft($_POST['chapternumber'], htmlspecialchars($_POST['title']), htmlspecialchars($_POST['content']));
        } elseif (isset($_POST['publishlaterbool'])) {
          addChapter($_POST['chapternumber'], htmlspecialchars($_POST['title']), htmlspecialchars($_POST['content']), htmlspecialchars($_POST['date']) . " " . htmlspecialchars($_POST['time']));
        } else {
          addChapter($_POST['chapternumber'], htmlspecialchars($_POST['title']), htmlspecialchars($_POST['content']), "NOW()");
        }
        break;
      case 'deletechapter':
        if (isset($_GET['chapterid']) && $_GET['chapterid'] > 0) {
          deleteChapter(htmlspecialchars($_GET['chapterid']));
        } else {
          throw new Exception("Numéro de chapitre invalide");
        }
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
