<?php
include 'header.php';
include 'ft.php';

$cid=$_SESSION['cid'];
$q=mysqli_query($con,"SELECT * FROM movie WHERE cid=$cid");
$q2=mysqli_fetch_array($q);
$mid=$q2['mov_id'];
?>

<div class="container">
    <div class="head">
        <div class="jumbotron">
  <h1 class="display-4">Add Content</h1>
  <p class="lead">Add a type & also mention Content ID</p>
  <hr class="my-4">
  <form action="#" method="post">
   <div class="form-row">
    <div class="col-7">
      <input type="text" name="type" class="form-control" placeholder="Content Type">
    </div>
    <div class="col">
      <input type="text" name="cid" value="<?php echo $cid ?>" class="form-control" placeholder="Category ID">
    </div>
    <div class="col">
      <input type="text" name="mid" value="<?php echo $mid ?>" class="form-control" placeholder="Movie ID">
    </div>
  </div>
<br><br>
  <p class="lead">
    <button class="btn btn-primary btn-lg" name="submit" href="#">Add</button>
    </p>
    </form>
</div>
    </div>
</div>

<?php
if(isset($_POST['submit']))
{
$ctype = $_POST['type'];
$cid = $_POST['cid'];
$sql="INSERT INTO `content`(`cid`,'mov_id', `type`) VALUES ($cid,$mid,'$ctype')";
$res = mysqli_query($con,$sql);
$type=mysqli_fetch_array($res);
if($res)
{
    header("Location: movlist.php");
}
else
{
    echo "<script>alert('Something went wrong, please try again.');window.location.href='addCon.php'</script>";
}
}
?>