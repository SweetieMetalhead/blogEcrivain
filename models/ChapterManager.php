<?php

namespace PaulOhl\Blog\Model;

require_once('models/Manager.php');

class ChapterManager extends Manager {

  const CHAPTER_NUMBER = 1;
  const CHAPTER_ID = 2;
  const SUMMARY_LENGTH = 200;

  public function getChapters() {
    $db = $this->dbConnect();

    $req = $db->query('SELECT id, title, chapter_number, content, LEFT(content, 200) AS summary, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS publication_date_fr FROM Chapters ORDER BY chapter_number LIMIT 0, 5');

    return $req;
  }

  public function getLastChapter() {
    $db = $this->dbConnect();

    $req = $db->query('SELECT id, title, chapter_number, content, LEFT(content, 200) AS summary, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS publication_date_fr FROM Chapters ORDER BY chapter_number DESC LIMIT 0, 1');

    //print_r($req->fetch());

    return $req->fetch();
  }

  public function getChapter($chapter, $mode) {
    $db = $this->dbConnect();

    if ($mode == 1) {
      // Search by ID
      $req = $db->prepare('SELECT id, title, chapter_number, content, LEFT(content, 200) AS summary, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS publication_date_fr FROM Chapters WHERE id = ?');
    } elseif ($mode == 2) {
      // Search by chapter number
      $req = $db->prepare('SELECT id, title, chapter_number, content, LEFT(content, 200) AS summary, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS publication_date_fr FROM Chapters WHERE chapter_number = ?');
    } else {
      throw new Exception("Mauvais mode entré");
    }

    $req->execute(array($chapter));

    $result = $req->fetch();

    return $result;
  }

  public function addChapter($authorID, $title, $content) {
    $db = $this->dbConnect();

    $req = $db->prepare('INSERT INTO Chapters(author_id, title, content, post_date) VALUES(?, ?, ?, NOW())');
    $affectedLines = $req->execute(array($authorID, $title, $content));

    return $affectedLines;
  }
}
