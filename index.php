<?php require 'objects/pullsettings.php'; // Retrieve settings ?>
<?php $page = $_GET['page']; if($page == "" || $page == 0){$page=1;};// GET page # ?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="theme/<?php echo $theme; ?>/style.css" />
	<title><?php echo $site_name; ?>: Home</title>
</head>

<body>
    
    <div id="container">
    
		<div id="logonav">
			<?php include 'theme/'.$theme.'/logonav.php'; ?>
		</div>
		
		<div id="form">
			<?php include 'theme/'.$theme.'/postform.php'; ?>
		</div>
		
		<div id="content">
			<?php include 'theme/'.$theme.'/posts.php'; ?>
		</div>
    
    </div>
    
</body>
</html>