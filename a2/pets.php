<?php 
include 'db_connect.inc'; 
include 'header.inc'; 
include 'nav.inc'; 
?>

<main>
    <h2 class="center-text">Discover Pets Victoria</h2>
    <p class="center-text">Explore the diverse range of pets available for adoption in Victoria. Our mission is to find loving homes for every pet...</p>

    <div class="content">
        <img src="images/pets.jpeg" alt="Pet Image" class="left-image">

        <table>
            <thead>
                <tr>
                    <th>Pet Name</th>
                    <th>Type</th>
                    <th>Age</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                <?php
               
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "petsvictoria";

                
                $conn = mysqli_connect($servername, $username, $password, $database);

                
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                
                $sql = "SELECT petid, petname, type, age, location FROM pets";
                $result = mysqli_query($conn, $sql);

               
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                  
                        echo "<td><a href='details.php?id=" . $row['petid'] . "'>" . htmlspecialchars($row['petname']) . "</a></td>";
                        echo "<td>" . htmlspecialchars($row['type']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['age']) . " years</td>";
                        echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No pets found.</td></tr>";
                }

                
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</main>

<?php include 'footer.inc'; ?>
