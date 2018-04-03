
<?php
//The file ProcessLogin.php is used to process login for the Q8
  session_start();
  include("mysql_connection.php");

  //check if the user and password are empty
  if(isset(($_POST['submit']))){
    //check if the user and password are empty
      if(empty($_POST['username']) || empty($_POST['password'])){
          echo "<b>Please enter Username and Password to log in!</b>";
      }else{
      //define user and password
      $username=$_POST['username'];
      $password=$_POST['password'];

          //fetch info of registered user and fnds user match
      $query = mysqli_query($connect, "SELECT * FROM user WHERE username='$username' AND password='$password'")
                            or die("Failed to query db ".mysql_error());;
        $rows= mysqli_num_rows($query);
        if($rows == 1)
          {
            $result=mysqli_fetch_assoc($query);
            $_SESSION["username"]=$username;
            $_SESSION["uid"]=$result["uid"];

          //redirect to another page, using user.php file to display a list of users
          header("Location: users.php");
        }
        echo "<b>Username or Password is invalid!</b>";
      // close connection
      mysqli_close($connect);
     }
   }
?>
