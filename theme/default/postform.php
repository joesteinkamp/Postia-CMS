<?php 
$user_role = getRole();
if($user_role  >= $who_can_post) { ?> 
	<form enctype="multipart/form-data" method="post" action="objects/addpost.php">
	    <textarea name="post" rows="8" placeholder="Type content here"></textarea><br />
	    <input type="submit" id="submit" value="Post" />
	    
	    <input type="file" id="file" name="file" />
	    
	    <!-- Set the file size upload limit here (in kilobtyes) -->
		<input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
		<input type="text" id="title" name="title" value="" placeholder="Add Title (Optional)" />
	    
	    <div style="clear:both;"></div>
	</form>

<?php } ?>