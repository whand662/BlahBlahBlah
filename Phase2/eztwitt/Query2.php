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
    </head>

    <?php

      include('mysql_connection.php');

      //fetch records
      $sql="SELECT username, magnitude
            FROM   (SELECT following_id as uid, COUNT(*) AS magnitude
                                                          FROM follow
                                                          GROUP BY following_id) AS temp natural join user
            WHERE  magnitude=(SELECT MAX(magnitude) FROM (SELECT following_id as uid, COUNT(*) AS magnitude
                                                          FROM follow
                                                          GROUP BY following_id) AS temp2);";

      $result = mysqli_query($connect, $sql);
      $connect -> close();

      if($result->num_rows == 1){
        $top=mysqli_fetch_assoc($result);
        echo "<p><b>".$top['username']." had the most followers with ".$top['magnitude']."</b></p>";
      }else if($result->num_rows > 1){
        while($top = mysqli_fetch_assoc($result)){
          echo "<p><b>".$top['username']." was tied for the most followers with ".$top['magnitude']."</b></p>";
        }
      }else{
        echo "<p><b>No one is following anyone!</b></p>";
      }

      ?>

</html>
