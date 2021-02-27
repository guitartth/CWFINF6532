<?php
// INF653 VB Week 5 Project
// Author: Craig Freeburg
// Date: 3/1/21

function get_tasks_by_category($category_id){
    global $db;
    $query = 'SELECT * FROM todoitems
              WHERE todoitems.categoryId = :category_id
              ORDER BY ItemNum';
    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id);
    $statement->execute();
    $tasks = $statement->fetchAll();
    $statement->closeCursor();
    return $tasks;          
}

function delete_task($task_id)
{
    global $db;
    $query = 'DELETE FROM todoitems
              WHERE ItemNum = :task_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':task_id', $task_id);
    $statement->execute();
    $statement->closeCursor();
}

function add_task($category_id, $task_title, $task_desc)
{
    global $db;
    $query = 'INSERT INTO todoitems
                (categoryId, Title, Description)
              VALUES
                (:category_id, :task_title, :task_desc)';
    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id);
    $statement->bindValue(':task_title', $task_title);
    $statement->bindValue(':task_desc', $task_desc);
    $statement->execute();
    $statement->closeCursor();
    echo '<script>alert("Task successfully added.")</script>';
}
?>