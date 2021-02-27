<?php include('header.php'); ?>

<section id="task_list" class="task_list">
    <h3>Select Category:</h3>
    <form action="." method="get" id="list_category_select" class="list_category_select">
        <input type="hidden" name="action" value="list_tasks">
        <select name="task_id" required>
            <option value="0">View All</option>
            <?php foreach ($category as $category) : ?>
            <?php if ($task_id == $category['categoryID']) { ?>
                <option value="<?= $category['categoryID'] ?>" selected>
                    <?php } else { ?>
                <option value="<?= $category['categoryID'] ?>">
                    <?php } ?>
                    <?= $category['categoryName'] ?>
                </option>
                <?php endforeach; ?>
        </select>
        <button class="add-button bold">GO</button>
    </form>
    <h2> To Do List </h2>
    <?php if($task) { ?>
        <?php foreach ($tasks as $task) : ?>
        <div class="list_row">
            <div class="list_task">
                <p class="bold"><?= $task['Title'] ?></p>
                <p><?= $task['Description'] ?></p>
            </div>
            <div class="task_remove"> 
                <form action="." method="post">
                    <input type="hidden" name="action" value="delete_task">
                    <input type="hidden" name="ItemNum" value="<?=$task['ItemNum'] ?>">
                    <button class="delete_button">Completed</button>
                </form>
            </div>
        </div>
        </div>
        <?php endforeach; ?>
    <?php } else { ?>
    <br>
    <?php if ($category_id) { ?>
    <p>No tasks exist for this category yet.</p>
    <?php } else { ?>
    <p>No tasks exist yet.</p>
    <?php } ?>
    <br>
    <?php } ?>
</section>

<section id="add" class="add">
    <h2>Add Task</h2>
    <form action="." method="post" id="add_form" class="add_form">
        <input type="hidden" name="action" value="add_task">
        <div class="add_inputs">
        <label>Task:</label>
        <select name="category_id" required>
            <option value="">Please select</option>
            <?php foreach ($category as $category) : ?>
            <option value="<?= $category['categoryID']; ?>">
                <?= $category['categoryName']; ?>
            </option>
            <?php endforeach; ?>
        </select>
        <label>Description:</label>
        <input type="text" name="desc" maxlength="50" placeholder="Description" required>
        </div>
        <div class="add_addItem">
            <button class="add-button bold">Add</button>
        </div>
    </form>
</section>
<br>
<?php include('footer.php');