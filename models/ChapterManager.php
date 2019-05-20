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

  public function countChapters() {
    $db = $this->dbConnect();

    $req = $db->query('SELECT COUNT(id) AS NumberOfChapters FROM Chapters');

    $chapterNumber = $req->fetch();

    return $chapterNumber['NumberOfChapters'];
  }

  public function getLastChapter() {
    $db = $this->dbConnect();

    $req = $db->query('SELECT id, title, chapter_number, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS publication_date_fr FROM Chapters ORDER BY chapter_number DESC LIMIT 0, 1');

    //print_r($req->fetch());

    return $req->fetch();
  }

  public function getChapter($chapter, $mode) {
    $db = $this->dbConnect();

    if ($mode == 1) {
      // Search by ID
      $req = $db->prepare('SELECT id, title, chapter_number, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS publication_date_fr FROM Chapters WHERE id = ?');
    } elseif ($mode == 2) {
      // Search by chapter number
      $req = $db->prepare('SELECT id, title, chapter_number, content, DATE_FORMAT(publish_date, \'%d/%m/%Y à %Hh%imin%ss\') AS publication_date_fr FROM Chapters WHERE chapter_number = ?');
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
}
