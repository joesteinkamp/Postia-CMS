<?php

// Add new post

// *** Requirements ***
	// Pull Settings
	include 'pullsettings.php';
	
	// CALL classes
	require '../includes/classes.php';
    
// *** End Requirements ***


// *** Retrieve Content ***

	$text = $_POST["post"];
	
// *** End Retrieve ***

// ***** File Upload *****
	$file_size_limit = $_POST['MAX_FILE_SIZE']; // Set in form.php in theme
	$target = "../uploads/";
	$temp_dir = $_FILES['file']['tmp_name'];
	$file_name = $_FILES['file']['name'];
	$file_type = $_FILES['file']['type'];
	$file_size = $_FILES['file']['size'];
	
	// Check if filename exists. If so, add number to the beginning
	$num = "";
	while(file_exists($target . $num . $file_name)) {
		$num++;
		
	}
	$file_name = $num . $file_name;
	// END fix file name
	
	if($file_size < $file_size_limit && !$file_name == "") {
		try
		{
			move_uploaded_file($temp_dir, $target . $file_name);
			$status = 1;
		}
		
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
	
	// If Successful - Insert into text
	if(isset($status)) {
		$path = $site_url . "/uploads/" . $file_name;
		$text .= '<br /><br />Attachments: <a href="'.$path.'">'.$file_name.'</a>';
	}
	
// ***** End File Upload *****


// *** Transform Text ***

	// Find URLs & Replace w/ Clickable Links
		$text = MakeItLink::transform( $text );
	
	// Find Video URL & Embed
		$AE = new AutoEmbed();
	    if($AE->parseUrl($text)){
	        $embedcode = $AE->getEmbedCode();
	        $text .= "<br />" . $embedcode;
	    }
	
	// Find Image URL, Word Doc, PowerPoint, Excel Spreadsheet, PDF & Embed
		if(preg_match('!http://[^?#]+\.(?:jpe?g|png|gif)!Ui', $text, $match)) {
	        $imgembed = '<a href="' . $match[0] . '" target="_blank"><img width="450px" src="' . $match[0] . '" /></a>';
	        $text .= "<br />" . $imgembed;
	    }
	    elseif(preg_match('!http://[^?#]+\.(?:docx?)!Ui', $text, $docmatch)) {
	    	// File is Word Doc
	    	$docname = "Word Document - " . basename($docmatch[0]);
	    	$docembed = '<a href="' . $docmatch[0] . '" target="_blank" class="worddoc")>' . $docname . '</a>';
	    	$text .= "<p>" . $docembed . "</p>";
	    
	    }
	    elseif(preg_match('!http://[^?#]+\.(?:pptx?)!Ui', $text, $pptmatch)) {
	    	// File is PowerPoint
	    	$pptname = "Powerpoint - " . basename($pptmatch[0]);
	    	$pptembed = '<a href="' . $pptmatch[0] . '" target="_blank" class="powerpoint")>' . $pptname . '</a>';
	    	$text .= "<p>" . $pptembed . "</p>";
	    	
	    }
	    elseif(preg_match('!http://[^?#]+\.(?:xlsx?)!Ui', $text, $xlsmatch)) {
	    	// File is Excel
	    	$xlsname = "Excel - " . basename($xlsmatch[0]);
	    	$xlsembed = '<a href="' . $xlsmatch[0] . '" target="_blank" class="excel")>' . $xlsname . '</a>';
	    	$text .= "<p>" . $xlsembed . "</p>";
	    	
	    }
	    elseif(preg_match('!http://[^?#]+\.(?:pdf)!Ui', $text, $pdfmatch)) {
	    	// File is PDF
	    	$pdfname = "PDF Document - " . basename($pdfmatch[0]);
	    	$pdfembed = '<a href="' . $pdfmatch[0] . '" target="_blank" class="pdf")>' . $pdfname . '</a>';
	    	$text .= "<p>" . $pdfembed . "</p>";
	    	
	    }
	
	
	// Lastly, Add Slashes for SQL Insert
		 $text = addslashes($text);

// *** End Transform Text

// *** Timestamp ***

	$timestamp = date('Y-m-d H:i:s');
// *** End Timestamp ***


// *** Author ***
	session_start();
	$author = $_SESSION['username'];
	if($author == "") {
		$author = "Anonymous";
	}
	
// *** End Author ***

// *** Title ***
	$title = $_POST['title'];
// *** End Title ***



// *** Insert Post Into DB ***
	addPost($text, $timestamp, $author, $title);


// *** Functions ***

	// FUNCTION: Add new post
	function addPost($content, $timestamp, $author, $title) {
		include 'opendb.php'; // Open database connection
	    mysql_query("INSERT INTO $table_posts (content, timestamp, author, title) VALUES ('$content', '$timestamp', '$author', '$title')") or die('Error : ' . mysql_error());
	    include 'closedb.php'; // Close database connection
	}

// *** End Functions ***


// FIND LINK IN POST

    
    
    
    
    // FUNCTION: Find link in $post. Return boolean
    function findLink($text) {
        // Link filter
        $link_filter = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        
        if(preg_match($link_filter, $text, $url)) {
            $return = "true"; // Link found
        }
        else {
            $return = "false"; // No link found
        }
        
        
        return $return;
    }
    
    // FUNCTION: Find if there are short urls. Then replace them using expandShortUrl()
    function findReplaceShortUrls() {
        
    }
    
    // FUNCTION: Expand short urls
    function expandShortUrl($shorturl) {
        $headers = get_headers($shorturl, 1);
        
        return $headers['Location'];
    }





// ********* TESTING ***********
    
    
    
    
    
// ********* TESTING *************


// *** Redirect ***
	header("Location: ../index.php");
	
	
	



?>