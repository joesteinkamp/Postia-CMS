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
	deletePage($id);
	
	echo "Deleted Page #" . $id;	
	// Redirect back to Page Management
	header("Location: ../managepages.php");

?>

<?php } // End content ?>