<?php

namespace PaulOhl\Blog\Model;

class Manager
{
  protected function dbConnect() {
    $db = new \PDO('mysql:host=http://paul-ohl.zd.fr/; dbname=blogEcrivain; charset=utf8', 'pauldafp_jForte', 'xGFwtuBV4RC5km3eDY');
    return $db;
  }
}
