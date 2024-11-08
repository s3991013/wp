<?php
session_start();
require 'db_connect.inc';

// success message is set in the session
$successMessage = '';
if (isset($_SESSION['successMessage'])) {
    $successMessage = $_SESSION['successMessage'];
    unset($_SESSION['successMessage']); // Remove  after displaying
}

// e last four uploaded images 
$query = "SELECT image FROM pets ORDER BY petid DESC LIMIT 4";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home - Pets Victoria</title>
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

    <!-- Display Success Message -->
    <?php if ($successMessage): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $successMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Main Section  -->
    <div class="main-section container mt-4">
        <div class="row align-items-center">
            <!-- Carousel on the Left -->
            <div class="col-md-6">
                <div id="petCarousel" class="carousel slide custom-carousel" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php if ($result->num_rows > 0): ?>
                            <?php $isFirst = true; ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <div class="carousel-item <?php if ($isFirst) { echo 'active'; $isFirst = false; } ?>">
                                    <img src="images/<?php echo htmlspecialchars($row['image']); ?>" class="d-block w-100" alt="Pet Image">
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="carousel-item active">
                                <img src="images/default.jpg" class="d-block w-100" alt="Default Image">
                            </div>
                        <?php endif; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#petCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#petCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <!-- "Pets Victoria" on the Right -->
            <div class="col-md-6 text-center">
                <h1 class="hero-title">PETS VICTORIA</h1>
                <h2 class="hero-subtitle">WELCOME TO PET ADOPTION</h2>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="search-section mt-4 text-center">
        <form action="search.php" method="GET" class="input-group mb-3 search-bar">
            <input type="text" class="form-control" name="keyword" placeholder="I am looking for ...">
            <select class="form-select" name="type">
                <option selected>Select your pet type</option>
                <option value="Dog">Dog</option>
                <option value="Cat">Cat</option>
            </select>
            <button class="btn btn-primary search-button" type="submit">Search</button>
        </form>
    </div>

    <!-- Mission Section -->
    <div class="mission-section text-center mt-5">
        <h3 class="mission-title">Discover Pets Victoria</h3>
        <p class="mission-description">
            Pets Victoria is a dedicated pet adoption organization based in Victoria, Australia, focused on providing a safe and loving environment for pets in need. With a compassionate approach, Pets Victoria works tirelessly to rescue, rehabilitate, and rehome dogs, cats, and other animals. Their mission is to connect these deserving pets with caring individuals and families, creating lifelong bonds. The organization offers a range of services, including adoption counseling, pet education, and community support programs, all aimed at promoting responsible pet ownership and reducing the number of homeless animals.
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'footer.inc'; ?>
</body>
</html>
