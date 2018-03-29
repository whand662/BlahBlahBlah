
<?php
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

      //to prevent mysql injection
      $username = stripcslashes($username);
      $password = stripcslashes($password);
      $username = mysqli_real_escape_string($connect, $username);
      $password = mysqli_real_escape_string($connect, $password);

      //fetch info of registered user and fnds user match
      $query = mysqli_query($connect, "SELECT * FROM user WHERE username='$username' AND password='$password'")
                            or die("Failed to query db ".mysql_error());;
        $rows= mysqli_fetch_array($query);

        //check if user and password matches
        if($rows['username']== $username && $rows['password']== $password){
            //echo "<b>Welcome ".$rows['username'],"!!!</b>"," "," You are now logged in";
        }else{
         echo "<b>Username or Password doesn't match!</b>";
          }
          //redirect to another page
          header("Location: users.php");


      // close connection
      mysqli_close($connect);
     }
   }
?>
