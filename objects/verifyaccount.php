<?php

if($_SERVER['REQUEST_METHOD'] == "GET") {
	
	// Check if email & hash aren't empty
	if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {  
		// Verify account
		$email = mysql_escape_string($_GET['email']); // Set email variable  
		$hash = mysql_escape_string($_GET['hash']); // Set hash variable  
		
		include 'opendb.php'; // Open DB connection
		$search = mysql_query("SELECT email, hash, verified FROM $table_users WHERE email='".$email."' AND hash='".$hash."' AND verified='0'") or die(mysql_error());  
		$match  = mysql_num_rows($search);
		
		if($match > 0) {  
			// We have a match, activate the account
			mysql_query("UPDATE $table_users SET verified='1' WHERE email='".$email."' AND hash='".$hash."' AND verified='0'") or die(mysql_error());
			echo "Account Activated!";
		}
		else {  
			// No match -> invalid url or account has already been activated.
			echo "There was a problem! :(<br>The email and verification key were invalid or the account is already verified.";
		}  
		
		include 'closedb.php'; // Close DB connection
    }
	else {  
        // GET values are wrong
		echo "Values have been entered incorrectly. Sorry :(";
    }  


}
else {
	// Page opened without GET values
	echo "This page has a specific purpose. I regret to tell you that the way you reached this page is incorrect. :(";
}

?>