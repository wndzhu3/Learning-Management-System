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

    $sql = "insert into enrollment_grade values ('$sid', '$cid', '$grade') on duplicate key update letterGrade='$grade'";
    if(mysqli_query($conn, $sql)){
            echo "<h3>Grade successfully added. Details:</h3>"; 
  
            echo nl2br("\n$sid\n$cid\n$grade\n");
    } else {
      printf("Error: %s\n", mysqli_error($conn));
	exit(1);
    }
    echo nl2br("\n");

    echo "<a href=\"instructor_class_page.php?id=".$cid."\">Return to class page</a>";
  ?>

</body>
  <?php
    mysqli_free_result($result);
    mysqli_close($conn);
  ?>

</html>
