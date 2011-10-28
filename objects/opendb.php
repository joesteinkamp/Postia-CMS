<?php 

// * Open Database *
	    
	$dbusername = "root";
	$dbpassword = "root";
	$hostname = "localhost";
	$dbh = mysql_connect($hostname, $dbusername, $dbpassword) or die("Unable to connect to MySQL");
	
	$dbname = "postia";
	mysql_select_db($dbname);
	
	$table_settings = "pc_settings";
	$table_pages = "pc_pages";
	$table_posts = "pc_posts";
	$table_users = "pc_users";
	$table_comments = "pc_comments";
	
	
?>