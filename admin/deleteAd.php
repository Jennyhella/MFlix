<?php
include 'C:\wamp64\www\Project\db.php';
$id=$_GET['id'];
$sql="DELETE FROM admin WHERE id=$id";
$res=mysqli_query($conn,$sql);
if($res)
{
    header("Location: adlist.php");
}
else
{
    echo "Something went wrong.";
}
?>