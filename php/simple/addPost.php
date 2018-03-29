<?php
  include 'mysql_connection.php';

if(isset($_POST['commentSubmit'])){
    $uid = $_GET['id'];
    $body = $_POST['combody'];

    //query to post new twitt
    $sql = "insert INTO twitts VALUES (null,'$uid', '$body',NOW())";
    //echo $sql;

    $result = mysqli_query($connect, $sql);
    if($result)
    echo "The user posted new twitt.";

}
 ?>
