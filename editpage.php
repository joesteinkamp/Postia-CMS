<?php include 'objects/pullsettings.php'; // Retrieve settings ?>
<?php 
$user_role = getRole();
if(!$user_role == "3"){
	// Redirect to login (index)
	header( 'location:index.php' );
}
else { // Display admin content ?>

<?php 
if($_SERVER['REQUEST_METHOD'] == "POST") {

	$pageid = $_POST['id'];
	$title = $_POST['title'];
	$content = $_POST['content']; $content = addslashes($content);
	$ordernum = $_POST['ordernum'];
	
	include './objects/opendb.php'; // Open database connection
    mysql_query("UPDATE $table_pages SET title='$title' WHERE id='$pageid'") or die('Error : ' . mysql_error());
    mysql_query("UPDATE $table_pages SET content='$content', ordernum='$ordernum' WHERE id='$pageid'") or die('Error : ' . mysql_error());
    include './objects/closedb.php'; // Close database connection
    
    $content = stripslashes($content); // To fix for more editting (Can't display slashes in textarea)
    
    $msg = '<p>Page updated.</p>';
}
elseif($_SERVER['REQUEST_METHOD'] == "GET") {
	$pageid = $_GET["id"];
	$action = $_GET["action"];
	
	include './objects/opendb.php';

	if(!$action == "delete") {
		$result = mysql_query("SELECT title, content, ordernum FROM $table_pages WHERE ID='$pageid' LIMIT 1") or die('Error : ' . mysql_error());	
		while($row = mysql_fetch_array($result, MYSQL_NUM)) { 
			list($title, $content, $ordernum) = $row;
			$content = stripslashes($content);
		}
		$redirectmsg = ''; // redirect is blank
	}
	else {
		// Run delete page function
		deletePage($pageid);
		// Set redirect back to home
		$redirect = '<meta http-equiv="refresh" content="2;url=index.php">';
		$redirectmsg = '<h2>Redirecting you home because page no longer exists.</h2>';
	}

	include './objects/closedb.php';

}
else {
	$msg = '<p>ERROR: This page is not meant to be gone to directly</p>';
}

?>


<html>
<head>
	<link rel="stylesheet" type="text/css" href="theme/<?php echo $theme; ?>/style.css" />
	<title>Edit Page: <?php echo $title; ?></title>
	<?php echo $redirect; ?>
</head>
<body>
    
    <div id="container">
    
		<div id="logonav">
			<?php include 'theme/'.$theme.'/logonav.php'; ?>
		</div>
		
		<div id="content">
		
			<?php echo $redirectmsg; ?>
			
			<p><a href="page.php?id=<?php echo $pageid; ?>">Stop Editing</a></p>
			
			<form action="editpage.php" method="post">
				<input type="hidden" name="id" value="<?php echo $pageid; ?>" />
				<input type="text" name="title" value="<?php echo $title; ?>" /><br />
				<textarea name="content" rows="20" cols="50"><?php echo $content; ?></textarea><br />
				Order Number: <input type="text" name="ordernum" value="<?php echo $ordernum; ?>" /><br />
				<input type="submit" name="Update" value="Update" />
			</form>
			
			<p><a href="editpage.php?id=<?php echo $pageid; ?>&action=delete">Delete Page</a></p>
			
			<?php echo $msg; ?>
			
		</div>
    
    </div>
    
</body>
</html>

<?php } // End Admin Content ?>