<?php
require 'db_connect.inc';

// Query to fetch all unique usernames from the `pets` table, representing contributors
$userQuery = "SELECT DISTINCT username FROM pets";
$userResult = $conn->query($userQuery);
?>

<footer class="text-center mt-5 py-3" style="background-color: #ff884d; color: white;">
    <div class="container">
        <p>&copy; <?php echo date("Y"); ?> Pets Victoria. All Rights Reserved.
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                <?php echo htmlspecialchars($_SESSION['username']); ?>
            <?php endif; ?>
        </p>

        
    </div>
</footer>
