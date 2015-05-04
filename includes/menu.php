<?php

print '

<div class="Menu">

<ul>
<li><a href="index.php">Home</a></li>';

if (!isset($_SESSION['user_id']))
{

	print '	<li><a href="register.php">Register, if You Are a New User</a></li>
		   	<li><a href="login.php">Login, if You Are a Registered User</a></li>';
}
else
{
	print '<li><a href="login.php?logout">Logout</a></li>';
}

print '</ul></div>';
?>