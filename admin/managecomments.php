<?php include '../objects/pullsettings.php'; ?>
<?php 
$user_role = getRole(); // Get user role
if(!$user_role == "3"){
	// Redirect to login (index)
	header( 'location:index.php' );
}
else { // Display content ?>


<?php 



include '../objects/opendb.php'; // required to get table name

// Default comment type to all comments
	$commentquery = "SELECT * FROM $table_comments ORDER BY timestamp DESC"; // All comments

if($_SERVER['REQUEST_METHOD'] == "GET") {
	
	// Determine comment type selection (All, Pending, Approved)
	// Alter SQL Query accordingly
	
	$commenttype = $_GET["type"];
	$commentid = $_GET["id"];
	$action = $_GET["action"];
	
	if(!$commentype == "") {
		if($commenttype == "all") {
			$commentquery = "SELECT * FROM $table_comments ORDER BY timestamp DESC"; // All comments
		}
		elseif($commenttype == "pending") {
			$commentquery = "SELECT * FROM $table_comments WHERE approved=0 ORDER BY timestamp DESC"; // Pending comments
		}
		elseif($commenttype == "approved") {
			$commentquery = "SELECT * FROM $table_comments WHERE approved=1 ORDER BY timestamp DESC"; // Approved comments
		}
		else {
			// Default to all comments
			$commentquery = "SELECT * FROM $table_comments ORDER BY timestamp DESC"; // All comments
		}
	} // END DETERMINE COMMENT TYPE
	if($action == "delete") {
		// DELETE COMMENT ACTION
	
		// Check to make sure the comment id is inputted
		if(!$commentid == "") {
		    mysql_query("DELETE FROM $table_comments WHERE id='$commentid'") or die('Error : ' . mysql_error());
		}
	
		// END DELETE ACTION
	}
	elseif($action == "approve") {
		// APPROVE COMMENT ACTION
		
		// Check to make sure the comment id is inputted
		if(!$commentid == "") {
		    mysql_query("UPDATE $table_comments SET approved=1 WHERE id='$commentid'") or die('Error : ' . mysql_error());
		}
		
		//END APPROVE ACTION
	}
	elseif($action == "unapprove") {
		// UNAPPROVE COMMENT ACTION
		
		// Check to make sure the comment id is inputted
		if(!$commentid == "") {
		    mysql_query("UPDATE $table_comments SET approved=0 WHERE id='$commentid'") or die('Error : ' . mysql_error());
		}
		
		// END UNAPPROVE ACTION
	}
}


include '../objects/closedb.php';



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

	<ul id="adminnav">
		<li><a href="settings.php">Settings</a></li>
		<li><a href="manageposts.php">Posts</a></li>
		<li><a href="managepages.php">Pages</a></li>
		<li><a href="manageusers.php">Users</a></li>
		<li><a href="managecomments.php" class="active">Comments</a></li>
	</ul>

<h2>Comment Management</h2>

<ul id="commenttypes">
	<li><a href="?type=all">All</a> | </li>
	<li><a href="?type=pending">Pending</a> | </li>
	<li><a href="?type=approved">Approved</a></li>
</ul>


		<table id="comments">
			<tr>
				<th>Author</th>
				<th>Comment</th>
				<th>Post</th>
			</tr>



<?php include '../objects/opendb.php'; ?>

<?php $result = mysql_query($commentquery) or die('Error : ' . mysql_error()); ?>
<?php while($row = mysql_fetch_array($result, MYSQL_NUM)) { ?>
<?php list($id, $post_id, $author, $content, $timestamp, $approved) = $row; ?>
<?php $content = stripslashes($content); ?>
	<tr class="<?php if($approved == "1") { echo "approved"; } else { echo "unapproved"; } ?>">
		<td><?php echo $author; ?></td>
		<td><?php echo $content; ?>
			<ul class="commentadminnav">
				<li><?php if($approved == "0") { ?><a href="?action=approve&id=<?php echo $id; ?>">Approve</a><?php } else { ?><a href="?action=unapprove&id=<?php echo $id; ?>">Unapprove</a><?php } ?></li>
				<li><a href="./tasks/editcomment.php?id=<?php echo $id; ?>">Edit</a></li>
				<li><a href="?action=delete&id=<?php echo $id; ?>">Delete</a></li>
			</ul>
		</td>
		<td><?php echo $post_id; ?></td>
	</tr>
	
<?php } ?>

<?php include '../objects/closedb'; ?>

		</table>

	</div>

</body>
</html>

<?php } // End content ?>