<!DOCTYPE html>
<html>
<head>
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

        $classID  = $_GET['id'];
	$assignment = $_GET['assignment'];

	echo "<h3>$assignment</h3>";

        $assignmentinfo = "select dueDate, assignmentText, totalPoints from assignment where courseID='$classID' and assignmentName='$assignment'";
        if (!($result = mysqli_query($conn, $assignmentinfo))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
        }
        while ( $row = mysqli_fetch_assoc( $result )) {
		foreach ($row as $key => $value) {
			echo $key . ": " . $value;
               		echo nl2br("\n");
		}

        }
	echo "<h4>Grades</h4>";

	$studentgrades = "select sID, grade from assignment_grade where courseID='$classID' and assignmentName='$assignment'";
	 if (!($result = mysqli_query($conn, $studentgrades))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit(1);
        }
        while ( $row = mysqli_fetch_assoc( $result )) {
		foreach ($row as $key => $value) {
			echo $key . ": " . $value;
               		echo nl2br("\n");
		}
		echo nl2br("\n");

        }
?>
<h4>Enter a grade</h4>
<form action="enter_grade.php">
	<input type="hidden" name="class" value=<?php echo $classID ?>>
	<input type="hidden" name="assignmentName" value=<?php echo $assignment ?>>
	Enter grade for student:<br>
	<select name="student">
		<?php
		$students = "select sID, firstName, lastName from student where sID in (select sID from enrollment_grade where courseID='$classID')";
		if (!($result = mysqli_query($conn, $students))) {
        	printf("Error: %s\n", mysqli_error($conn));
        	exit(1);
        	}
		while ( $row = mysqli_fetch_assoc( $result )) {
			$sid = $row["sID"];
			$firstname = $row["firstName"];
			$lastname = $row["lastName"];
			echo "<option value=$sid>$firstname $lastname</option>";
		}
		?>
	</select>
	<br>
	Enter grade:<br>
	<input type="text" maxlength=3 name="grade"><br>
	<input type="submit"><br>
	<br>
</form>

<?php

	echo "<a href=\"instructor_class_page.php?id=".$classID."\">Go back to class page</a>";
	mysqli_free_result($result);
?>

</body>
<?php mysqli_close($conn); ?>
</html>
