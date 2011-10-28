<!-- *** POSTS SECTION *** -->

<!-- List of Posts -->
<?php $start_from = ($page-1) * 10; echo displayFullPosts(10, $start_from); ?>
<!-- End of List of Posts -->


<!-- Post Navigation -->
<?php $nextpage = $page+1; $previouspage = $page-1; ?>
<p><a href="index.php?page=<?php echo $previouspage;?>">Previous Posts</a> | <a href="index.php?page=<?php echo $nextpage; ?>">Next Posts</a></p>
<!-- End Post Navigation -->


<!-- *** END OF POST SECTION *** -->