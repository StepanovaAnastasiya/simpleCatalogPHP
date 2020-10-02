<?php

require( "config.php" );
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
  case 'viewArticle':
    viewArticle();
    break;
 case 'newArticle':
    newArticle();
    break;
  case 'deleteArticle':
    deleteArticle();
    break;
  default:
    catalog();
}

function catalog() {
  $results = array();
  $results['articles'] = Article::getList();
  $results['pageTitle'] = "Catalog";
  if ( isset( $_GET['error'] ) ) {
  if ( $_GET['error'] == "articleNotFound" ) $results['errorMessage'] = "Ошибка:Статья не найдена.";
}

if ( isset( $_GET['status'] ) ) {
  if ( $_GET['status'] == "articleSaved" ) $results['statusMessage'] = "Ваша статья сохранена!";
  if ( $_GET['status'] == "articleDeleted" ) $results['statusMessage'] = "Статья удалена.";
}
  require( "templates/catalog.php" );

}

function viewArticle() {
  if ( !isset($_GET["articleId"]) || !$_GET["articleId"] ) {
    catalog();
    return;
  }

  $results = array();
  $results['article'] = Article::getById( (int)$_GET["articleId"] );
  $results['pageTitle'] = $results['article']->title;
  require( "templates/viewArticle.php" );
}

function newArticle() {

  $results = array();
  $results['pageTitle'] = "New Article";
  $results['formAction'] = "newArticle";

  if ( isset( $_POST['saveChanges'] ) ) {

    // Saving new article
    $article = new Article;
    $article->storeFormValues( $_POST );
    $article->insert();
    header( "Location: index.php?status=articleSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {
    header( "Location: index.php" );
  } else {
    // User don't receice form yet, so we will show form
    $results['article'] = new Article;
    require("templates/createArticle.php" );
  }

}

function deleteArticle() {

  if ( !$article = Article::getById( (int)$_GET['articleId'] ) ) {
    header( "Location: index.php?error=articleNotFound" );
    return;
  }

  $article->delete();
  header( "Location: index.php?status=articleDeleted" );
}

?>
