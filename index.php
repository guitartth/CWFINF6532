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
        $tasks = get_tasks_by_category($category_id);
        include('view/item_list.php');
        break;

    case "add_task":
        if ($title && $desc && $category_id) {
            add_task($category_id, $title, $desc);
            header("Location: .?action=list_tasks&category_id=$category_id");
        } else {
            $error = "Invalid task data. Check all fields and try again.";
            include('view/error.php');
            exit();
        }
        break;

    case "delete_task":
        if($task_id)
        {
            try 
            {
                delete_task($task_id);
            }
            catch (PDOException $e)
            {
                $error = "Cannot delete category with tasks existing.";
                include('view/error.php');
                exit();
            }
            header("Location: .?action=");
        }
        
        header("Location: .?action=");
        break;

    case "add_category":
        if($category_name)
        {
            add_category($category_name);
            header("Location: .?action=");
        }
      
    default:
        $category_name = get_category_name($category_id);
        $categories = get_categories();
        $tasks = get_tasks_by_category($category_id);
        include('view/item_list.php');

}





?>

