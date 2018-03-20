<!DOCTYPE html>
<html>
  <head>
    <style>

      table{
        border-collapse: collapse;
        width: 100%;
        color: #588c7e;
        font-family: monospace;
        font-size: 17px;
        text-align: left;
      }
      td{
        border-collapse
        padding: 5px;
      }
      th{
        padding: 5px;
        text-align: left;
        background-color: #588c7e;
        color: white;
      }
      tr:nth-child(even) {background-color: #f2f2f2}
      </style>

  </head>
        <body>
        <table style="width:100%">
            <tr>
              <th>Username</th>
              <th>Password</th>
              <th>Email</th>
              <th>Location</th>
            </tr>

            <?php

              //make connection
              $connect = mysqli_connect('localhost', 'root', '');

              //select db
              mysqli_select_db($connect, 'class_project');

              if(mysqli_connect_errno()){
                exit();
              }
              //fetch records
              $sql="SELECT * FROM user";

              $result = mysqli_query($connect, $sql);

              if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr><td>".$row["username"];
                    echo "<td><td>".$row["password"];
                    echo "<td><td>".$row["email"];
                    echo "<td><td>".$row["location"];
                }
                echo "</table>";
              }else{
                echo "No data.";
              }

              $connect -> close();
              ?>


        </body>
      </html>
