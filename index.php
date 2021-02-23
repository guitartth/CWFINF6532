<?php
// INF653 VB Week 4 Project
// Author: Craig Freeburg
// Date: 2/15/21

require('database.php');

$newTask = filter_input(INPUT_POST, "newTask", FILTER_SANITIZE_STRING);
$newDesc = filter_input(INPUT_POST, "newDesc", FILTER_SANITIZE_STRING);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Craig's To Do List</title>
    <link rel="stylesheet" href="main.css">
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