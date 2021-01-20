
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
             Database backup is not availabel in demo version
       </div>
        <br/>
        <div class="ui small basic icon buttons">
            <a href="company.php"><button class="ui button">Company Details</button></a>
            <button class="ui button active">Database</button>
        </div>
        <div class="html ui top attached segment">
            <div class="ui top attached label">Manage Database</div>
            <div class="content">
               <form action="?" method="post">
                     <!-- Click <a href="includes/export_databse.php">here</a> to download and save the system records including your sales, orders, users and products to your computer. -->
                     <div class="ui yellow message">
                     Keep the downloaded database safe hence it will be used to restore the system once all data is lost for some reason.
                    </div>
               </form>

            </div>
        </div>

    </div>
</div>

<?php include_once 'includes/layout/footer.php'?>