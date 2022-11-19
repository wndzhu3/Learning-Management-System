<!DOCTYPE html>
<html>
<head>
 <title>Post Created</title>
</head>

<body>
<?php
	$conn = mysqli_connect("localhost", "cs377", "ma9BcF@Y", "canvas");
        if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
        }
        if (!mysqli_select_db ($conn, "canvas")) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
        }

	$courseid = $_REQUEST["courseID"];
	$posterid = $_REQUEST["posterID"];
	$posttitle = $_REQUEST["postTitle"];
	$posttext = $_REQUEST["postText"];
	$postnumber = $_REQUEST["postNumber"];
	$postdate = date("Y-m-d H:i");
	$tags = $_REQUEST["tag"];

	$postnumber = $postnumber + 1;
	$postid = $courseid . "_" . $postnumber;

	$sql = "insert into post values ('$postid', '$posterid', '$courseid', '$posttitle', '$postdate', '$posttext')";
    	if(mysqli_query($conn, $sql)){
            echo "<h3>Post successfully created. Details:</h3>"; 
  
            echo nl2br("\n$posttitle\n$postdate\n$posttext\n");
    	} else {
      	printf("Error: %s\n", mysqli_error($conn));
        exit(1);
    	}

	for ($x=0; $x<count($tags); $x++) {
		$inserttag = "insert into tag values ('$postid', '$tags[$x]')";
		if(!mysqli_query($conn, $inserttag)){
        		printf("Error: %s\n", mysqli_error($conn));
        		exit(1);
        	}
	}

    	echo nl2br("\n");
    	echo "<a href=\"qa_page.php?id=".$courseid."&sid=".$posterid."\">Return to Q&A page</a>";

	mysqli_close($conn);
?>

</body>


</html>
