<?php include 'objects/pullsettings.php'; // Retrieve settings ?>

<?php

if($_SERVER['REQUEST_METHOD'] == "POST") {
    include './objects/opendb.php';
    $username = mysql_real_escape_string($_POST['username']);
    $password = mysql_real_escape_string($_POST['password']);
    $result = mysql_query("SELECT role FROM $table_users WHERE username='$username' AND password=md5('$password') AND verified='1'");

	while($row = mysql_fetch_array($result, MYSQL_NUM)) { 
		list($user_role) = $row;
	}

	
    if(mysql_num_rows($result) > 0) {
      $_SESSION['is_logged_in'] = 1;
      $_SESSION['username'] = $username;
      $_SESSION['user_role'] = $user_role;
    }
    
    include './objects/closedb.php';
}
elseif($_SERVER['REQUEST_METHOD'] == "GET") {
  	if($_GET['logout'] == "yes") {
	  	$referer = $_GET['referer'];
	  	session_destroy();
	  	$msg = "<p>You've been logged out.</p>";
	}
}
else {
	// No action being performed
}
  	

	if(isset($_SESSION['is_logged_in'])) {
		$msg = "<p>You're logged in as ".$_SESSION['username']."!</p>";
	}
  
?>


<html>
<head>
	<head>
		<link rel="stylesheet" type="text/css" href="theme/<?php echo $theme; ?>/style.css" />
		<title><?php echo $site_name; ?>: Login</title>
	</head>
</head>

<body>
    
    <div id="container">
    
		<div id="logonav">
			<?php include 'theme/'.$theme.'/logonav.php'; ?>
		</div>
		
		<h3>Login</h3>
		
		<div id="content">
			<form method="POST" action="login.php">
				<p>Username:<br />
				<input type="text" name="username" tabindex="1" size="25" /></p>
				
				<p>Password:<br />
				<input type="password" name="password" tabindex="2" size="25" /></p>
				<p><input type="submit" id="submit" value="Submit" tabindex="3" /></p>
			</form>
			
			<?php echo $msg; ?>
		</div>
    
    </div>
    
</body>
</html>
