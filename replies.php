<!DOCTYPE html>
<html>

<head>
<title>Replies</title>
</head>
<body>
<h2>Post</h2>
<?php
	$postid = $_GET["postid"];
	$sid = $_GET["sid"];
	$cid = $_GET["cid"];

	echo $cid;

	$conn = mysqli_connect("localhost", "cs377", "ma9BcF@Y", "canvas");
        if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
        }
        if (!mysqli_select_db ($conn, "canvas")) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
        }

	$posts = "select posterID, title, postDate, postText from post where postID='$postid'";
	$replies = "select replyNumber, replierID, replyTime, replyText from reply where postID='$postid' order by replyNumber asc";

	if (!($originalpost = mysqli_query($conn, $posts))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
        }

        if (!($replythread = mysqli_query($conn, $replies))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
        }

	while ( $row = mysqli_fetch_assoc( $originalpost )) {
                $posterid = $row["posterID"];
                $title = $row["title"];
                $postdate = $row["postDate"];
                $posttext = $row["postText"];
                echo "<h4>" . $posterid . ": " . $title . "</h4>";
                echo "Posted at " . $postdate;
                echo nl2br("\n");
                echo $posttext;
                echo nl2br("\n");
        }

	echo "<h3>Replies</h3>";
	while ($row = mysqli_fetch_assoc($replythread)) {
                $replynumber = $row["replyNumber"];
                $replierid = $row["replierID"];
                $replytime = $row["replyTime"];
                $replytext = $row["replyText"];
                echo "<h4>".$replynumber . ": " . $replierid . ", " . $replytime . "</h4>";
                echo $replytext . nl2br("\n\n");
        }

	echo "<h4>Write a reply</h4>";
?>
<form action="create_reply.php">
    Your reply: <br>
    <input type="text" name="replyText" size="70" maxlength="1000"><br>
    <input type="hidden" name="replierID" value=<?php echo $sid ?>>
    <input type="hidden" name="postID" value=<?php echo $postid ?>>
    <input type="hidden" name="courseID" value=<?php echo $cid ?>>
    <input type="hidden" name="replyNumber" value=<?php echo $replynumber ?>>
    <input type="submit" value="Reply"><br>
 </form>
<?php
	echo "<a href=\"qa_page.php?id=".$cid."&sid=".$sid."\">Return to Q&A</a>";
	mysqli_free_result($originalpost);
	mysqli_free_result($replythread);
	mysqli_close($conn);
?>
</body>

</html>
