<?php

//require('models/model.php');
require_once('models/ChapterManager.php');
require_once('models/CommentManager.php');
require_once('models/UserManager.php');

function home() {
  $chapterManager = new PaulOhl\Blog\Model\ChapterManager();
  $firstChapter = $chapterManager->getChapter(1, 2);
  $lastChapter = $chapterManager->getLastChapter();

  require('views/home-display.php');
}

function chapter($chapterID) {
  $chapterManager = new PaulOhl\Blog\Model\ChapterManager();
  $commentManager = new PaulOhl\Blog\Model\CommentManager();

  $chapter = $chapterManager->getChapter($chapterID, 1);
  $comments = $commentManager->getComments($chapterID);

  require('views/chapter-display.php');
}

function addComment($chapterID, $authorID, $comment) {
  $commentManager = new PaulOhl\Blog\Model\CommentManager();
  $affectedLines = $commentManager->postComment($chapterID, $authorID, $comment);

  if ($affectedLines === false) {
    throw new Exception('Impossible d\'ajouter le commentaire !');
  } else {
    header('Location: index.php?action=article&article=' . $chapterID);
  }
}

function userSignIn($pseudo, $password, $email) {
  //testing regex match
  if (preg_match("#^([a-zA-Z0-9-_]{3,36})$#", $pseudo) && filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($password) >= 5) {
    $userManager = new PaulOhl\Blog\Model\UserManager();
    if($userManager->checkExistingUser($pseudo)) {
      if ($userManager->checkExistingUser($email)) {
        $affectedLines = $userManager->signIn($pseudo, $password, $email);

        if ($affectedLines === false) {
          throw new Exception('Impossible d\'ajouter l\'utilisateur !');
        } else {
          userLogIn($email, $password);
        }
      } else {
        throw new Exception('Email déjà utilisé par un autre utilisateur.');
      }
    } else {
      throw new Exception('Pseudo déjà utilisé par un autre utilisateur.');
    }
  } else {
    throw new Exception('Vos informations sont incorrectes.');
    //header("Location: index.php?action=signin-page");
  }
}

function displaySignInPage() {
  require('views/signin-display.php');
}

function userLogIn($email, $password) {
  $userManager = new PaulOhl\Blog\Model\UserManager();
  $response = $userManager->getInfo($email);

  if (password_verify($password, $response['password'])) {
    // $_SESSION['sessionID'] = password_hash($response['pseudo'], PASSWORD_DEFAULT);
    $_SESSION['pseudo'] = $response['pseudo'];
    header('Location: index.php?action=home');
  } else {
    header('Location: index.php?action=home');
  }
}

function displayLogInPage() {
  require('views/login-display.php');
}

function userLogout() {
  session_destroy();
  header('Location: index.php?action=home');
}

function userManage($user) {
  $userManager = new PaulOhl\Blog\Model\UserManager();
  $userInfo = $userManager->getInfo($user);

  require('views/user-manage-display.php');
}

function userChangeInfo($pseudo, $parameter, $newInfo) {
  $userManager = new PaulOhl\Blog\Model\UserManager();

  $userID = $userManager->getInfo($pseudo)['id'];
  echo $userID;

  switch ($parameter) {
    case 'pseudo':
      if (preg_match("#^([a-zA-Z0-9-_]{3,36})$#", $newInfo)) {
        if($userManager->checkExistingUser($newInfo)) {
          $affectedLines = $userManager->changePseudo($userID, $newInfo);
        } else {
          throw new Exception('Pseudo déjà utilisé par un autre utilisateur.');
        }
      } else {
        throw new Exception("Le nouveau pseudo n'est pas valide.");
      }
      break;
    case 'email':
      if(filter_var($newInfo, FILTER_VALIDATE_EMAIL)) {
        if ($userManager->checkExistingUser($newInfo)) {
          $affectedLines = $userManager->changeEmail($userID, $newInfo);
        } else {
          throw new Exception('Email déjà utilisé par un autre utilisateur.');
        }
      } else {
        throw new Exception("Le nouvel email n'est pas valide.");
      }
      break;
    case 'password':
      if (strlen($newInfo) >= 5 && strlen($newInfo) <= 64) {
        $affectedLines = $userManager->changePassword($userID, $newInfo);
      } else {
        throw new Exception("Le nouveau mot de passe est trop court ou trop long.");
      }
      break;
    default:
      throw new Exception("Synthax error when selecting parameter to modify !");
      break;
  }


  if ($affectedLines === false) {
    throw new Exception("Impossible de changer le paramètre demandé !");
  } else {
    if ($parameter == 'pseudo') {
      $_SESSION['pseudo'] = $newInfo;
    }
    header('Location: index.php?action=manage&pseudo=' . $_SESSION['pseudo']);
  }
}

function userChangePassword($user, $oldPassword, $newPassword, $verification) {
  if ($newPassword == $verification) {
    $userManager = new PaulOhl\Blog\Model\UserManager();
    $response = $userManager->getInfo($user);

    if (password_verify($oldPassword, $response['password'])) {
      userChangeInfo($_SESSION['pseudo'], 'password', $newPassword);
    } else {
      throw new Exception("Ancien mot de passe incorrect !");
    }
  } else {
    throw new Exception("Les nouveaux mots de passe ne correspondent pas !");
  }
}

function userDeleteAccount($userID) {
  $userManager = new PaulOhl\Blog\Model\UserManager();
  $affectedLines = $userManager->deleteAccount($userID);

  if ($affectedLines) {
    session_destroy();

    header('Location: index.php?action=home');
  }else {
    throw new Exception("Could not delete account.");
  }
}

function displayWriteChapterPage() {
  require('views/chapter-write.php');
}

function addChapter($authorID, $title, $content) {
  $chapterManager = new PaulOhl\Blog\Model\ChapterManager();
  $affectedLines = $chapterManager->addChapter($authorID, $title, $content);

  if ($affectedLines) {
    header('Location: index.php?action=home');
  } else {
    throw new Exception("Impossible d'ajouter l'article.");
  }
}
