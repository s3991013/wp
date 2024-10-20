<?php include 'db_connect.inc'; ?>
<?php include 'header.inc'; ?>
<?php include 'nav.inc'; ?>

<main>
    <h2 class="center-text">Add a Pet</h2>
    <p class="center-text">You can add a new pet here</p>

    <form class="pet-form" action="submit_form.php" method="post" enctype="multipart/form-data">
        <label for="pet-name">Pet Name:</label>
        <input type="text" id="pet-name" name="pet-name" placeholder="Provide a name for the pet" required>
        
        <label for="pet-type">Type:</label>
        <select id="pet-type" name="pet-type" required>
            <option value="" disabled selected>Choose an option</option>
            <option value="dog">Dog</option>
            <option value="cat">Cat</option>
            <option value="rabbit">Rabbit</option>
            <option value="bird">Bird</option>
            <option value="guinea-pig">Guinea Pig</option>
            <option value="fish">Fish</option>
        </select>
        
        <label for="pet-description">Description:</label>
        <textarea id="pet-description" name="pet-description" rows="4" placeholder="Describe the pet briefly" required></textarea>
        
        <label for="pet-image">Select an Image:</label>
        <input type="file" id="pet-image" name="pet-image" accept="image/*" required>
        
        <label for="image-caption">Image Caption:</label>
        <input type="text" id="image-caption" name="image-caption" placeholder="Describe the image in one word" required>
        
        <label for="pet-age">Age (months):</label>
        <input type="number" id="pet-age" name="pet-age" placeholder="Age of the pet in months" min="0" required>
        
        <label for="pet-location">Location:</label>
        <input type="text" id="pet-location" name="pet-location" placeholder="Location of the pet" required>
        
        <div class="form-buttons">
            <button type="submit">Submit</button>
            <button type="reset">Clear</button>
        </div>
    </form>
</main>

<?php include 'footer.inc'; ?>
