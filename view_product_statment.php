
<?php $title = 'Manage products'; ?>
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
            <a class="section" href="products.php">Products</a>
            <div class="divider"> / </div>
            <div class="active section">Product Statement</div>
        </div>
        <div></div>
        
        <div class="ui card">
        
        <div class="content">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Action</th>
                <th>By</th>
                <th>Date / Time</th>
                
            </tr>
        </thead>
        <tbody>
         <?php
           if(isset($_GET['id']) && !empty($_GET['id'])){
            $id = base64_decode($_GET['id']);
            $sql = "select * from product_statement left join products on product_statement.p_ID = products.p_ID left join users on product_statement.user_id = users.user_id  where product_statement.p_ID = '$id' order by product_statement.ps_ID desc";
            $results = $functions->fetch_rows($functions->query($sql));
            foreach ($results as $result) {
               

                echo '<tr>
                <td>'.$result['p_NAME'].'</td>
                <td>'.$result['ps_action'].'</td>
                <td>'.$result['user_name'].'</td>
                <td>'.gmdate('d M Y, h:i A',strtotime($result['date_time'])).'</td>
            </tr>';
            }
           }
         ?>
            
        </tbody>
    </table>
        </div>
        </div>
    </div>
</div>



<?php include_once 'includes/layout/footer.php'?>