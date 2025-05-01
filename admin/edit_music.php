<?php 
include 'header.php';
include 'ft.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch movie details
    $query = "SELECT * FROM music WHERE mid = $id";
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
                                    <label for="title" class="form-label">Music Title:</label>
                                    <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" class="form-control" placeholder="Music Title" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="g" class="form-label">Genre:</label>
                                    <input type="text" name="genre" value="<?php echo htmlspecialchars($row['genre']); ?>" class="form-control" placeholder="Genre" required>
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
            $gen = mysqli_real_escape_string($con, $_POST['genre']);
            $path = mysqli_real_escape_string($con, $_POST['path']);

            // Update movie details
            $query = "UPDATE music SET title = '$title', genre = '$gen', file_path = '$path' WHERE mid = $id";

            $run = mysqli_query($con, $query);

            if ($run) {
                echo "<script>alert('Music Updated Successfully!');window.location.href='musiclist.php';</script>";
            } else {
                echo "<script>alert('Something Went Wrong! Please Try Again.');window.location.href='edit_music.php?id=$id';</script>";
            }
        }
    } else {
        echo "<script>alert('Movie Not Found!');window.location.href='musiclist.php';</script>";
    }
} else {
    header('Location: musiclist.php');
}
?>