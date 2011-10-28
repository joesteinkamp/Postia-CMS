<?php include '../objects/pullsettings.php'; ?>
<?php 
$user_role = getRole(); // Get user role
if(!$user_role == "3"){
	// Redirect to login (index)
	header( 'location:index.php' );
}
else { // Display content ?>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST") {
	// Set variables of updated settings
	$site_url = $_POST['site_url']; $site_name = $_POST['site_name']; $site_slogan = $_POST['site_slogan'];
	$site_description = $_POST['site_description']; $admin_email = $_POST['admin_email'];
	$who_can_post = $_POST['who_can_post']; $site_membership = $_POST['site_membership'];
	$site_visibility = $_POST['site_visibility']; $onoff_comments = $_POST['onoff_comments'];
	$who_can_comment = $_POST['who_can_comment'];
	
	updateSetting("site_url", $site_url); // Update site url
	updateSetting("site_name", $site_name); // Update site name
	updateSetting("site_slogan", $site_slogan); // Update site slogan
	updateSetting("site_description", $site_description); // Update site description
	updateSetting("admin_email", $admin_email); // Update administrator's email address
	updateSetting("who_can_post", $who_can_post); // Update who can post
	updateSetting("site_membership", $site_membership); // Update site membership
	updateSetting("site_visibility", $site_visibility); // Update site visibility
	updateSetting("onoff_comments", $onoff_comments); // Update turn on or off comments
	updateSetting("who_can_comment", $who_can_comment); // Update who can comment
	
	echo "Settings Updated!";
}

?>


<html>

<head>
	<link rel="stylesheet" type="text/css" href="adminstyle.css" />
</head>

<body>

	<div id="topbar">
		<a id="site_url" href="<?php echo $site_url; ?>"><?php echo $site_name; ?> - Back to site</a>
		<?php if(isset($_SESSION['is_logged_in'])) { ?><a id="logout" href="../login.php?logout=yes&referer=<?php echo curPageURL(); ?>">Logout</a><?php } ?>
	</div>
	
	<div id="content">

	<ul id="adminnav">
		<li><a href="settings.php" class="active">Settings</a></li>
		<li><a href="manageposts.php">Posts</a></li>
		<li><a href="managepages.php">Pages</a></li>
		<li><a href="manageusers.php">Users</a></li>
		<li><a href="managecomments.php">Comments</a></li>
	</ul>

	<form method="post" action="settings.php">
		
		<!-- GENERAL -->
		<h2>General Settings</h2>
			<p>Site URL: <input type="text" name="site_url" size="45" value="<?php echo $site_url; ?>" /></p>
			<p>Site Name: <input type="text" name="site_name" size="45" value="<?php echo $site_name; ?>" /></p>
			<p>Site Slogan: <input type="text" name="site_slogan" size="45" value="<?php echo $site_slogan; ?>" /></p>
			<p>Site Description:<br />
			<textarea name="site_description" cols="70" rows="3"><?php echo $site_description; ?></textarea></p>
			<p>Site Administrator's Email: <input type="text" name="admin_email" size="45" value="<?php echo $admin_email; ?>" /></p>
		
		
		<!-- Permissions -->
		<h3>Permissions</h3>
			<p>Post Permissions (Who can post): 
				<input type="radio" name="who_can_post" value="3" <?php if($who_can_post == "3") { echo 'checked="checked"'; } ?> />Only Administrators
				<input type="radio" name="who_can_post" value="2" <?php if($who_can_post == "2") { echo 'checked="checked"'; } ?> />Editors & Admins
				<input type="radio" name="who_can_post" value="1" <?php if($who_can_post == "1") { echo 'checked="checked"'; } ?> />Registered Users
				<input type="radio" name="who_can_post" value="0" <?php if($who_can_post == "0") { echo 'checked="checked"'; } ?> />Everyone (Users & Public)
			</p>
				
				
			<p>Site Membership (Who can register):
				<input type="radio" name="site_membership" value="0" <?php if($site_membership == "0") { echo 'checked="checked"'; } ?> />Anyone can register
				<input type="radio" name="site_membership" value="1" <?php if($site_membership == "1") { echo 'checked="checked"'; } ?> />Only admins can create accounts
			</p>
			
			<p>Site Visibility (Who can see the site): 
				<input type="radio" name="site_visibility" value="0" <?php if($site_visibility == "0") { echo 'checked="checked"'; } ?> />Public: Everyone Can View
				<input type="radio" name="site_visibility" value="1" <?php if($site_visibility == "1") { echo 'checked="checked"'; } ?> />Private: Registered Users Only
			</p>
		
		
		<!-- Comment -->
		<h3>Comments</h3>
		<p>Comments On/Off: 
		<input type="radio" name="onoff_comments" value="0" <?php if($onoff_comments == "0") { echo 'checked="checked"'; } ?> />On: allow comments
		<input type="radio" name="onoff_comments" value="1" <?php if($onoff_comments == "1") { echo 'checked="checked"'; } ?> />Off: disallow comments
		</p>
		
		<p>Who can comment?
			<input type="radio" name="who_can_comment" value="3" <?php if($who_can_comment == "3") { echo 'checked="checked"'; } ?> />Only Administrators
			<input type="radio" name="who_can_comment" value="2" <?php if($who_can_comment == "2") { echo 'checked="checked"'; } ?> />Editors & Admins
			<input type="radio" name="who_can_comment" value="1" <?php if($who_can_comment == "1") { echo 'checked="checked"'; } ?> />Registered Users
			<input type="radio" name="who_can_comment" value="0" <?php if($who_can_comment == "0") { echo 'checked="checked"'; } ?> />Everyone (Users & Public)
		</p>
		
		<!-- APPEARANCE -->
		
		
	
		<input type="submit" value="Update Settings" />
	</form>
	
	</div>

</body>
</html>

<?php } // End content ?>