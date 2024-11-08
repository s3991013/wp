<?php
session_start();
require 'db_connect.inc';

// fetch all pets from the database
$stmt = $conn->prepare("SELECT * FROM pets");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Pets Victoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'nav.inc'; ?>

<div class="container mt-5">
    <h2 class="text-center">Pets Victoria has a lot to offer!</h2>
    <p class="text-center">
        For almost two decades, Pets Victoria has helped in creating true social change by bringing pet adoption into the mainstream.
        Our work has helped make a difference to the Victorian rescue community and thousands of pets in need of rescue and rehabilitation.
    </p>

    <!-- Dropdown  -->
    <div class="text-center mb-4">
        <select class="form-select w-25 d-inline" id="petTypeFilter" aria-label="Select type...">
            <option selected>Select type...</option>
            <option value="Dog">Dog</option>
            <option value="Cat">Cat</option>
            
        </select>
    </div>

    <!-- Pet grid display -->
    <div class="row">
        <?php while ($pet = $result->fetch_assoc()): ?>
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card h-100 text-center">
                    <img src="images/<?php echo htmlspecialchars($pet['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($pet['petname']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($pet['petname']); ?></h5>
                        <p class="card-text"><strong>Type:</strong> <?php echo htmlspecialchars($pet['type']); ?></p>
                        <p class="card-text"><strong>Age:</strong> <?php echo htmlspecialchars($pet['age']); ?> months</p>

                        <!-- Buttons for Details, Edit, and Delete if user is logged in -->
                        <a href="details.php?id=<?php echo $pet['petid']; ?>" class="btn btn-info mb-2">Details</a>

                        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                            <a href="edit.php?id=<?php echo $pet['petid']; ?>" class="btn btn-warning mb-2">Edit</a>
                            <a href="delete.php?id=<?php echo $pet['petid']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this pet?');">Delete</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // JavaScript type
    document.getElementById('petTypeFilter').addEventListener('change', function() {
        const selectedType = this.value.toLowerCase();
        const petCards = document.querySelectorAll('.card');

        petCards.forEach(card => {
            const petType = card.querySelector('.card-text strong').nextSibling.nodeValue.trim().toLowerCase();
            if (selectedType === "select type..." || petType === selectedType) {
                card.parentElement.style.display = "block";
            } else {
                card.parentElement.style.display = "none";
            }
        });
    });
</script>
<?php include 'footer.inc'; ?>
</body>
</html>
