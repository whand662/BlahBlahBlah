
<?php
//The file user.php runs the show_users()function
//and displays a list of all the users in the system, each with a link that says follow next to the user name.
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
                //used showUsersUidOrder() function to populate a user list ordered by uid
                $users = showUsersUidOrder();
                //echo $_SESSION["uid"];
              //  echo $_SESSION["username"];
              // If(user[i]!=$_session[uid])
              // Echo arr[i];

                $following = following($_SESSION['uid']);

                if (count($users)){
          ?>
      <table border = '1' cellspacing='0' cellpadding='3' width='300'>

          <?php
                  foreach ($users as $key => $value){
                    if($key!=$_SESSION['uid']){
                    echo "<tr valign='top'>\n";
                    echo "<td>".$key ."</td>\n";
                    echo "<td>".$value; //." <p><a href='#'>Follow</a><p><a href='#'>Unfollow</a></p></td>\n";
                    if(in_array($key,$following)){
                      echo "<a href='action.php?id=$key&do=unfollow'> Unfollow</a>";
                    }else{
                    echo " <a href='action.php?id=$key&do=follow'>Follow</a>";
                    }
                    echo "</tr>\n";
                  }
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
