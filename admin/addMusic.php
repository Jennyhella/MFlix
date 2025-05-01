<?php
include 'header.php';
include 'ft.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white text-center">
                    <h3>Add Music</h3>
                </div>
                <div class="card-body bg-light">
                    <form action="addMusic.php" method="post">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Music Title:</label>
                            <input type="text" name="title" class="form-control" placeholder="Music Title" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="cid" class="form-label">Content ID:</label>
                            <input type="text" name="cid" class="form-control" placeholder="Content ID" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="ar_id" class="form-label">Artist ID:</label>
                            <input type="text" name="ar_id" class="form-control" placeholder="Artist ID" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="aid" class="form-label">Album ID:</label>
                            <input type="text" name="aid" class="form-control" placeholder="Album ID">
                        </div>
                        <div class="form-group mb-3">
                            <label for="genre" class="form-label">Genre:</label>
                            <input type="text" name="genre" class="form-control" placeholder="Genre" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="fpath" class="form-label">File Path:</label>
                            <input type="text" name="fpath" class="form-control" placeholder="File URL" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-dark btn-lg">Add Music</button>
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
    $ar_id = $_POST['ar_id'];
    $genre = $_POST['genre'];
    $aid = $_POST['aid'];
    $fpath = $_POST['fpath'];

    // Insert into the music table
    $sql = "INSERT INTO `music`(`cid`, `ar_id`, `aid`, `title`, `genre`, `file_path`) VALUES ($cid, $ar_id, $aid, '$title', '$genre', '$fpath')";
    $res = mysqli_query($con, $sql);

    if ($res) {
        // Fetch the inserted music ID
        $q = "SELECT * FROM music WHERE cid = $cid ORDER BY mid DESC LIMIT 1";
        $q2 = mysqli_query($con, $q);
        $q3 = mysqli_fetch_array($q2);
        $mid = $q3['mid'];

        // Insert into the content table
        $sql = mysqli_query($con, "INSERT INTO `content`(`cid`, `mid`, `type`) VALUES ($cid, $mid, 'music')");
        if ($sql) {
            echo "<script>alert('Music added successfully.');window.location.href='musiclist.php';</script>";
        } else {
            echo "<script>alert('Something went wrong, please try again.');window.location.href='addMusic.php';</script>";
        }
    } else {
        echo "<script>alert('Something went wrong, please try again.');window.location.href='addMusic.php';</script>";
    }
}
?>