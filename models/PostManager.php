<?php

namespace PaulOhl\Blog\Model;

require_once('models/Manager.php');

class PostManager extends Manager {

  public function getPosts() {
    $db = $this->dbConnect();

    $req = $db->query('SELECT Members.pseudo AS author, Posts.id AS id, Posts.title AS title, Posts.content AS content, DATE_FORMAT(Posts.post_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM Posts, Members WHERE Posts.author_id = Members.id ORDER BY post_date DESC LIMIT 0, 5');

    return $req;
  }

  public function getPost($postID) {
    $db = $this->dbConnect();

    $req = $db->prepare('SELECT Members.pseudo AS author, Posts.id AS id, Posts.title AS title, Posts.content AS content, DATE_FORMAT(Posts.post_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM Posts, Members WHERE Posts.author_id = Members.id AND Posts.id = ? ORDER BY post_date DESC LIMIT 0, 5');
    $req->execute(array($postID));
    $article = $req->fetch();

    return $article;
  }

  public function addPost($authorID, $title, $content) {
    $db = $this->dbConnect();

    $req = $db->prepare('INSERT INTO Posts(author_id, title, content, post_date) VALUES(?, ?, ?, NOW())');
    $affectedLines = $req->execute(array($authorID, $title, $content));

    return $affectedLines;
  }
}
