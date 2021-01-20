
<?php
    include_once 'menu.php';

    //print_r(json_decode($side_bar_menu));
    $menus = json_decode($side_bar_menu);
    $path = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
?>
<div class="ui inverted vertical pointing menu side-bar">

  <?php 
    foreach ($menus as $menu) {
        $active = '';

        if($menu->menu_type == 'menu'){
            if($menu->path == $path){
                $active = 'active';
            }
            ?>
            <?php
               $permissions = $functions->get_user_permission(strtolower($menu->label));
               if($menu->label == 'Dashboard' || $menu->label == 'Logout'){
                  array_push($permissions,'view');
                }

               if(in_array('view',$permissions)):
            ?>
            <div class="item">
                <div class="menu">
                    <a class="item <?php echo $active?>" href="<?php echo $menu->path ?>"><?php echo $menu->label ?></a>
                </div>
            </div>
            <?php endif ?>
            <?php
        }else{
            ?>

            <?php
               $permissions = $functions->get_user_permission(strtolower($menu->label));
               if(in_array('view',$permissions)):
            ?>
            <div class="item">
                <div class="header"><?php echo $menu->label ?></div>
                <div class="menu">
                  <?php
                    foreach ($menu->drop as $drop_menu) {
                        if($drop_menu->path == $path){
                            $active = 'active';
                        }else{
                            $active = '';
                        }
                        ?>
                            <?php 
                                $module_permissions = $menu->permissions;
                                if(!in_array('create',$permissions) && strpos($drop_menu->label,'Add') > -1):
                            ?>
                            <?php else:?>
                            <a class="item <?php echo $active?>" href="<?php echo $drop_menu->path ?>"><?php echo $drop_menu->label?></a>
                            <?php endif?>
                        <?php
                    }
                  ?>
                </div>
            </div>
            <?php endif?>
            <?php
        }
        ?>
        <?php
    }
  ?>
</div>