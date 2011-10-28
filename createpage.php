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

$title = $_POST["title"];
$content = $_POST["content"];
$content = addslashes($content);
$ordernum = $_POST["ordernum"];

include './objects/opendb.php'; // Open database connection
mysql_query("INSERT INTO $table_pages (title, content, ordernum) VALUES ('$title', '$content', '$ordernum')") or die('Error : ' . mysql_error());
include './objects/closedb.php'; // Close database connection

$msg = '<p>New Page Added</p>';

}

?>


<html>
<head>
	<link rel="stylesheet" type="text/css" href="theme/<?php echo $theme; ?>/style.css" />
	<title><?php echo $site_name; ?>: Create Page</title>
</head>
<body>
    
    <div id="container">
    
		<div id="logonav">
			<?php include 'theme/'.$theme.'/logonav.php'; ?>
		</div>
		
		<div id="content">
			
				<form name="createpage" method="post" action="createpage.php">
					Title<br />
					<input type="text" name="title" value="" /><br />
					Content:<br />
					<textarea name="content" rows="20" cols="50"></textarea><br />
					Order Number: <input type="text" name="ordernum" value="0" /><br />
					<input type="submit" value="Submit" />
				</form>
				
				<?php echo $msg; ?>
			
		</div>
    
    </div>
    
</body>
</html>

<?php } // End Admin Content ?>