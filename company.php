
<?php $title = 'Conpany Profile'; ?>
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
            <a class="section">Company</a>
            <div class="divider"> / </div>
            <div class="active section">Company Details</div>
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
            $functions->update_company_details();
            $sql = "SELECT * FROM `company_details`";
            $results = $functions->fetch_rows($functions->query($sql));
            $data = $results[0];
        ?>
        <div class="ui yellow message">
              Updating company details is not available in demo version
       </div>
        <br/>
        <div class="ui small basic icon buttons">
            <button class="ui button active">Company Details</button>
            <a href="database.php"> <button class="ui button">Database</button></a>
        </div>
        <div class="html ui top attached segment">
            <div class="ui top attached label">Company Details</div>
            <div class="content">
               <form action="?" method="post">
               <div class="form-group">
                    <label>Company Name</label>
                    <div class="ui input">
                        <input type="text" name="company_name" value="<?php echo $data['company_name']?>" placeholder="Company Name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>VAT Charges %</label>
                    <div class="ui input">
                        <input type="text" name="vat" value="<?php echo $data['vat_charges']?>" placeholder="VAT" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <div class="ui input">
                         <input type="text" name="address" value="<?php echo $data['address']?>" placeholder="Address" required>
                        
                    </div>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <div class="ui input">
                        <input type="text" value="<?php echo $data['phone']?>" name="phone" placeholder="Phone Number" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Message</label>
                    <div class="ui input">
                        <textarea class="form-control" name="message"><?php echo $data['message']?></textarea>
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