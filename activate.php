<?php
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
<?php print '<h1>Welcome!</h1>'; ?>
</div>
</div>

<div id="bodywrap">
<div id="bottom-bg">
<div id="wrapper2">
<div id="content">
    <img style="float: left;" alt="top" src="css/images/content-top.gif">
    
        <div id="left-div">
		
		<?php

// Get data from a loaded link
$login = '"'.$_GET['activate'].'"';
mysql_real_escape_string($_GET['activate']);
trim ($login);

//Update user activity status
$query_a = "UPDATE users SET u_active = true  WHERE u_login=$login";
$sql_a = mysql_query($query_a) or die(mysql_error());
	

?>
            <div class="home-left">
            <div class="home-post-wrap">
<?php
		if (!mysql_query($query_a, $db_server)) 
		{
			echo "AUTHORIZATION failed: $query_a<br />" . mysql_error() . "<br /><br />";
		}
		else 
		{
			echo "<h4>You have successfully finalized your authorization process. Now, you can login to your account using your username and password.</h4><br /><br />";
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
print'
</div>
</body>
</html>';?>