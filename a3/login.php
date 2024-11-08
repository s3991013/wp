<?php
session_start();
require 'db_connect.inc';

//  error message
$errorMessage = '';

//  form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $hashedPassword = sha1($password);

    // username and password match
    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $hashedPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Successful login
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['successMessage'] = 'Login successful! Welcome back.';

        // Redirect to home page
        header("Location: index.php");
        exit();
    } else {
        // Failed login
        $errorMessage = 'Invalid username or password. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - Pets Victoria</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ysabeau+SC&family=Poetsen+One&display=swap&family=Permanent+Marker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <?php include 'header.inc'; ?>
</head>
<body>
<?php include 'nav.inc'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Login</h2>

    <!-- Display Error Message -->
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $errorMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form action="login.php" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'footer.inc'; ?>
</body>
</html>
