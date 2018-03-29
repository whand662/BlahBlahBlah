<?php
$posts = show_posts($_SESSION['uid']);

if (count($posts)){
?>
<table border='1' cellspacing='0' cellpadding='5' width='500'>

<?php
foreach ($posts as $key => $list){
    echo "<tr valign='top'>\n";
    echo "<td>".$list['userid'] ."</td>\n";
    echo "<td>".$list['body'] ."<br/>\n";
    echo "<small>".$list['stamp'] ."</small></td>\n";
    echo "</tr>\n";
}
?>
</table>
<?php
}else{
?>
<p><b>You haven't posted anything yet!</b></p>
<?php
}
?>
