<!DOCTYPE html>
<html lang="en">
<?php
  include("mysql_connection.php");
  include('functions.php');

  if(isset(($_POST['submit']))){
    //check if the user and password are empty
    if(empty($_POST['username']) || empty($_POST['password'])){
      echo "<b>Please enter Username and Password to log in!</b>";
      echo "<script>";
      echo "  setTimeout(goHome, 3000);";
      echo "  function goHome() {";
      echo "    window.location.href = 'Page.php';";
      echo "  }";
      echo "</script>";
    }else{
      //define user and password
      $username=$_POST['username'];
      $password=$_POST['password'];
      $target = $_POST['target'];

      //to prevent mysql injection
      $username = stripcslashes($username);
      $password = stripcslashes($password);
      $username = mysqli_real_escape_string($connect, $username);
      $password = mysqli_real_escape_string($connect, $password);

      //fetch info of user and fnds user match
      $query = mysqli_query($connect, "SELECT * FROM user WHERE username='$username' AND password='$password'")
                    or die("Failed to query db ".mysql_error());
      $rows= mysqli_fetch_array($query);
      $connect -> close();

      //check if user and password matches
      if($rows['username']== $username && $rows['password']== $password){
          echo "<b>Welcome ".$rows['username'],"!!!</b>"," "," You are now logged in";
          $uid = $rows['uid'];
          echo "<script>";
          echo "  setTimeout(goHome, 3000);";
          echo "  function goHome() {";
          echo "    window.location.href = '$target?uid=$uid';";
          echo "  }";
          echo "</script>";
      }else{
          echo "<b>Username or Password doesn't match!</b>";
          echo "<script>";
          echo "  setTimeout(goHome, 3000);";
          echo "  function goHome() {";
          echo "    window.location.href = 'Page.php';";
          echo "  }";
          echo "</script>";
      }

    }


  }
?>
</html>
