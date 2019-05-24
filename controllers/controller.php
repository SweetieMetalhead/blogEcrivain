<?php

//require('models/model.php');
require_once('models/ChapterManager.php');
require_once('models/CommentManager.php');
require_once('models/UserManager.php');

function home() {
  $chapterManager = new PaulOhl\Blog\Model\ChapterManager();
  $firstChapter = $chapterManager->getChapter(1, $chapterManager::CHAPTER_NUMBER);
  $lastChapter = $chapterManager->getLastChapter();

  require('views/home-display.php');
}

function chapter($chapterID) {
  $userManager = new PaulOhl\Blog\Model\UserManager();
  $chapterManager = new PaulOhl\Blog\Model\ChapterManager();
  $commentManager = new PaulOhl\Blog\Model\CommentManager();

  $chapter = $chapterManager->getChapter($chapterID, $chapterManager::CHAPTER_ID);
  $content = html_entity_decode($chapter['content']);

  $comments = $commentManager->getComments($chapterID);

  $userInfo = $userManager->getInfo($_SESSION['pseudo']);

  require('views/chapter-display.php');
}

function addComment($chapterID, $authorPseudo, $comment) {
  $commentManager = new PaulOhl\Blog\Model\CommentManager();
  $userManager = new PaulOhl\Blog\Model\UserManager();

  $userInfo = $userManager->getInfo($authorPseudo);

  $affectedLines = $commentManager->postComment($chapterID, $userInfo['id'], $comment);

  if ($affectedLines === false) {
    throw new Exception('Impossible d\'ajouter le commentaire !');
  } else {
    header('Location: index.php?action=chapter&chapterid=' . $chapterID);
  }
}

function deleteComment($comment, $userDeleting) {
  $commentManager = new PaulOhl\Blog\Model\CommentManager();
  $userManager = new PaulOhl\Blog\Model\UserManager();

  $userInfo = $userManager->getInfo($userDeleting);
  $commentInfo = $commentManager->getInfo($comment);

  if ($userInfo['authorization'] == 'admin' || $userInfo['authorization'] == 'author' || $userInfo['id'] == $commentInfo['author_id']) {
    $affectedLines = $commentManager->deleteComment($comment);

    if ($affectedLines) {
      // Commentaire supprimé
      if ($commentInfo['author_id'] == $userInfo['id']) { // If the author deleted the comment
        // Congratulations on successfully deleting the comment

      } else {
        // Notify the author that his/her comment has been deleted and congratulations on successfully deleting the comment

      }

      header("Location: index.php?action=chapter&chapterid=" . $commentInfo['chapter_id']);
    } else {
      throw new Exception("Le commentaire n'a pas pu être supprimé");
    }
  }
}

function flagComment($comment, $userFlagging) {
  $commentManager = new PaulOhl\Blog\Model\CommentManager();
  $userManager = new PaulOhl\Blog\Model\UserManager();

  $userInfo = $userManager->getInfo($userFlagging);
  $commentInfo = $commentManager->getInfo($comment);
  $flagInfo = $commentManager->getFlagInfo($comment);
  $flagInfo = $flagInfo->fetch();

  $affectedLines = false;

  if($commentManager->countFlagsToday($userInfo['id']) >= 5) {
    throw new Exception("Vous ne pouvez pas signaler plus de 5 commentaires par jour");
  } elseif ($flagInfo['flagger_id'] == $userInfo['id']) {
    throw new Exception("Vous avez déjà signalé ce commentaire");
  } else {
    // echo $commentManager->countFlagsToday($userInfo['id']);
    $affectedLines = $commentManager->flagComment($comment, $userInfo['id']);
  }

  if ($affectedLines) {
    header("Location: index.php?action=chapter&chapterid=" . $commentInfo['chapter_id'] . "#" . $comment);
  } else {
    throw new Exception("Le commentaire n'a pas pu être supprimé");
  }
}

