<?php

session_start();

//Connect to database and check the connection
require_once 'includes/login-db.php';
include 'includes/connect-db.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css" media="all">
@import "css/style.css";
.style4 {color: #9CD1A0}
</style>
<title>Blog - Home Page</title>
</head>
<body>

<?php
/*
** Function for salt generation, used for hashing password
** creates 3 random symbols
*/

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
    
        <div id="left-div">
<?php

function GenerateSalt($n=3)
{
	$key = '';
	$pattern = '1234567890abcdefghijklmnopqrstuvwxyz.,*_-=+';
	$counter = strlen($pattern)-1;
	for($i=0; $i<$n; $i++)
	{
		$key .= $pattern{rand(0,$counter)};
	}
	return $key;
}


?>
            <div class="home-left">
            <div class="home-post-wrap"> 
<?php

if (empty($_POST))
{
	?>
	
	<h3>Please, register as a new user:</h3>
	
	<form action="register.php" method="post">
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
				<td>Email:</td>
				<td><input type="mail" name="mail" /></td>
			</tr> 
			<tr>
				<td></td>
				<td><input type="submit" value="Register" /></td>
			</tr>
		</table>
	</form>
	
	
	<?php
}
else
{

	
	// Process data
	$login = (isset($_POST['login'])) ? mysql_real_escape_string($_POST['login']) : '';
	$password = (isset($_POST['password'])) ? mysql_real_escape_string($_POST['password']) : '';
	$mail = (isset($_POST['mail'])) ? mysql_real_escape_string($_POST['mail']) : '';
	$u_id = (isset($_POST['u_id'])) ? mysql_real_escape_string($_POST['u_id']) : '';

	
	// Check for wrong login and password input
	
	$error = false;
	$errort = '';
	
	if (strlen($login) < 3)
	{
		$error = true;
		$errort .= 'Length of login name must be at least 3 symbols.<br />';
	}
	if (strlen($password) < 3)
	{
		$error = true;
		$errort .= 'Password must be at least 6 symbols long.<br />';
	}
	if (strlen($mail) < 1)
	{
		$error = true;
		$errort .= 'Please, enter an email.<br />';
	}
	
	// Check if such a user name exists
	$query = "SELECT `u_id`
				FROM `users`
				WHERE `u_login`='{$login}'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($sql)==1)
	{
		$error = true;
		$errort .= 'Please, choose another user name, this one is already reserved.<br />';
	}

	// Check if such an email exists
	$query2 = "SELECT `u_id`
				FROM `users`
				WHERE `u_mail`='{$mail}'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($sql)==1)
	{
		$error = true;
		$errort .= 'Please, choose another email, this one is already reserved.<br />';
	}	
	
	// If there are no errors, insert user into user table
	
	if (!$error)
	{
		// Generate salt and password
		
		$salt = GenerateSalt();
		$hashed_password = md5(md5($password) . $salt);
		$hashed_login = md5(md5($login) . $salt);
		
		$query = "INSERT
					INTO `users`
					SET
						`u_login`='{$login}',
						`u_pas`='{$hashed_password}',
						`u_salt`='{$salt}',
						 `u_mail`='{$mail}'";
		$sql = mysql_query($query) or die(mysql_error());

		//Send authorization confirmation email		
		$to =  $_REQUEST['mail'] ;
		$subject = "Authorization Confirmation";
		$message = "
		Hello,
		
		Thank you for signing up for an account on my weblog. 
		
		In order to complete your account registration, I need you to click on the following confirmation link:
		
					http://student.educ.umu.se/~jeno0019/6IT014vt10/blog/activate.php?activate=".$login."
		
		This one time step is required to complete your signup. After confirmation, you can login to your account using your username and password.
					
		If you did not signup for an account on my website, please discard this message.
		
		Best regards,
		Weblog Author
		Evindar Marouf" ;
		$headers = "From: jeno0019@student.umu.se";
		$sent = mail($to, $subject, $message, $headers) ;
		//Send authorization confirmation email	--> End
		
		print '<h4>Congratulation! You have successfully created a new account. <br />
		Authorization confirmation message was sent by the email address you proposed.
		Please, visit your inbox and complete you registration process, as explained in the sent message. </h4>';


	}
	else
	{
		print '<h4>The following errors occured</h4>' . $errort;
	}
}
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

?>

</div>
</body>
</html>