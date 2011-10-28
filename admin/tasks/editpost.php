<?php include '../../objects/pullsettings.php'; ?>
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
	
	include '../../objects/opendb.php'; // Open database connection
    mysql_query("UPDATE $table_posts SET title='$title', content='$content' WHERE id='$postid'") or die('Error : ' . mysql_error());
    include '../../objects/closedb.php'; // Close database connection
    
    $content = stripslashes($content); // To fix for more editting (Can't display slashes in textarea)
    
    echo "Post updated.";
}
elseif($_SERVER['REQUEST_METHOD'] == "GET") {
	$postid = $_GET["id"];
	
	include '../../objects/opendb.php';

	$result = mysql_query("SELECT title, content FROM $table_posts WHERE ID='$postid' LIMIT 1") or die('Error : ' . mysql_error());	
	while($row = mysql_fetch_array($result, MYSQL_NUM)) { 
	list($title, $content) = $row;
	$content = stripslashes($content);
	}

	include '../../objects/closedb.php';
}
else {
	// No page selected
}

?>

<html>
<head>
</head>

<body>
	
	<p><a href="../manageposts.php">Back to Post Management</a></p>
	
	<form action="editpost.php" method="post">
		<input type="hidden" name="id" value="<?php echo $postid; ?>" />
		<input type="text" name="title" value="<?php echo $title; ?>" /><br />
		<textarea name="content" rows="20" cols="50"><?php echo $content; ?></textarea><br />
		<input type="submit" name="Update" value="Update" />
	</form>
	
	<p><a href="deletepost.php?id=<?php echo $postid; ?>">Delete Post</a></p>

    
</body>
</html>

<?php } // End content ?>