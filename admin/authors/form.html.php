<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title><?php htmlout($pageTitle); ?></title>
  </head>
  <body>
    <h1><?php htmlout($pageTitle); ?></h1>
    <form action="?<?php htmlout($action); ?>" method="post">
      <div>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php htmlout($name); ?>" />
      </div>
      <div>
        <label for="name">Email:</label>
        <input type="text" name="email" id="email" value="<?php htmlout($email); ?>" />
      </div>
      <input type="hidden" name="id" value="<?php htmlout($id); ?>" />
      <input type="submit" value="<?php htmlout($button); ?>" />
    </form>
  </body>
</html>