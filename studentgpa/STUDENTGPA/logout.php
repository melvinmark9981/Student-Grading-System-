<?php
ob_start();
session_start();
if(isset($_SESSION['Student_ID'])) {
	session_destroy();
	unset($_SESSION['Student_login_ID']);
	unset($_SESSION['Student_Name']);
	unset($_SESSION['Student_Course']);
	header("Location: login.php");
} else {
	header("Location: login.php");
}
?>