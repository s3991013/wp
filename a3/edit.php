<?php
session_start();
require 'includes\db_connect.inc';

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

$pet_id = $_GET['id'];

// Fetch existing pet details
$stmt = $conn->prepare("SELECT * FROM pets WHERE petid = ?");
$stmt->bind_param("i", $pet_id);
$stmt->execute();
$pet = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $petname = trim($_POST['petname']);
    $description = trim($_POST['description']);
    $caption = trim($_POST['caption']);
    $age = $_POST['age'];
    $type = $_POST['type'];
    $location = trim($_POST['location']);

    // Handle image upload
    $new_image = $_FILES['image']['name'];
    if ($new_image) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($new_image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

        // Delete old image
        unlink("images/" . $pet['image']);

        // Update pet with new image
        $stmt = $conn->prepare("UPDATE pets SET petname = ?, description = ?, caption = ?, age = ?, type = ?, location = ?, image = ? WHERE petid = ?");
        $stmt->bind_param("sssdsssi", $petname, $description, $caption, $age, $type, $location, $new_image, $pet_id);
    } else {
        // Update pet without changing image
        $stmt = $conn->prepare("UPDATE pets SET petname = ?, description = ?, caption = ?, age = ?, type = ?, location = ? WHERE petid = ?");
        $stmt->bind_param("sssdssi", $petname, $description, $caption, $age, $type, $location, $pet_id);
    }
    $stmt->execute();
    $stmt->close();

    echo "Pet details updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Pet - Pets Victoria</title>
    <?php include 'includes\header.inc'; ?>
</head>
<body>
<?php include 'includes\nav.inc'; ?>

<div class="container mt-5">
    <h2>Edit Pet Details</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="petname" class="form-label">Pet Name:</label>
            <input type="text" name="petname" class="form-control" value="<?php echo htmlspecialchars($pet['petname']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea name="description" class="form-control" required><?php echo htmlspecialchars($pet['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="caption" class="form-label">Image Caption:</label>
            <input type="text" name="caption" class="form-control" value="<?php echo htmlspecialchars($pet['caption']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="age" class="form-label">Age (months):</label>
            <input type="number" name="age" class="form-control" value="<?php echo $pet['age']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type:</label>
            <select name="type" class="form-select" required>
                <option value="Dog" <?php if ($pet['type'] == 'Dog') echo 'selected'; ?>>Dog</option>
                <option value="Cat" <?php if ($pet['type'] == 'Cat') echo 'selected'; ?>>Cat</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location:</label>
            <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($pet['location']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            <input type="file" name="image" class="form-control">
            <small>Leave blank to keep the current image.</small>
        </div>
        <button type="submit" class="btn btn-primary">Update Pet</button>
    </form>
</div>

<?php include 'includes\footer.inc'; ?>
</body>
</html>
