<?php
session_start();
require 'db_connect.inc';

//  username is set in the URL
if (isset($_GET['username']) && !empty($_GET['username'])) {
    $username = $_GET['username'];

    // Prepare execute query to fetch pets-user
    $stmt = $conn->prepare("SELECT petname, type, age, location, description, image FROM pets WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // checking for pets
    if ($result->num_rows === 0) {
        $noRecords = true;
    }
} else {
    // Redirect to index if username there
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($username); ?>'s Pets - Pets Victoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'nav.inc'; ?>

<div class="container mt-5">
    <h2 class="page-title"><?php echo htmlspecialchars($username); ?>'s Collection</h2>

    <?php if (isset($noRecords) && $noRecords): ?>
        <p class="text-center">This user has not uploaded any pets yet.</p>
    <?php else: ?>
        <div class="row gallery-grid">
            <?php while ($pet = $result->fetch_assoc()): ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card pet-card">
                        <img src="images/<?php echo htmlspecialchars($pet['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($pet['petname']); ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($pet['petname']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($pet['type']); ?></p>
                            <p class="card-text"><small class="text-muted"><?php echo htmlspecialchars($pet['age']); ?> months old</small></p>
                            <p class="card-text"><small class="text-muted"><?php echo htmlspecialchars($pet['location']); ?></small></p>
                            <a href="details.php?id=<?php echo urlencode($pet['petid']); ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'footer.inc'; ?>
</body>
</html>
