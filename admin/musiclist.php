<?php
include 'header.php';
include 'ft.php';
?>

<div class="container mt-4">
    <div class="head text-center mb-4">
        <h1>Music List</h1>
        <hr>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Content ID <small>(Foreign Key)</small></th>
                    <th scope="col">Title</th>
                    <th scope="col">Genre</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM music";
                $result = mysqli_query($con, $sql);
                $i = 0;
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo $row['mid']; ?></th>
                            <td><?php echo $row['cid']; ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['genre']); ?></td>
                            <td class="text-center">
                                <a class="btn btn-success btn-sm me-2" href="edit_music.php?id=<?php echo $row['mid']; ?>&forkey=<?php echo $row['cid']; ?>&mname=<?php echo $row['title']; ?>&genre=<?php echo $row['genre']; ?>&path=<?php echo $row['file_path']; ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a class="btn btn-danger btn-sm" href="delMusic.php?id=<?php echo $row['mid']; ?>">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No music found.</td></tr>";
                }
                ?>
                <tr>
                    <td colspan="4"></td>
                    <td class="text-center">
                        <a href="addMusic.php" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i> Add Music</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Optional Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>