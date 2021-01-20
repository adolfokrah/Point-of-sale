
<?php $title = 'Manage groups'; ?>
<?php 
    include_once 'includes/includes.php';
    $session = new Session();
    $functions = new Functions();
    if($session->isUserLoggedIn() == false){
        $functions->redirect('index.php');
    }
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
            <a class="section" href="groups.php">groups</a>
            <div class="divider"> / </div>
            <div class="active section">Manage groups</div>
        </div>
        <div></div>
        <?php
              $path = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
               $permissions = $functions->get_user_permission($path);

               if(in_array('create',$permissions)):
        ?>
        <a href="add_group.php">
            <div class="ui  small primary labeled icon button">
            <i class="add icon"></i> Add group
            </div>
        </a>
        <?php endif ?>
        <?php
            if(isset($_SESSION['success']) && !empty($_SESSION['success'])){
                echo $functions->message($_SESSION['success'],'green');
                unset($_SESSION['success']);
            }
            if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
                echo $functions->message($_SESSION['error'],'red');
                unset($_SESSION['error']);
            }
            $functions->delete_group();
            ?>
        <div class="ui card">
        
        <div class="content">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Group Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
         <?php
            $sql = "select * from groups where group_name != 'admin'";

            $results = $functions->fetch_rows($functions->query($sql));
            foreach ($results as $result) {

                $delete_btn = ' <button data-tooltip="Delete user" data-position="top right" class="ui icon button" onclick="delete_group(\''.$result['gr_id'].'\')"><i class="trash icon"></i></button>';

                $actions = '';
                if(in_array('update',$permissions)){
                    $actions .= '<a  href="edit_group.php?id='.($result['gr_id']).'"><button data-tooltip="Edit user" data-position="top right" class="ui icon button"><i class="edit icon"></i></button></a>';
                }

                if(in_array('delete',$permissions)){
                    $actions .= $delete_btn;
                }

                echo '<tr>
                <td>'.$result['group_name'].'</td>
                <td>
                '.$actions.'
                </td>
            </tr>';
            }
         ?>
            
        </tbody>
    </table>
        </div>
        </div>
    </div>
</div>



<?php include_once 'includes/layout/footer.php'?>