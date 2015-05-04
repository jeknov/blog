<?php //functions.php
function get_post($var)
{
	return mysql_real_escape_string($_POST[$var]);
}
?>