<?php include 'objects/pullsettings.php'; // Retrieve settings ?>

<?php
	
	// If form has been posted, try to update account information
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$fullname = $_POST["fullname"];
		$username = $_POST["username"];
		$website = $_POST["website"];
		$bio = $_POST["bio"];
		
		include './objects/opendb.php';
		mysql_query("UPDATE $table_users SET fullname='$fullname', website='$website', bio='$bio' WHERE username='$username'") or die('Error : ' . mysql_error());
		include './objects/closedb.php';
	}
	elseif($_SERVER['REQUEST_METHOD'] == "GET") {
		$username = $_GET["user"];
		$action = $_GET["action"];
		include './objects/opendb.php';
		$result = mysql_query("SELECT fullname, website, bio FROM $table_users WHERE username = '$username' LIMIT 1") or die('Error : ' . mysql_error());
		while($row = mysql_fetch_array($result, MYSQL_NUM)) {
			list($fullname, $website, $bio) = $row;
			$content = stripslashes($content);
		}
		include './objects/closedb.php';	
	}
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="theme/<?php echo $theme; ?>/style.css" />
	<title><?php echo $site_name; ?>: User Profile - <?php echo $username; ?></title>
</head>

<body>
    
    <div id="container">
    
		<div id="logonav">
			<?php include 'theme/'.$theme.'/logonav.php'; ?>
		</div>
		
		<div id="content">
			<?php if($username == $_SESSION['username'] && !$action == "edit") { ?> 
				<p><a href="?user=<?php echo $username; ?>&action=edit">Edit</a></p>
			<?php } elseif($username == $_SESSION['username'] && $action == "edit") { ?><p><a href="?user=<?php echo $username; ?>">Stop Editing</a></p><?php } ?>
			
					<?php if($action == "edit") { ?>
						<form action="" method="post">
							Full Name: <input type="text" name="fullname" value="<?php echo $fullname; ?>" /><br />
							Username: <input type="text" name="username" value="<?php echo $username; ?>" readonly="readonly" /> *Can't change<br />
							Website: <input type="text" name="website" value="<?php echo $website; ?>" /><br />
							Bio:<br /><textarea name="bio" rows="8" cols="50"><?php echo $bio; ?></textarea><br />
							<input type="submit" value="Update" />
						</form>
						
					<?php } else { // Display public view ?>
						<h3 class="title"><?php echo $fullname; ?></h3>
						<h6 class="secondtitle"><?php echo $username; ?></h6>
						
						<p><a href="<?php echo $website; ?>" target="_blank"><?php echo $website; ?></a></p>
						
						<!-- BIO -->
						<p>
							<?php echo $bio; ?>
						</p>
					<?php } ?>
				
				
				
				
			
			
		</div>
    
    </div>
    
</body>
</html>