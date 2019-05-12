<?php

namespace PaulOhl\Blog\Model;

class Manager
{
  protected function dbConnect() {
    $db = new \PDO('mysql:host=localhost;dbname=blogEcrivain;charset=utf8', 'root', 'root');
    return $db;
  }
}
