<?php
// INF653 VB Week 5 Project
// Author: Craig Freeburg
// Date: 3/1/21

require('model/database.php');
require('model/category_db.php');
require('model/item_db.php');


$item_id = filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT);
if(!$item_id)
{
    $item_id = filter_input(INPUT_GET, 'item_id', FILTER_VALIDATE_INT);
}

$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
if(!$title)
{
    $title = filter_input(INPUT_GET, 'title', FILTER_SANITIZE_STRING);
}

$desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
if(!$desc)
{
    $desc = filter_input(INPUT_GET, 'desc', FILTER_SANITIZE_STRING);
}

$category_name = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_STRING);
if(!$category_name)
{
    $category_name = filter_input(INPUT_GET, 'category_name', FILTER_SANITIZE_STRING);
}

$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
if(!$category_id)
{
    $category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
}

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if(!$action)
{
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
    if(!$action)
    {
        $action = 'list_items';
    }
}

//Gray filters $item_id, $title, $desc, $category_name, $category_id, $action


switch ($action)
{
    case "list_tasks":

        break;
    default:
        $category_name = get_category_name($category_id);
        $categories = get_categories();
        $tasks = get_tasks_by_category($category_id);
        include('view/item_list.php');

}

if($action == 'list_tasks')
{
    $category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
    if($category_id == NULL || $category_id == FALSE)
    {
        $category_id = 1;
    }
    $category_name = get_category_name($category_id);
    $categories = get_categories();
    $tasks = get_tasks_by_category($category_id);
    include('view/item_list.php');
}
else if($action == 'delete_task')
{
    $task_id = filter_input(INPUT_POST, 'task_id', FILTER_VALIDATE_INT);
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
    if($category_id == NULL || $category_id == FALSE || $task_id == NULL || $task_id == FALSE)
    {
        $error = "missing or incorrect task id or category id.";
        include('view/error.php');
    }
    else
    {
        delete_task($task_id);
        header("Location: .?category_id=$category_id");
    }
}
else if($action == "delete_category")
{
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
    if($category_id == NULL || $category_id == FALSE)
    {
        $error = "no existing category selected.";
        include('view/error.php');
    }
    else
    {
        delete_category($category_id);
        header("Location: .?category_id=$category_id");
    }
}
//not positive this is needed. I believe it depends on if adding form is on the same page or not
else if($action == "show_add_form")
{
    $categories = get_categories();
    //this file doesn't exist yet - either create file or direct the include to the correct file
    include('view/add_task.php');
}
else if($action == "add_task")
{
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
    $title = filter_input(INPUT_POST, 'title');
    $desc = filter_input(INPUT_POST, 'desc');
    if($category_id == NULL || $category_id == FALSE || $title == NULL || $title == FALSE || $desc == NULL || $desc == FALSE)
    {
        $error = "Invalid task data. Check all fields and try again.";
        include('view/error.php');
    }
    else
    {
        add_task($category_id, $name, $desc);
        header("Location: .?category_id=$category_id");
    }
}
else if ($action == "add_category")
{
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
    $name = filter_input(INPUT_POST, 'name');
    if($category_id == NULL || $category_id == FALSE || $name == NULL || $name == FALSE)
    {
        $error = "Invalid category data. Check all fields and try again.";
        include('view/error.php');
    }
    else
    {
        add_category($category_id);
        header("Location: .?category_id=$category_id");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Craig's To Do List</title>
    <link rel="stylesheet" href="view/css/main.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
</head>


<!-- the body section -->

<body>
    <header>
        <h1>To Do List</h1>
    </header>
    <main>
            <?php

            if ($newTask && $newDesc) {
                $query = "INSERT INTO todoitems
                            (Title, Description)
                          VALUES 
                            (:newTask, :newDesc)";
                $statement = $db->prepare($query);
                $statement->bindValue(':newTask', $newTask);
                $statement->bindValue(':newDesc', $newDesc);
                $statement->execute();
                $statement->closeCursor();
                header("location:index.php");
            }

            $query = 'SELECT * FROM todoitems';
            $statement = $db->prepare($query);
            $statement->execute();
            $results = $statement->fetchAll();
            $statement->closeCursor();

            
            ?>
        <!-- results section -->
        <section>
            <h2> Do this: </h2>
            
            <?php foreach ($results as $task) : 
                ?>
                <tr>
                    <div id = "cssTask">
                    <td><?php echo $task['Title'] . " - "; ?></td>
                    </div>
                    <div id = "cssDesc">
                    <td><?php echo $task['Description']; ?></td>
                    </div>
                    
                </tr>
                <form class="delete" action="delete.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $task['ItemNum']?>">
                    <button type="deleteButton" id="deleteButton">Delete
                    </button><br><br>
                </form>
            <?php endforeach; ?>
            <?php if (!$results) {
                echo '<p id="noResult"> Put your feet up! </p>';
                }
                ?>
        </section>
        <!-- add items section -->
        <section id="addItem">
            <br><br><br><br>
            <h2>Add Task:</h2>
            <form id="submitTask" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <input type="text" name="newTask" id="newTask" placeholder="Task" required><br>
                <input type="text" name="newDesc" id="newDesc" placeholder="Description" required><br><br>
                <button type="submit" id="addButton"> ADD </button>
            </form>
        </section>
        
    </main>
</body>

</html>