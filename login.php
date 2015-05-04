<?php
session_start();
ob_start();
//Connect to database and check the connection
require_once 'includes/login-db.php';
include 'includes/connect-db.php';

print'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css" media="all">
@import "css/style.css";
</style>
<title>Blog - Edit Post</title>
</head>
<body>';

if (isset($_GET['logout']))
{
	if (isset($_SESSION['user_id']))
		unset($_SESSION['user_id']);
		
	setcookie('login', '', 0, "/");
	setcookie('password', '', 0, "/");
	header('Location: index.php');
	exit;
}

if (isset($_SESSION['user_id']))
{
	// vartotojas prisiloginines, perkeliam ji i uzdara psulapi
	
	header('Location: index.php');  // buvo perkelimas i closed.php
	exit;

}

?>

<div class="logo">
    <a href="http://localhost/blog/index.php">
    <img class="logo-image" alt="logo" src="css/images/logo.gif"></a>
    <img style="float: left; margin-top: 3px;" alt="logo" src="css/images/slogan-left.gif">
        <div class="slogan">
        Evindar Marouf weblog
        </div>
    <img style="float: left; margin-top: 3px;" alt="logo" src="css/images/slogan-right.gif">
</div>


<div id="pages">
<div id="pages-inside">
<?php print '<h1>Welcome, guest!</h1>'; ?>
</div>
</div>

<div id="bodywrap">
<div id="bottom-bg">
<div id="wrapper2">
<div id="content">
    <img style="float: left;" alt="top" src="css/images/content-top.gif">
    
        <div id="left-div"><?php

if (!empty($_POST))
{
	$login = (isset($_POST['login'])) ? mysql_real_escape_string($_POST['login']) : '';
	
	$query = "SELECT `u_salt`
				FROM `users`
				WHERE `u_login`='{$login}'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	
	$query_a = "SELECT `u_active`
				FROM `users`
				WHERE `u_login`='{$login}'
				LIMIT 1";
	$sql_a = mysql_query($query_a) or die(mysql_error());
	$myrow_a = mysql_fetch_array($sql_a,MYSQL_ASSOC);
	$active=$myrow_a['u_active'];

if ($myrow_a['u_active'] == false)
{
echo '<h3>User has not been activated. Please, visit your email and finalize registration.</h3>';	
}
else
{
	if (mysql_num_rows($sql) == 1)
	{
		$row = mysql_fetch_assoc($sql);
		
		// stai salt, atitinkanti loginui
		$salt = $row['u_salt'];
		
		// hashuojam passworda ir kartojame anksciau aprasytus zingsnus
		$password = md5(md5($_POST['password']) . $salt);
		
		// susijungiam su database
		//  ir ieskom useri su tokiu loginu ir passwordu

		$query = "SELECT `u_id`
					FROM `users`
					WHERE `u_login`='{$login}' AND `u_pas`='{$password}'
					LIMIT 1";
		$sql = mysql_query($query) or die(mysql_error());


		// jei toks user atsirado
		if (mysql_num_rows($sql) == 1)
		{
			// padarom zyme sesijoje (ID zyme)

			$row = mysql_fetch_assoc($sql);
			$_SESSION['user_id'] = $row['u_id'];
			
			// Jei vartotojas pasirinko "remember me"
			// i cookies idedam logina ir passwordo hash'a
			
			$time = 86400; // 24 val cookies
			
			if (isset($_POST['remember']))
			{
				setcookie('login', $login, time()+$time, "/");
				setcookie('password', $password, time()+$time, "/");
			}
			
			// perkeliam i uzddara puslapi closed.php
			header('Location: index.php');
			exit;

		}
		else
		{
			echo '<h4>These login and password are not valid.</h4><br />';
			
		}
	}
	else
	{
		echo '<h4>User with such a login was not found.</h4><br />';
	}
}
}?>
            <div class="home-left">
            <div class="home-post-wrap">
<?php
print '
<h3>Please, login as a registered user:</h3>
<form action="login.php" method="post">
	<table>
		<tr>
			<td>Login name:</td>
			<td><input type="text" name="login" /></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="password" /></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Log In" /></td>
		</tr>
	</table>
</form>
';
?>
			<div style="clear: both;"></div>
            </div> <!--class="home-post-wrap" -->
            </div> <!-- class="home-left" -->
        </div> <!-- class="left-div" -->

        <div id="sidebar">
            <div class="sidebar-box-wrap">
                <div class="sidebar-box">
                    <span class="sidebar-box-title">Menu</span>
                    <div>
                    <?php include 'includes/menu.php';?>
                    </div>
                </div>
            </div>
        </div>
    
    <div style="clear: both;"></div>
        
    <img style="float: left;" alt="top" src="css/images/content-bottom.gif">
                    
    </div>
	<div style="clear: both;"></div>
    
</div>
</div>
</div>
<?php
include 'includes/disconnect-db.php';
ob_end_flush();
print'
</div>
</body>
</html>';?>