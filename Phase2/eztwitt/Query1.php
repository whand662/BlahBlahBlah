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
      //make connection with database
      require_once('mysql_connection.php');

      $sql="SELECT body, magnitude
            FROM (SELECT tid, COUNT(*) AS magnitude
                  FROM thumb
                  GROUP BY tid) AS temp natural join twitts
            WHERE  magnitude=(SELECT MAX(magnitude) FROM (SELECT tid, COUNT(*) AS magnitude
                                                          FROM thumb
                                                          GROUP BY tid) AS temp2);";

      $result = mysqli_query($connect, $sql);
      $connect -> close();
      if($result->num_rows == 1){
        $top=mysqli_fetch_assoc($result);
        echo "<p><b>\"".$top['body']."\" had the most likes with ".$top['magnitude']."</b></p>";
      }else if($result->num_rows > 1){
        while($top = mysqli_fetch_assoc($result)){
          echo "<p><b>\"".$top['body']."\" was tied for the most likes with ".$top['magnitude']."</b></p>";
        }
      }else{
        echo "<p><b>There are no likes!</b></p>";
      }

      ?>
  </head>

</html>
