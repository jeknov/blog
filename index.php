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
    
   
    // 	>>>>> CONTENT BEGIN >>>>>>>>>
    
    global $p_id, $c_id, $p_header, $p_text; 
    
    // Adding a new post into database
    if (isset($_POST['p_add']) && isset($_POST['p_header']) && isset($_POST['p_text']) ) 
    {
        $p_header = $_POST['p_header'];
        $p_text = $_POST['p_text'];
        
        $query_ins = "INSERT INTO posts VALUES ('' , '$p_header', CURDATE(), '$p_text')";
            if (!mysql_query($query_ins, $db_server)) 
            {
                echo "INSERT failed: $query_ins<br />" . mysql_error() . "<br /><br />";
            }
            else 
            {
                echo "You have successfully added a new post.<br /><br />";
            }
    }
    
    // Deleting a post from blog
    if (isset($_POST['p_delete']) & isset($_POST['p_id']))
    {
        $p_id = $_POST['p_id'];
        $query_del = "DELETE FROM posts WHERE p_id=$p_id LIMIT 1";
            if (!mysql_query($query_del, $db_server)) 
            {
                echo "DELETE failed: $query_del<br />" . mysql_error() . "<br /><br />";
            }
            else 
            {
                echo "You have successfully deleted a post.<br /><br />";
            }
    }
    
    // Deleting a comment
    if (isset($_POST['c_delete']) & isset($_POST['c_id']))
    {
        $c_id = $_POST['c_id'];
        $query_del = "DELETE FROM comments WHERE c_id=$c_id LIMIT 1";
            if (!mysql_query($query_del, $db_server)) 
            {
                echo "DELETE failed: $query_del<br />" . mysql_error() . "<br /><br />";
            }
            else 
            {
                echo "You have successfully deleted a comment.<br /><br />";
            }
    }
    
    // Selecting all the posts from a blog's database
  
    $query = "SELECT * FROM posts ORDER BY p_id DESC";
    $result = mysql_query($query);
    $myrow = mysql_fetch_array($result,MYSQL_ASSOC);
    
    // Selecting all the comments for the post
    $query_c = "SELECT comments.* FROM (comments INNER JOIN posts ON comments.p_id = posts.p_id)";
    $result_c = mysql_query($query_c);
    $myrow_c = mysql_fetch_array($result_c,MYSQL_ASSOC);
    $num_c = mysql_num_rows($result_c);
    
    if(!$result) {echo "bad query";exit();}
    if(!$result_c) {echo "bad query";exit();}
    
    // Shows all the posts created by the moment	
?>	
                    <div class="home-left">
 <?php
        if (mysql_num_rows($result) > 0)
        {               
            do
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
                            <?php echo $myrow["p_text"]; ?>
                            </div>
                    <?php
                    // For registered users, adds a possibility to leave a comment
                    if ($welcome != 'guest')
                    { 
                    echo'
                    <form action="post.php" method="post">
                    <input type="hidden" name="p_id" value="'.$myrow["p_id"].'">
                    <input type="submit" name="c_add" value="Read Comments">
                    </form>';
                                        
                        if ($welcome == 'admin')
                        { 
                            //For the admin user, adds a possibility to edit and delete posts
                            echo'
                            <form action="post.php" method="post">
                            <input type="hidden" name="p_id" value="'.$myrow["p_id"].'">				
                            <input type="submit" name="p_edit" value="Edit this Post">
                            </form>
                            
                            <form action="index.php" method="post">
                            <input type="hidden" name="p_id" value="'.$myrow["p_id"].'">
                            <input type="submit" name="p_delete" value="Delete this Post">
                            </form>';
                        } 
                    }
        				?></div> <!-- class="home-post-wrap" --><?php              
			  }
              while ($myrow = mysql_fetch_array($result,MYSQL_ASSOC)); 
          }
        
        
        // Area for administrator
        if ($welcome=='admin')
            
        {	
        ?>
        
        <!--For the admin user, adds a possibility to create a new post-->
        
        <form action="index.php" method="POST">
        <table>
            <tr>
                <td>Post Title: </td>
                <td><input type="text" name="p_header" size="40" maxsize="100" /></td>
            </tr>
            <tr>
                <td>Post Text: </td>
                <td><textarea name="p_text" cols="50" rows="10"></textarea></td>
            </tr>
            <tr>
                <td><input type="submit" name="p_add" value="Add a New Post" /></td>
            </tr>
        </table>
        </form>


		<?php
        }
        // End of area for administrator
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
</div>

<?php

include 'includes/disconnect-db.php';

?>

</body>
</html>