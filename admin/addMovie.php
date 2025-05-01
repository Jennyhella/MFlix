<?php
include 'header.php';
include 'ft.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white text-center">
                    <h3>Add Movie</h3>
                </div>
                <div class="card-body bg-light">
                    <form action="addMovie.php" method="post" enctype="multipart/form-data">
                        <div class="form-group mb-3">
                            <label for="cid" class="form-label">Content ID:</label>
                            <input type="text" name="cid" class="form-control" placeholder="Enter Content ID" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Movie Title:</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter Movie Title" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="date" class="form-label">Release Date:</label>
                            <input type="date" name="date" class="form-control" placeholder="Enter Release Date" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="genre" class="form-label">Genre:</label>
                            <input type="text" name="genre" class="form-control" placeholder="Enter Genre" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail URL:</label>
                            <input type="text" name="thumbail" class="form-control" placeholder="Enter Image URL" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="fpath" class="form-label">File Path:</label>
                            <input type="text" name="fpath" class="form-control" placeholder="Enter File Path" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-dark btn-lg" name="submit">Add Movie</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center bg-dark text-white">
                    <small>Ensure all fields are filled correctly before submitting.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $cid = $_POST['cid'];
    $title = $_POST['title'];
    $date = $_POST['date'];
    $genre = $_POST['genre'];
    $thumbail = $_POST['thumbail'];
    $fpath = $_POST['fpath'];

    $sql = "INSERT INTO `movie`(`cid`, `title`, `release_date`, `genre`, `thumbnail`, `file_path`) VALUES ($cid,'$title','$date','$genre','$thumbail','$fpath')";
    $res = mysqli_query($con, $sql);
    if ($res) {
        $q = "SELECT * FROM movie WHERE cid=$cid ORDER BY mov_id DESC LIMIT 1";
        $q2 = mysqli_query($con, $q);
        $q3 = mysqli_fetch_array($q2);
        $mid = $q3['mov_id'];
        $sql = mysqli_query($con, "INSERT INTO `content`(`cid`, `mov_id`, `type`) VALUES ($cid,$mid,'movie')");
        if ($sql) {
            header("Location: movlist.php");
        } else {
            echo "<script>alert('Something went wrong, please try again.');window.location.href='addMovie.php'</script>";
        }
    } else {
        echo "<script>alert('Something went wrong, please try again.');window.location.href='addMovie.php'</script>";
    }
}
?>