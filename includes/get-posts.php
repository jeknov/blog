<?php //get-posts.php
$query = "SELECT * FROM posts";
$result = mysql_query($query);
$rows = mysql_num_rows($result);

if (!$result) die ("Database access failed: " . mysql_error());
?>