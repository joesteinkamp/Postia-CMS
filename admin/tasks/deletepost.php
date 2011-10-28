<?php include '../../objects/pullsettings.php'; ?>
<?php 
$user_role = getRole();
if(!$user_role == "3"){
	// Redirect to login (index)
	header( 'location:../index.php' );
}
else { // Display content ?>

<?php 
	$id = $_GET['id'];

	// Run delete page function
	deletePost($id);
	
	echo "Deleted Post #" . $id;	
	// Redirect back to Post Management
	header("Location: ../manageposts.php");

?>

<?php } // End content ?>