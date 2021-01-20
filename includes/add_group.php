<?php 
    include_once 'connection.php';
    include_once 'sessions.php';
    include_once 'functions.php';
    
    $session = new Session();
    $functions = new Functions();
    
    $group_name = $functions->real_escape($_POST['group_name']);
    $permissions = $functions->real_escape($_POST['permission']);

    $sql = "select * from groups where group_name like '$group_name'";
    if($functions->fetch_num_rows($functions->query($sql)) > 0){
        echo 'error';
        die();
    }
    $sql = "insert INTO `groups` (`gr_id`, `group_name`, `permissions`) VALUES (NULL, '$group_name', '$permissions');";

    $functions->query($sql);

    $_SESSION['success'] = 'Group added successfully';

?>