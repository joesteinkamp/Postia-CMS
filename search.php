<?php include 'objects/pullsettings.php'; // Retrieve settings ?>

<?php

$query = $_GET["q"];


// If no query, give message
if($query == "") {
	echo "Oops! You didnt search for anything. Make sure you type what you want to search in the search box above.";
}

// Perform Search
include './objects/opendb.php';

// Search Posts Table
$result = mysql_query("SELECT * FROM $table_posts WHERE title LIKE '%$query%' OR content LIKE '%$query%' OR author LIKE '%$query%' ORDER BY timestamp DESC LIMIT 10") or die('Error : ' . mysql_error());
	while($row = mysql_fetch_array($result, MYSQL_NUM)) {
		list($id, $content, $timestamp, $author, $title) = $row;
		$content = stripslashes($content);
		
		$search_results .= '<div class="post">';
		if(!$title == "") { $search_results .= '<a href="post.php?id='.$id.'"><h3 class="title">'.$title.'</h3></a>'; } // If post has title, display it.
		$search_results .= '<div class="postcontent">'.$content.'</div>';
		$search_results .= '<div class="postmeta">'.$timestamp.' by <a href="user.php?user='.$author.'">'.$author.'</a></div>';
		$search_results .= '<div class="postnavs"><a href="post.php?id='.$id.'">View</a> | <a href="post.php?id='.$id.'#comment">Comment</a>';
		$user_role = getRole();
		$current_user = getCurrentUser();
		if($user_role  == "3" || $current_user == $author) { $search_results .= ' | <a href="">Edit</a>'; }
		$search_results .= '</div>';
		$search_results .= '</div>';
	}
	
	
	



// End Search
include './objects/closedb.php';


?>


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
		
		<div id="content">
			<h2>Search Results for "<?php echo $query; ?>"</h2>
			<?php echo $search_results; ?>
		</div>
    
    </div>
    
</body>
</html>
