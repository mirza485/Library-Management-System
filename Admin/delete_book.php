<?php
session_start();
	if(!isset($_SESSION['email']))
{
	die(include('../user/error.html'));
}
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,"lms");
	$query = "delete from books where book_no = $_GET[bn]";
	$query_run = mysqli_query($connection,$query);
?>
<script type="text/javascript">
	alert("Book Deleted successfully...");
	window.location.href = "manage_book.php";
	
</script>
