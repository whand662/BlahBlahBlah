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

      //fetch records
      $sql="SELECT t.tid, b.body AS Post  FROM thumb t, twitts b
            WHERE t.tid=b.tid GROUP BY tid ORDER BY COUNT(*) DESC LIMIT 1";

      $result = mysqli_query($connect, $sql);

      if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            echo "<h1 style=font-size:100%;>The post that has the most number of likes is: </h1>";
            echo "<tr>Twitter id <td>".$row["tid"];
            echo "<td>: <td>".$row["Post"];
        }

      }else{
        echo "No data.";
      }

      $connect -> close();
      ?>
  </head>



</html>
