<?php
// OPEN PHP SESSION
session_start();

// *** Retrieve settings ***
	$site_url = retrieveSetting("site_url");
	$site_name = retrieveSetting("site_name");
	$site_slogan = retrieveSetting("site_slogan");
	$site_description = retrieveSetting("site_description");
	$admin_email = retrieveSetting("admin_email");
	$who_can_post = retrieveSetting("who_can_post");
	$site_membership = retrieveSetting("site_membership");
	$site_visibility = retrieveSetting("site_visibility");
	$onoff_comments = retrieveSetting("onoff_comments");
	$who_can_comment = retrieveSetting("who_can_comment");
	$theme = retrieveSetting("theme");


// FUNCTIONS
function retrieveSetting($settingname) {
	include 'opendb.php'; // Open DB connection
	$result = mysql_query("SELECT Value FROM $table_settings WHERE Name = '$settingname'") or die('Error : ' . mysql_error());
	include 'closedb.php'; // Close DB
	
	while($row = mysql_fetch_array($result)) { $settingvalue = $row['Value']; } // Get value from array
	return $settingvalue; // Return the value for the queried setting
}

// Function: Update settings 
function updateSetting($settingname, $settingvalue) {
	include 'opendb.php';
	mysql_query("UPDATE $table_settings SET Value = '$settingvalue' WHERE Name = '$settingname'") or die('Error : ' . mysql_error());
	include 'closedb.php';
}

// FUNCTION: Add User
function addUser($username, $password, $email, $fullname, $website, $bio, $user_role) {
	include 'opendb.php'; // Open database connection
    mysql_query("INSERT INTO $table_users (username, password, email, fullname, website, bio, role, verified) VALUES ('$username', '$password', '$email', '$fullname', '$website', '$bio', '$user_role', '1')") or die('Error : ' . mysql_error());
    include 'closedb.php'; // Close database connection
}

// FUNCTION: Delete post function
function deletePost($id) {
	include 'opendb.php'; // Open database connection
    mysql_query("DELETE FROM $table_posts WHERE id='$id'") or die('Error : ' . mysql_error());
    include 'closedb.php'; // Close database connection
}

// FUNCTION: Delete page function
function deletePage($id) {
	include 'opendb.php'; // Open database connection
    mysql_query("DELETE FROM $table_pages WHERE id='$id'") or die('Error : ' . mysql_error());
    include 'closedb.php'; // Close database connection
}

// FUNCTION: Delete user function
function deleteUser($user) {
	include 'opendb.php'; // Open database connection
    mysql_query("DELETE FROM $table_users WHERE username='$user'") or die('Error : ' . mysql_error());
    include 'closedb.php'; // Close database connection
}

// Function: Display navigation in a list
function list_navigation() {
	$before_tag = "<li>";
	$end_tag = "</li>";
	// List pages
	include 'opendb.php'; // Open database connection
	$result = mysql_query("SELECT id, title FROM $table_pages ORDER BY ordernum, title") or die('Error : ' . mysql_error());
	while($row = mysql_fetch_array($result, MYSQL_NUM)) {
		list($id, $title) = $row;
		$list_navigation .= $before_tag.'<a href="page.php?id='.$id.'">'.$title.'</a>'.$end_tag;
	}
	include 'closedb.php';
	
	// Other links: Sign Up, Login, Logout, & Admin
	if(!isset($_SESSION['is_logged_in'])) {  // Show links below if user isn't logged in
		$site_membership = retrieveSetting("site_membership");
		if($site_membership == "0") { 
			$list_navigation .= $before_tag.'<a href="join.php">Sign Up</a>'.$end_tag;
		} // Only displays join link if users can register
		$list_navigation .= $before_tag.'<a href="login.php">Login</a>'.$end_tag;
	} 
	else { // Show these links if user is logged in
		$list_navigation .= $before_tag.'<a href="user.php?user='.$_SESSION['username'].'">Profile</a>'.$end_tag;
		if($_SESSION['user_role'] == "3") { 
			$list_navigation .= $before_tag.'<a href="./admin/">Admin</a>'.$end_tag;
			$list_navigation .= $before_tag.'<a href="createpage.php">Create Page</a>'.$end_tag;
		} // Show admin link, if admin is logged in
		$list_navigation .= $before_tag.'<a href="login.php?logout=yes&referer='.curPageURL().'">Logout</a>'.$end_tag;
	}
	
	return $list_navigation;
}

