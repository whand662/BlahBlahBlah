
<?php
  include("mysql_connection.php");
  include('functions.php');

  if(isset(($_POST['submit']))){
    //check if the user and password are empty
    if(empty($_POST['username']) || empty($_POST['password'])){
      echo "<b>Please enter Username and Password to log in!</b>";
    }else{
      //define user and password
      $username=$_POST['username'];
      $password=$_POST['password'];

      //to prevent mysql injection
      $username = stripcslashes($username);
      $password = stripcslashes($password);
      $username = mysqli_real_escape_string($connect, $username);
      $password = mysqli_real_escape_string($connect, $password);

      //fetch info of user and fnds user match
      $query = mysqli_query($connect, "SELECT * FROM user WHERE username='$username' AND password='$password'")
                    or die("Failed to query db ".mysql_error());
      $rows= mysqli_fetch_array($query);

      //check if user and password matches
      if($rows['username']== $username && $rows['password']== $password){
          echo "<b>Welcome ".$rows['username'],"!!!</b>"," "," You are now logged in";
      }else{
       echo "<b>Username or Password doesn't match!</b>";
        }
              // user receives messages query 6
              session_start();

              $sql = "SELECT uid, username, sender_id from user, message where username=\"".$_POST["username"]."\"";
              $result = mysqli_query($connect, $sql);
              if($result)
              $uid=mysqli_fetch_assoc($result)["uid"];
              $_SESSION['uid'] = $uid;

              //using the function show_messages
              $messages = show_messages($_SESSION['uid']);

              if ($messages){
              ?>
              <table border='1' cellspacing='0' cellpadding='5' width='300'>
                <?php
                    echo "<p>Messages received by ".$_POST["username"]," :";

                    foreach ($messages as $key => $list){
                        echo "<tr valign='top'>\n";
                        //echo "<td>".$list['uid'] ."</td>\n";
                        echo "<td> Receiver: ".$_POST["username"] ."</td>\n";
                        $temp="select username from user where uid=".$list['sender_id'];
                        $temp_r=mysqli_query($connect,$temp);
                        $temp_f=mysqli_fetch_assoc($temp_r);
                        echo "<td>".$temp_f["username"] ."</td>\n";
                        echo "<td>".$list['body'] ."<br/>\n";
                        echo "<small>".$list['send_time'] ."</small></td>\n";
                        echo "</tr>\n";
                      }
                ?>
              </table>

                <?php
            }
          $connect -> close();

        }
      }
?>
