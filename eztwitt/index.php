<?php
session_start();
include 'mysql_connection.php';
include 'functions.php';

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

</head>
<body>
  <p>Post new twitt:</p>
  <form method='POST' action="index.php?id=<?php echo $_SESSION["uid"]; ?>">
    <input type='text' name='combody' >
          <button type='submit' name='commentSubmit'>Post</button>
    </form>
</body>

</html>

<?php
$dsql = "SELECT t.uid, t.body, t.post_time, u.username from twitts t,
              user u where u.uid=".$_SESSION['uid']." and t.uid=u.uid order by t.post_time DESC";

$dresult= mysqli_query($connect, $dsql);

if($dresult)
  $uid=mysqli_fetch_assoc($dresult)["uid"];

  $posts = show_posts($_SESSION['uid']);
  if (count($posts)){

    echo "<br></br> ";

  foreach ($posts as $key => $list){
      echo "<p>".$list['body']."\t(<small>".$list['post_time']."</small>)</p>";
    }

}else{
  echo "No data.";
}

if(isset($_POST['commentSubmit'])){
  $uid = $_GET['id'];
  $body = $_POST['combody'];

  //query to post new twitt
  $sql = "insert into twitts values (null,'$uid', '$body',NOW())";

  $result = mysqli_query($connect, $sql);
  if($result){
      header("Location: index.php");
  }
  mysqli_close($connect);
}
?>
