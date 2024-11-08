<?php
session_start();

// Destroy the session
session_unset();
session_destroy();

//logout success message
$successMessage = 'You have been logged out successfully.';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Logout - Pets Victoria</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ysabeau+SC&family=Poetsen+One&display=swap&family=Permanent+Marker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <?php include 'includes\header.inc'; ?>
</head>
<body>
<?php include 'includes\nav.inc'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Logout</h2>

    <!-- D Logout Success Message -->
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $successMessage; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-primary">Go to Home</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'includes\footer.inc'; ?>
</body>
</html>
