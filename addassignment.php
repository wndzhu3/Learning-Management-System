<!DOCTYPE html>
<html>
<head>
 <title>Assignment added</title>
</head>

<body>
  <?php
    $conn = mysqli_connect("localhost", "cs377", "ma9BcF@Y", "canvas");
    if (!mysqli_select_db ($conn, "canvas")) {
	printf("Error: %s\n", mysqli_error($conn));
	exit();
    }

    $courseID = $_REQUEST['course'];
    $assignmentname = $_REQUEST['assignmentname'];
    $totalpoints = $_REQUEST['points'];
    $duedate = $_REQUEST['duedate'];
    $assignmentdescription = $_REQUEST['description'];

    $sql = "insert into assignment values ('$courseID', '$assignmentname', '$duedate', '$assignmentdescription', '$totalpoints') on duplicate key update dueDate='$duedate', assignmentText='$assignmentdescription', totalPoints='$totalpoints'";
    if (mysqli_query($conn, $sql)){
            echo "<h3>Assignment successfully added or updated. Assignment details:</h3>";
            echo nl2br("\n$courseID\n $assignmentname\n "
                . "$duedate\n $assignmentdescription\n $totalpoints");
    } else {
      printf("Error: %s\n", mysqli_error($conn));
	exit(1);
    }
    echo nl2br("\n");
    echo "<a href=\"instructor_class_page.php?id=".$courseID."\">Return to class page</n>";
  ?>

</body>
  <?php
    mysqli_close($conn);
  ?>

</html>
