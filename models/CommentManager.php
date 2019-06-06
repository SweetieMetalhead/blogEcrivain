<?php

namespace PaulOhl\Blog\Model;

class CommentManager extends Manager {

  public function getComments($chapterID) {
    $db = $this->dbConnect();

    $req = $db->prepare('SELECT Comments.id AS commentID, Users.pseudo AS author, Comments.content AS content, DATE_FORMAT(Comments.comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM Comments, Users WHERE Comments.author_id = Users.id AND Comments.chapter_id = ? ORDER BY comment_date DESC');
    $req->execute(array($chapterID));

    return $req;
  }

  public function getInfo($commentID) {
    $db = $this->dbConnect();

    $req = $db->prepare('SELECT * FROM Comments WHERE id = ?');
    $req->execute([$commentID]);

    return $req->fetch();
  }

  public function postComment($postID, $author, $comment) {
    $db = $this->dbConnect();

    $req = $db->prepare('INSERT INTO Comments(chapter_id, author_id, content, comment_date) VALUES(?, ?, ?, NOW())');
    $affectedLines = $req->execute(array($postID, $author, $comment));

    return $affectedLines;
  }

  public function deleteComment($commentID) {
    $db = $this->dbConnect();

    $req = $db->prepare(' DELETE Comments
                          FROM Comments
                          WHERE Comments.id = ?');
    $affectedLines = $req->execute(array($commentID));

    return $affectedLines;
  }

  public function getFlags() {
    $db = $this->dbConnect();

    $req = $db->query('SELECT Chapters.id AS chapter_id,
                                FlaggedComments.comment_id AS comment_id,
                                Users.pseudo AS author,
                                LEFT(Comments.content, 60) AS comment_sumup,
                                COUNT(FlaggedComments.flagger_id) AS number_of_flaggers
                          FROM FlaggedComments, Comments, Users, Chapters
                          WHERE FlaggedComments.comment_id = Comments.id
                          AND Comments.author_id = Users.id
                          AND Comments.chapter_id = Chapters.id
                          GROUP BY FlaggedComments.comment_id');

    return $req;
  }

  public function getFlagInfo($commentID) {
    $db = $this->dbConnect();

    $req = $db->prepare('SELECT * FROM FlaggedComments WHERE comment_id = ?');
    $req->execute([$commentID]);

    return $req;
  }

  public function flagComment($commentID, $userFlagging) {
    $db = $this->dbConnect();

    $req = $db->prepare('INSERT INTO FlaggedComments(comment_id, flagger_id, flag_time) VALUES(?, ?, NOW())');
    $affectedLines = $req->execute(array($commentID, $userFlagging));

    return $affectedLines;
  }

  public function countFlagsToday($userID) { // Counts the number of comments the user has flagged in the last 24 hours
    $db = $this->dbConnect();

    $req = $db->prepare('SELECT COUNT(id) AS numberOfFlags FROM FlaggedComments WHERE flagger_id = ? AND flag_time >= NOW() - INTERVAL 1 DAY');
    $req->execute([$userID]);

    $result = $req->fetch();

    return $result['numberOfFlags'];
  }

  public function deleteFlags($flaggedComment) {
    $db = $this->dbConnect();

    $req = $db->prepare('DELETE FROM FlaggedComments WHERE FlaggedComments.comment_id = ?');
    $affectedLines = $req->execute(array($flaggedComment));

    return $affectedLines;
  }

  public function countAdminNotifications() {
    $db = $this->dbConnect();

    $req = $db->query('SELECT COUNT(DISTINCT Comments.id) AS number_of_flags FROM Comments, FlaggedComments WHERE Comments.id = FlaggedComments.comment_id');

    $result = $req->fetch();
    return $result['number_of_flags'];
  }
}
