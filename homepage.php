<!DOCTYPE html>
<html>
<head>
<title>Homepage</title>

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

        $studentid = $_REQUEST["studentid"];
        $loginid = $_REQUEST["loginid"];

        $checkauthenticity = "select loginID, sID from login where loginID='$loginid' and sID='$studentid'";

        if(!($isauthentic = mysqli_query($conn, $checkauthenticity))){
		printf("Error: %s\n", mysqli_error($conn));
        	exit();
        }

	if (mysqli_num_rows($isauthentic)==0) {
		echo "Signin information not found. Try a different Student ID and/or Login ID." . nl2br("\n");
		echo "<a href=\"index.php\">Return to login</a>";
		exit();
	}

	$userinfo = "select firstName, lastName, isInstructor, isTA from student where sID='$studentid'";
	if (!($result = mysqli_query($conn, $userinfo))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
        }

        while ( $row = mysqli_fetch_assoc( $result )) { 
		$firstname = $row["firstName"];
		$lastName = $row["lastName"];
		$isinstructor = $row["isInstructor"];
		$ista = $row["isTA"];
        }
?>
<h3>Welcome, <?php echo $firstname ?></h3>
<h4>Your Student Courses</h4>
<?php
	$query = "select * from class where courseID in (select courseID from enrollment_grade where sID='$studentid') order by courseID asc";
	if (!($result = mysqli_query($conn, $query))) {
	printf("Error: %s\n", mysqli_error($conn));
	exit();
	}

	if (mysqli_num_rows($result) == 0) {
		echo "No courses to display." . nl2br("\n");
	} else {
	while ($row = mysqli_fetch_assoc($result)) {
		$courseid = $row["courseID"];
		$coursenumber = $row["courseNumber"];
		$coursename = $row["courseName"];
		$semester = $row["semester"];
		$year = $row["year"];
		$instructorid = $row["instructorID"];

		$fullcoursename = $coursenumber . ": " . $coursename . " " . $semester . " " . $year;
		echo "<a href=\"class_page.php?id=".$courseid."&sid=".$studentid."\">".$fullcoursename."</a>";
		echo nl2br("\n");
	}
	}

?>
<h4>Your Instructor Courses</h4>
<?php
        $query = "select * from class where instructorID='$studentid' order by courseID asc";
        if (!($result = mysqli_query($conn, $query))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
        }
        if (mysqli_num_rows($result) == 0) {
                echo "No courses to display." . nl2br("\n");
        } else {
        while ($row = mysqli_fetch_assoc($result)) {
                $courseid = $row["courseID"];
                $coursenumber = $row["courseNumber"];
                $coursename = $row["courseName"];
                $semester = $row["semester"];
                $year = $row["year"];
                $instructorid = $row["instructorID"];
                $fullcoursename = $coursenumber . ": " . $coursename . " " . $semester . " " . $year;
                echo "<a href=\"instructor_class_page.php?id=".$courseid."&sid=".$studentid."\">".$fullcoursename."</a>";
                echo nl2br("\n");
        }
        }
?>
<h4>Your TA Courses</h4>
<?php
        $query = "select * from class where courseID in (select courseID from ta where sID='$studentid') order by courseID asc";
        if (!($result = mysqli_query($conn, $query))) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
        }
        if (mysqli_num_rows($result) == 0) {
                echo "No courses to display." . nl2br("\n");
        } else {
        while ($row = mysqli_fetch_assoc($result)) {
                $courseid = $row["courseID"];
                $coursenumber = $row["courseNumber"];
                $coursename = $row["courseName"];
                $semester = $row["semester"];
                $year = $row["year"];
                $instructorid = $row["instructorID"];
                $fullcoursename = $coursenumber . ": " . $coursename . " " . $semester . " " . $year;
                echo "<a href=\"ta_class_page.php?id=".$courseid."&sid=".$studentid."\">".$fullcoursename."</a>";
                echo nl2br("\n");
        }
        }
?>
<?php
 mysqli_close($conn);
?>
</body>

</html>
