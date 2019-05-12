<?php

namespace PaulOhl\Blog\Model;

require_once('models/Manager.php');

class UserManager extends Manager {
  public function signIn($pseudo, $password, $email){
    $db = $this->dbConnect();

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $req = $db->prepare('INSERT INTO Users(pseudo, password, email, signin_date, authorization) VALUES(?, ?, ?, NOW(), \'basic\')');
    $affectedLines = $req->execute(array($pseudo, $hash, $email));

    return $affectedLines;
  }

  public function checkExistingPseudo($pseudo) {
    $db = $this->dbConnect();

    $req = $db->prepare('SELECT id FROM Users WHERE pseudo = ?');
    $req->execute(array($pseudo));
    $response = $req->fetch();

    if ($response == null) {
      return true;
    } else {
      return false;
    }
  }

  public function checkExistingEmail($email) {
    $db = $this->dbConnect();

    $req = $db->prepare('SELECT id FROM Users WHERE email = ?');
    $req->execute(array($email));
    $response = $req->fetch();

    if ($response == null) {
      return true;
    } else {
      return false;
    }
  }

  public function getInfo($email) {
    $db = $this->dbConnect();

    $req = $db->prepare('SELECT * FROM Users WHERE email = ?');
    $req->execute(array($email));
    $response = $req->fetch();

    return $response;
  }

  public function changePseudo($userID, $newPseudo){
    $db = $this->dbConnect();

    $req = $db->prepare('UPDATE Users SET pseudo = ? WHERE Users.id = ?');
    $affectedLines = $req->execute(array($newPseudo, $userID));

    return $affectedLines;
  }

  public function changeEmail($userID, $newEmail){
    $db = $this->dbConnect();

    $req = $db->prepare('UPDATE Users SET email = ? WHERE Users.id = ?');
    $affectedLines = $req->execute(array($newEmail, $userID));

    return $affectedLines;
  }

  public function changePassword($userID, $newPassword){
    $db = $this->dbConnect();

    $hash = password_hash($newPassword, PASSWORD_DEFAULT);

    $req = $db->prepare('UPDATE Users SET password = ? WHERE Users.id = ?');
    $affectedLines = $req->execute(array($hash, $userID));

    return $affectedLines;
  }

  public function deleteAccount($userID) {
    $db = $this->dbConnect();

    $req = $db->prepare('DELETE FROM Users WHERE Users.id = ?');
    $affectedLines = $req->execute(array($userID));

    return $affectedLines;
  }
}
