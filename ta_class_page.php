<!DOCTYPE html PUBLIC "~e//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml11-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>TA Class Page</title>
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
  <h2>TA page for <?php echo $coursenumber . ": " . $classname . " " . $semester . " " . $year?></h2>
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
                if ($key == "assignmentName") {
                              echo $key . ": " . "<a href=\"assignment_page.php?id=".$subject."&assignment=".$value."\">$value</a>";
                              echo nl2br("\n");
                      } else {
                      echo $key . ": " . $value;
                      echo nl2br("\n");
                      }
              }
              echo nl2br("\n\n");
      }
      mysqli_free_result($result);
?>
<h3>Add an assignment</h3>
<form action="addassignment.php">
  <input type="hidden" name="course" value=<?php echo $subject ?>>
  Assignment name:<br>
  <input type="text" name="assignmentname"><br>
  Total points:<br>
  <input type="text" name="points"><br>
  Due date:<br>
  <input type="datetime-local" name="duedate"><br>
  Assignment description:<br>
  <input type="text" name="description" size="50"><br>
  <input type="submit"><br>
  <p> </p>
</form>
<h3>Student grades</h3>
<?php
      $query = "select sID, letterGrade from enrollment_grade where courseID='$subject'";
      if (!($result = mysqli_query($conn, $query))) {
              printf("Error: %s\n", mysqli_error($conn));
              exit(1);
      }
      while ( $row = mysqli_fetch_assoc( $result ) ) {
      foreach ($row as $key => $value) {
                      echo $key . ": " . $value;
                      echo nl2br("\n");
              }
              echo nl2br("\n");
      }
      mysqli_free_result($result);
?>
<h4>Enter grades</h4>
<form action="enter_class_grade.php">
      <input type="hidden" name="class" value=<?php echo $subject ?>>
      Enter grade for student:
      <select name="student">
              <?php
              $students = "select sID, firstName, lastName from student where sID in (select sID from enrollment_grade where courseID='$subject')";
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
      </select><br>
      Enter letter grade:<br>
      <input type="text" maxlength=2 name="grade"><br>
      <input type="submit"><br>
      <br>
</form>
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

