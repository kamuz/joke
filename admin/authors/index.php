<?php

// Delete author and his categories and jokes

if (isset($_POST['action']) && $_POST['action'] == 'Delete'){

  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  // Get ID jokes belonging to author
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

  // Delete joke category entries
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

  // Delete jokes belonging to author
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

  // Delete the author
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