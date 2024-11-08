<?php
session_start();
require 'db_connect.inc';

$search_keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$type_filter = isset($_GET['type']) ? trim($_GET['type']) : '';

$query = "SELECT petid, petname, type, age, location, image FROM pets WHERE (petname LIKE ? OR description LIKE ?)";
$search_param = '%' . $search_keyword . '%';

if ($type_filter) {
    $query .= " AND type = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $search_param, $search_param, $type_filter);
} else {
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $search_param, $search_param);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search - Pets Victoria</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ysabeau+SC&family=Poetsen+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <?php include 'header.inc'; ?>
</head>
<body>
<?php include 'nav.inc'; ?>

<div class="container mt-5">
    <!-- Search Header -->
    <div class="text-center mb-4">
        <h2 class="page-title">Search Pets</h2>
        <p class="page-description">Find your perfect pet by searching with keywords or filter by pet type.</p>
    </div>

    <!-- Search Form -->
    <div class="text-center mb-4">
        <form method="GET" action="">
            <div class="input-group mb-3">
                <input type="text" name="keyword" class="form-control" placeholder="Search by name or description" value="<?php echo htmlspecialchars($search_keyword); ?>">
                <select name="type" class="form-select gallery-filter">
                    <option value="">All types</option>
                    <option value="Dog" <?php if ($type_filter === 'Dog') echo 'selected'; ?>>Dog</option>
                    <option value="Cat" <?php if ($type_filter === 'Cat') echo 'selected'; ?>>Cat</option>
                </select>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>

    <!-- Search Results -->
    <div class="row gallery-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card pet-card">
                        <img src="images/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['petname']); ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['petname']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['type']); ?></p>
                            <a href="details.php?id=<?php echo $row['petid']; ?>" class="btn btn-primary">View Details</a>
                            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                                <a href="edit.php?id=<?php echo $row['petid']; ?>" class="btn btn-warning">Edit</a>
                                <a href="delete.php?id=<?php echo $row['petid']; ?>" class="btn btn-danger">Delete</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No pets found matching your search criteria.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.inc'; ?>
</body>
</html>
