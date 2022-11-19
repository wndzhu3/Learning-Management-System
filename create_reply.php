<!DOCTYPE html>
<html>
<head>
 <title>Reply Created</title>
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

	$postid = $_REQUEST["postID"];
	$replynumber = $_REQUEST["replyNumber"];
	$replierid = $_REQUEST["replierID"];
	$replytime = date("Y-m-d H:i");
	$replytext = $_REQUEST["replyText"];

	$coourseid = $_REQUEST["courseID"];

	$replynumber = $replynumber + 1;

        $sql = "insert into reply values ('$postid', '$replynumber', '$replierid', '$replytime', '$replytext')";
        if(mysqli_query($conn, $sql)){
            echo "<h3>Reply successfully created. Details:</h3>"; 
  
            echo nl2br("\n$replytime\n$replytext\n");
        } else {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
        }

        echo nl2br("\n");
        echo "<a href=\"replies.php?postid=".$postid."&sid=".$replierid."&cid=".$courseid."\">Return to post</n>";
        mysqli_close($conn);
?>
</body>
</html>
