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
<title>Blog - Edit Post</title>
</head>
<body>
<?php

// >>>>> AUTHORIZATION BEGIN >>>>>>>>>

// If user is not authorized
if (!isset($_SESSION['id']))
{
	// Check cookies. Maybe, login and password are already set
	if (isset($_COOKIE['login']) && isset($_COOKIE['password']))
	{
		// If they exist, try to authorize
		$login = mysql_escape_string($_COOKIE['login']);
		$password = mysql_escape_string($_COOKIE['password']);

		//Connect to database and look for user with such login and password
		$query = "SELECT `u_id`
					FROM `users`
					WHERE `u_login`='{$login}' AND `u_pas`='{$password}'
					LIMIT 1";
		$sql = mysql_query($query) or die(mysql_error());

		// If such a user exists
		if (mysql_num_rows($sql) == 1)
		{
			// Make an ID mark in session
			$row = mysql_fetch_assoc($sql);
			$_SESSION['user_id'] = $row['u_id'];

		}
	}
}

//Select user from database's table with an ID from session
if (isset($_SESSION['user_id']))
{
	$query = "SELECT `u_login`
				FROM `users`
				WHERE `u_id`='{$_SESSION['user_id']}'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	
	// If there is no user, delete ID
	if (mysql_num_rows($sql) != 1)
	{
		header('Location: login.php?logout');
		exit;
	}
	
	$row = mysql_fetch_assoc($sql);
	
	$welcome = $row['u_login'];
}
else
{
	$welcome = 'guest';
}

include 'functions/functions.php';

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
<?php print '<h1>Welcome, ' . $welcome . '!</h1>'; ?>
</div>
</div>

<div id="bodywrap">
<div id="bottom-bg">
<div id="wrapper2">

    <div id="content">
    <img style="float: left;" alt="top" src="css/images/content-top.gif">
    
        <div id="left-div">
<?php

global $p_id, $c_id, $u_id, $c_text; 

$u_id = $_SESSION['user_id'];
$p_id = get_post("p_id");

// Deleting a post from blog, together with all the associated comments
if (isset($_POST['p_delete']) && isset($_POST['p_id']))
{
	$p_id = $_POST['p_id'];
	$query_del = "DELETE FROM posts WHERE p_id=$p_id LIMIT 1";
	$query_del_c = "DELETE FROM comments WHERE p_id=$p_id";
		if (!mysql_query($query_del, $db_server) || !mysql_query($query_del_c, $db_server) )
		{
			echo "DELETE failed: $query_del<br />" . mysql_error() . "<br /><br />";
		}
		else 
		{
			echo "You have successfully deleted the post.<br /><br />";
		}
}

// Updating a post 
if (isset($_POST['p_update']) && isset($_POST['p_id']) && isset($_POST['p_upd']))
{
	$p_id = $_POST['p_id'];
	$p_upd = $_POST['p_upd'];
	trim ($p_upd);
	$p_upd = addslashes($p_upd);
	
	$query_upd = "UPDATE posts SET p_text =  '$p_upd'  WHERE p_id=$p_id LIMIT 1";
		if (!mysql_query($query_upd, $db_server)) 
		{
			echo "UPDATE failed: $query_upd<br />" . mysql_error() . "<br /><br />";
		}
		else 
		{
			echo "You have successfully updated the post.<br /><br />";
		}
}

// Adding a new comment to the post
if (isset($_POST['c_add']) && isset($_POST['c_text']) ) 
{
	$c_text = $_POST['c_text'];
	trim ($c_text);
	$c_text = addslashes($c_text);
	$p_id = $_POST['p_id'];
	$query_ins = "INSERT INTO comments VALUES ('$p_id' , '', '$u_id', '$c_text')";
		if (!mysql_query($query_ins, $db_server)) 
		{
			echo "INSERT failed: $query_ins<br />" . mysql_error() . "<br /><br />";
		}
		else 
		{
			echo "You have successfully added a new comment.<br /><br />";
		}
}

// Deleting a comment from blog
if (isset($_POST['c_delete']) & isset($_POST['c_id']))
{
	$c_id = $_POST['c_id'];
	$query_del_c = "DELETE FROM comments WHERE c_id=$c_id LIMIT 1";
		
		if (!mysql_query($query_del_c, $db_server)) 
		{
			echo "DELETE failed: $query_del_c<br />" . mysql_error() . "<br /><br />";
		}
		else 
		{
			echo "You have successfully deleted a comment.<br /><br />";
		}
}

// Selecting all the posts from a blog's database
$query = "SELECT * FROM posts WHERE p_id = $p_id";
$result = mysql_query($query);
$myrow = mysql_fetch_array($result,MYSQL_ASSOC);
$p_id = $myrow['p_id'];

