<?php include 'objects/pullsettings.php'; // Retrieve settings 
if($site_membership == "1" ) {
	echo "Sorry but you cannot register for this site. Only the site administrator can create you an account.";
}
else { // Users can register
  
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		
		// Check if username/email/password aren't empty
		if(isset($_POST['username']) && !empty($_POST['username']) AND isset($_POST['email']) && !empty($_POST['email']) AND isset($_POST['password']) && !empty($_POST['password'])) {  
			
			//Set variables
			$fullname = $_POST['fullname'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$password = md5($password);
			$email = $_POST['email'];
			$hash = md5( rand(0,1000) ); // Create unique hash for verification

			// Check if the email is valid
			if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){  
				// Return Error - Invalid Email 
				 $msg = 'The email you have entered is invalid, please try again.';
			}
			else {  
				// Return Success - Valid Email  
				$msg = 'Your account has been made, <br /> please verify it by clicking the activation link that has been sent to your email.';
				// Add account to DB
				joinUser($username, $password, $email, $fullname, $hash);
				sendVerifyEmail($site_url, $site_name, $admin_email, $username, $email, $hash);
			}  
			
			
		}  
		

	}

	// Notify user they're already logged in
	if(isset($_SESSION['is_logged_in'])) {
		$msg = "You already are logged in!";
	}
	
	function joinUser($username, $password, $email, $fullname, $hash) {
		include 'objects/opendb.php'; // Open database connection
	    mysql_query("INSERT INTO $table_users (username, password, email, fullname, hash, role) VALUES ('$username', '$password', '$email', '$fullname', '$hash', '3')") or die('Error : ' . mysql_error());
	    include 'objects/closedb.php'; // Close database connection
	}
	
	function sendVerifyEmail($site_url, $site_name, $admin_email, $username, $email, $hash) {
		$to      = $email; // Send email to our user  
		$subject = $site_name.' Signup | Verification'; // Give the email a subject  
		$message = ' 
		 
		Thanks for signing up! 
		Your account has been created, you can login with the following username after you have activated your account by pressing the url below. 
		 
		------------------------ 
		Username: '.$username.' 
		------------------------ 
		 
		Please click this link to activate your account: 
		 
		'.$site_url.'/objects/verifyaccount.php?email='.$email.'&hash='.$hash.' 
		 
		'; // Our message above including the link  
		  
		$headers = 'From: '.$admin_email.'' . "\r\n"; // Set from headers  
		mail($to, $subject, $message, $headers); // Send our email  
	}
  
?>


<html>
<head>
	<head>
		<link rel="stylesheet" type="text/css" href="theme/<?php echo $theme; ?>/style.css" />
		<title><?php echo $site_name; ?>: Join</title>
	</head>
</head>

<body>
    
    <div id="container">
    
		<div id="logonav">
			<?php include 'theme/'.$theme.'/logonav.php'; ?>
		</div>
		
		<h3>Sign Up</h3>
		
		<p><?php echo $msg; ?></p>
		
		<div id="content">
			<form method="POST" action="join.php">
				<table>
					<tr>
						<th>Full Name:</th>
						<td><input type="text" name="fullname" maxlength="20" tabindex="1" size="25" /></td>
					</tr>
					<tr>
						<th>Username:</th>
						<td><input type="text" name="username" maxlength="20" tabindex="2" size="25" /></td>
					</tr>
					<tr>
						<th>Password:</th>
						<td><input type="password" name="password" tabindex="3" size="25" /></td>
					</tr>
					<tr>
						<th>Email:</th>
						<td><input type="text" name="email" tabindex="4" size="25" /></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" id="submit" value="Create my account" tabindex="5" /></td>
					</tr>
				</table>
			</form>
			
		</div>
    
    </div>
    
</body>
</html>

<?php } // End of if statement checking if users can join ?>
