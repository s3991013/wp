<?php
session_start();
require 'includes\db_connect.inc';

// Check if pet ID is set in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $pet_id = $_GET['id'];

    // y to fetch pet details
    $stmt = $conn->prepare("SELECT petname, type, age, location, description, image FROM pets WHERE petid = ?");
    $stmt->bind_param("i", $pet_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the pet exists
    if ($result->num_rows > 0) {
        $pet = $result->fetch_assoc();
    } else {
        echo "<p class='text-center'>No pet found with that ID.</p>";
        exit;
    }
} else {
    echo "<p class='text-center'>Invalid pet ID.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pet['petname']); ?> - Pet Details</title>
    <!-- Google Fonts and Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Ysabeau+SC&family=Poetsen+One&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'includes\nav.inc'; ?>

<div class="container mt-5">
    <!-- Pet Details -->
    <div class="row">
        <div class="col-md-6">
            <img src="images/<?php echo htmlspecialchars($pet['image']); ?>" class="img-fluid rounded shadow" alt="<?php echo htmlspecialchars($pet['petname']); ?>">
        </div>
        <div class="col-md-6">
            <h2 class="pet-title"><?php echo htmlspecialchars($pet['petname']); ?></h2>
            <p><strong>Type:</strong> <?php echo htmlspecialchars($pet['type']); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($pet['age']); ?> months</p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($pet['location']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($pet['description']); ?></p>
            
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                <a href="edit.php?id=<?php echo $pet_id; ?>" class="btn btn-warning">Edit</a>
                <a href="delete.php?id=<?php echo $pet_id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this pet?');">Delete</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'includes\footer.inc'; ?>
</body>
</html>
