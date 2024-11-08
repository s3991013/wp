<?php
session_start();
require 'includes\db_connect.inc';

// logged in
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: login.php");
    exit();
}

//  success and error messages
$successMessage = '';
$errorMessage = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $petName = trim($_POST['petname']);
    $description = trim($_POST['description']);
    $caption = trim($_POST['caption']);
    $age = intval($_POST['age']);
    $location = trim($_POST['location']);
    $type = trim($_POST['type']);
    $username = $_SESSION['username']; //  session

    // Handle image upload
    $targetDir = "images/";
    $imageFileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $imageFileName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Check if image file 
    $validImageTypes = array("jpg", "jpeg", "png", "gif");
    if (in_array($imageFileType, $validImageTypes)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            // Insert new pet record into 
            $query = "INSERT INTO pets (petname, description, image, caption, age, location, type, username) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssissss", $petName, $description, $imageFileName, $caption, $age, $location, $type, $username);

            if ($stmt->execute()) {
                $successMessage = "Pet added successfully!";
            } else {
                $errorMessage = "Error adding pet. Please try again.";
            }
        } else {
            $errorMessage = "Error uploading image file.";
        }
    } else {
        $errorMessage = "Invalid image file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Pet - Pets Victoria</title>
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
    <h2 class="text-center mb-4">Add New Pet</h2>

    <!-- Display Success Message -->
    <?php if ($successMessage): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $successMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Display Error Message -->
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $errorMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Add Pet Form -->
    <form action="add.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="petname" class="form-label">Pet Name</label>
            <input type="text" class="form-control" id="petname" name="petname" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="caption" class="form-label">Image Caption</label>
            <input type="text" class="form-control" id="caption" name="caption" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Upload Image</label>
            <input type="file" class="form-control" id="image" name="image" accept=".jpg,.jpeg,.png,.gif" required>
        </div>
        <div class="mb-3">
            <label for="age" class="form-label">Age (in months)</label>
            <input type="number" class="form-control" id="age" name="age" min="0" required>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-select" id="type" name="type" required>
                <option value="" disabled selected>Select pet type</option>
                <option value="Dog">Dog</option>
                <option value="Cat">Cat</option>
                <!-- Add more options as needed -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Pet</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'includes\footer.inc'; ?>
</body>
</html>
