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
      $sql="SELECT a.location, COUNT(b.body) AS KeywordFlu
                    FROM user a, twitts b
                    WHERE a.uid=b.uid AND (b.body REGEXP '[ .!,?]flu[ .!,?]' OR b.body REGEXP '^flu[ .!,?]' OR b.body REGEXP '[ .!,?]flu$')
                    GROUP BY a.location";
      $result = mysqli_query($connect, $sql);

      if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
          //  echo "<h1 style=font-size:100%;>Result Q3</h1>";
            echo "<p> </p>".$row["location"];
            echo " - ", "<td> <td>".$row["KeywordFlu"];
        }

      }else{
        echo "No data.";
      }

      $connect -> close();
      ?>
  </head>



</html>
