<!DOCTYPE html PUBLIC "~e//W3C//DTD XHTML 1.0 Transitional//EN" "http://wwwm.w3.org/TR/xhtml1/DTD/xhtml11-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Filtered Posts</title>
 </head>
 <body>
  <h2>Filtered Posts</h2>
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

	$subject = $_REQUEST['class'];
        $filter = $_REQUEST["value"];
	echo "<h4>Tag: $filter</h4>";

	$filteredposts = "select postID, posterID, title, postDate, postText from post where courseID='$subject' and postID in (select postID from tag where tag='$filter') order by postDate desc";
        if (!($result = mysqli_query($conn, $filteredposts))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
        }

        while ( $row = mysqli_fetch_assoc( $result )) {
                $postid = $row["postID"];
                $posterid = $row["posterID"];
                $title = $row["title"];
                $postdate = $row["postDate"];
                $posttext = $row["postText"];
                $tags = "select tag from tag where postID='$postid'";
                if (!($tagresults = mysqli_query($conn, $tags))) {
                printf("Error: %s\n", mysqli_error($conn));
                exit(1);
                }
                echo "<h4>" . $posterid . ": " . $title . "</h4>";
                echo "Posted at " . $postdate;
                echo nl2br("\n");
                echo $posttext;
                echo nl2br("\n");
                echo "Tags: ";
                while ($tagrow = mysqli_fetch_assoc($tagresults)) {
                        $tag = $tagrow["tag"];
                        echo $tag . "\n";
                }
                echo nl2br("\n");
                echo "<a href=\"replies.php?postid=".$postid."\">See replies</a>";
                echo nl2br("\n\n");
        }

	echo "<a href=\"qa_page.php?id=".$subject."\">Show all posts</a>";

	mysqli_free_result($result);
	mysql_close($conn);
  ?>
 </body>
</html>
