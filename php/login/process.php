
<?php
  $error = '';//variable to store error messages
  if(isset(($_POST['submit'])))
    {
    if(empty($_POST['username']) || empty($_POST['password']))
    {
        $error ="Username or Password is invalid";
    }else{
      //define user and password
      $username=$_POST['username'];
      $password=$_POST['password'];
      //connection with the server
      $connect = mysqli_connect("localhost", "root", "");
      //select database
      $db = mysqli_select_db($connect, "class_project");
      //fetch info of registered user and fnds user match
      $query = mysqli_query($connect, "SELECT * FROM user WHERE username='$username' AND password='$password'");
      $rows= mysqli_num_rows($query);
      if($rows == 1)
        {
          //redirect to another page
          header("Location: welcome.php");
        }else{
          $error ="Username or Password is invalid" ;
        }
      mysqli_close($connect);// close connection
     }
   }
?>
