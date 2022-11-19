<!DOCTYPE html>
<html>
<head>
 <title>Grade entered</title>
</head>

<body>
  <?php
    $conn = mysqli_connect("localhost", "cs377", "ma9BcF@Y", "canvas");
    if (!mysqli_select_db ($conn, "canvas")) {
	printf("Error: %s\n", mysqli_error($conn));
	exit();
    }

    $cid = $_REQUEST['class'];
    $sid = $_REQUEST['student'];
    $grade = $_REQUEST['grade'];
    $assignmentname = $_REQUEST['assignmentName'];

    $sql = "insert into assignment_grade values ('$sid', '$cid', '$assignmentname', '$grade') on duplicate key update grade=$grade";
    if(mysqli_query($conn, $sql)){
            echo "<h3>Grade successfully added. Details:</h3>"; 
  
            echo nl2br("\n$sid\n $assignmentname\n $grade\n");
    } else {
      printf("Error: %s\n", mysqli_error($conn));
	exit(1);
    }
    echo nl2br("\n");

    echo "<a href=\"assignment_page.php?id=".$cid."&assignment=".$assignmentname."\">Return to assignment page</n>";
  ?>

</body>
  <?php
    mysqli_close($conn);
  ?>

</html>
