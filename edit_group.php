
<?php $title = 'Edit Group'; ?>
<?php 
    include_once 'includes/includes.php';
    $session = new Session();
    $functions = new Functions();
    if($session->isUserLoggedIn() == false){
        $functions->redirect('index.php');
    }
    $functions->edit_add_permission_access('update');
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
        <div class="active section">Edit Group</div>
    </div>

    <?php 
         $id = '';
         if(isset($_GET['id']) && !empty($_GET['id'])){
             $id = $_GET['id'];
         }

         if(!empty($id)){
            $id = $functions->real_escape($id);
            $sql = "select * from groups where gr_id = '$id'";
            $results = $functions->fetch_rows($functions->query($sql));
            if(sizeof($results) < 1){
                $functions->redirect('groups.php');
                die();
            }
            $results = $results[0];
       }else{
           $functions->redirect('groups.php');
       }

       if($results['group_name'] == 'admin'){
        $functions->redirect('groups.php');
       }

       $permisson_modules = json_decode($results['permissions']);
    ?>
    <div class="html ui top attached segment">
            <div class="ui top attached label">Edit Group</div>
            <div class="content">
               <form action="?" method="post">
                 <div class="form-group">
                        <label>Group Name</label>
                        <div class="ui input">
                            <input type="text" value="<?php echo $results['group_name'] ?>" name="group_name" id="group_name"  placeholder="Group Name" required>
                        </div>
                    </div>

                    <div class="form-group">
                      <label>Permissions</label>
                    </div>

                    <table  id="example2" class="table table-striped " style="width:100%">
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
                        <?php if($menu->label != "Logout"): ?>
                            <?php 
                                $permissions = array();
                                if($menu->label == "Manage stock"){
                                    $menu->label = "Stock";
                                }
                                foreach ($permisson_modules as $permisson_module) {
                                    if($menu->label == $permisson_module->module_name){
                                        $permissions = $permisson_module->permissions;
                                    }
                                }
                                
                               

                            ?>
                            <tr id="<?php echo $menu->label ?>" class="modules">
                                <td><?php echo $menu->label ?></td>
                                <td>
                                    <?php if(in_array("create",$menu->permissions)):?>
                                        <?php if(in_array('create',$permissions)): ?>
                                            <input onclick="toggle_permission('<?php echo $menu->label; ?>','create')" id="<?php echo $menu->label.'_create'; ?>"  type="checkbox" checked name="example">
                                        <?php else: ?>
                                            <input onclick="toggle_permission('<?php echo $menu->label; ?>','create')" id="<?php echo $menu->label.'_create'; ?>"  type="checkbox" name="example">
                                        <?php endif ?>
                                    <?php else:?>
                                       -
                                    <?php endif?>
                                </td>
                                <td>
                                     <?php if(in_array("view",$menu->permissions)):?>
                                        <?php if(in_array('view',$permissions)): ?>
                                            <input onclick="toggle_permission('<?php echo $menu->label; ?>','view')" id="<?php echo $menu->label.'_view'; ?>"  type="checkbox" checked name="example">
                                        <?php else: ?>
                                            <input onclick="toggle_permission('<?php echo $menu->label; ?>','view')" id="<?php echo $menu->label.'_view'; ?>"  type="checkbox" name="example">
                                        <?php endif ?>
                                    <?php else:?>
                                       -
                                    <?php endif?>
                                </td>
                                <td>
                                     <?php if(in_array("update",$menu->permissions)):?>
                                         <?php if(in_array('update',$permissions)): ?>
                                            <input onclick="toggle_permission('<?php echo $menu->label; ?>','update')" id="<?php echo $menu->label.'_update'; ?>"  type="checkbox" checked name="example">
                                        <?php else: ?>
                                            <input onclick="toggle_permission('<?php echo $menu->label; ?>','update')" id="<?php echo $menu->label.'_update'; ?>"  type="checkbox" name="example">
                                        <?php endif ?>
                                    <?php else:?>
                                       -
                                    <?php endif?>
                                </td>
                                <td>
                                     <?php if(in_array("delete",$menu->permissions)):?>
                                        <?php if(in_array('delete',$permissions)): ?>
                                            <input onclick="toggle_permission('<?php echo $menu->label; ?>','delete')" id="<?php echo $menu->label.'_delete'; ?>"  type="checkbox" checked name="example">
                                        <?php else: ?>
                                            <input onclick="toggle_permission('<?php echo $menu->label; ?>','delete')" id="<?php echo $menu->label.'_delete'; ?>"  type="checkbox" name="example">
                                        <?php endif ?>
                                    <?php else:?>
                                       -
                                    <?php endif?>
                                </td>
                            </tr>
                        <?php endif ?>
                    <?php endforeach?>
                    </tbody>
                    </table>

                    <input type="hidden" value="<?php echo $id ?>" id="group_id" ?>

                    <button name="submit" type="button" onclick="function_add_group('update')" class="ui  small primary labeled icon button">
                        <i class="add icon"></i> Save Changes
                    </button>
                </form>
            </div>
            </div>
    </div>
    </div>
</div>

<?php include_once 'includes/layout/footer.php'?>