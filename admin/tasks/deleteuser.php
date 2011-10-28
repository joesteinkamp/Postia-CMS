<?php include '../../objects/pullsettings.php'; ?>
<?php 
$user_role = getRole();
if(!$user_role == "3"){
	// Redirect to login (index)
	header( 'location:../index.php' );
}
else { // Display content ?>

<?php 
	$user = $_GET['user'];
	
	// Run delete page function
	deleteUser($user);
	
	echo "Deleted User" . $user;	
	// Redirect back to Page Management
	header("Location: ../manageusers.php");
	

?>

<?php } // End content ?>