function deleteFlags($flaggedComment) {
  $commentManager = new PaulOhl\Blog\Model\CommentManager();
  $userManager = new PaulOhl\Blog\Model\UserManager();

  $userInfo = $userManager->getInfo($_SESSION['pseudo']);

  if ($userInfo['authorization'] == 'admin' || $userInfo['authorization'] == 'author') {
    $affectedLines = $commentManager->deleteFlags($flaggedComment);

    if ($affectedLines) {
      header('Location: index.php?action=manage&pseudo=' . $_SESSION['pseudo']);
    } else {
      throw new Exception("Impossible de retirer le signalement");
    }
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

  if ($userInfo['authorization'] == "admin" || $userInfo['authorization'] == "author") {
    $commentManager = new PaulOhl\Blog\Model\CommentManager();
    $userManager = new PaulOhl\Blog\Model\UserManager();
    $flags = $commentManager->getFlags();

    if ($userInfo['authorization'] == "author") {
      $chapterManager = new PaulOhl\Blog\Model\ChapterManager();
      $drafts = $chapterManager->getDrafts();
    }
  }

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

function userDeleteAccount($pseudo) {
  $userManager = new PaulOhl\Blog\Model\UserManager();
  $userID = $userManager->getInfo($pseudo)['id'];
  $affectedLines = $userManager->deleteAccount($userID);

  if ($affectedLines) {
    session_destroy();

    header('Location: index.php?action=home');
  }else {
    throw new Exception("Could not delete account.");
  }
}

function displayWriteChapterPage($chapterEditID = 0) {
  $userManager = new PaulOhl\Blog\Model\UserManager();
  $chapterManager = new PaulOhl\Blog\Model\ChapterManager();
  $userInfo = $userManager->getInfo($_SESSION['pseudo']);
  $chapterNumber = $chapterManager->countChapters();

  if ($chapterEditID > 0) {
    $chapter = $chapterManager->getChapter($chapterEditID, $chapterManager::CHAPTER_ID, true);
  }
  if ($userInfo['authorization'] == "author") {
    require('views/chapter-write.php');
  } else {
    header('Location: index.php?action=home');
  }
}

function addChapter($chapterNumber, $title, $content, $publicationTime) {
  $chapterManager = new PaulOhl\Blog\Model\ChapterManager();
  $affectedLines = $chapterManager->addChapter($chapterNumber, $title, $content, $publicationTime);

  if ($affectedLines) {
    header('Location: index.php?action=home');
  } else {
    throw new Exception("Impossible d'ajouter le chapitre.");
  }
}

function deleteChapter($chapterID){
  $userManager = new PaulOhl\Blog\Model\UserManager();
  $chapterManager = new PaulOhl\Blog\Model\ChapterManager();

  $userInfo = $userManager->getInfo($_SESSION['pseudo']);

  if ($userInfo['authorization'] == "author") {
    $affectedLines = $chapterManager->deleteChapter($chapterID);

    if ($affectedLines) {
      header('Location: index.php?action=home');
    } else {
      throw new Exception("Impossible de supprimer le chapitre.");
    }
  } else {
    header("Location: index.php?action=home");
  }
}

function saveInDraft($chapterNumber, $title, $content) {
  $chapterManager = new PaulOhl\Blog\Model\ChapterManager();
  $affectedLines = $chapterManager->saveInDraft($chapterNumber, $title, $content);

  if ($affectedLines) {
    header('Location: index.php?action=home');
  } else {
    throw new Exception("Impossible d'ajouter le Brouillon.");
  }
}

function updateChapter($chapterID, $chapterNumber, $title, $content, $isDraft) {
  $chapterManager = new PaulOhl\Blog\Model\ChapterManager();
  $affectedLines = $chapterManager->updateChapter($chapterID, $chapterNumber, $title, $content, $isDraft);

  if ($affectedLines) {
    header('Location: index.php?action=manage');
  } else {
    throw new Exception("Impossible de mettre le chapitre à jour.");
  }
}
