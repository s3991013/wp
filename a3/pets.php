<?php
session_start();
require 'includes\db_connect.inc';

//  pets from the database
$query = "SELECT petid, petname, type, age, location FROM pets";
$pets = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pets - Pets Victoria</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ysabeau+SC&family=Poetsen+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <?php include 'includes\header.inc'; ?>
</head>
<body>
<?php include 'includes\nav.inc'; ?>

<div class="container mt-5">
    <!-- Page Header -->
    <div class="text-center mb-4">
        <h2 class="page-title">Discover Pets Victoria</h2>
        <p class="page-description">Pets Victoria is dedicated to connecting pets in need with caring families. Discover a wide range of pets looking for a loving home.</p>
    </div>

    <!-- Image and Table Section -->
    <div class="row">
        <div class="col-md-4">
            <img src="images/pets.jpeg" alt="Happy pets" class="img-fluid rounded shadow-sm">
        </div>
        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table table-striped fancy-table">
                    <thead>
                        <tr>
                            <th>Pet</th>
                            <th>Type</th>
                            <th>Age</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $pets->fetch_assoc()): ?>
                            <tr>
                                <td><a href="details.php?id=<?php echo $row['petid']; ?>" class="pet-link"><?php echo htmlspecialchars($row['petname']); ?></a></td>
                                <td><?php echo htmlspecialchars($row['type']); ?></td>
                                <td><?php echo $row['age']; ?> months</td>
                                <td><?php echo htmlspecialchars($row['location']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes\footer.inc'; ?>
</body>
</html>
