<?php

namespace PaulOhl\Blog\Model;

class CommentManager extends Manager {

  public function getComments($chapterID) {
    $db = $this->dbConnect();

    $req = $db->prepare('SELECT Users.pseudo AS author, Comments.content AS content, DATE_FORMAT(Comments.comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM Comments, Users WHERE Comments.author_id = Users.id AND Comments.post_id = ? ORDER BY comment_date DESC');
    $req->execute(array($chapterID));

    return $req;
  }

  public function postComment($postID, $author, $comment) {
    $db = $this->dbConnect();
    $req = $db->prepare('INSERT INTO Comments(post_id, author_id, content, comment_date) VALUES(?, ?, ?, NOW())');
    $affectedLines = $req->execute(array($postID, $author, $comment));

    return $affectedLines;
  }

  public function deleteComment($commentID) {
    $db = $this->dbConnect();

    $req = $db->prepare('DELETE FROM Comments WHERE id = ?');
    $affectedLines = $req->execute(array($commentID));

    return $affectedLines;
  }
}
