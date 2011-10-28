<?php include '../objects/pullsettings.php'; ?>
<?php 
$user_role = getRole(); // Get user role
if(!$user_role == "3"){
	// Redirect to login (index)
	header( 'location:index.php' );
}
else { // Display content ?>

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

	<ul id="adminnav">
		<li><a href="settings.php">Settings</a></li>
		<li><a href="manageposts.php">Posts</a></li>
		<li><a href="managepages.php" class="active">Pages</a></li>
		<li><a href="manageusers.php">Users</a></li>
		<li><a href="managecomments.php">Comments</a></li>
	</ul>

<h2>Page Management</h2>

<p><a href="tasks/addpage.php">Create New Page</a></p>

<h3>List of Pages</h3>

<?php include '../objects/opendb.php'; ?>

<?php $result = mysql_query("SELECT * FROM $table_pages") or die('Error : ' . mysql_error()); ?>

<?php while($row = mysql_fetch_array($result, MYSQL_NUM)) { ?>
<?php list($ID, $title, $content) = $row; ?>
<?php $content = stripslashes($content); ?>

	<p><?php echo $title; ?> | <a href="tasks/editpage.php?id=<?php echo $ID; ?>">Edit</a> | 
	<a href="tasks/deletepage.php?id=<?php echo $ID; ?>">Delete</a>
	</p>

<?php } ?>

<?php include '../objects/closedb'; ?>

	</div>

</body>
</html>

<?php } // End content ?>