
<?php $title = 'Add Group'; ?>
<?php 
    include_once 'includes/includes.php';
    $session = new Session();
    $functions = new Functions();
    if($session->isUserLoggedIn() == false){
        $functions->redirect('index.php');
    }
    $functions->edit_add_permission_access('create');
?>
<style>
    .card{
        width:100% !important;
    }
</style>
</head>
<body>
<?php include 'includes/layout/topBar.php' ?>
<div class="row" style="margin-top:30px">
        <div class="col-md-12 col-lg-2">
        <?php include 'includes/layout/sidebar.php' ?>
    </div>
    <div class="col-md-10 main-content">
    <div class="ui breadcrumb">
        <a class="section">Home</a>
        <div class="divider"> / </div>
        <a class="section" href="groups.php">Groups</a>
        <div class="divider"> / </div>
        <div class="active section">Add Group</div>
    </div>
    <div class="html ui top attached segment">
            <div class="ui top attached label">Add Group</div>
            <div class="content">
               <form action="?" method="post">
                 <div class="form-group">
                        <label>Group Name</label>
                        <div class="ui input">
                            <input type="text" name="group_name" id="group_name"  placeholder="Group Name" required>
                        </div>
                    </div>

                    <div class="form-group">
                      <label>Permissions</label>
                    </div>

                    <table id="example2" class="table table-striped " style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Create</th>
                            <th>View</th>
                            <th>Update</th>
                            <th>Delete</th>
                    </thead>
                    <tbody>

                    <?php foreach ($menus as $menu):?>
                    <?php
                          if($menu->label == "Manage stock"){
                            $menu->label = "Stock";
                         }    
                    ?>
                        <?php if($menu->label != "Logout"): ?>
                            <tr id="<?php echo $menu->label ?>" class="modules">
                                <td><?php echo $menu->label ?></td>
                                <td>
                                    <?php if(in_array("create",$menu->permissions)):?>
                                        <input onclick="toggle_permission('<?php echo $menu->label; ?>','create')" id="<?php echo $menu->label.'_create'; ?>"  type="checkbox" name="example">
                                    <?php else:?>
                                       -
                                    <?php endif?>
                                </td>
                                <td>
                                     <?php if(in_array("view",$menu->permissions)):?>
                                        <input onclick="toggle_permission('<?php echo $menu->label; ?>','view')" id="<?php echo $menu->label.'_view'; ?>"  type="checkbox" name="example">
                                    <?php else:?>
                                       -
                                    <?php endif?>
                                </td>
                                <td>
                                     <?php if(in_array("update",$menu->permissions)):?>
                                        <input onclick="toggle_permission('<?php echo $menu->label; ?>','update')" id="<?php echo $menu->label.'_update'; ?>"  type="checkbox" name="example">
                                    <?php else:?>
                                       -
                                    <?php endif?>
                                </td>
                                <td>
                                     <?php if(in_array("delete",$menu->permissions)):?>
                                        <input onclick="toggle_permission('<?php echo $menu->label; ?>','delete')" id="<?php echo $menu->label.'_delete'; ?>"  type="checkbox" name="example">
                                    <?php else:?>
                                       -
                                    <?php endif?>
                                </td>
                            </tr>
                        <?php endif ?>
                    <?php endforeach?>
                    </tbody>
                    </table>

                    <button name="submit" type="button" onclick="function_add_group('insert')" class="ui  small primary labeled icon button">
                        <i class="add icon"></i> Save
                    </button>
                </form>
            </div>
            </div>
    </div>
    </div>
</div>

<?php include_once 'includes/layout/footer.php'?>