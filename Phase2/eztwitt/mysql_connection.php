<?php

  $dbhost = 'localhost';
  $dbroot = 'root';
  $dbpassw = '';
  $dbname = 'class_project';


    //
    $connect = mysqli_connect($dbhost, $dbroot, $dbpassw);

    //select db
    mysqli_select_db($connect, $dbname);

    if(mysqli_connect_errno()){
      echo "<h1>Sorry, could not connect to database.";
      exit();
    }
?>
