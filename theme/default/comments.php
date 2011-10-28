<!-- *** BEGIN COMMENT SECTON *** -->

<a name="comment"></a>

<!-- Comment Form -->
<?php 
$user_role = getRole();
if($user_role  >= $who_can_comment) { ?> 
	<form method="post" action="objects/addcomment.php" class="postcommentform fullpost">
		<input type="hidden" name="postid" value="<?php echo $id; ?>" />
		<input type="hidden" name="author" value="<?php echo $_SESSION['username']; ?>" />
		<textarea name="content"></textarea>
		<br />
		<input type="submit" value="Post Comment" />
	</form>
<?php } ?>
			
<!-- List of Comments -->
<?php echo displayComments($id, 10, 0); ?>		


<!-- Comment Navigation -->


<!-- *** END COMMENT SECTON *** -->