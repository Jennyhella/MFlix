<?php 
include 'header.php';
include 'ft.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch movie details
    $query = "SELECT * FROM movie WHERE mov_id = $id";
    $run = mysqli_query($con, $query);

    if ($run && mysqli_num_rows($run) > 0) {
        $row = mysqli_fetch_assoc($run);
        ?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg">
                        <div class="card-header bg-dark text-white text-center">
                            <h3>Edit Movie</h3>
                        </div>
                        <div class="card-body bg-light">
                            <form action="#" method="post" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Movie Title:</label>
                                    <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" class="form-control" placeholder="Enter Movie Title" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="date" class="form-label">Release Date:</label>
                                    <input type="date" name="date" value="<?php echo htmlspecialchars($row['release_date']); ?>" class="form-control" placeholder="Enter Release Date" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="gen" class="form-label">Genre:</label>
                                    <input type="text" name="gen" value="<?php echo htmlspecialchars($row['genre']); ?>" class="form-control" placeholder="Enter Genre" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="thumbnail" class="form-label">Thumbnail URL:</label>
                                    <input type="text" name="thumbnail" value="<?php echo htmlspecialchars($row['thumbnail']); ?>" class="form-control" placeholder="Enter Thumbnail URL">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="path" class="form-label">File Path:</label>
                                    <input type="text" name="path" value="<?php echo htmlspecialchars($row['file_path']); ?>" class="form-control" placeholder="Enter File Path">
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="submit" class="btn btn-dark btn-lg">Update Movie</button>
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
            // Sanitize inputs
            $title = mysqli_real_escape_string($con, $_POST['title']);
            $date = mysqli_real_escape_string($con, $_POST['date']);
            $gen = mysqli_real_escape_string($con, $_POST['gen']);
            $thumbnail = mysqli_real_escape_string($con, $_POST['thumbnail']);
            $path = mysqli_real_escape_string($con, $_POST['path']);

            // Update movie details
            $query = "UPDATE `movie` 
                      SET `title` = '$title', 
                          `release_date` = '$date', 
                          `genre` = '$gen', 
                          `thumbnail` = '$thumbnail', 
                          `file_path` = '$path' 
                      WHERE mov_id = $id";

            $run = mysqli_query($con, $query);

            if ($run) {
                echo "<script>alert('Movie Updated Successfully!');window.location.href='movlist.php';</script>";
            } else {
                echo "<script>alert('Something Went Wrong! Please Try Again.');window.location.href='editmov.php?id=$id';</script>";
            }
        }
    } else {
        echo "<script>alert('Movie Not Found!');window.location.href='movlist.php';</script>";
    }
} else {
    header('Location: movlist.php');
}
?>