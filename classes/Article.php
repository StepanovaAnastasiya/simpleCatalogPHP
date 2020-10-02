<?php

class Article
{
  public $id = null;
  public $publicationDate = null;
  public $title = null;
  public $summary = null;
  public $content = null;

  /**
  * Set all article features
  * @param assoc
  */
  public function __construct( $data=array() ) {
    if ( isset( $data['id'] ) ) $this->id = (int) $data['id'];
    if ( isset( $data['publicationDate'] ) ) $this->publicationDate = (int) $data['publicationDate'];
    if ( isset( $data['title'] ) ) $this->title = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['title'] );
    if ( isset( $data['summary'] ) ) $this->summary = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['summary'] );
    if ( isset( $data['content'] ) ) $this->content = $data['content'];
  }

/**
  * Set all article features, when they came from form
  *
  * @param assoc
  */

  public function storeFormValues ( $params ) {

    $this->__construct( $params );

    if ( isset($params['publicationDate']) ) {
      $publicationDate = explode ( '-', $params['publicationDate'] );

      if ( count($publicationDate) == 3 ) {
        list ( $y, $m, $d ) = $publicationDate;
        $this->publicationDate = mktime ( 0, 0, 0, $m, $d, $y );
      }
    }
  }

  /**
  * Returns article object with certain ID
  *
  * @param int - article ID
  * @return Article|false
  */

  public static function getById( $id ) {
    $connection = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles WHERE id = :id";
    $st = $connection->prepare( $sql );
    $st->bindValue( ":id", $id, PDO::PARAM_INT );
    $st->execute();
    $row = $st->fetch();
    $connection = null;
    if ( $row ) return new Article( $row );
  }


  /**
  * Returns collection of article objects
  *
  * @param int Optional Number of articles
  * @return Array|false   Сollection of article objects
  */

  public static function getList( $numRows=1000000) {
    $connection  = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles
            ORDER BY publicationDate DESC LIMIT :numRows";

    $st = $connection->prepare( $sql );
    $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
    $st->execute();
    $list = array();

    while ( $row = $st->fetch() ) {
      $article = new Article( $row );
      $list[] = $article;
    }

    return ( $list );
  }


  /**
  * Articte data insert
  */

  public function insert() {
    $connection  = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "INSERT INTO articles ( publicationDate, title, summary, content ) VALUES ( FROM_UNIXTIME(:publicationDate), :title, :summary, :content )";
    $st = $connection->prepare ( $sql );
    $st->bindValue( ":publicationDate", $this->publicationDate, PDO::PARAM_INT );
    $st->bindValue( ":title", $this->title, PDO::PARAM_STR );
    $st->bindValue( ":summary", $this->summary, PDO::PARAM_STR );
    $st->bindValue( ":content", $this->content, PDO::PARAM_STR );
    $st->execute();
    $this->id = $connection->lastInsertId();
    $connection  = null;
  }




  /**
  * Delete article object from DB
  */

  public function delete() {
    $connection  = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $st = $connection->prepare ( "DELETE FROM articles WHERE id = :id LIMIT 1" );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $connection  = null;
  }

}

?>
