<?php //get-users.php
$query = "SELECT * FROM users";
$result = mysql_query($query);
$rows = mysql_num_rows($result);

if (!$result) die ("Database access failed: " . mysql_error());
?>