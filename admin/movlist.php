<?php
include 'header.php';
include 'ft.php';
?>

<div class="container mt-4">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
        <a class="navbar-brand fw-bold" href="#"><i class="fas fa-film"></i> Movies on MFlix</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="btn btn-warning text-light me-2" href="addMovie.php"><i class="fas fa-plus"></i> Add a Movie</a>
                </li>
                <li class="nav-item">
                    <form class="d-flex" method="post" action="searchmovie.php">
                        <input class="form-control form-control-sm me-2" name="search" type="text" placeholder="Search Movies" aria-label="Search">
                        <button class="btn btn-success btn-sm" name="submit" type="submit"><i class="fas fa-search"></i> Search</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Movie Cards -->
    <div class="row g-4">
        <?php 
        $query = "SELECT * FROM movie";
        $run = mysqli_query($con, $query);

        if ($run) {
            while ($row = mysqli_fetch_assoc($run)) {
                ?>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="../<?php echo htmlspecialchars($row['thumbnail']); ?>" class="card-img-top rounded" alt="Movie Thumbnail" style="height: 250px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="card-text text-muted"><strong>Release Date:</strong> <?php echo htmlspecialchars($row['release_date']); ?></p>
                            <p class="card-text text-muted"><strong>Genre:</strong> <?php echo htmlspecialchars($row['genre']); ?></p>
                        </div>
                        <div class="card-footer text-center bg-light border-0">
                            <a href="editmov.php?id=<?php echo $row['mov_id']; ?>" class="btn btn-info btn-sm me-2"><i class="fas fa-edit"></i> Edit</a>
                            <a href="deletemov.php?id=<?php echo $row['mov_id']; ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-center'>No movies found.</p>";
        }
        ?>
    </div>
</div>

<!-- Optional Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>