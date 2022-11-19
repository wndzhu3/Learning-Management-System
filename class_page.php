<!DOCTYPE html PUBLIC "~e//W3C//DTD XHTML 1.0 Transitional//EN" "http://wwwm.w3.org/TR/xhtml1/DTD/xhtml11-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Class Page</title>
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
	$subject  = $_GET['id'];
	$sid = $_GET['sid'];

	$classinfo = "select courseNumber, courseName, semester, year from class where courseID='$subject'";
	if (!($result = mysqli_query($conn, $classinfo))) {
	printf("Error: %s\n", mysqli_error($conn));
	exit(1);
	}

	while ( $row = mysqli_fetch_assoc( $result )) {	
		$coursenumber = $row["courseNumber"];
		$classname = $row["courseName"];
		$semester = $row["semester"];
		$year = $row["year"];
	}

  ?>
  <h2>Class page for <?php echo $coursenumber . ": " . $classname . " " . $semester . " " . $year?></h2>
  <?php
	$professor = "select firstName, lastName from student where sID in (select instructorID from class where courseID='$subject')";
	if (!($result = mysqli_query($conn, $professor))) {
	printf("Error: %s\n", mysqli_error($conn));
	exit(1);
	}

	$instructor = "";
	while ( $row = mysqli_fetch_assoc( $result ) ) {
		foreach ($row as $key => $value) {
			$instructor = $instructor . "\n" . $value;
		}
		echo "Instructor: " . $instructor;
		echo nl2br("\n\n");
	}
 ?>
 <h3>Assignments</h3>
 <?php

	$query = "select assignmentName, dueDate, assignmentText, totalPoints from assignment where courseID='$subject'";
	if (!($result = mysqli_query($conn, $query))) {
		printf("Error: %s\n", mysqli_error($conn));
		exit(1);
	}
	$totalpoints = array();
	while ( $row = mysqli_fetch_assoc( $result ) ) {
		$totalpoints[$row["assignmentName"]] = $row["totalPoints"];
		foreach ($row as $key => $value) {
			echo $key . ": " . $value;
			echo nl2br("\n");
		}
		echo nl2br("\n\n");
	}
  ?>
  <h3>Class Grades</h3>
  <?php
	$grades = "select assignmentName, grade from assignment_grade where sID='$sid' and courseID='$subject'";
	if (!($result = mysqli_query($conn, $grades))) {
		printf("Error: %s\n", mysqli_error($conn));
		exit();
	}
	while ($row = mysqli_fetch_assoc($result)) {
		$assignmentname = $row["assignmentName"];
		$assignmentgrade = $row["grade"];

		echo $assignmentname.": ".$assignmentgrade.nl2br("\n");
	}

	$finalgrade = "select letterGrade from enrollment_grade where sID='$sid' and courseID='$subject'";
	if (!($result = mysqli_query($conn, $finalgrade))) {
		printf("Error: %s\n", mysqli_error($conn));
		exit();
	}
	while ( $row = mysqli_fetch_assoc( $result )) {
		$lettergrade = $row["letterGrade"];
		echo "Final Grade: " . $lettergrade;
	}
  ?>
  <h3>Q&A</h3>
  <?php
	echo "<a href=\"qa_page.php?id=".$subject."&sid=".$sid."\">Link to Q&A page</a>";
  ?>
 </body>

 <?php
  mysqli_free_result($result);
  mysqli_close($conn);
 ?>
</html>
