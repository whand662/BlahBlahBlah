<?php
  session_start();
  include 'mysql_connection.php';
  include 'functions.php';


 ?>
 <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
<h2>User's you are following</h2>

    <?php
        $users = showUsers($_SESSION['uid']);

          if (count($users)){
    ?>
      <ul>
          <?php
                  foreach ($users as $key => $value){
                          echo "<li>".$value."</li>\n";
                  }
          ?>
      </ul>
          <?php
          }else{
          ?>
            <p><b>You're not following anyone yet!</b></p>
            <?php
          }
          ?>
</head>
<body>
  <p><a href='users.php'>See list of users</a></p>
    <form method='POST' action="users.php">

</body>
</html>
