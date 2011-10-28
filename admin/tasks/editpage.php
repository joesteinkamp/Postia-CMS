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
	$pageid = $_POST['id'];
	$title = $_POST['title'];
	$content = $_POST['content']; $content = addslashes($content);
	$ordernum = $_POST['ordernum'];
	
	include '../../objects/opendb.php'; // Open database connection
    mysql_query("UPDATE $table_pages SET title='$title' WHERE id='$pageid'") or die('Error : ' . mysql_error());
    mysql_query("UPDATE $table_pages SET content='$content', ordernum='$ordernum' WHERE id='$pageid'") or die('Error : ' . mysql_error());
    include '../../objects/closedb.php'; // Close database connection
    
    $content = stripslashes($content); // To fix for more editting (Can't display slashes in textarea)
    
    echo "Page updated.";
}
elseif($_SERVER['REQUEST_METHOD'] == "GET") {
	$pageid = $_GET["id"];
	
	include '../../objects/opendb.php';

	$result = mysql_query("SELECT title, content, ordernum FROM $table_pages WHERE ID='$pageid' LIMIT 1") or die('Error : ' . mysql_error());	
	while($row = mysql_fetch_array($result, MYSQL_NUM)) { 
	list($title, $content, $ordernum) = $row;
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
	
	<p><a href="../managepages.php">Back to Page Management</a></p>
	
	<form action="editpage.php" method="post">
		<input type="hidden" name="id" value="<?php echo $pageid; ?>" />
		<input type="text" name="title" value="<?php echo $title; ?>" /><br />
		<textarea name="content" rows="20" cols="50"><?php echo $content; ?></textarea><br />
		Order Number: <input type="text" name="ordernum" value="<?php echo $ordernum; ?>" /><br />
		<input type="submit" name="Update" value="Update" />
	</form>
	
	<p><a href="deletepage.php?id=<?php echo $pageid; ?>">Delete Page</a></p>

    
</body>
</html>

<?php } // End content ?>