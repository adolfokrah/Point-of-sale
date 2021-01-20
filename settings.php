
<?php $title = 'Settings'; ?>
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
            $functions->update_user_details('settings.php');
            $sql = "select * FROM `users` where user_id = '".$_SESSION['user_id']."'";

            $results = $functions->fetch_rows($functions->query($sql));
            $data = $results[0];
        ?>
        <div class="html ui top attached segment">
            <div class="ui top attached label">Profile Details</div>
            <div class="content">
               <form action="?" method="post">
               <div class="form-group">
                    <label>First Name</label>
                    <div class="ui input">
                        <input type="text" name="first_name" value="<?php echo $data['first_name']?>" placeholder="First Name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Last Name</label>
                    <div class="ui input">
                        <input type="text" name="last_name" value="<?php echo $data['last_name']?>" placeholder="Last Name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>User Name</label>
                    <div class="ui input">
                         <input type="text" readonly  style="background-color:#F1F1F1"  value="<?php echo $data['user_name']?>" placeholder="User Name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Gender</label>
                    <div>
                    <select class="ui dropdown"  name="gender" style="width:100%" required >
                        <option value="">--Select---</option>
                        <option value="Male" <?php echo (strtoupper($data['gender'])) == 'MALE' ?  "selected" : "";?>>Male</option>
                        <option value="Female" <?php echo (strtoupper($data['gender'])) == 'FEMALE' ?  "selected" : "";?>>Female</option>
                    </select>
                    </div>
                </div>

                <input type="hidden" value="<?php echo $_SESSION['user_data']['user_type']?>" name="user_type"/> 
                <div class="form-group">
                    <label>Phone</label>
                    <div class="ui input">
                         <input type="text" name="phone" value="<?php echo $data['phone']?>" placeholder="Phone" required>
                    </div>
                </div>
                

                <input type="hidden" name="user_id" value="<?php echo $data['user_id'] ?>"/>

                <div class="ui yellow message">
                     Account update is not available in demo version
                </div>

                <div class="form-group">
                    <label>Old Password</label>
                    <div class="ui input">
                         <input type="hidden" readonly name="old_password"  placeholder="Old Password" >
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="ui input">
                         <input type="hidden" readonly name="password"  placeholder="Password" >
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <div class="ui input">
                         <input type="hidden" readonly name="cpassword"  placeholder="Confirm Password" >
                    </div>
                </div>


                <button disabled name="submit" type="submit" class="ui  small primary labeled icon button">
                    <i class="save icon"></i> Save Changes
                </button>
               </form>

            </div>
        </div>

    </div>
</div>

<?php include_once 'includes/layout/footer.php'?>