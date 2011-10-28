<?php 
	
	// Grab values from posted form
	$postid = $_POST["postid"];
	$author = $_POST["author"];
	$content = addslashes($_POST["content"]);
	$approved = "1"; // By default comment is approved
	
	// Check for public author
	if($author == "") {
		$author = "Anonymous";
		$approved = "0";
	}
	
	// Get date & time
	$timestamp = date('Y-m-d H:i:s');

	// Insert values as new comment in database
	addComment($postid, $author, $content, $timestamp, $approved);
	
	
	// FUNCTION: Opens DB, insert into comments table, Closes DB
	function addComment($postid, $author, $content, $timestamp, $approved) {
		include 'opendb.php'; // Open database connection
	    mysql_query("INSERT INTO $table_comments (post_id, username, content, timestamp, approved) VALUES ('$postid', '$author', '$content', '$timestamp', '$approved')") or die('Error : ' . mysql_error());
	    include 'closedb.php'; // Close database connection
	}
	
	// Redirects back to previous page
	header("Location: " . $_SERVER['HTTP_REFERER']);
?>