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

$title = $_POST["title"];
$content = $_POST["content"];
$content = addslashes($content);
$ordernum = $_POST["ordernum"];

include '../../objects/opendb.php'; // Open database connection
mysql_query("INSERT INTO $table_pages (title, content, ordernum) VALUES ('$title', '$content', '$ordernum')") or die('Error : ' . mysql_error());
include '../../objects/closedb.php'; // Close database connection

echo "New Page Added";

}
?>

<html>

<body>

	<p><a href="../managepages.php">Back to Page Management</a></p>

	<form name="adduser" method="post" action="addpage.php">
		Title<br />
		<input type="text" name="title" value="" /><br />
		Content:<br />
		<textarea name="content" rows="20" cols="50"></textarea><br />
		Order Number: <input type="text" name="ordernum" value="1" /><br />
		<input type="submit" value="Submit" />
	</form>


</body>



</html>

<?php } // End Content ?>




