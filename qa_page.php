<!DOCTYPE html PUBLIC "~//W3C//DTD XHTML 1.0 Transitional//EN" "http://wwwm.w3.org/TR/xhtml1/DTD/xhtml11-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Class Q&A</title>
 </head>
 <body>
  <h2>Q&A Posts</h2>
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

        $subject  = $_GET['id'];
	$sid = $_GET['sid'];

	$alltags = "select distinct tag from tag where postID in (select postID from post where courseID='$subject')";
	if (!($alltagsresult = mysqli_query($conn, $alltags))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
        }
  ?>
  <form action='filter_posts.php' name='form_filter' >
    <input type="hidden" name="class" value=<?php echo $subject ?>>
    <select name="value">
	<?php
	while ($row = mysqli_fetch_assoc($alltagsresult)) {
		$tag = $row["tag"];
		echo '<option value="'.$tag.'">'.$tag.'</option>';
	}
	?>
    </select>
    <br />
    <input type='submit' value = 'Filter'>
  </form>
  <?php
	$posts = "select postID, posterID, title, postDate, postText from post where courseID='$subject' order by postDate desc";
        if (!($result = mysqli_query($conn, $posts))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
        }
	$numberofposts = 0;
        while ( $row = mysqli_fetch_assoc( $result )) {
		$numberofposts = $numberofposts + 1;

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
			foreach ($tagrow as $key => $value) {
			echo $value . "\n";
			}
		}
		echo nl2br("\n");
		echo "<a href=\"replies.php?postid=".$postid."&sid=".$sid."&cid=".$subject."\">See replies</a>";
		echo nl2br("\n\n");
        }

  ?>
  <h3>Create a post</h3>
  <form action="create_post.php">
    Post Title
    <input type="text" name="postTitle" size="30" maxlength="150"><br>
    Post Text<br>
    <input type="text" name="postText" size="70" maxlength="1000"><br>
    Tags<br>
	<?php
	$alltags = "select distinct tag from tag where postID in (select postID from post where courseID='$subject')";
        if (!($alltagsresult = mysqli_query($conn, $alltags))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
        }

	while ($row = mysqli_fetch_assoc($alltagsresult)) {
		$tag = $row["tag"];
		echo '<input type="checkbox" name="tag[]" value="'.$tag.'">'.$tag.'</option><br>';
	}
	?>
    <input type="hidden" name="posterID" value=<?php echo $sid ?>>
    <input type="hidden" name="courseID" value=<?php echo $subject ?>>
    <input type="hidden" name="postNumber" value=<?php echo $numberofposts ?>>
    <input type="submit" value="Post"><br>
  </form>
  <?php

	mysqli_free_result($result);
	mysqli_free_result($alltagsresult);
	mysqli_free_result($tagresults);
	mysqli_close($conn);
  ?>
  
 </body>
</html>
