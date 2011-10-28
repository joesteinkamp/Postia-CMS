<?php include 'objects/pullsettings.php'; // Retrieve settings ?>

<?php
	$pageid = $_GET["id"];
?>

<?php include './objects/opendb.php'; ?>

			<?php $result = mysql_query("SELECT * FROM $table_pages WHERE ID = '$pageid' LIMIT 1") or die('Error : ' . mysql_error()); ?>
			
			<?php while($row = mysql_fetch_array($result, MYSQL_NUM)) { ?>
			<?php list($id, $title, $content) = $row; ?>
			<?php $content = stripslashes($content); ?>


<html>
<head>
	<link rel="stylesheet" type="text/css" href="theme/<?php echo $theme; ?>/style.css" />
	<title><?php echo $site_name; ?>: <?php echo $title; ?></title>
</head>
<body>
    
    <div id="container">
    
		<div id="logonav">
			<?php include 'theme/'.$theme.'/logonav.php'; ?>
		</div>
		
		<div id="content">
			
			
				<!-- If admin, display edit link -->
				<?php $user_role = getRole(); if($user_role  == "3") { ?> 
				<p><a href="editpage.php?id=<?php echo $id; ?>">Edit</a></p>
				<?php } ?>
				<!-- END edit link -->
			
				<h3 class="title"><?php echo $title; ?></h3>
			
				<?php echo $content; ?>
			
			<?php } ?>
			
			<?php include './objects/closedb'; ?>
		</div>
    
    </div>
    
</body>
</html>