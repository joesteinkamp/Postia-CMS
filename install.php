<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<style type="text/css">

body {
	background-color: #ebebeb;
	line-height: 18px;
	font-size: 13.5px;
	font-family: "Helvetica Neue", Georgia, sans-serif;
}

form {
	padding: 10px;
	background-color: white;
	margin-right: auto;
	margin-left: auto;
	width: 650px;
}

table {
	border-width: 0px;
}

td {
	padding-bottom: 3px;
	padding-top: 3px;
	padding-right: 10px;
	padding-left: 10px;
}

h4 {
	font-size: 16px;
	margin-bottom: 5px;
	margin-top: 8px;
}

input.textbox {
	font-family: Georgia, Arial, sans-serif;
	font-size: 13px;
	height: 16px;
	width: 300px;
}

input.submit {
	top: 10px;
	position: relative;
	left: 250px;
}

</style>
	<title>Install Postia CMS</title>
</head>

<body>
	<form method="post" action="install.php">
	<h2>Install Postia CMS</h2>
	<table border="0">
		<tr>
			<td colspan="2"><h4>Database Information</h4></td>
		</tr>
		<tr>
			<td>Database Hostname:</td>
			<td><input type="text" class="textbox" name="database_host" value="" /></td>
		</tr>
		<tr>
			<td>Database Name:</td>
			<td><input type="text" class="textbox" name="database_name" value="" /></td>
		</tr>
		<tr>
			<td>Database Username:</td>
			<td><input type="text" class="textbox" name="database_username" value="" /></td>
		</tr>
		<tr>
			<td>Database Password:</td>
			<td><input type="password" class="textbox" name="database_password" value="" /></td>
		</tr>
		<tr>
			<td>Database Prefix:</td>
			<td><input type="text" class="textbox" name="table_prefix" value="pc_" /></td>
		</tr>
		<tr>
			<td colspan="2"><h4>Site Information</h4></td>
		</tr>
		<tr>
			<td>Site URL:</td>
			<td><input type="text" class="textbox" name="site_url" value="http://" /></td>
		</tr>
		<tr>
			<td>Site Name:</td>
			<td><input type="text" class="textbox" name="site_name" value="" /></td>
		</tr>
		<tr>
			<td>Administrator Email</td>
			<td><input type="text" class="textbox" name="admin_email" value="" /></td>
		</tr>
		<tr>
			<td>Site Visibility:</td>
			<td><input type="radio" name="site_visibility" value="0" checked="checked" />Public: Everyone Can View
				<input type="radio" name="site_visibility" value="1" />Private: Registered Users Only
</td>
		</tr>
		<tr>
			<td colspan="2"><h4>Administrator User Account</h4></td>
		</tr>
		<tr>
			<td>Administrator Username:</td>
			<td><input type="text" class="textbox" name="admin_username" value="" /></td>
		</tr>
		<tr>
			<td>Administrator Password:</td>
			<td><input type="password" class="textbox" name="admin_password" value="" /></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" class="submit" value="Setup Postia Site" /></td>
		</tr>
	</table>
	</form>


</body>
</html>


<?php 

// *** INSTALLATION FILE

