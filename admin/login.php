<!doctype html>
<html>
<?php
include 'ft.php';
include '../includes/config.php';
?>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white text-center">
                    <h3>Admin Login</h3>
                </div>
                <div class="card-body bg-dark text-white">
                    <form action="login.php" method="post">
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" name="name" class="form-control bg-light text-dark" id="username" placeholder="Enter Admin Username" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" name="pwd" class="form-control bg-light text-dark" id="password" placeholder="Enter Password" required>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" name="submit" class="btn btn-outline-light">Login</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center bg-dark text-white">
                    <small class="text-white">Enter your admin credentials to access the dashboard.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $pwd = $_POST['pwd'];
    $sql = "SELECT * FROM admin WHERE name = '$name'";

    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($pwd, $row['pwd'])) {
                $_SESSION['login'] = 1;
                $_SESSION['name'] = $name;
                header("Location: index.php");
                exit();
            }
        }
    } else {
        echo "<script> alert('Invalid credentials.')</script>";
    }
}
?>
</body>
</html>