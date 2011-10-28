<?php include 'objects/pullsettings.php'; // Retrieve settings ?>

<?php
	$postid = $_GET["id"];
?>
<?php include './objects/opendb.php'; ?>

			<?php $result = mysql_query("SELECT * FROM $table_posts WHERE ID = '$postid' LIMIT 1") or die('Error : ' . mysql_error()); ?>
			
			<?php while($row = mysql_fetch_array($result, MYSQL_NUM)) { ?>
			<?php list($id, $content, $timestamp, $author, $title) = $row; ?>
			<?php $content = stripslashes($content); ?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="theme/<?php echo $theme; ?>/style.css" />
	<title><?php if(!$title == "") { echo $title; } else { echo $site_name.": "."Post #".$id; } ?></title>
</head>

<body>
    
    <div id="container">
    
		<div id="logonav">
			<?php include 'theme/'.$theme.'/logonav.php'; ?>
		</div>
		
		<div id="content">
			<!-- BEGIN OF LOOP -->
			
				<!-- If admin, display edit link -->
				<?php $user_role = getRole(); if($user_role  == "3") { ?> 
				<p><a href="editpost.php?id=<?php echo $id; ?>">Edit</a></p>
				<?php } ?>
				<!-- END edit link -->
			
				<?php if(!$title == "") { ?><h3 class="title"><?php echo $title; ?></h3><?php } ?>
				
				<div class="postcontent">
					<?php echo $content; ?>
				</div>
				<div class="postmeta">
					<?php echo $timestamp; ?> by <?php echo $author; ?>
				</div>
				
				<h3>Comments</h3>
					<div class="commentlist">			
						<?php include 'theme/'.$theme.'/comments.php'; ?>
					</div>

		<?php } ?>
		<!-- END OF LOOP -->
			
			<?php include './objects/closedb'; ?>
		</div>
    
    </div>
    
</body>
</html>