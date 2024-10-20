<?php 

include 'db_connect.inc'; 
include 'header.inc'; 
include 'nav.inc'; 
?>

<main>
    <h2 class="center-text">Pet Gallery</h2>
    <p class="center-text">Explore our lovely pets waiting for a new home!</p>

    <div class="gallery">
        <?php
       
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "petsvictoria";

        
        $conn = mysqli_connect($servername, $username, $password, $database);

    
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }


        $sql = "SELECT petid, petname, image FROM pets";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
             
                echo "<div class='gallery-item'>";
                echo "<a href='details.php?id=" . $row['petid'] . "'>";
                echo "<img src='cat4.jpeg" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['petname']) . "' class='pet-image'>";
                echo "</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No pets found in the gallery.</p>";
        }

      
        mysqli_close($conn);
        ?>
    </div>
</main>

<?php include 'footer.inc'; ?>
