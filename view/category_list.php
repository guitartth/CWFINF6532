<?php include('header.php'); ?>

<?php if($categories) { ?>
    <section id="list" class="list"?
    <header class="list__row list__header">
        <h3> Category List </h3>
    </header>

    <?php foreach ($categories as $category) : ?>
    <div class="list__row">
        <div class="list__item">
            <p class="bold"><?= $category['categoryName'] ?></p>
        </div>
        <div class="list__removeItem">
            <form action="." method="post">
                <input type="hidden" name="action" value="delete_category">
                <input type="hidden" name="category_id" value="<?= $category['categoryID'] ?>">  
                <button class="remove-button">Delete</button>          
            </form>
        </div>
    </div>
    <?php endforeach ?>
    </section>
<? php } else { ?>

<?php } ?>

<section id="add" class="add">
    <h3>Add Category</h3>
    <form action="." method="post" id="add__form" class="add__form">
        <input type="hidden" name="action" value="add_category">
        <div class="add__inputs">
            <label>Name:</label>
            <input type="text" name="category_name" maxLength="50" placeholder="Name" autofocus required>
        </div>
        <div class="add__addItem">
            <button class="add-button bold">Add</button>
        </div>
    </form>
</section>


<p><a href=".">Back Home</a></p>
<?php include('footer.php');