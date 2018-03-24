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

      //make connection
      $connect = mysqli_connect('localhost', 'root', '');

      //select db
      mysqli_select_db($connect, 'class_project');

      if(mysqli_connect_errno()){
        exit();
      }
      //fetch records
      $sql="SELECT * FROM twitts natural join user ORDER BY post_time DESC";

      $result = mysqli_query($connect, $sql);

      if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            echo "<p></p>";
            echo "<tr><td>".$row["username"];
            echo "<td>: <td>".$row["body"];
            echo "<td>,  <td>".$row["post_time"];
            echo "<th></th>";
        }
      }else{
        echo "No data.";
      }

      $connect -> close();
      ?>
  </head>



</html>
