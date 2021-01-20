
<?php $title = 'Manage users'; ?>
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
            <a class="section" href="users.php">Users</a>
            <div class="divider"> / </div>
            <div class="active section">Manage users</div>
        </div>
        <div></div>
        
        <?php
              $path = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
               $permissions = $functions->get_user_permission($path);

               if(in_array('create',$permissions)):
        ?>
        <a href="add_users.php">
            <div class="ui  small primary labeled icon button">
            <i class="add icon"></i> Add user
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
            $functions->delete_user();
            ?>
        <div class="ui card">
        
        <div class="content">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Group / User Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
         <?php
            $sql = "select * from users";

            $results = $functions->fetch_rows($functions->query($sql));
            foreach ($results as $result) {

                $delete_btn = ' <button data-tooltip="Delete user" data-position="top right" class="ui icon button" onclick="delete_user(\''.$result['user_id'].'\')"><i class="trash icon"></i></button>';

                if($result['user_type'] == 'admin'){
                    $delete_btn = '';
                }
                $actions = '';
                if(in_array('update',$permissions)){
                    $actions .= '<a  href="edit_user.php?id='.base64_encode($result['user_id']).'"><button data-tooltip="Edit user" data-position="top right" class="ui icon button"><i class="edit icon"></i></button></a>';
                }

                if(in_array('delete',$permissions)){
                    $actions .= $delete_btn;
                }
               

                echo '<tr>
                <td>'.$result['user_name'].'</td>
                <td>'.$result['first_name'].'</td>
                <td>'.$result['last_name'].'</td>
                <td>'.$result['phone'].'</td>
                <td>'.$result['user_type'].'</td>
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