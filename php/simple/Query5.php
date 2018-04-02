<?php
  include("mysql_connection.php");
?>
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

    $year1 = $_POST["year"];
    $year2 = $year1 + 1;
    $sql="SELECT username, magnitude
          FROM   (SELECT uid, COUNT(*) AS magnitude
      		FROM twitts
      		GROUP BY uid
      		ORDER BY magnitude DESC) AS temp natural join user
          WHERE  magnitude=(SELECT MAX(magnitude) FROM (SELECT uid, COUNT(*) AS magnitude
                                                        FROM twitts
                                                        GROUP BY uid
                                                        ORDER BY magnitude DESC) AS temp2);
";
    $result = mysqli_query($connect, $sql);
    $connect -> close();
    if($result->num_rows == 1){
      $top=mysqli_fetch_assoc($result);
      echo "<p><b>".$top['username']." had the most posts in $year1 with ".$top['magnitude']."</b></p>";
    }else if($result->num_rows > 1){
      while($top = mysqli_fetch_assoc($result)){
        echo "<p><b>".$top['username']." was tied for the most posts in $year1 with ".$top['magnitude']."</b></p>";
      }
    }else{
      echo "<p><b>There are no twits from that year!</b></p>";
    }

  ?>
  </head>

</html>
