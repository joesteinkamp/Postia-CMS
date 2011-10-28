<?php include '../../objects/pullsettings.php'; ?>
<?php 
$user_role = getRole();
if(!$user_role == "3"){
	// Redirect to login (index)
	header( 'location:../index.php' );
}
else { // Display content ?>

<?php 
// If POST then update user profile, else if GET load for the first time
if($_SERVER['REQUEST_METHOD'] == "POST") {
	// Set updated variables
	$username = $_POST['username'];
	$fullname = $_POST['fullname'];
	$email = $_POST['email'];
	$website = $_POST['website'];
	$bio = $_POST['bio'];
	$user_role = $_POST['user_role'];
	
	if($_POST['newpassword1'] == $_POST['newpassword2'] && !empty($_POST['newpassword1'])) {
		// Update profile with password
		$newpassword = md5( $_POST['newpassword1'] );
		include '../../objects/opendb.php';
		mysql_query("UPDATE $table_users SET password='$newpassword', fullname='$fullname', email='$email', website='$website', bio='$bio', role='$user_role', verified='1' WHERE username='$username'");
		include '../../objects/closedb.php';
		echo "User Updated! Password changed.";
	}
	elseif($_POST['newpassword1'] == "") {
		// Update profile without password
		include '../../objects/opendb.php';
		mysql_query("UPDATE $table_users SET fullname='$fullname', email='$email', website='$website', bio='$bio', role='$user_role', verified='1' WHERE username='$username'");
		include '../../objects/closedb.php';
		echo "User Updated!";
	}
	else {	
		// Passwords don't match
		echo "Passwords don't match";
	}
}
elseif($_SERVER['REQUEST_METHOD'] == "GET") {
	$username = $_GET['user'];
	
	include '../../objects/opendb.php';

	$result = mysql_query("SELECT fullname, email, website, bio, role FROM $table_users WHERE username='$username' LIMIT 1") or die('Error : ' . mysql_error());	
	while($row = mysql_fetch_array($result, MYSQL_NUM)) { 
	list($fullname, $email, $website, $bio, $user_role) = $row;
	}
	
	include '../../objects/closedb.php';

}
else {
	// No page selected
}


?>


<html>
<head>
</head>

<body>
	
	<p><a href="../manageusers.php">Back to User Management</a></p>
	
	<form action="edituser.php" method="post">
		<table>
			<tr>
				<td>Username:</td>
				<td><input type="text" name="username" value="<?php echo $username; ?>" readonly="readonly" /> *Username cannot be changed.</td>
			</tr>
			<tr>
				<td>Full Name:</td>
				<td><input type="text" name="fullname" value="<?php echo $fullname; ?>" /></td>
			</tr>
			<tr>
				<td>New Password:</td>
				<td><input type="password" name="newpassword1" value="" /> Leave blank if you don't want to change the password</td>
			</tr>
			<tr>
				<td>Confirm Password:</td>
				<td><input type="password" name="newpassword2" value="" /></td>
			</tr>
			<tr>
				<td>Email:</td>
				<td><input type="text" name="email" value="<?php echo $email; ?>" /></td>
			</tr>
			<tr>
				<td>Website:</td>
				<td><input type="text" name="website" value="<?php echo $website; ?>" /></td>
			</tr>
			<tr>
				<td>Bio:</td>
				<td><textarea name="bio" rows="3"><?php echo $bio; ?></textarea></td>
			</tr>
			<tr>
				<td>User Role</td>
				<td>
					<select name="user_role">
						<option value="3" <?php if($user_role == "3") { echo 'selected="selected"'; } ?>>Administrator</option>
						<option value="2" <?php if($user_role == "2") { echo 'selected="selected"'; } ?>>Editor</option>
						<option value="1" <?php if($user_role == "1") { echo 'selected="selected"'; } ?>>Basic User</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="Update User" /> 
				</td>
			</tr>
		</table>
	</form>
	
	<p>Note: When an admin updates an account it automatically verifies the account.</p>
	
	<p><a href="deleteuser.php?user=<?php echo $username; ?>">Delete User</a></p>

    
</body>
</html>

<?php } // End content ?>