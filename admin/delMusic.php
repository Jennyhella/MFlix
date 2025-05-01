<?php 
include 'header.php';
include 'ft.php';

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$query = "DELETE FROM `music` WHERE mid=$id";
	$run = mysqli_query($con,$query);
	if ($run) {
        echo "<script>alert('Music deleted successfully!');window.location.href='musiclist.php';</script>";
	}
	else{
		echo "<script>alert('Something went Wrong!!');window.location.href='musiclist.php';</script>";
	}
}
else{
	header('location:musiclist.php');
}

 ?>