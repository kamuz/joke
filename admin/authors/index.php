<?php

// Add new author

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';

if (isset($_GET['add'])) {
  $pageTitle = 'New author';
  $action = 'addform';
  $name = '';
  $email = '';
  $id = '';
  $button = 'Add author';
  include 'form.html.php';
  exit();
}

if (isset($_GET['addform'])) {
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  try {
    $sql = 'INSERT INTO author SET name = :name, email = :email';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':email', $_POST['email']);
    $s->execute();
  }
  catch (PDOException $e) {
    $error = 'Error adding submitted author.';
    include 'error.html.php';
    exit();
  }
  
  header('Location: .');
  exit();
}

// Edit author

// show data
if (isset($_POST['action']) && $_POST['action'] == 'Edit') {
  include $_SERVER ['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  try {
    $sql = 'SELECT id, name, email FROM author WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch(PDOExeption $e) {
    $error = 'Error fetching author details.';
    include 'error.html.php';
    exit();
  }

  $row = $s->fetch();

  $pageTitle = 'Edit Author';
  $action = 'editform';
  $name = $row['name'];
  $email = $row['email'];
  $id = $row['id'];
  $button = 'Update author';

  include 'form.html.php';
  exit();
}

// save data
if (isset($_GET['editform'])){
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  try {
    $sql = 'UPDATE author SET name = :name, email = :email WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':email', $_POST['email']);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch(PDOExeption $e){
    $error = 'Error updating submitted author.';
    include 'error.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

// Delete author and his categories and jokes

if (isset($_POST['action']) && $_POST['action'] == 'Delete'){

  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  // get ID jokes belonging to author
  try{
    $sql = 'SELECT id FROM joke WHERE authorid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e){
    $error = 'Error getting list of jokes to delete.';
    include 'error.html.php';
    exit();
  }

  $result = $s->fetchAll();

  // delete joke category entries
  try {
    $sql = 'DELETE FROM jokecategory WHERE jokeid = :id';
    $s = $pdo->prepare($sql);

    // For each joke
    foreach($result as $row) {
      $jokeId = $row['id'];
      $s->bindValue(':id', $jokeId);
      $s->execute();
    }
  }
  catch (PDOException $e) {
    $error = 'Error deleting category entries for joke.';
    include 'error.html.php';
    exit();
  }

  // delete jokes belonging to author
  try {
    $sql = 'DELETE FROM joke WHERE authorid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e) {
    $error = 'Error deleting jokes for author.';
    include 'error.html.php';
    exit();
  }

  // delete the author
  try {
    $sql = 'DELETE FROM author WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOExeption $e) {
    $error = 'Error deleting author.';
    include 'error.html.php';
    exit();
  }
}

// Display author list

include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

try {
  $result = $pdo->query('SELECT id, name FROM author');
}
catch (PDOException $e) {
  $error = 'Error fetching authors from the database: ' . $e->getMessage();
  include 'error.html.php';
  exit();
}

foreach($result as $row) {
  $authors[] = array(
    'id' => $row['id'],
    'name' => $row['name']
  );
}

include 'authors.html.php';