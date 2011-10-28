<?php
// Load settings
include '../objects/pullsettings.php';

// Get login information
if($_SERVER['REQUEST_METHOD'] == "POST") {
    include '../objects/opendb.php';
    $username = mysql_real_escape_string($_POST['username']);
    $password = mysql_real_escape_string($_POST['password']);
    $result = mysql_query("SELECT role FROM pib_users WHERE username='$username' AND password=md5('$password') AND verified='1'");

	while($row = mysql_fetch_array($result, MYSQL_NUM)) { 
		list($user_role) = $row;
	}
	
	if(mysql_num_rows($result) > 0) {
		$_SESSION['is_logged_in'] = 1;
		$_SESSION['username'] = $username;
		$_SESSION['user_role'] = $user_role;
	}
	else {
		echo "Incorrect username and password.";
	}
    
    include '../objects/closedb.php';
}

?>

<html>

<head>
	<link rel="stylesheet" type="text/css" href="adminstyle.css" />
</head>

<body>

	<div id="topbar">
		<a id="site_url" href="<?php echo $site_url; ?>"><?php echo $site_name; ?> - Back to site</a>
		<?php if(isset($_SESSION['is_logged_in'])) { ?><a id="logout" href="../login.php?logout=yes&referer=<?php echo curPageURL(); ?>">Logout</a><?php } ?>
	</div>

	<div id="content">
<?php // Check if logged in
if(isset($_SESSION['is_logged_in'])) {
	// Check if logged in user is an Administrator
	if($_SESSION['user_role'] == "3") {
		// User is logged in as admin, display navigation ?>
		<ul id="adminnav">
			<li><a href="settings.php">Settings</a></li>
			<li><a href="manageposts.php">Posts</a></li>
			<li><a href="managepages.php">Pages</a></li>
			<li><a href="manageusers.php">Users</a></li>
			<li><a href="managecomments.php">Comments</a></li>
		</ul>
	<?php }
	else {
		// User is not an admin, display message ?>
		<p>You do not have access to this section.</p>
	<?php }
}
else {
	// Not logged in, display login box ?>
	<form method="post" action="index.php" id="loginbox">
		<h3>Admin Login</h3>
		<p>Username<br /><input type="text" name="username" value="" /></p>
		<p>Password<br /><input type="password" name="password" value="" /></p>
		<p><input type="submit" value="Login" /></p>
	</form>
<?php } ?>

	</div>






	

</body>

</html>