if(!$result) {echo "bad query";exit();}

// Selecting all the comments for the post
if ($myrow>1){
$query_c = "SELECT comments.c_id, users.u_login, users.u_mail, comments.c_text
			FROM users INNER JOIN (posts INNER JOIN comments ON $p_id = comments.p_id) ON users.u_id = comments.u_id GROUP BY c_id;";

$result_c = mysql_query($query_c);
$myrow_c = mysql_fetch_array($result_c,MYSQL_ASSOC);
	if(!$result_c) {echo "bad query";exit();}
}


// Shows all the posts created by the moment	
?>
                    <div class="home-left">
<?php

if ($myrow>0)
{
if  (isset($myrow) || isset($_POST['p_upd_cancel'])) 
	{
			?>
                        <div class="home-post-wrap">  
                        	<span class="post-info">               
                                <div class="invisible"> 
								<?php echo $myrow["p_id"]; ?>
                                </div>
                
                                <span class="date">
                                    <span class="date-left"></span>
                                    <span class="date-inside"><?php echo $myrow["p_date"]; ?></span>
                                </span>
                           	</span>
                            <div style="clear: both;"></div>
                
                            <h2 class="post_title">
							<?php echo $myrow["p_header"]; ?>
                            </h2>
                            <div style="clear: both;"></div>
                
                            <div>
                            
                            <?php
                            if (isset($_POST['p_edit']))
                            {                
                                //For the admin user, adds a possibility to edit post
            
                                    //Submit the changes
                                    echo'
                                    <form action="post.php" method="post">
                                    <input type="hidden" name="p_id" value="'.$myrow["p_id"].'">
                                    <textarea name="p_upd" cols="50" rows="10">'.$myrow["p_text"].'</textarea>
                                    <div>
                                    <input type="submit" name="p_update" value="Submit the Changes">
                                    </div>
                                    </form>';
                                    
                                    // Cancel the changes
                                    echo'
                                    <form action="post.php" method="post">
                                    <input type="hidden" name="p_id" value="'.$myrow["p_id"].'">
                                    <input type="submit" name="p_upd_cancel" value="Cancel the Changes">
                                    </form>';
                           
                            }
                            else
                            {
                            echo $myrow["p_text"];
								if ($welcome == 'admin')
								{
								echo'
								<form action="post.php" method="post">
								<input type="hidden" name="p_id" value="'.$myrow["p_id"].'">				
								<input type="submit" name="p_edit" value="Edit this Post">
								</form>';
								}
                            }
                            ?>
                            </div> <!-- empty class -->
                
 			<?php
 			// For registered users, adds a possibility to leave a comment
            if ($welcome != 'guest')
            { 				

				if ($welcome == 'admin')
				{ 
					// For the admin user, adds a possibility to delete post
					echo'
					<form action="post.php" method="post">
					<input type="hidden" name="p_id" value="'.$myrow["p_id"].'">
					<input type="submit" name="p_delete" value="Delete this Post">
					</form>';
                } 
	}
				
				// Shows all the comments if they exist
				if ($myrow_c>0)
				{
				do
				{
					echo'
					
					<div class="comment">
					<div class="invisible">'.$myrow_c["c_id"].'</div>
					<div class="post-author">'.$myrow_c["u_login"].' / '.$myrow_c["u_mail"].'</div><div>'.$myrow_c["c_text"].'</div>';
					
					// For the admin user, adds a possibility to delete comments
					if ($welcome == 'admin')
					{ 							
						echo '
						<div class="del_button">
						<form action="post.php" method="POST">
						<input type="hidden" name="c_id" value="'.$myrow_c["c_id"].'">
						<input type="hidden" name="p_id" value="'.$myrow["p_id"].'">
						<input type="submit" name="c_delete" value="Delete a Comment">
						</form>
						</div>';
					}
					?> </div> <!-- class="comment" --> <?php	
					
				}					
				while ($myrow_c = mysql_fetch_array($result_c,MYSQL_ASSOC));
				}
	?>
                        </div> <!--class="home-post-wrap" --> <?php				
					
			}

// Form for adding a comment
echo '
<form action="post.php" method="POST" id="commentform">
<table>
    <tr>
        <td>Please, write your comment: </td>
        <td><input type="hidden" name="p_id" value="'.$myrow["p_id"].'"></td>
    </tr>
    <tr>
        <td>Comment Text: </td>
        <td><textarea name="c_text" cols="30" rows="5"></textarea></td>
    </tr>
    <tr>
        <td><input type="submit" name="c_add" value="Add a New Comment" /></td>
    </tr>
</table>
</form>
';
}
?>

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
</div> <?php

include 'includes/disconnect-db.php';

?>

</div>
</body>
</html>