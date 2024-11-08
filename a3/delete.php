<?php
session_start();
require 'db_connect.inc';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: login.php");
    exit();
}

// Initialize success and error messages
$successMessage = '';
$errorMessage = '';

// Check if pet ID is provided
if (isset($_GET['petid']) && !empty($_GET['petid'])) {
    $petID = intval($_GET['petid']);  // Convert petid to an integer for safety

    // Check if deletion is confirmed
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // Fetch the pet image filename to delete from the images folder
        $query = "SELECT image FROM pets WHERE petid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $petID);
        $stmt->execute();
        $result = $stmt->get_result();
        $pet = $result->fetch_assoc();

        if ($pet) {
            $imagePath = 'images/' . $pet['image'];

            // Delete the pet record
            $deleteQuery = "DELETE FROM pets WHERE petid = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $petID);

            if ($deleteStmt->execute()) {
                // Delete the image file if it exists
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $successMessage = "Pet record deleted successfully!";
            } else {
                $errorMessage = "Error deleting pet record. Please try again.";
            }
        } else {
            $errorMessage = "Pet not found.";
        }
    }
} else {
    $errorMessage = "No pet ID provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete Pet - Pets Victoria</title>
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
    <h2 class="text-center mb-4">Delete Pet</h2>

    <!-- Display Success Message -->
    <?php if ($successMessage): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $successMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="text-center mt-4">
            <a href="pets.php" class="btn btn-primary">Back to Pets</a>
        </div>
    <?php endif; ?>

    <!-- Display Error Message -->
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $errorMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="text-center mt-4">
            <a href="pets.php" class="btn btn-primary">Back to Pets</a>
        </div>
    <?php endif; ?>

    <!-- Confirmation Prompt -->
    <?php if (!$successMessage && !$errorMessage && !isset($_GET['confirm'])): ?>
        <div class="alert alert-warning text-center" role="alert">
            Are you sure you want to delete this pet record? This action cannot be undone.
        </div>
        <div class="text-center mt-4">
            <a href="delete.php?petid=<?php echo htmlspecialchars($petID); ?>&confirm=yes" class="btn btn-danger">Yes, Delete</a>
            <a href="pets.php" class="btn btn-secondary">Cancel</a>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'footer.inc'; ?>
</body>
</html>
