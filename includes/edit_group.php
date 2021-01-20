<?php 
    include_once 'connection.php';
    include_once 'sessions.php';
    include_once 'functions.php';
    
    $session = new Session();
    $functions = new Functions();
    
    $group_name = $functions->real_escape($_POST['group_name']);
    $permissions = $functions->real_escape($_POST['permission']);
    $group_id = $functions->real_escape($_POST['group_id']);

    $sql = "select * from groups where group_name like '$group_name' and gr_id != '$group_id'";
    if($functions->fetch_num_rows($functions->query($sql)) > 0){
        echo 'error';
        die();
    }

    $sql = "select * from groups where gr_id = '$group_id'";
    $p_group_name = $functions->fetch_rows($functions->query($sql))[0]['group_name'];
    $sql = "update users set user_type = '$group_name' where user_type = '$p_group_name'";
    $functions->query($sql);


    $sql = "update groups set group_name = '$group_name', permissions='$permissions' where gr_id = '$group_id'";

    $functions->query($sql);


    

    $_SESSION['success'] = 'Group updated successfully';

?>