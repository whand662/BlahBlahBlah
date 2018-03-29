<?php
session_start();
//make connection
include("mysql_connection.php");
include("functions.php");

?>

<!DOCTYPE html>
<html>

      <body>

          <h1>List of Users</h1>

          <?php
                $users = showUsersUidOrder();
                $following = following($_SESSION['uid']);

                if (count($users)){
          ?>
      <table border = '1' cellspacing='0' cellpadding='3' width='300'>

          <?php
                  foreach ($users as $key => $value){
                    echo "<tr valign='top'>\n";
                    echo "<td>".$key ."</td>\n";
                    echo "<td>".$value; //." <p><a href='#'>Follow</a><p><a href='#'>Unfollow</a></p></td>\n";

                    if(in_array($key,$following)){
                      echo "<a href='action.php?id=$key&do=unfollow'>unfollow</a>";

                    }else{
                    echo " <a href='action.php?id=$key&do=follow'>follow</a>";
                    }
                    echo "</tr>\n";
                  }
          ?>
      </table>
          <?php
                }else {
          ?>
      <p><b>There are no users in the system!</b></p>
          <?php
                }
          ?>
      </body>

</html>
