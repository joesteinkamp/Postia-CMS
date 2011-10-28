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
	$commentid = $_POST['id'];
	$author = $_POST['author'];
	$content = $_POST['content']; $content = addslashes($content);
	
	include '../../objects/opendb.php'; // Open database connection
    mysql_query("UPDATE $table_comments SET username='$author', content='$content' WHERE id='$postid'") or die('Error : ' . mysql_error());
    include '../../objects/closedb.php'; // Close database connection
    
    $content = stripslashes($content); // To fix for more editting (Can't display slashes in textarea)
    
    echo "Post updated.";
}
elseif($_SERVER['REQUEST_METHOD'] == "GET") {
	$commentid = $_GET["id"];
	
	include '../../objects/opendb.php';

	$result = mysql_query("SELECT username, content FROM $table_comments WHERE ID='$commentid' LIMIT 1") or die('Error : ' . mysql_error());	
	while($row = mysql_fetch_array($result, MYSQL_NUM)) { 
	list($author, $content) = $row;
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
	
	<p><a href="../managecomments.php">Back to Comment Management</a></p>
	
	<form action="editcomment.php" method="post">
		<input type="hidden" name="id" value="<?php echo $commentid; ?>" />
		<input type="text" name="author" value="<?php echo $author; ?>" disabled="disabled" /><br />
		<textarea name="content" rows="20" cols="50"><?php echo $content; ?></textarea><br />
		Approve: <input type="radio" name="approve" value="1" /> Yes &nbsp;
		<input type="radio" name="approve" value="0" /> No<br />
		<input type="submit" name="Update" value="Update" />
	</form>
	
	<p><a href="">Delete Comment</a></p>

    
</body>
</html>

<?php } // End content ?>