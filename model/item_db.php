<?php
// INF653 VB Week 5 Project
// Author: Craig Freeburg
// Date: 3/1/21

function get_tasks_by_category($category_id){
    global $db;
    if ($category_id)
    {
        
        $query = 'SELECT I.ItemNum, I.Title, I.Description, C.categoryName FROM todoitems I LEFT JOIN
        categories C ON I.categoryID = C.categoryID WHERE I.categoryID = :category_id ORDER BY
        I.ItemNum';
    }
    else
    {
        
        $query = 'SELECT I.ItemNum, I.Title, I.Description, C.categoryName FROM todoitems I LEFT JOIN
        categories C ON I.categoryID = C.categoryID ORDER BY C.categoryName';
    }
    $statement = $db->prepare($query);
    if($category_id)
    {
        $statement->bindValue(':category_id', $category_id);
    }
    $statement->execute();
    $items = $statement->fetchAll();
    $statement->closeCursor();
    return $items;              
}

function delete_task($item_id)
{
    
    global $db;
    $query = 'DELETE FROM todoitems
              WHERE ItemNum = :item_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':item_id', $item_id);
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
}
?>