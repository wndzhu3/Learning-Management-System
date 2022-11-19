<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <!--
    Modified from the Debian original for Ubuntu
    Last updated: 2016-11-16
    See: https://launchpad.net/bugs/1288690
  -->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Canvas</title>
<?php
	$conn = mysqli_connect("localhost", "cs377", "ma9BcF@Y", "canvas");
	// check connection
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	if (!mysqli_select_db ($conn, "canvas")) {
		printf("Error: %s\n", mysqli_error($conn));
		exit();
	}
?>

<h3>Sign In</h4>
<form action="homepage.php">
Student ID<br>
<input type="text" name="studentid"><br>
Login ID<br>
<input type="text" name="loginid"><br>
<input type="submit" name="Sign in"><br>
</form>


  </body>

<?php
mysqli_close($conn);
?>
</html>

