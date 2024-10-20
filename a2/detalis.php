<?php 

include 'db_connect.inc'; 
include 'header.inc'; 
include 'nav.inc'; 


$petid = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($petid > 0) {
   
    $conn = mysqli_connect("localhost", "root", "", "petsvictoria");

  
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM pets WHERE petid = $petid";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $pet = mysqli_fetch_assoc($result);
    } else {
        echo "<h2>Pet not found</h2>";
        exit();
    }

    mysqli_close($conn);
} else {
    echo "<h2>Invalid Pet ID</h2>";
    exit();
}
?>

<main>
    <h2 class="center-text"><?php echo htmlspecialchars($pet['petname']); ?></h2>
    <img src="<?php echo htmlspecialchars($pet['image']); ?>" alt="<?php echo htmlspecialchars($pet['caption']); ?>" class="pet-image">
    <p><strong>Type:</strong> <?php echo htmlspecialchars($pet['type']); ?></p>
    <p><strong>Age:</strong> <?php echo htmlspecialchars($pet['age']); ?> years</p>
    <p><strong>Location:</strong> <?php echo htmlspecialchars($pet['location']); ?></p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($pet['description']); ?></p>
</main>

<?php include 'footer.inc'; ?>
