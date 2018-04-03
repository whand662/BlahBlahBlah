
<?php
  session_start();
  include("mysql_connection.php");

  //variable to store error messages
  $error = '';
  //check if the user and password are empty
  if(isset(($_POST['submit'])))
    {
    if(empty($_POST['username']) || empty($_POST['password']))
    {
        $error ="Enter Username and Password";
    }else{
      //define user and password
      $username=$_POST['username'];
      $password=$_POST['password'];

      //fetch info of registered user and fnds user match
      $query = mysqli_query($connect, "SELECT * FROM user WHERE username='$username' AND password='$password'");
      $rows= mysqli_num_rows($query);
      if($rows == 1)
        {
          $result=mysqli_fetch_assoc($query);
          $_SESSION["username"]=$username;
          $_SESSION["uid"]=$result["uid"];

          //redirect to another page
          header("Location: index.php");

        }else{
          $error ="Username or Password is invalid" ;
        }
      // close connection
      mysqli_close($connect);
     }
   }
?>
