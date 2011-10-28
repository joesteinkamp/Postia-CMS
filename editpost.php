<?php include 'objects/pullsettings.php'; // Retrieve settings ?>
<?php 
$user_role = getRole();
if(!$user_role == "3"){
	// Redirect to login (index)
	header( 'location:../index.php' );
}
else { // Display content ?>

<?php 
if($_SERVER['REQUEST_METHOD'] == "POST") {
	$postid = $_POST['id'];
	$title = $_POST['title'];
	$content = $_POST['content']; $content = addslashes($content);
	
	include './objects/opendb.php'; // Open database connection
    mysql_query("UPDATE $table_posts SET title='$title', content='$content' WHERE id='$postid'") or die('Error : ' . mysql_error());
    include './objects/closedb.php'; // Close database connection
    
    $content = stripslashes($content); // To fix for more editing (Can't display slashes in textarea)
    
    $msg = '<p>Post updated.</p>';
}
elseif($_SERVER['REQUEST_METHOD'] == "GET") {
	$postid = $_GET["id"];
	$action = $_GET["action"];
	
	include './objects/opendb.php';
	
	if(!$action == "delete") {
		$result = mysql_query("SELECT title, content FROM $table_posts WHERE ID='$postid' LIMIT 1") or die('Error : ' . mysql_error());	
		while($row = mysql_fetch_array($result, MYSQL_NUM)) { 
			list($title, $content) = $row;
			$content = stripslashes($content);
		}
		$redirect = ""; // redirect set to nothing
	}
	else {
		// Run delete post function
		deletePost($postid);
		// Set redirect back to home
		$redirect = '<meta http-equiv="refresh" content="2;url=index.php">';
		$redirectmsg = '<h2>Redirecting you home because post no longer exists.</h2>';
	}

	include './objects/closedb.php';
}
else {
	// No post selected
}
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="theme/<?php echo $theme; ?>/style.css" />
	<title>Edit: <?php if(!$title == "") { echo $title; } else { echo $site_name.": "."Post #".$id; } ?></title>
	<?php echo $redirect; ?>
</head>

<body>
    
    <div id="container">
    
		<div id="logonav">
			<?php include 'theme/'.$theme.'/logonav.php'; ?>
		</div>
		
		<div id="content">
			
			<?php echo $redirectmsg; ?>
			
			<p><a href="post.php?id=<?php echo $postid; ?>">Stop Editing</a></p>
	
			<form action="editpost.php" method="post">
				<input type="hidden" name="id" value="<?php echo $postid; ?>" />
				<input type="text" name="title" value="<?php echo $title; ?>" /><br />
				<textarea name="content" rows="20" cols="50"><?php echo $content; ?></textarea><br />
				<input type="submit" name="Update" value="Update" />
			</form>
			
			<p><a href="editpost.php?id=<?php echo $postid; ?>&action=delete">Delete Post</a></p>
			
			<?php echo $msg; ?>

		</div>
    
    </div>
    
</body>
</html>

<?php } // End content ?>