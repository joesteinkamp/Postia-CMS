<?php include '../../objects/pullsettings.php'; ?>
<?php 
$user_role = getRole();
if(!$user_role == "3"){
	// Redirect to login (index)
	header( 'location:../index.php' );
}
else { // Display content ?>

<html>

<body>

	<p><a href="../manageusers.php">Back to User Management</a></p>

	<form name="adduser" method="post" action="adduser.php">
		<table>
			<tr>
				<td>Username:</td>
				<td><input type="text" name="username" value="" maxlength="20" tabindex="1" /></td>
			</tr>
			<tr>
				<td>Full Name:</td>
				<td><input type="text" name="fullname" value="" maxlength="20" tabindex="2" /></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="password" value="" tabindex="3" /></td>
			</tr>
			<tr>
				<td>Email:</td>
				<td><input type="text" name="email" value="" tabindex="4" /></td>
			</tr>
			<tr>
				<td>Website:</td>
				<td><input type="text" name="website" value="" tabindex="5" /></td>
			</tr>
			<tr>
				<td>Bio:</td>
				<td><textarea name="bio" rows="3" tabindex="6"></textarea></td>
			</tr>
			<tr>
				<td>User Role</td>
				<td>
					<select name="user_role" tabindex="7">
						<option value="3">Administrator</option>
						<option value="2">Editor</option>
						<option value="1" selected="selected">Basic User</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="Add User" tabindex="8" />
					<input type="reset" value="Reset" tabindex="9" />
				</td>
			</tr>
		</table>		
	</form>

	<p>Note: Accounts created with this admin form will automatically verify the account.</p>

</body>



</html>






<?php 
if($_SERVER['REQUEST_METHOD'] == "POST") {

	$username = $_POST["username"];
	$password = $_POST["password"];
	$password = md5($password);
	$email = $_POST["email"];
	$fullname = $_POST["fullname"];
	$website = $_POST['website'];
	$bio = $_POST['bio'];
	$user_role = $_POST['user_role'];
	
	if ($username != "" && $password != "" && $email != "" && $fullname != "") {
		addUser($username, $password, $email, $fullname, $website, $bio, $user_role);
		echo "User Account Added Successfully!";
	}

}



?>

<?php } // End content ?>