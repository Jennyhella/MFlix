<?php 
include 'header.php';
include 'ft.php';

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$query = "DELETE FROM `movie` WHERE mov_id=$id";
	$run = mysqli_query($con,$query);
	if ($run) {
		header('location:movlist.php');
	}
	else{
		echo "<script>alert('Something went Wrong!!');window.location.href='movlist.php';</script>";
	}
}
else{
	header('location:movlist.php');
}

 ?>