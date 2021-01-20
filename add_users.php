
<?php $title = 'Add user'; ?>
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
            <a class="section">Profile</a>
            <div class="divider"> / </div>
            <div class="active section">Settings</div>
        </div>
        <?php
            if(isset($_SESSION['success']) && !empty($_SESSION['success'])){
                echo $functions->message($_SESSION['success'],'green');
                unset($_SESSION['success']);
            }
            if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
                echo $functions->message($_SESSION['error'],'red');
                unset($_SESSION['error']);
            }
            $functions->add_user();
        ?>
        <div class="html ui top attached segment">
            <div class="ui top attached label">Profile Details</div>
            <div class="content">
               <form action="?" method="post">
               <div class="form-group">
                    <label>First Name</label>
                    <div class="ui input">
                        <input type="text" name="first_name"  placeholder="First Name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Last Name</label>
                    <div class="ui input">
                        <input type="text" name="last_name"  placeholder="Last Name" required>
                    </div>
                </div>

                <div class="ui yellow message">
                     User name can't be changed once added
                </div>

                <div class="form-group">
                    <label>User Name</label>
                    <div class="ui input">
                         <input type="text" name="user_name"   placeholder="User Name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Gender</label>
                    <div>
                    <select class="ui dropdown"  name="gender" style="width:100%" required >
                        <option value="">--Select---</option>
                        <option value="Male" >Male</option>
                        <option value="Female" >Female</option>
                    </select>
                    </div>
                </div>

            
                <div class="form-group">
                    <label>Group</label>
                    <div class="ui input">
                    <select class="js-example-basic-single" name="user_type" style="width:100%" onchange="get_value(event)">
                        <?php 
                            $sql = "select * from groups";
                            $results = $functions->fetch_rows($functions->query($sql));
                            foreach ($results as $result) {
                                $selected = '';
                                if($result['group_name'] == $data['group_name']){
                                    $selected = 'selected';
                                }else{
                                    $selected  = '';
                                }
                                echo '<option value="'.$result['group_name'].'">'.$result['group_name'].'</option>';
                            }
                        ?>
                    </select>
                    </div>
                </div>
               
                <div class="form-group">
                    <label>Phone</label>
                    <div class="ui input">
                         <input type="text" name="phone"  placeholder="Phone" required>
                    </div>
                </div>                

                <div class="form-group">
                    <label>Password</label>
                    <div class="ui input">
                         <input type="text" name="password"  placeholder="Password" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <div class="ui input">
                         <input type="text" name="cpassword"  placeholder="Confirm Password" required>
                    </div>
                </div>


                <button name="submit" type="submit" class="ui  small primary labeled icon button">
                    <i class="save icon"></i> Add User
                </button>
               </form>

            </div>
        </div>

    </div>
</div>

<?php include_once 'includes/layout/footer.php'?>