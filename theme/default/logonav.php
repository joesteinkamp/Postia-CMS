<div id="logo">
	<h1 class="sitename"><?php echo $site_name; ?></h1>
	<h2 class="slogan"><?php echo $site_slogan; ?></h2>
</div>

<div id="search">
	<form method="get" action="search.php">
		<input type="text" name="q" id="q" value="" />
		<input type="submit" value="Search" />
	</form>
</div>


<ul id="menu">
	<li><a href="index.php">Home</a></li>
	
	<?php echo list_navigation(); ?>
	
</ul>


