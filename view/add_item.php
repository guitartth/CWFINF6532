<?php include('header.php');?>



<h2>Add Task:</h2>
<label>Category:</label>
<select name="category_id" required>
    <option value="">Please select</option>
    <?php foreach ($categories as $category) : ?>
        <option value="<?= $category['categoryID']; ?>">
            <?= $category['categoryName']; ?>
        </option>
    <?php endforeach; ?>
</select>


<section id="addItem">
    <br><br><br><br>
    <form id="submitTask" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <input type="text" name="newTask" id="newTask" placeholder="Task" required><br>
        <input type="text" name="newDesc" id="newDesc" placeholder="Description" required><br><br>
        <button type="submit" id="addButton"> ADD </button>
    </form>
</section>


<?php include('footer.php');?>