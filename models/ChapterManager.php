<?php

namespace PaulOhl\Blog\Model;

require_once('models/Manager.php');

class ChapterManager extends Manager {

  const CHAPTER_NUMBER = 1;
  const CHAPTER_ID = 2;

  public function getChapters() {
    $db = $this->dbConnect();

    $req = $db->query('SELECT id, title, chapter_number, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS publication_date_fr FROM Chapters WHERE publish_date <= NOW() AND is_draft = 0 ORDER BY chapter_number LIMIT 0, 5');

    return $req;
  }

  public function countChapters() {
    $db = $this->dbConnect();

    $req = $db->query('SELECT COUNT(id) AS NumberOfChapters FROM Chapters');

    $chapterNumber = $req->fetch();

    return $chapterNumber['NumberOfChapters'];
  }

  public function getLastChapter() {
    $db = $this->dbConnect();

    $req = $db->query('SELECT id, title, chapter_number, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS publication_date_fr FROM Chapters WHERE publish_date <= NOW() AND is_draft = 0 ORDER BY chapter_number DESC LIMIT 0, 1');

    //print_r($req->fetch());

    return $req->fetch();
  }

  public function getChapter($chapter, $mode, $selectDrafts = false) {
    $db = $this->dbConnect();

    if (in_array($mode, [self::CHAPTER_NUMBER, self::CHAPTER_ID])) {
      if ($mode == 1) {
        // Search by ID
        if ($selectDrafts) {
          $req = $db->prepare('SELECT id, title, chapter_number, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS publication_date_fr FROM Chapters WHERE chapter_number = ?');
        } else {
          $req = $db->prepare('SELECT id, title, chapter_number, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS publication_date_fr FROM Chapters WHERE chapter_number = ? AND publish_date <= NOW() AND is_draft = 0');
        }
      } elseif ($mode == 2) {
        // Search by chapter number
        if ($selectDrafts) {
          $req = $db->prepare('SELECT id, title, chapter_number, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS publication_date_fr FROM Chapters WHERE id = ?');
        } else {
          $req = $db->prepare('SELECT id, title, chapter_number, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS publication_date_fr FROM Chapters WHERE id = ? AND publish_date <= NOW() AND is_draft = 0');
        }
      } else {
        throw new Exception("Mauvais mode entré");
      }
    } else {
      throw new Exception("Mauvais mode entré");
    }

    $req->execute(array($chapter));
    $result = $req->fetch();

    return $result;
  }

  private function formatDate($nonFormattedDateTime) {
    $monthsInNumbers = [
      "Janvier" => "01",
      "Février" => "02",
      "Mars" => "03",
      "Avril" => "04",
      "Mai" => "05",
      "Juin" => "06",
      "Juillet" => "07",
      "Août" => "08",
      "Septembre" => "09",
      "Octobre" => "10",
      "Novembre" => "11",
      "Décembre" => "12"
    ];

    $dateTimeArray = preg_split("/[\s:]+/", $nonFormattedDateTime);
    print_r($nonFormattedDateTime);

    $YYYY = $dateTimeArray[3];
    $MM = $monthsInNumbers[$dateTimeArray[2]];
    $DD = $dateTimeArray[1];

    $hh = $dateTimeArray[4];
    $mm = $dateTimeArray[5];
    $ss = "00";

    $formattedDateTime = $YYYY."-".$MM."-".$DD." ".$hh.":".$mm.":".$ss;

    return $formattedDateTime;
  }

  public function addChapter($chapterNumber, $title, $content, $publicationdatetime) {
    $db = $this->dbConnect();

    if ($publicationdatetime == "NOW()") {
      $req = $db->prepare('INSERT INTO Chapters(chapter_number, title, content, publish_date) VALUES(?, ?, ?, NOW())');
      $affectedLines = $req->execute(array($chapterNumber, $title, $content));
    } else {
      $publishFormatted = $this->formatDate($publicationdatetime);
      $req = $db->prepare('INSERT INTO Chapters(chapter_number, title, content, publish_date) VALUES(?, ?, ?, ?)');
      $affectedLines = $req->execute(array($chapterNumber, $title, $content, $publishFormatted));
    }

    return $affectedLines;
  }

  public function deleteChapter($chapterID) {
    $db = $this->dbConnect();

    $req = $db->prepare('DELETE FROM Chapters WHERE id = ?');
    $affectedLines = $req->execute([$chapterID]);

    return $affectedLines;
  }

  public function saveInDraft($chapterNumber, $title, $content) {
    $db = $this->dbConnect();

    $req = $db->prepare('INSERT INTO Chapters(chapter_number, title, content, publish_date, is_draft) VALUES(?, ?, ?, NOW(), 1)');
    $affectedLines = $req->execute(array($chapterNumber, $title, $content));

    return $affectedLines;
  }

  public function getDrafts() {
    $db = $this->dbConnect();

    $req = $db->query('SELECT id, title, chapter_number, content FROM Chapters WHERE is_draft = 1 ORDER BY chapter_number LIMIT 0, 5');

    return $req;
  }

  public function updateChapter($chapterID, $chapterNumber, $title, $content, $isDraft) {
    $db = $this->dbConnect();

    $req = $db->prepare('UPDATE Chapters SET title = ?, chapter_number = ?, content = ?, is_draft = ? WHERE id = ?');

    $affectedLines = $req->execute([$title, $chapterNumber, $content, $isDraft, $chapterID]);

    return $affectedLines;
  }
}
