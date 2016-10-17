<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Manage Authors</title>
  </head>
  <body>
    <p>Manage Authors</p>
    <p><a href="?add">Add new author</a></p>
    <?php foreach($authors as $author): ?>
    <ul>
      <li>
        <form action="" method="POST">
          <div><?php htmlout($author['name']); ?>
            <input type="hidden" name="id" value="<?php htmlout($author['id']); ?>">
            <input type="submit" name="action" value="Edit">
            <input type="submit" name="action" value="Delete">
          </div>
        </form>
      </li>
    </ul>
    <?php endforeach; ?>
    <p><a href="..">Return to JMS home</a></p>
  </body>
</html>