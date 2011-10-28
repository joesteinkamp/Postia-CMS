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

include '../../objects/opendb.php'; // Open database connection
mysql_query("INSERT INTO $table_posts (title, content) VALUES ('$title', '$content')") or die('Error : ' . mysql_error());
include '../../objects/closedb.php'; // Close database connection

echo "New Post Added";

}
?>

<html>

<body>

	<p><a href="../managepages.php">Back to Post Management</a></p>

	<form name="addpost" method="post" action="addpost.php">
		Title<br />
		<input type="text" name="title" value="" /><br />
		Content:<br />
		<textarea name="content" rows="20" cols="50"></textarea><br />
		<input type="submit" value="Submit" />
	</form>


</body>



</html>

<?php } // End Content ?>