// Function: Display comments
function displayComments($postid, $numofcomments, $start) {
	include 'opendb.php';
	$comments = mysql_query("SELECT username, content, timestamp FROM $table_comments WHERE post_id = '$postid' AND approved='1' ORDER BY timestamp DESC LIMIT $start, $numofcomments ") or die('Error : ' . mysql_error());
	while($commentrow = mysql_fetch_array($comments, MYSQL_NUM)) { 
		list($commentusername, $commentcontent, $commenttime) = $commentrow;
		$commentcontent = stripslashes($commentcontent);
		$display_comments .= '<div class="comment">';
		$display_comments .= '<div class="commentmeta"><a href="user?user='.commentusername.'">'.$commentusername.'</a> says: ('.$commenttime.')</div>';
		$display_comments .= '<div class="commentcontent">'.$commentcontent.'</div>';
		$display_comments .= '</div>';
	} 
	include 'closedb.php';
	
	return $display_comments;
}

// Function: Display full posts
function displayFullPosts($numofposts, $start) {
	$numofposts = 10;
	include 'opendb.php';
	$result = mysql_query("SELECT * FROM $table_posts ORDER BY timestamp DESC LIMIT $start, $numofposts") or die('Error : ' . mysql_error());
	while($row = mysql_fetch_array($result, MYSQL_NUM)) {
		list($id, $content, $timestamp, $author, $title) = $row;
		$content = stripslashes($content);
		
		$display_posts .= '<div class="post">';
		if(!$title == "") { $display_posts .= '<a href="post.php?id='.$id.'"><h3 class="title">'.$title.'</h3></a>'; } // If post has title, display it.
		$display_posts .= '<div class="postcontent">'.$content.'</div>';
		$display_posts .= '<div class="postmeta">'.$timestamp.' by <a href="user.php?user='.$author.'">'.$author.'</a></div>';
		$display_posts .= '<div class="postnavs"><a href="post.php?id='.$id.'">View</a> | <a href="post.php?id='.$id.'#comment">Comment</a>';
		$user_role = getRole();
		$current_user = getCurrentUser();
		if($user_role  == "3" || $current_user == $author) { $display_posts .= ' | <a href="editpost.php?id='.$id.'">Edit</a>'; }
		$display_posts .= '</div>';
		$display_posts .= '</div>';		
	}
	include 'closedb.php';
	
	return $display_posts;
}

// Function: Display excerpts
function displayExcerpts($numofposts, $start, $excerptLen) {
	$numofposts = 10;
	$excerptLen = 300;
	
	include 'opendb.php';
	$result = mysql_query("SELECT * FROM $table_posts ORDER BY timestamp DESC LIMIT $start, $numofposts") or die('Error : ' . mysql_error());
	while($row = mysql_fetch_array($result, MYSQL_NUM)) {
		list($id, $content, $timestamp, $author, $title) = $row;
		$content = stripslashes($content);
		
		// Truncate content by limit
		$content = truncate($content, $excerptLen);
		
		$display_posts .= '<div class="post">';
		if(!$title == "") { $display_posts .= '<a href="post.php?id='.$id.'"><h3 class="title">'.$title.'</h3></a>'; } // If post has title, display it.
		$display_posts .= '<div class="postcontent">'.$content.'</div>';
		$display_posts .= '<div class="postmeta">'.$timestamp.' by <a href="user.php?user='.$author.'">'.$author.'</a></div>';
		$display_posts .= '<div class="postnavs"><a href="post.php?id='.$id.'">View</a> | <a href="post.php?id='.$id.'#comment">Comment</a>';
		$user_role = getRole();
		$current_user = getCurrentUser();
		if($user_role  == "3" || $current_user == $author) { $display_posts .= ' | <a href="editpost.php?id='.$id.'">Edit</a>'; }
		$display_posts .= '</div>';
		$display_posts .= '</div>';		
	}
	include 'closedb.php';
	
	return $display_posts;
}

//Function: Display excerpts with no embedded media
function displayExcerptsNoMedia() {
	
}

// Function: Gets URL for current page
function curPageURL() {
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} 
	else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

// Function: Get User Role
function getRole() {
	if(isset($_SESSION['is_logged_in'])) {
		$role = $_SESSION['user_role']; // Role equal to session role
	}
	else {
		$role = "0"; // Public role
	}
	return $role;
}

// Function: Get Current User
function getCurrentUser() {
	if(isset($_SESSION['is_logged_in'])) {
		$user = $_SESSION['username'];
	}
	else {
		$user = "Anonymous";
	}
	return $user;
}

// Function: Truncate String
function truncate($string, $limit) {
	$strLen = strlen($string);
	
	// Check if limit is there
	if(!isset($limit)) { $limit = $strLen; }
	
	if($strLen <= $limit) {
		return $string;
	}
	else {
		$string = substr($string, 0, $limit);
		return $string;
	}
	

}

?>