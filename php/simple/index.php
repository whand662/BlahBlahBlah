<?php
  session_start();
  include 'mysql_connection.php';

 ?>
 <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">

  <title>User Posts</title>
</head>
<body>
    <form method='POST' action="addPost.php?id=<?php echo $_SESSION["uid"]; ?>">
      <input type='text' name='combody' >
            <button type='submit' name='commentSubmit'>Post</button>
      </form>
</body>
</html>