// RUN ONLY WHEN POSTED
if($_SERVER['REQUEST_METHOD'] == "POST") {

// ***** Data validation
if( $_POST['database_host'] == "" || $_POST['database_name'] == "" || $_POST['database_username'] == "" || $_POST['database_password'] == "" || $_POST['site_url'] == "" || $_POST['site_name'] == "" || $_POST['admin_email'] == "" ) {
	echo "<p>* Please fill in all the fields above. Each is required.</p>";
	exit();
}

// ***** END Data validation

// VARIABLES
	// Database variables
	$database_name = $_POST['database_name'];
	$database_host = $_POST['database_host'];
	$database_username = $_POST['database_username'];
	$database_password = $_POST['database_password'];
	$table_prefix = $_POST['table_prefix'];
	
	// General Settings variables
	$site_url = $_POST['site_url'];
	$site_name = $_POST['site_name'];
	$admin_email = $_POST['admin_email'];
	$site_visibility = $_POST['site_visibility'];
	
	// Admin username
	$admin_username = $_POST['admin_username'];
	$admin_password = $_POST['admin_password'];
		// If not filled in
		if($admin_username == "") { $admin_username = "admin"; }
		if($admin_password == "") { $admin_password = md5( rand(1,9999999) ); }
	$admin_password_md5 = md5($admin_password); // MD5 password for database encyption

// *** Create opendb.php w/ database information ***
$string = '<?php 

// * Open Database *
	    
	$dbusername = "'.$database_username.'";
	$dbpassword = "'.$database_password.'";
	$hostname = "'.$database_host.'";
	$dbh = mysql_connect($hostname, $dbusername, $dbpassword) or die("Unable to connect to MySQL");
	
	$dbname = "'.$database_name.'";
	mysql_select_db($dbname);
	
	$table_settings = "'.$table_prefix.'settings";
	$table_pages = "'.$table_prefix.'pages";
	$table_posts = "'.$table_prefix.'posts";
	$table_users = "'.$table_prefix.'users";
	$table_comments = "'.$table_prefix.'comments";
	
	
?>';

$file = "objects/opendb.php";
$fh = fopen($file, 'w') or die($file." isn't writeable.");
fwrite($fh, $string);
fclose($fh);
// *** END Create opendb.php ***


// ****** Create database structure ******
	$con = mysql_connect($database_host, $database_username, $database_password);
	mysql_select_db($database_name, $con);
	
	// Create Comments table
	$sql_comments = "CREATE TABLE ".$table_prefix."comments
(
id bigint(20) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (id),
post_id bigint(20),
username varchar(15),
content text,
timestamp datetime,
approved tinyint(2)
)";
	
	// Create Pages table
	$sql_pages = "CREATE TABLE ".$table_prefix."pages
(
id bigint(20) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (id),
title varchar(255),
content longtext,
ordernum int(11)
)";
	
	// Create Posts table
	$sql_posts = "CREATE TABLE ".$table_prefix."posts
(
id bigint(20) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (id),
content text,
timestamp datetime,
author varchar(20),
title varchar(255)
)";
	
	// Create Users table
	$table_users = $table_prefix . "users";
	$sql_users = "CREATE TABLE ".$table_users."
(
id bigint(20) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (id),
username varchar(15),
password varchar(96),
email varchar(60),
fullname varchar(20),
website varchar(160),
bio varchar(160),
role tinyint(2),
verified tinyint(2),
hash varchar(32)
)";
	
	
	// Create Settings table & insert default values
	$table_settings = $table_prefix . "settings";
	$sql_settings = "CREATE TABLE ".$table_settings."
(
id bigint(20) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (id),
name varchar(255),
value varchar(400)
)";

	// Run Queries
	mysql_query($sql_comments);
	mysql_query($sql_pages);
	mysql_query($sql_posts);
	mysql_query($sql_users);
	mysql_query($sql_settings);
// ****** END Create DB structure *******



// *** Add General Settings information to DB ***
	mysql_query("INSERT INTO $table_settings (name, value) VALUES ('site_url', '$site_url')");
	mysql_query("INSERT INTO $table_settings (name, value) VALUES ('site_name', '$site_name')");
	mysql_query("INSERT INTO $table_settings (name, value) VALUES ('site_slogan', 'This is a new Postia site.')");
	mysql_query("INSERT INTO $table_settings (name, value) VALUES ('site_description', 'This is a new Postia site\'s description.')");
	mysql_query("INSERT INTO $table_settings (name, value) VALUES ('admin_email', '$admin_email')");
	mysql_query("INSERT INTO $table_settings (name, value) VALUES ('who_can_post', '2')");
	mysql_query("INSERT INTO $table_settings (name, value) VALUES ('site_membership', '0')");
	mysql_query("INSERT INTO $table_settings (name, value) VALUES ('site_visibility', '$site_visibility')");
	mysql_query("INSERT INTO $table_settings (name, value) VALUES ('onoff_comments', '0')");
	mysql_query("INSERT INTO $table_settings (name, value) VALUES ('who_can_comment', '1')");
	mysql_query("INSERT INTO $table_settings (name, value) VALUES ('theme', 'default')");
	
	// Create Admin Account
	mysql_query("INSERT INTO $table_users (username, password, email, fullname, website, role, verified) VALUES ('$admin_username', '$admin_password_md5', '$admin_email', 'Site Administrator', '$site_url', '3', '1')");
// *** END Add General Setting info to DB ***


// ****** Change permissions of install file & opendb file ******
echo "<p>For your safety, please delete install.php in the root folder.</p>";
chmod("install.php", 0600);
chmod($file, 0600);


// ****** END change permissions of install file ******

// *** Completion Tasks ***
	echo "<p>Your Postia site has been successfully installed.</p>";
	echo "<p>Your admin username is: " . $admin_username . "<br />";
	echo "Your admin password is: " . $admin_password . "</p>";
	



} // END ONLY WHEN POSTED
?>
