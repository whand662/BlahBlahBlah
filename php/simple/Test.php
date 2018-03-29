<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
      <img src="logoUser.png"  class="center">
      <h1 align="center">Welcome to EzTwitt</h1>

    <style>
      body{
          background: url(background2.jpg);
          background-size: cover;
          margin: 0;
      }
      .center {
          display: block;
          margin-left: auto;
          margin-right: auto;
          width: 10%;
       }

      </style>

      <?php
      session_start();
      include('mysql_connection.php');
      include('functions.php');
      ?>
      <body>

<h1>List of Users</h1>
<?php
$users = show_users();

if (count($users)){
?>
<table border='1' cellspacing='0' cellpadding='5' width='500'>
<?php
foreach ($users as $key => $value){
    echo "<tr valign='top'>\n";
    echo "<td>".$key ."</td>\n";
    echo "<td>".$value;
    echo "</tr>\n";
}
?>
</table>
<?php
}else{
?>
<p><b>There are no users in the system!</b></p>
<?php
}
?>
</body>
</html>
